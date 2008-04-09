<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
Filename: action.php
Description: Actionator-thingie.

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

// Check that the password in the cookie is good
if ($_SESSION["seemeslogin"] == $websitepassword) {
	$action = makesafe($_POST["action"], true, true);
	$requestedaction = $action;
	if ($action == "changesettings") {
		$page = $websiteactiondir . "changesettings" . $websitedataextension;
		$pagename = "Changing settings...";
	}
	elseif ($action == "createpage") {
		$page = $websiteactiondir . "createpage" . $websitedataextension;
		$pagename = "Creating page...";
	}
	elseif ($action == "deletepage") {
		$page = $websiteactiondir . "deletepage" . $websitedataextension;
		$pagename = "Deleting page...";
	}
	elseif ($action == "editmenu") {
		$page = $websiteactiondir . "editmenu" . $websitedataextension;
		$pagename = "Editing menu...";
	}
	elseif ($action == "editpage") {
		$page = $websiteactiondir . "editpage" . $websitedataextension;
		$pagename = "Editing page...";
	}
	elseif ($action == "logout") {
		$page = $websiteactiondir . "logout" . $websitedataextension;
		$pagename = "Logging out...";
	}
	elseif ($action == "movepage") {
		$page = $websiteactiondir . "movepage" . $websitedataextension;
		$pagename = "Moving page...";
	}
	elseif ($action == "uploadfile") {
		$page = $websiteactiondir . "uploadfile" . $websitedataextension;
		$pagename = "Uploading file...";
		
		$uploaddir = $_POST["uploaddir"];
		if ($uploaddir != $websiteuploaddir && $uploaddir != $websiteimagedir) {
			$uploaddir = $websiteuploaddir;
		}
		if ($uploaddir == $websiteimagedir) {
			$action = "image";
		}
		else {
			$action = "file";
		}
	}
	elseif ($action == "deletefile") {
		$page = $websiteactiondir . "deletefile" . $websitedataextension;
		$pagename = "Deleting file...";
		
		$deletedir = $_POST["deletedir"];
		if ($deletedir != $websiteuploaddir && $deletedir != $websiteimagedir) {
			$deletedir = $websiteuploaddir;
		}
		if ($deletedir == $websiteimagedir) {
			$action = "image";
		}
		else {
			$action = "file";
		}
	}
	elseif ($action == "movefile") {
		$page = $websiteactiondir . "movefile" . $websitedataextension;
		$pagename = "Moving file...";
		
		$movedir = $_POST["movedir"];
		if ($movedir != $websiteuploaddir && $movedir != $websiteimagedir) {
			$movedir = $websiteuploaddir;
		}
		if ($movedir == $websiteimagedir) {
			$action = "image";
		}
		else {
			$action = "file";
		}
	}
	elseif ($action == "edittheme") {
		$page = $websiteactiondir . "edittheme" . $websitedataextension;
		$pagename = "Editing theme...";
	}
	else {
		$page = $websiteactiondir . "badaction" . $websitedataextension;
		$pagename = "Bad action!";
		$action = "home";
	}
}
else {
	$page = $websiteactiondir . "notloggedin" . $websitedataextension;
	$pagename = "Not logged in!";
	$action = "home";
}

// Set the extra <head> content...
$headextra = "<meta http-equiv=\"refresh\" content=\"3; URL=" . $websiteadminindex . ".php?page=" . $action . "\" />\n";

// Now include the theme...
include($websitethemedir . $websitetheme);

?>
