<?
//------------------------------------------
// Donnees du serveur
//------------------------------------------
$db = 'bdd';

$db1 = 'martinfrpc3351';
$dbuser1 = 'martinfrpc3351';
$dbpass1 = 'Lamato33';
$serveur_mysql1 = 'martinfrpc3351.mysql.db';

$db2 = 'martinfrpc3351';
$dbuser2 = 'martinfrpc3351';
$dbpass2 = 'Lamato33';
$serveur_mysql2 = 'martinfrpc3351.mysql.db';

$sgbd = 'mysql';
$prefix = 'app_';
$instance = 'install';

$elapse_time = 86400;    // duree de rétention des fichiers temporaires
$log_level = 2;          // 0:erreurs seulement 1:erreurs+warnings 2:tout tracer
$zip_log_files = 1;      // 0:pas de compression zip 1:compression zip
$wait_time = 3;          // Temps d'attente entre 2 tentatives de connexion. 
$nb_tentatives_max = 1000; // Nombre de tentatives maximum de connexion 

$encrypt = 0;            // 1:Oui 0:Non
$clef = "Comme il fait beau!";    // Clef utilisee pour l'encodage des sauvegardes
$stop_bad_sql = 1;       // 1: Si l'execution sql detecte une mauvaise requete => arret de l'execution
$connexion_unique = 0;   // 1: Une seule connexion par poste. 0: plusieurs connexions possibles
$controle_ip = 0;        // 1: Controle de l'adresse IP du poste utilisateur

$mail_admin = "jplambert@dilasoft.fr";

$url_externe = "/admin/externe/actions.php";
$srv_externe = "localhost";

if (!defined('DIR'))
	define('DIR', substr( __FILE__, 0, strpos( __FILE__, "dilasys" ))."dilasys/");

//----------------------------------------------------------------------------------
// Afin d'eviter les messages d'erreur a l'utilisation de mktime()
//----------------------------------------------------------------------------------
if (function_exists('date_default_timezone_set'))
	date_default_timezone_set('Europe/Paris');

//----------------------------------------------------------------------------------
// Nous allons faire notre propre gestion d'erreurs
//error_reporting(E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE);
//----------------------------------------------------------------------------------
error_reporting(E_ALL);

//-----------------------------------------
// Caracteres speciaux pour les extractions
//-----------------------------------------
$separateur = ",";
$fin_de_ligne = ";";

//----------------------------------------------
// Temps maxi d'execution pour les restaurations
//----------------------------------------------
$exec_time = 300;

include('params.php');
?>