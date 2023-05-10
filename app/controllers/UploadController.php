<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use App\Core\Forms\MediaForm;

class UploadController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Upload');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new UploadForm;
    }

    /**
     * Search vlafon based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Upload", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $upload = Upload::find($parameters);
        
        if (count($upload) == 0) {
            $this->flash->notice("Upload is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $upload,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->upload = $upload;
    }
    
    public function viewAction()
    {
        $numberPage = 1;
        
        $upload = Upload::find(
                [    
                 'order'      => 'ID_Upload',   
                ]
                );
        if (count($upload) == 0) {
            $this->flash->notice("Upload is not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "new",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $upload,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->upload = $upload;
        $this->view->form = new UploadForm;
    }
    
    public function addAction() {
            $this->view->form = new MediaForm();
        }
    
/**    public function uploadAction() {
        if (true == $this->request->hasFiles() &&
            $this->request->isPost()) {
            $upload_dir = __DIR__ . '/../../../public/uploads/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755);
              }
            
            foreach ($this->request->getUploadedFiles() as $file) {
                $file->moveTo($upload_dir . $file->getName());
                $this->flashSession->success($file->getName().' has been
                successfully uploaded.');
              }
            $this->response->redirect('media/add');
          }
        }   */
        
    /**
     * Shows the form to create a new upload
     */
    public function newAction()
    {
       $this->view->form = new UploadForm(null, ['edit' => true]);
    }

    /**
     * Edits a vlafon based on its id
     */
    public function editAction($ID_Upload)
    {

        if (!$this->request->isPost()) {

            $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
            if (!$upload) {
                $this->flash->error("Upload not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "upload",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new UploadForm($upload, ['edit' => true]);
        }
    }
    
    public function editActiondoc($ID_Upload)
    {

        if (!$this->request->isPost()) {

            $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
            if (!$upload) {
                $this->flash->error("Upload not found.");
                return $this->dispatcher->forward(
                    [
                        "controller" => "upload",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new UploadForm($upload, ['edit' => true]);
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
                    "controller" => "upload",
                    "action"     => "new",
                ]
            );
        }

        $form = new UploadForm;
        $upload = new Upload();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $upload)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "new",
                ]
            );
        }

        if ($upload->save() == false) {
            foreach ($upload->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();
        
        $this->flash->success("Upload successfully created.");

        return $this->dispatcher->forward(
            [
                "controller" => "upload",
                "action"     => "view",
            ]
        );
    }
    
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }

        $ID_Upload = $this->request->getPost("ID_Upload", "string");

        $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
        if (!$upload) {
            $this->flash->error("Upload does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }

        $form = new UploadForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $upload)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "new",
                ]
            );
        }

        if ($upload->save() == false) {
			
            foreach ($upload->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Upload successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "upload",
                "action"     => "view",
            ]
        );
    }

    public function saveActiondoc()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }

        $ID_Upload = $this->request->getPost("ID_Upload", "string");

        $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
        if (!$upload) {
            $this->flash->error("Upload does not exist.");

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }

        $form = new UploadForm;

        $data = $this->request->getPost();
		
        if (!$form->isValid($data, $upload)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "new",
                ]
            );
        }

        if ($upload->save() == false) {
			
            foreach ($upload->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "view",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Upload successfully updated.");
   
        return $this->dispatcher->forward(
            [
                "controller" => "upload",
                "action"     => "upload",
            ]
        );
    }
    
    public function deleteAction($ID_Upload)
    {
         
       $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
        
       $this->view->form = new UploadForm($upload, ['edit' => true]);
       
    }
    
    public function deleteConfirmAction()
    {
      
        $upload_dir = __DIR__ . '/../../public/uploads/';
        $ID_Upload = $this->request->getPost("ID_Upload", "string");
                
        $upload = Upload::findFirst("ID_Upload = '$ID_Upload'");
        if (!$upload) {
            $this->flash->error("Upload not found.");

            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }  

        $ID_Doc = $upload->ID_Doc;
        $FileName = $upload->FileName; 
        $docupload = Docupload::findFirst(" ID_Upload = '$ID_Upload' AND ID_Doc = '$ID_Doc'");
        
        if (count($docupload) == 0) {
            $this->flash->notice("Upload not found.");
        } else {
            if (!$docupload->delete()) {
                foreach ($docupload->getMessages() as $message) {
                    $this->flash->error($message);
                }
    
                return $this->dispatcher->forward(
                    [
                        "controller" => "upload",
                        "action"     => "index",
                    ]
                );
            }
        }
        
        $ID_Upload = $this->request->getPost("ID_Upload", "string");
         
        if (!$upload->delete()) {
            foreach ($upload->getMessages() as $message) {
                $this->flash->error($message);
            }
    
            return $this->dispatcher->forward(
                [
                    "controller" => "upload",
                    "action"     => "index",
                ]
            );
        }
        
        unlink($upload_dir. $FileName);
        
        $this->flash->success("Upload deleted");

                
        return $this->dispatcher->forward(
            [
                "controller" => "upload",
                "action"     => "view",
            ]
        );
    }
    
     public function deleteCancelAction()
    {
/**     $this->session->conditions = null;
        $this->view->form = new UploadForm;
        $this->view->form = new UploadForm(null, ['edit' => true]); */
   
      
        return $this->dispatcher->forward(
            [
                "controller" => "upload",
                "action"     => "index",
            ]  
        );  
    }

    public function uploadAction()
    {   
     echo 'Hey <BR>';
        
        if ($this->session->has("ID_Doc")) {
            // Retrieve its value
            $ID_Doc = $this->session->get("ID_Doc");
        }
        
        echo $ID_Doc.'<BR>';
        
        $upload_dir_temp = __DIR__ . '/../../public/upload_temp/';
        $upload_dir = __DIR__ . '/../../public/uploads/';
	echo $upload_dir_temp.'<BR>';
        echo $upload_dir;
        
        if (true == $this->request->hasFiles() && $this->request->isPost()) 
          {        
            
            foreach ($this->request->getUploadedFiles() as $file) {
                $file->moveTo($upload_dir_temp . $file->getName());                          

                $data = $this->request->getPost();

                $allowed = array('docx', 'doc', 'pdf', 'rtf');
                $ext = pathinfo($upload_dir . $file->getName(), PATHINFO_EXTENSION);                
                echo $ext.'<BR>';

                if (!in_array($ext, $allowed)) {
                     $this->flashSession->success('File type not supported. Allowed file types: pdf, doc, docx, txt.');
                } else {
                    $FileName = $file->getName();
                    $FileType = $ext;
                    $FileSize = $file->getSize();
                    $FileSizeKB = $FileSize/1024;
                    $UserFileName = $data['UserFileName'];
                    $Download = $data['Download'];
                    $auth = $this->session->get('auth');
                    $ID_User = $auth['id'];
                                        
                    echo $FileName.' - '.$FileType.' - '.$FileSize.' '.$UserFileName.' '.$Download.'<BR>';
                    
                    $upload = new Upload();
                    
                    $upload->FileName = $FileName;
                    $upload->UserFileName = $UserFileName;
                    $upload->FileType = $FileType;
                    $upload->FileSize = $FileSize;
                    $upload->FileSizeKB = $FileSizeKB;
                    $upload->Download = $Download;
                    $upload->ID_User = $ID_User;                               
                    $upload->ID_Doc = $ID_Doc;
                    $upload->link ='<a target = "_blank" href="/../uploads/'.$FileName.'" class="btn btn-default"><i class="glyphicon glyphicon-download"></i> Download</a>';
//                 die(var_dump($upload)); 
                
                    $a = scandir($upload_dir);
//                    die(var_dump($a));
                      
                      $break = 0;
                      
                      foreach( $a as $file ) {
          
                        $file_name = $file;
                        
                        if ($break == 0) {
                          if ( ($file_name != '.')) {
                            if ( ($file_name != '..')) {
                              echo $file_name.'<BR>';    
                            
                              $upload_check = Upload::find("FileName = '$file_name'");    
                              foreach ($upload_check as $upload_test){
                                $FileName_check = $upload_test->FileName;
                                $FileType_check = $upload_test->FileType;
                                $FileSize_check = $upload_test->FileSize;
                                $UserFileName_check = $upload_test->UserFileName;
                                
                               $name = 0; $size = 0; $type = 0; $username = 0;
                               if ($FileName == $FileName_check) $name = 1;
                               if ($FileSize == $FileSize_check) $size = 1;
                               if ($FileType == $FileType_check) $type = 1;
                               if ($UserFileName == $UserFileName_check) $username = 1;

                              echo $FileName_check.' - '.$FileType_check.' - '.$FileSize_check.' - '.$UserFileName_check.'<BR>';                      
                              echo $name.' - '.$type.' - '.$size.' - '.$username.'<BR>';                      
                              }
                              
                              if ( $name == 1 AND $type == 1) {
                                $break = 1;
                                $this->flashSession->success($FileName.' already exists in repository.');    
                              }
                  
//                              die(var_dump($upload_check)); 
                            }  
                          }                                           
                        }  
                    }                                                       
                    
                    $succes_save = 0; $succes_copy = 0;  
                    
                    if ($break == 0) {
                             
                        if ($upload->save() == false) {
                            foreach ($upload->getMessages() as $message) {
                                $this->flash->error($message);
                                $succes_save = 1;
                            }
                            
                            return $this->dispatcher->forward(
                            [
                                "controller" => "upload",
                                "action"     => "view",
                              ]
                            );
                        }
                
                        $upload = Upload::findFirst("FileName = '$FileName'");
                        $ID_Upload = $upload->ID_Upload;
                        echo $ID_Upload.'<BR>';
                        $docupload = new Docupload(); 
        
                        $docupload->ID_Doc = $ID_Doc;
                        $docupload->ID_Upload = $ID_Upload;

                        if ($docupload->save() == false) {
                            foreach ($docupload->getMessages() as $message) {
                                $this->flash->error($message);
                                $succes_save = 1;
                            }
                    
                         return $this->dispatcher->forward(
                                [
                                    "controller" => "upload",
                                    "action"     => "view",
                                ]   
                            );
                        }
                        
                        if (!copy($upload_dir_temp.$FileName,$upload_dir.$FileName)) {
                            echo "failed to copy?". $FileName;
                               $succes_copy = 1;
                        }      
                        
                    }   
                                       
                unlink($upload_dir_temp . $FileName);
                
                if ( $succes_copy == 1) {
                    $this->flashSession->success($FileName.' has been successfully uploaded.');
                }
            }       
          }  
          }
          
        $numberPage = 1;
        
        $document = Document::findFirst("ID_Doc = '$ID_Doc'");
        
        $this->view->document  = $document;
                        
        $upload = Upload::find("ID_Doc = '$ID_Doc'");
        if (count($upload) == 0) {
            $this->flash->notice("Upload not found.");
        }    
     
        $paginator = new Paginator(array(
            "data"  => $upload,
            "limit" => 10,
            "page"  => $numberPage
        ));  
        
        $this->view->page = $paginator->getPaginate();   
        
        $this->view->form = new UploadForm(null, ['edit' => true]);
        $numberPage = 1;        
       
    }
  
    public function downloadAction($ID_Upload)
    { 
        $upload = Upload::findFirst( "ID_Upload = '$ID_Upload'");

        $file_name = $upload->FileName;
        echo $file_name.'<BR>'; 
        $upload_dir = __DIR__ . '/../../public/uploads/';
        $path = $upload_dir.$file_name;
        echo $path.'<BR>'; 
//        die(var_dump($upload));
        
        if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
/**        $filetype = filetype($path);
        $filesize = filesize($path);
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Download');
        header('Content-type: '.$filetype);
        header('Content-length: ' . $filesize);
        header('Content-Disposition: attachment; filename="'.$file.'"');
        readfile($path);
        die(); */
        }
     }    
   
}
