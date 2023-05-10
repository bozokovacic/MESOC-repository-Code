<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SocialimpactController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Socialimpact');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new SocialimpactForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Socialimpact", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $socialimpact = Socialimpact::find($parameters);
        
        if (count($socialimpact) == 0) {
            $this->flash->notice("Socialimpact is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $socialimpact,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->socialimpact = $socialimpact;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        echo 'Hey';
        $socialimpact = Socialimpact::find(
                [    
                 'order'      => 'ID_SocImpact',   
                ]
                );
        if (count($socialimpact) == 0) {
            $this->flash->notice("Socialimpact is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $socialimpact,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->socialimpact = $socialimpact;
    }
    
    /**
     * Shows the form to create a new socialimpact
     */
    public function newAction()
    {
       $this->view->form = new SocialimpactForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_SocImpact)
    {

        if (!$this->request->isPost()) {

            $socialimpact = Socialimpact::findFirst("ID_SocImpact = '$ID_SocImpact'");
            if (!$socialimpact) {
                $this->flash->error("Socialimpact not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "socialimpact",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new SocialimpactForm($socialimpact, ['edit' => true]);
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
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $form = new SocialimpactForm;
        $socialimpact = new Socialimpact();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $socialimpact)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "new",
                ]
            );
        }

        if ($socialimpact->save() == false) {
            foreach ($socialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Socialimpact successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "socialimpact",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SOCIAL IMPACT in screen
     *
     * @param string $ID_SocImpact
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $ID_SocImpact = $this->request->getPost("ID_SocImpact", "string");

        $socialimpact = Socialimpact::findFirst("ID_SocImpact = '$ID_SocImpact'");
        if (!$socialimpact) {
            $this->flash->error("Socialimpact does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $form = new SocialimpactForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $socialimpact)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "new",
                ]
            );
        }

        if ($socialimpact->save() == false) {
			
            foreach ($socialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Socialimpact successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "socialimpact",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($ID_SocImpact)
    {
         
       $socialimpact = Socialimpact::findFirst("ID_SocImpact = '$ID_SocImpact'");
        
       $this->view->form = new SocialimpactForm($socialimpact, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_SocImpact = $this->request->getPost("ID_SocImpact", "string");

/**        $this->view->disable();
        echo "Evo".$SocialimpactName." ".$ID_SocImpact;   */
        
        $socialimpact = Socialimpact::findFirst("ID_SocImpact = '$ID_SocImpact'");
        if (!$socialimpact) {
            $this->flash->error("Socialimpact not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }  

        if (!$socialimpact->delete()) {
            foreach ($socialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "socialimpact",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Socialimpact deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "socialimpact",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new SocialimpactForm;
        $this->view->form = new SocialimpactForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "socialimpact",
                "action"     => "index",
            ]  
        );  
    }
        
}
