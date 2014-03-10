<script>

	function showEditForm(){
		$("#EditForm").toggle();
		if($("#EditButton").text() === "Edit"){
			$("#EditButton").text("Cancel");
		} else {
			$("#EditButton").text("Edit");
		}
	}

</script>

<div class="profile col-md-5">

  <div class="top-spacer"></div>
  <h2>The internet probably loves you</h2>
  <div class="pageDescription">
      Show it some love and write on it, or just tell it what you like.
  </div>

  <?php echo $this->element('profile', array('user' => $user, 'interestNames' => $selected, 'thisUser' => true)); ?>

  <div id="EditForm">
  <?php
  	echo $this->Form->create('Profile');
  ?>
    <div class="form-group">
    <?php
      echo $this->Form->input('about_me', array('rows' => '7', 'default' => $user['Profile']['about_me'], 'class' => 'form-control about-me', 'label' => 'Write something!'));
    ?>
    </div>

    <div class="form-group">

    <?php

      echo $this->element('interestBox', array(
          'interests' => $interests,
          'selected' => $selected,
          'placeholder' => 'Psst, hit \'enter\' after typing to save something new'
          )
      );

    ?>
    </div>
    <?php

      echo $this->Form->input('id', array('type' => 'hidden'));
      echo $this->Form->submit('Save', array('class' => 'saveProfile btn btn-default'));
      echo $this->Form->end();
  ?>
  </div>
  <button id="EditButton" class="btn btn-default" onclick="showEditForm()">Edit</button>
</div>