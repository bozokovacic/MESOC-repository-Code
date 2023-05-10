<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SectorController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sector');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new SectorForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Sector", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $sector = Sector::find($parameters);
        
        if (count($sector) == 0) {
            $this->flash->notice("Sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $sector,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->sector = $sector;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        
        $sector = Sector::find(
                [    
                 'order'      => 'ID_Sector',   
                ]
                );
        if (count($sector) == 0) {
            $this->flash->notice("Sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $sector,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->sector = $sector;
    }
    
    /**
     * Shows the form to create a new sector
     */
    public function newAction()
    {
       $this->view->form = new SectorForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Sector)
    {

        if (!$this->request->isPost()) {

            $sector = Sector::findFirst("ID_Sector = '$ID_Sector'");
            if (!$sector) {
                $this->flash->error("Sector not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "sector",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new SectorForm($sector, ['edit' => true]);
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
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $form = new SectorForm;
        $sector = new Sector();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $sector)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "new",
                ]
            );
        }

        if ($sector->save() == false) {
            foreach ($sector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Sector successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "sector",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Sector
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $ID_Sector = $this->request->getPost("ID_Sector", "string");

        $sector = Sector::findFirst("ID_Sector = '$ID_Sector'");
        if (!$sector) {
            $this->flash->error("Sector does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $form = new SectorForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $sector)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "new",
                ]
            );
        }

        if ($sector->save() == false) {
			
            foreach ($sector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Sector successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "sector",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_Sector)
    {
         
       $sector = Sector::findFirst("ID_Sector = '$ID_Sector'");
        
       $this->view->form = new SectorForm($sector, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Sector = $this->request->getPost("ID_Sector", "string");

/**        $this->view->disable();
        echo "Evo".$SectorName." ".$ID_Sector;   */
        
        $sector = Sector::findFirst("ID_Sector = '$ID_Sector'");
        if (!$sector) {
            $this->flash->error("Sector not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }  

        if (!$sector->delete()) {
            foreach ($sector->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "sector",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Sector deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "sector",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new SectorForm;
        $this->view->form = new SectorForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "sector",
                "action"     => "index",
            ]  
        );  
    }
        
}
