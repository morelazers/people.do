<div id="idea-list" class="col-lg-5 text-left scrollable">

  <?php if(isset($think)){ ?>
  <div class="row">
    <div class="think-heading">Just trying something out...</div>
    <div class="page-description">
      This page attempts to find things you might like.
      <br/>
    </div>
  </div>
  <?php } ?>

<?php
    if(!isset($user) && isset($think)){
?>
        <div class="row">
          To get the most out of it,
          <?php
              echo $this->Html->link('log in', '#LoginModal', array('data-toggle' => 'modal'));
          ?>
          and tell me what interests you!
        </div>
<?php
    } else if(isset($think)){
?>
        <div class="row">
        To get the most out of this page, you should tell us what you like
        <?php
            echo $this->Html->link('over here!', array('controller' => 'profiles', 'action' => 'index'));
        ?>
        </div>
<?php
    } else {
      ?>
      <div class="top-spacer">

      </div>
    <?php
    }
?>

<?php
$count = 0;
if(isset($ideas)){

	foreach ($ideas as $idea):
	$visible = "";
	if($count > 0){
		$visible = "hidden";
	}
	$count++;
	?>
		<div class="idea row">
		  <div class="idea-list-title">
			<?php echo $idea['Idea']['name']; ?>
		  </div>
		  <div class="idea-list-id"><?php echo $idea['Idea']['id']; ?></div>
		</div>

	<?php endforeach; ?>
	</div>

	<div id="idea-content-panel">

	</div>

	<?php
	  //echo $this->element('ideaDescription', array('idea' => $ideas[0]));
	?>


	<?php unset($idea); ?>

<?php

} else {
	?>
	<div class="idea-list-message">There seem to be no ideas here, maybe updating your interests will fix that.</div>
	<?php
}

?>