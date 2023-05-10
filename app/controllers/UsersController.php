<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UsersController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Users');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new UsersForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Users", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $users = Users::find($parameters);
        
        if (count($users) == 0) {
            $this->flash->notice("Users is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $users,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->users = $users;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        
        $users = Users::find(
                [    
                 'order'      => 'id',   
                ]
                );
        if (count($users) == 0) {
            $this->flash->notice("Users is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $users,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->users = $users;
    }
    
    /**
     * Shows the form to create a new users
     */
    public function newAction()
    {
       $this->view->form = new UsersForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $users = Users::findFirst("id = '$id'");
            if (!$users) {
                $this->flash->error("Users not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "users",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new UsersForm($users, ['edit' => true]);
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
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $form = new UsersForm;
        $users = new Users();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $users)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "new",
                ]
            );
        }

        if ($users->save() == false) {
            foreach ($users->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Users successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "users",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $id = $this->request->getPost("id", "string");

        $users = Users::findFirst("id = '$id'");
        if (!$users) {
            $this->flash->error("Users does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $form = new UsersForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $users)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "new",
                ]
            );
        }

        if ($users->save() == false) {
			
            foreach ($users->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Users successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "users",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
    
    public function deleteAction($id)
    {
         
       $users = Users::findFirst("id = '$id'");
        
       $this->view->form = new UsersForm($users, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $id = $this->request->getPost("id", "string");

/**        $this->view->disable();
        echo "Evo".$UsersName." ".$id;   */
        
        $users = Users::findFirst("id = '$id'");
        if (!$users) {
            $this->flash->error("Users not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }  

        if (!$users->delete()) {
            foreach ($users->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Users deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "users",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new UsersForm;
        $this->view->form = new UsersForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "users",
                "action"     => "index",
            ]  
        );  
    }
        
}
