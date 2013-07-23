<h1>Messages:</h1>
</br>
</br>
<?php foreach($messages as $message): ?>
<p>
    <?php echo $message['Message']['content']; ?>
</p>
<?php endforeach; ?>