<?php

namespace App\Validators\Unsuscribe;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\Unsuscribe;

class PublicValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            'correo',
            new PresenceOf([
                'message' => [
                    'correo'  => $tr->_('unsuscribe_presence_email'),
                ]
            ])
        );

        $this->add(
            'captcha',
            new PresenceOf([
                'message' => $tr->_('unsuscribe_presence_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'correo',
            new StringLength([
                'max' => [
                    'correo' => 50
                ],
                'min' => [
                    'correo' => 12
                ],
                'messageMaximum' => [
                    'correo' => $tr->_('unsuscribe_strlength_max_correo')
                ],
                'messageMinimum' => [
                    'correo' => $tr->_('unsuscribe_strlength_min_correo')
                ]
            ])
        );

        $this->add(
            'captcha',
            new StringLength([
                'max'            => 6,
                'min'            => 5,
                'messageMaximum' => $tr->_('unsuscribe_strlength_max_captcha'),
                'messageMinimum' => $tr->_('unsuscribe_strlength_min_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'correo',
            new Regex([
                'pattern' => [
                    'correo' => '/^[a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.\-\_])*[a-zA-Z0-9Ññ]+@([a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.\-\_])*[a-zA-Z0-9Ññ]*([a-zA-Z0-9Ññ]+[\.])[a-zA-Z0-9Ññ][a-zA-Z]+)?+$/'
                ],
                'message' => [
                    'correo'  => $tr->_('unsuscribe_regex_email')
                ]
            ])
        );

        $this->add(
            'captcha',
            new Regex([
                'pattern' => '/^[A-Za-z0-9]+$/',
                'message' => $tr->_('unsuscribe_regex_captcha'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'captcha',
            new Identical([
                'message' => $tr->_('unsuscribe_identical_captcha'),
                'value' => $this->session->get('phrase')
            ])
        );

        $this->add(
            'correo',
            new Uniqueness([
                'message' => $tr->_('unsuscribe_uniqueness_email'),
                'model' => new Unsuscribe,
                'attribute' => 'email',
                'cancelOnFail' => true
            ])
        );
    }
}
