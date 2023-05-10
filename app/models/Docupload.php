<?php

use Phalcon\Mvc\Model;
/**
 * Sector
 */
class Docupload extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var string
	 */
	public $ID_Upload;
        
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
            	$this->belongsTo('ID_Upload', 'Upload', 'ID_Upload', [
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