<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Messages extends Model
{
    public $message_id;
    public $identifier;
    public $name;
    public $email;
    public $subject;
    public $message;
    public $received_at;
    public $read_at;

    public function getSource()
    {
        return 'messages';
    }

    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function columnMap()
    {
        return [
            'message_id' => 'message_id',
            'identifier' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'subject' => 'subject',
            'message' => 'message',
            'received_at' => 'received_at',
            'read_at' => 'read_at'
        ];
    }
}
