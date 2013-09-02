<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
    <?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js'); ?>
    <?php echo $this->Html->script('bootstrap.js'); ?>
    <?php echo $this->Html->script('ajax_loginAndRefreshPage.js'); ?>
    <?php echo $this->Html->script('ajax_checkNewUsernameIsValid.js'); ?>
    
    <?php 
        $userdata = $this->session->read('Auth.User'); 
    	echo '<script> var userIsLoggedIn = ';
    	if(!$userdata){
            $loggedIn = false;
    		echo 'false ';
    	} else {
            $loggedIn = true;
    		echo 'true ';
    	}
    	echo '</script>';
    	//debug($userdata);
    ?>

	<?php echo $this->Html->charset(); ?>
	<title>

		people.do

	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');
        echo $this->Html->css('bootstrap-responsive.min');
        echo $this->Html->css('style');
        
        echo $this->Html->css('http://fonts.googleapis.com/css?family=Lato:400,700');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>

	<div class="container">
  	<div id="header" class="row">
    	<div class="span4">
      		<div class="logo">
        		<?php 
                    echo $this->Html->image("transparentlogo.png", array(
                        "alt" => "People.do",
                        'url' => array('controller' => 'ideas', 'action' => 'index'),
                        'class' => 'peopleDoLogo'
                    ));
    			?>
      		</div>
      </div>      
  		<div class="span6">
        <ul class="navigation">
          <li><a href="/">Home</a></li>
          <li><a href="/share">Share</a></li>
          <li><a href="/think">Think</a></li>
          <li><a href="/about/">About</a></li>
        </ul>
      </div>
      <div class="span2">
        <div class="user-panel">
  		
        Welcome<?php if($loggedIn){ 
                        echo ', '.$userdata['User']['display_name'].'!<br />';
                        $unreadCount = 0;
                        foreach($userdata['MessageReceived'] as $message){
                            if(!$message['is_read']){
                                $unreadCount++;
                            }
                        }
                        echo '<a href="/messages/" class="messagesLink">Messages ('.$unreadCount.')</a>';
                    } else {
                    ?>!
                    <br />
                    <?php 
                        echo $this->Html->link('Log in/Register', '#LoginModal', array('data-toggle' => 'modal'));
                    }
                    ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="span12">
        <div class="hero-unit">
          <?php echo $this->fetch('topbar'); ?>
        </div>
      </div>
    </div>  

	<div id="main" class="container-inset">
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<div class="footer">
    
    <?php echo $this->element('loginModal'); ?>
        
      <div class="row">
        <div class="span6">
          <p>&copy; 2013 PeopleDo</p>
        </div>
      </div>
    </div>
	</div>
	<?php
    echo $this->Js->writeBuffer();
  ?>
</body>
</html>
