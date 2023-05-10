<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Resultset;

class AnalyseController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Analyse');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new AnalyseForm;               
        
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Analyse", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }
        
        $analyse = Analyse::find($parameters);
        if (count($analyse) == 0) {
            $this->flash->notice("Analyse is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $analyse,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->analyse = $analyse;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
        $analyse = Analyse::find(
                [    
                 'order'      => 'ID_Analyse',   
                ]
                );
        
        if (count($analyse) == 0) {
            $this->flash->notice("Analyse is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $analyse,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->analyse = $analyse;
    }
    
    /**
     * Shows the form to create a new analyse
     */
    public function newAction()
    {
       $this->view->form = new AnalyseForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Analyse)
    {

        if (!$this->request->isPost()) {

            $analyse = Analyse::findFirst("ID_Analyse = '$ID_Analyse'");
            if (!$analyse) {
                $this->flash->error("Analyse not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "analyse",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new AnalyseForm($analyse, ['edit' => true]);
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
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $form = new AnalyseForm;
        $analyse = new Analyse();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $analyse)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "new",
                ]
            );
        }

        if ($analyse->save() == false) {
            foreach ($analyse->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Analyse successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "analyse",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Analyse
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $ID_Analyse = $this->request->getPost("ID_Analyse", "string");

        $analyse = Analyse::findFirst("ID_Analyse = '$ID_Analyse'");
        if (!$analyse) {
            $this->flash->error("Analyse does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $form = new AnalyseForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $analyse)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "new",
                ]
            );
        }

        if ($analyse->save() == false) {
			
            foreach ($analyse->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Analyse successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "analyse",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Analyse)
    {
         
       $analyse = Analyse::findFirst("ID_Analyse = '$ID_Analyse'");
        
       $this->view->form = new AnalyseForm($analyse, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $ID_Analyse = $this->request->getPost("ID_Analyse", "string");

/**        $this->view->disable();
        echo "Evo".$AnalyseName." ".$ID_Analyse;   */
        
        $analyse = Analyse::findFirst("ID_Analyse = '$ID_Analyse'");
        if (!$analyse) {
            $this->flash->error("Analyse not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }  

        if (!$analyse->delete()) {
            foreach ($analyse->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Analyse deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "analyse",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new AnalyseForm;
        $this->view->form = new AnalyseForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "analyse",
                "action"     => "index",
            ]  
        );  
    }

 public function analysecultdomainsocimpactAction($ID_Analyse){
               
        $numberPage = 1;

        if ($this->dispatcher->getParam("analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->dispatcher->getParam("analyse");
        } else {
            $this->session->set("ID_Analyse", "$ID_Analyse");
        }     

             
        $analyse = Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");

        $this->view->analyse  = $analyse;
//        die(var_dump($analyse));
        
//        $culturaldomain = CulturalDomain::find();

        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $analysecultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>ANALYSIS </th><th></th><th>CULTURAL DOMAIN</th></tr></thead><tbody><tr>';        
                           
            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $analyseculturaldomain = Analyseculturaldomain::find("(ID_Analyse = '$ID_Analyse' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($analyseculturaldomain) > 0) {
                    $analysecultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/analyse/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $analysecultview .= '<td></td><td width="7%"><a href="/analyse/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
          }
        }   

            $analysecultview .=  '</tbody></table>';            
             
        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $analysesocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>ANALYSIS </th><th></th><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';        
                           
            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
           
/**              $this->view->disable();
              echo "Evo".$ID_Analyse." ".$ID_SocImpact;  */
        
              $analysesocialimpact = Analysesocialimpact::find("(ID_Analyse = '$ID_Analyse' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($analysesocialimpact) > 0) {
                    $analysesocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/analyse/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $analysesocview .= '<td></td><td width="7%"><a href="/analyse/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$SocImpactName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $analysesocview .=  '</tbody></table>';        

//            echo $analysecultview.'<BR>';    
//            echo $analysesocview.'<BR>';
            
            $analyse->Analysecultdomainview = $analysecultview;
            $analyse->Analysesocimpactview = $analysesocview;



          
        if ($analyse->save() == false) {
            foreach ($analyse->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                ]
            );
        }
        
        $analyseculturaldomain = Analyseculturaldomain::find(" ID_Analyse = '$ID_Analyse'");
        
        $paginator = new Paginator(array(
            "data"  => $analyseculturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }      

        $analyse = Analyse::findFirst("ID_Analyse = '$ID_Analyse'");
        
        $this->view->analyse  = $analyse;
        
        $analyseculturaldomain = new Analyseculturaldomain();
        
        $analyseculturaldomain->ID_Analyse = $ID_Analyse;
        $analyseculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($analyseculturaldomain->save() == false) {            
            foreach ($analyseculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }
               
        $analyse = Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");
        
        $this->view->analyse  = $analyse;
       
        $analyseculturaldomain = new Analyseculturaldomain();
        
        $analyseculturaldomain->ID_Analyse = $ID_Analyse;
        $analyseculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($analyseculturaldomain->delete() == false) {            
            foreach ($analyseculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Analyseument;  */
        
        $analyse = Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");
        
        $this->view->analyse  = $analyse;
       
        $analysesocialimpact = new Analysesocialimpact();
        
        $analysesocialimpact->ID_Analyse = $ID_Analyse;
        $analysesocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($analysesocialimpact->save() == false) {            
            foreach ($analysesocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }
               
        $analyse = Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");
        
        $this->view->analyse  = $analyse;
       
        $analysesocialimpact = new Analysesocialimpact();
        
        $analysesocialimpact->ID_Analyse = $ID_Analyse;
        $analysesocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($analysesocialimpact->delete() == false) {            
            foreach ($analysesocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "analyse",
                    "action"     => "analysecultdomainsocimpact",
                    "params"     => [$ID_Analyse]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }    
 
        public function analysekeywordAction($ID_Analyse){
        
        $numberPage = 1;
        
        $analysekeyword = Analysekeyword::find(" ID_Analyse = '$ID_Analyse'");

        foreach ($analysekeyword as $keyword) {
            if ($keyword->delete() === false) {
                echo "Sorry, we can't delete the robot right now: \n";

                    $messages = $keyword->getMessages();

                    foreach ($messages as $message) {
                        echo $message, "\n";
                    }
                } 
           }
        
        $analyseculturaldomain = Analyseculturaldomain::find(" ID_Analyse = '$ID_Analyse'");

        if (count($analyseculturaldomain) > 0 ) {
            
            foreach ($analyseculturaldomain as $cultdomain){
                $ID_CultDomain = $cultdomain->ID_CultDomain;
                $keywordculturaldomain = Keywordculturaldomain::find(" ID_CultDomain = '$ID_CultDomain'");
                if (count($keywordculturaldomain) > 0) {
                    foreach ($keywordculturaldomain as $keyword){                        
                        $analysekeyword = new Analysekeyword();
                        $ID_Keyword = $keyword->ID_Keyword;
                        $analysekeyword->ID_Analyse = $ID_Analyse;
                        $analysekeyword->ID_Keyword = $ID_Keyword;
//                        echo $analysekeyword->ID_Analyse.' - '.$analysekeyword->ID_Keyword.'<BR>';
                            if ($analysekeyword->save() == false) {            
                                foreach ($analysekeyword->getMessages() as $message) {
                                    $this->flash->error($message);
                                }
                                return $this->dispatcher->forward(
                                 [
                                    "controller" => "analyse",
                                    "action"     => "view",
                                    "params"     => [$ID_Analyse]
                                  ]
                                );
                            }
                    }    
                }
            }
        }                                 
        
        $analysesocialimpact = Analysesocialimpact::find(" ID_Analyse = '$ID_Analyse'");

        if (count($analysesocialimpact) > 0 ) {
            
            foreach ($analysesocialimpact as $socialimpact){
                $ID_SocImpact = $socialimpact->ID_SocImpact;
                $keywordsocialimpact= Keywordsocialimpact::find(" ID_SocImpact = '$ID_SocImpact'");
                if (count($keywordsocialimpact) > 0) {
                    foreach ($keywordsocialimpact as $keyword){                        
                        $analysekeyword = new Analysekeyword();
                        $ID_Keyword = $keyword->ID_Keyword;
                        $analysekeyword->ID_Analyse = $ID_Analyse;
                        $analysekeyword->ID_Keyword = $ID_Keyword;
//                        echo $analysekeyword->ID_Analyse.' - '.$analysekeyword->ID_Keyword.'<BR>';
                            if ($analysekeyword->save() == false) {            
                                foreach ($analysekeyword->getMessages() as $message) {
                                    $this->flash->error($message);
                                }
                                return $this->dispatcher->forward(
                                 [
                                    "controller" => "analyse",
                                    "action"     => "view",
                                    "params"     => [$ID_Analyse]
                                  ]
                                );
                            }
                    }    
                }
            }
        }
        
        $analyse = Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");
// die(var_dump($analyse));        
        $this->view->djela  = $analyse;
        
        $analysekeyword = Analysekeyword::find(" ID_Analyse = '$ID_Analyse'");
                
        $paginator = new Paginator(array(
            "data"  => $analysekeyword,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
    
    }

        public function analysedocumentAction(){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }
 
          $analysedocument = Analysedocument::find(" ID_Analyse = '$ID_Analyse'");

        foreach ($analysedocument as $analysedoc) {
            if ($analysedoc->delete() === false) {
                echo "Sorry, we can't delete the robot right now: \n";

                    $messages = $analysedoc->getMessages();

                    foreach ($messages as $message) {
                        echo $message, "\n";
                    }
                } 
           }
        $analysedocumentkeyword = Analysedocumentkeyword::find(" ID_Analyse = '$ID_Analyse'");

        foreach ($analysedocumentkeyword as $analysedockey) {
            if ($analysedockey->delete() === false) {
                echo "Sorry, we can't delete the robot right now: \n";

                    $messages = $analysedockey->getMessages();

                    foreach ($messages as $message) {
                        echo $message, "\n";
                    }
                } 
           }
           
        //   Unos cultraldomain i social impact u analyse    
        
        $analyseview = '';
        $analysecultldomain = Analyseculturaldomain::find(" ID_Analyse = '$ID_Analyse'");
             
        if (count($analysecultldomain) > 0) {
            
            $analyseview .= '<table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL DOMAIN NAME</th></tr></thead><tbody><tr>';
       
                $analysecultdomain = "SELECT CD.CultDomainName FROM analyseculturaldomain A INNER JOIN culturaldomain CD ON CD.ID_CultDomain = A.ID_CultDomain WHERE A.ID_Analyse = $ID_Analyse";        
                $resultGeneral = $this->db->query($analysecultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                foreach ($resultGeneral as $row => $result) {
                     $analyseview .= '<td>'.$result['CultDomainName'].'</td></tr>';
                 }
       
            $analyseview .=  '</tbody></table>';

        }
        
        $analysesocimpact = Analysesocialimpact::find(" ID_Analyse = '$ID_Analyse'");
             
        if (count($analysesocimpact) > 0) {
            
            $analyseview .= '<table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';
       
                $analysesocimpact = "SELECT SC.SocImpactName FROM analysesocialimpact A INNER JOIN socialimpact SC ON SC.ID_SocImpact = A.ID_SocImpact WHERE A.ID_Analyse = $ID_Analyse";        
                $resultGeneral = $this->db->query($analysesocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $analyseview .= '<td>'.$result['SocImpactName'].'</td></tr>';
                 }
       
            $analyseview .=  '</tbody></table>';

        }

        $analyse =  Analyse::findFirst(" ID_Analyse = '$ID_Analyse'");

        $analyse->Analyseview = $analyseview;
                
        if ($analyse->save() == false) {
            foreach ($analyse->getMessages() as $message) {
                $this->flash->error($message);
            }
        }  
        
        $document = Document::find();

        foreach ($document as $document) {
            $Documentkeywordcount = 0;
            $Documentabstractcount = 0;
            $ID_Doc = $document->ID_Doc;
            $keywords = trim($document->Keywords);
            $Abstract = rtrim($document->Summary);    
            $analysekeyword = Analysekeyword::find(" ID_Analyse = '$ID_Analyse'");
               foreach($analysekeyword as $keyword) {
                   $ID_Keyword= $keyword->ID_Keyword;                   
                   $keywordname = Keyword::find(" ID_Keyword = '$ID_Keyword'");
                   foreach($keywordname as $keyword) {
                        $KeywordName= $keyword->KeywordName;        
                        $KeywordCount = 0;
                        $AbstractCount = 0;
                        $template_keywords = explode(";", $keywords);
                            foreach ($template_keywords as $result) {
                              $result = trim($result);
                              if ($KeywordName === $result) {
                                 $KeywordCount++;    
//                                   echo 'Keyword->'.$keywords.' - '.$result.'<BR>';
                                   $keywords = str_replace($result, '<font style="color:blue">'.$result.'</font>', $keywords);                                   
//                                   echo 'Novi '.$ID_Doc.' ->'.$keywords.'<BR>';  
                              }    
                            }                    
//                        $Abstract = rtrim($document->Summary);    
                        $AbstractCount = substr_count($Abstract, $KeywordName);
//                            echo 'Abstract->'.$Abstract.' <-> '.$KeywordName.'<BR>';
                            $Abstract = str_replace($KeywordName, '<font style="color:blue">'.$KeywordName.'</font>', $Abstract);                                   
//                            echo 'Abstract->'.$Abstract.'<BR>';
//                        echo $KeywordCount.' - rezultat <BR>';          
//                        echo $AbstractCount.' - abstract <BR>';          
                        if ( $KeywordCount > 0 OR $AbstractCount > 0){
                            $analysedocumentkeyword = new Analysedocumentkeyword();
                            $analysedocumentkeyword->ID_Analyse = $ID_Analyse;
                            $analysedocumentkeyword->ID_Doc = $ID_Doc;
                            $analysedocumentkeyword->ID_Keyword = $ID_Keyword;
                            $analysedocumentkeyword->KeywordCount = $KeywordCount;
                            $analysedocumentkeyword->AbstractCount = $AbstractCount;
                            if ($analysedocumentkeyword->save() == false) {            
                                foreach ($analysedocumentkeyword->getMessages() as $message) {
                                    $this->flash->error($message);
                                }
                            }
                       }
                       $Documentkeywordcount = $Documentkeywordcount + $KeywordCount;
                       $Documentabstractcount = $Documentabstractcount + $AbstractCount;
                    }    
                }
       
                if ( $Documentkeywordcount > 0 OR $Documentabstractcount > 0){
//                    echo $ID_Doc.' Keyword ->'.$Documentkeywordcount.'<BR>';
//                    echo $ID_Doc.' Abstract ->'.$Documentabstractcount.'<BR>';
                    $analysedocument = new Analysedocument();
                    $analysedocument->ID_Analyse = $ID_Analyse;
                    $analysedocument->ID_Doc = $ID_Doc;
                    $analysedocument->KeywordCount = $Documentkeywordcount;
                    $analysedocument->AbstractCount = $Documentabstractcount;
                    $analysedocument->Keywordview = $keywords;
                    $analysedocument->Abstractview = $Abstract;
//                    echo $ID_Doc.' ->'.$analysedocument->Keywordview.'<BR>';
//                    echo $ID_Doc.' ->'.$analysedocument->Abstractview.'<BR>';
                    if ($analysedocument->save() == false) {            
                        foreach ($analysedocument->getMessages() as $message) {
                            $this->flash->error($message);
                            }
                        }
                }    
        }  
        
//        $analysedocumentkeyword = Analysedocumentkeyword::find(" ID_Analyse = '$ID_Analyse'");
        
        $analysedocument = Analysedocument::find(" ID_Analyse = '$ID_Analyse'");

        $paginator = new Paginator(array(
            "data"  => $analysedocument,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
            
    }    
    
      public function pregledAction($ID_Analyse){
        
        $numberPage = 1;
        
        if ($this->dispatcher->getParam("analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->dispatcher->getParam("analyse");
        } else {
            $this->session->set("ID_Analyse", "$ID_Analyse");
        }     
                 
        $analysedocument = Analysedocument::find(" ID_Analyse = '$ID_Analyse'");

        $paginator = new Paginator(array(
            "data"  => $analysedocument,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
      }

      public function pregledkeywordAction($ID_Doc){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Analyse")) {
            // Retrieve its value
            $ID_Analyse = $this->session->get("ID_Analyse");
        }
        
        $analysedocument = Analysedocument::findFirst("(ID_Analyse = '$ID_Analyse' AND ID_Doc ='$ID_Doc')");

        $keywordview = $analysedocument->Keywordview;
        $abstractview = $analysedocument->Abstractview;
   
        $keywords = Analysedocumentkeyword::find("(ID_Analyse = '$ID_Analyse' AND ID_Doc ='$ID_Doc')");
        
        foreach ($keywords as $keyword) {
//                die(var_dump($keyword));
/**                $keywordname = Keyword::findFirst(" ID_Keyword = '$keyword'");
                $KeywordName= $keyword->KeywordName; 
                $keyword = str_replace($$KeywordName, '<font style="color:red">'.$Keywordname.'</font>', $keywordview); */                                  
                $analysedocumentkeyword = new Analysedocumentkeyword();
                $analysedocumentkeyword->ID_Analyse = $keyword->ID_Analyse;
                $analysedocumentkeyword->ID_Doc = $keyword->ID_Doc;
                $analysedocumentkeyword->ID_Keyword = $keyword->ID_Keyword;
                $analysedocumentkeyword->KeywordCount = $keyword->KeywordCount;
                $analysedocumentkeyword->AbstractCount = $keyword->AbstractCount;
                $analysedocumentkeyword->Keywordview = $keywordview;
                $analysedocumentkeyword->Abstractview = $abstractview;
//                die(var_dump($analysedocumentkeyword));
                if ($analysedocumentkeyword->save() == false) {            
                        foreach ($analysedocument->getMessages() as $message) {
                            $this->flash->error($message);
                    }                       
            }   
        }
        
        $analysedocumentkeyword = Analysedocumentkeyword::find("(ID_Analyse = '$ID_Analyse' AND ID_Doc ='$ID_Doc')");

        $this->view->analysedocumentkeyword  = $analysedocumentkeyword;
        
        $paginator = new Paginator(array(
            "data"  => $analysedocumentkeyword,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
//         die(var_dump($analysedocument));
      }     
 
       public function StatisticAction($ID_Category = 0){
        
        $this->session->set("ID_Category", "$ID_Category");   

//        echo $ID_Category.'<BR>'; 
           
        $numberPage = 1;        
        
        $domain = array();
        $sector = array();
        
        $culturaldomain = Culturaldomain::find();
        
        $i = 1;
        foreach ( $culturaldomain as $cultdomain){
            
            $domain[$i][0]= $cultdomain->ID_CultDomain;
            $domain[$i][1]= $cultdomain->CultDomainName;
            $i++;
                        
        }
        
        $socialimpact = Socialimpact::find();
        
        $i = 1;
        foreach ( $socialimpact as $socimpact){
           
            $sector[$i]= $socimpact->ID_SocImpact;        
            $i++;
            
        }        
         
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total5 = 0;        
        $total6 = 0; 
        
/**        $documentstatisticlist = Documentstatisticlist::find();

        foreach ( $documentstatisticlist as $docstatistic) {
            
            $ID_Docstatistic = $docstatistic->ID_Doc;
            
            $documentfind = Document::findFirst(" ID_Doc = '$ID_Docstatistic'");

            if (!$documentfind) {

                $docstatisticlist = Documentstatisticlist::findFirst(" ID_Doc = '$ID_Docstatistic'");

                if (!$docstatisticlist->delete()) {
                    foreach ($docstatisticlist->getMessages() as $message) {
                       $this->flash->error($message);
                    }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "analyse",
                        "action"     => "index",
                    ]
                );
              }
            }
            
        } */

/**        foreach ( $document as $doc) {
          
            $ID_Doc = $doc->ID_Doc;
            
            $documentstatisticlist = Documentstatisticlist::findFirst(" ID_Doc = '$ID_Doc'");

                if (!$documentstatisticlist) {
                    
                    $documentstatisticlist = new Documentstatisticlist;
                    $documentstatisticlist->ID_Doc = $ID_Doc;
                }    
                
                if ($documentstatisticlist->save() == false) {
                    foreach ($documentstatisticlist->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(
                        [
                            "controller" => "analyse",
                            "action"     => "index",
                        ]
                    );
                }
        }  
      
        $documentstatisticlist = Documentstatisticlist::find(
                   [    
                    'order'      => 'ID_Doc',   
                   ]
                );  */

        $document = Document::find(
		     [    
	                    'order'      => 'ID_Doc',   
                     ]
		);

        foreach ( $document as $docstat ) {
         
            $ID_Doc = $docstat->ID_Doc;
            
//            $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
            
            $ID_Doc = $docstat->ID_Doc;
            $ID_Cat = $docstat->ID_Category;
            if ( $ID_Category == 0 ) $CategoryName = 'ALL DOCUMENTS';
            if ( $ID_Category == 1 ) $CategoryName = 'UNDEFINED';
            if ( $ID_Category == 2 ) $CategoryName = 'SCIENTIFIC DOCUMENTS';
            if ( $ID_Category == 3 ) $CategoryName = 'GREY LITERATURE';            
//            echo $ID_Doc.' - '.$ID_Category.'<BR>';                
//   die(var_dump($docstat));           

            $docculturaldomain = Documentculturaldomain::find( " ID_Doc = '$ID_Doc' ");
                                  
            $docstatistic = Docstatistic::findFirst( " ID_Doc = '$ID_Doc' ");
 
            if (!$docstatistic) $docstatistic = new Docstatistic();     
            
            if (count($docculturaldomain) > 1) {

                $k = 1;
                foreach ( $docculturaldomain as $docdomain){
                    
                    $ID_CultDomain = $docdomain->ID_CultDomain;
                    if ( $k == 1) {
                        $Domains = $ID_CultDomain;
                        $k++;
                    } else {    
                        $Domains .= '-'.$ID_CultDomain;
                    }
                }

                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_CultDomain = 0;
                $docstatistic->Domains = $Domains;
                $docstatistic->ID_Category = $ID_Cat;
                
            } 
            
            if (count($docculturaldomain) == 1) {
         
                foreach ($docculturaldomain as $docdomain)  $ID_CultDomain = $docdomain->ID_CultDomain;
                
                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_CultDomain = $ID_CultDomain;
                $docstatistic->Domains = 0;
                $docstatistic->ID_Category = $ID_Cat;

                }
                
            if (count($docculturaldomain) == 0) echo 'CultDomain: '.$ID_Doc.'<BR>';
                
            $docsocialimpact = Documentsocialimpact::find( " ID_Doc = '$ID_Doc' ");
                                          
            if (count($docsocialimpact) > 1) {
                
                $k = 1;
                foreach ( $docsocialimpact as $docimpact){
                    
                    $ID_SocImpact = $docimpact->ID_SocImpact;
                    if ( $k == 1) {
                        $Sectors = $ID_SocImpact;
                        $k++;
                    } else {    
                        $Sectors .= '-'.$ID_SocImpact;
                    }
                }
                
                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_SocImpact = 0;
                $docstatistic->Sectors = $Sectors;
                $docstatistic->ID_Category = $ID_Cat;

            } 
            
            if (count($docsocialimpact) == 1) {
         
                foreach ( $docsocialimpact as $docimpact)  $ID_SocImpact = $docimpact->ID_SocImpact;
                
                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_SocImpact = $ID_SocImpact;
                $docstatistic->Sectors = 0;
                $docstatistic->ID_Category = $ID_Cat;

            }
                
            if (count($docsocialimpact) == 0) echo 'SocImpact: '.$ID_Doc.'<BR>'; 
            
            if ($docstatistic->save() == false) {
                foreach ($docstatistic->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }                          
            
        }             
        
        $statisticview = '<table class="table table-bordered table-striped" align="center">'
                            .'<thead><tr><th style="vertical-align:top", colspan="8"> <H4> SELECTED: '.$CategoryName.'</H4></th> </tr>'
                            .'<tr><th style="vertical-align:top">No.</th><th style="vertical-align:top"> CULTURAL SECTOR </th>'
                            .'<th style="vertical-align:top"><center> HEALTH AND WELLBEING </center></center></th><th style="vertical-align:top"><center> URBAN AND TERRITORIAL RENOVATION </center></center></th>'
                            .'<th style="vertical-align:top"><center> PEOPLE  ENGAGEMENT AND PARTICIPATION </center></center></th><th style="vertical-align:top"><center> GENERAL </center></th>'
                            .'<th style="vertical-align:top"><center> DOCUMENT INCLUDED IN TWO OR MORE CELLS </center></th><th style="vertical-align:top"><center> TOTAL </center></th></tr></thead><tbody><tr>';
                      
        for ($i = 1; $i<=11; $i++) {
            
            $sector1 = 0;
            $sector2 = 0;
            $sector3 = 0;
            $general = 0;
            $cells = 0;        
            $totaldomain = 0;                
            if ( $ID_Category == 0 ) $CategoryName = "ALL DOCUMENTS";
            if ( $ID_Category == 2 ) $CategoryName = "SCIENTIFIC DOCUMENTS";
            if ( $ID_Category == 3 ) $CategoryName = "GREY LITERATURE";
            if ( $ID_Category == 1 ) $CategoryName = "UNDEFINED";                                  
          
            $statistictemp = new Statistic();

            $statistictemp->Row = $i;
            $statistictemp->ID_Domain = $domain[$i][0];
            $statistictemp->CultDomainName = $domain[$i][1];            
                                     
                $domena = $domain[$i][0];
                $CultDomainName = $domain[$i][1];
                $list = array();

                if ( $ID_Category == 0) {                    
                    $statisticresult = Docstatistic::find(
                        [    
                            " ID_CultDomain = '$domena' ",
                            'order'      => 'ID_Doc',   
                        ]);                    
                } else {                   
                    $statisticresult = Docstatistic::find(
                        [    
                            " ID_CultDomain = '$domena' AND ID_Category = '$ID_Category' ",
                            'order'      => 'ID_Doc',   
                        ]);                    
                }

                foreach ( $statisticresult as $statistic ) {

                  $ID_Doc = $statistic->ID_Doc;   
                  $ID_SocImpact = $statistic->ID_SocImpact;   
                  $Sectors = $statistic->Sectors;                     
                 
                    switch ($ID_SocImpact) {
                        case 0:
                            $included = 0;  // no domain 
                            $Domains = $statistic->Domains;
                            $list = explode("-",$Domains);
                            $n = count($list);
                            for( $m = 0; $m < $n; $m++ ) {
                                if ($list[$m] == $domena) {
                                    $included = 1; 
                                }
                            }
                            if ( $included == 0 ) { 
                                $cells = $cells + 1;       
                            }
                            break;
                        case 1:
                            $sector1 = $sector1 + 1;                            
                            break;
                        case 2:
                            $sector2 = $sector2 + 1;
                            break;
                        case 3:
                            $sector3 = $sector3 + 1;
                            break;
                        case 63:
                            $general = $general + 1;
                            break;
                        }  
                                       
//                  echo $statistic->ID_Doc.'<BR>';
//                  $sum = $sum + $count;  
                }

                $statistictemp->Sector1 = $sector1;
                $statistictemp->Sector2 = $sector2;
                $statistictemp->Sector3 = $sector3;                
                $statistictemp->General = $general;
               
                if ( $ID_Category == 0) {                    
                    $statisticresult = Docstatistic::find(
                            [    
                            " ID_CultDomain = 0 ",
                            'order'      => 'ID_Doc',   
                        ]);                    
                  } else {                   
                    $statisticresult = Docstatistic::find(
                        [    
                            " ID_CultDomain = 0 AND ID_Category = '$ID_Category' ",
                            'order'      => 'ID_Doc',   
                        ]);                    
                }

                foreach ( $statisticresult as $statistic ) {
   
                  $ID_Doc = $statistic->ID_Doc;                
                    
                    $Domains = $statistic->Domains;
                    $list = explode("-",$Domains);
                    $n = count($list);
                    for( $m = 0; $m < $n; $m++ ) {
                        if ($list[$m] == $domena) {
                            $cells = $cells+1;                                            
                        }
                    }                    
                } 

                $totaldomain = $sector1+$sector2+$sector3+$general+$cells;                
                $statistictemp->Cells = $cells;
                $statistictemp->Total = $totaldomain;
                $total1 = $total1 + $sector1;
                $total2 = $total2 + $sector2;
                $total3 = $total3 + $sector3;
                $total4 = $total4 + $general;
                $total5 = $total5 + $cells;
                $total6 = $total6 + $totaldomain;
//                $total5 = $total5 + $sum;
//  die(var_dump($statistictemp));   

                if ( $ID_Category == 0) {
                
                    $statistic = Statistic::findFirst(" Row = '$i'");
                                    
                    if(!$statistic){     

                        $statistic = $statistictemp;              
                    
                    } else {

                        $statistic->Sector1 = $statistictemp->Sector1; 
                        $statistic->Sector2 = $statistictemp->Sector2; 
                        $statistic->Sector3 = $statistictemp->Sector3; 
                        $statistic->General = $statistictemp->General; 
                        $statistic->Cells = $statistictemp->Cells; 
                        $statistic->Total = $statistictemp->Total; 
//                    die(var_dump($statistic));
                    }
                    
                    if ($statistic->save() == false) {                       

                        foreach ($statistic->getMessages() as $message) {
                              $this->flash->error($message);
                        }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                ]
                            );
                     }
                 }

                    $statisticview .= '<tbody><tr><td>'.$i.'</td><td>'.$CultDomainName.'</td>'
                                      .'<td><center> <a href="/analyse/pregleddoc/'.$domena.'-1-'.$ID_Category.'">'.$sector1.'</a> </center></td>'
                                      .'<td><center> <a href="/analyse/pregleddoc/'.$domena.'-2-'.$ID_Category.'">'.$sector2.'</a> </center></td>' 
                                      .'<td><center> <a href="/analyse/pregleddoc/'.$domena.'-3-'.$ID_Category.'">'.$sector3.'</a> </center></td>'
                                      .'<td><center> <a href="/analyse/pregleddoc/'.$domena.'-63-'.$ID_Category.'">'.$general.'</a> </center></td>'
                                      .'<td><center> <a href="/analyse/pregleddoc/'.$domena.'-5-'.$ID_Category.'">'.$cells.'</a> </center></td>'
                                      .'<td><center><strong>'.$totaldomain.'</strong></center></td></tr></tbody>';
                 
//                die(var_dump($statistic));
        }        
                    $statisticview .= '<tbody><tr><td></td><td><strong> TOTAL </strong></td>'
                                      .'<td><center><strong>'.$total1.'</strong></center></td>'
                                      .'<td><center><strong>'.$total2.'</strong></center></td>'
                                      .'<td><center><strong>'.$total3.'</strong></center></td>'
                                      .'<td><center><strong>'.$total4.'</strong></center></td>'
                                      .'<td><center><strong>'.$total5.'</strong></center></td>'
                                      .'<td><center><strong> </strong></center></td></tr>';
        $statisticview .=  '</tbody></table>';    
                
        $statistic = Statistic::find();
  
        $paginator = new Paginator(array(
            "data"  => $statistic,
            "limit" => 11,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statistic;
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('statisticview', $statisticview);
        $this->view->setVar('total1', $total1);
        $this->view->setVar('total2', $total2);
        $this->view->setVar('total3', $total3);
        $this->view->setVar('total4', $total4);
        $this->view->setVar('total5', $total5);
        $this->view->setVar('total6', $total6);
        
      }
 
       public function pregleddocAction($ID_Cell){
        
        $numberPage = 1;                              
        
        $cell = $ID_Cell;
        $Type = 1;
        $this->session->set("ID_Cell", "$ID_Cell");
        $this->session->set("Type", "$Type");
        $ID_Category = $this->session->get("ID_Category");
        $cell_loc = explode("-",$cell);
        
        $ID_CultDomain = $cell_loc[0];
        $ID_SocImpact = $cell_loc[1];        
        $ID_Category = $cell_loc[2];        

//        echo $ID_CultDomain.' - '.$ID_SocImpact.' - '.$ID_Category.'<BR>';
        
        $culturaldomain = Culturaldomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
        
        if ( !$culturaldomain ) {
            
        } else{
            $CultDomainName = $culturaldomain->CultDomainName;
        }
        
        $socialimpact = Socialimpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");

        if ( !$socialimpact ) {
            $SocialImpactName = "More than one cell";
        } else{
            $SocialImpactName = $socialimpact->SocImpactName;
        }
     
        $doclist = Doclist::find();
        
        foreach ($doclist as $doclist) {
        
            if ($doclist->delete() === false) {
                echo "Sorry, we can't delete the doclist right now: \n";

                $messages = $robot->getMessages();
                
                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } 
        }
                        
        $documentsview = '<table class="table table-bordered table-striped" align="center"><thead>'
                       .'<tr><th>DOCUMENT ID</th><th>TITLE</th><th>KEYWORDS</th><th>YEAR OF PUBLICATION</th></tr></thead><tbody>';           

        if ( $ID_SocImpact == 5 ) {
            
             if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              } else {                   
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              }
                
            foreach ( $docstatistic as $docstat ) {

                $ID_Doc = $docstat->ID_Doc;
                $Domains = $docstat->Domains;        
                $list = explode("-",$Domains);
                $n = count($list);                   
                for( $m = 0; $m < $n; $m++ ) {                       
                    if ($list[$m] == $ID_CultDomain) {

                        $ID_Doc = $docstat->ID_Doc;
                        $Domains = $docstat->Domains;
                        $Sectors = $docstat->Sectors;
                        $doclist = new Doclist();
            
                        $doclist->ID_Doc = $ID_Doc;
                        $doclist->Domains = $Domains;
                        $doclist->Sectors = $Sectors;

                        if ($doclist->save() == false) {                       

                            foreach ($doclist->getMessages() as $message) {
                                $this->flash->error($message);
                            }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                ]
                            );
                        }
                        $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                        $Title = $documentdata->Title;
                        $Keyword = $documentdata->Keywords;
                        $Pubyear = $documentdata->PubYear;
                        
                        $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
              		                 .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
				         .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//		                         .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>';
                    }  
                }
            }
         
                if ( $ID_Category == 0) {                    
                    $docstatistic = Docstatistic::find(
                        [    
                             " ID_CultDomain = '$ID_CultDomain' AND ID_SocImpact = 0  ",
                                'order'      => 'ID_Doc',   
                       ]);                    
                } else {                   
                    $docstatistic = Docstatistic::find(
                        [    
                            " ID_CultDomain = '$ID_CultDomain' AND ID_SocImpact = 0 AND ID_Category = '$ID_Category' ",
                            'order'      => 'ID_Doc',   
                        ]);                    
                }

                foreach ( $docstatistic as $docstat) {                             

                        $ID_Doc = $docstat->ID_Doc;
                        $Domains = $docstat->Domains;
                        $Sectors = $docstat->Sectors;
            
                        $doclist = new Doclist();
            
                        $doclist->ID_Doc = $ID_Doc;
                        $doclist->Domains = $Domains;
                        $doclist->Sectors = $Sectors;
                
                        if ($doclist->save() == false) {                       

                            foreach ($doclist->getMessages() as $message) {
                                      $this->flash->error($message);
                                }

                                    return $this->dispatcher->forward(
                                        [
                                            "controller" => "analyse",
                                            "action"     => "index",
                                         ]
                                     );
                            }
                        
                        $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                        $Title = $documentdata->Title;
                        $Keyword = $documentdata->Keywords;
                        $Pubyear = $documentdata->PubYear;
                        
                        $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
                                         .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
 				         .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//					 .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>';
                    }
                } else {
                
                if ( $ID_Category == 0) {                    
                    $docstatistic = Docstatistic::find(
                        [    
                            "  ID_CultDomain = '$ID_CultDomain' AND ID_SocImpact = '$ID_SocImpact' ",
                            'order'      => 'ID_Doc',   
                       ]);                    
                } else {                   
                    $docstatistic = Docstatistic::find(
                        [    
                            " ID_CultDomain = '$ID_CultDomain' AND ID_SocImpact = '$ID_SocImpact' AND ID_Category = '$ID_Category' ",
                            'order'      => 'ID_Doc',   
                        ]);                    
              }
/**                $docstatistic = Docstatistic::find( 
                    [
                        " ID_CultDomain = '$ID_CultDomain'  AND ID_SocImpact = '$ID_SocImpact' ",
                        'order'      => 'ID_Doc', 
                    ]); */
                                   
                foreach ( $docstatistic as $docstat) {
            
                    $ID_Doc = $docstat->ID_Doc;

                    if( $ID_Category == 0 ) {
                        $document = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                    } else {    
                        $document = Document::findFirst( " ID_Doc = '$ID_Doc' AND ID_Category = '$ID_Category' ");
                    }   

                    if ( $document ) {
                        $ID_Doc = $docstat->ID_Doc;
                        $Domains = $docstat->Domains;
                        $Sectors = $docstat->Sectors;
            
                        $doclist = new Doclist();
                        
                        $doclist->ID_Doc = $ID_Doc;
                        $doclist->Domains = $Domains;
                        $doclist->Sectors = $Sectors;
                                        
//            die(var_dump($doclist));
                        if ($doclist->save() == false) {                       

                            foreach ($doclist->getMessages() as $message) {
                                  $this->flash->error($message);
                            }
                            
                                return $this->dispatcher->forward(
                                    [
                                        "controller" => "analyse",
                                        "action"     => "index",
                                     ]
                                );
                        }
                    $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                    $Title = $documentdata->Title;
                    $Keyword = $documentdata->Keywords;
                    $Pubyear = $documentdata->PubYear;
                        
                    $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
			             .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
				     .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//				     .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>'; 
		     }
                }                                
        }  
//            die(var_dump($docstatistic));
//            $pregleddoc = "SELECT * from Document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc INNER JOIN documentsocialimpact SI ON D.ID_Doc = SI.ID_Doc WHERE CD.ID_CultDomain = $ID_CultDomain AND SI.ID_SocImpact = $ID_SocImpact";                      
    
            $documentsview .= '</tbody></table>';

            $doclist = Doclist::find(
                    [
                         'order'      => 'ID_Doc', 
                    ]);        
        
            $paginator = new Paginator(array(
            "data"  => $doclist,
            "limit" => 300,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->doclist = $doclist;
        $this->view->setVar('CultDomainName', $CultDomainName);
        $this->view->setVar('SocialImpactName', $SocialImpactName);        
        $this->view->setVar('documentsview', $documentsview);
        $this->view->setVar('ID_Cell', $cell);
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('Type', $Type);
        
      }             
            
    public function statisticsectorAction($ID_Category = 0){
       
        $this->session->set("ID_Category", "$ID_Category");   

//        echo $ID_Category.'<BR>';
        if ( $ID_Category == 0 ) $CategoryName = "ALL DOCUMENTS";
        if ( $ID_Category == 2 ) $CategoryName = "SCIENTIFIC DOCUMENTS";
        if ( $ID_Category == 3 ) $CategoryName = "GREY LITERATURE";
        if ( $ID_Category == 1 ) $CategoryName = "UNDEFINED";                                  

    
        $numberPage = 1;        
       
        $i = 0;
        $total2 = 0;
        $total3 = 0;        
        $total4 = 0;        
        $ID_Type = 2;
                
        $statistic = Statistic::find(
                [    
                 'order'      => 'Row',   
                ]
            );
        
        if (count($statistic) == 0) {
            $this->flash->notice("Staistic is not found..");

            return $this->dispatcher->forward(
                [
                    "controller" => "analyse",
                    "action"     => "index",
                ]
            );
        }

        $statisticview = '<table class="table table-bordered table-striped" align="center" style="width:60%">'
                            .'<thead><tr><th style="vertical-align:top", colspan="8"> <H4> SELECTED:'.$CategoryName.' </H4></th> </tr>'
                            .'<tr><th style="vertical-align:top">No.</th><th style="vertical-align:top"> CULTURAL DOMAIN </th>'
                            .'<th style="vertical-align:top"><center> DOCUMENT IN DOMAIN </center></center></th><th style="vertical-align:top"><center> DOCUMENT INCLUDED IN TWO OR MORE DOMAINS </center></center></th>'
                            .'<th style="vertical-align:top"><center> TOTAL  </center></th></tr></thead><tbody>';
         
        foreach ($statistic as $statistic) {

            $total1 = 0;
            $i++;
            
            $ID_CultDomain = $statistic->ID_Domain;
            $CultDomainName = $statistic->CultDomainName;            
 
            if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              } else {                   
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              }            
            
            foreach ( $docstatistic as $docstatistic ) {                                        
                
                    $Domains = $docstatistic->Domains;
                    $ID_Doc = $docstatistic->ID_Doc;
                    $list = explode("-",$Domains);
                    $n = count($list);
                    for( $m = 0; $m < $n; $m++ ) {
                        if ($list[$m] == $ID_CultDomain) {
                            $total1 = $total1 + 1;                                            
                        }
                    }
            }             

            if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = '$ID_CultDomain' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              } else {                   
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = '$ID_CultDomain' AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
              }           

                $Total = $total1 + count($docstatistic);
                $total2 = $total2 + $total1;               
                $total3 = $total3 + $Total;
                $total4 = $total4 + count($docstatistic);
                $total5 = count($docstatistic);
              
            $statistic->CultDomains = $total1;
            $statistic->Total = $Total;
            
            if ( $ID_CultDomain == 0 ) {                    
                if ($statistic->save() == false) {
                    foreach ($statisic->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
              }          
            
            $statisticview .= '<tbody><tr><td>'.$i.'</td><td>'.$CultDomainName.'</td>'
                              .'<td><center> <a href="/analyse/pregleddocsector/'.$ID_CultDomain.'-0-'.$ID_Category.'">'.$total5.'</a> </center></td>'
                              .'<td><center> <a href="/analyse/pregleddocsector/'.$ID_CultDomain.'-1-'.$ID_Category.'">'.$total1.'</a> </center></td>' 
                              .'<td><center><strong>'.$Total.'</strong></center></td>';                                     
        }                                 
            $statisticview .= '<tbody><tr><td></td><td><strong> TOTAL </strong></td>'
                              .'<td><center><strong>'.$total4.'</strong></center></td>'
                              .'<td><center><strong>'.$total2.'</strong></center></td>'
                              .'<td><center><strong>'.$total3.'</strong></center></td>';
                              
            $statisticview .=  '</tbody></table>';    
        
        $statistic = Statistic::find();
        
        $paginator = new Paginator([
            "data"  => $statistic,
            "limit" => 15,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->statistic = $statistic;
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('statisticview', $statisticview);
        $this->view->setVar('total2', $total2);
        $this->view->setVar('total3', $total3);
        $this->view->setVar('total4', $total4);
    }

    public function PregleddocsectorAction($ID_Domain){
        
        $numberPage = 1;        
        $domain = $ID_Domain;
        $Type = 2;
        $this->session->set("Type", "$Type");
               
        $domain_loc = explode("-",$domain);
        
        $ID_CultDomain = $domain_loc[0];
        $State = $domain_loc[1];
        $ID_Category = $domain_loc[2];       
        
	$this->session->set("ID_Cell", "$ID_Domain");
        $this->session->set("ID_CultDomain", "$ID_CultDomain");
        $this->session->set("ID_Domain", "$ID_Domain");   
	$this->session->set("ID_Category", "$ID_Category");
        
//        echo $ID_CultDomain.' - '.$State.' - '.$ID_Category.'<BR>';
        $culturaldomain = Culturaldomain::findFirst( " ID_CultDomain = '$ID_CultDomain' " );
        $CultDomainName = $culturaldomain->CultDomainName;

         
        $doclist = Doclist::find();
        
        foreach ($doclist as $doclist) {
        
            if ($doclist->delete() === false) {
                echo "Sorry, we can't delete the doclist right now: \n";

                $messages = $robot->getMessages();
                
                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } 
        }
        
         $documentsview = '<table class="table table-bordered table-striped" align="center"><thead>'
                       .'<tr><th>DOCUMENT ID</th><th>TITLE</th><th>KEYWORDS</th><th>YEAR OF PUBLICATION</th></tr></thead><tbody>';           
        
        if ( $State == 1 ) {
            
            if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 ",
                        'order'      => 'ID_Doc',   
                    ]);                    
             } else {                   
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = 0 AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
             }                        
     
            foreach ( $docstatistic as $docstat ) {
                    
                $Domains = $docstat->Domains;        
                $list = explode("-",$Domains);
                $n = count($list);
                    for( $m = 0; $m < $n; $m++ ) {
                        if ($list[$m] == $ID_CultDomain) {
  
                            $ID_Doc = $docstat->ID_Doc;
                            $Domains = $docstat->Domains;
                            $Sectors = $docstat->Sectors;

                            $doclist = new Doclist();
            
                            $doclist->ID_Doc = $ID_Doc;
                            $doclist->Domains = $Domains;
                            $doclist->Sectors = $Sectors;

                            if ($doclist->save() == false) {                       

                               foreach ($doclist->getMessages() as $message) {
                                    $this->flash->error($message);
                                }

                                return $this->dispatcher->forward(
                                    [
                                        "controller" => "analyse",
                                        "action"     => "index",
                                    ]
                                );
                            }
                            
                            $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                            $Title = $documentdata->Title;
                            $Keyword = $documentdata->Keywords;
                            $Pubyear = $documentdata->PubYear;
                        
                            $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
                                              .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
				              .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//					      .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>';
                        }  
                    }                                                      
               }
            } else {
                
            if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_CultDomain = '$ID_CultDomain' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
             } else {                   
                $docstatistic = Docstatistic::find(
                   [    
                        " ID_CultDomain = '$ID_CultDomain' AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
             }                        
                                   
                foreach ( $docstatistic as $docstat) {
            
                    $ID_Doc = $docstat->ID_Doc;
                    $Domains = $docstat->Domains;
                    $Sectors = $docstat->Sectors;
            
                    $doclist = new Doclist();
            
                    $doclist->ID_Doc = $ID_Doc;
                    $doclist->Domains = $Domains;
                    $doclist->Sectors = $Sectors;
                
//            die(var_dump($doclist));
                    if ($doclist->save() == false) {                       

                        foreach ($doclist->getMessages() as $message) {
                              $this->flash->error($message);
                        }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                 ]
                            );
                    }
                    
                    $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                    $Title = $documentdata->Title;
                    $Keyword = $documentdata->Keywords;
                    $Pubyear = $documentdata->PubYear;
                      
                    $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
              	                      .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
				      .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//				      .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>';

               }
         }

        $documentsview .= '</tbody></table>';
         
        $doclist = Doclist::find(
                [
                    'order'      => 'ID_Doc', 
                ]);
        
            $paginator = new Paginator(array(
            "data"  => $doclist,
            "limit" => 500,
            "page"  => $numberPage
        ));
            
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->doclist = $doclist;
        $this->view->setVar('CultDomainName', $CultDomainName);
        $this->view->setVar('ID_CultDomain', $ID_CultDomain);
        $this->view->setVar('ID_Domain', $ID_Domain);
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('documentsview', $documentsview);
        $this->view->setVar('Type', $Type);
        
      }  
 
    public function statisticthemeAction($ID_Category = 0){
       
        $this->session->set("ID_Category", "$ID_Category");   

//        echo $ID_Category.'<BR>';
        if ( $ID_Category == 0 ) $CategoryName = "ALL DOCUMENTS";
        if ( $ID_Category == 2 ) $CategoryName = "SCIENTIFIC DOCUMENTS";
        if ( $ID_Category == 3 ) $CategoryName = "GREY LITERATURE";
        if ( $ID_Category == 1 ) $CategoryName = "UNDEFINED";                                  
    
        $numberPage = 1;
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total5 = 0;
        $total6 = 0;
              
        if ( $ID_Category == 0) {                    

            $docstatistic = Docstatistic::find( "ID_SocImpact = 1 " );
        
            $total1 = count($docstatistic);
               
            $docstatistic = Docstatistic::find( "ID_SocImpact = 2 " );
        
            $total2 = count($docstatistic);
        
            $docstatistic = Docstatistic::find( "ID_SocImpact = 3 " );
        
            $total3 = count($docstatistic);
        
            $docstatistic = Docstatistic::find( "ID_SocImpact = 63 " );
        
            $total4 = count($docstatistic);
               
            $docstatistic = Docstatistic::find( "ID_SocImpact = 0 " );
        
            $total5 = count($docstatistic);
            
        } else {                   
            
            $docstatistic = Docstatistic::find( "ID_SocImpact = 1 AND ID_Category = '$ID_Category' " );
        
            $total1 = count($docstatistic);
               
            $docstatistic = Docstatistic::find( "ID_SocImpact = 2 AND ID_Category = '$ID_Category' " );
        
            $total2 = count($docstatistic);
        
            $docstatistic = Docstatistic::find( "ID_SocImpact = 3 AND ID_Category = '$ID_Category' " );
        
            $total3 = count($docstatistic);
        
            $docstatistic = Docstatistic::find( "ID_SocImpact = 63 AND ID_Category = '$ID_Category' " );
        
            $total4 = count($docstatistic);
               
            $docstatistic = Docstatistic::find( "ID_SocImpact = 0 AND ID_Category = '$ID_Category' " );
        
            $total5 = count($docstatistic);
        }         
        
        $total6 = $total1 + $total2+ $total3 + $total4 + $total5;
        
       
        $statisticview = '<table class="table table-bordered table-striped" align="center">'
                            .'<thead><tr><th style="vertical-align:top", colspan="8"> <H4> SELECTED: '.$CategoryName.'</H4></th> </tr>'
                            .'<tr><th style="vertical-align:top"></th><th style="vertical-align:top"><center> HEALTH AND WELLBEING </center></center></th>'
                            .'<th style="vertical-align:top"><center> URBAN AND TERRITORIAL RENOVATION </center></center></th>'
                            .'<th style="vertical-align:top"><center> PEOPLE  ENGAGEMENT AND PARTICIPATION </center></center></th><th style="vertical-align:top"><center> GENERAL </center></th>'
                            .'<th style="vertical-align:top"><center> DOCUMENT INCLUDED IN TWO OR MORE CELLS </center></th><th style="vertical-align:top"><center> TOTAL </center></th></tr></thead><tbody><tr>';
                      
        $statisticview .= '<tbody><tr><td><strong> TOTAL </strong></td>'
                          .'<td><center> <a href="/analyse/pregleddoctheme/1-'.$ID_Category.'">'.$total1.'</a> </center></td>'
                          .'<td><center> <a href="/analyse/pregleddoctheme/2-'.$ID_Category.'">'.$total2.'</a> </center></td>' 
                          .'<td><center> <a href="/analyse/pregleddoctheme/3-'.$ID_Category.'">'.$total3.'</a> </center></td>' 
                          .'<td><center> <a href="/analyse/pregleddoctheme/63-'.$ID_Category.'">'.$total4.'</a> </center></td>'   
                          .'<td><center> <a href="/analyse/pregleddoctheme/0-'.$ID_Category.'">'.$total5.'</a> </center></td>'
                          .'<td><center><strong>'.$total6.'</strong></center></td>';                                     
                              
                              
        $statisticview .=  '</tbody></table>';    
        
        $statistic = Statistic::find();
        
        $paginator = new Paginator([
            "data"  => $statistic,
            "limit" => 15,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('statisticview', $statisticview);
        $this->view->total1  = $total1;
        $this->view->total2  = $total2;
        $this->view->total3  = $total3;
        $this->view->total4  = $total4;
        $this->view->total5  = $total5;
        $this->view->total6  = $total6;

    }
    
     public function PregleddocthemeAction($ID_Theme){
        
        $numberPage = 1;        
        $domains = $ID_Theme;
        $domain = explode("-",$domains);
        
	$this->session->set("ID_Cell", "$ID_Theme");
        $ID_SocImpact = $domain[0];
        $ID_Category = $domain[1];
        $this->session->set("ID_Category", "$ID_Category");
        $Type = 3;
        $this->session->set("Type", "$Type");
        $new = array();
        $new[0][1] = 5;
        
        $this->session->set("ID_SocImpact", "$ID_SocImpact");
        $this->session->set("ID_Theme", "$ID_Theme");       
                
        $socialimpact = Socialimpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");
        
        if ( !$socialimpact) {
            $SocImpactName = "More then one cross-over theme";
        } else{
            $SocImpactName = $socialimpact->SocImpactName;
        }
        
        $doclist = Doclist::find();
        
        foreach ($doclist as $doclist) {
        
            if ($doclist->delete() === false) {
                echo "Sorry, we can't delete the doclist right now: \n";

                $messages = $robot->getMessages();
                
                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } 
        }
        
                
        if ( $ID_Category == 0) {                    
                $docstatistic = Docstatistic::find(
                    [    
                        " ID_SocImpact = '$ID_SocImpact' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
         } else {                   
                $docstatistic = Docstatistic::find(
                   [    
                        " ID_SocImpact = '$ID_SocImpact' AND ID_Category = '$ID_Category' ",
                        'order'      => 'ID_Doc',   
                    ]);                    
          }                         
            
            $documentsview = '<table class="table table-bordered table-striped" align="center"><thead>'
                        .'<tr><th>DOCUMENT ID</th><th>TITLE</th><th>KEYWORDS</th><th>YEAR OF PUBLICATION</th></tr></thead><tbody>';           
     
            foreach ( $docstatistic as $docstat) {
            
                $ID_Doc = $docstat->ID_Doc;
                $Domains = $docstat->Domains;
                $Sectors = $docstat->Sectors;
           
                $doclist = new Doclist();
            
                $doclist->ID_Doc = $ID_Doc;
                $doclist->Domains = $Domains;
                $doclist->Sectors = $Sectors;
                
//            die(var_dump($doclist));
                if ($doclist->save() == false) {                       

                    foreach ($doclist->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                        return $this->dispatcher->forward(
                            [
                                "controller" => "analyse",
                                "action"     => "index",
                            ]
                        );
                  }
                
                $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                $Title = $documentdata->Title;
                $Keyword = $documentdata->Keywords;
                $Pubyear = $documentdata->PubYear;  
                    
                $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
       	                          .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'
			          .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
//				  .'<td width="7%"><a href="https://doi.org/'.$document->DOI.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Doi </a></td>';                   
                }    
                
                
            $documentsview .= '</tbody></table>';
            
            $doclist = Doclist::find();
                
            $paginator = new Paginator(array(
            "data"  => $doclist,
            "limit" => 600,
            "page"  => $numberPage
            ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->doclist = $doclist;
        $this->view->setVar('SocImpactName', $SocImpactName);
        $this->view->setVar('ID_SocImpact', $ID_SocImpact);
        $this->view->setVar('ID_Theme', $ID_Theme);
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('documentsview', $documentsview);
        $this->view->setVar('Type', $Type);
        $this->view->setVar('new', $new);
        
      }  
     
    public function StatisticyeardomainAction($ID_Category = 0){
       
        $this->session->set("ID_Category", "$ID_Category"); 
        
//        echo $ID_Category.'<BR>';
        if ( $ID_Category == 0 ) $CategoryName = "ALL DOCUMENTS";
        if ( $ID_Category == 2 ) $CategoryName = "SCIENTIFIC DOCUMENTS";
        if ( $ID_Category == 3 ) $CategoryName = "GREY LITERATURE";
        if ( $ID_Category == 1 ) $CategoryName = "UNDEFINED";      
        
        $numberPage = 1;        
        
        $domain = array();
        $yeardomain = array();
        $total1 = 0;
        
        $culturaldomain = Culturaldomain::find();

        $i = 1;
        foreach ( $culturaldomain as $cultdomain){
            
            $domain[$i][0]= $cultdomain->ID_CultDomain;
            $domain[$i][1]= $cultdomain->CultDomainName;
            $i++;
                        
        }
        
        $socialimpact = Socialimpact::find();
        
        $j = 1;
        foreach ( $socialimpact as $socimpact){
           
            $sector[$j]= $socimpact->ID_SocImpact;        
            $j++;
            
        }
        
/**         $document = Document::find(
                        [
                            'order' =>'PubYear',
                        ]);
        
       foreach ( $document as $document) {
            $Year = $document->PubYear;
            
            $year_domain = Statisticyear::find(" Year = '$Year' ");
            
            if ( count($year_domain) == 0) {

                for ($k = 1; $k < $i; $k ++) {
                
                    $statisticyear = new Statisticyear();
                
                    $statisticyear->Year = $Year;
                    $statisticyear->ID_CultDomain = $domain[$k][0];
                    $statisticyear->Yeardomain = 0;
                    $statisticyear->ID_SocImpact = 0;
                    $statisticyear->Yearsector = 0;

                    if ($statisticyear->save() == false) {
                        foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                       }
                    }
                }
                
                for ($k = 1; $k < $j; $k ++) {
                
                    $statisticyear = new Statisticyear();
                
                    $statisticyear->Year = $Year;
                    $statisticyear->ID_CultDomain = 0;
                    $statisticyear->Yeardomain = 0;
                    $statisticyear->ID_SocImpact = $sector[$k];
                    $statisticyear->Yearsector = 0;

                    if ($statisticyear->save() == false) {
                        foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                       }
                    }
                }
                                
            }
//       die(var_dump($statisticyear)); 
        } */
                 
        $statisticview = '<table class="table table-bordered table-striped" align="center">'
                            .'<thead><tr><th style="vertical-align:top", colspan="8"> SELECTED: '.$CategoryName.'</th> </tr>'
                            .'<th style="vertical-align:top"> No. </th>'
                            .'<th style="vertical-align:top"> YEAR </th>'
                            .'<th style="vertical-align:top"><center> Heritage </center></th>'
                            .'<th style="vertical-align:top"><center> Archives </center></th>'
                            .'<th style="vertical-align:top"><center> Libraries </center></th>'
                            .'<th style="vertical-align:top"><center> Book and Press </center></th>'
                            .'<th style="vertical-align:top"><center> Visual Arts </center></th>'
                            .'<th style="vertical-align:top"><center> Performing Arts </center></th>'
                            .'<th style="vertical-align:top"><center> Audiovisual and Multimedia </center></th>'
                            .'<th style="vertical-align:top"><center> Architecture </center></th>'
                            .'<th style="vertical-align:top"><center> Advertising </center></th>'
                            .'<th style="vertical-align:top"><center> Art crafts </center></th>'
                            .'<th style="vertical-align:top"><center> General cultural dimension </center></th>'
                            .'<th style="vertical-align:top"><center> More cells </center></th>'
                            .'<th style="vertical-align:top"><center> Total </center></th></tr></thead><tbody>';                                    
                      
        $statisticyeardomainrec = Statisticyeardomainrec::find();            
        
        $i = 0;
        foreach ( $statisticyeardomainrec as $statyear) {
            
            $year = $statyear->Year;
            $yeardomain[0] = $year;
            $total = 0;
            $i++;
         
            if ( $ID_Category == 0) {                    
                 $document = Document::find(
                    [    
                        " PubYear = '$year' ",
                        'order'      => 'PubYear',   
                    ]);                    
             } else {                   
                 $document = Document::find(
                   [    
                        " PubYear = '$year' AND ID_Category = '$ID_Category' ",
                        'order'      => 'PubYear',   
                    ]);                    
             }                     
            
            $totaldocument = 0; 
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
            $total6 = 0;
            $total7 = 0;
            $total8 = 0;
            $total9 = 0;
            $total10 = 0;
            $total11 = 0;
            $total12 = 0;
            $total13 = count($document);           
            
            foreach ( $document as $document) {
                
                $ID_Doc = $document->ID_Doc;
//                $ID_Category = $document->ID_Category;
                
                $docstatistic = Docstatistic::findFirst( " ID_Doc = '$ID_Doc' ");
                
                $ID_CultDomain = $docstatistic->ID_CultDomain;
//                echo $ID_CultDomain.'<BR>';
                
                switch ($ID_CultDomain){
                    case 53:
                        $total1 = $total1 + 1;
                        break;
                    case 54:
                        $total2 = $total2 + 1;
                        break;
                    case 55:
                        $total3 = $total3 + 1;
                        break;
                    case 56:
                        $total4 = $total4 + 1;
                        break;
                    case 57:
                        $total5 = $total5 + 1;
                        break;
                    case 58:
                        $total6 = $total6 + 1;
                        break;
                    case 59:
                        $total7 = $total7 + 1;
                        break;
                    case 60:
                        $total8 = $total8 + 1;
                        break;
                    case 61:
                        $total9 = $total9 + 1;
                        break;
                    case 62:
                        $total10 = $total10 + 1;
                        break;
                    case 64:
                        $total11 = $total11 + 1;
                        break;
                    case 0:
                        $total12 = $total12 + 1;
                        break;                    
                }
                    
            }

            if ( $ID_Category == 0 ) {
                $statisticyeardomainrec = Statisticyeardomainrec::findFirst(" Year = '$year' ");
                                   
                if ( !$statisticyeardomainrec) {
                
                        $statisticyeardomainrec = new $Statisticyeardomainrec();
                } else {                           
                 
                    $statisticyeardomainrec->Year = $yeardomain[0];                    
                    $statisticyeardomainrec->Domain1 = $total1;
                    $statisticyeardomainrec->Domain2 = $total2;
                    $statisticyeardomainrec->Domain3 = $total3;
                    $statisticyeardomainrec->Domain4 = $total4;
                    $statisticyeardomainrec->Domain5 = $total5;
                    $statisticyeardomainrec->Domain6 = $total6;
                    $statisticyeardomainrec->Domain7 = $total7;
                    $statisticyeardomainrec->Domain8 = $total8;
                    $statisticyeardomainrec->Domain9 = $total9;
                    $statisticyeardomainrec->Domain10 = $total10;
                    $statisticyeardomainrec->Domain11 = $total11;
                    $statisticyeardomainrec->Cells = $total12;
                    $statisticyeardomainrec->Total = $total13;
                    $statisticyeardomainrec->ID_Category = $ID_Category;
        
                    //die(var_dump($statisticyeardomainrec));                
                    
                    if ($statisticyeardomainrec->save() == false) {                       

                        foreach ($statisticyeardomainrec->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                 ]
                            );
                    }                
                }
            }   
            
            $statisticview .= '<tbody><tr><td>'.$i.'</td><td>'.$year.'</td>'
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-53-'.$ID_Category.'">'.$total1.'</a> </center></td>'                            
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-54-'.$ID_Category.'">'.$total2.'</a> </center></td>'                            
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-55-'.$ID_Category.'">'.$total3.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-56-'.$ID_Category.'">'.$total4.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-57-'.$ID_Category.'">'.$total5.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-58-'.$ID_Category.'">'.$total6.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-59-'.$ID_Category.'">'.$total7.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-60-'.$ID_Category.'">'.$total8.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-61-'.$ID_Category.'">'.$total9.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-62-'.$ID_Category.'">'.$total10.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-64-'.$ID_Category.'">'.$total11.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyeardomain/'.$year.'-0-'.$ID_Category.'">'.$total12.'</a> </center></td>'                                                                       
                              .'<td><center><strong>'.$total13.'</strong></center></td>';                                     
        }
        
        $statisticview .=  '</tbody></table>';   
        
        $statisticyeardomainrec = Statisticyeardomainrec::find();
        
        $paginator = new Paginator(array(
            "data"  => $statisticyeardomainrec,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statisticyeardomainrec;
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('statisticview', $statisticview);        
        
    }

    public function PregledyeardomainAction($ID_Cell){
        
        $numberPage = 1;        
        
        $cell = $ID_Cell;
        $Type = 4;
        $this->session->set("ID_Cell", "$ID_Cell");
        $this->session->set("Type", "$Type");
        $cell_loc = explode("-",$cell);
        
        $year = $cell_loc[0];
        $ID_CultDomain = $cell_loc[1];        
        $ID_Category = $cell_loc[2];    
        $this->session->set("ID_Category", "ID_Category");

//         echo $year.' - '.$ID_CultDomain.' '.$ID_Cell. '<BR>';
//        die(var_dump($yearcell_loc));
        
        $culturaldomain = Culturaldomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
        
        if (  $cell_loc[1] == 0 ) { 
                $CultDomainName = "Document in more then one domains.";            
        } else {
               $culturaldomain = CulturalDomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
               $CultDomainName = $culturaldomain->CultDomainName;
        }    
                
        $doclist = Doclist::find();
        
        foreach ($doclist as $doclist) {
        
            if ($doclist->delete() === false) {
                echo "Sorry, we can't delete the doclist right now: \n";

                $messages = $robot->getMessages();
                
                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } 
        }
        
        if ( $ID_Category == 0) {                    
            $document = Document::find(
                [    
                    " PubYear = '$year' ",
                    'order'      => 'PubYear',   
                ]);                    
         } else {                   
            $document = Document::find(
                [    
                    " PubYear = '$year' AND ID_Category = '$ID_Category' ",
                    'order'      => 'PubYear',   
                ]);                    
         }                  
        
        $documentsview = '<table class="table table-bordered table-striped" align="center"><thead>'
                         .'<tr><th>DOCUMENT ID</th><th>TITLE</th><th>KEYWORDS</th><th>YEAR OF PUBLICATION</th></tr></thead><tbody>';           
     
        foreach ( $document as $doc ) {
                
                $ID_Doc = $doc->ID_Doc; 
                
                $docstat = Docstatistic::findFirst(" ID_Doc = '$ID_Doc'");
                
                    $ID_Domain = $docstat->ID_CultDomain;
                    
                    if ( $ID_Domain == $ID_CultDomain) {
  
                        $ID_Doc = $docstat->ID_Doc;
                        $Domains = $docstat->Domains;
                        $Sectors = $docstat->Sectors;

                        $doclist = new Doclist();
            
                        $doclist->ID_Doc = $ID_Doc;
                        $doclist->Domains = $Domains;
                        $doclist->Sectors = $Sectors;

                        if ($doclist->save() == false) {                       

                            foreach ($doclist->getMessages() as $message) {
                                $this->flash->error($message);
                             }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                ]
                            );
                          }    
                        
                        $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                        $Title = $documentdata->Title;
                        $Keyword = $documentdata->Keywords;
                        $Pubyear = $documentdata->PubYear;  
                    
                        $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
                                          .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'                      
  			                  .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
                    }      
                }           
              
            $documentsview .= '</tbody></table>';    
            
            $doclist = Doclist::find(
                [
                    'order'      => 'ID_Doc', 
                ]);
        
            $paginator = new Paginator(array(
                "data"  => $doclist,
                "limit" => 500,
                "page"  => $numberPage
            ));
            
            $this->view->page = $paginator->getPaginate();   
        
            $this->view->doclist = $doclist;
            $this->view->setVar('CultDomainName', $CultDomainName);
            $this->view->setVar('ID_CultDomain', $ID_CultDomain);
            $this->view->setVar('ID_Category', $ID_Category);
            $this->view->setVar('documentsview', $documentsview);
            $this->view->setVar('Year', $year);
            $this->view->setVar('Type', $Type);     
                
    }
      
    public function StatisticyearsectorAction( $ID_Category = 0){
       
        $this->session->set("ID_Category", "$ID_Category"); 
//        echo $ID_Category.'<BR>';
        if ( $ID_Category == 0 ) $CategoryName = "ALL DOCUMENTS";
        if ( $ID_Category == 2 ) $CategoryName = "SCIENTIFIC DOCUMENTS";
        if ( $ID_Category == 3 ) $CategoryName = "GREY LITERATURE";
        if ( $ID_Category == 1 ) $CategoryName = "UNDEFINED";   
    
        $numberPage = 1;        
        
        $domain = array();
        $yeardomain = array();
        $total1 = 0;
        
        $culturaldomain = Culturaldomain::find();

        $i = 1;
        foreach ( $culturaldomain as $cultdomain){
            
            $domain[$i][0]= $cultdomain->ID_CultDomain;
            $domain[$i][1]= $cultdomain->CultDomainName;
            $i++;
                        
        }
        
        $socialimpact = Socialimpact::find();
        
        $j = 1;
        foreach ( $socialimpact as $socimpact){
           
            $sector[$j]= $socimpact->ID_SocImpact;        
            $j++;
            
        }
        
/**        $document = Document::find(
                        [
                            'order' =>'PubYear',
                        ]);
                foreach ( $document as $document) {
            $Year = $document->PubYear;
            
            $year_domain = Statisticyear::find(" Year = '$Year' ");
            
            if ( count($year_domain) == 0) {

                for ($k = 1; $k < $i; $k ++) {
                
                    $statisticyear = new Statisticyear();
                
                    $statisticyear->Year = $Year;
                    $statisticyear->ID_CultDomain = $domain[$k][0];
                    $statisticyear->Yeardomain = 0;
                    $statisticyear->ID_SocImpact = 0;
                    $statisticyear->Yearsector = 0;

                    if ($statisticyear->save() == false) {
                        foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                       }
                    }
                }
                
                for ($k = 1; $k < $j; $k ++) {
                
                    $statisticyear = new Statisticyear();
                
                    $statisticyear->Year = $Year;
                    $statisticyear->ID_CultDomain = 0;
                    $statisticyear->Yeardomain = 0;
                    $statisticyear->ID_SocImpact = $sector[$k];
                    $statisticyear->Yearsector = 0;

                    if ($statisticyear->save() == false) {
                        foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                       }
                    }
                }
                                
            }
//       die(var_dump($statisticyear)); 
        }  */
        
         $statisticview = '<table class="table table-bordered table-striped" align="center">'
                          .'<thead><tr><th style="vertical-align:top", colspan="8"> SELECTED: '.$CategoryName.'</th> </tr>'
                          .'<th style="vertical-align:top"> No. </th>'
                          .'<th style="vertical-align:top"> YEAR </th>'
                          .'<th style="vertical-align:top"><center> HEALT AND WELLBEING </center></th>'
                          .'<th style="vertical-align:top"><center> URBAN AND TERITORIAL RENOVATION </center></th>'
                          .'<th style="vertical-align:top"><center> PEOPLE ENGAGMENT AND PARTICIPATION </center></th>'
                          .'<th style="vertical-align:top"><center> GENERAL </center></th>'
                          .'<th style="vertical-align:top"><center> DOCUMENTS IN MORE CROSS-OVER THEME </center></th>'
                          .'<th style="vertical-align:top"><center> TOTAL </center></th></tr></thead><tbody>';                                    
                
        $statisticyearsectorrec = Statisticyearsectorrec::find(
                    [    
                        'order'      => 'Year',   
                    ]);
        
        $i = 0;
        foreach ( $statisticyearsectorrec as $statyear) {
            
            $year = $statyear->Year;
            $yeardomain[0] = $year;
            $total = 0;
            $i++;
                    
         
            if ( $ID_Category == 0) {                    
                 $document = Document::find(
                    [    
                        " PubYear = '$year' ",
                        'order'      => 'PubYear',   
                    ]);                    
             } else {                   
                 $document = Document::find(
                   [    
                        " PubYear = '$year' AND ID_Category = '$ID_Category' ",
                        'order'      => 'PubYear',   
                    ]);                    
             }       
            
            $totaldocument = 0; 
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
            $total6 = count($document);;           
            
            foreach ( $document as $documentyear) {
                
                $ID_Doc = $documentyear->ID_Doc;
                
                $docstatistic = Docstatistic::findFirst( " ID_Doc = '$ID_Doc' ");
                
                $ID_SocImpact = $docstatistic->ID_SocImpact;
//                echo $ID_CultDomain.'<BR>';
                
                switch ($ID_SocImpact){
                    case 1:
                        $total1 = $total1 + 1;
                        break;
                    case 2:
                        $total2 = $total2 + 1;
                        break;
                    case 3:
                        $total3 = $total3 + 1;
                        break;
                    case 63:
                        $total4 = $total4 + 1;
                        break;
                    case 0:
                        $total5 = $total5 + 1;
                        break;                    
                }
                    
            }

            if ( $ID_Category == 0 ) {
                
                $statisticyearsectorrec = Statisticyearsectorrec::findFirst(" Year = '$year' ");

                if ( !$statisticyearsectorrec) {
                    
                        $statisticyearsectorrec = new $Statisticyearsectorrec();
                } else {                           
                 
                    $statisticyearsectorrec->Year = $yeardomain[0];
                    $statisticyearsectorrec->Sector1 = $total1;
                    $statisticyearsectorrec->Sector2 = $total2;
                    $statisticyearsectorrec->Sector3 = $total3;
                    $statisticyearsectorrec->Sector4 = $total4;
                    $statisticyearsectorrec->Cells = $total5;
                    $statisticyearsectorrec->Total = $total6;
        
//        die(var_dump($statisticyearsectorrec));                
                    
                    if ($statisticyearsectorrec->save() == false) {                       

                        foreach ($statisticyearsectorrec->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                 ]
                            );
                    }                
                }   
            }
               $statisticview .= '<tbody><tr><td>'.$i.'</td><td>'.$year.'</td>'
                              .'<td><center><a href="/analyse/pregledyearsector/'.$year.'-1-'.$ID_Category.'">'.$total1.'</a> </center></td>'                            
                              .'<td><center><a href="/analyse/pregledyearsector/'.$year.'-2-'.$ID_Category.'">'.$total2.'</a> </center></td>'                            
                              .'<td><center><a href="/analyse/pregledyearsector/'.$year.'-3-'.$ID_Category.'">'.$total3.'</a> </center></td>'                           
                              .'<td><center><a href="/analyse/pregledyearsector/'.$year.'-63-'.$ID_Category.'">'.$total4.'</a> </center></td>'                                                         
                              .'<td><center><a href="/analyse/pregledyearsector/'.$year.'-0-'.$ID_Category.'">'.$total5.'</a> </center></td>'                                                                       
                              .'<td><center><strong>'.$total6.'</strong></center></td>';                                     
        }
        
        $statisticview .=  '</tbody></table>'; 

        $statisticyearsectorrec = Statisticyearsectorrec::find();
        
        $paginator = new Paginator(array(
            "data"  => $statisticyearsectorrec,
            "limit" => 800,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statisticyearsectorrec;
        $this->view->setVar('ID_Category', $ID_Category);  
        $this->view->setVar('statisticview', $statisticview);  
        
    }

    public function PregledyearsectorAction($ID_Cell){
        
        $numberPage = 1;        
        
        $cell = $ID_Cell;
        $Type = 5;
        $this->session->set("ID_Cell", "$ID_Cell");
        $this->session->set("Type", "$Type");
        $cell_loc = explode("-",$cell);
        
        $year = $cell_loc[0];
        $ID_SocImpact = $cell_loc[1];      
        $ID_Category = $cell_loc[2];      
        $this->session->set("ID_Category", "$ID_Category");       

//        echo $year.' - '.$ID_SocImpact.' '.$ID_Cell. '<BR>';
//        die(var_dump($yearcell_loc));
        
        if (  $cell_loc[1] == 0 ) { 
                $SocImpactName = "Documents in more cross-over theme";
        } else {
               $socialimpact = Socialimpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");
               $SocImpactName = $socialimpact->SocImpactName;
        }                                           
                  
        $doclist = Doclist::find();
        
        foreach ($doclist as $doclist) {
        
            if ($doclist->delete() === false) {
                echo "Sorry, we can't delete the doclist right now: \n";

                $messages = $robot->getMessages();
                
                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } 
        }          
        
        if ( $ID_Category == 0) {                    
            $document = Document::find(
                [    
                    " PubYear = '$year' ",
                    'order'      => 'PubYear',   
                ]);                    
         } else {                   
            $document = Document::find(
                [    
                    " PubYear = '$year' AND ID_Category = '$ID_Category' ",
                    'order'      => 'PubYear',   
                ]);                    
         }           
         
        $documentsview = '<table class="table table-bordered table-striped" align="center"><thead>'
                         .'<tr><th>DOCUMENT ID</th><th>TITLE</th><th>KEYWORDS</th><th>YEAR OF PUBLICATION</th></tr></thead><tbody>';           
     
        foreach ( $document as $doc ) {
                
            $ID_Doc = $doc->ID_Doc; 
                
            $docstat = Docstatistic::findFirst(" ID_Doc = '$ID_Doc'");
                
                $ID_Sector = $docstat->ID_SocImpact;
                    
                    if ( $ID_Sector == $ID_SocImpact) {
  
                        $ID_Doc = $docstat->ID_Doc;
                        $Domains = $docstat->Domains;
                        $Sectors = $docstat->Sectors;

                        $doclist = new Doclist();
            
                        $doclist->ID_Doc = $ID_Doc;
                        $doclist->Domains = $Domains;
                        $doclist->Sectors = $Sectors;

                        if ($doclist->save() == false) {                       

                            foreach ($doclist->getMessages() as $message) {
                                $this->flash->error($message);
                             }

                            return $this->dispatcher->forward(
                                [
                                    "controller" => "analyse",
                                    "action"     => "index",
                                ]
                            );
                          }  
                        
                        $documentdata = Document::findFirst( " ID_Doc = '$ID_Doc' ");
                        $Title = $documentdata->Title;
                        $Keyword = $documentdata->Keywords;
                        $Pubyear = $documentdata->PubYear;  
                    
                        $documentsview .= '<tr><td>'.$ID_Doc.'</td><td>'.$Title.'</td><td>'.$Keyword.'</td><td>'.$Pubyear.'</td>'		
                                          .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>'                                                  
	  		                  .'<td width="7%"><a href="/analyse/detail/'.$ID_Doc.'" target="_blank"." class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Open in new tab </a></td>';
                    }      
                }           
              
            $documentsview .= '</tbody></table>';    
            
            $doclist = Doclist::find(
                [
                    'order'      => 'ID_Doc', 
                ]);
        
            $paginator = new Paginator(array(
                "data"  => $doclist,
                "limit" => 500,
                "page"  => $numberPage
            ));
            
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->doclist = $doclist;
        $this->view->setVar('SocImpactName', $SocImpactName);
        $this->view->setVar('ID_Cell', $ID_Cell);
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('documentsview', $documentsview);
        $this->view->setVar('Year', $year);
        $this->view->setVar('Type', $Type);
        
      }  

       public function DetailAction($ID_Doc){
        
        $numberPage = 1;
        $this->tag->setTitle($ID_Doc);

        if ($this->session->has("ID_Cell")) {
            // Retrieve its value
            $ID_Cell = $this->session->get("ID_Cell");
            $ID_CultDomain = $this->session->get("ID_CultDomain");
            $ID_SocImpact = $this->session->get("ID_SocImpact");
            $ID_Theme = $this->session->get("ID_Theme");
            $ID_Domain = $this->session->get("ID_Domain");
            $ID_Category = $this->session->get("ID_Category");	
            $Type = $this->session->get("Type");
        }
    
        $document = $this->dispatcher->getParam("document");
        
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $docview = '';
        
        $upload = Upload::find(" ID_Doc = '$ID_Doc'");
        
        $doctransitionvar = Doctransitionvar::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doctransitionvar) > 0) {
            
            $docview .= ' <H4>TRANSITION VARIABLE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                      .'<thead><tr><th>CROSS OVER THEME</th><th>TRANSITION VARIABLE</th><th>KEYWORD TRANSITION VARIABLE</th></tr></thead><tbody><tr>';
       
                $doctransitionvar = "SELECT TV.ID_Transvar,TV.TransvarName, TS.ID_SocImpact FROM transitionvar TV INNER JOIN doctransitionvar DT ON TV.ID_Transvar = DT.ID_Transvar INNER JOIN transitionvarsocialimpact TS ON TV.ID_Transvar = TS.ID_Transvar WHERE DT.ID_Doc = $ID_Doc ORDER by TS.ID_SocImpact ";                        
                $resultGeneral = $this->db->query($doctransitionvar);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral);            
                
                foreach ($resultGeneral as $row => $result) {
                    
                    $ID_Tranvsar = $result['ID_Transvar'];
                    $TranvsarName = $result['TransvarName'];
                                        
                    if ( $result['ID_SocImpact'] == 1 ) $tranvarsector = "H&W"; 
                    if ( $result['ID_SocImpact'] == 2 ) $tranvarsector = "U&TR"; 
                    if ( $result['ID_SocImpact'] == 3 ) $tranvarsector = "PE&P"; 
                    if ( $result['ID_SocImpact'] == 63 ) $tranvarsector = "G&S&I";
   
                    $transvarkeywordtv = "SELECT K.KeywordtvName FROM keywordtv K INNER JOIN transitionvarkeywordtv TK ON TK.ID_Keywordtv = K.ID_keywordtv WHERE TK.ID_Doc = $ID_Doc AND TK.ID_Transvar = $ID_Tranvsar ";                        
                    $resultGeneral2 = $this->db->query($transvarkeywordtv);
                    $resultGeneral2->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                    $resultGeneral2 = $resultGeneral2->fetchAll($resultGeneral2);                      
                    $n = 1;
                   
                    foreach ($resultGeneral2 as $row => $result2) {
                        if ( $n == 1) {
                            $docview .= '<td>'.$tranvarsector.'</td><td>'.$TranvsarName.'</td><td>'.$result2['KeywordtvName'].'</td></tr>';
                            $n++;
                        }else {
                        $docview .= '<td></td><td></td><td>'.$result2['KeywordtvName'].'<BR></td></tr>';    
                        }        
                    }
                 }
       
            $docview .=  '</tbody></table>';
          
        }
        
        if (count($upload) > 0) {
            
            $docview .= ' <H4>DOCUMENT UPLOADS</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>UPLOAD USER NAME</th><th>FILE SIZE</th><th>FILE TYPE</th><th>DOWNLOAD</th></tr></thead><tbody><tr>';
                
                foreach ($upload as $upload_data) {
                    
                    $UserFileName = $upload_data->UserFileName;
                    $FileName = $upload_data->FileName;
                    $FileSize = $upload_data->FileSizeKB;
                    $FileType = $upload_data->FileType;
                    $Download = $upload_data->Download;
                    $docview .= '<td>'.$UserFileName.'</td><td>'.$FileSize.'</td><td>'.$FileType.'</td><td>'.$Download.'</td>';
//                    $docview .= '</td><td> {{link_to("../uploads/"'.$FileName.', <i class="glyphicon glyphicon-download"></i> Download, "class": "btn btn-default") }}'.'</td></tr>';
                    $docview .= '</td><td><a target = "_blank" href="/../uploads/'.$FileName.'" class="btn btn-default"><i class="glyphicon glyphicon-download"></i> Download</a></td></tr>';
//                    $docview .= '</td><td><a href="../uploads/"'.$FileName.'" class="btn btn-default" <i class="glyphicon glyphicon-download"></i> Download</a></td></tr>';                    
                 }
       
            $docview .=  '</tbody></table>';

        }

        $documentcultldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentcultldomain) > 0) {
            
            $docview .= ' <H4>CULTURAL SECTOR</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';
       
                $doccultdomain = "SELECT CD.CultDomainName FROM documentculturaldomain DC INNER JOIN culturaldomain CD ON CD.ID_CultDomain = DC.ID_CultDomain WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($doccultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['CultDomainName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';

        }
        
        $documentsocimpact = Documentsocialimpact::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentsocimpact) > 0) {
            
            $docview .= ' <H4>CROSS-OVER THEME</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';
       
                $docsocimpact = "SELECT SC.SocImpactName FROM documentsocialimpact DS INNER JOIN socialimpact SC ON SC.ID_SocImpact = DS.ID_SocImpact WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($docsocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SocImpactName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';

        }
        
        $docauthor = Docauthor::find(" ID_Doc = '$ID_Doc'");
             
        if (count($docauthor) > 0) {
            
            $docview .= ' <H4>AUTHORS</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>LAST NAME</th><th>FIRST NAME</th></tr></thead><tbody><tr>';
       
                $author = "SELECT A.FirstName, A.LastName, C.CountryName, I.InstName FROM docauthor DA INNER JOIN author A ON DA.ID_Author = A.ID_Author INNER JOIN country C ON DA.ID_Country = C.ID_Country INNER JOIN institution I ON DA.ID_Institution = I.ID_Institution WHERE DA.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($author);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['LastName'].'</td><td>'.$result['FirstName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';
            
        }
        
        $doccountry = Doccountry::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doccountry) > 0) {
            
            $docview .= ' <H4>TERRITORIAL CONTEXT</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>COUNTRY CODE</th><th>COUNTRY</th><th>REGION</th><th>CITY</th><th>TERR. CONTEXT</th>'.
                    '</tr></thead><tbody>';
                
                $query = "SELECT R.RegionName, C.CountryCode, C.CountryName, CT.CityName, DC.TeritCon FROM doccountry DC INNER JOIN city CT ON DC.ID_City = CT.ID_City INNER JOIN country C ON DC.ID_Country = C.ID_Country INNER JOIN region R ON DC.ID_Region = R.ID_Region WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['CountryCode'].'</td><td>'.$result['CountryName'].'</td><td>'.$result['RegionName']. '</td><td>'.$result['CityName']. '</td><td>'.$result['TeritCon'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';
                     
        }
  
        $docsearchdatabase = Docsearchdatabase::find(" ID_Doc = '$ID_Doc'");
             
        if (count($docsearchdatabase) > 0) {
            
            $docview = $docview.' <H4>SEARCH DATABASE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>SEARCH DATABASE</th></tr></thead><tbody>';
                    
                $query = "SELECT SD.SearchDatabase FROM docsearchdatabase DS INNER JOIN searchdatabase SD ON DS.ID_Database = SD.ID_Database WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SearchDatabase'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';    
        }    
        
        $doctechnique = Doctechnique::find(" ID_Doc = '$ID_Doc'");
             
        if (count($doctechnique) > 0) {
            
               
            $docview = $docview.' <H4>TECHNIQUE</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>TECHNIQUE</th></tr></thead><tbody>';
                    
                $query = "SELECT T.TechniqueName FROM doctechnique DT INNER JOIN technique T ON DT.ID_Technique = T.ID_Technique WHERE DT.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['TechniqueName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }    
        
        $doclitarea = Doclitarea::find(" ID_Doc = '$ID_Doc'");
        
        if (count($doclitarea) > 0) {
            
             $docview = $docview.' <H4>LITERATURE AREA</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>LITERATURE AREA</th></tr></thead><tbody>';
                    
                $query = "SELECT L.LiteratureArea FROM doclitarea DL INNER JOIN litarea L ON DL.ID_LitArea = L.ID_LitArea WHERE DL.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['LiteratureArea'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
        
        $docdataprov = Docdataprov::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docdataprov) > 0) {
            
               $docview = $docview.' <H4>DATA PROVIDER AREA</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DATA PROVIDER</th></tr></thead><tbody>';
                    
                $query = "SELECT DP.DataProvName FROM docdataprov DDP INNER JOIN dataprov DP ON DDP.ID_DataProv = DP.ID_DataProv WHERE DDP.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['DataProvName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
        
        $docsector = Docsector::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docsector) > 0) {
            
            $docview = $docview.' <H4>SECTOR</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>SECTOR</th></tr></thead><tbody>';
                    
                $query = "SELECT S.SectorName FROM docsector DS INNER JOIN sector S ON DS.ID_Sector = S.ID_Sector WHERE DS.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $docview .= '<td>'.$result['SectorName'].'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
            
        }
              
        $docinstitution = Docinstitution::find(" ID_Doc = '$ID_Doc'");
        
        if (count($docinstitution) > 0) {
            
            $docview = $docview.' <H4>INSTITUTION</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>INSTITUTION</th><th>COUNTRY</th></tr></thead><tbody>';
                    
                $query = "SELECT I.InstName, I.ID_Country FROM docinstitution DI INNER JOIN institution I ON DI.ID_Institution = I.ID_Institution WHERE DI.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 

                foreach ($resultGeneral as $row => $result) {
                    $ID_Country  = $result['ID_Country'];
                    $country = Country::findFirst(" ID_Country = '$ID_Country'");
                    $CountryName = $country->CountryName;
                    $docview .= '<td>'.$result['InstName'].'<td>'.$CountryName.'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }

        $doccity = Doccity::find(" ID_Doc = '$ID_Doc'");
        
        if (count($doccity) > 0) {
            
            $docview = $docview.' <H4>CITY LOCATED TO DOCUMENT</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                .'<thead><tr><th>CITY</th><th>COUNTRY</th></tr></thead><tbody>';
                    
                $query = "SELECT C.CityName, C.ID_Country FROM doccity DC INNER JOIN city C ON DC.ID_City = C.ID_City WHERE DC.ID_Doc = $ID_Doc";        
                $resultGeneral = $this->db->query($query);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 

                foreach ($resultGeneral as $row => $result) {
                    $ID_Country  = $result['ID_Country'];
                    $country = Country::findFirst(" ID_Country = '$ID_Country'");
                    $CountryName = $country->CountryName;
                    $docview .= '<td>'.$result['CityName'].'<td>'.$CountryName.'</td></tr>';
                 }
       
            $docview .=  '</tbody></table>';  
        }

        $document->docview = $docview;
        
//        $this->view->document  = $document;
        
        if ($document->save() == false) {
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
        // DOCUMENT 
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        if (count($document) == 0) {
            $this->flash->notice("Document not found");
        }
        
//        $document->DOI =  '<a href="https://doi.org/'.$document->DOI.'" target="_blank">'.$document->DOI.'</a>';

        $document->Links =  '<a href="'.$document->Links.'" target="_blank">'.$document->Links.'</a>';
        
        $this->view->document  = $document;
        
        $paginator = new Paginator(array(
            "data"  => $document,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
//        $this->view->page = $paginator->getPaginate();
        $this->view->setVar('ID_Cell', $ID_Cell);
        $this->view->setVar('ID_YearCell', $ID_Cell);
        $this->view->setVar('ID_CultDomain', $ID_CultDomain);
        $this->view->setVar('ID_SocImpact', $ID_SocImpact);
        $this->view->setVar('ID_Theme', $ID_Theme);
        $this->view->setVar('ID_Domain', $ID_Domain);        
        $this->view->setVar('ID_Category', $ID_Category);
        $this->view->setVar('Type', $Type);
            
    }
    
}
