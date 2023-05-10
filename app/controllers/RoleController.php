<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RoleController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Role');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new RoleForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Role", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $role = Role::find($parameters);
        if (count($role) == 0) {
            $this->flash->notice("Role is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $role,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->role = $role;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $role = Role::find(
                [    
                 'order'      => 'ID_Role',   
                ]
                );
        if (count($role) == 0) {
            $this->flash->notice("Role is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $role,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->role = $role;
    }
    
    /**
     * Shows the form to create a new role
     */
    public function newAction()
    {
       $this->view->form = new RoleForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Role)
    {

        if (!$this->request->isPost()) {

            $role = Role::findFirst("ID_Role = '$ID_Role'");
            if (!$role) {
                $this->flash->error("Role not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "role",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new RoleForm($role, ['edit' => true]);
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
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $form = new RoleForm;
        $role = new Role();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $role)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "new",
                ]
            );
        }

        if ($role->save() == false) {
            foreach ($role->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Role successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "role",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Role
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $ID_Role = $this->request->getPost("ID_Role", "string");

        $role = Role::findFirst("ID_Role = '$ID_Role'");
        if (!$role) {
            $this->flash->error("Role does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $form = new RoleForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $role)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "new",
                ]
            );
        }

        if ($role->save() == false) {
			
            foreach ($role->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Role successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "role",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Role)
    {
         
       $role = Role::findFirst("ID_Role = '$ID_Role'");
        
       $this->view->form = new RoleForm($role, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Role = $this->request->getPost("ID_Role", "string");

/**        $this->view->disable();
        echo "Evo".$RoleName." ".$ID_Role;   */
        
        $role = Role::findFirst("ID_Role = '$ID_Role'");
        if (!$role) {
            $this->flash->error("Role not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }  

        if (!$role->delete()) {
            foreach ($role->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "role",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Role deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "role",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new RoleForm;
        $this->view->form = new RoleForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "role",
                "action"     => "index",
            ]  
        );  
    }

    
}
