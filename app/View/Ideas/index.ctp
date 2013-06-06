<!-- File: /app/View/Ideas/index.ctp -->

<h1>Ideas</h1>

<?php 
echo $this->Html->link(
    'Share Idea',
    array('controller' => 'ideas', 'action' => 'add')
); 
?>
<br /><br />
<?php
echo $this->Html->link(
    'Register',
    array('controller' => 'users', 'action' => 'add')
);
?>
<br /><br />
<?php
echo $this->Html->link(
    'Send a Message',
    array('controller' => 'messages', 'action' => 'send')
);
?>
<br /><br />

<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
    </tr>

    <!-- Here is where we loop through our $ideas array, printing out post info -->

    <?php foreach ($ideas as $idea): ?>
    <tr>
        <td><?php echo $idea['Idea']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($idea['Idea']['name'],
array('controller' => 'ideas', 'action' => 'view', $idea['Idea']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($idea); ?>
</table>