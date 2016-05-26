var x=0;
var y=0;

function positionSouris(e) {
 var DocRef;    // Variable pour IE uniquement

  // L'�v�nement est pass�e � la fonction
  // donc tous sauf IE�
  if(e){                     // Dans ce cas on obtient directement la position dans la page
    x = e.pageX;
    y = e.pageY;
  }
  else{                      // Dans ce cas on obtient la position relative � la fen�tre d'affichage
    x = event.clientX;
    y = event.clientY;


    //-- Il faut traiter le CAS des DOCTYPE sous IE
    if( document.documentElement && document.documentElement.clientWidth) // Donc DOCTYPE
      DocRef = document.documentElement;   // Dans ce cas c'est documentElement qui est r�f�rence
    else
      DocRef = document.body;                    // Dans ce cas c'est body qui est r�f�rence

    //-- On rajoute la position li�e aux ScrollBars
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