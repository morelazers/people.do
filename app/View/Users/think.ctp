<!-- File: /app/View/Users/think.ctp -->

<?php echo $this->start('topbar'); ?>
<?php 
    if(!isset($user)){
?>
        <p>We see you haven't yet logged in, to get the most out of this page you should 
        <?php
            echo $this->Html->link('login', '#LoginModal', array('data-toggle' => 'modal'));
        ?>
        and set a few interests in your profile!</p>
<?php
    } else {
?>
        <p>To get the most out of this page, tell us what you're interested in by editing your 
        <?php
            echo $this->Html->link('profile!', array('controller' => 'profiles', 'action' => 'index'));
        ?>
        </p>
<?php
    }
?>
<?php echo $this->end(); ?>


<br /><br />

<table>
    <?php foreach ($ideas as $idea): ?>
        <div class="post">
            <p class="title">
                <?php 
                    echo $this->Html->link($idea['Idea']['name'],
                    array('controller' => 'ideas', 'action' => 'view', $idea['Idea']['id']),
                    array('class' => 'idea-title')); 
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