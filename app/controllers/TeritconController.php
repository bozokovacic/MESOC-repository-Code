<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TeritconController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Teritcon');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new TeritconForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Teritcon", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $teritcon = Teritcon::find($parameters);
        if (count($teritcon) == 0) {
            $this->flash->notice("Teritcon is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $teritcon,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->teritcon = $teritcon;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $teritcon = Teritcon::find(
                [    
                 'order'      => 'ID_TeritCon',   
                ]
                );
        if (count($teritcon) == 0) {
            $this->flash->notice("Territorial context is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $teritcon,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->teritcon = $teritcon;
    }
    
    /**
     * Shows the form to create a new teritcon
     */
    public function newAction()
    {
       $this->view->form = new TeritconForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_TeritCon)
    {

        if (!$this->request->isPost()) {

            $teritcon = Teritcon::findFirst("ID_TeritCon = '$ID_TeritCon'");
            if (!$teritcon) {
                $this->flash->error("Territorial context not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "teritcon",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new TeritconForm($teritcon, ['edit' => true]);
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
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }

        $form = new TeritconForm;
        $teritcon = new Teritcon();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $teritcon)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "new",
                ]
            );
        }

        if ($teritcon->save() == false) {
            foreach ($teritcon->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Territorial context successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "teritcon",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_TeritCon
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }

        $ID_TeritCon = $this->request->getPost("ID_TeritCon", "string");

        $teritcon = Teritcon::findFirst("ID_TeritCon = '$ID_TeritCon'");
        if (!$teritcon) {
            $this->flash->error("Territorial context does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }

        $form = new TeritconForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $teritcon)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "new",
                ]
            );
        }

        if ($teritcon->save() == false) {
			
            foreach ($teritcon->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Territorial context successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "teritcon",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_TeritCon)
    {
         
       $teritcon = Teritcon::findFirst("ID_TeritCon = '$ID_TeritCon'");
        
       $this->view->form = new TeritconForm($teritcon, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_TeritCon = $this->request->getPost("ID_TeritCon", "string");

/**        $this->view->disable();
        echo "Evo".$TeritconName." ".$ID_TeritCon;   */
        
        $teritcon = Teritcon::findFirst("ID_TeritCon = '$ID_TeritCon'");
        if (!$teritcon) {
            $this->flash->error("Territorial context not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }  

        if (!$teritcon->delete()) {
            foreach ($teritcon->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "index",
                ]
            );
        }   

        $this->flash->success("Territorial context deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "teritcon",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new TeritconForm;
        $this->view->form = new TeritconForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "teritcon",
                "action"     => "index",
            ]  
        );  
    }

    
}
