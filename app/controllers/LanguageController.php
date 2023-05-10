<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class LanguageController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Language');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new LanguageForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Language", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $language = Language::find($parameters);
        if (count($language) == 0) {
            $this->flash->notice("Language is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $language,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->language = $language;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        

        $language = Language::find(
                [
                'order'      => 'ID_Language',   
                ]
                );
        if (count($language) == 0) {
            $this->flash->notice("Language is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $language,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->language = $language;
    }

    /**
     * Shows the form to create a new language
     */
    public function newAction()
    {
       $this->view->form = new LanguageForm(null, ['edit' => true]);
    }

    
    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Language)
    {

        if (!$this->request->isPost()) {

            $language = Language::findFirst("ID_Language = '$ID_Language'");
            if (!$language) {
                $this->flash->error("Language not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "language",
                        "action"     => "view",
                    ]
                );
            }

            $this->view->form = new LanguageForm($language, ['edit' => true]);
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
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $form = new LanguageForm;
        $language = new Language();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $language)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "new",
                ]
            );
        }

        if ($language->save() == false) {
            foreach ($language->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Language successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "language",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Language
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $ID_Language = $this->request->getPost("ID_Language", "string");

        $language = Language::findFirst("ID_Language = '$ID_Language'");
        if (!$language) {
            $this->flash->error("Language does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $form = new LanguageForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $language)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "new",
                ]
            );
        }

        if ($language->save() == false) {
			
            foreach ($language->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Language successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "language",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
   public function deleteAction($ID_Language)
    {
         
       $language = Language::findFirst("ID_Language = '$ID_Language'");
        
       $this->view->form = new LanguageForm($language, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Language = $this->request->getPost("ID_Language", "string");
        $LanguageName = $this->request->getPost("LanguageName", "string");

/**        $this->view->disable();
        echo "Evo".$LanguageName." ".$ID_Language;   */
        
        $language = Language::findFirst("ID_Language = '$ID_Language'");
        if (!$language) {
            $this->flash->error("Language not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }  

        if (!$language->delete()) {
            foreach ($language->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "language",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Language deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "language",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new LanguageForm;
        $this->view->form = new LanguageForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "language",
                "action"     => "index",
            ]  
        );  
    }
}
