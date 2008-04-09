<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
Filename: login.php
Description: Login.

*/

// Start the load timer. This goes here, instead of in functions.php, to get a more accurate load time.
$currenttime = microtime();
$currenttime = explode(" ", $currenttime);
$currenttime = $currenttime[0] + $currenttime[1];
$starttime = $currenttime;

// Include Seemes configuration and functions
include("config.php");
include("functions.php");

// Start the session
session_start();

// Get the given password
$loginpassword = $_POST["loginpassword"];

// Now generate the SHA-1 hash.
$loginpassword = sha1($loginpassword);

// Check if the password matches the correct one
if ($loginpassword == $websitepassword) {
   // Good password, set the session value...
   $_SESSION["seemeslogin"] = $websitepassword;
   
   // Set the page path and name
   $page = $websiteactiondir . "goodlogin" . $websitedataextension;
   $pagename = "You have been logged in";
}
else {
   // Set the page path and name
   $page = $websiteactiondir . "badlogin" . $websitedataextension;
   $pagename = "Bad login";
}

// Set the extra <head> content...
$headextra = "<meta http-equiv=\"refresh\" content=\"3; URL=" . $websiteadminindex . ".php\" />\n";

// Now include the theme...
include($websitethemedir . $websitetheme);

?>