<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl()
	{
		if (!isset($this->persistent->acl)) {

			$acl = new AclList();

			$acl->setDefaultAction(Acl::DENY);

			// Register roles
			$roles = [
                                'administrator' => new Role(
					'Administrator',
					'Administering users, documents and document metadata.'
				),	
                                'users'  => new Role(
					'Users',
					'Member privileges, granted after sign in.'
				),
                                'templateuser' => new Role(
					'Templateuser',
					'Anyone browsing the site who can fillup template form.'
				),
				'guests' => new Role(
					'Guests',
					'Anyone browsing the site who is not signed in is considered to be a "Guest".'
				)
			];

			foreach ($roles as $role) {
				$acl->addRole($role);
			}

			//Private area resources Administrator
			$privateResources = [
                            /** 'djelovodstvo' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
				'suradnici' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
				'djela' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'pregled', 'deleteConfirm', 'deleteCancel', 'view'], */
                                'document' => ['index', 'search', 'view', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel','pregled','linksauthor', 'createdocumenttemplate', 'read', 'readfile', 'newread', 'export', 'upload', 'prepare', 'unos', 'dockey', 'preparecity', 'documentcity', 'documentrename', 'documentrenamenew', 'docprepare', 'docexport', 'exportcelldoc', 'celldocdatabase', 'documenttransvar', 'new2'],
//                                'documentlink' => ['index', 'search', 'linksauthor', 'authoradd', 'authorselectInst', 'authoraddInst', 'authordelInst', 'authorselectCountry', 'authoraddCountry', 'authordelCounty', 'authorview', 'authorsearch', 'authordelete', 'linkscountry', 'linksrelevance', 'techniquesearch', 'techniqueadd', 'techniqueview', 'techniquedelete', 'relevancesearch', 'relevanceadd', 'relevanceview', 'relevancedelete', 'linkssearchdatabase', 'searchdatabasesearch', 'searchdatabaseadd', 'searchdatabaseview', 'searchdatabasedelete', 'linkstechnique', 'techniqueadd', 'techniqueview', 'techniquedelete', 'linksbeneficiary', 'beneficiarysearch', 'beneficiaryadd', 'beneficiaryview', 'beneficiarydelete'], 
                                'documentlink' => ['index', 'search', 'linksauthor', 'authoradd', 'authorselectInst', 'authoraddInst', 'authordelInst', 'authorselectCountry', 'authoraddCountry', 'authordelCounty', 'authorview', 'authorsearch', 'authordelete', 'linkscountry', 'techniquesearch', 'techniqueadd', 'techniqueview', 'techniquedelete', 'linkssearchdatabase', 'searchdatabasesearch', 'searchdatabaseadd', 'searchdatabaseview', 'searchdatabasedelete', 'linkstechnique', 'techniqueadd', 'techniqueview', 'techniquedelete',   'linkslitarea', 'litareasearch', 'litareaadd', 'litareaview', 'litareadelete', 'linksdataprov', 'dataprovsearch', 'dataprovadd', 'dataprovview', 'dataprovdelete', 'linkssector', 'sectorsearch', 'sectoradd', 'sectorview', 'sectordelete', 'linksinstitution', 'institutionsearch', 'institutionadd', 'institutionview', 'institutiondelete','linkscultdomainsocimpact', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'linkscity', 'citysearch', 'cityadd', 'cityview', 'citydelete'], 
                                'documentresearch' => ['index', 'search','linkscountry', 'countryadd', 'countrysearch', 'countrydelete', 'countryview', 'countryselectCity', 'countryaddCity', 'countrydelCity', 'countryselectRegion', 'countryaddRegion', 'countrydelRegion', 'countryselectTeritcon', 'countryaddTeritcon', 'countrydelTeritcon'],     
                                'sector' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'language' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'type' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete',  'deleteConfirm', 'deleteCancel', 'view', 'category', 'addCategory', 'deleteCategory'],
                                'searchdatabase' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'litarea' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete',  'deleteConfirm', 'deleteCancel', 'view'],
                                'technique' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'relevance' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'country' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'region' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'city' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'institution' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'author' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'beneficiary' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'users' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view','deleteConfirm'],
                                'partner' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'deleteConfirm'],
                                'culturaldomain' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'keyword' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'pregledcultdomain', 'addcultdomain', 'delcultdomain','pregledsocimpact','addsocimpact', 'delsocimpact', 'linkkeyword'],                     
                                'keywordtv' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'pregledcultdomain', 'addcultdomain', 'delcultdomain','pregledsocimpact','addsocimpact', 'delsocimpact', 'linkkeyword', 'statistic', 'exportcelldoc', 'dockey', 'preparecity', 'documentcity'],                     
                                'transitionvar' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'dataprov' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'teritcon' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'analyse' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'analysecultdomainsocimpact', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'analysekeyword', 'analysedocument', 'pregled', 'pregledkeyword', 'pregleddocsector', 'statistic', 'pregleddoc', 'detail', 'statisticsector', 'statistictheme', 'pregleddoctheme', 'statisticyeardomain', 'pregledyeardomain', 'statisticyearsector', 'pregledyearsector'],
                                'socialimpact' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'role' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'deleteConfirm'],
                                'upload' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'add', 'upload', 'editdoc', 'savedoc', 'download'],
                                'category' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete',  'deleteConfirm', 'deleteCancel', 'view'],
                                'celldoc' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'kolegij' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'faculty' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'universita' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'studprogram' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'template' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'pregled', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'templatecultdomainsocimpact', 'check', 'definekeyword', 'deletedocument'],
                                'register' => ['index'],
                                'documentwaitingroom' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'pregled', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'documentwaitingroomcultdomainsocimpact', 'check', 'definekeyword', 'deletedocument', 'doctransitionvar'],
                                'importeddocument' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                                'organisation' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'profile'     => ['index', 'profile']
			];
			foreach ($privateResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
                	}
                                                
        //              Private area resources User
			$privateUserResources = [
//                                'document' => ['index', 'search', 'view','pregled','linksauthor'],
                                'document' => ['index', 'search', 'view', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel','pregled','linksauthor', 'createdocumenttemplate', 'read', 'readfile', 'newread', 'export', 'upload', 'prepare', 'unos', 'dockey', 'preparecity', 'documentcity', 'documentrename', 'documentrenamenew', 'docprepare', 'docexport', 'exportcelldoc', 'celldocdatabase', 'documenttransvar'],
                                'documentlink' => ['index', 'search', 'linksauthor', 'authorview', 'authorsearch', 'linkscountry', 'linksrelevance', 'techniquesearch', 'techniqueview','relevancesearch', 'relevanceview', 'linkssearchdatabase', 'searchdatabasesearch', 'searchdatabaseview', 'linkstechnique', 'techniqueview', 'linksbeneficiary', 'beneficiarysearch', 'beneficiaryview'], 
      //                          'template' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'pregled', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'templatecultdomainsocimpact', 'check', 'definekeyword'],                
//                'template' => ['index', 'search', 'new', 'edit', 'save', 'create', 'view', 'pregled'],
                                'documentresearch' => ['index', 'search','linkscountry', 'countrysearch', 'countryview'],     
                                'analyse' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'analysecultdomainsocimpact', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'analysekeyword', 'analysedocument', 'pregled', 'pregledkeyword', 'pregleddocsector', 'statistic', 'pregleddoc', 'detail', 'statisticsector', 'statistictheme', 'pregleddoctheme', 'statisticyeardomain', 'pregledyeardomain', 'statisticyearsector', 'pregledyearsector'],    
                            //'analyse' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'analysecultdomainsocimpact', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'analysekeyword', 'analysedocument', 'pregled', 'pregledkeyword', 'pregleddocsector', 'statistic', 'pregleddoc', 'detail', 'statisticsector', 'statistictheme', 'pregleddoctheme', 'statisticyeardomain', 'pregledyeardomain', 'statisticyearsector', 'pregledyearsector'],
                        //      'sector' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'language' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'type' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete',  'deleteConfirm', 'deleteCancel', 'view'],
                        //      'searchdatabase' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'litarea' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete',  'deleteConfirm', 'deleteCancel', 'view'],
                        //      'technique' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'relevance' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'country' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'region' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'city' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'institution' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'author' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'beneficiary' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view'],
                        //      'users' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view','deleteConfirm'],
                        //      'partner' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'deleteConfirm'],
                        //      'role' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'view', 'deleteConfirm'],
       			//	'profile'     => ['index', 'profile']
			];
			foreach ($privateUserResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}   

                        //              Private area resources Templateuser
			$privateTemplateuserResources = [
                                'document' => ['index', 'search', 'view'],
                                'documentlink' => ['index', 'search', 'linksauthor', 'authorview', 'authorsearch', 'linkscountry', 'linksrelevance', 'techniquesearch', 'techniqueview','relevancesearch', 'relevanceview', 'linkssearchdatabase', 'searchdatabasesearch', 'searchdatabaseview', 'linkstechnique', 'techniqueview', 'linksbeneficiary', 'beneficiarysearch', 'beneficiaryview'], 
                                'template' => ['index', 'search', 'new', 'edit', 'save', 'create', 'view', 'pregled', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'templatecultdomainsocimpact', 'check'],
                                'documentresearch' => ['index', 'search','linkscountry', 'countrysearch', 'countryview'],     
                                'analyse' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete', 'deleteConfirm', 'deleteCancel', 'view', 'analysecultdomainsocimpact', 'addcultdomain', 'delcultdomain', 'addsocimpact', 'delsocimpact', 'analysekeyword', 'analysedocument', 'pregled', 'pregledkeyword', 'pregleddocsector', 'statistic', 'pregleddoc', 'detail', 'statisticsector', 'statistictheme', 'pregleddoctheme', 'statisticyeardomain', 'pregledyeardomain', 'statisticyearsector', 'pregledyearsector'],
			];
			foreach ($privateUserResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}   

			//Public area resources 
			$publicResources = [
				'index'      => ['index'],
				'about'      => ['index'],
//				'register'   => ['index'],
				'errors'     => ['show401', 'show404', 'show500'],
//				'session'    => ['index', 'register', 'start', 'end'],
                            	'session'    => ['index', 'start', 'end', 'access'],
				'contact'    => ['index', 'send'],
			];
			foreach ($publicResources as $resource => $actions) {
				$acl->addResource(new Resource($resource), $actions);
			}

			//Grant access to public areas to both users and guests
			foreach ($roles as $role) {
				foreach ($publicResources as $resource => $actions) {
					foreach ($actions as $action){
						$acl->allow($role->getName(), $resource, $action);
					}
				}
			}

			//Grant access to private area to role Administrator
			foreach ($privateResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Administrator', $resource, $action);
				}
			}
                        
                        //Grant access to private area to role Users
			foreach ($privateUserResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Users', $resource, $action);
				}
			} 
                        
                        //Grant access to private area to role Templateusers
			foreach ($privateTemplateuserResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow('Templateuser', $resource, $action);
				}
			} 

			//The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
		$auth = $this->session->get('auth');
		if (!$auth){
			$role = 'Guests';
		} else {
                    $ID_Role = $auth['ID_Role'];
                    if ( $ID_Role == 2) {
                        $role = 'Users';
                      } 
                    if ( $ID_Role == 3) {
                        $role = 'Templateuser';
                     }
                     if ( $ID_Role == 4) {
			$role = 'Administrator';
                      }
                }

                   
		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();

		$acl = $this->getAcl();

		if (!$acl->isResource($controller)) {
			$dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show404'
			]);

			return false;
		}

		$allowed = $acl->isAllowed($role, $controller, $action);
		if (!$allowed) {
			$dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show401'
			]);
                        $this->session->destroy();
			return false;
		}
	}
}
