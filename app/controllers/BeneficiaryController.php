<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class BeneficiaryController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Beneficiary');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new BeneficiaryForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
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
            $this->flash->notice("Beneficiary not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
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

      public function viewAction()
    {
        $numberPage = 1;
        
        $beneficiary = Beneficiary::find(
                [    
                 'order'      => 'ID_Beneficiary',   
                ]
                );
        if (count($beneficiary) == 0) {
            $this->flash->notice("Beneficiary is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
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
    
    /**
     * Shows the form to create a new beneficiary
     */
    public function newAction()
    {
       $this->view->form = new BeneficiaryForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Beneficiary)
    {

        if (!$this->request->isPost()) {

            $beneficiary = Beneficiary::findFirst("ID_Beneficiary = '$ID_Beneficiary'");
            if (!$beneficiary) {
                $this->flash->error("Beneficiary not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "beneficiary",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new BeneficiaryForm($beneficiary, ['edit' => true]);
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
                    "controller" => "beneficiary",
                    "action"     => "index",
                ]
            );
        }

        $form = new BeneficiaryForm;
        $beneficiary = new Beneficiary();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $beneficiary)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "new",
                ]
            );
        }

        if ($beneficiary->save() == false) {
            foreach ($beneficiary->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Beneficiary successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "beneficiary",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Beneficiary
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
                ]
            );
        }

        $ID_Beneficiary = $this->request->getPost("ID_Beneficiary", "string");

        $beneficiary = Beneficiary::findFirst("ID_Beneficiary = '$ID_Beneficiary'");
        if (!$beneficiary) {
            $this->flash->error("Beneficiary does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
                ]
            );
        }

        $form = new BeneficiaryForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $beneficiary)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "new",
                ]
            );
        }

        if ($beneficiary->save() == false) {
			
            foreach ($beneficiary->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Beneficiary successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "beneficiary",
                "action"     => "view",
            ]
        );
    }

   public function deleteAction($ID_Beneficiary)
    {
         
       $beneficiary = Beneficiary::findFirst("ID_Beneficiary = '$ID_Beneficiary'");
        
       $this->view->form = new BeneficiaryForm($beneficiary, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Beneficiary = $this->request->getPost("ID_Beneficiary", "string");

/**        $this->view->disable();
        echo "Evo".$BeneficiaryName." ".$ID_Beneficiary;   */
        
        $beneficiary = Beneficiary::findFirst("ID_Beneficiary = '$ID_Beneficiary'");
        if (!$beneficiary) {
            $this->flash->error("Beneficiary not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
                ]
            );
        }  

        if (!$beneficiary->delete()) {
            foreach ($beneficiary->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "beneficiary",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Beneficiary deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "beneficiary",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new BeneficiaryForm;
        $this->view->form = new BeneficiaryForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "beneficiary",
                "action"     => "index",
            ]  
        );  
    }
    
}
