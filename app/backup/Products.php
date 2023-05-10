<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Products extends Model
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var integer
	 */
	public $sifrasvojstva;

	/**
	 * @var integer
	 */
	public $sifrasuradnik;

	/**
	 * @var integer
	 */
	public $sifradjela;
	/**
	 * @var string
	 */
	public $price;

	/**
	 * @var string
	 */
	public $active;

	/**
	 * Svojstva initializer
	 */
	public function initialize()
	{
		$this->belongsTo('sifrasvojstva', 'Svojstva', 'id', [
			'reusable' => true
		]);
		$this->belongsTo('sifradjela', 'Product_types', 'id', [
			'reusable' => true
		]);
  	}
	
	/**
	 * Suradnika initializer
	 */
	public function initialize1()
	{
		$this->belongsTo('sifrasuradnik', 'Companies', 'id', [
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
