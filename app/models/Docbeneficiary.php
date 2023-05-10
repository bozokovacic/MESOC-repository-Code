<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Docbeneficiary extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_Beneficiary;
        
        /**
	 * @var string
	 */
	/** Products initializer
	 */
	public function initialize()
	{
           {
            	$this->belongsTo('ID_Beneficiary', 'Beneficiary', 'ID_Beneficiary', [
			'reusable' => true
		]);
            }
            {
           {
            	$this->belongsTo('ID_Doc', 'Document', 'ID_Doc', [
			'reusable' => true
		]);
            }  
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
}