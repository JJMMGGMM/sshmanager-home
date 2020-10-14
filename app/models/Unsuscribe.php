<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Unsuscribe extends Model
{
    public $unsuscribed_id;
    public $email;
    public $created_at;
    public $updated_at;

    public function getSource()
    {
        return 'unsuscribe';
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
            'unsuscribed_id' => 'unsuscribed_id',
            'email' => 'email',
            'created_at'=> 'created_at',
            'updated_at'=> 'updated_at'
        ];
    }
}
