<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TransitionvarController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Transitionvar');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new TransitionvarForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Transitionvar", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $transitionvar = Transitionvar::find($parameters);
        
        if (count($transitionvar) == 0) {
            $this->flash->notice("Transition variable is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $transitionvar,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->transitionvar = $transitionvar;
    }

    
    public function viewAction()
    {
        $numberPage = 1;
        
        // pregled iz uređivanja Transitionvar
        $ID_Transvar = 0; 
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        if ($this->session->has("ID_Transvar")) {
            // Retrieve its value
            $ID_Transvar = $this->session->get("ID_Transvar");
        }
     
        
        $numberPage = $this->request->getQuery("page", "int");
        $parameters = [];
        
        $transitionvar = Transitionvar::find(
                [    
                $parameters,                    
                 'order'      => 'ID_Transvar',   
                ]);
        
        if (count($transitionvar) == 0) {
            $this->flash->notice("Transition variable is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $transitionvar,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->transitionvar = $transitionvar;
    }
    
    /**
     * Shows the form to create a new transitionvar
     */
    public function newAction()
    {
       $this->view->form = new TransitionvarForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Transvar)
    {

        if (!$this->request->isPost()) {

            $transitionvar = Transitionvar::findFirst("ID_Transvar = '$ID_Transvar'");
            if (!$transitionvar) {
                $this->flash->error("Transition variable not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "transitionvar",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new TransitionvarForm($transitionvar, ['edit' => true]);
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
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $form = new TransitionvarForm;
        $transitionvar = new Transitionvar();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $transitionvar)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "new",
                ]
            );
        }

        if ($transitionvar->save() == false) {
            foreach ($transitionvar->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Transition variable successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "transitionvar",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Transitionvar
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $ID_Transvar = $this->request->getPost("ID_Transvar", "string");

        $transitionvar = Transitionvar::findFirst("ID_Transvar = '$ID_Transvar'");
        if (!$transitionvar) {
            $this->flash->error("Transition variable does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $form = new TransitionvarForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $transitionvar)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "new",
                ]
            );
        }

        if ($transitionvar->save() == false) {
			
            foreach ($transitionvar->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Transition variable successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "transitionvar",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_Transvar)
    {
         
       $transitionvar = Transitionvar::findFirst("ID_Transvar = '$ID_Transvar'");
        
       $this->view->form = new TransitionvarForm($transitionvar, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Transvar = $this->request->getPost("ID_Transvar", "string");

/**        $this->view->disable();
        echo "Evo".$TransitionvarName." ".$ID_Transitionvar;   */
        
        $transitionvar = Transitionvar::findFirst("ID_Transvar = '$ID_Transvar'");
        if (!$transitionvar) {
            $this->flash->error("Transition variable not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }  

        if (!$transitionvar->delete()) {
            foreach ($transitionvar->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "transitionvar",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Transition variable deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "transitionvar",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new TransitionvarForm;
        $this->view->form = new TransitionvarForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "transitionvar",
                "action"     => "index",
            ]  
        );  
    }
        
}
