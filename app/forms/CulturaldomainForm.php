<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CulturaldomainForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_CultDomain");
            $this->add($element->setLabel("Cultural sector ID"));
        } else {
            $this->add(new Hidden("ID_CultDomain"));
        }

        $CultDomainName = new Text("CultDomainName");
        $CultDomainName->setLabel("Cultural sector ");
        $CultDomainName->setFilters(['striptags', 'string']);
        $CultDomainName->addValidators([
            new PresenceOf([
                'message' => 'Cultural sector is required.'
            ])
        ]);
        $this->add($CultDomainName);

        $CultDomainDescription = new Text("CultDomainDescription");
        $CultDomainDescription->setLabel("Cultural sector description");
        $CultDomainDescription->setFilters(['striptags', 'string']);
        $CultDomainDescription->addValidators([
            new PresenceOf([
                'message' => 'Cultural sector description is required.'
            ])
        ]);
        $this->add($CultDomainDescription);

   	}
}
