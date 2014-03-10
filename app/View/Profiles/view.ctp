<div id="profile-view" class="col-lg-10 text-left scrollable">

  <div class="top-spacer"></div>
  <h2>
      <?php echo $userToView['User']['display_name']; ?>
  </h2>
  <div class="page-description">
      <?php
        if($userToView['User']['facebook_user'] || $userToView['User']['google_user']){
          $messageLink = $userToView['User']['id'];
        } else {
          $messageLink = $userToView['User']['display_name'];
        }
      ?>
      <a href="/message/<?php echo $messageLink; ?>">Message <?php echo $userToView['User']['display_name']; ?></a>
  </div>
  
  <?php
      echo $this->element('profile', 
      array(
          'user' => $userToView
          )
      );
      
  ?>
</div>