<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: admin.php
Description: Administrator index file.

*/

// Start the load timer. This goes here, instead of in functions.php, to get a more accurate load time.
$currenttime = microtime();
$currenttime = explode(" ", $currenttime);
$currenttime = $currenttime[0] + $currenttime[1];
$starttime = $currenttime;

// Include Seemes configuration and functions
require("config.php");
require("functions.php");

// Start the session
session_start();

// Check if the user is logged in and if the password is correct
if (isset($_SESSION["seemeslogin"]) && $_SESSION["seemeslogin"] == $websitepassword) {
   // Get the requested page, first checking if a value for "page" was passed
   $page = makesafe($_GET["page"], true, true);
   $requestedpage = $page;
   
   // Check if $page is blank. If so, use the default page.
   if ($page == "") {
      $page = $websitedefaultpage;
   }
   
   // Now get the page path
   $page = getpage($page, $websiteadmindir);
   
   // If the requested page doesn't exist, use the error message.
   if (!file_exists($page)) {
      $page = $websiteerrorpage;
   }
   
   // And get the extras.
   $extras = getextra($page, $websiteadmindir);
   $bodyextra = $extras[0];
   $headextra = $extras[1];
   
   // Get the menu
   $menu = getmenu($websiteadmindir, $websiteadminindex);
}
else {
   // Set $page to the login page...
   $page = "login.inc";
   
   // Get the menu
   $menu = getmenu($websitedatadir, $websiteindex);
}

   
// Get the name of the page
$pagename = getpagename($page);

// Finally, include the theme.
include($websitethemedir . $websitetheme);

?>