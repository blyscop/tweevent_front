function getXMLHTTP(){
  var xhr=null;
  if(window.XMLHttpRequest) // Firefox et autres
  xhr = new XMLHttpRequest();
  else if(window.ActiveXObject){ // Internet Explorer
    try {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e1) {
        xhr = null;
      }
    }
  }
  else { /* XMLHttpRequest non support� par le navigateur */
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
  }
  return xhr;
}
	
function envoi_AJAX(com, url, div, trans) {

	// On initialise la requ�te http qui sera envoy�e au serveur.		
	com.open('GET', url, true);
	// Que fera-t-on avec le r�sultat? 
	com.onreadystatechange = function() { 
		if(com.readyState==4 && com.status == 200) {
			var result = com.responseText;
			if(result.length  >= 2) {
				document.getElementById(div).innerHTML = result;
			} 
		}
	}

	// Ex�cution de la requ�te
	com.send(null);    		
}