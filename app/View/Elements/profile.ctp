<div class="profile">
    <h2 class="profileHeading"><?php echo $user['User']['display_name']; ?> wrote this:</h2>
    <p>
        <?php
        $about = false;
        if(isset($user['Profile']['about_me']) && $user['Profile']['about_me'] !== ''){
            echo $user['Profile']['about_me'];
            $about = true;
        } else {
            echo "Actually, " . $user['User']['display_name']." hasn't written anything, I was just kidding.";
        }
        ?>
    </p>
    
    <h2 class="profileHeading"><?php echo $user['User']['display_name']; ?> likes these things:</h2>
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
        } else if($about){
        	echo " * empty space *";
        } else {
            echo "peopledo, ideas, burrito- oh, no sorry I was kidding again, " . $user['User']['display_name']." hasn't told me what they like yet. <br /><br /> At least we can rule out egotism.";
        }
        ?>
    </p>
</div>