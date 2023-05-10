<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SearchdatabaseController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Searchdatabase');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new SearchdatabaseForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
                    "controller" => "searchdatabase",
                    "action"     => "index",
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

     public function viewAction()
    {
        $numberPage = 1;
        
        $searchdatabase = Searchdatabase::find(
                [    
                 'order'      => 'ID_Database',   
                ]
                );
        if (count($searchdatabase) == 0) {
            $this->flash->notice("Searchdatabase is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
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
    
    /**
     * Shows the form to create a new searchdatabase
     */
    public function newAction()
    {
       $this->view->form = new SearchdatabaseForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Database)
    {

        if (!$this->request->isPost()) {

            $searchdatabase = Searchdatabase::findFirst("ID_Database = '$ID_Database'");
            if (!$searchdatabase) {
                $this->flash->error("Searchdatabase not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "searchdatabase",
                        "action"     => "view",
                    ]
                );
            }

            $this->view->form = new SearchdatabaseForm($searchdatabase, ['edit' => true]);
        }
    }

    /**
     * Creates a new vlafon
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
                ]
            );
        }

        $form = new SearchdatabaseForm;
        $searchdatabase = new Searchdatabase();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $searchdatabase)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "new",
                ]
            );
        }

        if ($searchdatabase->save() == false) {
            foreach ($searchdatabase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Search database successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "searchdatabase",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Database
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
                ]
            );
        }

        $ID_Database = $this->request->getPost("ID_Database", "string");

        $searchdatabase = Searchdatabase::findFirst("ID_Database = '$ID_Database'");
        if (!$searchdatabase) {
            $this->flash->error("Search database does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
                ]
            );
        }

        $form = new SearchdatabaseForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $searchdatabase)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "new",
                ]
            );
        }

        if ($searchdatabase->save() == false) {
			
            foreach ($searchdatabase->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Search database successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "searchdatabase",
                "action"     => "view",
            ]
        );
    }

      public function deleteAction($ID_Database)
    {
         
       $searchdatabase = Searchdatabase::findFirst("ID_Database = '$ID_Database'");
        
       $this->view->form = new SearchdatabaseForm($searchdatabase, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Database = $this->request->getPost("ID_Database", "string");

/**        $this->view->disable();
        echo "Evo".$SearchdatabaseName." ".$ID_Database;   */
        
        $searchdatabase = Searchdatabase::findFirst("ID_Database = '$ID_Database'");
        if (!$searchdatabase) {
            $this->flash->error("Searchdatabase not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
                ]
            );
        }  

        if (!$searchdatabase->delete()) {
            foreach ($searchdatabase->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "searchdatabase",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Searchdatabase deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "searchdatabase",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new SearchdatabaseForm;
        $this->view->form = new SearchdatabaseForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "searchdatabase",
                "action"     => "index",
            ]  
        );  
    }  
    
}
