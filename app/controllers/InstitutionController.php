<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class InstitutionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Institution');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new InstitutionForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Institution", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $institution = Institution::find($parameters);
        
        if (count($institution) == 0) {
            $this->flash->notice("Institution is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $institution,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->institution = $institution;
    }

    
    public function viewAction()
    {
        $numberPage = 1;
        
        // pregled iz uređivanja Institution
        $ID_Author = 0; 
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        if ($this->session->has("ID_Author")) {
            // Retrieve its value
            $ID_Author = $this->session->get("ID_Author");
        }
     
        
        $numberPage = $this->request->getQuery("page", "int");
        $parameters = [];
        
        $institution = Institution::find(
                [    
                $parameters,                    
                 'order'      => 'ID_Institution',   
                ]);
        
        if (count($institution) == 0) {
            $this->flash->notice("Institution is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $institution,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->institution = $institution;
    }
    
    /**
     * Shows the form to create a new institution
     */
    public function newAction()
    {
       $this->view->form = new InstitutionForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Institution)
    {

        if (!$this->request->isPost()) {

            $institution = Institution::findFirst("ID_Institution = '$ID_Institution'");
            if (!$institution) {
                $this->flash->error("Institution not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "institution",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new InstitutionForm($institution, ['edit' => true]);
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
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $form = new InstitutionForm;
        $institution = new Institution();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $institution)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "new",
                ]
            );
        }

        if ($institution->save() == false) {
            foreach ($institution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Institution successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "institution",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Institution
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $ID_Institution = $this->request->getPost("ID_Institution", "string");

        $institution = Institution::findFirst("ID_Institution = '$ID_Institution'");
        if (!$institution) {
            $this->flash->error("Institution does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $form = new InstitutionForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $institution)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "new",
                ]
            );
        }

        if ($institution->save() == false) {
			
            foreach ($institution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Institution successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "institution",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_Institution)
    {
         
       $institution = Institution::findFirst("ID_Institution = '$ID_Institution'");
        
       $this->view->form = new InstitutionForm($institution, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Institution = $this->request->getPost("ID_Institution", "string");

/**        $this->view->disable();
        echo "Evo".$InstitutionName." ".$ID_Institution;   */
        
        $institution = Institution::findFirst("ID_Institution = '$ID_Institution'");
        if (!$institution) {
            $this->flash->error("Institution not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }  

        if (!$institution->delete()) {
            foreach ($institution->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "institution",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Institution deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "institution",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new InstitutionForm;
        $this->view->form = new InstitutionForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "institution",
                "action"     => "index",
            ]  
        );  
    }
        
}
