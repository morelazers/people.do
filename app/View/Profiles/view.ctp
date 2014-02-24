<div id="profile-view" class="col-lg-10 text-left scrollable">

  <div class="top-spacer"></div>
  <h2>
      <?php echo $userToView['User']['display_name']; ?>
  </h2>
  <div class="page-description">
      <a href="/message/<?php echo $userToView['User']['display_name']; ?>">Message <?php echo $userToView['User']['display_name']; ?></a>
  </div>
  
  <?php
      echo $this->element('profile', 
      array(
          'user' => $userToView
          )
      );
      
  ?>
</div>