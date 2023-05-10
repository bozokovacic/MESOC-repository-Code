<?php

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{
    
    private $_headerMenu = [
        'navbar-left' => [
/**            'index' => [
                'caption' => 'Home',
                'action' => 'index'
            ], 
            'document' => [
                'caption' => 'Documents',
                'action' => 'view'
            ], */
            'about' => [
                'caption' => 'About application',
                'action' => 'index'
            ],
             'contact' => [
                'caption' => 'Contact',
                'action' => 'index'
            ],
        ],
        'navbar-right' => [
            'session' => [
                'caption' => 'Sign in',
                'action' => 'index'
            ],
        ]
    ];

    private $_tabs1 = [
        'Documents' => [
            'controller' => 'document',
            'action' => 'view',
            'any' => true
        ],
        'Documents search' => [
            'controller' => 'document',
            'action' => 'index',
            'any' => true
        ],
            'Statistical analysis' => [
            'controller' => 'analyse',
            'action' => 'statistic',
            'any' => true
        ],
            'Document proposal' => [
            'controller' => 'template',
            'action' => 'view',
            'any' => true
        ],
    ];    

    private $_tabsuser = [
        'Documents' => [
            'controller' => 'document',
            'action' => 'index',
            'any' => true
        ],
        'Statistical analysis' => [
            'controller' => 'analyse',
            'action' => 'view',
            'any' => true
        ],
         'Document proposal' => [
            'controller' => 'template',
            'action' => 'view',
            'any' => true
        ],
    ];    
        
    private $_tabs2 = [
    	'Language' => [
            'controller' => 'language',
            'action' => 'view',
            'any' => true
        ],
        'Database' => [
            'controller' => 'searchdatabase',
            'action' => 'view',
            'any' => true  
        ], 
/**            'Lit. Area' => [
            'controller' => 'litarea',
            'action' => 'view',
            'any' => true
        ], 
        'Sector' => [
            'controller' => 'sector',
            'action' => 'view',
            'any' => true
        ], */
        'Document Type' => [
            'controller' => 'type',
            'action' => 'view',
            'any' => true
        ],
        'Technique' => [
            'controller' => 'technique',
            'action' => 'view',
            'any' => true
        ], 
/**        'Relevance' => [
            'controller' => 'relevance',
            'action' => 'view',
            'any' => true
        ], 
        'NUTS category' => [
            'controller' => 'teritcon',
            'action' => 'view',
            'any' => true
        ],*/
              'Author' => [
            'controller' => 'author',
            'action' => 'view',
            'any' => true
        ],  
        'Country' => [
            'controller' => 'country',
            'action' => 'view',
            'any' => true
        ],
        'City' => [
            'controller' => 'city',
            'action' => 'view',
            'any' => true
        ],             
        'Institution' => [
            'controller' => 'institution',
            'action' => 'view',
            'any' => true
        ],       
        'Territorial context' => [
            'controller' => 'region',
            'action' => 'view',
            'any' => true
        ],       
        'Data providers' => [
            'controller' => 'dataprov',
            'action' => 'view',
            'any' => true
        ],   
/**        'Beneficiary' => [
            'controller' => 'beneficiary',
            'action' => 'view',
            'any' => true
        ],   
        'Roles' => [
            'controller' => 'role',
            'action' => 'view',
            'any' => true
        ],      
        'Partners' => [
            'controller' => 'partner',
            'action' => 'view',
            'any' => true
        ],   */   
       'Cultural sector' => [
            'controller' => 'culturaldomain',
            'action' => 'view',
            'any' => true
        ],
        'Cross-over theme' => [
            'controller' => 'socialimpact',
            'action' => 'view',
            'any' => true
        ],
         'Keywords' => [
            'controller' => 'keyword',
            'action' => 'view',
            'any' => true
        ],
/**        'Theasurus' => [
            'controller' => 'thesaurus',
            'action' => 'view',
            'any' => true
        ],  */
        'Keywords trans. var.' => [
            'controller' => 'keywordtv',
            'action' => 'view',
            'any' => true
        ],
        'Transition variable' => [
            'controller' => 'transitionvar',
            'action' => 'view',
            'any' => true
        ],
        'Document category' => [
            'controller' => 'category',
            'action' => 'view',
            'any' => true
        ],
        'Organisation' => [
            'controller' => 'organisation',
            'action' => 'view',
            'any' => true
        ],
        'Upload' => [
            'controller' => 'upload',
            'action' => 'view',
            'any' => true
        ],
         'Cell statistic' => [
            'controller' => 'celldoc',
            'action' => 'view',
            'any' => true
        ],
/**           'Users' => [
            'controller' => 'users',
            'action' => 'view',
            'any' => true  
        ]       */
       
/**        ' Profile' => [
            'controller' => 'profile',
            'action' => 'profile',
            'any' => false
        ], */
          
    ];

    private $_tabs_user = [
        'Documents view' => [
            'controller' => 'document',
            'action' => 'view',
            'any' => true
        ],
        'Documents search' => [
            'controller' => 'document',
            'action' => 'index',
            'any' => true
        ],
        'Statistical analysis' => [
            'controller' => 'analyse',
            'action' => 'statistic',
            'any' => true
        ],
    ];

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['navbar-right']['session'] = [
                'caption' => 'Sign out',
                'action' => 'end'
            ];
        } else {
            unset($this->_headerMenu['navbar-left']['invoices']);
        }

        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) {
            echo '<div class="nav-collapse">';
            echo '<ul class="nav navbar-nav ', $position, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($controller . '/' . $option['action'], $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

    }

    /**
     * Returns menu tabs
     */
    public function getTabs()
    {
        $auth = $this->session->get('auth');
        $usertype = $auth['ID_Role'];
	$controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-tabs">';
        if ( $usertype == 2) {
            foreach ($this->_tabs_user as $caption => $option) {
                if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
            }
        }
        if ( $usertype == 3) {
            foreach ($this->_tabs1 as $caption => $option) {
                if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
            }
        }        
        if ( $usertype == 4) {
            foreach ($this->_tabs1 as $caption => $option) {
                if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
            }
        }
        echo '</ul>';
        
        echo '<ul class="nav nav-tabs">';
        if ( $usertype == 4) {
            foreach ($this->_tabs2 as $caption => $option) {
                if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
            }
        }
        echo '</ul>';
    }
}
