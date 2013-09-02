<?php
class Interest extends AppModel {
    
    public function saveNewInterest($id, $uid){
        $this->create();
        $newInterest['name'] = $id;
        $newInterest['user_id'] = $uid;
        $this->save($newInterest);
    }
}
?>