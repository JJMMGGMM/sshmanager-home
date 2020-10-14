<?php

namespace App\Validators\Contact;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\Unsuscribe;

class ContactValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            [
                'nombre',
                'correo',
                'asunto',
                'mensaje'
            ],
            new PresenceOf([
                'message' => [
                    'nombre'  => $tr->_('contact_presence_name'),
                    'correo'  => $tr->_('contact_presence_email'),
                    'asunto'  => $tr->_('contact_presence_subject'),
                    'mensaje' => $tr->_('contact_presence_message')
                ],
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'captcha',
            new PresenceOf([
                'message' => $tr->_('contact_presence_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            [
                'nombre',
                'correo',
                'asunto',
                'mensaje'
            ],
            new StringLength([
                'max' => [
                    'nombre' => 50,
                    'correo' => 50,
                    'asunto' => 50,
                    'mensaje' => 5000
                ],
                'min' => [
                    'nombre'  => 3,
                    'correo' => 12,
                    'asunto' => 3,
                    'mensaje' => 10
                ],
                'messageMaximum' => [
                    'nombre'  => $tr->_('contact_strlength_max_nombre'),
                    'correo' => $tr->_('contact_strlength_max_correo'),
                    'asunto'  => $tr->_('contact_strlength_max_asunto'),
                    'mensaje' => $tr->_('contact_strlength_max_mensaje')
                ],
                'messageMinimum' => [
                    'nombre'  => $tr->_('contact_strlength_min_nombre'),
                    'correo' => $tr->_('contact_strlength_min_correo'),
                    'asunto'  => $tr->_('contact_strlength_min_asunto'),
                    'mensaje' => $tr->_('contact_strlength_min_mensaje')
                ],
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'captcha',
            new StringLength([
                'max'            => 6,
                'min'            => 5,
                'messageMaximum' => $tr->_('contact_strlength_max_captcha'),
                'messageMinimum' => $tr->_('contact_strlength_min_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            [
                'nombre',
                'correo',
                'asunto',
                'mensaje'
            ],
            new Regex([
                'pattern' => [
                    'nombre' => '/^([A-Za-z]+\s)*[A-Za-z]+$/',
                    'correo' => '/^[a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.\-\_])*[a-zA-Z0-9Ññ]+@([a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.\-\_])*[a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.])[a-zA-Z0-9Ññ][a-zA-Z]+)?+$/',
                    'asunto' => '/^[A-Za-z]*([A-Za-z0-9Ññ.,]+\s)*[A-Za-z0-9Ññ.]+$/',
                    'mensaje' => '/^[A-Za-z]*([A-Za-z0-9Ññ.,]+\s)*[A-Za-z0-9Ññ.]+$/'
                ],
                'message' => [
                    'nombre'  => $tr->_('contact_regex_name'),
                    'correo'  => $tr->_('contact_regex_email'),
                    'asunto'  => $tr->_('contact_regex_subject'),
                    'mensaje' => $tr->_('contact_regex_message')
                ],
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'captcha',
            new Regex([
                'pattern' => '/^[A-Za-z0-9]+$/',
                'message' => $tr->_('contact_regex_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'captcha',
            new Identical([
                'message' => $tr->_('contact_identical_captcha'),
                'value' => $this->session->get('phrase'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'correo',
            new Uniqueness([
                'message' => $tr->_('contact_unsuscribe_uniqueness_email'),
                'model' => new Unsuscribe,
                'attribute' => 'email',
                'cancelOnFail' => true
            ])
        );
    }
}
