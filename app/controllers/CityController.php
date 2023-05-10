<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * CityController
 *
 * Manage CRUD operations for city
 */
class CityController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('City');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new CityForm;
    }

    /**
     * Search city based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "City", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $city = City::find($parameters);
        if (count($city) == 0) {
            $this->flash->notice("The search did not find any city");

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator(array(
            "data"  => $city,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

       public function viewAction()
    {
        $numberPage = 1;
        
        $city = City::find(
                [    
                 'order'      => 'ID_City',   
                ]
                );
        if (count($city) == 0) {
            $this->flash->notice("City is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $city,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->city = $city;
    }
            
    /**
     * Shows the form to create a new city
     */
    public function newAction()
    {
        $this->view->form = new CityForm(null, array('edit' => true));
    }

    /**
     * Edits a city based on its id
     */
    public function editAction($ID_City)
    {

        if (!$this->request->isPost()) {

            $city = City::findFirst("ID_City = '$ID_City'");
            if (!$city) {
                $this->flash->error("City was not found");

                return $this->dispatcher->forward(
                    [
                        "controller" => "city",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new CityForm($city, array('edit' => true));
        }
    }

    /**
     * Creates a new city
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $form = new CityForm;
        $city = new City();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $city)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "new",
                ]
            );
        }

        if ($city->save() == false) {
            foreach ($city->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("City was created successfully");

        return $this->dispatcher->forward(
            [
                "controller" => "city",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current city in screen
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $ID_City = $this->request->getPost("ID_City", "int");

        $city = City::findFirst("ID_City = '$ID_City'");
        if (!$city) {
            $this->flash->error("City does not exist");

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $form = new CityForm;
        $this->view->form = $form;

        $data = $this->request->getPost();

        if (!$form->isValid($data, $city)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "edit",
//                    "params"     => [$id]
                ]
            );
        }

        if ($city->save() == false) {
            foreach ($city->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "edit",
 //                   "params"     => [$id]
                ]
            );
        }

        $form->clear();

        $this->flash->success("City was updated successfully");

        return $this->dispatcher->forward(
            [
                "controller" => "city",
                "action"     => "view",
            ]
        );
    }

      public function deleteAction($ID_City)
    {
         
       $city = City::findFirst("ID_City = '$ID_City'");
        
       $this->view->form = new CityForm($city, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_City = $this->request->getPost("ID_City", "string");

/**        $this->view->disable();
        echo "Evo".$CityName." ".$ID_City;   */
        
        $city = City::findFirst("ID_City = '$ID_City'");
        if (!$city) {
            $this->flash->error("City not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }  

        if (!$city->delete()) {
            foreach ($city->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "city",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("City deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "city",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new CityForm;
        $this->view->form = new CityForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "city",
                "action"     => "index",
            ]  
        );  
    }
    
}
