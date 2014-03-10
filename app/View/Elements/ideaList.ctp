<div id="idea-list" class="col-lg-5 text-left scrollable">
    <div class="top-spacer">
      
    </div>

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