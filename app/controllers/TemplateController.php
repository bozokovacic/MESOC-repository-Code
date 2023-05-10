<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TemplateController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Template');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new TemplatecasestudyForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;

        $auth = $this->session->get('auth');
        $id = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Template", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $template = Template::find($parameters);
        if (count($template) == 0) {
            $this->flash->notice("Template is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $template,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->template = $template;
        $this->view->setVar('ID_Role', $ID_Role);
    }

      public function viewAction($view = 0)
    {
        $numberPage = 1;                                     
        
        if ($this->dispatcher->getParam("view")) {
            // Retrieve its value
            $view = $this->dispatcher->getParam("view");
        }        
        
        $this->session->set("view", "$view");
        
        $auth = $this->session->get('auth');
        $id = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];
        
        if ( $view == 0 ) $viewtype = 'ALL DOCUMENTS';
        if ( $view == 1 ) $viewtype = 'STORED TO REPOSITORY';
        if ( $view == 2 ) $viewtype = 'REJECTED';
        if ( $view == 3 ) $viewtype = 'WAITING';            
            
        if ($ID_Role == 4) {
            
            switch ($view) {
            
                case 0:  
                    $template = Template::find(); 
                    break;  
                case 1:  
                    $template = Template::find(" Checked = 1 "); 
                    break;  
                case 2:  
                    $template = Template::find(" Checked = 2 "); 
                    break;  
                case 3:  
                    $template = Template::find(" Checked = 0 "); 
                    break;  
              }
            } else {  
              
              switch ($view) {
            
                case 0:  
                    $template = Template::find(" ID_Partner = '$ID_Partner' "); 
                    break;  
                case 1:  
                    $template = Template::find("ID_Partner = '$ID_Partner' AND Checked = 1 "); 
                    break;  
                case 2:  
                    $template = Template::find("ID_Partner = '$ID_Partner' AND Checked = '2' ");
                    break;  
                case 3:  
                    $template = Template::find("ID_Partner = '$ID_Partner' AND Checked = 0 ");
                    break;  
                 }
        }
        
/*        if (count($template) == 0) {
            
            $this->flash->notice("Document proposal is not found.");
            
            $view = 0;

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                    "params"     => [$view]
                ]
            );
        } */

        $paginator = new Paginator([
            "data"  => $template,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->template = $template;
        $this->view->setVar('viewtype', $viewtype);
        $this->view->setVar('view', $view);
        $this->view->setVar('ID_Role', $ID_Role);
        
    }
    
     /**
     * Pregled svojstava template
     */
    public function pregledAction($ID_Proposal){
        
        $numberPage = 1;
        
        if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 

        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");

        $this->view->template  = $template;
        
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
        if (count($template) == 0) {
            $this->flash->notice("Template not found");
        }

        $templateview = '';
        $templatecultldomain = Templateculturaldomain::find(" ID_Proposal = '$ID_Proposal'");
             
        if (count($templatecultldomain) > 0) {
            
            $templateview .= ' <H4>CULTURAL DOMAIN</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL DOMAIN NAME</th></tr></thead><tbody><tr>';
       
                $templatecultdomain = "SELECT CD.CultDomainName FROM templateculturaldomain DC INNER JOIN culturaldomain CD ON CD.ID_CultDomain = DC.ID_CultDomain WHERE DC.ID_Proposal = $ID_Proposal";        
                $resultGeneral = $this->db->query($templatecultdomain);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                foreach ($resultGeneral as $row => $result) {
                     $templateview .= '<td>'.$result['CultDomainName'].'</td></tr>';
                 }
       
            $templateview .=  '</tbody></table>';

        }
        
        $templatesocimpact = Templatesocialimpact::find(" ID_Proposal = '$ID_Proposal'");

        if (count($templatesocimpact) > 0) {
            
            $templateview .= ' <H4>SOCIAL IMPACT</H4> <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL DOMAIN NAME</th></tr></thead><tbody><tr>';
       
                $templatesocimpact = "SELECT SC.SocImpactName FROM templatesocialimpact DS INNER JOIN socialimpact SC ON SC.ID_SocImpact = DS.ID_SocImpact WHERE DS.ID_Proposal = $ID_Proposal";        
                $resultGeneral = $this->db->query($templatesocimpact);
                $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
                $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
                
                foreach ($resultGeneral as $row => $result) {
                     $templateview .= '<td>'.$result['SocImpactName'].'</td></tr>';
                 }
       
            $templateview .=  '</tbody></table>';

        }
                            
        $template->templateview = $templateview;
            
        $this->view->template  = $template;
             
                 
        if ($template->save() == false) {
            foreach ($template->getMessages() as $message) {
                $this->flash->error($message);
            }
        }
        
        
        $paginator = new Paginator(array(
            "data"  => $template,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
        $this->view->setVar('view', $view);
            
    }
    
    /**
     * Shows the form to create a new template
     */
    public function newAction($ID_Category=2)
    {
       $this->view->form = new TemplatecasestudyForm(null, ['edit' => true,'ID_Category' => $ID_Category] );
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Proposal)
    {

        if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 
        
        
        $template = $this->dispatcher->getParam("template");
                
        if (!$this->request->isPost()) {

            $template = Template::findFirst("ID_Proposal = '$ID_Proposal'");
            if (!$template) {
                $this->flash->error("Template not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "index",
                    ]
                );
            }
            
                $numberPage = 1;
       
/**         if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }  */
        
//        $keyword = $this->dispatcher->getParam("keyword");
                
        $ID_Category = $template->ID_Category;
        
//        die(var_dump($template));
        
        $culturaldomain = Culturaldomain::find();
        
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $templatecultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CULTURAL DOMAIN</th></tr></thead><tbody><tr>';        

            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $templateculturaldomain = Templateculturaldomain::find("(ID_Proposal = '$ID_Proposal' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($templateculturaldomain) > 0) {
                    $templatecultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/template/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $templatecultview .= '<td></td><td width="7%"><a href="/template/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$CultDomainName.'</td></tr>';
                }   
          }
        }   

        $templatecultview .=  '</tbody></table>';            
                   
        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
              $templatesocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';

            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
                  
              $templatesocialimpact = Templatesocialimpact::find("(ID_Proposal = '$ID_Proposal' AND ID_SocImpact ='$ID_SocImpact')");                         
              if (count($templatesocialimpact) > 0) {
                    $templatesocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/template/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';   
                } else {
                    $templatesocview .= '<td></td><td width="7%"><a href="/template/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$SocImpactName.'</td></tr>';
                }   
           }
        }   

        $templatesocview .=  '</tbody></table>';        
                
        $templatecultdomainsocimpact = $templatecultview.$templatesocview; 
  
        $template->templatecultdomainsocimpact = $templatecultdomainsocimpact;
        
        if ($template->save() == false) {
            foreach ($template->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                ]
            );
        }  
        
//        $template = Template::find(" ID_Proposal = '$ID_Proposal'");
        
//        $this->view->template  = $template;        
                  
        $this->view->form = new TemplatecasestudyForm($template, ['edit' => true,'ID_Category' => $ID_Category] );
        $this->view->setVar('view', $view);
        }
    }

    /**
     * Creates a 
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "new",
                ]
            );
        }

        $form = new TemplatecasestudyForm;
        $template = new Template();
        
        $auth = $this->session->get('auth');
        $ID_User = $auth['id'];
        $ID_Role = $auth['ID_Role'];
        $ID_Partner = $auth['ID_Partner'];
        $template->ID_User = $ID_User;
        $template->ID_Role = $ID_Role;
        $template->ID_Partner = $ID_Partner;
        $template->Created_at = new Phalcon\Db\RawValue('now()');
        $template->ID_Proposal = 0;
    
        $data = $this->request->getPost();
//        print_r($data);
//        die(var_dump($data));
        if (!$form->isValid($data, $template)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "new",
                ]
            );
        }

        $document_all = Document::find();
        $templatetitle = strtolower($template->Title);
        $i = 0;
        
        foreach ( $document_all as $doc_all ) {
            
            $title = strtolower($doc_all->Title);
            if ( $title == $templatetitle ) {
               $i = 1;
               $Doc = $doc_all->ID_Doc;
               break;
            }
        }
        
        $template_all = Template::find();
        $templatetitle = strtolower($template->Title);
        $j = 0;
        
        foreach ( $template_all as $templ_all ) {
            
            $title = strtolower($templ_all->Title);
            if ( $title == $templatetitle ) {
               $j = 1;
               $Doc = $templ_all->ID_Doc;
               break;
            }
        }
        
        if ( $j == 1 ) {
            
            $message1 = 'The proposal document with the same title is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "view",
                    ]
                );
            }
//        die(var_dump($document_all));
        if ( $i == 1 ) {
            
            $message1 = 'The document with the same title is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "document",
                        "action"     => "view",
                    ]
                );
            } else {                           
               if ($template->save() == false) {
                    foreach ($template->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "new",
                    ]
                  );
                }
            

                $form->clear();

                $this->flash->success("Template successfully created.");
            

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "view",
                        "params"     => [$view]
                    ]
                );
            }       
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Proposal
     */
    public function saveAction()
    {
     
        if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 
        
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "index",
                ]
            );
        }

        $ID_Proposal_current = $this->request->getPost("ID_Proposal", "string");

        $template = Template::findFirst("ID_Proposal = '$ID_Proposal_current'");
        if (!$template) {
            $this->flash->error("Template does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                ]
            );
        }

        $form = new TemplatecasestudyForm;

        $data = $this->request->getPost();
         
        $templatetitle = strtolower($data['Title']);
        
        if (!$form->isValid($data, $template)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                ]
            );
        }

        $document_all = Document::find();
        
        $i = 0;
        
        foreach ( $document_all as $doc_all ) {
            
            $title = strtolower($doc_all->Title);
            $ID_Proposal = $doc_all->ID_Doc;
            if ( ($templatetitle == $title) AND ( $ID_Proposal_current != $ID_Proposal) ) {
               $i = 1;
               $Doc = $doc_all->ID_Doc;
               break;
            }
        }

        $template_all = Template::find();

        $j = 0;
       
        foreach ( $template_all as $templ_all ) {
            
            $title = strtolower($templ_all->Title);
            $ID_Proposal = $templ_all->ID_Proposal;

            if ( ($title == $templatetitle ) AND ( $ID_Proposal_current != $ID_Proposal) ) {
               $j = 1;
               $Doc_proposal = $templ_all->ID_Proposal;
               break;
            }
        }
        
        if ( $j == 1 ) {
            
            $message1 = 'The proposal document with the same title is stored with ID: '.$Doc_proposal;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "view",
                    ]
                );
            }
//        die(var_dump($document_all));
        if ( $i == 1 ) {
            
            $message1 = 'The document with the same title is stored with ID: '.$Doc;
             $this->flash->error($message1);
             
                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "view",
                    ]
                );
            } 

            if ($template->save() == false) {
			
                foreach ($template->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "view",
                    ]
                );
            }                

            $form->clear();

            $this->flash->success("Template successfully updated.");

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                    "params"     => [$view]
                ]
            );
    }

  public function deleteAction($ID_Proposal)
    {
         
       if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 
     
        $template = Template::findFirst( " ID_Proposal = '$ID_Proposal' ");
        $template->Checked = 2;
        
        if ($template->save() == false) {            
                foreach ($template->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "template",
                        "params"     => [$view]
                    ]
                );
          }
          
        return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                    "params"     => [$view]
                ]
            );              
    }
    
    
/**    public function deleteConfirmAction()
    { 
        $ID_Proposal = $this->request->getPost("ID_Proposal", "string");
        
        $template = Template::findFirst("ID_Proposal = '$ID_Proposal'");
        if (!$template) {
            $this->flash->error("Template not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "index",
                ]
            );
        }  

        if (!$template->delete()) {
            foreach ($template->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Template deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "template",
                "action"     => "view",
            ]
        );
    }  */
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new TemplateForm;
        $this->view->form = new TemplateForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "template",
                "action"     => "index",
            ]  
        );  
    }
    
     public function templatecultdomainsocimpactAction($ID_Proposal) {
               
        $this->session->set("ID_Proposal", "$ID_Proposal");
        
        if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 
        
        $numberPage = 1;
       
        $template = $this->dispatcher->getParam("template");
               
//        $docinstitution = new Docinstitution();
                   
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");

        $this->view->template  = $template;
//        die(var_dump($keyword));
        
//        $culturaldomain = CulturalDomain::find();

        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $templatecultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>CULTURAL DOMAIN</th></tr></thead><tbody><tr>';        
                          
            foreach ($culturaldomain as $result) {   
                
              $ID_CultDomain = $result->ID_CultDomain;
              $CultDomainName = $result->CultDomainName;
                  
              $templateculturaldomain = Templateculturaldomain::find("(ID_Proposal = '$ID_Proposal' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($templateculturaldomain) > 0) {
                    $templatecultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/template/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural domain <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $templatecultview .= '<td></td><td width="7%"><a href="/template/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural domain </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
          }
        }   

            $templatecultview .=  '</tbody></table>';            
             
        $socialimpact = Socialimpact::find();
        if (count($socialimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $templatesocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>DOCUMENT </th><th></th><th>SOCIAL IMPACT</th></tr></thead><tbody><tr>';        
                           
            foreach ($socialimpact as $result) {   
                
              $ID_SocImpact = $result->ID_SocImpact;
              $SocImpactName = $result->SocImpactName;
           
/**              $this->view->disable();
              echo "Evo".$ID_Proposal." ".$ID_SocImpact;  */
        
              $templatesocialimpact = Templatesocialimpact::find("(ID_Proposal = '$ID_Proposal' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($templatesocialimpact) > 0) {
                    $templatesocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/template/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink social impact <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $templatesocview .= '<td></td><td width="7%"><a href="/template/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link social impact </a></td><td>'.$SocImpactName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $templatesocview .=  '</tbody></table>';        
            $template->Templatecultdomain = $templatecultview;
            $template->Templatesocimpact = $templatesocview;
  
          
        if ($template->save() == false) {
            foreach ($template->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                ]
            );
        }
        
        $templateculturaldomain = Templateculturaldomain::find(" ID_Proposal = '$ID_Proposal'");
        
        $paginator = new Paginator(array(
            "data"  => $templateculturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
        $this->view->setVar('view', $view);
            
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }      
        
        $template = Template::findFirst("ID_Proposal = '$ID_Proposal'");
        
        $this->view->template  = $template;
        
       
        $templateculturaldomain = new Templateculturaldomain();
        
        $templateculturaldomain->ID_Proposal = $ID_Proposal;
        $templateculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($templateculturaldomain->save() == false) {            
            foreach ($templateculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }
               
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
        
        $this->view->template  = $template;
       
        $templateculturaldomain = new Templateculturaldomain();
        
        $templateculturaldomain->ID_Proposal = $ID_Proposal;
        $templateculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($templateculturaldomain->delete() == false) {            
            foreach ($templateculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]         
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Proposalument;  */
        
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
        
        $this->view->template  = $template;
       
        $templatesocialimpact = new Templatesocialimpact();
        
        $templatesocialimpact->ID_Proposal = $ID_Proposal;
        $templatesocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($templatesocialimpact->save() == false) {            
            foreach ($templatesocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }
               
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
        
        $this->view->template  = $template;
       
        $templatesocialimpact = new Templatesocialimpact();
        
        $templatesocialimpact->ID_Proposal = $ID_Proposal;
        $templatesocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($templatesocialimpact->delete() == false) {            
            foreach ($templatesocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]
                    
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "templatecultdomainsocimpact",
                    "params"     => [$ID_Proposal]           
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }   

    public function checkAction($ID_Proposal)
    {
        $numberPage = 1;
     
        if ($this->session->has("view")) {
            $view = $this->session->get("view");
        } 
        
        $this->session->set("ID_Proposal", "$ID_Proposal");        
        
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
       
        $this->view->template  = $template;    

        if (count($template) == 0) {
            $this->flash->notice("Template is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                ]
            );
        }               
        
        $document = Document::findFirst(" ID_Proposal = '$ID_Proposal'");

        if ( !$document )  $document = new Document();

        
        $document->PubYear = $template->PubYear;
        $document->Title = $template->Title;
        $document->ID_Type = $template->ID_Type;
        $document->ID_Language = $template->ID_Language;
        $document->NumPages = $template->NumPages;
        $document->Links = $template->Links;
        $document->Summary = $template->Summary;
        $document->PeriodFrom = $template->PeriodFrom;        
        $document->BiblioRef = $template->BiblioRef;
        $document->Relevance = $template->Relevance;
        $document->FindingOutcomes = $template->FindingOutcomes;
        $document->Keywords = $template->Keywords;
        $document->ID_Proposal = $template->ID_Proposal;
        $document->OpenAccess = $template->OpenAccess;
        $document->Author = $template->Author;
        $document->Institution = $template->Institution;
        $document->Author = $template->Author;
        $document->ID_Category = $template->ID_Category;
//    die(var_dump($document));          

        if ($document->save() == false) {            
            foreach ($document->getMessages() as $message) {
                $this->flash->error($message);
            }

                 return $this->dispatcher->forward(
                [
                   "controller" => "template",
                   "action"     => "view",
                   "params"     => [$ID_Proposal]
                ]
            );
        }    

       
        
        $document = Document::findFirst(" ID_Proposal = '$ID_Proposal'");

        $ID_Doc_upis = $document->ID_Doc;
                            
        $keywords = $document->Keywords;       
        $keyword_list = explode(";",$keywords);

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
                            "controller" => "template",
                            "action"     => "view",
                            "params"     => [$ID_Proposal]
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
                            "controller" => "template",
                            "action"     => "view",
                            "params"     => [$ID_Proposal]
                        ]
                    );
                }                                   
                
            }            
          }   
        }

        $templatesocialimpact = Templatesocialimpact::find( " ID_Proposal = $ID_Proposal");
        
        foreach ( $templatesocialimpact as $socialimpact ) {
            
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
                            "controller" => "template",
                            "action"     => "viev",
                            "params"     => [$ID_Proposal]
                        ]
                    );
                }
        }
    
        $templateculturaldomain = Templateculturaldomain::find( " ID_Proposal = $ID_Proposal" );

        foreach ( $templateculturaldomain as $culturaldomain ) {
            
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
                            "controller" => "template",
                            "action"     => "view",
                            "params"     => [$ID_Proposal]
                        ]
                    );
                }
        }
        
        $template = Template::findFirst(" ID_Proposal = '$ID_Proposal'");
        $template->ID_Doc = $ID_Doc_upis;
        $template->Checked = 1;
   
        if ($template->save() == false) {            
            foreach ($template->getMessages() as $message) {
                $this->flash->error($message);
            }

                 return $this->dispatcher->forward(
                [
                   "controller" => "template",
                   "action"     => "view",
                   "params"     => [$view]
                ]
            );
        }            
                   
              
        return $this->dispatcher->forward(
                [ 
                    "controller" => "template",
                    "action"     => "view",
                    "params"     => [$view]           
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

        public function definekeywordAction($ID_ProposalKeyword)
    {
        $numberPage = 1;
       
        if ($this->session->has("ID_Proposal")) {
            // Retrieve its value
            $ID_Proposal = $this->session->get("ID_Proposal");
        }  
        $this->session->set("ID_ProposalKeyword", "$ID_ProposalKeyword");
        
 //       echo $ID_Proposal,' '.$ID_ProposalKeyword.' ';
        
        $templatekeyword = Templatekeyword::find("(ID_Proposal = '$ID_Proposal' AND ID_ProposalKeyword ='$ID_ProposalKeyword')");
 
        $this->view->templatekeyword = $templatekeyword;
        
//          $keyword = $templatekeyword->Keyword;
//        die(var_dump($templatekeyword));
/**        foreach ($templatekeyword as $result) {             
              $keyword = $result->Keyword;
            }  */   
                    
//        echo $keyword;
          
        if (count($templatekeyword) == 0) {
            $this->flash->notice("Template is not found.");
            return $this->dispatcher->forward(
                [
                    "controller" => "template",
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
            "data"  => $templatekeyword,
            "limit" => 10,
            "page"  => $numberPage
        ]);  

        $this->view->page = $paginator->getPaginate(); 
        $this->view->form = new KeywordForm;
    }
 
    public function deletedocumentAction($ID_Proposal) {
 
        $template = Template::findFirst( " ID_Proposal = '$ID_Proposal' ");
        $template->Checked = 2;
        
        if ($template->save() == false) {            
                foreach ($template->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        "controller" => "template",
                        "action"     => "edit",
//                        "params"     => [$ID_Doc]
                    ]
                );
          }
          
        return $this->dispatcher->forward(
                [
                    "controller" => "template",
                    "action"     => "view",
                ]
            );
        
    }
}
