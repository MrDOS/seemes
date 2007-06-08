/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007 MagicWare
Filename: htmlpreview.js
Description: The JavaScript that controls the live HTML preview in createpage and editpage.

*/

function showPreview(inputId, outputId) {
	document.getElementById(outputId).innerHTML = document.getElementById(inputId).value;
}