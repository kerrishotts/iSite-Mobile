iSite Mobile, version 0.2 alpha
==========================================================

    Author: Kerri Shotts (photoKandy Studios LLC)
    Created: March 2011
    Updated: January 2012
    License: Creative-Commons SSA+Attribution (commercial use is permitted)
       Note: the demo portions are (C) photoKandy Studios.


The goal of this project is to make it easier to design mobile websites that look, act,
and feel as if they are native applications on iDevices. In order to accomplish this,
there is a framework of HTML, Javascript, and CSS that defines the site layout, the
functionality, and the look.

Currently the project is attached to the demo pages; but they can be easily replaced
or used as examples in order to facilitate your own design. Please do not use them
verbatim in your project as those particular contents are (C) 2012 photoKandy Studios LLC.

The actual parts of the framework include the "index.html" page as well as the "ios.js" script
in the "scripts" directory, and all related "ipad" and "iphone" and "ios" CSS files. The rest
is intended as example only. At some point this will need to be split into two separate
trees or removed entirely and replaced with an adequate demo project.

Documentation
==========================================================

The following documentation is subject to change without notice as the framework is under
active development.

index.html
----------------------------------------------------------

This page serves as the homepage for your site. It does not actually contain any content;
your content will exist in pages that will be loaded into the site via AJAX. What it does
contain, however, is the layout and framework support for your site.

The layout of the index page looks something like this (pardon the ASCII-style graphics):

    +--------------------------+------------------------------------------------------+
    |        Menu NavBar       | [BACK] [MENU]               Title                    |
    +--------------------------+------------------------------------------------------+
    |                          |                                                      |
    | Menu Item 1            > | Page Content loaded via AJAX                         |
    |                          |                                                      |
    | Menu Item 2            > | The content is loaded from pages like news.html, and  |
    |                          | can contain javascript or be rendered.html.           |
    :                          :                                                      :
    |                          |                                                      |
    +--------------------------+------------------------------------------------------+
    
    TODO: bottom-level toolbar feature

The above layout is used *even when* the iDevice is not in a landscape mode. Instead CSS
and JavaScript is used to turn on/off the relevant parts of the interface. When an iPad
is rotated into portrait mode, the "Menu NavBar" portion is hidden, and the "Menu" button
appears on the NavBar. When it is clicked, the left sidebar will appear as a floating
popup menu, just like in native applications.

Likewise, for iPhone devices, the same layout is used, though the left-hand sidebar is
permanently hidden and only the right-hand content area is used.

For content that should or should not appear on certain devices, there are special CSS
classes that can be used to hide or show content based upon the orientation and type of
device.

### body ###

The *body* of the document is named "pnlBody", and includes an *ontouchmove* event that
prevents accidental scrolling of the entire document (which will give away the fact that
we aren't native). It is also classed, by default, with "ipad" and "landscape", though
this will be modified after all the content is loaded to be the appropriate device and
orientation. It is through these two classes that the CSS files target and modify the
layout and look-and-feel of the site.

####Left-hand Panel ####

The left-hand panel is where the menu and primary navigation of the site lives when
viewed on an iPad. (iPhones never see this panel.) It is named "menuPanel", and has
a class of "panel". In general you shouldn't use panels too often as they assume that
they have full rights to their containing object; the ony reason this particular panel
doesn't is that there is CSS to constrain its width.

Within the left-hand panel there is a DIV classed "navBar". This class denotes that the
DIV is to be placed at the top of its surrounding panel and that it should look like an
iDevice NavBar. In the left-hand panel, it only needs to contain the name of the menu
unless one intends on supporting nested menus.

After the navBar is a DIV classed "container" and named "pnlMainArea". Within this DIV
resides the actual main menu. Any content is technically allowed, such as images, but
the primary inhabitant is a DIV classed "navSubItemGroup" with Anchors inside classed
"navSubItem". CSS will target these and apply the appropriate iDevice look-and-feel.

Each Anchor must specify the title of the page to which it is linking as well as have
javascript attached in the HREF to load the content. For example:

    <a title="Contact" href="javascript:loadcontent('./contact.html', updateMainMenu);"
       class="navSubItem">Contact Us</a>
       
The *loadContent* function will, when invoked, load the contents of the page requested
(in this case, contact.html) and when complete call *updateMainMenu* in order to update
the main menu's selected item. (It should be noted that no callback must be specified,
but it is highly suggested.)

####Right-Hand Panel####

The right-hand panel is the primary content area and is structured similarly to the
left-hand panel. It is named "bodyPanel" and has a DIV classed "navBar" inside. This
particular navBar is named "navBodyArea" (and must be, since there is Javascript that
acts upon it). It also contains the back and menu buttons as well as the site and page
title SPANs that can be modified by the Javascript. The back and menu buttons will
hide or show appropriately based upon the orientation of the device and type of device.

Below the navBar is a DIV classed "container" and named "pnlBodyArea" -- it is in to this
DIV that content is loaded by *loadContent()*. Therefore there should be **no** content
in your index.html page beyond the main menu; the rest will be loaded dynamically.

####Loading Spinner####

The framework has a built in function to turn on a loading animation when a page load
seems to be taking a little longer than normal. In general, if a page loads within 100ms
the animation never appears. If it takes longer, however, the framework will display the
DIV named "loader" which contains the loading animation. There is a maximum time this
will be displayed (currently 10 seconds), after which it disappears to permit other
work within the app.

####startApp()####

The *startApp()* function is called at the end of the page in order to kick everything
off. It will load the first page dynamically and also initialize the interface for the
appropriate orientation and iDevice.

CSS
---------------------------------

All the CSS for the project is located in the "style" directory. There are several
files that control the look and feel of the site.

 * *ios.css* is the primary stylesheet. Defines the base look and feel of just about
 everything that should look like an iOS widget (buttons, lists, etc.)
 * *ipad.css* defines any overrides that are applied only to iPads in any orientation.
 * *ipad-landscape.css* defines overrides that are applied to iPads in landscape mode.
 * *ipad-portrait.css* defines overrides that are applied to iPads in portrait mode.
 * *iphone.css* defines overrides that are applied only when simulating an iPhone interface.
 * *iphone-landscape.css* defines any overrides that are applied to an iPhone in landscape mode.
 * *iphone-portrait.css* defines any overrides that are applied to an iPhone in portrait mode.
 
In general, the *-landscape* and *-portrait* sheets control layout (such as width and height) as
well as the display (or hiding) of elements.

There is also the opportunity for further overrides to accomplish certain "looks", called "skins".
For example, the *glossy-black.css* file overrides the entire look to provide a glossy black look
that some applications use. Without it, the interface looks like a standard iDevice's interface.

ios.js
------------------------------------

Welcome to the primary driver of the application. It provides support for orientation changes,
device detection, menu toggling, AJAX content loading, and more.

The following functions are provided:

 * *$(id)*: returns a DOM element with named *id*. Note: if you intend on using JQuery, remove
 this function first!
 * *_resetSB(which)*: Resets the scrollbar specified by *which*. *Which* can be 0 or 1 where 0 is the menu scrollbar and 1 is the body scrollbar.
 * *resetSB(which)*: Calls *_resetSB* after 125ms via setTimeout.
 * *destroySB(which)*: Destroys the specified scrollbar.
 * *isIPad()*, *isIPhone()*: returns TRUE if the device is running on the requested device.
 * *isPortrait()*, *isLandscape()*: returns TRUE if the device is in the requested orientation.
 * *BlockMove(event)*: Ensures that no scrolling of the document window will occur. See [this page][1]
 for more information.
 * *processScriptTags(id)*: after an AJAX load of content, this function is called in order to add any
 SCRIPT tags to the DOM so that they can execute. [See this page][2] for more information.
 * *updateOrientation()*: This function is called whenever the device's orientation is changed, or
 when the site has just finished loading. It detects the device and its orientation and sets the
 BODY classes to match, which forces the device-specific CSS to take effect. A little more work
 is done to ensure that the left-hand menu is in the correct state for iPads. (It should be hidden in
 portrait mode, visible in landscape mode.)
 * *toggleMenu()*: Turns the menu panel on and off. Assumes it is named "menuPanel". In general, this
 is invoked by pressing the "menu" button in portrait mode on an iPad.
 * *showLoader()*, *hideLoader()*: Shows/hides the loading animation. *showLoader* creates a timeout of 10s that calls *hideLoader* in the event nothing ever calls *hideLoader* manually. (For example, an AJAX call times out.)
 * *loadContent(url, callback, animate, backTo)*: loads the content specified by *url* into the
 main content area. When it is complete, *callback* is called in order to do any work (like updating
 selected items). The *animate* and *backTo* functions work together when forming a chain of
 navigation; using *animate=slideOut* will slide the old content out first and replace it with the
 incoming content. *backTo* is used to indicate which page should be the previous page when the user
 clicks "Back" on the NavBar. It should be noted that this technically puts the return page on a
 stack, so the history of the navigation chain can be as deep as desired. It is, however, cleared
 out when both *animate* and *backTo* are empty. The AJAX function uses code obtained [from here][3].
 * *updateMainMenu(url, title)*: is used to update the main menu (named "grpMainMenu") to indicate
 which item is currently selected. It does this by comparing the incoming *url* with the URL in the
 HREF of each anchor within the menu item group. If *title* is passed, the SPAN named "navBodyTitle"
 will be updated to reflect the title of the page, otherwise it will be obtained from the title
 attribute of the selected menu item.
 * *loadMenu (url, callback)*: is used to load the menu portion of the page. Typically this is ./menu.html and doesn't change, but it could be changed dynamically.
 * *setPageTitle (title)*: sets the content of SPAN named "navBodyTitle" to *title*. Primarily used
 for pages that are in deep level navigation chains.
 * *setSiteTitle (title)*: sets the content of SPAN named "navSiteTitle" to *title*. Primarily used only once at App startup.
 * *setMenuTitle (title)*: sets the content of SPAN named "navMenuTitle" to *title*. Primarily used only once at App startup, *or* if the menu should be changed.
 * *loaded()*: is called when the DOM is ready. It includes the necessary work to start up the
 application.
 * *resetContentScrollBar()*: is a utility function that does a resetSB(1).
 * *startApp()*: is called intentionally at the end of the index.html page. It adds some event
 listeners to detect DOM readiness and orientation changes.
 
utility.js
----------------------------------------------------
Utility functions.

The following functions are useful:
 * *ago (str)*: is a utility that returns how long ago *str* (which is a date) occurred, in a Twitter-like format. [See this page][4] for more.
 
twitterStream.js
----------------------------------------------------
Simple Twitter object that returns up to 200 tweets given a user's ID. Use as seen in /tweets.html.

podcastList.js
----------------------------------------------------
Simple Podcast object that parses a podcast feed and generates an iTunes-like list. Use as seen in /podcasts.html. **NOTE**: You must provide your own Google API key.

gplusStream.js
----------------------------------------------------
Simple Google+ object that returns posts for a given user. Use as seen in /gplus.html. **NOTE**: You must provide your own Google API key.


 [1]: http://matt.might.net/articles/how-to-native-iphone-ipad-apps-in-javascript/
 [2]: http://bytes.com/topic/javascript/answers/513633-innerhtml-script-tag
 [3]: http://www.tek-tips.com/viewthread.cfm?qid=1622697&page=13
 [4]: http://stackoverflow.com/questions/6456856/converting-2011-06-23t1320120000-to-time-ago