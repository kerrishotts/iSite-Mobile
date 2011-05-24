<?php
    error_reporting( 0 );
    $itunesFeed = "http://godfreynaz.blip.tv/rss/itunes/";
    $itunesPage = "http://itunes.apple.com/us/podcast/godfrey-church-nazarene/id412558543";
    $itunesItemCount = 25;
    $itunesCover = 'http://a.images.blip.tv/Godfreynaz-300x300_show_image746.jpg';
?>

<div class="content">

 <img class="imgLeft" src='<?= $itunesCover ?>' width=200px />
 <h1>Available Podcasts</h1>
 <p>Welcome to Godfrey Church of the Nazarene! We hope you enjoy these video clips of our services and other events.
 You're welcome to stop by in person as well. Please Note: Due to licensing and copyright restrictions,
 some material is not available online.</p>
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
