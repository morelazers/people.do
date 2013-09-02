<?php
class UserInterest extends AppModel
{
    public $belongsTo = array(
        'User',
        'Interest'
    );
}
?>