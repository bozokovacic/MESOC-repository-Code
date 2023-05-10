<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class RoleForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Role");
            $this->add($element->setLabel("ROLE ID"));
        } else {
            $this->add(new Hidden("ID_Role"));
        }

        $RoleNumber = new Text("RoleNumber");
        $RoleNumber->setLabel("ROLE NUMBER");
        $RoleNumber->setFilters(['striptags', 'string']);
        $RoleNumber->addValidators([
            new PresenceOf([
                'message' => 'Role Number is required.'
            ])
        ]);
        
        $this->add($RoleNumber);
        
        $RoleName = new Text("RoleName");
        $RoleName->setLabel("ROLE");
        $RoleName->setFilters(['striptags', 'string']);
        $RoleName->addValidators([
            new PresenceOf([
                'message' => 'Role is required.'
            ])
        ]);
        $this->add($RoleName);
        
    }
}
