<?php

namespace App\Validators\Terms;

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
                'message' => $tr->_('term_presence_content'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'contenido',
            new StringLength([
                'max'            => 30000,
                'min'            => 10,
                'messageMaximum' => $tr->_('term_strlength_max_content'),
                'messageMinimum' => $tr->_('term_strlength_min_content'),
                'cancelOnFail' => true
            ])
        );
    }
}
