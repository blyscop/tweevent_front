<?
/*! \mainpage My Personal Index Page
*
* \section intro_sec Introduction 
*
* This is the introduction. Pour modifier le texte dans l'index, fichier admin > actions.php
*
* \section install_sec Installation
*
* \subsection step1 Step 1: Opening the box
*  
* etc...
*/

/**
*  @defgroup group1 Install
*  C'est le groupe Install contenant l'installation !
*/
/** @} */ // end of group1

/**
*  @defgroup group4 Dilasys
*  C'est le groupe Dilasys
*/
/** @} */ // end of group4

/**
*  @defgroup group2 Fiches
*  C'est le groupe Fiches contenant les différentes fiches
*/
/** @} */ // end of group2

/**
*  @defgroup group3 Articles
*  C'est le groupe Articles
*/
/** @} */ // end of group3
if (!file_exists("dilasys/conf.php") && !file_exists("conf.php")) {
	 // Le fichier conf.php n'existe pas => install nouvelle
	 // HTTP 1.1 n'accepte que des url absolues!
	 header("Location: http://" . $_SERVER['HTTP_HOST']
				. rtrim(dirname($_SERVER['PHP_SELF']), '/\\')
				. "/dilasys/install/");
	 exit;
} 

//==================================================================================
// Les actions suivantes sont normalement effectuees par pre.php
//==================================================================================
include("conf.php");
include("biblio/zip.lib.php");
include("biblio/lib.inc.php");
include("biblio/element.inc.php");
include("biblio/sql.inc.php");
include("biblio/sessions.inc.php");
include("biblio/groupe.inc.php");
include("biblio/utilisateur.inc.php");
include("biblio/ip_autorisation.inc.php");
include("biblio/ip_interdiction.inc.php");
include("biblio/parametre.inc.php");
include("biblio/evenement.inc.php");

$db_link = Sql_connect();
$tab_session['db_link'] = $db_link;

foreach($_GET as $key => $value) $data_in[$key] = $value;
foreach($_POST as $key => $value) $data_in[$key] = $value;

$data = Lib_readData($session);
$lang = (isset($data_in['lang'])) ? $data_in['lang'] : 'fr';
if ($data != '') foreach($data as $key => $value) $data_srv[$key] = $value;

/*=============*/ Lib_myLog("FILE: ",__FILE__);
/*=============*/ Lib_myLog("IN: ",$data_in);
include('lang/messages_dilasys_'.$lang.'.php');
$data_out['message'] = '';
$ip = $_SERVER["REMOTE_ADDR"];

//==================================================================================
// Initialisation des variables globals qui seront utilisées dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article', 'utilisateur', 'ip');

//==================================================================================
// Liste des fichiers contenant les actions
//==================================================================================
include('actions_login.php');

if (!isset($data_in['action'])) $data_in['action'] = 'Login_AfficheLogin';
call_user_func($data_in['action'], $data_in);
/*=============*/ Lib_myLog("OUT: ",$data_out);

//==================================================================================
// La fermeture de la base est normalement effectuee par post.php mais pas ici
//==================================================================================
Sql_close($db_link);

return $data_out;
?>