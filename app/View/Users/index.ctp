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
    <tr>
        <th>Id</th>
        <th>username</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td><?php echo $user['User']['username']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>