<?php

namespace App\Controllers;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use App\Validators\Features\CreateValidator;
use App\Validators\Features\UpdateValidator;
use App\Models\Features as Feature;

class FeaturesController extends ControllerBase
{
    public function publicAction()
    {
        $lang_id = $this->view->app_lang_id;

        $features = Feature::find([
            'columns' => [
                'title',
                'content',
                'icon',
                'image'
            ],
            'conditions' => 'feature_id is not null and lang_id = :lang_id:',
            'bind'       => [
                'lang_id' => $lang_id,
            ],
            'order' => 'feature_id asc'
        ]);

        $this->view->features = $features;
        return $this->view->render('features', 'public');
    }

    public function indexAction()
    {
        $lang_id = $this->view->app_lang_id;

        $current_page = $this->request->getPost('actual');
        $order_by = $this->request->getPost('orden');
        $limit = $this->request->getPost('limite');
        $search = $this->request->getPost('busqueda');

        $builder = $this->modelsManager->createBuilder()
            ->columns(
                'feature_id,
                title,
                substring(content, 1, 30) as content,
                created_at,
                updated_at'
            )
            ->from(Feature::class)
            ->where('lang_id = :lang_id:', [
                'lang_id' => $lang_id,
            ]);

        if ($order_by == 'asc') {
            $builder->orderBy('feature_id asc');
        } else {
            $builder->orderBy('feature_id desc');
        }

        if (!$limit) {
            $limit = 10;
        }

        if ($search) {
            $builder->where(
                'title like :search: or
                content like :search:',
                ['search' => '%' . $search . '%']
            );
        }

        $paginator = new PaginatorQueryBuilder([
            'builder' => $builder,
            'limit' => $limit,
            'page'  => $current_page
        ]);

        $this->view->actual = $current_page;
        $this->view->orden = $order_by;
        $this->view->limite = $limit;
        $this->view->busqueda = $search;
        $this->view->features = $paginator->getPaginate();
        return $this->view->render('features', 'index');
    }

    public function createAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken() == false) {
                $this->flash->error($this->translate('invalid_token'));
                return $this->response->redirect($this->request->getHTTPReferer());
            }

            $validation = new CreateValidator();
            $errors = $validation->validate(array_merge($_POST, $_FILES));

            if (count($errors)) {
                foreach ($errors as $error) {
                    $this->flash->error($error->getMessage());
                }

                $columns = [];
                foreach($this->request->getPost() as $field => $input) {
                    $columns[$field] = $input;
                }

                $old_input = (object) $columns;
                $this->view->old = $old_input;
                return $this->view->render('features', 'create');
            }

            $public_path = $this->url->getBasePath();
            $uploads_folder = 'uploads/images/features/';
            $path = $public_path . $uploads_folder;

            $files = $this->request->getUploadedFiles();
            $timestamp = strval(time());

            $ico_name = 'ico-' . $timestamp;
            $img_name = 'img-' . $timestamp;

            foreach ($files as $file) {
                if ($file->getKey() == 'icono') {
                    $ico_name = $ico_name . '.' . strtolower($file->getExtension());
                    if (!$file->moveTo($path . $ico_name)) {
                        $this->flash->error($this->translate('images_not_saved'));
                        return $this->response->redirect($this->request->getHTTPReferer());
                    }
                }

                if ($file->getKey() == 'imagen') {
                    $img_name = $img_name . '.' . strtolower($file->getExtension());
                    if (!$file->moveTo($path . $img_name)) {
                        $this->flash->error($this->translate('images_not_saved'));
                        return $this->response->redirect($this->request->getHTTPReferer());
                    }
                }
            }

            $filters = array('trim', 'striptags');

            $feature = new Feature();
            $feature->lang_id = $this->request->getPost('lang_id', $filters);
            $feature->title = $this->request->getPost('titulo', $filters);
            $feature->content = $this->request->getPost('contenido', $filters);
            $feature->icon = $ico_name;
            $feature->image = $img_name;
            $feature->created_at = date('Y-m-d H:i:s');

            if ($feature->create() == false) {
                $this->flash->error($this->translate('info_not_saved'));
                return $this->response->redirect('caracteristicas/administrar');
            }

            $this->flash->success($this->translate('info_saved'));
            return $this->response->redirect('caracteristicas/administrar');
        } else {
            return $this->view->render('features', 'create');
        }
    }

    public function readAction($feature_id)
    {
        $feature = Feature::findFirst([
            'columns' => [
                'feature_id',
                'title',
                'content',
                'icon',
                'image',
                'created_at',
                'updated_at'
            ],
            'conditions' => 'feature_id = :id:',
            'bind'       => [
                'id' => $feature_id
            ],
            'order' => 'feature_id asc'
        ]);

        $this->view->feature_id = $feature_id;
        $this->view->feature = $feature;
        return $this->view->render('features', 'read');
    }

    public function updateAction($feature_id)
    {
        $feature = Feature::findFirst($feature_id);

        if (!$feature) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('caracteristicas/administrar');
        }

        $this->view->feature = $feature;

        if ($this->request->isPost()) {
            if ($this->security->checkToken() == false) {
                $this->flash->error($this->translate('invalid_token'));
                return $this->response->redirect($this->request->getHTTPReferer());
            }

            $validation = new UpdateValidator();
            $errors = $validation->validate(array_merge($_POST, $_FILES));

            if (count($errors)) {
                foreach ($errors as $error) {
                    $this->flash->error($error->getMessage());
                }

                $columns = [];
                foreach ($this->request->getPost() as $field => $input) {
                    $columns[$field] = $input;
                }

                $old_input = (object) $columns;
                $this->view->old = $old_input;

                return $this->view->render('features', 'update');
            }

            if ($this->request->hasFiles() == true) {
                $public_path = $this->url->getBasePath();
                $uploads_folder = 'uploads/images/features/';
                $path = $public_path . $uploads_folder;

                $files = $this->request->getUploadedFiles();
                $timestamp = strval(time());

                $ico_name = 'ico-' . $timestamp;
                $img_name = 'img-' . $timestamp;

                foreach ($files as $file)
                {
                    if($file->getKey() == 'icono') {
                        if($file->getName() != '') {
                            unlink($path . $feature->icon);

                            $ico_name = $ico_name . '.' . strtolower($file->getExtension());

                            if (!$file->moveTo($path . $ico_name)) {
                                $this->flash->error($this->translate('images_not_saved'));
                                return $this->response->redirect($this->request->getHTTPReferer());
                            }

                            $feature->icon = $ico_name;
                        }
                    }

                    if($file->getKey() == 'imagen') {
                        if($file->getName() != '') {
                            unlink($path . $feature->image);

                            $img_name = $img_name . '.' . strtolower($file->getExtension());

                            if (!$file->moveTo($path . $img_name)) {
                                $this->flash->error($this->translate('images_not_saved'));
                                return $this->response->redirect($this->request->getHTTPReferer());
                            }

                            $feature->image = $img_name;
                        }
                    }                    
                }
            }

            $filters = array('trim', 'striptags');

            $feature->title = $this->request->getPost('titulo', $filters);
            $feature->content = $this->request->getPost('contenido', $filters);
            $feature->updated_at = date('Y-m-d H:i:s');

            if ($feature->update() == false) {
                $this->flash->error($this->translate('info_not_saved'));
                return $this->response->redirect('caracteristicas/administrar');
            }

            $this->flash->success($this->translate('info_saved'));
            return $this->response->redirect('caracteristicas/administrar');
        } else {
            return $this->view->render('features', 'update');
        }
    }

    public function deleteAction($feature_id)
    {
        $feature = Feature::findFirst($feature_id);

        if (!$feature) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('caracteristicas/administrar');
        }

        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/images/features/';
        $path = $public_path . $uploads_folder;

        if (!unlink($path . $feature->icon)) {
            $this->flash->error($this->translate('images_not_deleted'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if (!unlink($path . $feature->image)) {
            $this->flash->error($this->translate('images_not_deleted'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if ($feature->delete() == false) {
            $this->flash->error($this->translate('info_not_deleted'));
            return $this->response->redirect('caracteristicas/administrar');
        }

        $this->flash->success($this->translate('info_deleted'));
        return $this->response->redirect('caracteristicas/administrar');
    }
}
