<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="styles.css" type="text/css">
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
    ?>

	<!-- <?php echo $this->Html->charset(); ?> -->
	<title>people.do</title>

</head>

<body>
	<!--header -->
	<div id="header">
		<div class="container">
				<a href="/index.html"><h1 class="logo">people.do</h1></a>
			<div id="nav-container">
			  	<ul id="topnav">
					<!-- Change these to reflect your pages. -->
				    <li><a href="index.html">Home</a></li>
				    <li><a href="share.html">Share</a></li>
				    <li><a href="think.html">Think</a></li>
				    <li><a href="about.html">About</a></li>
					<li>
					<?php if($loggedIn) { 
			        echo ', '.$userdata['User']['display_name'].'!<br />';
			                          
					$unreadCount = 0;
			                          
						foreach($userdata['MessageReceived'] as $message) {
			                              if(!$message['is_read']) {
			                                  $unreadCount++;
			                              }
			            }
			            echo '<a href="/messages/">Messages ('.$unreadCount.')</a>';
			            } else {
			                        ?>!
			           <? php 
			             echo $this->Html->link('Log in/Register', '#LoginModal', array('data-toggle' => 'modal'));
			             }
			           ?>
					</li>
				 </ul>
			</div>
		</div>
	</div>
	
	<!-- hero --> 
	<div id="hero">
		<div class="container">
			<h2 id="hero"><?php echo $this->fetch('topbar'); ?></h2>
		</div>
	</div>
	
	<!-- content -->
	<div id="content">
		<div class="container">
			<?php echo $this->Session->flash(); ?>
			<p class="text-content"><?php echo $this->fetch('content'); ?></p> 
		</div>
	</div>
	
	<!-- footer -->
	<div id="footer">
		<div class="container">
			<p id="footer-content">
				<?php echo $this->element('loginModal'); ?>
				© 2013 people.do
			</p>
		</div>
	</div>
	<?php
    echo $this->Js->writeBuffer();
  ?>	
</body>
</html>