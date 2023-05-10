<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CulturaldomainController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Cultural sector');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new CulturaldomainForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Culturaldomain", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $culturaldomain = Culturaldomain::find($parameters);
        
        if (count($culturaldomain) == 0) {
            $this->flash->notice("Cultural sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $culturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->culturaldomain = $culturaldomain;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        
        $culturaldomain = Culturaldomain::find(
                [    
                 'order'      => 'ID_CultDomain',   
                ]
                );
        if (count($culturaldomain) == 0) {
            $this->flash->notice("Cultural sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $culturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->culturaldomain = $culturaldomain;
    }
    
    /**
     * Shows the form to create a new culturaldomain
     */
    public function newAction()
    {
       $this->view->form = new CulturaldomainForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_CultDomain)
    {

        if (!$this->request->isPost()) {

            $culturaldomain = Culturaldomain::findFirst("ID_CultDomain = '$ID_CultDomain'");
            if (!$culturaldomain) {
                $this->flash->error("Cultural sector not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "culturaldomain",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new CulturaldomainForm($culturaldomain, ['edit' => true]);
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
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $form = new CulturaldomainForm;
        $culturaldomain = new Culturaldomain();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $culturaldomain)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "new",
                ]
            );
        }

        if ($culturaldomain->save() == false) {
            foreach ($culturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Cultural sector successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "culturaldomain",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SOCIAL IMPACT in screen
     *
     * @param string $ID_CultDomain
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $ID_CultDomain = $this->request->getPost("ID_CultDomain", "string");

        $culturaldomain = Culturaldomain::findFirst("ID_CultDomain = '$ID_CultDomain'");
        if (!$culturaldomain) {
            $this->flash->error("Cultural sector does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $form = new CulturaldomainForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $culturaldomain)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "new",
                ]
            );
        }

        if ($culturaldomain->save() == false) {
			
            foreach ($culturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Cultural sector successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "culturaldomain",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_CultDomain)
    {
         
       $culturaldomain = Culturaldomain::findFirst("ID_CultDomain = '$ID_CultDomain'");
        
       $this->view->form = new CulturaldomainForm($culturaldomain, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_CultDomain = $this->request->getPost("ID_CultDomain", "string");

/**        $this->view->disable();
        echo "Evo".$CulturaldomainName." ".$ID_CultDomain;   */
        
        $culturaldomain = Culturaldomain::findFirst("ID_CultDomain = '$ID_CultDomain'");
        if (!$culturaldomain) {
            $this->flash->error("Cultural sector not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }  

        if (!$culturaldomain->delete()) {
            foreach ($culturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "culturaldomain",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Cultural sector deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "culturaldomain",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new Cultural domainForm;
        $this->view->form = new Cultural domainForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "culturaldomain",
                "action"     => "index",
            ]  
        );  
    }
        
}
