<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CountryController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Country');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new CountryForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Country", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $country = Country::find($parameters);
        if (count($country) == 0) {
            $this->flash->notice("Country is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $country,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->country = $country;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $country = Country::find(
                [    
                 'order'      => 'ID_Country',   
                ]
                );
        if (count($country) == 0) {
            $this->flash->notice("Country is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $country,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->country = $country;
    }
        
    /**
     * Shows the form to create a new country
     */
    public function newAction()
    {
       $this->view->form = new CountryForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Country)
    {

        if (!$this->request->isPost()) {

            $country = Country::findFirst("ID_Country = '$ID_Country'");
            if (!$country) {
                $this->flash->error("Country not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "country",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new CountryForm($country, ['edit' => true]);
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
                    "controller" => "country",
                    "action"     => "index",
                ]
            );
        }

        $form = new CountryForm;
        $country = new Country();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $country)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "new",
                ]
            );
        }

        if ($country->save() == false) {
            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Country successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "country",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current COUNTRY in screen
     *
     * @param string $ID_Country
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "index",
                ]
            );
        }

        $ID_Country = $this->request->getPost("ID_Country", "string");

        $country = Country::findFirst("ID_Country = '$ID_Country'");
        if (!$country) {
            $this->flash->error("Country does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "index",
                ]
            );
        }

        $form = new CountryForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $country)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "new",
                ]
            );
        }

        if ($country->save() == false) {
			
            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Country successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "country",
                "action"     => "view",
            ]
        );
    }

    public function deleteAction($ID_Country)
    {
         
       $country = Country::findFirst("ID_Country = '$ID_Country'");
        
       $this->view->form = new CountryForm($country, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Country = $this->request->getPost("ID_Country", "string");

/**        $this->view->disable();
        echo "Evo".$ID_Country;    */
        
        $country = Country::findFirst("ID_Country = '$ID_Country'");
        if (!$country) {
            $this->flash->error("Country not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "view",
                ]
            );
        }  

        if (!$country->delete()) {
            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "country",
                    "action"     => "view",
                ]
            );
        }

        $this->flash->success("Country deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "country",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new CountryForm;
        $this->view->form = new CountryForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "country",
                "action"     => "index",
            ]  
        );  
    }
}
