<div class="content">

    <img class="imgLeft" src='http://a3.mzstatic.com/us/r30/Podcasts/4d/df/1d/dj.fkhlbrem.170x170-75.jpg' width=48 height=48 width=200px />
    <h1>Available Podcasts</h1>
    <p>The following shows an example iTunes feed showing the most recent episodes for a podcast. Note: not working for all feeds yet.</p>
    <div style="clear: both" class="listGroup" id="lstStream">
       Loading...
    </div>

    <p style="text-align: right;"><a href="http://itunes.apple.com/podcast/this-week-in-radio-tech-video/id435030225">View in iTunes...</a></p>
    <br><br><br>

    <script>        
        var mypodcast = new podcastStream ( 'mypodcast', 'http://feeds.twit.tv/twit_video_small',
                                            '<a class="listItem arrow" style="max-height:4em; overflow: hidden; clear:both; font-weight: normal; position: static;" href="javascript:loadContent(\'./playVideo.php?uri=%MEDIA:URL%&img=http://a3.mzstatic.com/us/r30/Podcasts/4d/df/1d/dj.fkhlbrem.170x170-75.jpg\',updateMainMenu,\'slideOut\', \'./podcasts.php\')"><img height=89 width=89 border=0 src="http://a3.mzstatic.com/us/r30/Podcasts/4d/df/1d/dj.fkhlbrem.170x170-75.jpg"/><div style="max-height:3em; overflow: hidden;">%TITLE%<br>%TEXT%</div> <span class="minor floatLeft">About %MEDIA:LENGTH% minutes</span> <span class="minor floatRight">Published %TIME% ago</span></a>',
                                            'lstStream', "mp4" );
        mypodcast.loadpodcast( 10 );
    </script>

</div>
