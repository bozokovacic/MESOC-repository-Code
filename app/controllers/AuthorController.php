<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AuthorController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Author');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new AuthorForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Author", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $author = Author::find($parameters);
        if (count($author) == 0) {
            $this->flash->notice("Author is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $author,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->author = $author;
    }

        public function viewAction()
       {    $numberPage = 1;

           $author = Author::find(
                   [    
                    'order'      => 'ID_Author',   
                   ]
                   );
           if (count($author) == 0) {
               $this->flash->notice("Author is not found.");

               return $this->dispatcher->forward(
                   [
                       "controller" => "author",
                       "action"     => "index",
                   ]
               );
           }

           $paginator = new Paginator([
               "data"  => $author,
               "limit" => 10,
               "page"  => $numberPage
           ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->author = $author;
    }
    
    
    /**
     * Shows the form to create a new author
     */
    public function newAction()
    {
       $this->view->form = new AuthorForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Author)
    {

        if (!$this->request->isPost()) {

            $author = Author::findFirst("ID_Author = '$ID_Author'");
            if (!$author) {
                $this->flash->error("Author not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "author",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new AuthorForm($author, ['edit' => true]);
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
                    "controller" => "author",
                    "action"     => "index",
                ]
            );
        }

        $form = new AuthorForm;
        $author = new Author();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $author)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "new",
                ]
            );
        }

        if ($author->save() == false) {
            foreach ($author->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Author successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "author",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Author
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "index",
                ]
            );
        }

        $ID_Author = $this->request->getPost("ID_Author", "string");

        $author = Author::findFirst("ID_Author = '$ID_Author'");
        if (!$author) {
            $this->flash->error("Author does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "index",
                ]
            );
        }

        $form = new AuthorForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $author)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "new",
                ]
            );
        }

        if ($author->save() == false) {
			
            foreach ($author->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Author successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "author",
                "action"     => "view",
            ]
        );
    }

     public function deleteAction($ID_Author)
    {
         
       $author = Author::findFirst("ID_Author = '$ID_Author'");
        
       $this->view->form = new AuthorForm($author, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Author = $this->request->getPost("ID_Author", "string");

/**        $this->view->disable();
        echo "Evo".$AuthorName." ".$ID_Author;   */
        
        $author = Author::findFirst("ID_Author = '$ID_Author'");
        if (!$author) {
            $this->flash->error("Author not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "index",
                ]
            );
        }  

        if (!$author->delete()) {
            foreach ($author->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "author",
                    "action"     => "view",
                ]
            );
        }

        $this->flash->success("Author deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "author",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new AuthorForm;
        $this->view->form = new AuthorForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "author",
                "action"     => "index",
            ]  
        );  
    }
}
