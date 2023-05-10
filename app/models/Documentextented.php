<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Documentextented extends Model
{
	/**
	 * @var integer
	 */
	public $ID;
        
        /**
	 * @var integer
	 */
	public $ID_Doc;
        
        /**
	 * @var text
	 */
	public $keywordtv;

        /**
	 * @var integer
	 */
	public $transitionvar;        
            
        /**
	 * Svojstva initializer
	 */
	public function initialize()
	{
    
                $this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);
                                                  	
        }
	/**
	 * Djela initializer
	 /
	public function initialize2()
	{
		$this->belongsTo('sifradjela', 'Product_types', 'id', [
			'reusable' => true
		]);
	}  */
	
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
