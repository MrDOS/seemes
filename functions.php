<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
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
		
		// Get the page theme (if any).
		$pagetheme = rtrim(fgets($file));
		
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
	return array($bodyextra, $pagetheme, $headextra);
}

function getmenu($datadir, $phpfile) {
	// Get the website menu.
	
	// Get some necessary variables out of config.php.
	global $websitemenucurrentitem, $websitemenuformatting, $websitemenuindent, $requestedpage;
	
	// First, make sure that the menu variable is blank.
	$menu = "";
	
	// Set the item number counter.
	$menuitems = 0;
	
	// Check that the file exists...
	if (file_exists($datadir . "menu.inc")) {
		// If it does, open and read the file.
		$pageread = fopen($datadir . "menu.inc", "r");
		while (!feof($pageread)) {
			// Read in the current item.
			$currentitemraw = trim(fgets($pageread));
			
			// Now, parse the current item(s).
			
			// First, we reset all the menu variables to blank, just to be on the safe side.
			$currentitemhref = array("");
			$currentitemid = array("");
			$currentitemname = array("");
			
			// Split the item up by |'s right from the start. This allows us to use extra controls on menu sub-items.
			$currentitemraw = explode("|", $currentitemraw);
			
			// See if we should be doing sub-items at all.
			$showsubitems = false;
			foreach ($currentitemraw as $currentsubitem) {
				$currentsubitem = explode("#", $currentsubitem);
				$currentsubitem = $currentsubitem[0];
				if ($currentsubitem == $requestedpage) {
					$showsubitems = true;
				}
			}
			
			// Teh numero counter.
			for ($i = 0; $i < count($currentitemraw); $i++) {
				// Add one to the item number counter.
				$menuitems++;
				
				// If the counter is greater than 0, we want to display a bullet first.
				if ($i > 0) {
					$currentitemname[$i] = $websitemenuindent;
				}
				
				// This if only lets us past if the counter is less than 1 or if we're allowed to show sub-items.
				if ($i < 1 || $showsubitems) {
					// Split it into two peices (one for the main page name, one for the in-page link (if any).
					$currentitemsplit = explode("#", $currentitemraw[$i]);
					// Put the current item in its own variable.
					$currentitem[$i] = trim($currentitemsplit[0]);
					// Put the in-page link in its own variable.
					$currentiteminlink[$i] = trim($currentitemsplit[1]);
					
					// Is it a comment or a blank line?
					if (substr($currentitem[$i], 0, 2) == "((" || $currentitem[$i] == "") {
						// It is - do nothing.
					}
					// Okay, is it a bullet?
					elseif (substr($currentitem[$i], 0, 2) == "**") {
						// Yes. Replace the ** with &bull;.
						$currentitem[$i] = substr($currentitem[$i], 2, strlen($currentitem[$i]) - 2);
						$currentitempath = getpage($currentitem[$i], $datadir);
						$currentitemname[$i] = $currentitemname[$i] . "&bull;&nbsp;" . getpagename($currentitempath);
						$currentitemhref[$i] = $phpfile . ".php?page=" . $currentitem[$i];
						$currentitemid[$i] = strtolower(str_replace(" ", "", $currentitem[$i]));
					}
					// Is it an absolute link?
					elseif (substr($currentitem[$i], 0, 2) == "!!") {
						$currentitem[$i] = substr($currentitem[$i], 2, strlen($currentitem[$i]) - 2);
						$currentitem[$i] = explode("!!", $currentitem[$i]);
						if ($currentitem[$i][1] != "") {
							$currentitemhref[$i] = $currentitem[$i][0];
							$currentitemname[$i] = $currentitemname[$i] . $currentitem[$i][1];
						}
						else {
							$currentitemhref[$i] = $currentitem[$i][0];
							$currentitemname[$i] = $currentitemname[$i] . $currentitem[$i][0];
						}
						$currentitemid[$i] = strtolower(str_replace(" ", "", $currentitemname[$i]));
					}
					// Or is it just plain and normal?
					else {
						// Oh goodie! However, we do have to check to see whether we're dealing with page-specific menu items or not, too...
						
						// Do the first item.
						$currentitemsimplename[$i] = $currentitem[$i];
						$currentitempath = getpage($currentitem[$i], $datadir);
						$currentitemname[$i] = $currentitemname[$i] . getpagename($currentitempath);
						$currentitemhref[$i] = $phpfile . ".php?page=" . $currentitem[$i];
						$currentitemid[$i] = strtolower(str_replace(" ", "", $currentitem[$i]));
					}
				}
			}
			
			// Alrighty. Now, let's throw together the menu entry - providing it's not blank, of course.
			if ($currentitemhref[0] != "" && $currentitemname[0] != "" && $currentitemid[0] != "") {
				// Set up a loop for the generation. This is really only used for page-specific menus.
				for ($i = 0; $i < count($currentitemhref); $i++) {
					if ($currentiteminlink[$i] != "") {
						$currentitemhref[$i] = $currentitemhref[$i] . "#" . $curreniteminlink[$i];
					}
					
					$currentitemfinal = $websitemenuformatting;
					$currentitemfinal = str_replace("%menuhref%", $currentitemhref[$i], $currentitemfinal);
					$currentitemfinal = str_replace("%menuid%", $currentitemid[$i], $currentitemfinal);
					$currentitemfinal = str_replace("%menuname%", $currentitemname[$i], $currentitemfinal);
					$currentitemfinal = str_replace("%menunumber%", $menuitems, $currentitemfinal);
					if ($currentitemsimplename[$i] == $requestedpage) {
						$currentitemfinal = str_replace("%menucurrentitem%", $websitemenucurrentitem, $currentitemfinal);
					}
					else {
						$currentitemfinal = str_replace("%menucurrentitem%", "", $currentitemfinal);
					}
					
					$menu = $menu . $currentitemfinal;
				}
			}
		}
		fclose($pageread);
	}
	else {
		// If it doesn't, return an error.
		$menu = "The menu file, menu.inc, could not be found!";
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
