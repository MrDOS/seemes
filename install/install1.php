<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
Filename: install1.php
Description: Seemes CMS installation; stage #1: permissions check.

*/

if (file_exists("../config.php")) {
	die("Seemes has already been installed!");
}

$goodpermissions = true;

function checkpermissions($file) {
	global $goodpermissions;
	
	echo("<tr>
<td><code>" . $file . "</code></td>\n");
	
	if (is_writeable("../" . $file)) {
		echo("<td class=\"iswriteable\">Pass</td>\n");
	}
	else {
		echo("<td class=\"isunwriteable\">Fail</td>\n");
		$goodpermissions = false;
	}
	
	echo("</tr>\n");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Seemes CMS 0.4 - Installation</title>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
<!--

td.isunwriteable {
	background-color: #ffc0c0 !important;
	color: #000000;
}

td.iswriteable {
	background-color: #c0ffc0 !important;
	color: #000000;
}

-->
</style>
</head>
<body>
<div id="main">
<h1>Seemes CMS 0.4 - Installation</h1>
<div class="stepbox currentstep"><em>Step 1</em><br />Permissions Check</div>
<div class="stepbox"><em>Step 2</em><br />Gather information</div>
<div class="stepbox"><em>Step 3</em><br />Writing files</div>
<br style="clear: both;" />
<h2>File Permissions</h2>
<table>
<tr>
<th>File or Folder</th>
<th>Writeable?</th>
</tr>
<?php checkpermissions("/"); ?>
<?php checkpermissions("data/"); ?>
<?php checkpermissions("data/home.txt"); ?>
<?php checkpermissions("data/menu.inc"); ?>
<?php checkpermissions("files/"); ?>
<?php checkpermissions("img/"); ?>
<?php checkpermissions("themes/"); ?>
<?php checkpermissions("themes/defaultstyle.css"); ?>
<?php checkpermissions("themes/defaulttheme.txt"); ?>
</table>
<form action="install2.php" method="post">
<div id="permissionsreturn">
<?php

if ($goodpermissions) {
	echo("<p>It looks like all the necessary stuff is writeable!</p>
<input type=\"submit\" value=\"Go to Step 2\" />");
}
else {
	echo("<p>Uh oh, it looks like a few things aren't writeable. Please FTP into your site and CHMOD the items listed as having failed to 0777.</p>");
}

?>
</div>
</form>
</div>
</body>
</html>