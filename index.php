<html>
    <head>
        <title>
            iSite Mobile Demo
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
            <div class="navBar" id="navMainArea">
                <span id="navMenuTitle">Menu</span>
            </div>
            <div class="container" id="pnlMainArea">
                <div class="content" id="menuMain">
                    <? include ('./menu.php'); ?>
                </div>
            </div>
        </div>
        <div class="panel" id="bodyPanel">
            <div class="navBar" id="navBodyArea">
                <a id="btnBack" href="javascript:loadContent (returnTo.pop(), updateMainMenu, 'slideBack')" class="button back black"><span></span>Back</a>
                <a id="btnMenu" href="javascript:toggleMenu ()" class="button black">Menu</a>
                <span id="navSiteTitle">Sample Church of the Nazarene</span><span id="navSiteBullet"> &bull; </span><span id="navBodyTitle">Home</span>
            </div>
            <div class="container"  id="pnlBodyArea">
                <!-- this to be replaced by content at startup -->
            </div>
        </div>
        <div id="loader">
            <div>
                Loading...<br>
                <img src="./images/ajax-loader.gif" alt="Loading"/>
            </div>
        </div>
        <script>
        
            // startup variables
            var mySiteName = "Sample Church of the Nazarene";
            var myMenuName = "My Mobile Church";
            var myStartPage = "./home.php";
            var myStartName = "Home";
        
            startApp( ); // tell our app to start
        </script>
    </body>
</html>