<?php echo $this->start('topbar'); ?>
<h1>Edit</h1>
<div class="pageDescription">
    Edit your (- about to be even more amazing -) idea!
</div>
<?php echo $this->end('topbar'); ?>
<br />
<div id="ErrorMessage">
</div>
<?php
    echo $this->Form->create('Idea', array('id' => 'IdeaAddForm'));
    echo $this->Form->error('name');
    echo $this->Form->input('name', array('error' => false));
    echo $this->Form->error('description');
    echo $this->Form->input('description', array('rows' => '7','error' => false));
    
    echo $this->element('interestBox', array(
        'interests' => $interests,
        'selected' => $selectedInterests,
        'placeholder' => 'Start typing to see existing interests!'
        )
    );
?>
<?php
    echo $this->Form->end(array(
        'id' => 'SubmitIdea',
        'label' => 'Share!'
        )
    );
?>
<span id="IdeaTips">
<p class="nameTip">
Give your idea a catchy but concise name; 
<br/>
it's the first thing that others will see, so you want to grab their attention!
</p>
<p class="descriptionTip">
Describe your idea in detail.
<br/>
You have ten thousand characters here, so go nuts.
</p>
<p class="interestTip">
Finally, tag your idea with some interests.
<br/>
If there's one that you want to add, just type it in and hit enter to add it to the list.
<br/>
Others will then be able to use that interest in their profile and their ideas.
</p>
</span>