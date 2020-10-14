<?php

namespace App\Validators\Contact;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class UpdateValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            'contenido',
            new PresenceOf([
                'message' => $tr->_('contact_presence_content'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'contenido',
            new StringLength([
                'max'            => 30000,
                'min'            => 10,
                'messageMaximum' => $tr->_('contact_strlength_max_content'),
                'messageMinimum' => $tr->_('contact_strlength_min_content'),
                'cancelOnFail' => true
            ])
        );
    }
}
