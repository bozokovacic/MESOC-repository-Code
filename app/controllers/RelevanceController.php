<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RelevanceController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Relevance');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new RelevanceForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
                    "controller" => "relevance",
                    "action"     => "index",
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

     public function viewAction()
    {
        $numberPage = 1;
        
        $relevance = Relevance::find(
                [    
                 'order'      => 'ID_Relevance',   
                ]
                );
        if (count($relevance) == 0) {
            $this->flash->notice("Relevance is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "index",
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
    
    /**
     * Shows the form to create a new relevance
     */
    public function newAction()
    {
       $this->view->form = new RelevanceForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Relevance)
    {

        if (!$this->request->isPost()) {

            $relevance = Relevance::findFirst("ID_Relevance = '$ID_Relevance'");
            if (!$relevance) {
                $this->flash->error("Relevance not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "relevance",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new RelevanceForm($relevance, ['edit' => true]);
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
                    "controller" => "relevance",
                    "action"     => "index",
                ]
            );
        }

        $form = new RelevanceForm;
        $relevance = new Relevance();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $relevance)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "new",
                ]
            );
        }

        if ($relevance->save() == false) {
            foreach ($relevance->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Relevance successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "relevance",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Relevance
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "index",
                ]
            );
        }

        $ID_Relevance = $this->request->getPost("ID_Relevance", "string");

        $relevance = Relevance::findFirst("ID_Relevance = '$ID_Relevance'");
        if (!$relevance) {
            $this->flash->error("Relevance does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "index",
                ]
            );
        }

        $form = new RelevanceForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $relevance)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "new",
                ]
            );
        }

        if ($relevance->save() == false) {
			
            foreach ($relevance->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Relevance successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "relevance",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Relevance)
    {
         
       $relevance = Relevance::findFirst("ID_Relevance = '$ID_Relevance'");
        
       $this->view->form = new RelevanceForm($relevance, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Relevance = $this->request->getPost("ID_Relevance", "string");

/**        $this->view->disable();
        echo "Evo".$RelevanceName." ".$ID_Relevance;   */
        
        $relevance = Relevance::findFirst("ID_Relevance = '$ID_Relevance'");
        if (!$relevance) {
            $this->flash->error("Relevance not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "index",
                ]
            );
        }  

        if (!$relevance->delete()) {
            foreach ($relevance->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "relevance",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Relevance deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "relevance",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new RelevanceForm;
        $this->view->form = new RelevanceForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "relevance",
                "action"     => "index",
            ]  
        );  
    }
        
}
