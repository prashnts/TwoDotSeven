/*	  ______________  ____  _  ______
	 / ___/  _/ ___/ / __ \/ |/ / __/
	/ /___/ // /__  / /_/ /    / _/  
	\___/___/\___/  \____/_/|_/___/  
	
	>CIC One< Base Library.
	<assets/js/cookies.js>
	Simple JS Cookie retriever. Only sets/gets the HTTP(s) cookies.
	Written for CIC One, by Prashant Sinha <prashantsinha@outlook.com>
*/

function setCookie(cname,cvalue,exdays) {
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++)  {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	}
	return "";
}