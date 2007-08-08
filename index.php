<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: index.php
Description: Index file.

*/

// Start the load timer. This goes here, instead of in functions.php, to get a more accurate load time.
$currenttime = microtime();
$currenttime = explode(" ", $currenttime);
$currenttime = $currenttime[0] + $currenttime[1];
$starttime = $currenttime;

if (!file_exists("config.php")) {
	exit("<code>config.php</code> could not be found! Have you run <a href=\"install.php\">the installer</a>?");
}

// Include Seemes configuration and functions.
require("config.php");
require("functions.php");

// Get the requested page, first checking if a value for "page" was passed.
$page = makesafe($_GET["page"], true, true);
$requestedpage = $page;

// Check if $page is blank. If so, use the default page.
if ($page == "") {
   $page = $websitedefaultpage;
}

// Now get the page path.
$page = getpage($page, $websitedatadir);

// If the requested page doesn't exist, use the error message.
if (!file_exists($page)) {
   $page = $websiteerrorpage;
}

// Get the name of the page.
$pagename = getpagename($page);

// Get the extras.
$extras = getextra($page, $websitedatadir);
$bodyextra = $extras[0];
$headextra = $extras[1];

// Get the menu
$menu = getmenu($websitedatadir, $websiteindex);

// Finally, include the theme.
include($websitethemedir . $websitetheme);

?>