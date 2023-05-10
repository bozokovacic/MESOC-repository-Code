<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Docauthor extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_Author;
        
        /**
	 * @var string
	 */
	public $ID_Institution;
        
        /**
         * @var string
	 */
	public $ID_Country;

		
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
            	$this->belongsTo('ID_Author', 'Author', 'ID_Author', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Institution', 'Institution', 'ID_Institution', [
			'reusable' => true
		]);
            }
            {
            	$this->belongsTo('ID_Country', 'Country', 'ID_Country', [
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