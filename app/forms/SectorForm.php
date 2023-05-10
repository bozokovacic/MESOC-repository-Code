<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SectorForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Sector");
            $this->add($element->setLabel("Sector ID"));
        } else {
            $this->add(new Hidden("ID_Sector"));
        }

        $SectorName = new Text("SectorName");
        $SectorName->setLabel("Sector name");
        $SectorName->setFilters(['striptags', 'string']);
        $SectorName->addValidators([
            new PresenceOf([
                'message' => 'Sector name is required.'
            ])
        ]);
        $this->add($SectorName);

   	}
}
