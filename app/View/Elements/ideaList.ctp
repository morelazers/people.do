<div id="idea-list" class="col-lg-5 text-left scrollable">
    <div class="top-spacer">
      
    </div>

<?php 
$count = 0;
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