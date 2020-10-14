<?php

namespace App\Validators\index;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\InclusionIn;

class UpdateValidator extends Validation
{
    public function initialize()
    {
        $tr = $this->translator->getTranslation();

        $this->add(
            'seccion',
            new PresenceOf([
                'message' => $tr->_('index_presence_section'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'contenido',
            new PresenceOf([
                'message' => $tr->_('index_presence_content'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'seccion',
            new InclusionIn([
                'message' => $tr->_('index_inclusion_section'),
                'domain'  => ['intro', 'contenido', 'final'],
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'contenido',
            new StringLength([
                'max'            => 30000,
                'min'            => 10,
                'messageMaximum' => $tr->_('index_strlength_max_content'),
                'messageMinimum' => $tr->_('index_strlength_min_content'),
                'cancelOnFail' => true
            ])
        );
    }
}
