<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class KeywordController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Keyword');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new KeywordForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Keyword", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $keyword = Keyword::find($parameters);
        if (count($keyword) == 0) {
            $this->flash->notice("Keyword is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $keyword,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->keyword = $keyword;
    }

      public function viewAction()
    {
        $numberPage = 1;
        
/**        $numberPage = $this->request->getQuery("page", "int");
        $parameters = [];
        
        $keyword = Keyword::find($parameters); */
        
        $keyword = Keyword::find(
                [    
                 'order'      => 'ID_Keyword',   
                ]
                );  
        
        if (count($keyword) == 0) {
            $this->flash->notice("Keyword is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $keyword,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->keyword = $keyword;
    }
    
     public function pregledcultdomainAction($ID_Keyword){
                
        $this->session->set("ID_Keyword", "$ID_Keyword");
        
        $numberPage = 1;
       
        $keyword = $this->dispatcher->getParam("keyword");
            
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
//        die(var_dump($keyword));
        
//        $culturaldomain = CulturalDomain::find();
        
        $culturaldomain = Culturaldomain::find();
        if (count($culturaldomain) == 0) {
             $this->flash->error("Cultural domain not found.");
           } else {
            
                $keywordcultview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>KEYWORDS </th><th></th><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';        
                $cultview = ' <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CULTURAL SECTOR</th></tr></thead><tbody><tr>';
           
            foreach ($culturaldomain as $result) {   
                
            $ID_CultDomain = $result->ID_CultDomain;
            $CultDomainName = $result->CultDomainName;
/**        $this->view->disable();
           echo "Evo".$ID_Keyword." ".$ID_CultDomain;  */
        
            $keywordculturaldomain = Keywordculturaldomain::find("(ID_Keyword = '$ID_Keyword' AND ID_CultDomain ='$ID_CultDomain')");                         
                if (count($keywordculturaldomain) > 0) {
                    $keywordcultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/delcultdomain/'.$ID_CultDomain.'" class="btn btn-default"> Unlink cultural sector <i class="glyphicon glyphicon-hand-right"></i></a></td><td></td></tr>';                    
                } else {
                    $keywordcultview .= '<td></td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cultural sector </a></td><td>'.$CultDomainName.'</td></tr>';
//                    $cultview .= '<td>'.$CultDomainName.'</td><td width="7%"><a href="/keyword/addcultdomain/'.$ID_CultDomain.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add cultural domain</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $keywordcultview .=  '</tbody></table>';
            $cultview .=  '</tbody></table>';
            
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
            
            $keyword->Keywordcultdomainview = $keywordcultview;
            $keyword->Cultdomainview = $cultview;
          
        if ($keyword->save() == false) {
            foreach ($keyword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }
        
        $keywordculturaldomain = Keywordculturaldomain::find(" ID_Keyword = '$ID_Keyword'");
        
        $paginator = new Paginator(array(
            "data"  => $culturaldomain,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }
    
     public function pregledsocimpactAction($ID_Keyword){
        
        $this->session->set("ID_Keyword", "$ID_Keyword");
        
        $numberPage = 1;
       
        $keyword = $this->dispatcher->getParam("keyword");
            
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
//        die(var_dump($keyword));
        
//        $culturaldomain = CulturalDomain::find();
        
        $socimpact = Socialimpact::find();
        if (count($socimpact) == 0) {
             $this->flash->error("Social impact not found.");
           } else {
            
                $keywordsocview = '<BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>KEYWORDS</th><th></th><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';        
                $socview = ' <BR> <table class="table table-bordered table-striped" align="center">'
                    .'<thead><tr><th>CROSS-OVER THEME</th></tr></thead><tbody><tr>';
           
            foreach ($socimpact as $result) {   
                
            $ID_SocImpact = $result->ID_SocImpact;
            $SocImpactName = $result->SocImpactName;
/**        $this->view->disable();
           echo "Evo".$ID_Keyword." ".$ID_CultDomain;  */
        
            $keywordsocimpact = Keywordsocialimpact::find("(ID_Keyword = '$ID_Keyword' AND ID_SocImpact ='$ID_SocImpact')");                         
                if (count($keywordsocimpact) > 0) {
                    $keywordsocview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/keyword/delsocimpact/'.$ID_SocImpact.'" class="btn btn-default"> Unlink cross-over theme <i class="glyphicon glyphicon-hand-right"></i></a><td></td></td></tr>';
                } else {
                    $keywordsocview .= '<td></td><td width="7%"><a href="/keyword/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-hand-left"></i>  Link cross-over theme </a><td>'.$SocImpactName.'</td></td></tr>';
//                    $socview .= '<td>'.$SocImpactName.'</td><td width="7%"><a href="/keyword/addsocimpact/'.$ID_SocImpact.'" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i> Add social impact</a></td></tr>';
                }   
//            echo $keywordcultview.'<BR>';    
//            echo $cultview.'<BR>';
          }
        }   

            $keywordsocview .=  '</tbody></table>';
            $socview .=  '</tbody></table>';
            
//            echo $keywordsocview.'<BR>';    
//            echo $socview.'<BR>';
            
            $keyword->Keywordsocimpactview = $keywordsocview;
            $keyword->SocImpactview = $socview;
          
        if ($keyword->save() == false) {
            foreach ($keyword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }
        
        $keywordsocialimpact = Keywordsocialimpact::find(" ID_Keyword = '$ID_Keyword'");
        
        $paginator = new Paginator(array(
            "data"  => $keywordsocialimpact,
            "limit" => 10,
            "page"  => $numberPage
        ));
        
        $this->view->page = $paginator->getPaginate();
            
    }

    /**
     * Shows the form to create a new keyword
     */
    public function newAction()
    {
       $this->view->form = new KeywordForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Keyword)
    {

        if (!$this->request->isPost()) {

            $keyword = Keyword::findFirst("ID_Keyword = '$ID_Keyword'");
            if (!$keyword) {
                $this->flash->error("Keyword not found.");

                return $this->dispatcher->forward(
                    [
                        "controller" => "keyword",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new KeywordForm($keyword, ['edit' => true]);
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
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $form = new KeywordForm;
        $keyword = new Keyword();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $keyword)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }

        if ($keyword->save() == false) {
            foreach ($keyword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Keyword successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "keyword",
                "action"     => "view",
            ]
        );
    }

    /**
     * Saves current SECTOR in screen
     *
     * @param string $ID_Keyword
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $ID_Keyword = $this->request->getPost("ID_Keyword", "string");

        $keyword = Keyword::findFirst("ID_Keyword = '$ID_Keyword'");
        if (!$keyword) {
            $this->flash->error("Keyword does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $form = new KeywordForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $keyword)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }

        if ($keyword->save() == false) {
			
            foreach ($keyword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Keyword successfully updated.");

        return $this->dispatcher->forward(
            [
                "controller" => "keyword",
                "action"     => "view",
            ]
        );
    }

  public function deleteAction($ID_Keyword)
    {
         
       $keyword = Keyword::findFirst("ID_Keyword = '$ID_Keyword'");
        
       $this->view->form = new KeywordForm($keyword, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }

/**        $this->view->disable();
        echo "Evo".$KeywordName." ".$ID_Keyword;   */
        
        $ID_Keyword = $this->request->getPost("ID_Keyword", "string");
       
        $keyword = Keyword::findFirst("ID_Keyword = '$ID_Keyword'");
        if (!$keyword) {
            $this->flash->error("Keyword not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }  

        if (!$keyword->delete()) {
            foreach ($keyword->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "index",
                ]
            );
        }

        $this->flash->success("Keyword deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "keyword",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new KeywordForm;
        $this->view->form = new KeywordForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "keyword",
                "action"     => "index",
            ]  
        );  
    }

      public function addcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keyword")) {
            // Retrieve its value
            $ID_Keyword = $this->session->get("ID_Keyword");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Keyword;  */
        
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
       
        $keywordculturaldomain = new Keywordculturaldomain();
        
        $keywordculturaldomain->ID_Keyword = $ID_Keyword;
        $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($keywordculturaldomain->save() == false) {            
            foreach ($keywordculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keyword]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keyword",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keyword]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delcultdomainAction($ID_CultDomain){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keyword")) {
            // Retrieve its value
            $ID_Keyword = $this->session->get("ID_Keyword");
        }
               
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
       
        $keywordculturaldomain = new Keywordculturaldomain();
        
        $keywordculturaldomain->ID_Keyword = $ID_Keyword;
        $keywordculturaldomain->ID_CultDomain = $ID_CultDomain;
                              
        if ($keywordculturaldomain->delete() == false) {            
            foreach ($keywordculturaldomain->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keyword]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keyword",
                    "action"     => "pregledcultdomain",
                    "params"     => [$ID_Keyword]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }

      public function addsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keyword")) {
            // Retrieve its value
            $ID_Keyword = $this->session->get("ID_Keyword");
        }
        
/**        $this->view->disable();  
        echo "Evo - ".$ID_Keyword;  */
        
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
       
        $keywordsocialimpact = new Keywordsocialimpact();
        
        $keywordsocialimpact->ID_Keyword = $ID_Keyword;
        $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($keywordsocialimpact->save() == false) {            
            foreach ($keywordsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keyword]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keyword",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keyword]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }
  
    public function delsocimpactAction($ID_SocImpact){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Keyword")) {
            // Retrieve its value
            $ID_Keyword = $this->session->get("ID_Keyword");
        }
               
        $keyword = Keyword::findFirst(" ID_Keyword = '$ID_Keyword'");
        
        $this->view->keyword  = $keyword;
       
        $keywordsocialimpact = new Keywordsocialimpact();
        
        $keywordsocialimpact->ID_Keyword = $ID_Keyword;
        $keywordsocialimpact->ID_SocImpact = $ID_SocImpact;
                              
        if ($keywordsocialimpact->delete() == false) {            
            foreach ($keywordsocialimpact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keyword]
                ]
            );
          }
          
        return $this->dispatcher->forward(
                [ 
                    "controller" => "keyword",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keyword]
                ]
            );
        
        $this->view->page = $paginator->getPaginate(); 
    }    
 
      public function linkkeywordAction($ID_Keyword){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Template")) {
            // Retrieve its value
            $ID_Template = $this->session->get("ID_Template");
            $ID_TemplateKeyword = $this->session->get("ID_TemplateKeyword");
        }
        
//        echo $ID_Template.' '.$ID_TemplateKeyword.' '.$ID_Keyword.'<BR>';
        
        $templatekeyword = Templatekeyword::find("(ID_Template = '$ID_Template' AND ID_TemplateKeyword ='$ID_TemplateKeyword')");
      
        $this->view->templatekeyword  = $templatekeyword;
        
        $templatekeyword->ID_TemplateKeyword = $ID_Keyword;

        $query = "UPDATE templatekeyword SET ID_Keyword = '$ID_Keyword' WHERE ID_Template = '$ID_Template' AND ID_TemplateKeyword ='$ID_TemplateKeyword'";        
        $resultGeneral = $this->db->query($query);      

/**        if ($templatekeyword->save() == false) {            
            foreach ($templatekeyword->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "keyword",
                    "action"     => "pregledsocimpact",
                    "params"     => [$ID_Keyword]
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

    public function preparecityAction(){
        
        $numberPage = 1;
        
//        $document = Document::find();        
//        $export = '';
//        $path = $upload_dir . $file->getName();
        $path = "Location-Country-Coordinate_all.txt";
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

}
