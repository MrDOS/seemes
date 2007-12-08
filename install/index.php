<?php

/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: index.php
Description: Seemes CMS installation; redirect to first installation step.

*/

if (file_exists("../config.php")) {
	die("Seemes has already been installed!");
}

header("Location: install1.php");

?>