<?php
    $facebookName = "photoKandy-Studios";
    $facebookUserID = "87979941601";
    $facebookItemCount = 25;
    $facebookAvatar = 'http://profile.ak.fbcdn.net/hprofile-ak-snc4/41475_1362462100_2106_q.jpg';
?>

<div class="content">

 <img class="imgLeft" src='<?= $facebookAvatar ?>' />
 <h1>Recent Facebook Posts</h1>
 <p>Here are some of our most recent posts on facebook. If you are on facebook as well, you're welcome to <a href="#">Like Us</a>.</p>
 <div class="listGroup">
<?php
    include ('./script/facebook.php');

    function time_since($original) {
        // array of time period chunks
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
        );
        
        $today = time(); /* Current unix time  */
        $since = $today - $original;
        
        // $j saves performing the count function each time around the loop
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            
            // finding the biggest chunk (if the chunk fits, break)
            if (($count = floor($since / $seconds)) != 0) {
                // DEBUG print "<!-- It's $name -->\n";
                break;
            }
        }
        
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
           
        return $print;
    }
    
    $mySM = getfacebookItems( 'http://graph.facebook.com/' . $facebookUserID . '/feed');

    foreach ($mySM as $item)
    {
       // echo strtotime ($item["created_time"]);
       // echo "<br>". $item["created_time"];
        $i=0;
        if ( $item["message"] != "" && $i < $facebookItemCount)
        {
            $i++;
            $picture = $item["picture"] ? $item["picture"] : $item["icon"];
            $height = $item["picture"] ? 'height:4em; overflow: hidden' : 'height:2em; overflow: hidden';
            $link = $item["link"] ? $item["link"] : "#";
?>
    <a href="<?=$link?>" target="_blank" class="listItem <?= $item["link"] ? "arrow" : "" ?>" style="<?=$height?>">
     <?= $item["picture"] ? '<img border=0 src="' . $item["picture"] . '" />' : ($item["icon"] ? '<img border=0 style="width:64px" src="' . $picture . '" />' : "") ?>
     <?= $item["message"] ?> 
     <span class="minor floatRight">(<?= time_since (strtotime( $item["created_time"] ) ) ?> ago)</span>
     <?= $item["description"] ?>
    </a>
<?php
        }
    }
?>
 </div>
<p style="text-align: right;"><a href="http://www.facebook.com/pages/<?=$facebookName?>/<?=$facebookUserID?>">more...</a></p>
<br><br><br>
</div>
