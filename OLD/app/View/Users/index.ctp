<!-- File: /app/View/Users/index.ctp -->

<h1>Users</h1>

<?php 
echo $this->Html->link(
    'Login',
    array('controller' => 'users', 'action' => 'login')
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

<table>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td><?php echo $user['User']['username']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>