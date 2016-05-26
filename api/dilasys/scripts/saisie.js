/* *********************************************************
	module de controle de saisie
	Christian Temprano
	juin 2001
 Version          : $Revision:   1.1  $
 ********************************************************* */

/* *********************************************************
	Nom			: valideForm
	Description	: Controle de tous les champs d'un formulaire avant soumission.
	Parametre	
		strForm	: nom du formulaire sous forme d'une chaine ex: "document.fm"
		tab		: tableau (Array) contenant la liste des champs a scruter avec leur type
					  exemple var tab=Array("nom:NOM","prenom:PRENOM","cp:CP");
	Retour		: true si validation OK, soumission acceptee.
					  false si un des champs est KO, soumission avortee.
 ********************************************************* */
var flagAnnuler=0;

function setAnnuler(){
	flagAnnuler=1;
}

function valideForm( strForm,tab ){
	if( flagAnnuler==0 ) {
		var i=0;

		while( i<tab.length ){
			tabx=new Array();
			tabx=tab[i].split(":");
			var str="document."+strForm+"."+tabx[0];
			var form=eval("document."+strForm+"."+tabx[0]);
			if( !valideField( form, tabx[1] ) ) return false;
			i++;
		}
	}
	return true;
}

/* *********************************************************
	Nom			: valideField
	Description : Controle un champ d'un formulaire avant soumission.
	Parametre
		field		: nom du champ input de type text
		champ 	: type du controle
	Retour 		: true si validation OK, soumission acceptee.
					  false si un des champs est KO, soumission avortee.
 ********************************************************* */
function valideField(field, type ){
	var ret=false;
	var faff=true;
 
	var err="Ce champ ne peut rester vide";
	var tab=new Array();

	tab=type.split(";");
	if( flagAnnuler==1 ) return true;
  
	switch( tab[0] ){
		case "NOM" :
			if( field.value.length>0 ) {
				if( (err=setSize( field, tab ))=="" ){
					field.value=field.value.toUpperCase();
					ret=testChaine(field,"ABCDEFGHIJKLMNOPQRSTUVWXYZ -");
					if( !ret ) err="Seules les lettres alphabetiques majuscules sont valides";
				}
			}
			break;			
		case "NONVIDE" :
			if( (err=setSize( field, tab ))=="" ){
				if( field.value.length==0 ) {
					err="Champ obligatoire";
				}
				else ret=true;
			}
			break;
		case "ALPHANUM" :
			if( (err=setSize( field, tab ))=="" ){
				ret=testChaine(field,"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ,/-\340\350\371\351\352\347");
				if( !ret ) err="Seules les lettres usuelles sont valides";
			}
			break;			
		case "ALPHAMAJ" :
			field.value=field.value.toUpperCase();
			if( field.value.length>0 ) {
				if( (err=setSize( field, tab ))=="" ){
					ret=testChaine(field,"ABCDEFGHIJKLMNOPQRSTUVWXYZ ,/-");
					if( !ret ) err="Seules les lettres de alphabetiques sont valides";
				}
			}
			break;
		case "ALPHANUMOBL" :
			field.value=field.value.toUpperCase();
			if( field.value.length>0 ) {
				if( (err=setSize( field, tab ))=="" ){
					ret=testChaine(field,"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ,/-\340\350\371\351\352\347");
					if( !ret ) err="Seules les lettres usuelles sont valides";
				}
			} 
			break;			
		case "ALPHA" :
			if( field.value.length>0 ) {
				if( (err=setSize( field, tab ))=="" ){
					ret=testChaine(field,"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz -\340\350\371\351\352\347");
					if( !ret ) err="Seules les lettres alphabetiques sont valides";
				}
			}
			break;
		case "MOTCLE" :
			if( (err=setSize( field, tab ))=="" ){
				ret=testChaine(field,"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ,\340\350\371\351\352\347");
				if( !ret ) err="Seules les lettres de alphabetiques et la virgule (,) sont valides";
			}
			break;					
		case "URL" :
			if( (err=setSize( field, tab ))=="" ){
				ret=testChaine(field,"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz \\:/-._");
				if( !ret ) err="Seules les lettres, chiffres, 2 points (:), slash (/), tiret et underscore sont valides";
			}
			break;
		case "EMAIL" :
			if( field.value.length>0 ) {
				if( (err=setSize( field, tab ))=="" ){
					field.value=field.value.toLowerCase();
					ret=testChaine(field,"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.-_0123456789");
					if( !ret ) {
						err="Seules les lettres, chiffres, tiret (-) et underscore (_) sont valides";
					}
					else {
						if( field.value.indexOf("@")<0 || field.value.indexOf(".")<0 ){
							err="Le format du mail est invalide";
							ret=false;
						}
						else ret=true;
					}
				}
			}
			break;			
		case "TEL" :
			if( field.value.length>0 ){
				ret=testChaine(field,"+()0123456789");
				if( !ret ) {
					err="Seuls les chiffres, plus (+) et parentheses sont valides";	
				}
				if( ret && field.value.length<10 ) {
					err="Seule une longueur de 10 chiffres est valide";
					ret=false;
				}
			}
			break;
		case "CP" :
			if( field.value.length==5 ) {
				ret=testChaine(field,"0123456789");
				if( !ret ) err="Seuls les chiffres sont valides";
			}
			else {
				err="5 chiffres sont attendus";
			}
			break;
		case "NUMOBL" :	
			if( field.value.length==0 ){
				field.value="0";
				err="Cette saisie est obligatoire";
				ret=false;
				break;
			}
		case "NUM" :	
			if( field.value.length>0 ){
				ret=testChaine(field,"0123456789");
				if( !ret ) err="Seuls les chiffres sont valides";
				if( ret && (err=testNum( field, tab ))!="") ret=false;
			}
			else {
				ret=true;
			}
			break;
		case "REELOBL" :	
			if( field.value.length==0 ){
				field.value="0";
				err="Cette saisie est obligatoire";
				ret=false;
				break;
			}
		case "REEL" :	
			if( field.value.length>0 ){
				ret=testChaine(field,"-0123456789.,");
				if( !ret ) err="Seuls les chiffres sont valides";
				if( ret && (err=testReel( field, tab ))!="") ret=false;
			}
			else {
				//*field.value="0"; */
				ret=true;
			}
			break;
		case "SELECT" :	
			if( field.selectedIndex<0 ){
				err="Selection obligatoire dans la liste";
			}
			else ret=true;
			break;
		case "DATE1" :
			/* format attendu "JJ/MM/AAAA ou JJ/MM/AA" */
			ret=true;
			if( field.value.length>0 ){
				ret=TextDateTest( field );
				faff=false;
				err=testDate( field, tab);
				if( err.length>0 ) {
					ret=false;
					faff=true;
				}
			}
			break;
    case "DATE" :
      ret=true;
			if( field.value.length>0 ){
  			/* format attendu "JJ/MM/AAAA" */
        var chiffres    = new RegExp("[0-9]"); /* Modifier pour : var chiffres = new RegExp("[0-9]"); */
        var slash       = new RegExp("[/]"); 
        var verif;
        err="Les dates sont au format JJ/MM/AAAA";
        
        ret = chiffres.test(field.value.charAt(0));
        if (ret == true && field.value.length == 2) {
          ret = chiffres.test(field.value.charAt(1));
          if (ret) (field.value += "/");
        }
        if (ret == true && field.value.length == 3) ret = slash.test(field.value.charAt(2));
        if (ret == true && field.value.length == 4) ret = chiffres.test(field.value.charAt(3));
        if (ret == true && field.value.length == 5) {
          ret = chiffres.test(field.value.charAt(4));
          if (ret) (field.value += "/");
        }
        if (ret == true && field.value.length == 6) ret = slash.test(field.value.charAt(5));
        if (ret == true && field.value.length == 7) ret = chiffres.test(field.value.charAt(6));
        if (ret == true && field.value.length == 8) ret = chiffres.test(field.value.charAt(7));
        if (ret == true && field.value.length == 9) ret = chiffres.test(field.value.charAt(8));
        if (ret == true && field.value.length == 10) ret = chiffres.test(field.value.charAt(9));
        if (ret == false) field.value = field.value.substr(0,field.value.length-1);    
      }
      break;
		case "HEURE" :
			/* format attendu "HH:MM" */
			ret=TextHeureTest( field );
			faff=false;
			break;
		case "VARCHAROBL" :
			if( field.value.length==0 ){
				ret=false;
			}
			else {
				if( (err=setSize( field, tab ))=="" ){
					field.value.replace(/'/g,"\'");
					ret=true;
				}
			}
			break;
		case "VARCHAR" :
			if( (err=setSize( field, tab ))=="" ){
				field.value.replace(/'/g,"\'");
				ret=true;
			}
			break;			
		default :
			err="Type de format inconnu";
			break;
	}
	if( faff && !ret ) {
		alert(err);
		field.focus();
    field.style.backgroundColor = "#99FF99";
/*		field.select(); */
	}
	return ret;
}

/* *********************************************************

	FONCTIONS INTERNES
	
 ********************************************************* */

/* *********************************************************
	Nom			: setSize
	Description : verifie la taille max d'une chaine
	Parametre
		field		: nom du champ de type texte
		tab		: tableau des parametres
						0 : donne le type
						[1 : la taille]
	Retour 		: "" si ok, sinon un message d'erreur
 ********************************************************* */
function setSize( field, tab ) {
	var ret="";
	if( tab.length>1 ) {
		var sz=parseInt( tab[1],10 );
		if( field.value.length>sz ) {
			field.value=field.value.substring( 0, sz );
			ret="Ce champ est trop long. Sa longueur a ete modifiee";
		}
	}
	return ret;
}

/* *********************************************************
	Nom			: testNum
	Description : verifie le bornage mini, maxi d'un numerique
	Parametre
		field		: nom du champ de type texte
		tab		: tableau des parametres
						0 : donne le type
						1 : la valeur mini
						2 : la valeur maxi
	Retour 		: "" si ok, sinon un message d'erreur
********************************************************* */
function testNum( field, tab ) {
	var ret="";
	if( tab.length==3 ) {
		if( parseInt(field.value,10)<parseInt(tab[1],10) ||
				parseInt(field.value,10)>parseInt(tab[2],10) ) {
					ret="La valeur doit se trouver entre "+tab[1]+" et "+tab[2];
		}
	}
	return ret;
}

/* *********************************************************
	Nom			: testReel
	Description : verifie le bornage mini, maxi d'un numerique de type reel
	Parametre
		field		: nom du champ de type texte
		tab		: tableau des parametres
						0 : donne le type
						1 : la valeur mini
						2 : la valeur maxi
						3 : le nombre de decimale
	Retour 		: "" si ok, sinon un message d'erreur
 ********************************************************* */
function testReel( field, tab ) {
	var ret="";
	if( tab.length>=3 ) {
		if( parseFloat(field.value)<parseFloat(tab[1]) ||
				parseFloat(field.value)>parseFloat(tab[2]) ) {
					ret="La valeur doit se trouver entre "+tab[1]+" et "+tab[2];
		}
	}
	if( tab.length==4 ){
		/* on doit tester le nombre de decimale*/
	}
	return ret;
}

/* *********************************************************
	Nom			: testDate
	Description : verifie le bornage mini, maxi d'une date
	Parametre
		field		: nom du champ de type date (JJ/MM/AAAA)
		tab		: tableau des parametres
						0 : donne le type
						1 : la valeur* mini 
						2 : la valeur* maxi
						valeur peut-être donne sous l'un des formats suivants :
							"JJ/MM/AAAAA" ou le nom complet d'un champ "document.fm.datedebut"

	Retour 		: "" si ok, sinon un message d'erreur
********************************************************* */
function testDate( field, tab ) {
	var ret="";
	var err=false;
	
	if( tab[0]=="DATE" && tab.length==3 ) {
		var dt=Array();
		var dtmini=Array()
		var dtmaxi=Array();
		dt=field.value.split("/");

		if( tab[1].indexOf("document.")==0 ){
			var fd=eval( tab[1] );
			dtmini=fd.value.split("/");
		}
		else dtmini=tab[1].split("/");

		if( tab[2].indexOf("document.")==0 ){
			var fd=eval( tab[2] );
			dtmaxi=fd.value.split("/");
		}
		else dtmaxi=tab[2].split("/");
		
		if( !TestDate(dtmini[0],dtmini[1],dtmini[2]) ) err=true;
		if( !err && !TestDate(dtmaxi[0],dtmaxi[1],dtmaxi[2]) ) err=true;
		
		if( !err ){
			
			if( ret.length==0 && formatteDateTab(dtmini)>formatteDateTab(dt) ){
				ret="la date doit etre posterieure au "+dtmini[0]+"/"+dtmini[1]+"/"+dtmini[2];
				
			}
				
			if( ret.length==0 && formatteDateTab(dtmaxi)<formatteDateTab(dt) ){
				ret="la date doit etre anterieure au "+dtmaxi[0]+"/"+dtmaxi[1]+"/"+dtmaxi[2];
			}
		}
	}
	return ret;
}

/* *********************************************************
	Nom			: testChaine
	Description : permet verifier les caracteres autorises d'une chaine
	Parametre
		field		: nom du champ de type texte
		listcar	: liste des caracteres autorise
	Retour 		: true si autorise OK, sinon false
 ********************************************************* */
function testChaine( field, listcar ) {
	var ok = false;
	var car;
	for( var i=0; i< field.value.length; i++) {
		car = "" + field.value.charAt(i);
		if( listcar.indexOf(car)<0) ok=true;
	}
	if( ok ) return false;
	return true;
}

/* *********************************************************
	Nom 			: TestDate
	Description	:	test la validite d'une date
	Parametre	:	jour, mois, annee
	Retour		: 	True si exact, False sinon
 ********************************************************* */
function TestDate(jour,mois,annee)
{
	var TMois=new Array(12);
	var LMois="31;28;31;30;31;30;31;31;30;31;30;31";
	var bissex=0;
	var a1,a2;
	TMois=LMois.split(";");
	if( mois<1 || mois>12 )
	{
		alert("Erreur dans le mois");
		return( false );
	}
	if( annee<1900 || annee>2099 )
	{
		alert("Erreur dans l'annee");
		return( false );
	}
	a2=annee%100;
	a1= (annee-a2)/100;
	if( ( a2 != 0  && (a2%4) == 0 ) || ( a2 == 0 && (a1%4) == 0 ) )  bissex=1;
	if( jour > TMois[ mois-1] )
	{
		if( ( mois == 2 && bissex == 1 && jour > 29 ) || 
			  mois != 2 || bissex == 0 )
		{
			alert("Erreur dans le jour !");
			return( false );
		}
	}
	return( true );
}

/* *********************************************************
	Nom			: TextDateTest
	Description	:	test la validite d'une date
						complete la date si necessaire
	Parametre	:	(this) nom du champ dans un input type=text
	Retour		: 	True si exact, False sinon
					modifie le champ si necessaire
 ********************************************************* */
var memdate="&&";
var cptdate=0;

function TextDateTest(form)
{
	var dt=new Date();
	var tdt=new Array(3);
	var max=new Array(3);
	var i=0,j=0,flag=0, err=0,fin=0,data=0;
	var buf="";
	/*if( memdate==form.value ) 
	{
		if( cptdate++>0 ) 
		{
			cptdate=0;
			alert("Veuillez retaper la date");
			memdate="&&";
			form.value="";
		}
		form.focus();
		return false;
	}
	else memdate=form.value; */
	cptdate=0;
	tdt[0]=parseInt(dt.getDate(),10);
	tdt[1]=parseInt(dt.getMonth()+1,10);
	tdt[2]=parseInt(dt.getYear(),10);
	max[0]=31;
	max[1]=12;
	max[2]=2099;
	/* if( form.value == null || form.value == "" ) return false; */
	while( !err && !fin && j<12 && i<3 && j<form.value.length )
	{
		while( !err && !fin && j<12 && i<3 & j<form.value.length )
		{
			car=form.value.charAt(j);
			if( "0123456789".indexOf(car) >=0 )
			{
				if( !flag ) tdt[i]=car;
				else tdt[i]+=car;
				flag=1;
			}
			else
			{
				if( j>=form.value.length ) fin=1;
				else
				{
					if( car != "/" ) err=1;
					else
					{
						flag=0;
						i++;
						if( i>2 ) err=2;
					}
				}
			}
			j++;
		}
	}
	tdt[2]=parseInt(tdt[2],10);
	if( tdt[2]<50 ) tdt[2]+=2000;
	if( tdt[2]>=50 && tdt[2]<100 ) tdt[2]+=1900;
	if( tdt[2]>=100 && tdt[2]<1000 ) tdt[2]+=1900;

	for( i=0 ; i<2 ; i++ )
	{
		data=parseInt(tdt[i],10);
		if( data> max[i] )
		{
			if( i==0 && data>99 ) { err=3; }
			else { err=4+i; }
			break;
		}
		if( data==0 )
		{
			if( i==0 ) tdt[i]=parseInt(dt.getDate(),10);
			if( i==1 ) tdt[i]=parseInt(dt.getMonth(),10)+1;
		}
		if( data<=9 ) buf+="0";
		buf+=data+"/";
	}
	if( err )
	{
		/* form.value=memdate; */
		if( err==1 ) alert("Le separateur slash (/) est attendu");
		if( err==2 ) alert("Format de date invalide");
		if( err==3 ) alert("Saisie invalide !!");		
		if( err==4 ) alert("Il y a une erreur dans le jour");
		if( err==5 ) alert("Il y a une erreur dans le mois");
		if( err==6 ) alert("Il y a une erreur dans l annee");
		form.focus();
		form.select();
		return false;
	}
	buf+=tdt[2];
	form.value=buf;
	if( !TestDate(parseInt(tdt[0],10),parseInt(tdt[1],10),parseInt(tdt[2],10)) )
	{
		form.focus();
		form.select();
		return false;
	}
	return true;
}

/* *********************************************************
	Nom			: TextHeureTest
	Description	:	test la validite d'une heure
						complete celle-ci si necessaire
	Parametre	:	(this) nom du champ dans un input type=text
	Retour		: 	True si exact, False sinon
						modifie le champ si necessaire
********************************************************* */
function TextHeureTest( field )
{
	var ret=false;
	ret=testChaine(field,"0123456789:");
	if( !ret ) err="Seuls les chiffres et les 2 points (:) sont valides";
	else {
		var ferr=true;
		var hh=0, mm=0;
		var pos=field.value.indexOf(":");
					
		if( pos<0){
			err="Il manque le separateur 2 points (:) (format HH:MM)";
			ferr=false;
			}
		else {
			var hhx=field.value.substring(0,pos);
			if( hhx==null || hhx=="" ) hh=0;
			else hh=parseInt(hhx,10);
			var mmx=field.value.substring(pos+1);
			if( mmx==null || mmx=="" ) mm=0;
			else mm=parseInt( mmx,10);
		}
		if( ferr && (hh<0 || hh>24 )){
			err="Les heures sont comprises entre 0 et 24";
			ferr=false;
		}
		if( mm<0 || mm>59 ){
			err="Les minutes sont comprises entre 0 et 59";
			ferr=false;
		}
		field.value="";
		if( hh<=9 ) field.value="0";
		field.value+=hh+":";
		if( mm<=9 ) field.value+="0";
		field.value+=mm;
		ret=ferr;
	}
	return ret;	
}

/* *********************************************************
	Nom			:  formatteDateTab
	Description	:	formatte une date au format informatique
	Parametre	:	un tableau contenant le jour, le mois et l'annee et qui est une date valide 
	Retour		: 	la date formattee au format "AAAAMMJJ"
 ********************************************************* */
function formatteDateTab( tab ){
	var ret="";
	if( parseInt(tab[2])<1000 ) ret=""+(1900+parseInt(tab[2]));
	else ret=""+tab[2];
	if( tab[1].length==1 ) ret+="0";
	ret+=tab[1];
	if( tab[0].length==1 ) ret+="0";
	ret+=tab[0];
	return ret;
}

/* *********************************************************
	Nom			:  formatteDate
	Description	:	formatte correctement une date
	Parametre	:	une chaine qui cntient une date valide au format J/M/A
	Retour		: 	la date formattee au format "JJ/MM/AAAA"
 ********************************************************* */
function formatteDate( chaine ){
	var ret="";
	var tab=chaine.split("/");
	
	if( tab[0].length==1 ) ret+="0";
	ret+=tab[0];
	ret+="/";
	
	if( tab[1].length==1 ) ret+="0";
	ret+=tab[1];
	ret+="/";
	
	if( parseInt(tab[2])<1000 ) ret+=1900+parseInt(tab[2]);
	else ret+=tab[2];
	
	return ret;
}
