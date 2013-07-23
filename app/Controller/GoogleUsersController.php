<?php
class GoogleUsersController extends AppController {
    public function add($raw){
        $this->GoogleUser->add($raw);
    }
}
?>