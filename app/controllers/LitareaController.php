<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class LitareaController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Literature Area');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new LitareaForm;
    }

    /**
     * Search litarea based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
            $this->flash->notice("The search did not find any litarea");

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "index",
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

        public function viewAction()
    {
        $numberPage = 1;
        
        $litarea = Litarea::find(
                [
                'order'      => 'ID_LitArea',   
                ] 
                );
        if (count($litarea) == 0) {
            $this->flash->notice("The search did not find any litarea");

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "index",
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
    /**
     * Shows the form to create a new litarea
     */
    public function newAction()
    {
       $this->view->form = new LitareaForm(null, ['edit' => true]);
    }

    /**
     * Edits a litaera based on its ID_LitArea
     */
    public function editAction($ID_LitArea)
    {

        if (!$this->request->isPost()) {

            $litarea = Litarea::findFirst(" ID_LitArea = '$ID_LitArea'");
		
            if (!$litarea) {
                $this->flash->error("Lierature area not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "litarea",
                        "action"     => "view",
                    ]
                );
            }

            $this->view->form = new LitareaForm($litarea, ['edit' => true]);
        } 
				
    }

    /**
     * Creates a new litaera
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "index",
                ]
            );
        }

        $form = new LitareaForm;
        $litaera = new Litarea();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $litaera)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        if ($litaera->save() == false) {
            foreach ($litaera->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Lierature area stored.");

        return $this->dispatcher->forward(
            [
                "controller" => "litarea",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current Suranici in screen
     *
     * @param string $ID_LitArea
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        $ID_LitArea = $this->request->getPost("ID_LitArea", "int");

        $litarea = Litarea::findFirst(" ID_LitArea ='$ID_LitArea'");
        if (!$litarea) {
            $this->flash->error("Literature area not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        $form = new LitareaForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $litarea)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "new",
                ]
            );
        }

        if ($litarea->save() == false) {
			
            foreach ($litarea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Lierature area updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "litarea",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a Suradnik
     *
     * @param string $ID_LitArea
     */
    public function deleteAction($ID_LitArea)
    {
         
       $litarea = Litarea::findFirst("ID_LitArea = '$ID_LitArea'");
        
       $this->view->form = new LitareaForm($litarea, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
     {
      
        $ID_LitArea = $this->request->getPost("ID_LitArea", "string");
        
        $litarea = Litarea::findFirst("ID_LitArea = '$ID_LitArea'");
        
        if (!$litarea) {
            $this->flash->error("Literature area not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "index",
                ]
            );
        }  

        if (!$litarea->delete()) {
            foreach ($litarea->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "litarea",
                    "action"     => "view",
                ]
            );
        }

        $this->flash->success("Literature area deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "litarea",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new LitAreaForm;
        $this->view->form = new LitAreaForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "litArea",
                "action"     => "index",
            ]  
        );  
    }
}
