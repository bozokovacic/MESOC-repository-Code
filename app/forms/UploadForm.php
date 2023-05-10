<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class UploadForm extends Form
{
    /**
     * Initialize the Upload form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options['edit'])) {
            $element = new Text("ID_Upload");
            $this->add($element->setLabel("Upload ID"));
        } else {
            $this->add(new Hidden("ID_Upload"));
        }

/**        $FileName = new Text("FileName");
        $FileName->setLabel("File name");
        $FileName->setFilters(['striptags', 'string']);
        $FileName->addValidators([
            new PresenceOf([
                'message' => 'File name is required.'
            ])
        ]);
        $this->add($FileName); */
        
        $UserFileName = new Text("UserFileName");
        $UserFileName->setLabel("User file name");
        $UserFileName->setFilters(['striptags', 'string']);
        $UserFileName->addValidators([
            new PresenceOf([
                'message' => 'User file name is required.'
            ])
        ]);
        $this->add($UserFileName);
        
        $Download = new Select( "Download", [
            'NO' => 'NO',
            'YES' => 'YES'
            ]);
        
        $Download ->setFilters(['striptags', 'string']);
               /**    new PresenceOf([
                'message' => 'Public year is ruquired.'
            ]) */
                  
        $Download ->setLabel("Download");
        $this->add($Download );
        
   	}
}
