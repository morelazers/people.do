<div class='login_popbox'>
  	<a class='open' href='#'>Upvote</a>
  	<div class='collapse'>
    	<div class='box'>
	      	<div class='arrow'></div>
	      	<div class='arrow-border'></div>
	      		<?php
					$options = array('url' => '/users/login');
					echo $this->Form->create('User', $options);
				    echo $this->Form->input('username', array('id' => 'PopupUserUsername'));
				    echo $this->Form->input('password', array('id' => 'PopupUserPassword'));
				    echo $this->Form->end('Login');
				?>
	      <a href="#" class="close">close</a>
	    </div>
  	</div>
</div>