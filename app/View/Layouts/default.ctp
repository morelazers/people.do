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
  
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato:400,700">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-switch.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/chosen.css">

    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-touch-icon-152x152.png">
    <link rel="icon" type="image/png" href="img/favicon/favicon-196x196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="img/favicon/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <!-- END FAVICON (yep) -->

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php
    echo $this->fetch('meta');
    ?>
        
    <title>people.do</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript">
       window.userIsLoggedIn = "<?php if(isset($user)){ echo true; } else { echo false; }; ?>";
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <div id="page-container">
  
    <div id="nav-panel" class="col-xs-2">
      <div>
        <div id="logo" class="text-right">
          <a href="/" class="logo-link"><h1>people.do</h1></a>
        </div>
      </div>
      <div class="row">
        <ul id="nav-buttons" class="nav nav-pills nav-stacked text-right">
          <div class="nav-button-separator"></div>
          <li><a href="/share" id="share"><strong>share an idea</strong></a></li>
          <div class="nav-button-separator"></div>
          <li><a href="/think" id="think"><strong>interest me</strong></a></li>
          <div class="nav-button-separator"></div>
          <li><a href="/about" id="about"><strong>about</strong></a></li>
          <div class="nav-button-separator"></div>
        </ul>
      </div>
      <div class="nav-separator">
        <!-- 50px seperator between the two navs -->
      </div>
      <div class="row">
        <ul id="user-panel" class="nav nav-pills nav-stacked text-right">
          <div class="nav-button-separator"></div>
          <li>
              <?php
              if(isset($user)){
                $unreadCount = 0;
                foreach($user['MessageReceived'] as $msg){
                  if(!$msg['is_read']){
                    $unreadCount++;
                  }
                }
                echo '<a href="/profile" id="user-link">' . $user['User']['display_name'] . '</a>';
                $messagesLink = '<li><a href="/messages" id="messages-link">';
                if($unreadCount != 0){
                  $messagesLink .= $unreadCount;
                }else{
                  $messagesLink .= 'no';
                }
                $messagesLink .= ' new messages</a></li>';
                echo '<div class="nav-button-separator"></div>';
                echo $messagesLink;
                echo '<div class="nav-button-separator"></div>';
                echo '<li><a href="/logout" id="logout-link">logout</a></li>';
              } else {
                echo '<a href="#" data-toggle="modal" data-target="#LoginModal">Login/Register</a></li>';
              }
              ?>
          <div class="nav-button-separator"></div>
        </ul>
      </div>
    </div>
  
  <?php
    echo $this->fetch('content');
  ?>
  
  </div>

  <?php echo $this->element('loginModal'); ?>

  
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <script src="/js/bootstrap-switch.min.js"></script>
  <script src="/js/custom.js"></script>
  <script src="/js/ajax_replyToComment.js"></script>
  <script src="/js/ajax_checkNewUsernameIsValid.js"></script>
  <script src="/js/checkPasswordsMatch.js"></script>
  <script src="/js/ajax_checkUserExists.js"></script>
  <script src="/js/ajax_loginAndRefreshPage.js"></script>
  <script src="/js/ajax_replyToMessage.js"></script>

  <?php
  echo $this->fetch('script');
  echo $this->JS->writeBuffer();
  ?>


  </body>
</html>
