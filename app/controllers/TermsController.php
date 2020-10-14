<?php

namespace App\Controllers;

use App\Validators\Terms\UpdateValidator;

class TermsController extends ControllerBase
{
    public function publicAction()
    {
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/terms/' . $app_lang . '/';
        $path = $public_path . $uploads_folder;

        $md_template = $path . 'public.md';
        $md_content;

        if (file_exists($md_template)) {
            $filesize = filesize($md_template);

            if ($filesize > 0) {
                $md_content = file_get_contents($md_template, true);
            } else {
                $md_content = '## ' . $this->translate('no_data');
            }
        } else {
            $md_content = $this->translate('file_not_found');
        }

        $this->view->md_content = $md_content;
        return $this->view->render('terms', 'public');
    }

    public function indexAction()
    {
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/terms/' . $app_lang . '/';
        $path = $public_path . $uploads_folder;

        $md_template = $path . 'public.md';
        $md_content;

        $old_content = $this->persistent->old_terms_content;

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

        $this->persistent->old_terms_content = $md_content;

        $this->view->md_content = $md_content;
        return $this->view->render('terms', 'index');
    }

    public function previewAction()
    {
        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $filters = array('trim', 'clearInput');

        $md_content = $this->request->getPost('contenido', $filters);

        $key = $this->config->application->cryptSalt;
        $this->view->md_content_text = $md_content;
        $this->view->md_content = $this->crypt->encryptBase64($md_content, $key);
        return $this->view->render('terms', 'preview');
    }

    public function updateAction()
    {
        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $enc_content = $this->request->getPost('contenido');
        
        $filters = array('trim');
        $action = $this->request->getPost('accion', $filters);

        $key = $this->config->application->cryptSalt;
        $content = trim($this->crypt->decryptBase64($enc_content, $key));

        $post_request = (object) ['contenido' => $content];

        $validation = new UpdateValidator();
        $errors = $validation->validate($post_request);
        $count_errors = count($errors);

        if ($count_errors) {
            foreach ($errors as $error) {
                $this->flash->error($error->getMessage());
            }
        }

        if ($action === 'back') {
            $this->persistent->old_terms_content = $post_request->contenido;
            return $this->response->redirect('terminos/administrar');
        } else {
            if ($count_errors) {
                return $this->response->redirect('terminos/administrar');
            }

            $app_lang = $this->view->app_lang;

            $public_path = $this->url->getBasePath();
            $uploads_folder = 'uploads/templates/terms/' . $app_lang . '/';
            $path = $public_path . $uploads_folder;

            $md_template = $path . 'public.md';

            if (file_exists($md_template)) {
                $file_put_contents = file_put_contents($md_template, $content);

                if(!$file_put_contents) {
                    $this->flash->error($this->translate('file_not_saved'));
                    return $this->response->redirect('terminos/administrar');
                }

                $this->persistent->destroy('old_terms_content');
                $this->flash->success($this->translate('info_saved'));
                return $this->response->redirect('terminos/administrar');
            } else {
                $this->flash->error($this->translate('old_terms_content'));
                return $this->response->redirect('terminos/administrar');
            }
        }
    }

    public function restartAction()
    {
        $this->persistent->destroy('old_terms_content');
        return $this->response->redirect($this->request->getHTTPReferer());
    }
}
