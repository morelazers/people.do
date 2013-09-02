<!-- File: /app/View/Ideas/index.ctp -->

<?php echo $this->start('topbar'); ?>
<h1>Ideas</h1>
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