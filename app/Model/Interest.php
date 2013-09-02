<?php
class Interest extends AppModel {
    
    public function saveNewInterest($name, $uid){
        $this->create();
        $newInterest['name'] = $name;
        $newInterest['user_id'] = $uid;
        $this->save($newInterest);
    }
}
?>