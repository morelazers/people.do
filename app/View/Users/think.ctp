<!-- File: /app/View/Users/think.ctp -->

<div class="think-page">
	<div class="think-description">
	    <div class="think-heading">Just trying something out</div>
	    <div class="pageDescription">
	        This page uses your interests to find some ideas that you might be interested in!
	        <br/>
	
	    <?php 
	        if(!isset($user)){
	    ?>
	            To get the most out of this feature you should 
	            <?php
	                echo $this->Html->link('log in', '#LoginModal', array('data-toggle' => 'modal'));
	            ?>
	            and set a few interests on your internet page!
	    <?php
	        } else {
	    ?>
	            To get the most out of this page, you should tell us what you're interested in 
	            <?php
	                echo $this->Html->link('over here!', array('controller' => 'profiles', 'action' => 'index'));
	            ?>
	    <?php
	        }
	    ?>
	    </div>
	</div>

<?php echo $this->element('ideaList', array('ideas' => $ideas)); ?>

</div>