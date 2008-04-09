/*

Please see gpl.txt for licence and disclaimer of warranty.

Seemes CMS
Copyright 2007, 2008 Samuel C
Filename: quicklink.js
Description: The JavaScript that controls the quick link thingie.

*/

function addLink(textareaId, selectId) {
	page = document.getElementById(selectId).value;
	document.getElementById(textareaId).innerHTML += '<a href="' + websiteindex + '?page=' + page + '">link text</a>';
}