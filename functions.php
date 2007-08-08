<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: functions.php
Description: Global functions. See each function for a description.

*/

function getextra($page, $datadir) {
	// Get a page's extra <head> and <body> content.
	
	// First, check if the file for the extra stuff even exists.
	if (file_exists($page . ".extra")) {
		// If she do, open it.
		$file = fopen($page . ".extra", "r");
		
		// Read in the extra <body> content.
		$bodyextra = rtrim(fgets($file));
		
		// Now read in the extra header data.
		while (!feof($file)) {
			$headextra = $headextra . fgets($file);
		}
		fclose($file);
		
		// Remove slashes from both $headextra and $bodyextra
		$headextra = stripslashes($headextra);
		$bodyextra = stripslashes($bodyextra);
		
		// Pad $headextra with a final "\n" so the HTML source is more readable
		$headextra = $headextra . "\n";
	}
	
	// Return $bodyextra and $headextra
	return array($bodyextra, $headextra);
}

function getmenu($datadir, $phpfile) {
	// Get the website menu.
	
	// Get some necessary variables out of config.php.
	global $websitemenuidprefix, $websitemenuids, $requestedpage;
	
	// First, make sure that the menu variable is blank.
	$menu = "";
	
	// Check that the file exists...
	if (file_exists($datadir . "menu.inc")) {
		// If it does, open and read the file.
		$pageread = fopen($datadir . "menu.inc", "r");
		while (!feof($pageread)) {
			$currentitem = trim(fgets($pageread));
			// Now check to see if the first two characters of the name are (( (comment) or ** (bullet)
			if (substr($currentitem, 0, 2) == "((" || $currentitem == "") {
				// Comment or blank line, do nothing.
			}
			elseif (substr($currentitem, 0, 2) == "**") {
				// Bullet, remove ** and add a &bull; symbol.
				$currentitem = substr($currentitem, 2, strlen($currentitem) - 2);
				$currentitempath = getpage($currentitem, $datadir);
				$currentitemname = "&bull;&nbsp;" . getpagename($currentitempath);
				$menu = $menu . "<a href=\"" . $phpfile . ".php?page=" . $currentitem . "\"";
				// See if we need to assign an ID.
				if ($websitemenuids == true) {
					$menu = $menu . " id=\"" . $websitemenuidprefix . $currentitem . "\"";
				}
				$menu = $menu . ">" . $currentitemname . "</a>\n";
			}
			elseif (substr($currentitem, 0, 2) == "!!") {
				$currentitem = substr($currentitem, 2, strlen($currentitem) - 2);
				$currentitem = explode("!!", $currentitem);
				$menu = $menu . "<a href=\"" . $currentitem[0] . "\">" . $currentitem[1] . "</a>";
			}
			else {
				// It's normal, be normal.
				$currentitem = explode("|", $currentitem);
				$currentitempath = getpage($currentitem[0], $datadir);
				$currentitemname = getpagename($currentitempath);
				$menu = $menu . "<a href=\"" . $phpfile . ".php?page=" . $currentitem[0] . "\"";
				// See if we need to assign an ID.
				if ($websitemenuids == true) {
					$menu = $menu . " id=\"" . $websitemenuidprefix . $currentitem[0] . "\"";
					
					$menu = $menu . ">" . $currentitemname . "</a>\n";
					
					$currentmenuitem = false;
					foreach($currentitem as $currentsubitem) {
						if ($currentsubitem == $requestedpage) {
							$currentmenuitem = true;
						}
					}
					if ($currentmenuitem == true) {
						if (count($currentitem) > 1) {
							for ($i = 1; $i < count($currentitem); $i++) {
								$currentitempath = getpage($currentitem[$i], $datadir);
								$currentitemname = "&bull;&nbsp;" . getpagename($currentitempath);
								$menu = $menu . "<a href=\"" . $phpfile . ".php?page=" . $currentitem[$i] . "\"";
								// See if we need to assign an ID.
								if ($websitemenuids == true) {
									$menu = $menu . " id=\"" . $websitemenuidprefix . $currentitem[$i] . "\"";
								}
							$menu = $menu . ">" . $currentitemname . "</a>\n";
							}
						}
					}
				}
			}
		}
		fclose($pageread);
	}
	else {
		// If it doesn't, return an error.
		$menu = "Menu file, menu.inc, could not be found!";
	}
	
	// Return the menu contents.
	return $menu;
}

function getpage($page, $datadir) {
	// Get the path of the requested page.
	
	// Get the global variables.
	global $websitedataextension;
	
	$page = trim($datadir . $page . $websitedataextension);
	
	// Return the page path.
	return $page;
}

function getpagename($page) {
	// Get the name of the requested page.
	
	// Open and read the file.
	$pageread = fopen($page, "r");
	$pagename = trim(fgetss($pageread, 1024));
	fclose($pageread);
	
	// Return the page name.
	return $pagename;
}

function listfiles($datadir, $removefolders, $filestoremove, $showresults, $dropdownlist, $dropdownid) {
	// Make $filestoremove an array if there's only one entry (makes things easier later).
	if (count($filestoremove) <= 1) {
		$filestoremove = array($filestoremove);
	}
	// Get the length of the data directory string.
	$datadirlen = strlen($datadir);
	// Get the filenames.
	$filename = glob($datadir . "*");
	for ($i = 0; $i < count($filename); $i++) {
		$folder = is_dir($filename[$i]);
		// Chop $datadir off the filename.
		$filename[$i] = substr($filename[$i], $datadirlen, strlen($filename[$i]) - $datadirlen);
		if ($folder) {
			if (!$removefolders) {
				$filename[$i] = $filename[$i] . " (folder)";
			}
			else {
				unset($filename[$i]);
			}
		}
	}
	
	// Remove files in $filestoremove.
	if (count($filestoremove) >= 1) {
		foreach ($filestoremove as $filetoremove) {
			$filetoremoveindex = array_search($filetoremove, $filename);
			if ($filetoremoveindex !== false) {
				unset($filename[$filetoremoveindex]);
			}
		}
	}
	
	// Are we allowed to echo the results?
	if ($showresults) {
		// Now, are we simply echoing, or are we producing a list?
		if ($dropdownlist) {
			// Let's make lists!
			echo("<select name=\"" . $dropdownid . "\" id=\"" . $dropdownid . "\">\n");
			foreach ($filename as $filename) {
				echo("<option value=\"" . $filename . "\">" . $filename . "</option>\n");
			}
			echo("</select>\n");
		}
		else {
			// Echo... echo... echo...
			foreach ($filename as $filename) {
  				echo($filename . "\n");
			}
		}
	}
	
	return $filename;
}

function listpages($datadir, $pagestoremove, $showresults, $dropdownlist, $dropdownid) {
	global $websitedataextension;
	// Make $pagestoremove an array if there's only one entry (makes things easier later).
	if (count($pagestoremove) <= 1) {
		$pagestoremove = array($pagestoremove);
	}
	// Get the length of the data directory string.
	$datadirlen = strlen($datadir);
	// Get the length of the website data extension string.
	$websitedataextensionlen = strlen($websitedataextension);
	// Get the filenames.
	$filename = glob($datadir . "*" . $websitedataextension);
	for ($i = 0; $i < count($filename); $i++) {
		// Chop $datadir off the filename.
		$filename[$i] = substr($filename[$i], $datadirlen, strlen($filename[$i]) - $datadirlen);
		// Now $websitedataextension.
		$filename[$i] = substr($filename[$i], 0, strlen($filename[$i]) - $websitedataextensionlen);
	}
	
	// Remove files in $pagestoremove.
	if (count($pagestoremove) >= 1) {
		foreach ($pagestoremove as $filetoremove) {
			$filetoremoveindex = array_search($filetoremove, $filename);
			if ($filetoremoveindex !== false) {
				unset($filename[$filetoremoveindex]);
			}
		}
	}
	
	// Make sure that there are entries left.
	if (count($filename) >= 1) {
		// Are we allowed to echo the results?
		if ($showresults) {
			// Now, are we simply echoing, or are we producing a list?
			if ($dropdownlist) {
				// Let's make lists!
				echo("<select name=\"" . $dropdownid . "\" id=\"" . $dropdownid . "\">\n");
				foreach ($filename as $filename) {
					echo("<option value=\"" . $filename . "\">" . $filename . "</option>\n");
				}
				echo("</select>\n");
			}
			else {
				// Echo... echo... echo...
				foreach ($filename as $filename) {
  					echo($filename . "\n");
				}
			}
		}
	}
	else {
		if ($showresults) {
			echo("No pages found!");
		}
	}
	return $filename;
}

function makesafe($unsafestring, $removeslashes, $removeperiods) {
	// Make a string safe. (Remove HTML, etc.)
	
	$safestring = $unsafestring;
	if ($removeslashes) {
		$safestring = str_replace("/", "", $safestring);
	}
	if ($removeperiods) {
		$safestring = str_replace(".", "", $safestring);
	}
	$safestring = htmlspecialchars($safestring);
	$safestring = htmlentities($safestring);
	$safestring = str_replace("http://", "", $safestring);
	$safestring = str_replace("$", "", $safestring);
	$safestring = addslashes($safestring);
	
	// Return the safe path.
	return $safestring;
}

function timerreturn($starttime) {
	$currenttime = microtime();
	$currenttime = explode(" ", $currenttime);
	$currenttime = $currenttime[0] + $currenttime[1];
	$endtime = $currenttime;
	$totaltime = round($endtime - $starttime, 5);
	return $totaltime;
}

?>
