<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class BeneficiaryForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Beneficiary");
            $this->add($element->setLabel("BENEFICIARY ID"));
        } else {
            $this->add(new Hidden("ID_Beneficiary"));
        }

        $BeneficiaryName = new Text("BeneficiaryName");
        $BeneficiaryName->setLabel("BENEFICIARY NAME");
        $BeneficiaryName->setFilters(['striptags', 'string']);
        $BeneficiaryName->addValidators([
            new PresenceOf([
                'message' => 'Beneficiary name is required.'
            ])
        ]);
        $this->add($BeneficiaryName);
        
    }
}
