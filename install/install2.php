<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: install1.php
Description: Seemes CMS installation; stage #2: gather information.

*/

if (file_exists("../config.php")) {
	die("Seemes has already been installed!");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Seemes CMS - Installation</title>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="main">
<h1>Seemes CMS - Installation</h1>
<div class="stepbox"><em>Step 1</em><br />Permissions Check</div>
<div class="stepbox currentstep"><em>Step 2</em><br />Gather information</div>
<div class="stepbox"><em>Step 3</em><br />Writing files</div>
<br style="clear: both;" />
<h2>Website Information</h2>
<form action="install3.php" method="post">
<fieldset>
<legend>Installation Information</legend>
<label for="websitename">Website name:</label><br />
<input type="text" name="websitename" id="websitename" value="Seemes Site" style="width: 400px;" /><br />
<label for="websitecopyright">Website copyright:</label><br />
<input type="text" name="websitecopyright" id="websitecopyright" value="&amp;copy;2007 Your Name" style="width: 400px;" /><br />
<p><b>Please note:</b> Special characters (e.g. &copy;) used in the website name and website copyright should be entered using their character code (e.g. &amp;copy) instead of just entering the character. <i>Special characters will not automatically be converted into their HTML entity!</i></p>
<label for="websitetheme">Website theme (only change if you have already uploaded your own theme):</label><br />
<input type="text" name="websitetheme" id="websitetheme" value="defaulttheme.txt" style="width: 400px;" /><br />
<label for="websitepassword">Administrator password (minimum 6 characters):</label><br />
<input type="password" name="websitepassword" id="websitepassword" value="" /><br />
<label for="websitepasswordverify">Administrator password (again, the same):</label><br />
<input type="password" name="websitepasswordverify" id="websitepasswordverify" value="" /><br />
</fieldset>
<fieldset>
<legend>Legal</legend>
<p><b>Please note:</b> Seemes CMS is distributed in the hope that it will be useful, but without any warranty; without even the implied warranty of merchantability or fitness for a particular purpose. See the <a href="../gpl.txt">GNU General Public License version 2</a> for more details.</p>
<input type="checkbox" name="gplagree" id="gplagree" />
<label for="gplagree">I agree to the terms of the <a href="../gpl.txt">GNU General Public Licence version 2</a>.</label><br />
</fieldset>
<fieldset>
<input type="submit" value="Install Seemes!" />
</fieldset>
</form>
</div>
</body>
</html>