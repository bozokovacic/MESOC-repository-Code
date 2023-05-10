<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 public function linksinstitutionAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");
        if (count($docinstitution) == 0) {
            $this->flash->notice("Institution not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docinstitution,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new InstitutionForm;
        
    }
    
       public function institutionviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docinstitution = Docinstitution::find("ID_Doc = '$ID_Doc'");
        if (count($docinstitution) == 0) {
            $this->flash->notice("Institution not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docinstitution,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function institutionsearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Institution", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $institution = Institution::find($parameters);
        if (count($institution) == 0) {
            $this->flash->notice("Institution is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $institution,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->institution = $institution;
    }

    public function institutionaddAction($ID_Institution){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docinstitution = new Docinstitution();
           
        $docinstitution->ID_Doc = $ID_Doc;
        $docinstitution->ID_Institution = $ID_Institution;
        
     
        $docinstitution->ID_Institution = $ID_Institution;
        
        if ($docinstitution->save() == false) {            
            foreach ($docinstitution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );      
    }
    
      public function institutiondeleteAction($ID_Institution){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docinstitution = new Docinstitution();
        
        $docinstitution->ID_Doc = $ID_Doc;
        $docinstitution->ID_Institution = $ID_Institution;
        
        if (!$docinstitution->delete()) {
            foreach ($docinstitution->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            );
        }
           
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "institutionview",
                ]
            ); 
    }

