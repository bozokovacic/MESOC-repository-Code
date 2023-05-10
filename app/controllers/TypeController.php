<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TypeController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Type');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new TypeForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Type", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $type = Type::find($parameters);
        if (count($type) == 0) {
            $this->flash->notice("Type is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $type,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->type = $type;
    }

     public function viewAction()
    {
        $numberPage = 1;
        
        $type = Type::find(
                [
                'order'      => 'ID_Type',   
                ]
                );
        
        if (count($type) == 0) {
            $this->flash->notice("Type is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $type,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->type = $type;
    }
    
    /**
     * Shows the form to create a new type
     */
    public function newAction()
    {
       $this->view->form = new TypeForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Type)
    {

        if (!$this->request->isPost()) {

            $type = Type::findFirst("ID_Type = '$ID_Type'");
            if (!$type) {
                $this->flash->error("Type not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "type",
                        "action"     => "view",
                    ]
                );
            }

            $this->view->form = new TypeForm($type, ['edit' => true]);
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
                    "controller" => "type",
                    "action"     => "view",
                ]
            );
        }

        $form = new TypeForm;
        $type = new Type();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $type)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "new",
                ]
            );
        }

        if ($type->save() == false) {
            foreach ($type->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Type successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "type",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Type
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }

        $ID_Type = $this->request->getPost("ID_Type", "string");

        $type = Type::findFirst("ID_Type = '$ID_Type'");
        
        if (!$type) {
            $this->flash->error("Type does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }

        $form = new TypeForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $type)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "new",
                ]
            );
        }

        if ($type->save() == false) {
			
            foreach ($type->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Type successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "type",
                "action"     => "view",
            ]
        );
    }

    /**
     * Deletes a vlafon
     *
     * @param string $SIFVL
     */
   public function deleteAction($ID_Type)
    {
         
       $type = Type::findFirst("ID_Type = '$ID_Type'");
        
       $this->view->form = new TypeForm($type, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Type = $this->request->getPost("ID_Type", "string");

/**        $this->view->disable();
        echo "Evo".$TypeName." ".$ID_Type;   */
        
        $type = Type::findFirst("ID_Type = '$ID_Type'");
        if (!$type) {
            $this->flash->error("Type not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }  

        if (!$type->delete()) {
            foreach ($type->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Type deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "type",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new TypeForm;
        $this->view->form = new TypeForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "type",
                "action"     => "index",
            ]  
        );  
    }

    public function categoryAction($ID_Type)
    {
        
        $numberPage = 1;                          
        
        $type = Type::findFirst(" ID_Type = '$ID_Type'");
        
        $DocType = $type->DocType;
        
        $this->session->set("ID_Type", "$ID_Type");
        $this->session->set("DocType", "$DocType");
       
        $category = Category::find();
               
        $typecategory = Typecategory::find( 
                [
                    "ID_Type = '$ID_Type'",
                    'order'  => 'ID_Category', 
                ] 
                );
        
        $categorylist = '';
        
        if ( count($typecategory) == 0 ) {

                $categorylist .= 'Category is not selected'; 
                
            } else {                                
                
                foreach ( $typecategory as $typecat ) {
                    
                $ID_Category = $typecat->ID_Category;
            
                $category = Category::findFirst(" ID_Category = '$ID_Category' "); 
                
                $CategoryName = $category->CategoryName;
                    
                switch ($ID_Category){
                    case 1: 
                        $categorylist .= $CategoryName.'<BR>';
                        break;
                    case 2: 
                        $categorylist .= $CategoryName.'<BR>';
                        break;
                    case 3: 
                        $categorylist .= $CategoryName.'<BR>';
                        break;
                    case 4: 
                        $categorylist .= $CategoryName.'<BR>';
                        break;
                }    
            } 
        }
        
        $type = Type::findFirst(" ID_Type = '$ID_Type' ");
        
        $type->Category = $categorylist;
        
        if ($type->save() == false) {
			
            foreach ($type->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "type",
                    "action"     => "view",
                ]
            );
        }
        
        
        $category = Category::find();
        
        $paginator = new Paginator([
            "data"  => $category,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->form = $category;
        $this->view->setVar('ID_Type', $ID_Type);
        $this->view->setVar('DocType', $DocType);
        $this->view->setVar('categorylist', $categorylist);
 
    }
    
    public function addCategoryAction($ID_Category)
    {
  
        if ($this->session->has("ID_Type")) {
            $ID_Type = $this->session->get("ID_Type");
            $DocType = $this->session->get("DocType");
        }     

//        echo $ID_Type.' - '.$DocType.' - '.$ID_Category.'<BR>';
            
        if (!$this->request->isPost()) {
            
            $typecategory = Typecategory::findFirst(" ID_Type = '$ID_Type' AND ID_Category = '$ID_Category' ");
                      
            if (!$typecategory) {

                $typecategory = new TypeCategory();
                
                $typecategory->ID_Type = $ID_Type;
                $typecategory->ID_Category = $ID_Category;
                $typecategory->DocType = $DocType; 
         
                if ($typecategory->save() == false) {
			
                    foreach ($typecategory->getMessages() as $message) {
                        $this->flash->error($message);
                        }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "type",
                            "action"     => "view",
                        ]
                    );
                }
                    
                return $this->dispatcher->forward(
                        [
                            "controller" => "type",
                            "action"     => "category",
                            "params"     => [$ID_Type]
                        ]
                    );
                
            }
            
            return $this->dispatcher->forward(
                    [
                        "controller" => "type",
                        "action"     => "category",
                    ]
                );
            
        }
    }
    
    public function deleteCategoryAction($ID_Category)
    {
  
        if ($this->session->has("ID_Type")) {
            $ID_Type = $this->session->get("ID_Type");
            $DocType = $this->session->get("DocType");
        }     

//        echo $ID_Type.' - '.$DocType.'<BR>';
            
        if (!$this->request->isPost()) {
            
            $typecategory = Typecategory::findFirst(" ID_Type = '$ID_Type' AND ID_Category = '$ID_Category' ");
           
//            die(var_dump($typecategory));
            
            if ($typecategory) {
        
                if ($typecategory->delete() == false) {
			
                    foreach ($typecategory->getMessages() as $message) {
                        $this->flash->error($message);
                        }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "type",
                            "action"     => "view",
                        ]
                    );
                }
                    
                return $this->dispatcher->forward(
                        [
                            "controller" => "type",
                            "action"     => "category",
                            "params"     => [$ID_Type]
                        ]
                    );
                
            }
            
            return $this->dispatcher->forward(
                    [
                        "controller" => "type",
                        "action"     => "category",
                    ]
                );
            
        }
    }
    

}
