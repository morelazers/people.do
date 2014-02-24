<div class="profile">
    <h2 class="profileHeading">About <?php echo $user['User']['display_name']; ?>:</h2>
    <p>
        <?php
        if(isset($user['Profile']['about_me']) && $user['Profile']['about_me'] !== ''){
            echo $user['Profile']['about_me']; 
        } else {
            echo $user['User']['display_name']." has yet to write anything about themselves, if you're sitting next to them, give them a nudge.";
        }
        ?>
    </p>
    
    <h2 class="profileHeading"><?php echo $user['User']['display_name']; ?>'s Interests:</h2>
    <p>
        <?php
        $count = count($interestNames);
        if($count !== 0){
            $i = 0;
            foreach($interestNames as $name){
                $i++;
                echo $name;
                if($i !== $count){
                    echo ', ';
                }
            }
        } else {
            echo "Apparently, ".$user['User']['display_name']." isn't interested in anything!";
        }
        ?>
    </p>
</div>