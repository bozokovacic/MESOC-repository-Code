<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OrganisationController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Organisation');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new OrganisationForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Organisation", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $organisation = Organisation::find($parameters);
        
        if (count($organisation) == 0) {
            $this->flash->notice("Organisation is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $organisation,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->organisation = $organisation;
    }

    
    public function viewAction()
    {
        $numberPage = 1;
                             
/**        $numberPage = $this->request->getQuery("page", "int");
        $parameters = []; */
        
        $organisation = Organisation::find(
                [    
                $parameters,                    
                 'order'      => 'ID_Organisation',   
                ]);

        if (count($organisation) == 0) {
            $this->flash->notice("Organisation is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $organisation,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->organisation = $organisation;
    }
    
    /**
     * Shows the form to create a new organisation
     */
    public function newAction()
    {
       $this->view->form = new OrganisationForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Organisation)
    {

        if (!$this->request->isPost()) {

            $organisation = Organisation::findFirst("ID_Organisation = '$ID_Organisation'");
            if (!$organisation) {
                $this->flash->error("Organisation not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "organisation",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new OrganisationForm($organisation, ['edit' => true]);
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
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $form = new OrganisationForm;
        $organisation = new Organisation();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $organisation)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "new",
                ]
            );
        }

        if ($organisation->save() == false) {
            foreach ($organisation->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Organisation successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "organisation",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Organisation
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $ID_Organisation = $this->request->getPost("ID_Organisation", "string");

        $organisation = Organisation::findFirst("ID_Organisation = '$ID_Organisation'");
        if (!$organisation) {
            $this->flash->error("Organisation does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $form = new OrganisationForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $organisation)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "new",
                ]
            );
        }

        if ($organisation->save() == false) {
			
            foreach ($organisation->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Organisation successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "organisation",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_Organisation)
    {
         
       $organisation = Organisation::findFirst("ID_Organisation = '$ID_Organisation'");
        
       $this->view->form = new OrganisationForm($organisation, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Organisation = $this->request->getPost("ID_Organisation", "string");

/**        $this->view->disable();
        echo "Evo".$OrganisationName." ".$ID_Organisation;   */
        
        $organisation = Organisation::findFirst("ID_Organisation = '$ID_Organisation'");
        if (!$organisation) {
            $this->flash->error("Organisation not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }  

        if (!$organisation->delete()) {
            foreach ($organisation->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "organisation",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Organisation deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "organisation",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new OrganisationForm;
        $this->view->form = new OrganisationForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "organisation",
                "action"     => "index",
            ]  
        );  
    }
        
}
