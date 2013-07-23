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
, or sign in with 
<?php
echo $this->Html->link(
    'Google',
    array('controller' => 'auth', 'action' => 'google')
);
?>
 or 
<?php
echo $this->Html->link(
    'Facebook',
    array('controller' => 'auth', 'action' => 'facebook')
);
?>
.
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
        <div class="post">
            <p class="title">
                <?php 
                    echo $this->Html->link($idea['Idea']['name'],
                    array('controller' => 'ideas', 'action' => 'view', $idea['Idea']['id'])); 
                ?>
            </p>
            <p class="description">
                Shared by: 
                <?php
                    echo $this->Html->link($idea['Idea']['posted_by_name'], 
                    array('controller' => 'users', 'action' => 'profile', $idea['Idea']['posted_by_name']));
                ?>
                <br />
                <?php echo $idea['Idea']['upvotes']; ?>
                Likes
            </p>
        </div>
    <?php endforeach; ?>
    <?php unset($idea); ?>
</table>