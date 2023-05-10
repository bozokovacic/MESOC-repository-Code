<?php

public function countryselectTeritconAction($ID_Research){
                      
        $this->session->set("ID_Research", "$ID_Research");
        
           
            return $this->dispatcher->forward(
                [
                    "controller" => "teritcon",
                    "action"     => "view",
                ]
            );        
    }
    
    public function countryaddTeritconAction($ID_TeritCon){
       
        if ($this->session->has("ID_Research")) {
            // Retrieve its value
            $ID_Research = $this->session->get("ID_Research");
        }
        
        $doccountry = Doccountry::findFirst($ID_Research); 
        
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $ID_City = $doccountry->ID_City;   
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Region.' '.$ID_Country.' '.$ID_City ;  */
                  
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->ID_City = $ID_City; 
        $doccountry->ID_TeritCon = $ID_TeritCon; 
                         
//      die(var_dump($doccountry));
      
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
         
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }
    
    public function countrydelTeritconAction($ID_Research){
             
        $doccountry = Doccountry::findFirst($ID_Research); 
        $ID_Doc = $doccountry->ID_Doc;
        $ID_Country = $doccountry->ID_Country;
        $ID_Region = $doccountry->ID_Region;   
        $ID_City = $doccountry->ID_city;   
        
/**        $this->view->disable();
        echo 'Hej - '.$ID_Research.' '.$ID_Doc.' '.$ID_Region.' '.$ID_Country ;  */
    
        $doccountry = new Doccountry();
        
        $doccountry->ID_Research = $ID_Research;
        $doccountry->ID_Doc = $ID_Doc;
        $doccountry->ID_Region = $ID_Region;
        $doccountry->ID_Country = $ID_Country;
        $doccountry->ID_City = $ID_City;
        $doccountry->ID_TeritCon = 1;
        
        if ($doccountry->save() == false) {            
            foreach ($doccountry->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );
        }
               
            return $this->dispatcher->forward(
                [
                    "controller" => "documentresearch",
                    "action"     => "countryview",
                ]
            );        
    }
