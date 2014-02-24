<?php    
    $isSelected = false;
    $selectArray = array();
    foreach($interests as $interest) {
        if($selected !== null) {
            if(in_array($interest['Interest']['name'], $selected)){
                $isSelected = true;
            } else {
                $isSelected = false;
            }
        }
        $selectArray[$interest['Interest']['id']] = array(
            'name' => $interest['Interest']['name'],
            'value' => $interest['Interest']['id'],
            'selected' => $isSelected
        );
    }
    
?>
<label for="InterestId">Interests</label>    
<?php
    echo $this->Chosen->select(
        'Interest.id',
        $selectArray,
        array(
            'data-placeholder' => $placeholder,
            'multiple' => true,
            'class' => 'interest-box form-control'
        )
    );
?>