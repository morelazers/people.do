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

    <?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
    <?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js'); ?>
    <?php echo $this->Html->script('login_popup.js'); ?>
    
    <?php echo $this->Html->script('popbox.js'); ?>
    <script type='text/javascript'>
	   	$(document).ready(function(){
	     	$('.login_popbox').popbox();
	   	});
	</script>

    <?php 
    	$userdata = $this->session->read('Auth.User'); 
    	echo '<script> var userIsLoggedIn = ';
    	if(!$userdata){
    		echo 'false ';
    	} else {
    		echo 'true ';
    	}
    	echo '</script>';
    	debug($userdata);
    ?>

	<?php echo $this->Html->charset(); ?>
	<title>

		people.do

	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>

	<div id="wrapper">
      	<div id="header">
        	<div class="container">
          		<div class="fluid logo">
            		Some Logo
          		</div>
          		<div id="navigation" class="fluid">
            		<ul>
              			<li><a href="/">Home</a></li>
              			<li><a href="/ideas/add/">Share</a></li>
              			<li><a href="/">Discover</a></li>
              			<li><a href="/about/">About</a></li>
            		</ul>
          		</div>
          		<div id="user-panel" class="pull-right">
            		Welcome, Chris!
          		</div>
        	</div>
      	</div>

        <div id="welcome-panel" class="container inset">
	        Welcome<br />
	        Welcome<br /> 
	        Welcome<br />
	        (Here you can use bootstrap fluid grid)
      	</div>
		<div id="main" class="container inset">
			<div id="content">
				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
