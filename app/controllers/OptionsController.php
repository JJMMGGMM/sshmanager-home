<?php

namespace App\Controllers;

use App\Models\Messages as Message;

class OptionsController extends ControllerBase
{
    public function indexAction()
    {
        $count_messages = $this->modelsManager->createBuilder()
            ->columns('count(message_id) as total')
            ->from(Message::class)
            ->where('message_id is not null and read_at is null')
		    ->getQuery()
		    ->setUniqueRow(true)
		    ->execute();

		$messages = intval($count_messages['total']);

        $this->view->messages = $messages;
        return $this->view->render('options', 'index');
    }
}
