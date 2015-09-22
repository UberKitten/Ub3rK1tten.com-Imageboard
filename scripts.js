/*-------------------------
	Form Resetting
-------------------------*/

function clickclear(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
		thisfield.value = "";
	}
}

function clickrecall(thisfield, defaulttext) {
	if (thisfield.value == "") {
		thisfield.value = defaulttext;
	}
}

/*-------------------------
	Ajax
-------------------------*/
			
/*@cc_on @*/
/*@if (@_jscript_version >= 5)
	try {
		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e2) {
			xmlHttp = false;
		}
	}
@end @*/
			
var xmlHttp = false;
if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
	xmlHttp = new XMLHttpRequest();
}

function stateChange() { 
	if (xmlHttp.readyState==4) { 
		eval(xmlHttp.responseText); 
	} 
}

/*-------------------------
	Form Refreshing
-------------------------*/

function refreshForm() {
	if (xmlHttp) { 
		theDate = new Date();
		xmlHttp.onreadystatechange = stateChange; 
		xmlHttp.open("GET","timestamp.php?" + theDate.getTime(),true); 
		xmlHttp.send(null); 
	}
}

/*-------------------------
	Image Refreshing
-------------------------*/

function refreshImage() {
	tmpd = new Date(); 
	tmp = imageLocation+tmpd.getTime();
	document.images["feed"].src = tmp; 
	milisec = 0;
	seconds = 30;
}

/*-------------------------
	Timer
-------------------------*/

var milisec = 0; 
var seconds = 30; 
function display() { 
	if (milisec <= 0){ 
		milisec = 9;
		seconds -= 1; 
	}
	
	if (seconds <= -1) { 
		milisec = 0; 
		seconds += 1; 
	}
	
	if (seconds == 0 && milisec == 0) {
		seconds = 30;
		refreshImage();
		refreshForm();
	} else {
		milisec -= 1;
	}
	
	document.forms['sayform'].refresh.value='Refresh ('+seconds+')';
	setTimeout("display()",100); 
}

/*-------------------------
	Google Analytics
-------------------------*/

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
try {
	var pageTracker = _gat._getTracker("UA-967859-2");
	pageTracker._trackPageview();
} catch(err) {}