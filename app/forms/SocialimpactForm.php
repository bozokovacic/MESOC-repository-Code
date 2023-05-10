<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class SocialimpactForm extends Form
{
    /**
     * Initialize the Sector form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_SocImpact");
            $this->add($element->setLabel("Cross-over theme ID"));
        } else {
            $this->add(new Hidden("ID_SocImpact"));
        }

        $SocImpactName = new Text("SocImpactName");
        $SocImpactName->setLabel("Cross-over theme");
        $SocImpactName->setFilters(['striptags', 'string']);
        $SocImpactName->addValidators([
            new PresenceOf([
                'message' => 'Cross-over theme is required.'
            ])
        ]);
        $this->add($SocImpactName);

        $SocImpactDescription = new Text("SocImpactDescription");
        $SocImpactDescription->setLabel("Cross-over theme description");
        $SocImpactDescription->setFilters(['striptags', 'string']);
        $SocImpactDescription->addValidators([
/**            new PresenceOf([
                'message' => 'Social impact description is required.'
            ])  */
        ]);
        $this->add($SocImpactDescription);

   	}
}
