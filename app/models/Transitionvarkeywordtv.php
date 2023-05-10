<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Transitionvarkeywordtv extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;
        
        /**
	 * @var integer
	 */
	public $ID_Transvar;

	/**
	 * @var string
	 */
	public $ID_Keywordtv;
        
        /** Products initializer
	 */
	public function initialize()
	{
            {
            	$this->belongsTo('ID_Transvar', 'Transitionvar', 'ID_Transvar', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Keywordtv', 'Keywordtv', 'ID_Keywordtv', [
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