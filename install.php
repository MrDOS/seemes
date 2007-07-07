<?

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: install.php
Description: Seemes CMS installation UI.

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

input {
	font-family: "Trebuchet MS", sans-serif;
	margin-bottom: .5em;
}

form {
	display: block;
	margin: auto;
	text-align: right;
	width: 624px;
}
-->
</style>
</head>
<body>
<h1>Seemes CMS - Installation</h1>
<?php

if (!file_exists("config.php")) {
 echo("<p>Please fill out this form to install Seemes. (These - and other - values can be changed later by modifying <code>config.php</code>.)</p>
<form action=\"install2.php\" method=\"post\">
<fieldset>
<legend>Installation Information</legend>
<label for=\"websitename\">Website name:</label>
<input type=\"text\" name=\"websitename\" id=\"websitename\" value=\"Seemes Site\" /><br />
<label for=\"websitecopyright\">Website copyright:</label>
<input type=\"text\" name=\"websitecopyright\" id=\"websitecopyright\" value=\"&amp;copy;2007 Your Name\" /><br />
<p><b>Please note:</b> Special characters (e.g. &copy;) used in the website name and website copyright should be entered using their character code (e.g. &amp;copy) instead of just entering the character. <i>Special characters will not automatically be converted into their HTML entity!</i></p>
<label for=\"websitetheme\">Website theme (only change if you have already uploaded your own theme):</label>
<input type=\"text\" name=\"websitetheme\" id=\"websitetheme\" value=\"defaulttheme.txt\" /><br />
<label for=\"websitepassword\">Administrator password (minimum 6 characters):</label>
<input type=\"password\" name=\"websitepassword\" id=\"websitepassword\" value=\"\" /><br />
<label for=\"websitepasswordverify\">Administrator password (again, the same):</label>
<input type=\"password\" name=\"websitepasswordverify\" id=\"websitepasswordverify\" value=\"\" /><br />
</fieldset>
<fieldset>
<legend>Legal</legend>
<p><b>Please note:</b> Seemes CMS is distributed in the hope that it will be useful, but without any warranty; without even the implied warranty of merchantability or fitness for a particular purpose. See the <a href=\"gpl.txt\">GNU General Public License version 2</a> for more details.</p>
<input type=\"checkbox\" name=\"gplagree\" id=\"gplagree\" />
<label for=\"gplagree\">I agree to the terms of the <a href=\"gpl.txt\">GNU General Public Licence version 2</a>.</label><br />
</fieldset>
<fieldset>
<input type=\"submit\" value=\"Install Seemes!\" />
</fieldset>
</form>\n");
}
else {
 echo("<p>Seemes CMS has already been installed! To reinstall, please delete <code>config.php</code>.</p>");
}

?>
</body>
</html>