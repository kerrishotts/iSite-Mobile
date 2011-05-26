<?php
    $twitterName = "photokandy";
    $twitterUserID = "16098212";
    $twitterItemCount = 25;
    $twitterAvatar = 'https://si1.twimg.com/profile_images/1092570194/social-logo-v2_reasonably_small.png';
?>

<div class="content">

 <img class="imgLeft" src='<?= $twitterAvatar ?>' />
 <h1>Recent Tweets</h1>
 <p>Here are some of our most recent posts on Twitter. If you are on Twitter as well, you're welcome to <a href="#">Follow Us</a>.</p>
 <div class="listGroup">
<?php
    include ('./script/twitter.php');

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
    
    $mySM = getTwitterItems( 'http://twitter.com/statuses/user_timeline/' . $twitterUserID . '.rss' );
    for ($i=0;$i<$twitterItemCount;$i++)
    {
        if ( $mySM[$i]->content != "" )
        {
?>
    <div class="listItem"><?= $mySM[$i]->content ?> <span class="minor">(<?= time_since (strtotime( $mySM[$i]->published ) ) ?> ago)</span></div>
<?php
        }
    }
?>
 </div>
<p style="text-align: right;"><a href="http://www.twitter.com/<?=$twitterName?>">more...</a></p>
<br><br><br>
</div>
