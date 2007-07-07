<?

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: install2.php
Description: Seemes CMS installation processor.

*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Seemes CMS - Installation</title>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
<style type="text/css">
<!--
html {
	background-color: #ffffff;
	color: #000000;
	font-family: "Trebuchet MS", sans-serif;
	font-size: 11pt;
}
-->
</style>
</head>
<body>
<h1>Seemes CMS - Installation</h1>
<?php

include("functions.php");

$gplagree = $_POST["gplagree"];
$websitename = trim(stripslashes($_POST["websitename"]));
$websitecopyright = trim(stripslashes($_POST["websitecopyright"]));
$websitetheme = trim(stripslashes($_POST["websitetheme"]));
$websitepassword = $_POST["websitepassword"];
$websitepasswordverify = $_POST["websitepasswordverify"];

if (!file_exists("config.php")) {
	if ($gplagree != "on") {
		echo("<p>You haven't agreed to the GNU General Public Licence version 2. If you don't agree, we're very sorry. If you just didn't click the checkbox, click the Back button to try again.</p>");
	}
	else {
		if (strlen($websitename) == 0 && strlen($websitecopyright) == 0 && strlen($websitetheme) == 0 && strlen($websitepassword) == 0 && strlen($websitepasswordverify) == 0) {
		echo("<p><b>Error:</b> Dude, you haven't entered anything! Click the Back button to try again.</p>");
		}
		else {
			if (!$websitepassword == $websitepasswordverify) {
				echo("<p><b>Error:</b> Passwords did not match!</p>");
			}
			elseif (strlen($websitepassword) < 6) {
				echo("<p><b>Error:</b> The provided password is not long enough! Your password must be 6 characters or longer.</p>");
			}
			elseif (strlen($websitename) == 0) {
				echo("<p><b>Error:</b> You haven't provided a name for your website!</p>");
			}
			elseif (strlen($websitetheme) == 0) {
				echo("<p><b>Error:</b> You must specify a theme!</p>");
			}
			elseif (!file_exists("themes/" . $websitetheme)) {
				echo("<p><b>Error:</b> The specified theme file does not exist!</p>");
			}
			else {
				if (strlen($websitecopyright) == 0) {
					echo("<p><b>Warning:</b> You haven't entered a website copyright.</p>");
				}
				$websitepassword = sha1($websitepassword);
				$configfile = fopen("config.php", "w");
				$write = fwrite($configfile, "<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: config.php
Description: Seemes configuration file.

*/

\$seemesversion = \"0.2\"; // Seemes version number
\$websiteactiondir = \"actions/\"; // The actions data folder. MUST HAVE LEADING SLASH!
\$websiteadmindir = \"admin/\"; // The admin data folder. MUST HAVE LEADING SLASH!
\$websiteadminindex = \"admin\"; // The main admin PHP file.
\$websitecopyright = \"" . $websitecopyright . "\"; // The website copyright
\$websitedatadir = \"data/\"; // The website data folder. MUST HAVE LEADING SLASH!
\$websitedataextension = \".txt\"; // File extension for the data files. Period needed.
\$websitedefaultpage = \"home\"; // The filename of the default page. No extension.
\$websiteerrorpage = \"error.inc\"; // The default error page (404).
\$websiteheadersize = \"2\"; // Size of page title headers.
\$websiteindex = \"index\"; // The main PHP file.
\$websitemenuidprefix = \"menu\"; // The prefix for each menu item's ID. This will be followed by the page filename, if $websitemenuids is true. (If $websitemenuids is false, this does nothing.)
\$websitemenuids = true; // Turns menu item ID's on or off.
\$websitename = \"" . $websitename . "\"; // The name of the site.
\$websitepassword = \"" . $websitepassword . "\"; // The admin password, SHA-1 encrypted (default \"password\")
\$websiteuploaddir = \"files/\"; // The folder for uploads. MUST HAVE LEADING SLASH!
\$websitetheme = \"" . $websitetheme . "\"; // The php file for the the template you want to use.
\$websitethemedir = \"themes/\"; // The theme directory.

?>");
				fclose($configfile);
				if ($write) {
					echo("<p>Installation successful! Click <a href=\"index.php\">here</a> to view the site.</p>");
					echo("<p><b>Please note:</b> It is highly recommended that you delete the files <code>install.php</code> and <code>install2.php</code> for security reasons.</p>");
					echo("<p><b>Please note:</b> For Seemes to actually function, you need to FTP into your site and CHMOD the folders <code>data/</code> and <code>files/</code> 777, and the contents of <code>data/</code> as 666.</p>");
				}
				else {
					echo("<p>The configuration file could not be written, installation was not successful!</p>");
				}
			}
		}
	}
}
else {
	echo("<p>Seemes CMS has already been installed! To reinstall, please delete <code>config.php</code>.</p>");
}

?>
</body>
</html>