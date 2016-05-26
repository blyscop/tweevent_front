<?

//==================================================================================
// Definir ici le nom du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script!
//==================================================================================
if (!include('pre.php')) exit;

//==================================================================================
// On trace le fichier actuel et les donn?es entrantes
//==================================================================================
/*=============*/ Lib_myLog("FILE: ",__FILE__);
/*=============*/ Lib_myLog("IN: ",$data_in);

//==================================================================================
// Inclusion librairies n?cessaires aux actions
//==================================================================================
include('../dilasys/biblio/tweevent_user.inc.php');
include('../dilasys/biblio/tweevent_img.inc.php');
include('../dilasys/biblio/tweevent_event.inc.php');
include('../dilasys/biblio/tweevent_post.inc.php');

//==================================================================================
// Initialisation des variables globals qui seront utilis?es dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article', 'fiche');

//==================================================================================
// Liste des fichiers contenant les actions
//==================================================================================

include('actions_get.php');
include('actions_put.php');
include('actions_post.php');

call_user_func($data_in['action'], $data_in);
/*=============*/ Lib_myLog("OUT: ",$data_out);
include('post.php');
return $data_out;
?>
