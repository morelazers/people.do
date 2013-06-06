<!-- File: /app/View/Ideas/add.ctp -->

<h1>Share Idea</h1>
<?php
echo $this->Form->create('Idea');
echo $this->Form->input('name');
echo $this->Form->input('description', array('rows' => '3'));
echo $this->Form->end('Share Idea');
?>