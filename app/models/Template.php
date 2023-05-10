<?php

use Phalcon\Mvc\Model;

/**
 * Products
 */
class Template extends Model
{
	/**
	 * @var integer
	 */
	public $ID_Proposal;
        
        /**
	 * @var integer
	 */
	public $ID_User;
        
        /**
	 * @var integer
	 */
	public $ID_Role;

        /**
	 * @var integer
	 */
	public $ID_Partner;

	/**
	 * @var string
	 */
	public $PubYear;
	
	/**
	 * @var string
	 */
	public $Title;
        
        /**
	 * @var string
	 */
	public $BiblioRef; 
        
	/**
	 * @var integer
	 */
	public $Links;

	/**
	 * @var integer
	 */
	public $CountryPub;

	/**
	 * @var integer
	 */
	public $Summary;
	
	/**
	 * @var string
	 */
	public $Keywords;

	/**
	 * @var integer
	 */
	public $OpenAccess;

	/**
	 * @var integer
	 */
	public $ID_Language;

        /**
	 * @var integer
	 */
	public $transitionvar;        

	/**
	 * @var integer
	 */
	public $ID_Doc;

	/**
	 * @var integer
	 */
	public $Created_at;

	/**
	 * @var integer
	 */
	public $Checked;

        /**
	 * @var text
	 */
	public $Templateview;

        /**
	 * @var text
	 */
	public $Templatecultdomain;

        /**
	 * @var text
	 */
	public $Templatesocimpact;

        /**
	 * @var string
	 */
	public $PeriodFrom;

	/**
	 * @var integer
	 */
	public $FindingOutcomes;

	/**
	 * @var integer
	 */
	public $NumPages;
		
	/**
	 * @var integer
	 */
	public $Relevance;

        /**
	 * @var string
	 */
	public $ID_Type;

        /**
	 * @var integer
	 */
	public $ID_Category;    

        /**
	 * @var text
	 */
	public $keywordtv;

        /**
	 * @var integer
	 */
	public $Author;        
        
        /**
	 * @var integer
	 */
	public $Institution;        


	/**
	 * Svojstva initializer
	 */
	public function initialize()
	{
		$this->belongsTo('ID_Language', 'Language', 'ID_Language', [
			'reusable' => true
		]);
		$this->belongsTo('ID_User', 'Users', 'id', [
			'reusable' => true
		]);
		$this->belongsTo('ID_Partner', 'Partner', 'ID_Partner', [
			'reusable' => true
		]);
                $this->belongsTo('ID_Type', 'Type', 'ID_Type', [
			'reusable' => true
		]);
                $this->belongsTo('ID_Category', 'Category', 'ID_Category', [
			'reusable' => true
		]);
                
                
/**      		$this->belongsTo('ID_CultDomain', 'Culturaldomain', 'ID_CultDomain', [
			'reusable' => true
		]);
                
                $this->belongsTo('ID_SocImpact', 'Socialimpact', 'ID_SocImpact', [
			'reusable' => true
		]);    */
 /**               $this->hasMany('ID_Doc', 'Doc_Beneficiary', 'ID_Doc', [
        	'foreignKey' => [
        		'message' => 'Product Type cannot be deleted because it\'s used in Products'
        	 ]
                ]);  */
	
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
