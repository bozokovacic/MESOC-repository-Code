<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class RegionForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Region");
            $this->add($element->setLabel("REGION ID"));
        } else {
            $this->add(new Hidden("ID_Region"));
        }

        $RegionName = new Text("RegionName");
        $RegionName->setLabel("REGION");
        $RegionName->setFilters(['striptags', 'string']);
        $RegionName->addValidators([
            new PresenceOf([
                'message' => 'Region is required.'
            ])
        ]);
        $this->add($RegionName);
        
        $RegionTeritCon = new Text("RegionTeritCon");
        $RegionTeritCon->setLabel("TERRITORIAL CONTEXT");
        $RegionTeritCon->setFilters(['striptags', 'string']);
        $RegionTeritCon->addValidators([
            new PresenceOf([
                'message' => 'Region territorial context is required.'
            ])
        ]);
        $this->add($RegionTeritCon);
        
        $NUTSType = new Text("NUTSType");
        $NUTSType->setLabel("NUTS CATEGORY");
        $NUTSType->setFilters(['striptags', 'string']);
        $NUTSType->addValidators([
/**            new PresenceOf([
                'message' => 'Region name is required.'
            ]) */
        ]); 
        $this->add($NUTSType);
        
    }
}
