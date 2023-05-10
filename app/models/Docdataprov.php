<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Docdataprov extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_DataProv;
        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_DataProv', 'Dataprov', 'ID_DataProv', [
			'reusable' => true
		]);
            }
        }

	/**
	 * Returns a human representation of 'active'
	 *
	 * @return string
	 */
	public function getActiveDetail()
	{
		if ($this->active == 'Y') {
			return 'Yes';
		}
		return 'No';
	}
        
//    SECTOR
        
        public function linkssectorAction($ID_Doc){
        
        $numberPage = 1;
        
        // Set a session variable
        $this->session->set("ID_Doc", "$ID_Doc");
               
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsector = Docsector::find("ID_Doc = '$ID_Doc'");
        if (count($docsector) == 0) {
            $this->flash->notice("Sector not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsector,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new SectorForm;
        
    }
    
       public function sectorviewAction(){
        
        $numberPage = 1;
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
    
        $this->view->document  = $document;
        
        $docsector = Docsector::find("ID_Doc = '$ID_Doc'");
        if (count($docsector) == 0) {
            $this->flash->notice("Sector not found.");
        }
             
        $paginator = new Paginator(array(
            "data"  => $docsector,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate(); 
        
        $this->view->form = new TechniqueForm;
        
    }
    
   public function sectorsearchAction($ID_Doc){
        
        $numberPage = 1;
                
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
  
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
        
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Sector", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $sector = Sector::find($parameters);
        if (count($sector) == 0) {
            $this->flash->notice("Sector is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $sector,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->sector = $sector;
    }

    public function sectoraddAction($ID_Sector){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsector = new Docsector();
           
        $docsector->ID_Doc = $ID_Doc;
        $docsector->ID_Sector = $ID_Sector;
        
     
        $docsector->ID_Sector = $ID_Sector;
        
        if ($docsector->save() == false) {            
            foreach ($docsector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }
                        
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );      
    }
    
      public function sectordeleteAction($ID_Sector){
        
        $numberPage = 1;
 
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        $docsector = new Docsector();
        
        $docsector->ID_Doc = $ID_Doc;
        $docsector->ID_Sector = $ID_Sector;
        
        if (!$docsector->delete()) {
            foreach ($docsector->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            );
        }
           
        return $this->dispatcher->forward(
                [ 
                    "controller" => "documentlink",
                    "action"     => "sectorview",
                ]
            ); 
    }

}