<?php

namespace App\Controllers;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use App\Validators\Messages\UpdateValidator;
use App\Models\Messages as Message;

class MessagesController extends ControllerBase
{
    public function indexAction()
    {        
        $current_page = $this->request->getPost('actual');
        $order_by = $this->request->getPost('orden');
        $limit = $this->request->getPost('limite');
        $search = $this->request->getPost('busqueda');

        $builder = $this->modelsManager->createBuilder()
            ->columns(
                'message_id,
                identifier,
                name,
                subject,
                received_at,
                read_at'
            )
            ->from(Message::class);

        if ($order_by == 'asc') {
            $builder->orderBy('message_id asc');
        } else {
            $builder->orderBy('message_id desc');
        }

        if (!$limit) {
            $limit = 10;
        }

        if ($search) {
            $builder->where(
                'identifier like :search: or 
                name like :search: or
                email like :search: or
                subject like :search:',
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
        $this->view->messages = $paginator->getPaginate();
        return $this->view->render('messages', 'index');
    }

    public function readAction($message_id)
    {
        $message = Message::findFirst([
            'columns' => [
                'message_id',
                'identifier',
                'name',
                'email',
                'subject',
                'message',
                'received_at',
                'read_at'
            ],
            'conditions' => 'message_id = :id:',
            'bind'       => [
                'id' => $message_id
            ],
            'orderBy' => 'message_id asc'
        ]);

        $this->view->msg_id = $message_id;
        $this->view->message = $message;
        return $this->view->render('messages', 'read');
    }

    public function updateAction($message_id)
    {
        $message = Message::findFirst($message_id);

        if (!$message) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('mensajes');
        }

        $this->view->message = $message;

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

                return $this->view->render('messages', 'update');
            }

            $filters = array('trim', 'striptags', 'upper');

            $message->identifier = $this->request->getPost('identificador', $filters);

            if ($message->update() == false) {
                $this->flash->error($this->translate('info_not_saved'));
                return $this->response->redirect('mensajes');
            }

            $this->flash->success($this->translate('info_saved'));
            return $this->response->redirect('mensajes');
        } else {
            return $this->view->render('messages', 'update');
        }
    }

    public function deleteAction($message_id)
    {
        $message = Message::findFirst($message_id);

        if (!$message) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('mensajes');
        }

        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if ($message->delete() == false) {
            $this->flash->error($this->translate('info_not_deleted'));
            return $this->response->redirect('mensajes');
        }

        $this->flash->success($this->translate('info_deleted'));
        return $this->response->redirect('mensajes');
    }

    public function markAsReadAction($message_id)
    {
        $message = Message::findFirst($message_id);

        if (!$message) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('mensajes');
        }

        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $message->read_at = date('Y-m-d H:i:s');
        
        if ($message->update() == false) {
            $this->flash->error($this->translate('info_not_saved'));
            return $this->response->redirect('mensajes');
        }

        $this->flash->error($this->translate('info_saved'));
        return $this->response->redirect('mensajes');
    }

    public function markAsNotReadAction($message_id)
    {
        $message = Message::findFirst($message_id);

        if (!$message) {
            $this->flash->error($this->translate('registry_not_found'));
            return $this->response->redirect('mensajes');
        }

        if ($this->security->checkToken() == false) {
            $this->flash->error($this->translate('invalid_token'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $message->read_at = NULL;

        if ($message->update() == false) {
            $this->flash->error($this->translate('info_not_saved'));
            return $this->response->redirect('mensajes');
        }

        $this->flash->error($this->translate('info_saved'));
        return $this->response->redirect('mensajes');
    }
}
