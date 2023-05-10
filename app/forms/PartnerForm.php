<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class PartnerForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Partner");
            $this->add($element->setLabel("PARTNER ID"));
        } else {
            $this->add(new Hidden("ID_Partner"));
        }

        $PartnerNumber = new Text("PartnerNumber");
        $PartnerNumber->setLabel("PARTNER NUMBER");
        $PartnerNumber->setFilters(['striptags', 'string']);
        $PartnerNumber->addValidators([
            new PresenceOf([
                'message' => 'Partner number is required.'
            ])
        ]);
        $this->add($PartnerNumber);
        
        $PartnerName = new Text("PartnerName");
        $PartnerName->setLabel("PARTNER");
        $PartnerName->setFilters(['striptags', 'string']);
        $PartnerName->addValidators([
            new PresenceOf([
                'message' => 'Partner is required.'
            ])
        ]);
        $this->add($PartnerName);
        
        $PartnerAcr = new Text("PartnerAcr");
        $PartnerAcr->setLabel("PARTNER ACRONIM");
        $PartnerAcr->setFilters(['striptags', 'string']);
        $PartnerAcr->addValidators([
            new PresenceOf([
                'message' => 'Partner acronim name is required.'
            ])
        ]);
        $this->add($PartnerAcr);
    }
}
