<?php
    error_reporting( 0 );
    $itunesFeed = "http://feeds.twit.tv/twirt_video_small";
    $itunesPage = "http://itunes.apple.com/podcast/this-week-in-radio-tech-video/id435030225";
    $itunesItemCount = 25;
    $itunesCover = 'http://a3.mzstatic.com/us/r30/Podcasts/4d/df/1d/dj.fkhlbrem.170x170-75.jpg';
?>

<div class="content">

 <img class="imgLeft" src='<?= $itunesCover ?>' width=200px />
 <h1>Available Podcasts</h1>
 <p>The following shows an example iTunes feed showing the most recent episodes for a podcast. Note: not working for all feeds yet.</p>
 <div class="listGroup">
<?php
    include ('./script/itunes.php');

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

    $mySM = getitunesItems( $itunesFeed );

    for ($i=0;$i<$itunesItemCount;$i++)
    {
        if ( $mySM[$i]->description != "" )
        {
?>
    <a title='<?= str_replace(  "'", "&apos;", $mySM[$i]->description) ?>'
       class="listItem arrow"
       href="javascript:loadContent('./playVideo.php?uri=<?= $mySM[$i]->mediaURL ?>&img=<?= $mySM[$i]->image ?>', null, 'slideOut', './podcasts.php');"
       style="height: 3em; overflow: hidden; clear:both; font-weight: normal; position: static;">
     <img border=0 src="<?= $mySM[$i]->image ?>" />
     <div style="max-height: 1.2em; overflow: hidden;"><?= $mySM[$i]->title ?></div>
     <span class="minor floatLeft"><?= round($mySM[$i]->duration/60) ?>m <?= str_pad( ($mySM[$i]->duration % 60), 2, "0") ?>s </span>
     <span class="minor floatRight">Published <?= time_since (strtotime( $mySM[$i]->published ) ) ?> ago</span>
    </a>
<?php
        }
    }
?>
 </div>
<p style="text-align: right;"><a href="<?=$itunesPage?>">View in iTunes...</a></p>
<br><br><br>
</div>
