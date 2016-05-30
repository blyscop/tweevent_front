<?

//==================================================================================
// Definir ici le nom du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script! 
//==================================================================================
if (!include('dilasys/pre.php')) exit;

//==================================================================================
// On trace le fichier actuel et les donn?es entrantes
//==================================================================================
/*=============*/ Lib_myLog("FILE: ",__FILE__);
/*=============*/ Lib_myLog("IN: ",$data_in);

//==================================================================================
// Inclusion librairies n?cessaires aux actions
//==================================================================================
include('dilasys/biblio/post.inc.php');
include('dilasys/biblio/post_auteur.inc.php');
include('dilasys/biblio/post_categorie.inc.php');
include('dilasys/biblio/post_type.inc.php');

//==================================================================================
// Initialisation des variables globals qui seront utilis?es dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article', 'fiche');

//==================================================================================
// Liste des fichiers contenant les actions
//==================================================================================

include('actions_utilisateurs.php');

//==================================================================================
// Action d'accueil
//==================================================================================
function Accueil($data_in = array())
{
    Lib_myLog("action: ".__FUNCTION__);
    foreach($GLOBALS['tab_globals'] as $global) global $$global;

    $data_out['page'] = "page_accueil.php";
}

if (!isset($data_in['action'])) $data_in['action'] = 'Accueil';
call_user_func($data_in['action'], $data_in);
/*=============*/ Lib_myLog("OUT: ",$data_out);
include('dilasys/post.php');
return $data_out;
?>