<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * ProductsController
 *
 * Manage CRUD operations for documents
 */
class DocumentresearchController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Documents');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new DocumentForm;
    }

	 /**
     * Pregled svojstava document
     */
    public function pregledAction($ID_Doc){
        
        $numberPage = 1;
        
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        

        $this->view->document  = $document;
        
        // QUERY
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        if (count($document) == 0) {
            $this->flash->notice("Document not found");
        }
        
        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
                
    }

    /**
     * Search document based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Document", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $document = Document::find($parameters);
        if (count($document) == 0) {
            $this->flash->notice("Document not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

  
    
    /**
     * Shows the form to create a new document
     */
    public function newAction()
    {
        $this->view->form = new DocumentFullForm(null, array('edit' => true));
    }

    /**
     * Edits a document based on its id
     */
    public function editAction($ID_Doc)
    {

        if (!$this->request->isPost()) {

            $document = Document::findFirst("ID_Doc = '$ID_Doc'");
            if (!$document) {
                $this->flash->error("Document not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new DocumentFullForm($document, array('edit' => true));
        }
    }
   
      public function linkscountryAction($ID_Doc){
        
        $numberPage = 1;
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doccountry = Doccountry::find("ID_Doc = '$ID_Doc'");
        if (count($doccountry) == 0) {
            $this->flash->notice("Country is not defined.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $doccountry,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
  
        $this->view->form = new CountryForm;
    }  
    
        public function countryviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doccountry = Doccountry::find("ID_Doc = '$ID_Doc'");
        if (count($doccountry) == 0) {
            $this->flash->notice("Country not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $doccountry,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
           
        $this->view->form = new CountryForm;
        
//        $queryauthor = $this->modelsManager->createQuery("SELECT * FROM Author");
//        $author  = $queryauthor->execute();         
    }
    
       public function countrysearchAction() {
        
        $numberPage = 1;
                        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Country", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $country = Country::find($parameters);
        if (count($country) == 0) {
            $this->flash->notice("Country is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "countryview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $country,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->country = $country;
    }
       
    public function countryaddAction($ID_Country){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
    
        $country = Country::findFirst($ID_Country); 
        $CountryTeritCon = $country->CountryCode;
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Country.' '.$CountryTeritCon;  */
        
        $doccountry = new Doccountry();
        
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->ID_Region = 1;
        $doccountry->ID_City = 1;  
        $doccountry->TeritCon = $CountryTeritCon;
           
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
          }
  //      }      
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function countrydeleteAction($ID_Research){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doccountry = Doccountry::findFirst($ID_Research); 
                
        if (!$doccountry->delete()) {
           
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            ); 
        
        $this->view->page = $paginator->getPaginate(); 
    }
 
        public function countryselectCityAction($ID_Research){
                      
        $this->session->set("ID_Research", "$ID_Research");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "view",
                ]
            );        
    }
    
    public function countryaddCityAction($ID_City){
       
        if ($this->session->has("ID_Research")) {
            // Retrieve its value
            $ID_Research = $this->session->get("ID_Research");
        }
        
        $city = City::findFirst($ID_City); 
        $CityTeritCon = $city->CityTeritCon;
        
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $TeritCon = $doccountry->TeritCon; 
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Region.' '.$ID_Country.' '.$ID_City ;  */
                  
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->TeritCon = $TeritCon; 
                         
//      die(var_dump($doccountry));
      
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
         
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }
    
    public function countrydelCityAction($ID_Research){
             
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $TeritCon = $doccountry->TeritCon; 
        
/**        if ( $ID_Region == 1 ){
            $country = Country::findFirst($ID_Country); 
            $TeritCon = $country->CountryTeritCon; 
        } else {
            $region = Region::findFirst($ID_Region); 
            $TeritCon = $region->RegionTeritCon; 
        }  */
            
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Doc.' '.$ID_Region.' '.$ID_Country ;  */
    
        $doccountry = new Doccountry();
        
        $doccountry->ID_Research = $ID_Research;
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->TeritCon = $TeritCon;
        $doccountry->ID_City = 1;
        
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }

      public function countryselectRegionAction($ID_Research){
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Country = $doccountry->ID_Country;
        $ID_City = $doccountry->ID_City;

/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Doc.' '.$ID_Country.' '.$ID_City;        */
        
        $this->session->set("ID_Research", "$ID_Research");
        $this->session->set("ID_Country", "$ID_Country");
        $this->session->set("ID_City", "$ID_City");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "view",
                ]
            );        
    }
    
    public function countryaddRegionAction($ID_Region){
               
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        if ($this->session->has("ID_Research")) {
            // Retrieve its value
            $ID_Research = $this->session->get("ID_Research");
        }         
           
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Country = $doccountry->ID_Country;
        $ID_City = $doccountry->ID_City;   
        $TeritCon = $doccountry->TeritCon;
        
        $region = Region::findFirst($ID_Region); 
        $TeritCon = $region->RegionTeritCon; 
                
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Research.' '.$ID_Region.' '.$ID_Country.' '.$ID_City; */
    
        $doccountry = new Doccountry();
        
        $doccountry->ID_Research = $ID_Research;
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_City = $ID_City;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->TeritCon = $TeritCon;
        
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documenresearch",
                    "action"     => "countryview",
                ]
            );
        }
      
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }

    public function countrydelRegionAction($ID_Research){
        
         if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Country = $doccountry->ID_Country;
        $ID_City = $doccountry->ID_City;
        $ID_Region = $doccountry->ID_Region;
    
        $country = Country::findFirst($ID_Country); 
        $TeritCon = $country->CountryCode; 
        
 /**       $this->view->disable();
        echo 'Hej - '.$TeritCon;  */
    
        $doccountry = new Doccountry();
        
        $doccountry->ID_Research = $ID_Research;
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = 1;
        $doccountry->ID_City = $ID_City;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->TeritCon = $TeritCon;
 
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }

    public function countryselectTeritconAction($ID_Research){
                      
        $this->session->set("ID_Research", "$ID_Research");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "view",
                ]
            );        
    }
    
    public function countryaddTeritconAction($ID_TeritCon){
       
        if ($this->session->has("ID_Research")) {
            // Retrieve its value
            $ID_Research = $this->session->get("ID_Research");
        }
        
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $ID_City = $doccountry->ID_City;   
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Region.' '.$ID_Country.' '.$ID_City ;  */
                  
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->ID_TeritCon = $ID_TeritCon; 
                         
//      die(var_dump($doccountry));
      
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
         
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }
    
    public function countrydelTeritconAction($ID_Research){
             
        $doccountry = Doccountry::findFirst($ID_Research); 
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $ID_City = $doccountry->ID_City;   
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Doc.' '.$ID_Region.' '.$ID_Country ;  */
    
        $doccountry = new Doccountry();
        
        $doccountry->ID_Research = $ID_Research;
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->ID_City = $ID_City;
        $doccountry->ID_TeritCon = 1;
        
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }
       
}

