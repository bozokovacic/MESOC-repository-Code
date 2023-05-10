<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RegionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Region');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new RegionForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Region", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $region = Region::find($parameters);
        if (count($region) == 0) {
            $this->flash->notice("Region is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $region,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->region = $region;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $region = Region::find(
                [    
                 'order'      => 'ID_Region',   
                ]
                );
        if (count($region) == 0) {
            $this->flash->notice("Region is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $region,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->region = $region;
    }
    
    /**
     * Shows the form to create a new region
     */
    public function newAction()
    {
       $this->view->form = new RegionForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Region)
    {

        if (!$this->request->isPost()) {

            $region = Region::findFirst("ID_Region = '$ID_Region'");
            if (!$region) {
                $this->flash->error("Region not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "region",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new RegionForm($region, ['edit' => true]);
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
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $form = new RegionForm;
        $region = new Region();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $region)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "new",
                ]
            );
        }

        if ($region->save() == false) {
            foreach ($region->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Region successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "region",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Region
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $ID_Region = $this->request->getPost("ID_Region", "string");

        $region = Region::findFirst("ID_Region = '$ID_Region'");
        if (!$region) {
            $this->flash->error("Region does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $form = new RegionForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $region)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "new",
                ]
            );
        }

        if ($region->save() == false) {
			
            foreach ($region->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Region successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "region",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Region)
    {
         
       $region = Region::findFirst("ID_Region = '$ID_Region'");
        
       $this->view->form = new RegionForm($region, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Region = $this->request->getPost("ID_Region", "string");

/**        $this->view->disable();
        echo "Evo".$RegionName." ".$ID_Region;   */
        
        $region = Region::findFirst("ID_Region = '$ID_Region'");
        if (!$region) {
            $this->flash->error("Region not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }  

        if (!$region->delete()) {
            foreach ($region->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "region",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Region deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "region",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new RegionForm;
        $this->view->form = new RegionForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "region",
                "action"     => "index",
            ]  
        );  
    }

    
}
