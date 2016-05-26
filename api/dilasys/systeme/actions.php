<?
//==================================================================================
// Definir ici le nom du module
//==================================================================================
// $module = "systeme";
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script! 
//==================================================================================
if (!include('../pre.php')) exit;

include('../lang/messages_systeme_'.$lang.'.php');

//==================================================================================
// Initialisation des variables globals qui seront utilisées dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article');

//==================================================================================
// Liste des fichiers contenant les actions
//==================================================================================
include('actions_systeme.php');

if (!isset($data_in['action'])) $data_in['action'] = 'Utilisateurs_Consulter';
call_user_func($data_in['action'], $data_in);
/*=============*/ Lib_myLog("OUT: ",$data_out);
include('../post.php');
return $data_out;
?>