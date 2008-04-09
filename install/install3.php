<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
Filename: install3.php
Description: Seemes CMS installation; stage #3: write files.

*/

if (file_exists("../config.php")) {
	die("Seemes has already been installed!");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Seemes CMS 0.4 - Installation</title>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="main">
<h1>Seemes CMS 0.4 - Installation</h1>
<div class="stepbox"><em>Step 1</em><br />Permissions Check</div>
<div class="stepbox"><em>Step 2</em><br />Gather information</div>
<div class="stepbox currentstep"><em>Step 3</em><br />Writing files</div>
<br style="clear: both;" />
<h2>Writing files</h2>
<?php

$gplagree = $_POST["gplagree"];
$websitename = trim(str_replace("\"", "\\\"", stripslashes($_POST["websitename"])));
$websitecopyright = trim(str_replace("\"", "\\\"", stripslashes($_POST["websitecopyright"])));
$websitetheme = trim(stripslashes($_POST["websitetheme"]));
$websitepassword = $_POST["websitepassword"];
$websitepasswordverify = $_POST["websitepasswordverify"];

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
		elseif (!file_exists("../themes/" . $websitetheme)) {
			echo("<p><b>Error:</b> The specified theme file does not exist!</p>");
		}
		else {
			if (strlen($websitecopyright) == 0) {
				echo("<p><b>Warning:</b> You haven't entered a website copyright. You can fix this later in the Admin Control Panel.</p>");
			}
			$websitepassword = sha1($websitepassword);
			echo("<p>Writing configuration file... ");
			$configfile = fopen("../config.php", "w");
			$writeconfig = fwrite($configfile, "<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 MagicWare
Filename: config.php
Description: Seemes configuration file.

*/

\$seemesversion = \"0.4\"; // Seemes version number
\$websiteactiondir = \"actions/\"; // The actions data folder. MUST HAVE LEADING SLASH!
\$websiteadmindir = \"admin/\"; // The admin data folder. MUST HAVE LEADING SLASH!
\$websiteadminindex = \"admin\"; // The main admin PHP file.
\$websitecopyright = \"" . $websitecopyright . "\"; // The website copyright
\$websitedatadir = \"data/\"; // The website data folder. MUST HAVE LEADING SLASH!
\$websitedataextension = \".txt\"; // File extension for the data files. Period needed.
\$websitedefaultpage = \"home\"; // The filename of the default page. No extension.
\$websiteerrorpage = \"error.inc\"; // The default error page (404).
\$websiteheaderpretext = \"<h2>\"; // Pre-page header HTML.
\$websiteheaderposttext = \"</h2>\\n\"; // Post-page header HTML.
\$websiteimagedir = \"img/\"; // The image folder. MUST HAVE LEADING SLASH!
\$websiteindex = \"index\"; // The main PHP file.
\$websitemenucurrentitem = \" class=\\\"currentitem\\\"\";
\$websitemenuformatting = \"<li><a href=\\\"%menuhref%\\\" id=\\\"menu%menuid%\\\"%menucurrentitem%>%menuname%</a></li>\\n\"; // The formatting for menu items. This is explained further in docs/advancedusage.htm.
\$websitemenuindent = \"&bull;&nbsp;\";
\$websitename = \"" . $websitename . "\"; // The name of the site.
\$websitepassword = \"" . $websitepassword . "\"; // The admin password, SHA-1 encrypted.
\$websiteuploaddir = \"files/\"; // The folder for uploads. MUST HAVE LEADING SLASH!
\$websitetheme = \"" . $websitetheme . "\"; // The php file for the the template you want to use.
\$websitethemedir = \"themes/\"; // The theme directory.

?>");
			fclose($configfile);
			if ($writeconfig) {
				echo(" done!</p>");
				if (chmod("../config.php", 0666)) {
					echo("<p>Configuration file made writable.</p>");
				}
				else {
					echo("<p>Failed making the configuration file writeable. You should probably FTP into your site and make sure that <code>config.php</code> is CHMODed 0666.</p>");
				}
				
				echo("<hr />");
				echo("<p>Installation successful! Click <a href=\"../index.php\">here</a> to view the site.</p>");
				echo("<p><b>Please note:</b> It is highly advised that you FTP into your site and remove the folder <code>install/</code>.</p>");
			}
			else {
				echo("<p>The configuration file could not be written, installation was not successful!</p>");
			}
		}
	}
}

?>
</div>
</body>
</html>