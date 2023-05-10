<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PartnerController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Partner');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new PartnerForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Partner", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $partner = Partner::find($parameters);
        if (count($partner) == 0) {
            $this->flash->notice("Partner is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $partner,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->partner = $partner;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $partner = Partner::find(
                [    
                 'order'      => 'ID_Partner',   
                ]
                );
        if (count($partner) == 0) {
            $this->flash->notice("Partner is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $partner,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->partner = $partner;
    }
    
    /**
     * Shows the form to create a new partner
     */
    public function newAction()
    {
       $this->view->form = new PartnerForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Partner)
    {

        if (!$this->request->isPost()) {

            $partner = Partner::findFirst("ID_Partner = '$ID_Partner'");
            if (!$partner) {
                $this->flash->error("Partner not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "partner",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new PartnerForm($partner, ['edit' => true]);
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
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $form = new PartnerForm;
        $partner = new Partner();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $partner)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "new",
                ]
            );
        }

        if ($partner->save() == false) {
            foreach ($partner->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Partner successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "partner",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Partner
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $ID_Partner = $this->request->getPost("ID_Partner", "string");

        $partner = Partner::findFirst("ID_Partner = '$ID_Partner'");
        if (!$partner) {
            $this->flash->error("Partner does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $form = new PartnerForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $partner)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "new",
                ]
            );
        }

        if ($partner->save() == false) {
			
            foreach ($partner->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Partner successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "partner",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Partner)
    {
         
       $partner = Partner::findFirst("ID_Partner = '$ID_Partner'");
        
       $this->view->form = new PartnerForm($partner, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Partner = $this->request->getPost("ID_Partner", "string");

/**        $this->view->disable();
        echo "Evo".$PartnerName." ".$ID_Partner;   */
        
        $partner = Partner::findFirst("ID_Partner = '$ID_Partner'");
        if (!$partner) {
            $this->flash->error("Partner not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }  

        if (!$partner->delete()) {
            foreach ($partner->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Partner deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "partner",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new PartnerForm;
        $this->view->form = new PartnerForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "partner",
                "action"     => "index",
            ]  
        );  
    }

    
}
