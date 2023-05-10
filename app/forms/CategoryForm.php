<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CategoryForm extends Form
{
    /**
     * Initialize the type form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Category");
            $this->add($element->setLabel("CATEGORY ID"));
        } else {
            $this->add(new Hidden("ID_Category"));
        }

        $CategoryName = new Text("CategoryName");
        $CategoryName->setLabel("DOCUMENT CATEGORY");
        $CategoryName->setFilters(['striptags', 'string']);
        $CategoryName->addValidators([
            new PresenceOf([
                'message' => 'Category name is required.'
            ])
        ]);
        $this->add($CategoryName);
        
        $CategoryDescription = new Text("CategoryDescription");
        $CategoryDescription->setLabel("DOCUMENT CATEGORY DESCRIPTION");
        $CategoryDescription->setFilters(['striptags', 'string']);
        $CategoryDescription->addValidators([
/**            new PresenceOf([
                'message' => 'Category name is required.'
            ]) */
        ]);
        $this->add($CategoryDescription);
                     
    }
}
