<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Features extends Model
{
    public $feature_id;
    public $lang_id;
    public $title;
    public $content;
    public $icon;
    public $image;
    public $created_at;
    public $updated_at;

    public function getSource()
    {
        return 'features';
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
            'feature_id' => 'feature_id',
            'lang_id' => 'lang_id',
            'title' => 'title',
            'content' => 'content',
            'icon' => 'icon',
            'image' => 'image',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        ];
    }
}
