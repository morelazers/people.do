<script>
    $(document).ready(function(){
        window.close();
    });
</script>

<?php echo $this->start('topbar'); ?>

<h1>This page should close automatically</h1>
<div class="pageDescription">
    If it doesn't then something's gone wrong or you've got here the wrong way, close it manually and try again.
</div>

<?php echo $this->end(); ?>