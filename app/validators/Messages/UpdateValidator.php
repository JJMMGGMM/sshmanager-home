<?php

namespace App\Validators\Messages;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;
use App\Models\Messages as Message;

class UpdateValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            'identificador',
            new PresenceOf([
                'message' => $tr->_('message_presence_identifier'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'identificador',
            new StringLength([
                'max'            => 10,
                'min'            => 8,
                'messageMaximum' => $tr->_('message_strlength_max_identifier'),
                'messageMinimum' => $tr->_('message_strlength_min_identifier'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'identificador',
            new Regex([
                'pattern' => '/^[A-Za-z0-9]+$/',
                'message' => $tr->_('message_regex_identifier'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'identificador',
            new Uniqueness([
                'message' => $tr->_('message_uniqueness_identifier'),
                'model' => new Message,
                'attribute' => 'identifier',
                'cancelOnFail' => true
            ])
        );
    }
}
