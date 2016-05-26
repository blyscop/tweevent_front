<?
//------------------------------------------
// Donnees configurables du systeme
//------------------------------------------
$MODULES = array(
"site",
"annuaire",
"news",
"admin"
);

//-----------------------------------------------------------------------------------------------------------------------
// Langues configur�es. 
// Pour chaque langue rajout�e, cr�er les fichiers logo_<langue>0.gif et logo_<langue>1.gif 
// et les mettre dans le r�pertoire img 
//-----------------------------------------------------------------------------------------------------------------------
$LANGUES = array(
"en"
);

//---------------------------
// Styles par d�faut
//---------------------------
$PARAM_STYLE = array(
"couleur_bg" => "FFFFFF",
"couleur_lignes_paires" => "DDDDDD",
"couleur_lignes_impaires" => "EEEEEE"
);

//-----------------------
// Nombre de lignes par INSERT
//-----------------------
$lines_max = 500;

//-----------------------
// Nombre de lignes par affichage de tableaux
//-----------------------
$taille_tableaux = 10;
$taille_tableaux_admin = 150;

//-----------------------
// Tables autorisees
//-----------------------
$AUTH_TABLES = array(
"articles",
"fiches",
"sys_autorisations",
"sys_evenements",
"sys_groupes",
"sys_groupes_modules",
"sys_groupes_droits",
"sys_parametres",
"sys_utilisateurs"
);

//-----------------------
// Droits utilisateurs
//-----------------------
$TAB_DROITS = array("droit" => "libelle");
?>