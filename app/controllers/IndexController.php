<?php

namespace App\Controllers;

use App\Validators\Index\UpdateValidator;

class IndexController extends ControllerBase
{
    public function publicAction()
    {
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/index/' . $app_lang . '/';
        $path = $public_path . $uploads_folder;

        $md_head_template = $path . 'public_head.md';
        $md_body_template = $path . 'public_body.md';
        $md_foot_template = $path . 'public_foot.md';

        $md_head;
        $md_body;
        $md_foot;

        if (file_exists($md_head_template)) {
            $filesize = filesize($md_head_template);

            if ($filesize > 0) {
                $md_head = file_get_contents($md_head_template, true);
            } else {
                $md_head = '## ' . $this->translate('no_data');
            }
        } else {
            $md_head = $this->translate('file_not_found');
        }

        if (file_exists($md_body_template)) {
            $filesize = filesize($md_body_template);

            if ($filesize > 0) {
                $md_body = file_get_contents($md_body_template, true);
            } else {
                $md_body = '## ' . $this->translate('no_data');
            }
        } else {
            $md_body = $this->translate('file_not_found');
        }

        if (file_exists($md_foot_template)) {
            $filesize = filesize($md_foot_template);

            if ($filesize > 0) {
                $md_foot = file_get_contents($md_foot_template, true);
            } else {
                $md_foot = '## ' . $this->translate('no_data');
            }
        } else {
            $md_foot = $this->translate('file_not_found');
        }

        $this->view->md_head = $md_head;
        $this->view->md_body = $md_body;
        $this->view->md_foot = $md_foot;
        return $this->view->render('index', 'public');
    }

    public function selectSectionAction()
    {
        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect('inicio/administrar');
        }

        $filters = array('trim');

        $md_section = $this->request->getPost('seccion', $filters);
        $md_content = $this->request->getPost('contenido', $filters);

        $this->persistent->old_index_section = $md_section;
        $this->persistent->old_index_content = $md_content;

        return $this->response->redirect($this->request->getHTTPReferer());
    }

    public function indexAction()
    {
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/index/' . $app_lang . '/';
        $path = $public_path . $uploads_folder;

        $md_head_template = $path . 'public_head.md';
        $md_body_template = $path . 'public_body.md';
        $md_foot_template = $path . 'public_foot.md';

        $md_template;
        $md_section;
        $md_content;

        $old_section = $this->persistent->old_index_section;
        $old_content = $this->persistent->old_index_content;

        switch ($old_section) {
            case 'intro':
                $md_template = $md_head_template;
                $md_section = $old_section;
                break;
            case 'contenido':
                $md_template = $md_body_template;
                $md_section = $old_section;
                break;
            case 'final':
                $md_template = $md_foot_template;
                $md_section = $old_section;
                break;
            default:
                $md_template = $md_head_template;
                $md_section = 'intro';
            break;
        }

        if (trim($old_content) == '') {
            if (file_exists($md_template)) {
                $filesize = filesize($md_template);
                if ($filesize > 0) {
                    $md_content = file_get_contents($md_template, true);
                } else {
                    $md_content = $md_content = '## ' . $this->translate('no_data');
                }
            } else {
                $this->flash->error($this->translate('file_not_found'));
            }
        } elseif (trim($old_content) != '') {
            $md_content =  $old_content;
        } else {
            $this->flash->error($this->translate('file_not_found'));
        }

        $this->persistent->old_index_section = $md_section;
        $this->persistent->old_index_content = $md_content;

        $this->view->md_section = $md_section;
        $this->view->md_content = $md_content;
        return $this->view->render('index', 'index');
    }

    public function previewAction()
    {
        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect('inicio/administrar');
        }

        $filters = array('trim', 'clearInput');

        $md_section = $this->request->getPost('seccion', $filters);
        $md_content = $this->request->getPost('contenido', $filters);

        $key = $this->config->application->cryptSalt;
        $this->view->md_section_text = $md_section;
        $this->view->md_section = $this->crypt->encryptBase64($md_section, $key);
        $this->view->md_content_text = $md_content;
        $this->view->md_content = $this->crypt->encryptBase64($md_content, $key);
        return $this->view->render('index', 'preview');
    }

    public function updateAction()
    {
        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $enc_section = $this->request->getPost('seccion');
        $enc_content = $this->request->getPost('contenido');
        
        $filters = array('trim');
        $action = $this->request->getPost('accion', $filters);

        $key = $this->config->application->cryptSalt;
        $section = trim($this->crypt->decryptBase64($enc_section, $key));
        $content = trim($this->crypt->decryptBase64($enc_content, $key));

        $post_request = (object) ['seccion' => $section, 'contenido' => $content];

        $validation = new UpdateValidator();
        $errors = $validation->validate($post_request);
        $count_errors = count($errors);

        if ($count_errors) {
            foreach ($errors as $error) {
                $this->flash->error($error->getMessage());
            }
        }

        if ($action === 'back') {
            $this->persistent->old_index_section = $post_request->seccion;
            $this->persistent->old_index_content = $post_request->contenido;
            return $this->response->redirect('inicio/administrar');
        } else {
            if ($count_errors) {
                return $this->response->redirect('inicio/administrar');
            }

            $app_lang = $this->view->app_lang;

            $public_path = $this->url->getBasePath();
            $uploads_folder = 'uploads/templates/index/' . $app_lang . '/';
            $path = $public_path . $uploads_folder;

            $md_head_template = $path . 'public_head.md';
            $md_body_template = $path . 'public_body.md';
            $md_foot_template = $path . 'public_foot.md';

            $md_template;
            $md_section;
            $md_content;

            switch ($section) {
                case 'intro':
                    $md_template = $md_head_template;
                    $md_section = $section;
                    $md_content = $content;
                    break;
                case 'contenido':
                    $md_template = $md_body_template;
                    $md_section = $section;
                    $md_content = $content;
                    break;
                case 'final':
                    $md_template = $md_foot_template;
                    $md_section = $section;
                    $md_content = $content;
                    break;
                default:
                    $this->flash->error($this->translate('section_not_found'));
                    return $this->response->redirect('inicio/administrar');
                break;
            }

            if (file_exists($md_template)) {
                $file_put_contents = file_put_contents($md_template, $md_content);

                if(!$file_put_contents) {
                    $this->flash->error($this->translate('file_not_saved'));
                    return $this->response->redirect('inicio/administrar');
                }

                $this->persistent->destroy('old_index_section');
                $this->persistent->destroy('old_index_content');
                $this->flash->success($this->translate('info_saved'));
                return $this->response->redirect('inicio/administrar');
            } else {
                $this->flash->error($this->translate('file_not_found'));
                return $this->response->redirect('inicio/administrar');
            }
        }
    }

    public function restartAction()
    {
        $this->persistent->destroy('old_index_section');
        $this->persistent->destroy('old_index_content');
        return $this->response->redirect('inicio/administrar');
    }
}
