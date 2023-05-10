<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SectorDeleteForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Sector");
            $this->add($element->setLabel("Cultural domain ID"));
        } else {
            $this->add(new Hidden("ID_Sector"));
        }

        $SectorName = new Text("SectorName");
        $SectorName->setLabel("Cultural domain name");
        $SectorName->setValue ("Sector name");
        $SectorName->setFilters(['striptags', 'string']);
        $SectorName->addValidators([
            new PresenceOf([
                'message' => 'Sector name is required.'
            ])
        ]);
        $this->add($SectorName);
        
        $yes = new Radio("Deleta", array("id" => "myYes", "value" => 1));
        $yes->setLabel("Delete");

        $no = new Radio("Delete", array("id" => "myNo", "value" => 2));
        $no->setLabel("Cancel");
         
    }
}
