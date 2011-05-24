<html>
    <head>
        <title>
            Godfrey Church of the Nazarene (Mobile)
        </title>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
        
        <link type="text/css" rel="stylesheet" href="./style/ios.css">

        <link type="text/css" rel="stylesheet" href="./style/ipad.css">
        <link type="text/css" rel="stylesheet" href="./style/ipad-landscape.css">
        <link type="text/css" rel="stylesheet" href="./style/ipad-portrait.css">

        <link type="text/css" rel="stylesheet" href="./style/iphone.css">
        <link type="text/css" rel="stylesheet" href="./style/iphone-landscape.css">
        <link type="text/css" rel="stylesheet" href="./style/iphone-portrait.css">
<?
    if ($_REQUEST["skin"] == "black")
    {
        echo '<link type="text/css" rel="stylesheet" href="./style/glossy-black.css">';
    }
?>

        <script type="application/javascript" src="./script/ios.js"></script>
        <script type="application/javascript" src="./script/iscroll-min.js"></script>
    </head>
    <body class="ipad landscape" id="pnlBody" ontouchmove="BlockMove(event);">
        <div class="panel" id="menuPanel">
            <div class="navBar">
                My Mobile Church
            </div>
            <div class="container" id="pnlMainArea">
                <div class="content" id="menuMain">
                    <img src="./images/church326.jpg" width=100% />
                    <h2>Navigation</h2>
                    <div class="navSubItemGroup" id="grpMainMenu" >
                        <a id="mnuMainHome"       title="Home"       href="javascript:loadContent('./home.php', updateMainMenu );"       class="navSubItem sel"><img src="./images/tabsfreecolor/Circle-Info.png"> Home</a>
                        <a id="mnuMainNews"       title="News"       href="javascript:loadContent('./news.php', updateMainMenu );"       class="navSubItem"><img src="./images/tabsfreecolor/RSS-Alternative.png"> News &amp; Events</a>
                        <a id="mnuMainMinistries" title="Ministries" href="javascript:loadContent('./ministries.php', updateMainMenu );" class="navSubItem"><img src="./images/tabsfreecolor/Heart.png"> Ministries</a>
                        <a id="mnuMainPodcasts"   title="Podcasts"   href="javascript:loadContent('./podcasts.php', updateMainMenu );"   class="navSubItem"><img src="./images/tabsfreecolor/Music.png"> Podcasts</a>
                        <a id="mnuMainTweets"     title="Tweets"     href="javascript:loadContent('./tweets.php', updateMainMenu );"     class="navSubItem"><img src="./images/tabsfreecolor/Twitter.png"> Latest Tweets</a>
                        <a id="mnuMainFacebook"   title="Facebook"   href="javascript:loadContent('./facebook.php', updateMainMenu );"   class="navSubItem"><img src="./images/tabsfreecolor/Facebook.png"> Our Facebook Page</a>
                        <a id="mnuMainContact"    title="Contact"    href="javascript:loadContent('./contact.php', updateMainMenu );"    class="navSubItem"><img src="./images/tabsfreecolor/Chat-Bubble.png"> Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel" id="bodyPanel">
            <div class="navBar" id="navBodyArea">
                <a id="btnBack" href="javascript:loadContent (returnTo.pop(), updateMainMenu, 'slideBack')" class="button back black"><span></span>Back</a>
                <a id="btnMenu" href="javascript:toggleMenu ()" class="button black">Menu</a>
                <span id="navSiteTitle">Sample Church of the Nazarene &bull; </span><span id="navBodyTitle">Home</span>
            </div>
            <div class="container"  id="pnlBodyArea">
                <? include ('./home.php'); ?>
            </div>
        </div>
        <div id="loader">
            <div>
                Loading...<br>
                <img src="./images/ajax-loader.gif" alt="Loading"/>
            </div>
        </div>
        <script>
            startApp( ); // tell our app to start and load the Podcasts Page.
        </script>
    </body>
</html>