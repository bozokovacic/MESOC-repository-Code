<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class KeywordtvController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Keywordtv trans. var.');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new KeywordtvForm; 
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Keywordtv", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $keywordtv = Keywordtv::find($parameters);
        if (count($keywordtv) == 0) {
            $this->flash->notice("Keywordtv is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $keywordtv,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->keywordtv = $keywordtv;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
/**        $numberPage = $this->request->getQuery("page", "int");
        $parameters = [];
        
        $keywordtv = Keywordtv::find($parameters); */
        
        $keywordtv = Keywordtv::find(
                [    
                 'order'      => 'ID_Keywordtv',   
                ]
                );  
        
        if (count($keywordtv) == 0) {
            $this->flash->notice("Keyword transition variable is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $keywordtv,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->keywordtv = $keywordtv;
    }
    
     public function pregledcultdomainAction($ID_Keywordtv){
                
        $this->session->set("ID_Keywordtv", "$ID_Keywordtv");
        
        $numberPage = 1;
       
        $keywordtv = $this->dispatcher->getParam("keywordtv");
            
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
//        die(var_dump($keywordtv));
        
//        $culturaldomain = CulturalDomain::find();
        
        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $keywordtvcultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>KEYWORDS </th><th></th><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';        
                $cultview = ' <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';
           
            foreach ($culturaldomain as $result) {   
                
            $ID_CultDomain = $result->ID_CultDomain;
            $CultDomainName = $result->CultDomainName;
/**        $this->view->disable();
           echo "Evo".$ID_Keywordtv." ".$ID_CultDomain;  */
        
            $keywordtvculturaldomain = Keywordtvculturaldomain::find("(ID_Keywordtv = '$ID_Keywordtv' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($keywordtvculturaldomain) > 0) {
                    $keywordtvcultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keywordtv/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural sector <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $keywordtvcultview .= '<td></td><td width="7%"><a href="/keywordtv/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural sector </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keywordtv/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordtvcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $keywordtvcultview .=  '</tbody></table>';
            $cultview .=  '</tbody></table>';
            
//            echo $keywordtvcultview.'<BR>';    
//            echo $cultview.'<BR>';
            
            $keywordtv->Keywordtvcultdomainview = $keywordtvcultview;
            $keywordtv->Cultdomainview = $cultview;
          
        if ($keywordtv->save() == false) {
            foreach ($keywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }
        
        $keywordtvculturaldomain = Keywordtvculturaldomain::find(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $paginator = new Paginator(array(
            "data"  => $culturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }
    
     public function pregledsocimpactAction($ID_Keywordtv){
        
        $this->session->set("ID_Keywordtv", "$ID_Keywordtv");
        
        $numberPage = 1;
       
        $keywordtv = $this->dispatcher->getParam("keywordtv");
            
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
//        die(var_dump($keywordtv));
        
//        $culturaldomain = CulturalDomain::find();
        
        $socimpact = Socialimpact::find();
        if (count($socimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $keywordtvsocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>KEYWORDS</th><th></th><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';        
                $socview = ' <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';
           
            foreach ($socimpact as $result) {   
                
            $ID_SocImpact = $result->ID_SocImpact;
            $SocImpactName = $result->SocImpactName;
/**        $this->view->disable();
           echo "Evo".$ID_Keywordtv." ".$ID_CultDomain;  */
        
            $keywordtvsocimpact = Keywordtvsocialimpact::find("(ID_Keywordtv = '$ID_Keywordtv' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($keywordtvsocimpact) > 0) {
                    $keywordtvsocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/keywordtv/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cross-over theme <i class="glyphicon glyphicon-hand-right"></i></a><td></td></td></tr>';
                } else {
                    $keywordtvsocview .= '<td></td><td width="7%"><a href="/keywordtv/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cross-over theme </a><td>'.$SocImpactName.'</td></td></tr>';
//                    $socview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/keywordtv/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add social impact</a></td></tr>';
                }   
//            echo $keywordtvcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $keywordtvsocview .=  '</tbody></table>';
            $socview .=  '</tbody></table>';
            
//            echo $keywordtvsocview.'<BR>';    
//            echo $socview.'<BR>';
            
            $keywordtv->Keywordtvsocimpactview = $keywordtvsocview;
            $keywordtv->SocImpactview = $socview;
          
        if ($keywordtv->save() == false) {
            foreach ($keywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }
        
        $keywordtvsocialimpact = Keywordtvsocialimpact::find(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $paginator = new Paginator(array(
            "data"  => $keywordtvsocialimpact,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }

    /**
     * Shows the form to create a new keywordtv
     */
    public function newAction()
    {
       $this->view->form = new KeywordtvForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Keywordtv)
    {

        if (!$this->request->isPost()) {

            $keywordtv = Keywordtv::findFirst("ID_Keywordtv = '$ID_Keywordtv'");
            if (!$keywordtv) {
                $this->flash->error("Keywordtv not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "keywordtv",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new KeywordtvForm($keywordtv, ['edit' => true]);
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
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $form = new KeywordtvForm;
        $keywordtv = new Keywordtv();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $keywordtv)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }

        if ($keywordtv->save() == false) {
            foreach ($keywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Keywordtv successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "keywordtv",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Keywordtv
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $ID_Keywordtv = $this->request->getPost("ID_Keywordtv", "string");

        $keywordtv = Keywordtv::findFirst("ID_Keywordtv = '$ID_Keywordtv'");
        if (!$keywordtv) {
            $this->flash->error("Keywordtv does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $form = new KeywordtvForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $keywordtv)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }

        if ($keywordtv->save() == false) {
			
            foreach ($keywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Keywordtv successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "keywordtv",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Keywordtv)
    {
         
       $keywordtv = Keywordtv::findFirst("ID_Keywordtv = '$ID_Keywordtv'");
        
       $this->view->form = new KeywordtvForm($keywordtv, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }

/**        $this->view->disable();
        echo "Evo".$KeywordtvName." ".$ID_Keywordtv;   */
        
        $ID_Keywordtv = $this->request->getPost("ID_Keywordtv", "string");
       
        $keywordtv = Keywordtv::findFirst("ID_Keywordtv = '$ID_Keywordtv'");
        if (!$keywordtv) {
            $this->flash->error("Keywordtv not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }  

        if (!$keywordtv->delete()) {
            foreach ($keywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Keywordtv deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "keywordtv",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new KeywordtvForm;
        $this->view->form = new KeywordtvForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "keywordtv",
                "action"     => "index",
            ]  
        );  
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keywordtv")) {
            // Retrieve its value
            $ID_Keywordtv = $this->session->get("ID_Keywordtv");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Keywordtv;  */
        
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
       
        $keywordtvculturaldomain = new Keywordtvculturaldomain();
        
        $keywordtvculturaldomain->ID_Keywordtv = $ID_Keywordtv;
        $keywordtvculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($keywordtvculturaldomain->save() == false) {            
            foreach ($keywordtvculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keywordtv]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keywordtv",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keywordtv]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keywordtv")) {
            // Retrieve its value
            $ID_Keywordtv = $this->session->get("ID_Keywordtv");
        }
               
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
       
        $keywordtvculturaldomain = new Keywordtvculturaldomain();
        
        $keywordtvculturaldomain->ID_Keywordtv = $ID_Keywordtv;
        $keywordtvculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($keywordtvculturaldomain->delete() == false) {            
            foreach ($keywordtvculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keywordtv]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keywordtv",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keywordtv]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keywordtv")) {
            // Retrieve its value
            $ID_Keywordtv = $this->session->get("ID_Keywordtv");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Keywordtv;  */
        
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
       
        $keywordtvsocialimpact = new Keywordtvsocialimpact();
        
        $keywordtvsocialimpact->ID_Keywordtv = $ID_Keywordtv;
        $keywordtvsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($keywordtvsocialimpact->save() == false) {            
            foreach ($keywordtvsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keywordtv]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keywordtv",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keywordtv]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keywordtv")) {
            // Retrieve its value
            $ID_Keywordtv = $this->session->get("ID_Keywordtv");
        }
               
        $keywordtv = Keywordtv::findFirst(" ID_Keywordtv = '$ID_Keywordtv'");
        
        $this->view->keywordtv  = $keywordtv;
       
        $keywordtvsocialimpact = new Keywordtvsocialimpact();
        
        $keywordtvsocialimpact->ID_Keywordtv = $ID_Keywordtv;
        $keywordtvsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($keywordtvsocialimpact->delete() == false) {            
            foreach ($keywordtvsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keywordtv]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keywordtv",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keywordtv]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }    
 
      public function linkkeywordtvAction($ID_Keywordtv){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Template")) {
            // Retrieve its value
            $ID_Template = $this->session->get("ID_Template");
            $ID_TemplateKeywordtv = $this->session->get("ID_TemplateKeywordtv");
        }
        
//        echo $ID_Template.' '.$ID_TemplateKeywordtv.' '.$ID_Keywordtv.'<BR>';
        
        $templatekeywordtv = Templatekeywordtv::find("(ID_Template = '$ID_Template' AND ID_TemplateKeywordtv ='$ID_TemplateKeywordtv')");
      
        $this->view->templatekeywordtv  = $templatekeywordtv;
        
        $templatekeywordtv->ID_TemplateKeywordtv = $ID_Keywordtv;

        $query = "UPDATE templatekeywordtv SET ID_Keywordtv = '$ID_Keywordtv' WHERE ID_Template = '$ID_Template' AND ID_TemplateKeywordtv ='$ID_TemplateKeywordtv'";        
        $resultGeneral = $this->db->query($query);      

/**        if ($templatekeywordtv->save() == false) {            
            foreach ($templatekeywordtv->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keywordtv",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keywordtv]
                ]
            );
          }   */
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "check",
                    "params"     => [$ID_Template]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

    public function dockeyAction()
    {
        
            $document = Document::find();

//            die(var_dump($document));
        
            foreach ($document as $doc_keyword){
                
                $keywords = explode(";",$doc_keyword->Keywords);;
                $ID_Doc = $doc_keyword->ID_Doc;
                echo $ID_Doc.'<BR>';
                
                  foreach ($keywords as $keyword_name){
                  
                  if (strlen($keyword_name) > 0) {
                  
                    $keyword_name = trim($keyword_name);
//                  echo '----->'.$keyword_name.'<BR>';
                    $keyword = Keyword::find(" KeywordName = '$keyword_name'");
                    
                    foreach ( $keyword as $keyword_id )  {
                    
                       $ID_Keyword = $keyword_id->ID_Keyword;
                    }
                   
//                    echo '----->'.$ID_Keyword.'<BR>';
                
                    if ( count($keyword) == 0 ) {
                        
                            $keyword = new Keyword();
                            $keyword->KeywordName = $keyword_name;
                            $keyword->KeywordDescription  = '...';
                    
//                            die(var_dump($keyword));
                            
                            if ($keyword->save() == false) {
                                foreach ($keyword->getMessages() as $message) {
                                $this->flash->error($message);
                                }

                                return $this->dispatcher->forward(
                                    [
                                        "controller" => "document",
                                        "action"     => "new",
                                    ]
                                ); 
                            } 
                            
                            $keyword = Keyword::findFirst(" KeywordName = '$keyword_name'");
                            $ID_Keyword = $keyword->ID_Keyword;                        
                        }  
                
                        $dockeyword = Dockeyword::find("(ID_Keyword = '$ID_Keyword' AND ID_Doc ='$ID_Doc')");
//                        die(var_dump($dockeyword));                        
                        if ( count($dockeyword) == 0) {
                        
                            $dockeyword = new Dockeyword();
                            $dockeyword->ID_Keyword = $ID_Keyword;
                            $dockeyword->ID_Doc = $ID_Doc;                      
                            if ($dockeyword->save() == false) {
                                foreach ($dockeyword->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                            [
                                "controller" => "document",
                                "action"     => "new",
                            ]
                        );
                      }   
                    }
            
                    $documentculturaldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
              
                    foreach ($documentculturaldomain as $docculturaldomain){

                        $ID_CultDomain = $docculturaldomain->ID_CultDomain;
                        $keywordculturaldomain = Keywordculturaldomain::find("(ID_Keyword = '$ID_Keyword' AND ID_CultDomain ='$ID_CultDomain')");
                        if ( count($keywordculturaldomain) == 0) {
                            $keywordculturaldomain = new Keywordculturaldomain();
                            $keywordculturaldomain->ID_Keyword = $ID_Keyword;
                            $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;                      
                            if ($keywordculturaldomain->save() == false) {
                            foreach ($keywordculturaldomain->getMessages() as $message) {
                                 $this->flash->error($message);
                              }

                                return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "edit",
                                ]
                            );
                        }   
                      }
                    }    
                
                    $documentsocialimpact = Documentsocialimpact::find(" ID_Doc = '$ID_Doc'");

                        foreach ($documentsocialimpact as $docsocialimpact){

                        $ID_SocImpact = $docsocialimpact->ID_SocImpact;

                        $keywordsocialimpact = Keywordsocialimpact::find("(ID_Keyword = '$ID_Keyword' AND ID_SocImpact ='$ID_SocImpact')");
                        if ( count($keywordsocialimpact) == 0) {
                            $keywordsocialimpact = new Keywordsocialimpact();
                            $keywordsocialimpact->ID_Keyword = $ID_Keyword;
                            $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;                      
                            if ($keywordsocialimpact->save() == false) {
                              foreach ($keywordsocialimpact->getMessages() as $message) {
                                 $this->flash->error($message);
                            }

                                return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "edit",
                                ]
                            );
                          }   
                        }
                    }
                    
                  }
                }  
            }
            
            return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                            ]
                     );
    }

	    public function preparecityAction(){
        
        $numberPage = 1;
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
        $path = "location.txt";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);        
    
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);
        
//        die(var_dump($trans_temp));
        
        foreach($trans_temp as $trans)
	{
            $trans = trim($trans);
            echo $trans.'<BR>';
            $trans .= ",";
            echo $trans.'<BR>';
	    $tran = explode(",", $trans); // Data is tab delimited                           
//         die(var_dump($tran));
            
            $CountryName = strtoupper($tran[2]);
            $CountryCode = strtoupper($tran[3]);
            
            $country = Country::findFirst(" CountryName = '$CountryName' ");
  
            if ( count($country) == 0) {
                echo 'Unos '.$CountryName.'<BR>';
//        die(var_dump($tran));
                $country = new Country();
                $country->CountryName = $CountryName;
                $country->CountryCode = $CountryCode;
                
                if ($country->save() == false) {
                    foreach ($country->getMessages() as $message) {
                        $this->flash->error($message);
                        }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "document",
                            "action"     => "new",
                        ]
                     );
                } 
            } 
//            echo 'Hey!';
            
            $country = Country::findFirst(" CountryName = '$CountryName' ");
            $ID_Country = $country->ID_Country;  
            
            $CityName = $tran[1];
            $LAT = $tran[4];
            $LON = $tran[5];
            echo $CityName.' - '.$LAT.' - '.$LON.'<BR>';
            
            $city = City::findFirst(" CityName = '$CityName' ");
            
            if ( !$city ) {              
                $city = new City();              
                echo $CityName.' upis grada <BR>';
                $city->CityName = $CityName;
                $city->ID_Country = $ID_Country;
                $city->LATITUDE = $LAT;
                $city->LONGITUDE = $LON;
//           die(var_dump($city));
            } else {
                $city->ID_Country = $ID_Country;
                $city->LATITUDE = $LAT;
                $city->LONGITUDE = $LON;
            }
//            var_dump($city);

//            die(var_dump($city));
            if ($city->save() == false) {
                foreach ($city->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "new",
                    ]
                );
            } 
                   
	 } 

//    $this->view->form = new DocumentFullForm($document, array('edit' => true));            
//    var_Dump($document);            
    }

    public function documentcityAction(){
        
        $numberPage = 1;
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
        $path = "document-cities.txt";
//          $path = "document-cities.txt";
//        echo($file->getName());
//        $path = $filename; 
	
//        $path = "/uploads/1.csv";
        $fp = fopen($path, "r");

	$buf = "";
	/* Make sure the file was succesfully opened */
	if(!$fp)
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		/* Loop over the file storing the file into a buffer */
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);        
    
        $trans_temp = explode("\n", $buf);	
	/* Unset buffer since we have the data in an array now */
	unset($buf);

        foreach($trans_temp as $trans)
	{
            
            $tran_cities = explode(";", $trans); 
            $number =0;
            $doc_city = ''; // list of cities for document

            foreach($tran_cities as $tran_city) {
                $number++;
                $tran_data = explode(",", $tran_city); // Data is tab delimited                           
                if ( $number == 1) {
                    $ID_Doc = trim($tran_data[0]);
                    $CityName = trim($tran_data[1]);
                    $CountryName = trim($tran_data[2]);
                    $doc_city .= $CityName;
                } else {
                    $CityName = trim($tran_data[0]);
                    $CountryName = trim($tran_data[1]);
                    $doc_city .= ";".$CityName;
                }
//                echo $ID_Doc.' - '.$CityName.'<BR>'; 
                $document = Document::find(" ID_Doc = '$ID_Doc'");
                $city = City::findFirst(" CityName = '$CityName'");               

                if ( !$city ) {
                    echo 'Nema grada:'.$CityName.'<BR>';
                    die(var_dump($city));
                    $country = Country::findFirst(" CountryName = '$CountryName' ");
  
                   if ( count($country) == 0) {
                echo 'Nema zemlje:'.$CountryName.'<BR>';
                die(var_dump($city)); 
                        $country = new Country();
                        $country->CountryName = $CountryName;                        
                
                        if ($country->save() == false) {
                            foreach ($country->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        } 
                    }
                  
                    $country = Country::findFirst(" CountryName = '$CountryName' ");
                    $ID_Country = $country->ID_Country;  
            
//                    echo $CityName.'<BR>';
            
                    $city = City::findFirst(" CityName = '$CityName' ");
            
                    if ( !$city ) {              
                        $city = new City();              
                        echo $CityName.' upis grada <BR>';
                        $city->CityName = $CityName;
                        $city->ID_Country = $ID_Country;
                        $city->LATITUDE = 0;
                        $city->LONGITUDE = 0;
  
                       if ($city->save() == false) {
                            foreach ($city->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                            
                            return $this->dispatcher->forward(
                                [
                                    "controller" => "document",
                                    "action"     => "new",
                                ]
                            );
                        }     
                    }
                }
                
                $city = City::findFirst(" CityName = '$CityName' ");    
                $ID_City = $city->ID_City;
//                echo $ID_Doc.' - '.$ID_City.'<BR>';
                $doccity = Doccity::findFirst("(ID_Doc = '$ID_Doc' AND ID_City ='$ID_City')");

                if ( !$doccity ) {

                    $query = "INSERT INTO doccity (ID_Doc,ID_City) VALUES ($ID_Doc,$ID_City)";
//                    echo $query;
                    $resultGeneral = $this->db->query($query);
                    
                }
            
        $doccity = Doccity::find("ID_Doc = '$ID_Doc'");
//   die(var_dump($doccity));

        $city_list = '';
        
        if ( count($doccity) != 0 ) {
            $i = 0;
            foreach ($doccity as $doccity_data){
                $ID_City = $doccity_data->ID_City;
                $city = City::find(" ID_City = '$ID_City'");
                foreach ($city as $city_data){
                    $CityName = $city_data->CityName;
                    $i++;
                    if ($i == 1) {
                        $city_list = $city_list.$CityName;
                    } else {
                        $city_list = $city_list.'; '.$CityName;
                    }
                }
        }
        echo $ID_Doc.' - '.$city_list.'<BR>';        
          
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        $document->city = $city_list;

        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "document",
                    "action"     => "view",
                ]
            );
          }                
        } 
      } 
     }           
//    $this->view->form = new DocumentFullForm($document, array('edit' => true));            
//    var_Dump($document);            
    }

}
