<script>

	$(document).ready(function(){
	    $('#EditForm').hide();
	});

	function showEditForm(){
		$("#EditForm").toggle();
		if($("#EditButton").text() == "Edit"){
			$("#EditButton").text("Cancel");
		} else {
			$("#EditButton").text("Edit");
		}
	}
    
</script>

<?php $this->start('topbar'); ?>
<h1>Edit your profile!</h1>
<?php $this->end(); ?>

<div id="EditForm">
<?php
	echo $this->Form->create('Profile');
    echo $this->Form->input('about_me', array('rows' => '3'));
    
    echo $this->element('interestBox', array(
        'interests' => $interests,
        'selected' => $selected,
        'placeholder' => 'What are you interested in?'
        )
    );

    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save');
?>
</div>
<button id="EditButton" onclick="showEditForm()">Edit</button>