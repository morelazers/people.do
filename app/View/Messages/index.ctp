<h1>Messages</h1>
<?php foreach($messages as $message): ?>
<p>
    <?php echo $message['Message']['content']; ?>
</p>
<?php endforeach; ?>