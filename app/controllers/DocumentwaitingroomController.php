<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class DocumentwaitingroomController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Documentwaitingroom');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new DocumentwaitingroomForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Documentwaitingroom", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $documentwaitingroom = Documentwaitingroom::find($parameters);
        if (count($documentwaitingroom) == 0) {
            $this->flash->notice("Documentwaitingroom is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $documentwaitingroom,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->documentwaitingroom = $documentwaitingroom;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $auth = $this->session->get('auth');
        $id = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];
        
/**        if ($ID_Role == 4) {
              $documentwaitingroom = Documentwaitingroom::find(); 
            } else {  
                $documentwaitingroom = Documentwaitingroom::find(["ID_Partner = '$ID_Partner'",
                    ]);
        } */
        
        $documentwaitingroom = Documentwaitingroom::find(); 
              
        foreach ($documentwaitingroom as $docwaitingroom) {
            
            $ID_Doc = $docwaitingroom->ID_Doc;
        
            $documentwaitingroomsocialimpact = Documentwaitingroomsocialimpact::find(" ID_Doc = '$ID_Doc'");

            if ( count($documentwaitingroomsocialimpact) == 0) {
            
                $socimpacts = $docwaitingroom->socimpacts;
                $socimpact = explode ("|",$socimpacts);
                $transitionvar = array();
                $transitionvars = $docwaitingroom->transitionvar;
                $transitionvar = explode ("~",$transitionvars);               

                $n = 0;
                foreach ( $socimpact as $impact) {
                       
                    $socialimpact = Socialimpact::findFirst( " SocImpactName = '$impact' ");
            
                    if ( $socialimpact ) {
                
                        $ID_SocImpact = $socialimpact->ID_SocImpact;
//                        echo $impact.' '.$ID_SocImpact.'<BR>'; 
                    }
                    
                        $documentwaitingroomsocialimpact = new Documentwaitingroomsocialimpact();
                        $documentwaitingroomsocialimpact->ID_Doc = $ID_Doc;
                        $documentwaitingroomsocialimpact->ID_SocImpact = $ID_SocImpact;

                        if ($documentwaitingroomsocialimpact->save() == false) {
			
                            foreach ($documentwaitingroomsocialimpact->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                                return $this->dispatcher->forward(
                                    [
                                        "controller" => "documentwaitingroom",
                                        "action"     => "view",
                                    ]
                                );
                          }                
                     }                                       
            }    

            $documentwaitingroomculturaldomain = Documentwaitingroomculturaldomain::find(" ID_Doc = '$ID_Doc'");
                        
            if ( count($documentwaitingroomculturaldomain) == 0 ) { 
                
                $culturaldomains = $docwaitingroom->culturaldomains;
                $culturaldomain = explode ("|",$culturaldomains);
        
                foreach ( $culturaldomain as $cultural) {

                    $culturaldomain = Culturaldomain::findFirst( " CultDomainName = '$cultural' ");

                    $ID_CultDomain = $culturaldomain->ID_CultDomain;
                    $documentwaitingroomculturaldomain = new Documentwaitingroomculturaldomain();
                    $documentwaitingroomculturaldomain->ID_Doc = $ID_Doc;
                    $documentwaitingroomculturaldomain->ID_CultDomain = $ID_CultDomain;

                    if ($documentwaitingroomculturaldomain->save() == false) {
			
                        foreach ($documentwaitingroomculturaldomain->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "documentwaitingroom",
                                    "action"     => "view",
                                ]
                            );
                        }
                    }
                }    
                
            $imporeteddocument = Importeddocument::findFirst( " ID_Waitingroom = '$ID_Doc'");
            $linktodocument = $imporeteddocument->file;
            $downloadlink = '<a target = "_blank" href="/../'.$linktodocument.'" class="btn btn-default"><i class="glyphicon glyphicon-download"></i>   Download   </a>';
            $docwaitingroom->downloadlink = $downloadlink;
//            die(var_dump($docwaitingroom));
            
            if ($docwaitingroom->save() == false) {
			
                foreach ($docwaitingroom->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "view",
                    ]
                );
             }
            
        }
    
        $documentwaitingroom = Documentwaitingroom::find( " checked = 0 " ); 
        
        if (count($documentwaitingroom) == 0) {
            $this->flash->notice("Documentwaitingroom is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "new",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $documentwaitingroom,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->documentwaitingroom = $documentwaitingroom;
    }
    
     /**
     * Pregled svojstava documentwaitingroom
     */
    public function pregledAction($ID_Doc){
        
        $numberPage = 1;
        
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
        //$documentwaitingroomview = $documentwaitingroom->Documentwaitingroomview;
        
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        if (count($documentwaitingroom) == 0) {
            $this->flash->notice("Documentwaitingroom not found");
        }
        $documentwaitingroomview = '';       
                
        $documentwaitingroomcultldomain = Documentwaitingroomculturaldomain::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentwaitingroomcultldomain) > 0) {
            
            $documentwaitingroomview .= ' <H4>CULTURAL DOMAIN</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL DOMAIN NAME</th></tr></thead><tbody><tr>';
       
                $documentwaitingroomcultdomain = "SELECT CD.CultDomainName FROM documentwaitingroomculturaldomain DC INNER JOIN culturaldomain CD ON CD.ID_CultDomain = DC.ID_CultDomain WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($documentwaitingroomcultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                foreach ($resultGeneral as $row => $result) {
                     $documentwaitingroomview .= '<td>'.$result['CultDomainName'].'</td></tr>';
                 }
       
            $documentwaitingroomview .=  '</tbody></table>';

        }
        
        $documentwaitingroomsocimpact = Documentwaitingroomsocialimpact::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentwaitingroomsocimpact) > 0) {
            
            $documentwaitingroomview .= ' <H4>SOCIAL IMPACT</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL DOMAIN NAME</th></tr></thead><tbody><tr>';
       
                $documentwaitingroomsocimpact = "SELECT SC.SocImpactName FROM documentwaitingroomsocialimpact DS INNER JOIN socialimpact SC ON SC.ID_SocImpact = DS.ID_SocImpact WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($documentwaitingroomsocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $documentwaitingroomview .= '<td>'.$result['SocImpactName'].'</td></tr>';
                 }
       
            $documentwaitingroomview .=  '</tbody></table>';

        }
                            
        $documentwaitingroom->documentwaitingroomview = $documentwaitingroomview;
            
        $this->view->documentwaitingroom  = $documentwaitingroom;
                    
        if ($documentwaitingroom->save() == false) {
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
        
        $paginator = new Paginator(array(
            "data"  => $documentwaitingroom,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }
    
    /**
     * Shows the form to create a new documentwaitingroom
     */
    public function newAction()
    {
       $this->view->form = new DocumentwaitingroomForm(null, ['edit' => true] );
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Doc)
    {

        $documentwaitingroom = $this->dispatcher->getParam("documentwaitingroom");
        
        if (!$this->request->isPost()) {

            $documentwaitingroom = Documentwaitingroom::findFirst("ID_Doc = '$ID_Doc'");
            if (!$documentwaitingroom) {
                $this->flash->error("Documentwaitingroom not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "index",
                    ]
                );
            }
            
                $numberPage = 1;
       
/**         if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }  */
        
//        $keyword = $this->dispatcher->getParam("keyword");
            
        $ID_Category = 0;
//die(var_dump($documentwaitingroom));        
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        $transitionvar = $documentwaitingroom->transitionvar;
        $keywordtv = $documentwaitingroom->keywordtv;
        
        $this->view->form = new DocumentwaitingroomForm($documentwaitingroom, ['edit' => true]);
//        die(var_dump($documentwaitingroom));
        
/**        $culturaldomain = Culturaldomain::find();
        
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $documentwaitingroomcultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CULTURAL DOMAIN</th></tr></thead><tbody><tr>';        

            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $documentwaitingroomculturaldomain = Documentwaitingroomculturaldomain::find("(ID_Doc = '$ID_Doc' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($documentwaitingroomculturaldomain) > 0) {
                    $documentwaitingroomcultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/documentwaitingroom/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $documentwaitingroomcultview .= '<td></td><td width="7%"><a href="/documentwaitingroom/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$CultDomainName.'</td></tr>';
                }   
          }
        }   

            $documentwaitingroomcultview .=  '</tbody></table>';            
                   
        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
              $documentwaitingroomsocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';

            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
                  
              $documentwaitingroomsocialimpact = Documentwaitingroomsocialimpact::find("(ID_Doc = '$ID_Doc' AND ID_SocImpact ='$ID_SocImpact')");                         
              if (count($documentwaitingroomsocialimpact) > 0) {
                    $documentwaitingroomsocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/documentwaitingroom/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';   
                } else {
                    $documentwaitingroomsocview .= '<td></td><td width="7%"><a href="/documentwaitingroom/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$SocImpactName.'</td></tr>';
                }   
           }
        }   

        $documentwaitingroomsocview .=  '</tbody></table>';        
                
        $documentwaitingroomcultdomainsocimpact = $documentwaitingroomcultview.$documentwaitingroomsocview; 
  
        $documentwaitingroom->documentwaitingroomcultdomainsocimpact = $documentwaitingroomcultdomainsocimpact; */
        
/**        if ($documentwaitingroom->save() == false) {
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        }  */
        
//        $documentwaitingroom = Documentwaitingroom::find(" ID_Doc = '$ID_Doc'");
        
//        $this->view->documentwaitingroom  = $documentwaitingroom;        
                  
            $this->view->form = new DocumentwaitingroomForm($documentwaitingroom, ['edit' => true]);
        }
    }

    /**
     * Creates a 
     */
/**    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "new",
                ]
            );
        }

        $form = new DocumentwaitingroomcasestudyForm;
        $documentwaitingroom = new Documentwaitingroom();
        
        $auth = $this->session->get('auth');
        $ID_User = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];
        $documentwaitingroom->ID_User = $ID_User;
        $documentwaitingroom->ID_Role = $ID_Role;
        $documentwaitingroom->ID_Partner = $ID_Partner;
        $documentwaitingroom->Created_at = new Phalcon\Db\RawValue('now()');
        $documentwaitingroom->Checked = 'NO';
        $documentwaitingroom->ID_Doc = 0;
        
        $data = $this->request->getPost();
//        print_r($data);
//        die(var_dump($data));
        if (!$form->isValid($data, $documentwaitingroom)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "new",
                ]
            );
        }

        if ($documentwaitingroom->save() == false) {
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Documentwaitingroom successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "documentwaitingroom",
                "action"     => "view",
            ]
        );
    }  */

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Doc
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "index",
                ]
            );
        }

        $ID_Doc = $this->request->getPost("ID_Doc", "string");

        $documentwaitingroom = Documentwaitingroom::findFirst("ID_Doc = '$ID_Doc'");
        if (!$documentwaitingroom) {
            $this->flash->error("Documentwaitingroom does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        }
        
        $socimpacts = $documentwaitingroom->socimpacts;
        $socimpact = explode ("|",$socimpacts);
        
        foreach ( $socimpact as $impact) {
            
            
                $socalimpact = Socialimpact::findFirst( " SocImpactName = '$impact' ");
            
                if ( $socalimpact ) {
                
                    $ID_SocImpact = $socalimpact->ID_SocImpact;
                    echo $impact.' '.$ID_SocImpact.'<BR>'; 
                }
            
            
                $documentwaitingroomsocialimpact = new Documentwaitingroomsocialimpact();
                $documentwaitingroomsocialimpact->ID_Doc = $ID_Doc;
                $documentwaitingroomsocialimpact->ID_SocImpact = $ID_SocImpact;

                if ($documentwaitingroomsocialimpact->save() == false) {
			
                   foreach ($documentwaitingroomsocialimpact->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                        return $this->dispatcher->forward(
                            [
                                "controller" => "documentwaitingroom",
                                "action"     => "view",
                            ]
                        );
                    }                
            }        

            $culturaldomains = $documentwaitingroom->culturaldomains;
            $culturaldomain = explode ("|",$culturaldomains);
//            die(var_dump($culturaldomain));
        
            foreach ( $culturaldomain as $cultural) {

                $culturaldomain = Culturaldomain::findFirst( " CultDomainName = '$cultural' ");

                $ID_CultDomain = $culturaldomain->ID_CultDomain;
                $documentwaitingroomculturaldomain = new Documentwaitingroomculturaldomain();
                $documentwaitingroomculturaldomain->ID_Doc = $ID_Doc;
                $documentwaitingroomculturaldomain->ID_CultDomain = $ID_CultDomain;

                if ($documentwaitingroomculturaldomain->save() == false) {
			
                   foreach ($documentwaitingroomculturaldomain->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                        return $this->dispatcher->forward(
                            [
                                "controller" => "documentwaitingroom",
                                "action"     => "view",
                            ]
                        );
                    }
                
            }
        
        $form = new DocumentwaitingroomForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $documentwaitingroom)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "new",
                ]
            );
        }
        
        $documentwaitingroom->Created_at = new Phalcon\Db\RawValue('now()');

        if ($documentwaitingroom->save() == false) {
			
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Documentwaitingroom successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "documentwaitingroom",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Doc)
    {
         
       $documentwaitingroom = Documentwaitingroom::findFirst("ID_Doc = '$ID_Doc'");
        
       $this->view->form = new DocumentwaitingroomForm($documentwaitingroom, ['edit' => true]);
       
    }
    
    
    public function deleteConfirmAction()
    { 
        $ID_Doc = $this->request->getPost("ID_Doc", "string");

/**        $this->view->disable();
           echo "Evo".$DocumentwaitingroomName." ".$ID_Doc;   */
        
        $documentwaitingroom = Documentwaitingroom::findFirst("ID_Doc = '$ID_Doc'");
        if (!$documentwaitingroom) {
            $this->flash->error("Documentwaitingroom not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "index",
                ]
            );
        }  

        if (!$documentwaitingroom->delete()) {
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Documentwaitingroom deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "documentwaitingroom",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new DocumentwaitingroomForm;
        $this->view->form = new DocumentwaitingroomForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "documentwaitingroom",
                "action"     => "index",
            ]  
        );  
    }
    
     public function documentwaitingroomcultdomainsocimpactAction($ID_Doc) {
               
       $this->session->set("ID_Doc", "$ID_Doc");
        
        $numberPage = 1;
       
        $documentwaitingroom = $this->dispatcher->getParam("documentwaitingroom");              
                   
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
        
        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $documentwaitingroomcultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CULTURAL DOMAIN</th></tr></thead><tbody><tr>';        
                           
            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $documentwaitingroomculturaldomain = Documentwaitingroomculturaldomain::find("(ID_Doc = '$ID_Doc' AND ID_CultDomain ='$ID_CultDomain')");                         

                if (count($documentwaitingroomculturaldomain) > 0) {
                    $documentwaitingroomcultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/documentwaitingroom/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $documentwaitingroomcultview .= '<td></td><td width="7%"><a href="/documentwaitingroom/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
          }
        }   

        $documentwaitingroomcultview .=  '</tbody></table>';            

        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $documentwaitingroomsocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';        
                           
            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
           
/**              $this->view->disable();
              echo "Evo".$ID_Doc." ".$ID_SocImpact;  */
        
              $documentwaitingroomsocialimpact = Documentwaitingroomsocialimpact::find("(ID_Doc = '$ID_Doc' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($documentwaitingroomsocialimpact) > 0) {
                    $documentwaitingroomsocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/documentwaitingroom/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink social impact <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $documentwaitingroomsocview .= '<td></td><td width="7%"><a href="/documentwaitingroom/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link social impact </a></td><td>'.$SocImpactName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

        $documentwaitingroomsocview .=  '</tbody></table>';        

        $documentwaitingroom->documentcultdomainview = $documentwaitingroomcultview;
        $documentwaitingroom->documentsocimpactview = $documentwaitingroomsocview;
  
          
        if ($documentwaitingroom->save() == false) {
            foreach ($documentwaitingroom->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                ]
            );
        }
        
        //$documentwaitingroomculturaldomain = Documentwaitingroomculturaldomain::find(" ID_Doc = '$ID_Doc'");
        $documentwaitingroom = Documentwaitingroom::find(" ID_Doc = '$ID_Doc'");
        
        $paginator = new Paginator(array(
            "data"  => $documentwaitingroomculturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }      
        
        $documentwaitingroom = Documentwaitingroom::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
        
       
        $documentwaitingroomculturaldomain = new Documentwaitingroomculturaldomain();
        
        $documentwaitingroomculturaldomain->ID_Doc = $ID_Doc;
        $documentwaitingroomculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($documentwaitingroomculturaldomain->save() == false) {            
            foreach ($documentwaitingroomculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
               
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
       
        $documentwaitingroomculturaldomain = new Documentwaitingroomculturaldomain();
        
        $documentwaitingroomculturaldomain->ID_Doc = $ID_Doc;
        $documentwaitingroomculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($documentwaitingroomculturaldomain->delete() == false) {            
            foreach ($documentwaitingroomculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]         
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
       
        $documentwaitingroomsocialimpact = new Documentwaitingroomsocialimpact();
        
        $documentwaitingroomsocialimpact->ID_Doc = $ID_Doc;
        $documentwaitingroomsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($documentwaitingroomsocialimpact->save() == false) {            
            foreach ($documentwaitingroomsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
               
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
       
        $documentwaitingroomsocialimpact = new Documentwaitingroomsocialimpact();
        
        $documentwaitingroomsocialimpact->ID_Doc = $ID_Doc;
        $documentwaitingroomsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($documentwaitingroomsocialimpact->delete() == false) {            
            foreach ($documentwaitingroomsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]
                    
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentwaitingroom",
                    "action"     => "documentwaitingroomcultdomainsocimpact",
                    "params"     => [$ID_Doc]           
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }   

    public function checkAction($ID_Doc)
    {
        $numberPage = 1;
     
        $this->session->set("ID_Doc", "$ID_Doc");        
        
        $documentwaitingroom = Documentwaitingroom::findFirst(" ID_Doc = '$ID_Doc'");
        
        $this->view->documentwaitingroom  = $documentwaitingroom;
        $ID_Template = $ID_Doc;                        // ID_Template nije ID od Template za Cities (Rijeka, Milano) 
        
        $document = Document::findFirst(" ID_Template = '$ID_Template'");
        
        if ( !$document )  $document = new Document();
        
        $document->ID_Template = $documentwaitingroom->ID_Doc;
        $document->PubYear = $documentwaitingroom->PubYear;
        $document->Title = $documentwaitingroom->Title;
        $document->NumPages = $documentwaitingroom->NumPages;
        $document->ID_Template = $documentwaitingroom->ID_Doc;
        $document->Summary = $documentwaitingroom->Summary;
        $keyword = $documentwaitingroom->Keywords;
        $keyword = str_replace("|",";",$keyword);
        $document->Keywords = $keyword;
        $document->ID_Language = $documentwaitingroom->ID_Language;
        $document->ID_Type = $documentwaitingroom->ID_Type;
        $document->ID_Category = $documentwaitingroom->ID_Category;
        $document->ID_Template = $documentwaitingroom->ID_Doc;
        $document->documentculturaldomain = $documentwaitingroom->Documentculturaldomain;
        $document->documentsocialimpact = $documentwaitingroom->Documentsocialimpact;

        if ($document->save() == false) {            
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                   "controller" => "documentwaitingroom",
                   "action"     => "documentwaitingroomcultdomainsocimpact",
                   "params"     => [$ID_Doc]
                ]
            );
        }  

        $document = Document::findFirst(" ID_Template = '$ID_Template'");

        $ID_Doc_upis = $document->ID_Doc;
                    
        $keywords = $documentwaitingroom->Keywords;       
        $keyword_list = explode("|",$keywords);

        foreach ( $keyword_list as $key_list ) {
         
          if ( strlen($key_list) > 0 ) {
              
            $keyword = Keyword::findFirst(" KeywordName = '$key_list' ");
            
            if (!$keyword) {
                
                $keyword = new Keyword();
                $keyword->KeywordName = $key_list;
                $keyword->KeywordDescription = '..';
       
                if ($keyword->save() == false) {            
                    foreach ($keyword->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentwaitingroom",
                            "action"     => "documentwaitingroomcultdomainsocimpact",
                            "params"     => [$ID_Doc]
                        ]
                    );
                } 
                
                $keyword = Keyword::findFirst(" KeywordName = '$key_list' ");
                
            } else {
                
                $ID_Keyword = $keyword->ID_Keyword;
                $Keywordname = $keyword->KeywordName;
                $dockeyword = new Dockeyword();
                $dockeyword->ID_Doc = $ID_Doc_upis;
                $dockeyword->ID_Keyword = $ID_Keyword;

                if ($dockeyword->save() == false) {            
                    foreach ($dockeyword->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentwaitingroom",
                            "action"     => "documentwaitingroomcultdomainsocimpact",
                            "params"     => [$ID_Doc]
                        ]
                    );
                }                                   
                
            }            
          }   
        }

        $documentwaitingroomsocialimpact = Documentwaitingroomsocialimpact::find( " ID_Doc = $ID_Template");
        
        foreach ( $documentwaitingroomsocialimpact as $socialimpact ) {
            
            $ID_SocImpact = $socialimpact->ID_SocImpact;
            $documentsocialimpact = new Documentsocialimpact();
            $documentsocialimpact->ID_Doc = $ID_Doc_upis;
            $documentsocialimpact->ID_SocImpact = $ID_SocImpact;
            
            if ($documentsocialimpact->save() == false) {            
                    foreach ($documentsocialimpact->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentwaitingroom",
                            "action"     => "documentwaitingroomcultdomainsocimpact",
                            "params"     => [$ID_Doc]
                        ]
                    );
                }
        }
        
        $documentwaitingroomculturaldomain = Documentwaitingroomculturaldomain::find( " ID_Doc = $ID_Template" );

        foreach ( $documentwaitingroomculturaldomain as $culturaldomain ) {
            
            $ID_CultDomain = $culturaldomain->ID_CultDomain;
            $documentculturaldomain = new Documentculturaldomain();
            $documentculturaldomain->ID_Doc = $ID_Doc_upis;
            $documentculturaldomain->ID_CultDomain = $ID_CultDomain;
            
            if ($documentculturaldomain->save() == false) {            
                    foreach ($documentculturaldomain->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentwaitingroom",
                            "action"     => "documentwaitingroomcultdomainsocimpact",
                            "params"     => [$ID_Doc]
                        ]
                    );
                }
        }
        
        $doctransitionvar = Doctransitionvar::find(" ID_Doc = '$ID_Doc_upis' ");
        
        foreach ( $doctransitionvar as $doctranvar) {
            if ($doctranvar->delete() == false) {            
                foreach ($doctranvar->getMessages() as $message) {
                    $this->flash->error($message);
               }
            } 
        }
        
        $socialimpacts = $documentwaitingroom->socimpacts;
        $socialimpact = explode("|",$socialimpacts);
        $n = 0;       
        $tranvars = array();
        $transitionvar = $documentwaitingroom->transitionvar;
        $tranvars = explode("|",$transitionvar);

        foreach ($socialimpact as $impact) {
            
            $socialimpact = Socialimpact::findFirst( " SocImpactName = '$impact' "); {

            if ( $socialimpact ) $ID_SocImpact = $socialimpact->ID_SocImpact;

            $tranvar = explode("#",$tranvars[$n]);
            $n++;

            foreach ($tranvar as $tran) {

                if ( strlen ($tran) > 0) {
                    
                    $transitionvar = Transitionvar::findFirst( " TransvarName = '$tran' "); 
                    
                    if ( $transitionvar ) $ID_Transvar = $transitionvar->ID_Transvar;
                 
                        $transitionvarsocialimpact = new Transitionvarsocialimpact();
                        $transitionvarsocialimpact->ID_SocImpact = $ID_SocImpact;
                        $transitionvarsocialimpact->ID_Transvar = $ID_Transvar;
                        
                        if ($transitionvarsocialimpact->save() == false) {            
                            foreach ($transitionvarsocialimpact->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "documentwaitingroom",
                                    "action"     => "documentwaitingroomcultdomainsocimpact",
                                    "params"     => [$ID_Doc]
                                ]
                             );
                         }  
                         
                    $doctransitionvar = new Doctransitionvar();
                    
                    $doctransitionvar->ID_Doc = $ID_Doc_upis;
                    $doctransitionvar->ID_Transvar = $ID_Transvar;
                    $doctransitionvar->ID_SocImpact = $ID_SocImpact;
                     
                    if ($doctransitionvar->save() == false) {            
                        foreach ($doctransitionvar->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                            [
                                "controller" => "documentwaitingroom",
                                "action"     => "documentwaitingroomcultdomainsocimpact",
                                "params"     => [$ID_Doc]
                            ]
                          );
                        }        
                    }
                }
            }    
        }

        $transitionvarkeywordtv = Transitionvarkeywordtv::find(" ID_Doc = '$ID_Doc_upis' ");
        
        foreach ( $transitionvarkeywordtv as $tranvarkeywordtv) {
            if ($tranvarkeywordtv->delete() == false) {            
                foreach ($tranvarkeywordtv->getMessages() as $message) {
                    $this->flash->error($message);
               }
            } 
        }
        
        $transitionvars = $documentwaitingroom->transitionvar;       
        $keywordtvs = $documentwaitingroom->keywordtv;       
        
        $transitionvar = explode("|",$transitionvars);
        $keywordtv = explode("|",$keywordtvs);

        $n = 1;
        $tranvar_list = array();
        foreach ( $transitionvar as $tranvar ) {

            $tranvar_list[$n] = $tranvar;
            $n++;
            
            }

        $m = 1;
        $key_list = array();
        foreach ( $keywordtv as $key ) {
            
            $key_list[$m] = $key;
            $m++;
            
            } 

        $j = 1;
        for ( $i = 1; $i < $n; $i++ ) {        
            
          $tran_list_join = $tranvar_list[$i];
          if ( strlen ($tran_list_join) > 0) {    
              
            $tran_lists  = explode("#",$tran_list_join);
            $keyword_list = $key_list[$i];    
            $keyword_detail = explode('#',$keyword_list);
            $j = 1;
            $key_list_detail = array();
            foreach ( $keyword_detail as $key_detail) {
              $key_list_detail[$j] = $key_detail;
              $j++;
            }              

            $j = 1;
            foreach ( $tran_lists as $tran_list) {
               
//                echo $tran_list.'<BR>';  

                $transitionvar = Transitionvar::findFirst(" TransvarName = '$tran_list' ");
          
                if (!$transitionvar) {
                
                    $transitionvar = new Transitionvar();
                    $transitionvar->TransvarName = $tran_list;
                    $transitionvar->TransvarDescription = '..';
 
                if ( $transitionvar->save() == false) {            
                    foreach ($transitionvar->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "documentwaitingroom",
                            "action"     => "documentwaitingroomcultdomainsocimpact",
                            "params"     => [$ID_Doc]
                        ]
                    );
                  } 
                
                $transitionvar = Transitionvar::findFirst(" TransvarName = '$tran_list' ");
                                
               }                 
                $ID_Transvar = $transitionvar->ID_Transvar;                           
             
                $keyword_list_detail = explode('~',$key_list_detail[$j]);
                $j++;

                foreach ( $keyword_list_detail as $key_detail) {

                  if ( strlen ($key_detail) > 0) {
 //                   echo 'Keyword '.$key_detail.'<BR>';
                    $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$key_detail' ");

                    if (!$keywordtv) {
                
                        $keywordtv = new Keywordtv();
                        $keywordtv->KeywordtvName = $key_detail;
                        $keywordtv->KeywordtvDescription = '..';

                        if ( $keywordtv->save() == false) {            
                            foreach ($keywordtv->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "documentwaitingroom",
                                    "action"     => "documentwaitingroomcultdomainsocimpact",
                                    "params"     => [$ID_Doc]
                                ]
                            );
                        } 
                
                        $keywordtv = Keywordtv::findFirst(" KeywordtvName = '$key_detail' ");
                
                    }                 
                  
                    $ID_Keywordtv = $keywordtv->ID_Keywordtv;
                    $transitionvarkeywordtv = new Transitionvarkeywordtv();
                    $transitionvarkeywordtv->ID_Doc = $ID_Doc_upis;
                    $transitionvarkeywordtv->ID_Transvar = $ID_Transvar;
                    $transitionvarkeywordtv->ID_Keywordtv = $ID_Keywordtv;
// die(var_dump($transitionvarkeywordtv));
                    if ($transitionvarkeywordtv->save() == false) {            
                        foreach ($transitionvarkeywordtv->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(
                            [
                                "controller" => "documentwaitingroom",
                                "action"     => "documentwaitingroomcultdomainsocimpact",
                                "params"     => [$ID_Doc]
                             ]
                        );
                    }                                                         
                  }
                } 
              }  
            }    
        }                            
        
        if (count($documentwaitingroom) == 0) {
            $this->flash->notice("Documentwaitingroom is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        }             

        $documentwaitingroom = Documentwaitingroom::findFirst( " ID_Doc = '$ID_Template' ");
        $ID_City = $documentwaitingroom->city;
        
        $doccity = new Doccity();
        $doccity->ID_Doc = $ID_Doc_upis;
        $doccity->ID_City = $ID_City;
        
        if ($doccity->save() == false) {            
                foreach ($doccity->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "documentwaitingroomcultdomainsocimpact",
                        "params"     => [$ID_Doc]
                    ]
                );
          }     
        
        $documentwaitingroom->checked = 1;
        
        if ($documentwaitingroom->save() == false) {            
                foreach ($documentwaitingroom->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "documentwaitingroomcultdomainsocimpact",
                        "params"     => [$ID_Doc]
                    ]
                );
          }     

        $importeddocument = Importeddocument::findFirst( " ID_Waitingroom = '$ID_Template' ");
        
        $importeddocument->ID_Document = $ID_Doc_upis;
        
        if ($importeddocument->save() == false) {            
                foreach ($importeddocument->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "documentwaitingroomcultdomainsocimpact",
                        "params"     => [$ID_Doc]
                    ]
                );
          }     
          
        return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
    }
     
    
    public function deletedocumentAction($ID_Doc) {
 
        $documentwaitingroom = Documentwaitingroom::findFirst( " ID_Doc = '$ID_Doc' ");
        $documentwaitingroom->checked = 2;
        
        if ($documentwaitingroom->save() == false) {            
                foreach ($documentwaitingroom->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "documentwaitingroomcultdomainsocimpact",
                        "params"     => [$ID_Doc]
                    ]
                );
          }
          
        return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        
    }
    
    public function definekeywordAction($ID_DocKeyword)
    {
        $numberPage = 1;
       
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }  
        $this->session->set("ID_DocKeyword", "$ID_DocKeyword");
        
 //       echo $ID_Doc,' '.$ID_DocKeyword.' ';
        
        $documentwaitingroomkeyword = Documentwaitingroomkeyword::find("(ID_Doc = '$ID_Doc' AND ID_DocKeyword ='$ID_DocKeyword')");
 
        $this->view->documentwaitingroomkeyword = $documentwaitingroomkeyword;
        
//          $keyword = $documentwaitingroomkeyword->Keyword;
//        die(var_dump($documentwaitingroomkeyword));
/**        foreach ($documentwaitingroomkeyword as $result) {             
              $keyword = $result->Keyword;
            }  */   
                    
//        echo $keyword;
          
        if (count($documentwaitingroomkeyword) == 0) {
            $this->flash->notice("Documentwaitingroom is not found.");
            return $this->dispatcher->forward(
                [
                    "controller" => "documentwaitingroom",
                    "action"     => "view",
                ]
            );
        }
        
/**        $Keyword = new Keyword();
                
                $query = "SELECT K.KeywordName FROM Keyword K WHERE K.KeywordName LIKE '$keyword'";        
                echo $query;
                $keyword = $this->db->query($query);
        
        $this->view->keyword  = $keyword;
        
        die(var_dump($keyword)); */
        
        $paginator = new Paginator([
            "data"  => $documentwaitingroomkeyword,
            "limit" => 10,
            "page"  => $numberPage
        ]);  

        $this->view->page = $paginator->getPaginate(); 
        $this->view->form = new KeywordForm;
    }
 
        public function doctransitionvarAction()
    {
        $numberPage = 1;
                      
        $doctransitionvar = Doctransitionvar::find();
 
        foreach ( $doctransitionvar as $doctran ){
            
            $ID_Doc = $doctran->ID_Doc;
            $ID_Transvar = $doctran->ID_Transvar;
            
            $transitionvarsocialimpact = Transitionvarsocialimpact::findFirst( " ID_Transvar = '$ID_Transvar'" );
            
//            die(var_dump($transitionvarsocialimpact));
            
            $ID_SocImpact = $transitionvarsocialimpact->ID_SocImpact;
            
            $doctransitionvar1 = new Doctransitionvar1();
            
            $doctransitionvar1->ID_Doc = $ID_Doc;
            $doctransitionvar1->ID_Transvar = $ID_Transvar;
            $doctransitionvar1->ID_SocImpact = $ID_SocImpact;
            
//            die(var_dump($doctransitionvar));
            
            if ($doctransitionvar1->save() == false) {            
                foreach ($doctransitionvar1->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "documentwaitingroom",
                        "action"     => "documentwaitingroomcultdomainsocimpact",
                    ]
                );
          }
          
        }
        
    }
    
}
