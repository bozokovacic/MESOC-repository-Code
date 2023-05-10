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
 
       public function StatisticAction($ID_Category){
die();
        $numberPage = 1;        
        
        if (empty($ID_Category)) $ID_Category = 0;
                      
        echo $ID_Category;
die(var_dump($ID_Category));
        
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
                       
        $document = Document::find();
        die(var_dump($document));
        foreach ( $document as $doc) {
            
            $ID_Doc = $doc->ID_Doc;
            
            $docstatistic = Docstatistic::findFirst( " ID_Doc = '$ID_Doc' ");
            
            if (count($docstatistic) == 0 ) $docstatistic = new Docstatistic();
            die(var_dump($docstatistic));
            $docculturaldomain = Documentculturaldomain::find( " ID_Doc = '$ID_Doc' ");                                            
                    
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
                $docstatistic->ID_CultDomain = 0;
                $docstatistic->Domains = $Domains;
//                die(var_dump($docstatistic));
            } 
            
            if (count($docculturaldomain) == 1) {
         
                foreach ($docculturaldomain as $docdomain)  $ID_CultDomain = $docdomain->ID_CultDomain;
                
                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_CultDomain = $ID_CultDomain;
                $docstatistic->Domains = 0;
//                die(var_dump($docstatistic));
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
//                die(var_dump($docstatistic));
            } 
            
            if (count($docsocialimpact) == 1) {
         
                foreach ( $docsocialimpact as $docimpact)  $ID_SocImpact = $docimpact->ID_SocImpact;
                
                $docstatistic->ID_Doc = $ID_Doc;
                $docstatistic->ID_SocImpact = $ID_SocImpact;
                $docstatistic->Sectors = 0;
//                die(var_dump($docstatistic));
            }
                
            if (count($docsocialimpact) == 0) echo 'SocImpact: '.$ID_Doc.'<BR>'; 
            
            if ($docstatistic->save() == false) {
                foreach ($docstatistic->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }                          
            
        }                   
 
        for ($i = 1; $i<=11; $i++) {
            
            $statistictemp = new Statistic();

            $statistictemp->Row = $i;
            $statistictemp->ID_Domain = $domain[$i][0];
            $statistictemp->CultDomainName = $domain[$i][1];
            
            $sum = 0;
           
            for ($j = 1; $j <=4; $j++) {
                
                $domena = $domain[$i][0];
                $sectortemp = $sector[$j];
//                echo $domena.' - '.$sectortemp.'<BR>';
                $statisticresult = "SELECT * from Document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc INNER JOIN documentsocialimpact SI ON D.ID_Doc = SI.ID_Doc WHERE CD.ID_CultDomain = $domena AND SI.ID_SocImpact = $sector[$j]";                      
                $resultGeneral = $this->db->query($statisticresult);
//                echo $statisticresult.'<BR>';
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                $count = 0;
                foreach ($resultGeneral as $row => $result) {
                    $count++;
                 }
                switch ($j) {
                    case 1:
                        $statistictemp->Sector1 = $count;
                        $total1 = $total1 + $count;
                        break;
                    case 2:
                        $statistictemp->Sector2 = $count;
                        $total2 = $total2 + $count;
                        break;
                    case 3:
                        $statistictemp->Sector3 = $count;
                        $total3 = $total3 + $count;
                        break;
                    case 4:
                        $statistictemp->General = $count;
                        $total4 = $total4 + $count;
                        break;
                  }    
                  $sum = $sum + $count;
                }
                $statistictemp->Total = $sum;
                $total5 = $total5 + $sum;
               
                $statistic = Statistic::findFirst(" Row = '$i'");
                
                if(count($statistic) == 0 ){     

                    $statistic = $statistictemp;              
                    
                } else {

                    $statistic->Sector1 = $statistictemp->Sector1; 
                    $statistic->Sector2 = $statistictemp->Sector2; 
                    $statistic->Sector3 = $statistictemp->Sector3; 
                    $statistic->General = $statistictemp->General; 
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
                
        $statistic = Statistic::find();
  
        $paginator = new Paginator(array(
            "data"  => $statistic,
            "limit" => 11,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statistic;
        $this->view->setVar('total1', $total1);
        $this->view->setVar('total2', $total2);
        $this->view->setVar('total3', $total3);
        $this->view->setVar('total4', $total4);
        $this->view->setVar('total5', $total5);
        $this->view->setVar('total6', $total6);
        
      }
 
       public function PregleddocAction($ID_Cell){
        
        $numberPage = 1;        
        
        $cell = $ID_Cell;
        $Type = 1;
        $this->session->set("ID_Cell", "$ID_Cell");
        $this->session->set("Type", "$Type");
        $cell_loc = explode("-",$cell);
        
        $ID_CultDomain = $cell_loc[0];
        $ID_SocImpact = $cell_loc[1];        

//        echo $ID_CultDomain.' - '.$ID_SocImpact.'<BR>';
//        die(var_dump($cell_loc));
        
        $culturaldomain = Culturaldomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
        
        if ( count($culturaldomain) == 0) {
            
        } else{
            $CultDomainName = $culturaldomain->CultDomainName;
        }
        
        $socialimpact = Socialimpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");
        
        if ( count($socialimpact) == 0) {
            
        } else{
            $SocialImpactName = $socialimpact->SocImpactName;
        }
       
        
            $pregleddoc = "SELECT * from Document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc INNER JOIN documentsocialimpact SI ON D.ID_Doc = SI.ID_Doc WHERE CD.ID_CultDomain = $ID_CultDomain AND SI.ID_SocImpact = $ID_SocImpact";                      

            $document = new Document();         
            $pregleddoc = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($pregleddoc));

            $paginator = new Paginator(array(
            "data"  => $pregleddoc,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->pregleddoc = $pregleddoc;
        $this->view->setVar('CultDomainName', $CultDomainName);
        $this->view->setVar('SocialImpactName', $SocialImpactName);
        $this->view->setVar('ID_Cell', $cell);
        $this->view->setVar('Type', $Type);
        
      }  
      
      public function DetailAction($ID_Doc){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Cell")) {
            // Retrieve its value
            $ID_Cell = $this->session->get("ID_Cell");
            $ID_CultDomain = $this->session->get("ID_CultDomain");
            $ID_SocImpact = $this->session->get("ID_SocImpact");
            $Type = $this->session->get("Type");
        }
    
        $document = $this->dispatcher->getParam("document");
        
        $document = Document::findFirst(" ID_Doc = '$ID_Doc'");
        
        $docview= '';
        
        $documentcultldomain = Documentculturaldomain::find(" ID_Doc = '$ID_Doc'");
             
        if (count($documentcultldomain) > 0) {
            
            $docview = ' <H4>CULTURAL SECTOR</H4> <BR> <table class="table table-bordered table-striped" align="center">'
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
        
        $document->DOI =  '<a href="https://doi.org/'.$document->DOI.'" target="_blank">'.$document->DOI.'</a>';
        
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
        $this->view->setVar('Type', $Type);
            
    }
            
      public function statisticsectorAction()
    {
        $numberPage = 1;
        
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
        
        $paginator = new Paginator([
            "data"  => $statistic,
            "limit" => 15,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->statistic = $statistic;
       
    }

    public function PregleddocsectorAction($ID_CultDomain){
        
        $numberPage = 1;        
        $Type = 2;
        
        $this->session->set("ID_CultDomain", "$ID_CultDomain");
        $this->session->set("Type", "$Type");        
        
//        echo $ID_CultDomain.' - '.$ID_SocImpact.'<BR>';
//        die(var_dump($cell_loc));
        
        $culturaldomain = Culturaldomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
        
        if ( count($culturaldomain) == 0) {
            
        } else{
            $CultDomainName = $culturaldomain->CultDomainName;
        }
        
        $doccultdomain = DocumentCulturaldomain::find(" ID_CultDomain = '$ID_CultDomain'");
        
        foreach ($doccultdomain as $doc) {
            
            $ID_Doc = $doc->ID_Doc;
            echo $ID_Doc;
            $document = Document::findFirst(" ID_Doc = '$ID_Doc'");

            if ( count($document) == 1) {                
                
                $Title = $document->Title;
                $PubYear = $document->PubYear;
                $ID_Type = $document->ID_Type;
                $Keywords = $document->Keywords;
                
                $pregleddoc = new Pregleddoc();

                $predleddoc->ID_Doc = $ID_Doc;
                $predleddoc->Title = $Title;
                $predleddoc->PubYear = $PubYear;
                $predleddoc->ID_Type = $ID_Type;
                
                if ($pregleddoc->save() == false) {
                    foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                  }
                die(var_dump($predleddoc));
            }
        }
/**            $pregleddocsector = "SELECT DISTINCT * from document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc WHERE CD.ID_CultDomain = $ID_CultDomain";                      
echo $pregleddocsector;
            $document = new Document();         
            $pregleddocsector = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($pregleddocsector));
*/
        
            $paginator = new Paginator(array(
            "data"  => $pregleddocsector,
            "limit" => 300,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->pregleddocsector = $pregleddocsector;
        $this->view->setVar('CultDomainName', $CultDomainName);
        $this->view->setVar('ID_CultDomain', $ID_CultDomain);
        $this->view->setVar('Type', $Type);
        
      }  
 
    public function statisticthemeAction()
    {
        $numberPage = 1;
        
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

        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        
        foreach ( $statistic as $stat) {
            $total1 = $total1 + $stat->Sector1;
            $total2 = $total2 + $stat->Sector2;
            $total3 = $total3 + $stat->Sector3;
            $total4 = $total4 + $stat->General;
        }
        
        $paginator = new Paginator([
            "data"  => $statistic,
            "limit" => 15,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->statistic = $statistic;
        $this->view->total1  = $total1;
        $this->view->total2  = $total2;
        $this->view->total3  = $total3;
        $this->view->total4  = $total4;

    }
    
     public function PregleddocthemeAction($ID_SocImpact){
        
        $numberPage = 1;        
        $Type = 3;
        $new = array();
        $new[0][1] = 5;
        
        $this->session->set("ID_SocImpact", "$ID_SocImpact");
        $this->session->set("Type", "$Type");        
        
//        echo $ID_CultDomain.' - '.$ID_SocImpact.'<BR>';
//        die(var_dump($cell_loc));
        
        $socialimpact = Socialimpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");
        
        if ( count($socialimpact) == 0) {
            
        } else{
            $SocImpactName = $socialimpact->SocImpactName;
        }
                           
            $pregleddoctheme = "SELECT * from Document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc INNER JOIN documentsocialimpact SI ON D.ID_Doc = SI.ID_Doc WHERE SI.ID_SocImpact = $ID_SocImpact";                      

            $document = new Document();         
            $pregleddoctheme = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($pregleddoctheme));

            $paginator = new Paginator(array(
            "data"  => $pregleddoctheme,
            "limit" => 200,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->pregleddocsector = $pregleddoctheme;
        $this->view->setVar('SocImpactName', $SocImpactName);
        $this->view->setVar('ID_SocImpact', $ID_SocImpact);
        $this->view->setVar('Type', $Type);
        $this->view->setVar('new', $new);
        
      }  
     
    public function StatisticyeardomainAction()
    {
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
        
        $document = Document::find(
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
        }
        
        $statisticyear = Statisticyear::find(
                    [    
                        'order'      => 'Year',   
                    ]);
        
        foreach ( $statisticyear as $statyear) {
            
            $year = $statyear->Year;
            $yeardomain[0] = $year;
            $total = 0;
         
            $statisticyeardomainrec = Statisticyeardomainrec::find(" Year = '$year' ");
            
            if ( count($statisticyeardomainrec) == 0) {
               for ($i = 1; $i<=11; $i++) {
            
//                $yeardomain[$year][1] = $domain[$i][0];
                    $domena = $domain[$i][0];             
                        
                        $domena = $domain[$i][0];
//                      echo $year.' - '.$domena.'<BR>';                  
                        $statisticicyeardomain = "SELECT * from document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc WHERE CD.ID_CultDomain = $domena AND D.PubYear = $year";                      
//                      echo $statisticicyeadrdomain.'<BR>';
        
                        $document_domain = new Document();         
                        $document_domain = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($statisticicyeardomain));

                        $yeardomain[$i] = count($document_domain);
                        $totalyeardomain = count($document_domain);

                        $statisticyear = Statisticyear::findFirst ("(Year = '$year' AND ID_CultDomain = '$domena')");
//                      die(var_dump($statisticyear)); 
                   
                        if ( count($statisticyear) == 0) {
                        
                            $statisticyear = new Statisticyear();
                
                            $statisticyear->Year = $year;
                            $statisticyear->ID_CultDomain = $domena;
                            $statisticyear->Yeardomain = $totalyeardomain;
  //
                        } else {                           
                            $statisticyear->Yeardomain = $totalyeardomain;                          
//                          if ( $domena == 64) die(var_dump($statisticyear));
                        }
       
                        if ($statisticyear->save() == false) {
                            foreach ($statisticyear->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                        }       
                            $total = $total + $totalyeardomain ;	
                    }          
                
                    $yeardomain[$i] = $total;

                    $year = $yeardomain[0];
                    $statisticyeardomainrec = Statisticyeardomainrec::findFirst(" Year = '$year' ");
                
                    if ( count($statisticyeardomainrec) == 0  ) {
                    
                        $statisticyeardomainrec = new Statisticyeardomainrec();
                    }     
                
                        $statisticyeardomainrec->Year = $yeardomain[0];
                        $statisticyeardomainrec->Domain1 = $yeardomain[1];
                        $statisticyeardomainrec->Domain2 = $yeardomain[2];
                        $statisticyeardomainrec->Domain3 = $yeardomain[3];
                        $statisticyeardomainrec->Domain4 = $yeardomain[4];
                        $statisticyeardomainrec->Domain5 = $yeardomain[5];
                        $statisticyeardomainrec->Domain6 = $yeardomain[6];
                        $statisticyeardomainrec->Domain7 = $yeardomain[7];
                        $statisticyeardomainrec->Domain8 = $yeardomain[8];
                        $statisticyeardomainrec->Domain9 = $yeardomain[9];
                        $statisticyeardomainrec->Domain10 = $yeardomain[10];
                        $statisticyeardomainrec->Domain11 = $yeardomain[11];
                        $statisticyeardomainrec->Total = $yeardomain[12];
                
                        if ($statisticyeardomainrec->save() == false) {
                            foreach ($statisticyeardomainrec->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                        }               
 
                }
//              die(var_dump($yeardomain));                
            }    
        $statisticyeardomainrec = Statisticyeardomainrec::find();
        
        $paginator = new Paginator(array(
            "data"  => $statisticyeardomainrec,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statisticyeardomainrec;
        
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

//        echo $year.' - '.$ID_CultDomain.' '.$ID_Cell. '<BR>';
//        die(var_dump($yearcell_loc));
        
        $culturaldomain = Culturaldomain::findFirst(" ID_CultDomain = '$ID_CultDomain'");
        
        if ( count($culturaldomain) > 0) {
            
            $CultDomainName = $culturaldomain->CultDomainName;
        }
              
            $pregleddoc = "SELECT * from document D INNER JOIN documentculturaldomain CD ON D.ID_Doc = CD.ID_Doc WHERE CD.ID_CultDomain = $ID_CultDomain AND D.PubYear = $year";                      

            $document = new Document();         
            $pregleddoc = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($pregleddoc));

            $paginator = new Paginator(array(
            "data"  => $pregleddoc,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->pregleddoc = $pregleddoc;
        $this->view->setVar('CultDomainName', $CultDomainName);
        $this->view->setVar('ID_Cell', $ID_Cell);
        $this->view->setVar('Year', $year);
        $this->view->setVar('Type', $Type);
        
      }  

      
    public function StatisticyearsectorAction()
    {
    $numberPage = 1;        
        
        $sector = array();
        $yearsector = array();
        $total1 = 0;
        
        $socialimpact = Socialimpact::find();
        
        $j = 1;
        foreach ( $socialimpact as $socimpact){
           
            $sector[$j][0]= $socimpact->ID_SocImpact;        
            $sector[$j][1]= $socimpact->SocImpactName;
            $j++;
            
        }

        $document = Document::find(
                        [
                            'order' =>'PubYear',
                        ]);
        
        foreach ( $document as $document) {
            $Year = $document->PubYear;
            
            $year_sector = Statisticyear::find(" Year = '$Year' ");
            
            if ( count($year_sector) == 0) {
                                
                for ($k = 1; $k < $j; $k ++) {
                
                    $statisticyear = new Statisticyear();
                
                    $statisticyear->Year = $Year;
                    $statisticyear->ID_CultDomain = 0;
                    $statisticyear->Yeardomain = 0;
                    $statisticyear->ID_SocImpact = $sector[$k][0];
                    $statisticyear->Yearsector = 0;

                    if ($statisticyear->save() == false) {
                        foreach ($statisticyear->getMessages() as $message) {
                        $this->flash->error($message);
                       }
                    }
                }
                                
            }
        }
        
        $statisticyear = Statisticyear::find(
                    [    
                        'order'      => 'Year',   
                    ]);
        
        foreach ( $statisticyear as $statyear) {
            
            $year = $statyear->Year;
            $yearsector[0] = $year;
            
            $total = 0;
            
            $statisticyearsectorrec = Statisticyearsectorrec::find(" Year = '$year' ");
//            die(var_dump($statisticyearsectorrec));
            if ( count($statisticyearsectorrec) == 0) {
                for ($i = 1; $i<=4; $i++) {
                
                    $sectorfind = $sector[$i][0];             
                                            
                    echo $year.' - '.$sectorfind.'<BR>';                  
                        $statisticicyearsector = "SELECT * from document D INNER JOIN documentsocialimpact SI ON D.ID_Doc = SI.ID_Doc WHERE SI.ID_SocImpact = $sectorfind AND D.PubYear = $year";                      
                        echo $statisticicyearsector.'<BR>';
        
                        $document_sector = new Document();         
                        $document_sector = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($statisticicyearsector));

                        $yearsector[$i] = count($document_sector);
                        $totalyearsector = count($document_sector);

                        $statisticyear = Statisticyear::findFirst ("(Year = '$year' AND ID_SocImpact = '$sectorfind')");
//                    die(var_dump($statisticyear)); 
                   
                        if ( count($statisticyear) == 0) {
                        
                            $statisticyear = new Statisticyear();
                
                            $statisticyear->Year = $year;
                            $statisticyear->ID_SocImpact = $sectorfind;
                            $statisticyear->Yearsector = $totalyearsector;
  //
                        } else {                           
                            $statisticyear->Yearsector = $totalyearsector;                          
//                        if ( $sectorfind == 63) die(var_dump($statisticyear));
                        }
       
                        if ($statisticyear->save() == false) {
                            foreach ($statisticyear->getMessages() as $message) {
                                $this->flash->error($message);
                           }
                        }
                    }   
                       $total = $total + $totalyearsector ;	         
                    
                    $yearsector[$i] = $total;
 
                    $year = $yearsector[0];
 
                    $statisticyearsectorrec = Statisticyearsectorrec::findFirst(" Year = '$year' ");

                    if ( count($statisticyearsectorrec) == 0  ) {
                    
                        $statisticyearsectorrec = new Statisticyearsectorrec();
                    
                    }     
                
                        $statisticyearsectorrec->Year = $yearsector[0];
                        $statisticyearsectorrec->Sector1 = $yearsector[1];
                        $statisticyearsectorrec->Sector2 = $yearsector[2];
                        $statisticyearsectorrec->Sector3 = $yearsector[3];
                        $statisticyearsectorrec->Sector4 = $yearsector[4];
                        $statisticyearsectorrec->Total = $yearsector[5];
                   
                        if ($statisticyearsectorrec->save() == false) {
                            foreach ($statisticyearsectorrec->getMessages() as $message) {
                                $this->flash->error($message);
                            }
                        } 
                }   
            }
              
                
        $statisticyearsectorrec = Statisticyearsectorrec::find();
        
        $paginator = new Paginator(array(
            "data"  => $statisticyearsectorrec,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        $this->view->statistic = $statisticyearsectorrec;
        
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

//        echo $year.' - '.$ID_SocImpact.' '.$ID_Cell. '<BR>';
//        die(var_dump($yearcell_loc));
        
        $socialimpact = SocialImpact::findFirst(" ID_SocImpact = '$ID_SocImpact'");
        
        if ( count($socialimpact) > 0) {
            
            $SocImpactName = $socialimpact->SocImpactName;
        }
              
            $pregleddoc = "SELECT * from document D INNER JOIN documentsocialimpact SI ON D.ID_Doc = Si.ID_Doc WHERE SI.ID_SocImpact = $ID_SocImpact AND D.PubYear = $year";                      

            $document = new Document();         
            $pregleddoc = new Phalcon\Mvc\Model\Resultset\Simple(null, $document, $document->getReadConnection()->query($pregleddoc));

            $paginator = new Paginator(array(
            "data"  => $pregleddoc,
            "limit" => 100,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->pregleddoc = $pregleddoc;
        $this->view->setVar('SocImpactName', $SocImpactName);
        $this->view->setVar('ID_Cell', $ID_Cell);
        $this->view->setVar('Year', $year);
        $this->view->setVar('Type', $Type);
        
      }  

}
