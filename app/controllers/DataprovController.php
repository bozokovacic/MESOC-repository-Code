<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DataprovController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Dataprov');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new DataprovForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
            $this->flash->notice("Dataprov is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
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

      public function viewAction()
    {
        $numberPage = 1;
        
        $dataprov = Dataprov::find(
                [    
                 'order'      => 'ID_DataProv',   
                ]
                );
        if (count($dataprov) == 0) {
            $this->flash->notice("Data provider is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
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
    
    /**
     * Shows the form to create a new dataprov
     */
    public function newAction()
    {
       $this->view->form = new DataprovForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_DataProv)
    {

        if (!$this->request->isPost()) {

            $dataprov = Dataprov::findFirst("ID_DataProv = '$ID_DataProv'");
            if (!$dataprov) {
                $this->flash->error("Data provider not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "dataprov",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new DataprovForm($dataprov, ['edit' => true]);
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
                    "controller" => "dataprov",
                    "action"     => "index",
                ]
            );
        }

        $form = new DataprovForm;
        $dataprov = new Dataprov();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $dataprov)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "new",
                ]
            );
        }

        if ($dataprov->save() == false) {
            foreach ($dataprov->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Data provider successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "dataprov",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current DATA PROVIDER in screen
     *
     * @param string $ID_DataProv
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
                ]
            );
        }

        $ID_DataProv = $this->request->getPost("ID_DataProv", "string");

        $dataprov = Dataprov::findFirst("ID_DataProv = '$ID_DataProv'");
        if (!$dataprov) {
            $this->flash->error("Data provider does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
                ]
            );
        }

        $form = new DataprovForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $dataprov)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "new",
                ]
            );
        }

        if ($dataprov->save() == false) {
			
            foreach ($dataprov->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Data provider successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "dataprov",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_DataProv)
    {
         
       $dataprov = Dataprov::findFirst("ID_DataProv = '$ID_DataProv'");
        
       $this->view->form = new DataprovForm($dataprov, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_DataProv = $this->request->getPost("ID_DataProv", "string");
      
        $dataprov = Dataprov::findFirst("ID_DataProv = '$ID_DataProv'");
        if (!$dataprov) {
            $this->flash->error("Data provider not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
                ]
            );
        }  

        if (!$dataprov->delete()) {
            foreach ($dataprov->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "dataprov",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Data provider deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "dataprov",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new DataprovForm;
        $this->view->form = new DataprovForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "dataprov",
                "action"     => "index",
            ]  
        );  
    }

    
}
