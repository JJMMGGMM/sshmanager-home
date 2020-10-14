<?php

namespace App\Controllers;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Http\Response as Response;
use App\Validators\Unsuscribe\PublicValidator;
use App\Validators\Unsuscribe\UpdateValidator;
use App\Models\Unsuscribe;

class UnsuscribeController extends ControllerBase
{
    public function publicAction()
    {
        return $this->view->render('unsuscribe', 'public');
    }

    public function submitDataAction()
    {
        $this->view->disable();

        if ($this->security->checkToken(null, null, false) == false) {
            $errors = [$this->translate('invalid_token')];

            $json = [
                'code'=>'422',
                'status'=>'error',
                'details' => $errors
            ];

            $payload     = $json;
            $headers     = array();
            $contentType = 'application/json';
            $content     = json_encode($payload);

            $response = new Response();
            $response->setStatusCode(422);
            $response->setContentType($contentType, 'utf-8');
            $response->setContent($content);

            foreach ($headers as $key => $value) {
               $response->setHeader($key, $value);
            }

            return $response;
        }

        $validation = new PublicValidator();
        $messages = $validation->validate($this->request->getPost());

        if (count($messages)) {
            $errors = [];

            foreach ($messages as $message) {
                $errors[] =  $message->getMessage();
            }

            $json = [
                'code' => '422',
                'status' => 'error',
                'details' => $errors
            ];

            $payload     = $json;
            $headers     = array();
            $contentType = 'application/json';
            $content     = json_encode($payload);
    
            $response = new Response();
            $response->setStatusCode(422);
            $response->setContentType($contentType, 'utf-8');
            $response->setContent($content);

            foreach ($headers as $key => $value) {
               $response->setHeader($key, $value);
            }

            return $response;
        }

        $filters = array('trim', 'striptags', 'lower');

        $email = $this->request->getPost('correo', $filters);

        $unsuscribe = new Unsuscribe();
        $unsuscribe->email = $email;
        $unsuscribe->created_at = date('Y-m-d H:i:s');

        if ($unsuscribe->create() == false) {
            $errors = [$this->translate('info_not_saved')];

            $json = [
                'code' => '422',
                'status' => 'error',
                'details' => $errors
            ];

            $payload     = $json;
            $status      = 422;
            $description = 'Unprocessable Entity';
            $headers     = array();
            $contentType = 'application/json';
            $content     = json_encode($payload);
    
            $response = new Response();

            $response->setStatusCode($status, $description);
            $response->setContentType($contentType, 'utf-8');
            $response->setContent($content);

            foreach ($headers as $key => $value) {
               $response->setHeader($key, $value);
            }

            return $response;
        } else {
            $json = [
                'code' => '200',
                'status' => 'success',
                'details' => $this->translate('done')
            ];

            $payload     = $json;
            $status      = 200;
            $description = 'OK';
            $headers     = array();
            $contentType = 'application/json';
            $content     = json_encode($payload);
    
            $response = new Response();
            $response->setStatusCode($status, $description);
            $response->setContentType($contentType, 'utf-8');
            $response->setContent($content);

            foreach ($headers as $key => $value) {
               $response->setHeader($key, $value);
            }

            return $response;
        }
    }

    public function indexAction()
    {        
        $current_page = $this->request->getPost('actual');
        $order_by = $this->request->getPost('orden');
        $limit = $this->request->getPost('limite');
        $search = $this->request->getPost('busqueda');

        $builder = $this->modelsManager->createBuilder()
            ->columns(
                'unsuscribed_id,
                email,
                created_at'
            )
            ->from(Unsuscribe::class);

        if ($order_by == 'asc') {
            $builder->orderBy('unsuscribed_id asc');
        } else {
            $builder->orderBy('unsuscribed_id desc');
        }

        if (!$limit) {
            $limit = 10;
        }

        if ($search) {
            $builder->where(
                'email like :search:',
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
        $this->view->unsuscribe = $paginator->getPaginate();
        return $this->view->render('unsuscribe', 'index');
    }

    public function updateAction($unsuscribed_id)
    {
        $unsuscribe = Unsuscribe::findFirst($unsuscribed_id);

        if (!$unsuscribe) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('desuscribir/administrar');
        }

        $this->view->unsuscribe = $unsuscribe;

        if ($this->request->isPost()) {
            if ($this->security->checkToken() == false) {
                $this->flash->error($this->translate('invalid_token'));
                return $this->response->redirect($this->request->getHTTPReferer());
            }

            $validation = new UpdateValidator();
            $errors = $validation->validate($this->request->getPost());

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

                return $this->view->render('unsuscribe', 'update');
            }

            $filters = array('trim', 'striptags', 'lower');

            $unsuscribe->email = $this->request->getPost('correo', $filters);
            $unsuscribe->updated_at = date('Y-m-d H:i:s');

            if ($unsuscribe->update() == false) {
                $this->flash->error($this->translate('info_not_saved'));
                return $this->response->redirect('desuscribir/administrar');
            }

            $this->flash->success($this->translate('info_saved'));
            return $this->response->redirect('desuscribir/administrar');
        } else {
            return $this->view->render('unsuscribe', 'update');
        }
    }

    public function deleteAction($unsuscribed_id)
    {
        $unsuscribe = Unsuscribe::findFirst($unsuscribed_id);

        if (!$unsuscribe) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('desuscribir/administrar');
        }

        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if ($unsuscribe->delete() == false) {
            $this->flash->error($this->translate('info_not_deleted'));
            return $this->response->redirect('desuscribir/administrar');
        }

        $this->flash->success($this->translate('info_deleted'));
        return $this->response->redirect('desuscribir/administrar');
    }
}
