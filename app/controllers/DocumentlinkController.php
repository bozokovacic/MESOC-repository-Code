<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * ProductsController
 *
 * Manage CRUD operations for documents
 */
class DocumentlinkController extends ControllerBase
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
        
        // UPIT U DJELOVODSTVO
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
  
       public function linksauthorAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
 
        $this->view->document  = $document;
    
        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");
        if (count($docauthor) == 0) {
            $this->flash->notice("Author not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $docauthor,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->form = new AuthorForm;
    }
      
     public function authorviewAction($ID_Doc){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");
        if (count($docauthor) == 0) {
            $this->flash->notice("Author not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $docauthor,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
           
        $this->view->form = new AuthorForm;
        
//        $queryauthor = $this->modelsManager->createQuery("SELECT * FROM Author");
//        $author  = $queryauthor->execute();   
        
    }
    
       public function authorsearchAction($ID_Doc){
        
        $numberPage = 1;
                        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Author", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $author = Author::find($parameters);
        if (count($author) == 0) {
            $this->flash->notice("Author is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $author,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->author = $author;
    }
    
    public function authoraddAction($ID_Author){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Author;  */
        
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
        $docauthor->ID_Institution = 1;
        $docauthor->ID_Country = 1;
        
        if ($docauthor->save() == false) {            
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }

        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");

        $author_list = '';
        
        if ( count($docauthor) != 0) {
            $i = 0;
            foreach ($docauthor as $docaut){
                $ID_Author = $docaut->ID_Author;
                $author = Author::find(" ID_Author = '$ID_Author'");                
                foreach ($author as $aut){
                    $LastName = $aut->LastName;
                    $FirstName = $aut->FirstName;
                    $MiddleName = $aut->MiddleNameInitial;
                    echo $LastName.' '.$FirstName.' '.$MiddleName.'<BR>';
                    $i++;
                    if ($i == 1) {
                        $author_list = $author_list.$LastName;
                        if ( $FirstName != '-----') $author_list = $author_list.', '.$FirstName;
                        if ( $MiddleName != '-----') $author_list = $author_list.', '.$MiddleName;                        
                    } else {
                        $author_list = $author_list.'; '.$LastName;
                        if ( $FirstName != '-----') $author_list = $author_list.', '.$FirstName;
                        if ( $MiddleName != '-----') $author_list = $author_list.', '.$MiddleName;                        
                    }
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Author = $author_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
    
    public function authorselectInstAction($ID_Author){
        
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $this->session->set("ID_Author", "$ID_Author");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "view",
                ]
            );        
    }
    
    public function authoraddInstAction($ID_Institution){
        
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        if ($this->session->has("ID_Author")) {
            // Retrieve its value
            $ID_Author = $this->session->get("ID_Author");
        }
        
        $institution = Institution::findFirst("ID_Institution = '$ID_Institution'");
        
        $ID_Country = $institution->ID_Country;
        
/**                $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Author.' '.$ID_Institution.' '.$ID_Country; */
    
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
        $docauthor->ID_Institution = $ID_Institution;
        $docauthor->ID_Country = $ID_Country;
        
        if ($docauthor->save() == false) {            
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }
      
            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );        
    }
    
     public function authordelInstAction($ID_Author){
        
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
         
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Author;  */
    
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
        $docauthor->ID_Institution = 1;
        $docauthor->ID_Country = 1;
        
        if ($docauthor->save() == false) {            
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }

               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );        
    }
    
     public function authorselectCountryAction($ID_Author){
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $this->session->set("ID_Author", "$ID_Author");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "view",
                ]
            );        
    }
    
    public function authoraddCountryAction($ID_Country){
        
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        if ($this->session->has("ID_Author")) {
            // Retrieve its value
            $ID_Author = $this->session->get("ID_Author");
        }
                            
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Author.' '.$ID_Country; */
    
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
        $docauthor->ID_Institution = 1;
        $docauthor->ID_Country = $ID_Country;
        
        if ($docauthor->save() == false) {            
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }

               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );        
    }
    
    public function authordelCountryAction($ID_Author){
        
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
         
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Author;  */
    
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
        $docauthor->ID_Institution = 1;
        $docauthor->ID_Country = 1;
        
        if ($docauthor->save() == false) {            
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }
             
            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );        
    }
    
    public function authordeleteAction($ID_Author){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
          
        $docauthor = new Docauthor();
        
        $docauthor->ID_Doc = $ID_Doc;
        $docauthor->ID_Author = $ID_Author;
                
        if (!$docauthor->delete()) {
            foreach ($docauthor->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            );
        }

        $docauthor = Docauthor::find("ID_Doc = '$ID_Doc'");

        $author_list = '';
        $i = 0;
         
        if ( count($docauthor) != 0) {
            $i = 0;
            foreach ($docauthor as $docaut){
            $ID_Author = $docaut->ID_Author;
            $author = Author::find(" ID_Author = '$ID_Author'"); 
                foreach ($author as $aut){
                    $LastName = $aut->LastName;
                    $FirstName = $aut->FirstName;
                    $MiddleName = $aut->MiddleNameInitial;
                    //  echo $LastName.' '.$FirstName.' '.$MiddleName.'<BR>';
                    $i++;
                    if ($i == 1) {
                        $author_list = $author_list.$LastName;
                        if ( $FirstName != '-----') $author_list = $author_list.', '.$FirstName;
                        if ( $MiddleName != '-----') $author_list = $author_list.', '.$MiddleName;                        
                    } else {
                        $author_list = $author_list.'; '.$LastName;
                        if ( $FirstName != '-----') $author_list = $author_list.', '.$FirstName;
                        if ( $MiddleName != '-----') $author_list = $author_list.', '.$MiddleName;                        
                    }
                }
            }    
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Author = $author_list;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }       
                  
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "authorview",
                ]
            ); 
        
        $this->view->page = $paginator->getPaginate(); 
    }
           
    public function linksrelevanceAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docrelevance = Docrelevance::find("ID_Doc = '$ID_Doc'");
        if (count($docrelevance) == 0) {
            $this->flash->notice("Relevance not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docrelevance,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new RelevanceForm;
        
    }
    
       public function relevanceviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docrelevance = Docrelevance::find("ID_Doc = '$ID_Doc'");
        if (count($docrelevance) == 0) {
            $this->flash->notice("Relevance not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docrelevance,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function relevancesearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Relevance", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $relevance = Relevance::find($parameters);
        if (count($relevance) == 0) {
            $this->flash->notice("Relevance is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "relevanceview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $relevance,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->relevance = $relevance;
    }

    public function relevanceaddAction($ID_Relevance){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docrelevance = new Docrelevance();
           
        $docrelevance->ID_Doc = $ID_Doc;
        $docrelevance->ID_Relevance = $ID_Relevance;
        
     
        $docrelevance->ID_Relevance = $ID_Relevance;
        
        if ($docrelevance->save() == false) {            
            foreach ($docrelevance->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "relevanceview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "relevanceview",
                ]
            );      
    }
    
      public function relevancedeleteAction($ID_Relevance){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docrelevance = new Docrelevance();
        
        $docrelevance->ID_Doc = $ID_Doc;
        $docrelevance->ID_Relevance = $ID_Relevance;
        
        if (!$docrelevance->delete()) {
            foreach ($docrelevance->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "relevanceview",
                ]
            );
        }
           
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "relevanceview",
                ]
            ); 
    }

//---  SEARCH DATABASE
    
    public function linksSearchdatabaseAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsearchdatabase = Docsearchdatabase::find("ID_Doc = '$ID_Doc'");
        if (count($docsearchdatabase) == 0) {
            $this->flash->notice("Technique not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsearchdatabase,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new SearchdatabaseForm;
        
    }
    
      public function searchdatabasesearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Searchdatabase", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $searchdatabase = Searchdatabase::find($parameters);
        if (count($searchdatabase) == 0) {
            $this->flash->notice("Searchdatabase is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "searchdatabaseview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $searchdatabase,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->searchdatabase = $searchdatabase;
    }

    
    public function searchdatabaseaddAction($ID_Database){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsearchdatabase = new Docsearchdatabase();
   
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Database;     */
        
        $docsearchdatabase->ID_Doc = $ID_Doc;
        $docsearchdatabase->ID_Database = $ID_Database;
        
        if ($docsearchdatabase->save() == false) {            
            foreach ($docsearchdatabase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "searchdatabaseview",
                ]
            );
        }

        $docsearchdatabase = Docsearchdatabase::find("ID_Doc = '$ID_Doc'");

        $searchdatabase_list = '';
        $i = 0;
         
        if ( count($docsearchdatabase) != 0) {
            $i = 0;
            foreach ($docsearchdatabase as $docsearch){
            $ID_Database = $docsearch->ID_Database;
            $searchdatabase = Searchdatabase::find(" ID_Database =  '$ID_Database'"); 
                foreach ($searchdatabase as $search){
                    $SearchDatabase = $search->SearchDatabase;
                    $i++;
//                    echo $SearchDatabase.'<BR>';
                    if ($i == 1) $searchdatabase_list = $searchdatabase_list.$SearchDatabase;
                    else  $searchdatabase_list = $searchdatabase_list.'; '.$SearchDatabase;                        
                }
            }    
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Searchdatabase = $searchdatabase_list;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }        
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "searchdatabaseview",
                ]
            );
        
    }
    
        public function searchdatabaseviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsearchdatabase = Docsearchdatabase::find("ID_Doc = '$ID_Doc'");
        if (count($docsearchdatabase) == 0) {
            $this->flash->notice("Technique not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsearchdatabase,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new SearchdatabaseForm;
        
    }

      public function searchdatabasedeleteAction($ID_Database){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsearchdatabase = new Docsearchdatabase();
        
        $docsearchdatabase->ID_Doc = $ID_Doc;
        $docsearchdatabase->ID_Database = $ID_Database;
        
        if (!$docsearchdatabase->delete()) {
            foreach ($docsearchdatabase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "searchdatabaseview",
                ]
            );
        }
        
        $docsearchdatabase = Docsearchdatabase::find("ID_Doc = '$ID_Doc'");

        $searchdatabase_list = '';
        $i = 0;
         
        if ( count($docsearchdatabase) != 0) {
            $i = 0;
            foreach ($docsearchdatabase as $docsearch){
            $ID_Database = $docsearch->ID_Database;
            $searchdatabase = Searchdatabase::find(" ID_Database =  '$ID_Database'"); 
                foreach ($searchdatabase as $search){
                    $SearchDatabase = $search->SearchDatabase;
                    $i++;
//                    echo $SearchDatabase.'<BR>';
                    if ($i == 1) $searchdatabase_list = $searchdatabase_list.$SearchDatabase;
                    else  $searchdatabase_list = $searchdatabase_list.'; '.$SearchDatabase;                        
                }
            }    
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Searchdatabase = $searchdatabase_list;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "searchdatabaseview",
                ]
            ); 
    }

//--- TECNIQUE
    
        public function linkstechniqueAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doctechnique = Doctechnique::find("ID_Doc = '$ID_Doc'");
        if (count($doctechnique) == 0) {
            $this->flash->notice("Technique not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doctechnique,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
       public function techniqueviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doctechnique = Doctechnique::find("ID_Doc = '$ID_Doc'");
        if (count($doctechnique) == 0) {
            $this->flash->notice("Technique not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doctechnique,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
       }

        public function techniquesearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Technique", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $technique = Technique::find($parameters);
        if (count($technique) == 0) {
            $this->flash->notice("Technique is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "techniqueview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $technique,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->technique = $technique;
   
        }

   public function techniqueaddAction($ID_Technique){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doctechnique = new Doctechnique();
        
        $doctechnique->ID_Doc = $ID_Doc;
        $doctechnique->ID_Technique = $ID_Technique;
        
        if ($doctechnique->save() == false) {            
            foreach ($doctechnique->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "techniqueview",
                ]
            );
        }
        
        $doctechnique = Doctechnique::find("ID_Doc = '$ID_Doc'");

        $technique_list = '';
        
        if ( count($doctechnique) != 0) {
            $i = 0;
            foreach ($doctechnique as $docteh){
                $ID_Technique = $docteh->ID_Technique;
                $technique = Technique::find(" ID_Technique = '$ID_Technique'");                
                foreach ($technique as $teh){
                    $TechniqueName = $teh->TechniqueName;
                    echo $TechniqueName.'<BR>';
                    $i++;
                    if ($i == 1) $technique_list = $technique_list.$TechniqueName;                        
                    if ( $i > 1 ) $technique_list = $technique_list.'; '.$TechniqueName;                    
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Technique = $technique_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
                    
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "techniqueview",
                ]
            );
        
    }
    
      public function techniquedeleteAction($ID_Technique){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doctechnique = new Doctechnique();
        
        $doctechnique->ID_Doc = $ID_Doc;
        $doctechnique->ID_Technique = $ID_Technique;
        
        if (!$doctechnique->delete()) {
            foreach ($doctechnique->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "techniqueview",
                ]
            );
        }
        
        $doctechnique = Doctechnique::find("ID_Doc = '$ID_Doc'");

        $technique_list = '';
        $i = 0;
         
        if ( count($doctechnique) != 0) {
            $i = 0;
            foreach ($doctechnique as $docteh){
            $ID_Technique = $docteh->ID_Technique;
            $technique = Technique::find(" ID_Technique=  '$ID_Technique'"); 
                foreach ($technique as $teh){
                    $TechniqueName = $teh->TechniqueName;
                    $i++;
                    echo $TechniqueName.'<BR>';
                    if ($i == 1) $technique_list = $technique_list.$TechniqueName;
                    else  $technique_list = $technique_list.'; '.$TechniqueName;                        
                }
            }    
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Technique = $technique_list;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
            
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "techniqueview",
                ]
            ); 
    }

// --- BENEFICIARY
    
        public function linksbeneficiaryAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docbeneficiary = Docbeneficiary::find("ID_Doc = '$ID_Doc'");
        if (count($docbeneficiary) == 0) {
            $this->flash->notice("Beneficiary not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docbeneficiary,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new BeneficiaryForm;
        
    }
    
       public function beneficiaryviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docbeneficiary = Docbeneficiary::find("ID_Doc = '$ID_Doc'");
        if (count($docbeneficiary) == 0) {
            $this->flash->notice("Beneficiary not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docbeneficiary,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new BeneficiaryForm;
        
    }
    
        public function beneficiarysearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
               
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Beneficiary", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $beneficiary = Beneficiary::find($parameters);
        if (count($beneficiary) == 0) {
            
            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "linksbeneficiary",
                ]
            );
        }
        
        $paginator = new Paginator([
            "data"  => $beneficiary,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->beneficiary = $beneficiary;
   
        }

    public function beneficiaryaddAction($ID_Beneficiary){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docbeneficiary = new Docbeneficiary();
        
        $docbeneficiary->ID_Doc = $ID_Doc;
        $docbeneficiary->ID_Beneficiary = $ID_Beneficiary;
        
        if ($docbeneficiary->save() == false) {            
            foreach ($docbeneficiary->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "beneficiaryview",
                ]
            );
        }
                    
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "beneficiaryview",
                ]
            );
        
    }
    
      public function beneficiarydeleteAction($ID_Beneficiary){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docbeneficiary = new Docbeneficiary();
        
        $docbeneficiary->ID_Doc = $ID_Doc;
        $docbeneficiary->ID_Beneficiary = $ID_Beneficiary;
        
        if (!$docbeneficiary->delete()) {
            foreach ($docbeneficiary->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "beneficiaryview",
                ]
            );
        }
/**        $this->view->disable();
        echo 'Hej - '.$ID_Doc.' '.$ID_Beneficiary; */       
            
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "beneficiaryview",
                ]
            ); 
    }    
    
// --- LITAERATURE AREA
    
    public function linkslitareaAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doclitarea = Doclitarea::find("ID_Doc = '$ID_Doc'");
        if (count($doclitarea) == 0) {
            $this->flash->notice("Litarea not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doclitarea,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new LitareaForm;
        
    }
    
       public function litareaviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doclitarea = Doclitarea::find("ID_Doc = '$ID_Doc'");
        if (count($doclitarea) == 0) {
            $this->flash->notice("Litarea not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doclitarea,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function litareasearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Litarea", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $litarea = Litarea::find($parameters);
        if (count($litarea) == 0) {
            $this->flash->notice("Litarea is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "litareaview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $litarea,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->litarea = $litarea;
    }

    public function litareaaddAction($ID_LitArea){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doclitarea = new Doclitarea();
           
        $doclitarea->ID_Doc = $ID_Doc;
        $doclitarea->ID_LitArea = $ID_LitArea;
        
     
        $doclitarea->ID_LitArea = $ID_LitArea;
        
        if ($doclitarea->save() == false) {            
            foreach ($doclitarea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "litareaview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "litareaview",
                ]
            );      
    }
    
      public function litareadeleteAction($ID_LitArea){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doclitarea = new Doclitarea();
        
        $doclitarea->ID_Doc = $ID_Doc;
        $doclitarea->ID_LitArea = $ID_LitArea;
        
        if (!$doclitarea->delete()) {
            foreach ($doclitarea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "litareaview",
                ]
            );
        }
           
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "litareaview",
                ]
            ); 
    }

//    DATA PROVIDER

 public function linksdataprovAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docdataprov = Docdataprov::find("ID_Doc = '$ID_Doc'");
        if (count($docdataprov) == 0) {
            $this->flash->notice("Data provider not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docdataprov,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new DataprovForm;
        
    }
    
       public function dataprovviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docdataprov = Docdataprov::find("ID_Doc = '$ID_Doc'");
        if (count($docdataprov) == 0) {
            $this->flash->notice("Data provider not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docdataprov,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function dataprovsearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Dataprov", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $dataprov = Dataprov::find($parameters);
        if (count($dataprov) == 0) {
            $this->flash->notice("Data provider is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "dataprovview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $dataprov,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->dataprov = $dataprov;
    }

    public function dataprovaddAction($ID_DataProv){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docdataprov = new Docdataprov();
           
        $docdataprov->ID_Doc = $ID_Doc;
        $docdataprov->ID_DataProv = $ID_DataProv;
        
     
        $docdataprov->ID_DataProv = $ID_DataProv;
        
        if ($docdataprov->save() == false) {            
            foreach ($docdataprov->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "dataprovview",
                ]
            );
        }
        
        $docdataprov = Docdataprov::find("ID_Doc = '$ID_Doc'");

        $dataprov_list = '';
        
        if ( count($docdataprov) != 0) {
            $i = 0;
            foreach ($docdataprov as $docprov){
                $ID_DataProv = $docprov->ID_DataProv;
                $dataprov = Dataprov::find(" ID_DataProv = '$ID_DataProv'");                
                foreach ($dataprov as $prov){
                    $DataProvName = $prov->DataProvName;
//                    echo $DataProvName.'<BR>';
                    $i++;
                    if ($i == 1) $dataprov_list = $dataprov_list.$DataProvName;                        
                    if ( $i > 1 ) $dataprov_list = $dataprov_list.'; '.$DataProvName;                    
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->DataProviders = $dataprov_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "dataprovview",
                ]
            );      
    }
    
      public function dataprovdeleteAction($ID_DataProv){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docdataprov = new Docdataprov();
        
        $docdataprov->ID_Doc = $ID_Doc;
        $docdataprov->ID_DataProv = $ID_DataProv;
        
        if (!$docdataprov->delete()) {
            foreach ($docdataprov->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "dataprovview",
                ]
            );
        }

        $docdataprov = Docdataprov::find("ID_Doc = '$ID_Doc'");

        $dataprov_list = '';
        
        if ( count($docdataprov) != 0) {
            $i = 0;
            foreach ($docdataprov as $docprov){
                $ID_DataProv = $docprov->ID_DataProv;
                $dataprov = Dataprov::find(" ID_DataProv = '$ID_DataProv'");                
                foreach ($dataprov as $prov){
                    $DataProvName = $prov->DataProvName;
//                    echo $DataProvName.'<BR>';
                    $i++;
                    if ($i == 1) $dataprov_list = $dataprov_list.$DataProvName;                        
                    if ( $i > 1 ) $dataprov_list = $dataprov_list.'; '.$DataProvName;                    
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->DataProviders = $dataprov_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }        
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "dataprovview",
                ]
            ); 
    }    
 
//   SECTOR
    
    public function linkssectorAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsector = Docsector::find("ID_Doc = '$ID_Doc'");
        if (count($docsector) == 0) {
            $this->flash->notice("Sector not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsector,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new SectorForm;
        
    }
    
       public function sectorviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsector = Docsector::find("ID_Doc = '$ID_Doc'");
        if (count($docsector) == 0) {
            $this->flash->notice("Sector not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsector,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function sectorsearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Sector", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $sector = Sector::find($parameters);
        if (count($sector) == 0) {
            $this->flash->notice("Sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $sector,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->sector = $sector;
    }

    public function sectoraddAction($ID_Sector){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsector = new Docsector();
           
        $docsector->ID_Doc = $ID_Doc;
        $docsector->ID_Sector = $ID_Sector;
        
     
        $docsector->ID_Sector = $ID_Sector;
        
        if ($docsector->save() == false) {            
            foreach ($docsector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );      
    }
    
      public function sectordeleteAction($ID_Sector){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsector = new Docsector();
        
        $docsector->ID_Doc = $ID_Doc;
        $docsector->ID_Sector = $ID_Sector;
        
        if (!$docsector->delete()) {
            foreach ($docsector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }
           
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            ); 
    }

//   INSTITUTION
    
     public function linksinstitutionAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");
        if (count($docinstitution) == 0) {
            $this->flash->notice("Institution not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docinstitution,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new InstitutionForm;
        
    }
    
       public function institutionviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");
        if (count($docinstitution) == 0) {
            $this->flash->notice("Institution not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docinstitution,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new InstitutionForm;
        
    }
    
   public function institutionsearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Institution", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $institution = Institution::find($parameters);
        if (count($institution) == 0) {
            $this->flash->notice("Institution is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $institution,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->institution = $institution;
    }

    public function institutionaddAction($ID_Institution){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docinstitution = new Docinstitution();
           
        $docinstitution->ID_Doc = $ID_Doc;
        
        $docinstitution->ID_Institution = $ID_Institution;
        
        $docinstitution->ID_Institution = $ID_Institution;
        
        if ($docinstitution->save() == false) {            
            foreach ($docinstitution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }
        
       $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");

        $institution_list = '';
        
        if ( count($docinstitution) != 0) {
            $i = 0;
            foreach ($docinstitution as $docinst){
                $ID_Institution = $docinst->ID_Institution;
                $institution = Institution::find(" ID_Institution = '$ID_Institution'");
                foreach ($institution as $inst){
                    $InstName = $inst->InstName;
                    $i++;
                    if ($i == 1) {
                        $institution_list = $institution_list.$InstName;
                    } else {
                        $institution_list = $institution_list.'; '.$InstName;
                    }
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Institution = $institution_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );      
    }
    
      public function institutiondeleteAction($ID_Institution){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docinstitution = new Docinstitution();
        
        $docinstitution->ID_Doc = $ID_Doc;
        $docinstitution->ID_Institution = $ID_Institution;
        
        if (!$docinstitution->delete()) {
            foreach ($docinstitution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }
         
        $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");

        $institution_list = '';
        
        if ( count($docinstitution) != 0) {
            $i = 0;
            foreach ($docinstitution as $docinst){
                $ID_Institution = $docinst->ID_Institution;
                $institution = Institution::find(" ID_Institution = '$ID_Institution'");
                foreach ($institution as $inst){
                    $InstName = $inst->InstName;
                    $i++;
                    if ($i == 1) {
                        $institution_list = $institution_list.$InstName;
                    } else {
                        $institution_list = $institution_list.'; '.$InstName;
                    }
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->Institution = $institution_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            ); 
    }
    

//   CITY
    
     public function linkscityAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");
        if (count($doccity) == 0) {
            $this->flash->notice("City not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doccity,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new CityForm;
        
    }
    
       public function cityviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");
        if (count($doccity) == 0) {
            $this->flash->notice("City not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $doccity,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new CityForm;
        
    }
    
   public function citysearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "City", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $city = City::find($parameters);
        if (count($city) == 0) {
            $this->flash->notice("City is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "cityview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $city,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->institution = $city;
    }

    public function cityaddAction($ID_City){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doccity = new Doccity();
           
        $doccity->ID_Doc = $ID_Doc;
        
        $doccity->ID_City = $ID_City;
        
        if ($doccity->save() == false) {            
            foreach ($doccity->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "cityview",
                ]
            );
        }
        
       $doccity = Doccity::find("ID_Doc = '$ID_Doc'");

        $city_list = '';
        
        if ( count($doccity) != 0 ) {
            $i = 0;
            foreach ($doccity as $doccity_data){
                $ID_City = $doccity_data->ID_City;
                $city = City::find(" ID_City = '$ID_City'");
                foreach ($city as $city_data){
                    $CityName = $city_data->CityName;
                    $i++;
                    if ($i == 1) {
                        $city_list = $city_list.$CityName;
                    } else {
                        $city_list = $city_list.'; '.$CityName;
                    }
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->city = $city_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "cityview",
                ]
            );      
    }
    
      public function citydeleteAction($ID_City){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $doccity = new Doccity();
        
        $doccity->ID_Doc = $ID_Doc;
        $doccity->ID_City = $ID_City;
        
        if (!$doccity->delete()) {
            foreach ($doccity->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "cityview",
                ]
            );
        }
         
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");

        $city_list = '';
        
        if ( count($doccity) != 0) {
            $i = 0;
            foreach ($doccity as $doccity_data){
                $ID_City = $doccity_data->ID_City;
                $city = City::find(" ID_City = '$ID_City'");
                foreach ($city as $city_data){
                    $CityName = $city_data->CityName;
                    $i++;
                    if ($i == 1) {
                        $city_list = $city_list.$CityName;
                    } else {
                        $city_list = $city_list.'; '.$CityName;
                    }
                }
            }
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->city = $city_list;
//        die(var_dump($document));
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
        }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "cityview",
                ]
            ); 
    }    
    
    public function linkscultdomainsocimpactAction(){
               
        $numberPage = 1;
       
         if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docinstitution = new Docinstitution();
        
//        $keyword = $this->dispatcher->getParam("keyword");
            
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
//        die(var_dump($keyword));
        
//        $culturaldomain = CulturalDomain::find();

        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $documentcultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';        
                           
            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $documentculturaldomain = Documentculturaldomain::find("(ID_Doc = '$ID_Doc' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($documentculturaldomain) > 0) {
                    $documentcultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/documentlink/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural sector <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $documentcultview .= '<td></td><td width="7%"><a href="/documentlink/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural sector </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
          }
        }   

            $documentcultview .=  '</tbody></table>';            
             
        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $documentsocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';        
                           
            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
           
/**              $this->view->disable();
              echo "Evo".$ID_Doc." ".$ID_SocImpact;  */
        
              $documentsocialimpact = Documentsocialimpact::find("(ID_Doc = '$ID_Doc' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($documentsocialimpact) > 0) {
                    $documentsocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/documentlink/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cross-over theme <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $documentsocview .= '<td></td><td width="7%"><a href="/documentlink/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cross-over theme </a></td><td>'.$SocImpactName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $documentsocview .=  '</tbody></table>';        
      
//            echo $documentcultview.'<BR>';    
//            echo $documentsocview.'<BR>';
            
            $document->Documentcultdomainview = $documentcultview;
            $document->Documentsocimpactview = $documentsocview;
  
          
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "documentcultdomainsocimpact",
                ]
            );
        }
        
        $documentculturaldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
        
        $paginator = new Paginator(array(
            "data"  => $documentculturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }      
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
       
        $documentculturaldomain = new Documentculturaldomain();
        
        $documentculturaldomain->ID_Doc = $ID_Doc;
        $documentculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($documentculturaldomain->save() == false) {            
            foreach ($documentculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
          }
        
        $keywords = $document->Keywords;
        
        $keywords = explode(";",$document->Keywords);
        
        foreach ($keywords as $keyword_name){
         
            $keyword_name = trim($keyword_name);
            $keyword = Keyword::findFirst(" KeywordName = '$keyword_name'");
            $ID_Keyword = $keyword->ID_Keyword;
            
            if (strlen($keyword_name) > 0) {  

               $keywordculturaldomain = Keywordculturaldomain::find("(ID_Keyword = '$ID_Keyword' AND ID_CultDomain ='$ID_CultDomain')");
               
               if ( count($keywordculturaldomain) == 0) {
                        $keywordculturaldomain = new Keywordculturaldomain();
                        $keywordculturaldomain->ID_Keyword = $ID_Keyword;
                        $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;                      
                        if ($keywordculturaldomain->save() == false) {
                          foreach ($keywordculturaldomain->getMessages() as $message) {
                             $this->flash->error($message);
                          }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "edit",
                            ]
                        );
                      }   
                   }
               }
            }
        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
               
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
       
        $documentculturaldomain = new Documentculturaldomain();
        
        $documentculturaldomain->ID_Doc = $ID_Doc;
        $documentculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($documentculturaldomain->delete() == false) {            
            foreach ($documentculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
          }
          
        $keywords_document = explode(";",$document->Keywords);  
        $ID_Doc_keywords = $document->ID_Doc;  
    
        foreach ( $keywords_document as $keyword_document) {
            
            $keyword_document = trim($keyword_document);
            $keyword_doc = Keyword::findFirst(" KeywordName = '$keyword_document'");
            $ID_Keyword_document = $keyword_doc->ID_Keyword;
            
            $document = Document::find();
            
            $i  = 0;
            foreach ( $document as $doc ) {
        
                  $doc_id   = $doc->ID_Doc;
                
                  $keywords = explode(";",$doc->Keywords);
        
                  foreach ($keywords as $keyword_name){
            
                    $keyword_name = trim($keyword_name);
                
                    if ( $keyword_document == $keyword_name ) { 
                
                        $keyword = Keyword::findFirst(" KeywordName = '$keyword_name'");
                        $ID_Keyword = $keyword->ID_Keyword;
            
                        if (strlen($keyword_name) > 0) {  

                            $docculturaldomain = Documentculturaldomain::find("(ID_Doc = '$ID_Doc' AND ID_CultDomain ='$ID_CultDomain')");
               
                            if ( count($docculturaldomain) != 0 ) {
                                if  ( $ID_Doc != $doc_id ) {
                                    $i = 1;
                                }
                            }  
                        }
                    }    
                }
            }    
                        
            if ( $i == 0 ){
                
                $keywordculturaldomain = new Keywordculturaldomain();
                $keywordculturaldomain->ID_Keyword = $ID_Keyword_document;
                $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;
                if ($keywordculturaldomain->delete() == false) {            
                    foreach ($keywordculturaldomain->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentlink",
                            "action"     => "linkscultdomainsocimpact", 
                        ]
                    );
                }    
            }
          
        }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Document;  */
        
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
       
        $documentsocialimpact = new Documentsocialimpact();
        
        $documentsocialimpact->ID_Doc = $ID_Doc;
        $documentsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($documentsocialimpact->save() == false) {            
            foreach ($documentsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
          }
        
        $keywords = $document->Keywords;
        
        $keywords = explode(";",$document->Keywords);
        
        foreach ($keywords as $keyword_name){
         
            $keyword_name = trim($keyword_name);
            $keyword = Keyword::findFirst(" KeywordName = '$keyword_name'");
            $ID_Keyword = $keyword->ID_Keyword;
            
            if (strlen($keyword_name) > 0) {  

               $keywordsocialimpact = Keywordsocialimpact::find("(ID_Keyword = '$ID_Keyword' AND ID_SocImpact ='$ID_SocImpact')");
               
               if ( count($keywordsocialimpact) == 0) {
                        $keywordsocialimpact = new Keywordsocialimpact();
                        $keywordsocialimpact->ID_Keyword = $ID_Keyword;
                        $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;                      
                        if ($keywordsocialimpact->save() == false) {
                          foreach ($keywordsocialimpact->getMessages() as $message) {
                             $this->flash->error($message);
                          }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "edit",
                            ]
                        );
                      }   
                   }
               }
            }  
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
               
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
       
        $documentsocialimpact = new Documentsocialimpact();
        
        $documentsocialimpact->ID_Doc = $ID_Doc;
        $documentsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($documentsocialimpact->delete() == false) {            
            foreach ($documentsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
          }
          
        $keywords_document = explode(";",$document->Keywords);  
        $ID_Doc_keywords = $document->ID_Doc;  
    
        foreach ( $keywords_document as $keyword_document) {
            
            $keyword_document = trim($keyword_document);
            $keyword_doc = Keyword::findFirst(" KeywordName = '$keyword_document'");
            $ID_Keyword_document = $keyword_doc->ID_Keyword;
            
            $document = Document::find();
            
            $i  = 0;
            foreach ( $document as $doc ) {
        
                $doc_id   = $doc->ID_Doc;

                  $keywords = explode(";",$doc->Keywords);
        
                  foreach ($keywords as $keyword_name){
            
                    $keyword_name = trim($keyword_name);

                    if ( $keyword_document == $keyword_name ) { 

                        $keyword = Keyword::findFirst(" KeywordName = '$keyword_name'");
                        $ID_Keyword = $keyword->ID_Keyword;
            
                        if (strlen($keyword_name) > 0) {  

                            $docsocialimpact = Documentsocialimpact::find("(ID_Doc = '$doc_id' AND ID_SocImpact ='$ID_SocImpact')");

                            if ( count($docsocialimpact) != 0 ) {
                                if  ( $ID_Doc != $doc_id ) {
                                    $i = 1;
                                }
                            }  
                        }
                    }    
                }
            }                         
            if ( $i == 0 ){
                
                $keywordsocialimpact = new Keywordsocialimpact();
                $keywordsocialimpact->ID_Keyword = $ID_Keyword_document;
                $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;
                if ($keywordsocialimpact->delete() == false) {            
                    foreach ($keywordsocialimpact->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentlink",
                            "action"     => "linkscultdomainsocimpact", 
                        ]
                    );
                }    
            }
          
        } 
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "linkscultdomainsocimpact",
                    
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }    
    
}

