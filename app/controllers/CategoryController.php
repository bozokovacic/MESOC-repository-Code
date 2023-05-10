<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CategoryController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Category');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new CategoryForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Category", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $category = Category::find($parameters);
        if (count($category) == 0) {
            $this->flash->notice("Category is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $category,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->category = $category;
    }

     public function viewAction()
    {
        $numberPage = 1;
        
        $category = Category::find(
                [
                'order'      => 'ID_Category',   
                ]
                );
        
        if (count($category) == 0) {
            $this->flash->notice("Category is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $category,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->category = $category;
    }
    
    /**
     * Shows the form to create a new category
     */
    public function newAction()
    {
       $this->view->form = new CategoryForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Category)
    {

        if (!$this->request->isPost()) {

            $category = Category::findFirst("ID_Category = '$ID_Category'");
            if (!$category) {
                $this->flash->error("Category not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "category",
                        "action"     => "view",
                    ]
                );
            }

            $this->view->form = new CategoryForm($category, ['edit' => true]);
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
                    "controller" => "category",
                    "action"     => "view",
                ]
            );
        }

        $form = new CategoryForm;
        $category = new Category();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $category)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "new",
                ]
            );
        }

        if ($category->save() == false) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Category successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "category",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Category
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }

        $ID_Category = $this->request->getPost("ID_Category", "string");

        $category = Category::findFirst("ID_Category = '$ID_Category'");
        
        if (!$category) {
            $this->flash->error("Category does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }

        $form = new CategoryForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $category)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "new",
                ]
            );
        }

        if ($category->save() == false) {
			
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Category successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "category",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
   public function deleteAction($ID_Category)
    {
         
       $category = Category::findFirst("ID_Category = '$ID_Category'");
        
       $this->view->form = new CategoryForm($category, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Category = $this->request->getPost("ID_Category", "string");

/**        $this->view->disable();
        echo "Evo".$CategoryName." ".$ID_Category;   */
        
        $category = Category::findFirst("ID_Category = '$ID_Category'");
        if (!$category) {
            $this->flash->error("Category not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }  

        if (!$category->delete()) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "category",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Category deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "category",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new CategoryForm;
        $this->view->form = new CategoryForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "category",
                "action"     => "index",
            ]  
        );  
    }
}
