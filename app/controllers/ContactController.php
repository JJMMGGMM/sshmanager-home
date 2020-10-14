<?php

namespace App\Controllers;

use Phalcon\Http\Response as Response;
use App\Validators\Contact\ContactValidator;
use App\Validators\Contact\UpdateValidator;
use App\Models\Messages as Message;

class ContactController extends ControllerBase
{
    public function publicAction()
    {
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/contact/' . $app_lang . '/';
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
        return $this->view->render('contact', 'public');
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

        $validation = new ContactValidator();
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

        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_str = substr(str_shuffle($chars), 0, 10);

        $filters = array('trim', 'striptags', 'upper');

        $name = $this->request->getPost('nombre', $filters);
        $email = $this->request->getPost('correo', ['trim', 'striptags', 'lower']);
        $subject = $this->request->getPost('asunto', $filters);
        $msg = $this->request->getPost('mensaje', $filters);

        $message = new Message();
        $message->identifier = $random_str;
        $message->name = $name;
        $message->email = $email;
        $message->subject = $subject;
        $message->message = $msg;
        $message->received_at = date('Y-m-d H:i:s');

        if ($message->create() == false) {
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
            $this->mailer->send([$email => $name],
                $this->translate('message'), 'CONTACT', [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $msg
            ]);

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
        $app_lang = $this->view->app_lang;

        $public_path = $this->url->getBasePath();
        $uploads_folder = 'uploads/templates/contact/' . $app_lang . '/';
        $path = $public_path . $uploads_folder;

        $md_template = $path . 'public.md';
        $md_content;

        $old_content = $this->persistent->old_contact_content;

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

        $this->persistent->old_contact_content = $md_content;

        $this->view->md_content = $md_content;
        return $this->view->render('contact', 'index');
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
        return $this->view->render('contact', 'preview');
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
            $this->persistent->old_contact_content = $post_request->contenido;
            return $this->response->redirect('contacto/administrar');
        } else {
            if ($count_errors) {
                return $this->response->redirect('contacto/administrar');
            }

            $app_lang = $this->view->app_lang;

            $public_path = $this->url->getBasePath();
            $uploads_folder = 'uploads/templates/contact/' . $app_lang . '/';
            $path = $public_path . $uploads_folder;

            $md_template = $path . 'public.md';

            if (file_exists($md_template)) {
                $file_put_contents = file_put_contents($md_template, $content);

                if(!$file_put_contents) {
                    $this->flash->error($this->translate('file_not_saved'));
                    return $this->response->redirect('contacto/administrar');
                }

                $this->persistent->destroy('old_contact_content');
                $this->flash->success($this->translate('info_saved'));
                return $this->response->redirect('contacto/administrar');
            } else {
                $this->flash->error($this->translate('file_not_found'));
                return $this->response->redirect('contacto/administrar');
            }
        }
    }

    public function restartAction()
    {
        $this->persistent->destroy('old_contact_content');
        return $this->response->redirect($this->request->getHTTPReferer());
    }
}
