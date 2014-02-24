<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'ideas', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	  Router::connect('/profile', array('controller' => 'profiles', 'action' => 'index'));
    Router::connect('/profile/view/*', array('controller' => 'profiles', 'action' => 'view'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
    
    Router::connect('/about/*', array('controller' => 'pages', 'action' => 'about'));
    Router::connect('/login/*', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/share/*', array('controller' => 'ideas', 'action' => 'add'));
    Router::connect('/think/*', array('controller' => 'users', 'action' => 'think'));
    Router::connect('/ideas/ajaxview/*', array('controller' => 'ideas', 'action' => 'ajaxview'));
    Router::connect('/ideas/upvote/*', array('controller' => 'ideas', 'action' => 'upvote'));
    Router::connect('/comments/upvote/*', array('controller' => 'comments', 'action' => 'upvote'));
    Router::connect('/comments/reply/*', array('controller' => 'comments', 'action' => 'reply'));
    Router::connect('/message', array('controller' => 'messages', 'action' => 'send'));
    Router::connect('/message/*', array('controller' => 'messages', 'action' => 'send'));
    Router::connect('/messages/reply/*', array('controller' => 'messages', 'action' => 'reply'));
    Router::connect('/messages/*', array('controller' => 'messages', 'action' => 'index'));
    
    Router::connect('/users/ajax_login/*', array('controller' => 'users', 'action' => 'ajax_login'));
    Router::connect('/users/ajax_register/*', array('controller' => 'users', 'action' => 'ajax_register'));
    Router::connect('/users/checkExistence/*', array('controller' => 'users', 'action' => 'checkExistence'));
    Router::connect('/user/*', array('controller' => 'profiles', 'action' => 'view'));

  	Router::connect(
  		'/opauth-complete/*', 
  		array('controller' => 'users', 'action' => 'opauth_complete')
  	);
	
		  Router::connect('/*', array('controller' => 'ideas', 'action' => 'index'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

