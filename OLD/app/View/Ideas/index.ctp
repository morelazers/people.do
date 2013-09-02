<!-- File: /app/View/Ideas/index.ctp -->

<?php echo $this->start('topbar'); ?>
<h1>Ideas</h1>
<?php echo $this->end(); ?>

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
<?php
echo $this->Html->link(
    'Edit your profile',
    array('controller' => 'profiles', 'action' => 'index')
);
?>
<br /><br />

<table>
    <?php foreach ($ideas as $idea): ?>
        <div class="post">
            <p class="title">
                <?php 
                    echo $this->Html->link($idea['Idea']['name'],
                    array('controller' => 'ideas', 'action' => 'view', $idea['Idea']['id'])); 
                ?>
            </p>
            <p class="description">
                Brainchild of: 
                <?php
                    echo $this->Html->link($idea['Idea']['shared_by_name'], 
                    array('controller' => 'profiles', 'action' => 'view', $idea['Idea']['user_id']));
                ?>
                <br />
                <?php echo $idea['Idea']['upvotes']; ?>
                Likes
            </p>
        </div>
    <?php endforeach; ?>
    <?php unset($idea); ?>
</table>