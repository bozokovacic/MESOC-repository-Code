<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Doctransitionvar extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_Transvar;
        
        /**
	 * @var string
	 */
	public $Strength;
        
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
            	$this->belongsTo('ID_Transvar', 'Transitionvar', 'ID_Transvar', [
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
}