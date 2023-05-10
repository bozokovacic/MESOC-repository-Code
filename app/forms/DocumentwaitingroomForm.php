<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Forms\Element\File;

class DocumentwaitingroomForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
     if (!isset($options['edit'])) {
            $element = new Text("ID_Doc");
            $this->add($element->setLabel("Document ID"));
        } else {
            $this->add(new Hidden("ID_Doc"));
        }
   
        $PubYear = new Text("PubYear");
        $PubYear->setLabel("Year of publication");
        $PubYear->setFilters(['striptags', 'string']);
        $PubYear->addValidators([
            new PresenceOf([
                'message' => 'Public year is ruquired.'
            ]) 
        ]);
        $this->add($PubYear);
        
	$Title = new Text("Title");
        $Title->setLabel("Document title");
        $Title->setFilters(['striptags', 'string']);
        $Title->addValidators([
            new PresenceOf([
                'message' => 'Document title is required.'
            ])
        ]);
        
        $this->add($Title);
                
        $BiblioRef = new TextArea("BiblioRef");
        $BiblioRef->setLabel("Bibliographic Reference");
        $BiblioRef->setFilters(['striptags', 'string']);
        $BiblioRef->setAttribute('rows', '2');
        $BiblioRef->addValidators([
        /**    new PresenceOf([
                'message' => 'Public year is ruquired.'
            ]) */
        ]);
        $this->add($BiblioRef);
               
        $type = new Select('ID_Type', Type::find(), [
            'using'      => ['ID_Type', 'DocType'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Document Type');
        $this->add($type);   
        
        $type = new Select('ID_Category', Category::find(), [
            'using'      => ['ID_Category', 'CategoryName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Category');
        $this->add($type);   
        
        $type = new Select('ID_Language', Language::find(), [
            'using'      => ['ID_Language', 'Language'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $type->setLabel('Language');
        $this->add($type);  
      
        $NumPages = new Text("NumPages");
        $NumPages->setLabel("Number of pages");
        $NumPages->setFilters(['striptags', 'string']);
        $NumPages->addValidators([
           new PresenceOf([
                'message' => 'Number of pages is ruquired.'
            ]) 
        ]); 
        $this->add($NumPages);
        
        $Links = new Text("Links");
        $Links->setLabel("Link to document");
        $Links->setFilters(['striptags', 'string']);
        $Links->addValidators([
/**            new PresenceOf([
                'message' => 'Links is ruquired.'
            ]) */
        ]); 
        $this->add($Links);
        
        $Summary = new TextArea("Summary");
        $Summary->setLabel("Abstract");
        $Summary->setFilters(['striptags', 'string']);
        $Summary->setAttribute('rows', '8');
        $Summary->addValidators([
        /**    new PresenceOf([
                'message' => 'Public year is ruquired.'
            ])*/
        ]);
        
        $this->add($Summary);
        
        $PeriodFrom = new Text("PeriodFrom");
        $PeriodFrom->setLabel("Time period of data");
        $PeriodFrom->setFilters(['striptags', 'string']);
        $PeriodFrom->addValidators([
/**            new PresenceOf([
                'message' => 'Period From is ruquired.'
            ])  */
        ]);  
        
        $this->add($PeriodFrom);
        
        $Targetgroup = new Text("Targetgroup");
        $Targetgroup->setLabel("Target groups");
        $Targetgroup->setFilters(['striptags', 'string']);
        $Targetgroup->addValidators([
/**           new PresenceOf([
                'message' => 'Targetgroups of pages is required.'
            ]) */
        ]); 
        
        $this->add($Targetgroup);
       
        $FindingsOutcomes  = new TextArea("FindingsOutcomes ");
        $FindingsOutcomes ->setLabel("Findings and outcomes");
        $FindingsOutcomes ->setFilters(['striptags', 'string']);
        $FindingsOutcomes->setAttribute('rows', '5');
        $FindingsOutcomes ->addValidators([
        /**    new PresenceOf([
                'message' => 'Public year is ruquired.'
            ]) */
        ]);
        
        $this->add($FindingsOutcomes );
                
        $Keywords = new Text("Keywords");
        $Keywords->setLabel("Keywords");
        $Keywords->setFilters(['striptags', 'string']);
        $Keywords->addValidators([
/**            new PresenceOf([
                'message' => 'Keywords are ruquired.'
            ])*/
        ]);
        $this->add($Keywords);
                        
        $OpenAccess = new Select( "OpenAccess", [
            'YES' => 'YES',
            'NO' => 'NO'
//            'emptyText'  => 'YES',
//            'emptyValue' => ''YES','NO''
            ]);
            $OpenAccess ->setFilters(['striptags', 'string']);
               /**    new PresenceOf([
                'message' => 'Public year is ruquired.'
            ]) */
                  
        $OpenAccess ->setLabel("Open access");
        $this->add($OpenAccess );
               
        $Author = new Text("Author");
        $Author->setLabel("Author");
        $Author->setFilters(['striptags', 'string']);
        $Author->addValidators([
/**            new PresenceOf([
                'message' => 'Author is ruquired.'
            ]) */
        ]);
        $this->add($Author);
        
        $Institution = new Text("Institution");
        $Institution->setLabel("Institution");
        $Institution->setFilters(['striptags', 'string']);
        $Institution->addValidators([
/*            new PresenceOf([
                'message' => 'Institution is ruquired.'
            ]) */
        ]);
        $this->add($Institution);
        
/**        $DOI = new Text("DOI");
        $DOI->setLabel("DOI");
        $DOI->setFilters(['striptags', 'string']);
        $DOI->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) 
        ]);
                       
        $this->add($DOI); */
     
        $transitionvar = new Text("transitionvar",['disabled' => 'disabled']);
        $transitionvar->setLabel("Transition variable");
        $transitionvar->setFilters(['striptags', 'string']);
        $transitionvar->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
                       
        $this->add($transitionvar);
      
        $keywordtv = new Text("keywordtv",['disabled' => 'disabled']);
        $keywordtv->setLabel("Keyword transition variable");
        $keywordtv->setFilters(['striptags', 'string']);
        $keywordtv->addValidators([
        /**    new PresenceOf([
                'message' => 'Biblio. reference is ruquired.'
            ]) */
        ]);
                       
        $this->add($keywordtv);
        
        $category = new Select('ID_Category', Category::find(), [
            'using'      => ['ID_Category', 'CategoryName'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
   
       $category->setLabel('Document Category');
 
       $this->add($category);   
        
/**        $city = new Text("city");
        $city->setLabel("City");
        $city->setFilters(['striptags', 'string']);
        $city->addValidators([
        /**    new PresenceOf([
                'message' => 'City is ruquired.'
            ]) 
        ]);
                       
        $this->add($city); */       
    }    
      
}
