<?php

namespace App\Validators\Features;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\File;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\Features as Feature;

class CreateValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            'lang_id',
            new PresenceOf([
                'message' => $tr->_('feature_presence_lang_id')
            ])
        );

        $this->add(
            'titulo',
            new PresenceOf([
                'message' => $tr->_('feature_presence_title')
            ])
        );

        $this->add(
            'contenido',
            new PresenceOf([
                'message' => $tr->_('feature_presence_content'),
                'cancelOnFail'   => true
            ])
        );

        $this->add(
            'lang_id',
            new Numericality([
                'message' => $tr->_('feature_numericality_lang_id'),
                'cancelOnFail'   => true
            ])
        );

        $this->add(
            'titulo',
            new StringLength([
                'max'            => 30,
                'min'            => 3,
                'messageMaximum' => $tr->_('feature_strlength_max_title'),
                'messageMinimum' => $tr->_('feature_strlength_min_title')
            ])
        );

        $this->add(
            'contenido',
            new StringLength([
                'max'            => 80,
                'min'            => 10,
                'messageMaximum' => $tr->_('feature_strlength_max_content'),
                'messageMinimum' => $tr->_('feature_strlength_min_content'),
                'cancelOnFail'   => true
            ])
        );

        $this->add(
            'icono',
            new File([
                'maxSize'              => '1M',
                'messageSize'          => $tr->_('feature_size_icon'),
                'allowedTypes'         => [
                    'image/jpeg',
                    'image/png',
                ],
                'messageType'          => $tr->_('feature_type_icon'),
                'maxResolution'        => '700x700',
                'messageMaxResolution' => $tr->_('feature_maxres_icon'),
                'messageEmpty'         => $tr->_('feature_empty_icon')
            ])
        );

        $this->add(
            'imagen',
            new File([
                'maxSize'              => '2M',
                'messageSize'          => $tr->_('feature_size_image'),
                'allowedTypes'         => [
                    'image/jpeg',
                    'image/png',
                ],
                'messageType'          => $tr->_('feature_type_image'),
                'maxResolution'        => '1024x768',
                'messageMaxResolution' => $tr->_('feature_maxres_image'),
                'messageEmpty'         => $tr->_('feature_empty_image'),
                'cancelOnFail'         => true
            ])
        );

        $this->add(
            'titulo',
            new Regex([
                'pattern' => '/^[A-Za-zÁÉÍÓÚáéíóúÑñ]*([A-Za-z0-9ÁÉÍÓÚáéíóúÑñÑñ.,]+\s)*[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ.]+$/',
                'message' => $tr->_('feature_regex_title')
            ])
        );

        $this->add(
            'contenido',
            new Regex([
                'pattern' => '/^[A-Za-zÁÉÍÓÚáéíóúÑñ]*([A-Za-z0-9ÁÉÍÓÚáéíóúÑñÑñ.,]+\s)*[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ.]+$/',
                'message' => $tr->_('feature_regex_content'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'titulo',
            new Uniqueness([
                'message' => $tr->_('feature_uniqueness_title'),
                'model' => new Feature,
                'attribute' => 'title',
                'cancelOnFail' => true
            ])
        );
    }
}
