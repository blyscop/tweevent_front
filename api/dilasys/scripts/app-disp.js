var x=0;
var y=0;

function positionSouris(e) {
 var DocRef;    // Variable pour IE uniquement

  // L'événement est passée à la fonction
  // donc tous sauf IE…
  if(e){                     // Dans ce cas on obtient directement la position dans la page
    x = e.pageX;
    y = e.pageY;
  }
  else{                      // Dans ce cas on obtient la position relative à la fenêtre d'affichage
    x = event.clientX;
    y = event.clientY;


    //-- Il faut traiter le CAS des DOCTYPE sous IE
    if( document.documentElement && document.documentElement.clientWidth) // Donc DOCTYPE
      DocRef = document.documentElement;   // Dans ce cas c'est documentElement qui est réfèrence
    else
      DocRef = document.body;                    // Dans ce cas c'est body qui est réfèrence

    //-- On rajoute la position liée aux ScrollBars
    x += DocRef.scrollLeft;
    y += DocRef.scrollTop;
  }
}

function App(extension) {
	if (navigator.appName=='Microsoft Internet Explorer') {
		eval("document.all.ID_MENU"+extension+".style.display=''");
	} else {
		eval("document.getElementById('ID_MENU"+extension+"').style.display=''");
	}
}

function App2(extension) {
	// On applique un decalage supplementaire pour ne pas occulter la ligne de donnees
	// sur laquelle s'est fait l'App2
	y+=10;
	if (navigator.appName=='Microsoft Internet Explorer') {
		eval("document.all.ID_MENU"+extension+"_WD.style.display=''");
		eval("document.all.ID_MENU"+extension+".style.top="+y);
		eval("document.all.ID_MENU"+extension+"_WD.style.top="+y);
	} else {	
		eval("document.getElementById('ID_MENU"+extension+"_WD').style.display=''");
		eval("document.getElementById('ID_MENU"+extension+"').style.top='"+y+"px'");
		eval("document.getElementById('ID_MENU"+extension+"_WD').style.top='"+y+"px'");
	}		
}

function Disp(extension) {
	if (navigator.appName=='Microsoft Internet Explorer') {
		eval("document.all.ID_MENU"+extension+".style.display='none'");
		}
	else {
		eval("document.getElementById('ID_MENU"+extension+"').style.display='none'");
		}
}