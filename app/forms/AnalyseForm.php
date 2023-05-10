<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class AnalyseForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Analyse");
            $this->add($element->setLabel("ANALYSIS ID"));
        } else {
            $this->add(new Hidden("ID_Analyse"));
        }

        $AnalyseName = new Text("AnalyseName");
        $AnalyseName->setLabel("ANALYSIS NAME");
        $AnalyseName->setFilters(['striptags', 'string']);
        $AnalyseName->addValidators([
            new PresenceOf([
                'message' => 'Analyse name is required.'
            ])
        ]);
        $this->add($AnalyseName);
        
        $AnalyseDescription = new Text("AnalyseDescription");
        $AnalyseDescription->setLabel("ANALYSIS DESCRIPTION");
        $AnalyseDescription->setFilters(['striptags', 'string']);
        $AnalyseDescription->addValidators([
            new PresenceOf([
                'message' => 'Analyse desription is required.'
            ]) 
        ]);
        $this->add($AnalyseDescription);
        
    }
}
