<?php

namespace App\Validators\Faqs;

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
                'message' => $tr->_('faq_presence_content'),
                'cancelOnFail' => true
            ])
        );

        $this->add(
            'contenido',
            new StringLength([
                'max'            => 30000,
                'min'            => 10,
                'messageMaximum' => $tr->_('faq_strlength_max_content'),
                'messageMinimum' => $tr->_('faq_strlength_min_content'),
                'cancelOnFail' => true
            ])
        );
    }
}
