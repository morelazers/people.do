<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $uses = array('User');

    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'Chosen.Chosen'
    );
    
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'ideas', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'ideas', 'action' => 'index'),
            'authorize' => array('Controller'), // Added this line
            'flash' => array(
                'element' => 'alert',
                'key' => 'auth',
                'params' => array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error'
                )
            )
        )
    );

    public function isAuthorized($user) 
    {
        // Admin can access every action
        if (isset($user['usertype']) && $user['usertype'] === 'admin') {
            return true;
        }
        
        // Default deny
        return false;
    }
    
    public function _refreshAuth($field = '', $value = '') {
    	if (!empty($field) && !empty($value)) { 
    		$this->Session->write($this->Auth->sessionKey .'.'. $field, $value);
    	} else {
    		if (isset($this->User)) {
    			$this->Auth->login($this->User->read(false, $this->Auth->user('id')));
    		} else {
    			$this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
    		}
	    }
    }

    public function beforeFilter() 
    {
        $this->Auth->allow();
        
        if($this->Session->check('Auth.User')) {
            $this->_refreshAuth();
            $user = $this->Auth->user();
            $this->set('user', $user);
        }
    }
    
}
