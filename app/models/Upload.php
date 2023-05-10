<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Upload extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Upload;

	/**
	 * @var string
	 */
	public $FileName;
        
        /**
	 * @var string
	 */
	public $UserFileName;
        
        /**
	 * @var string
	 */
	public $UserFileNameKB;
        
        /**
	 * @var string
	 */
	public $FileSize;
        	
        /**
	 * @var string
	 */
	public $FileType;
        
        /**
	 * @var string
	 */
	public $Download;
                
        /**
	 * @var string
	 */
	public $ID_User;
        
        /**
	 * @var string
	 */
	public $ID_Doc;
        
        /**
	 * @var string
	 */
	public $link;
		
	/** Products initializer
	 */
	public function initialize()
	{
/**             $this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);  */
            
               $this->hasMany('ID_Upload', 'Docupload', 'ID_Upload', [
        	'foreignKey' => [
        		'message' => 'Document cannot be deleted because it\'s has one or more linked document'
        	 ]
                ]);  
             
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
}