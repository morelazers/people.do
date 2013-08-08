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
                echo $this->Html->link($idea['Idea']['shared_by_name'], 
                array('controller' => 'profiles', 'action' => 'view', $idea['Idea']['user_id']));
            ?>
            <br />
            <?php echo $idea['Idea']['upvotes']; ?>
            Likes
        </p>
    </div>
<?php endforeach; ?>