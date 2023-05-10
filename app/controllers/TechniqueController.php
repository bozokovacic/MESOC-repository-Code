<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TechniqueController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Technique');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new TechniqueForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
                    "controller" => "technique",
                    "action"     => "index",
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

       public function viewAction()
    {
        $numberPage = 1;
        
        $technique = Technique::find();
        
        if (count($technique) == 0) {
            $this->flash->notice("Technique is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "index",
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
    
    /**
     * Shows the form to create a new technique
     */
    public function newAction()
    {
       $this->view->form = new TechniqueForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Technique)
    {

        if (!$this->request->isPost()) {

            $technique = Technique::findFirst("ID_Technique = '$ID_Technique'");
            
            if (!$technique) {
                $this->flash->error("Technique not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "technique",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new TechniqueForm($technique, ['edit' => true]);
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
                    "controller" => "technique",
                    "action"     => "index",
                ]
            );
        }

        $form = new TechniqueForm;
        $technique = new Technique();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $technique)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "new",
                ]
            );
        }

        if ($technique->save() == false) {
            foreach ($technique->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Technique successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "technique",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Technique
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "index",
                ]
            );
        }

        $ID_Technique = $this->request->getPost("ID_Technique", "string"); 

        $technique = Technique::findFirst("ID_Technique = '$ID_Technique'");
        if (!$technique) {
            $this->flash->error("Technique does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "index",
                ]
            );
        }

        $form = new TechniqueForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $technique)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "new",
                ]
            );
        }

        if ($technique->save() == false) {
			
            foreach ($technique->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Technique successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "technique",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
public function deleteAction($ID_Technique)
    {
         
       $technique = Technique::findFirst("ID_Technique = '$ID_Technique'");
        
       $this->view->form = new TechniqueForm($technique, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Technique = $this->request->getPost("ID_Technique", "string");

/**        $this->view->disable();
        echo "Evo".$TechniqueName." ".$ID_Technique;   */
        
        $technique = Technique::findFirst("ID_Technique = '$ID_Technique'");
        if (!$technique) {
            $this->flash->error("Technique not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "index",
                ]
            );
        }  

        if (!$technique->delete()) {
            foreach ($technique->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "technique",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Technique deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "technique",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new TechniqueForm;
        $this->view->form = new TechniqueForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "technique",
                "action"     => "index",
            ]  
        );  
    }
    
}
