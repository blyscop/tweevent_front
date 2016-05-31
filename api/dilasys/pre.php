<? 
//==================================================================================
// pre.php, situé à la racine du système, est systématiquement appelé par tous les actions.php.
// Il récupère la session en cours, effectue le chargement des bibilothèques de travail de base, 
// des contrôles de securité, vérifie que l'utilisateur accède bien à un module
// autorisé et ouvre un accés a la base de données qui sera fermé par post.php
//==================================================================================

//==================================================================================
// Chargement de la configuration de base
// et chargement des bibliothèques de base
//==================================================================================
include("conf.php");
include("biblio/lib.inc.php");
include("biblio/libmail.php");
include("biblio/zip.lib.php");
include("biblio/sql.inc.php");
include("biblio/sessions.inc.php");
include("biblio/collection.inc.php");
include("biblio/element.inc.php");
include("biblio/groupe.inc.php");
include("biblio/utilisateur.inc.php");
include("biblio/ip_autorisation.inc.php");
include("biblio/ip_interdiction.inc.php");
include("biblio/parametre.inc.php");
include("biblio/evenement.inc.php");
include("biblio/param_pays.inc.php");

//==================================================================================
// Connexion a la base de données. La déconnexion se fait plus loin systématiquement
//==================================================================================
$db_link = Sql_connect();

//==================================================================================
// Rien ne sera affiché sur le client avant l'appel a end_flush dans post.php
// Lib_prepareAffichage est appelé pour remplacer les tags %%tag%% situés dans les pages HTML
// avant affichage final (utilisé principalement pour les messages pouvant être en plusieurs langues)
//==================================================================================
ob_start("Lib_prepareAffichage");

//==================================================================================
// Vérification de securité diverses 
//==================================================================================
unset($session);

// On récupère l'identifiant de session
$session = $_COOKIE[$GLOBALS['instance'].'_session'];

// On récupère les données passés par méthode GET ou POST et on les traduit en data_in pour simplifier 
// leur manipulation dans les actions.php
foreach($_GET as $key => $value) {
	if (!is_array($value))
		$data_in[$key] = stripslashes($value);
	else
		foreach($value as $value2)
			$data_in[$key][] = stripslashes($value2);
}
foreach($_POST as $key => $value) {
	if (!is_array($value))
		$data_in[$key] = stripslashes($value);
	else
		foreach($value as $value2)
			$data_in[$key][] = stripslashes($value2);
}

$stop = false;

// La session php n'existe pas => l'utilisateur ne s'est pas logge!
if ($session == '' || $session == 'NO_SESSION') $stop = true;

// Le fichier de session n'existe plus => on renvoie sur la fenetre de login
if (!Lib_sessionExists($session)) $stop = true;

// A ce niveau, la session existe et le fichier où sont stockées les informations aussi 
// => on peut donc les récupérer...
$tab_session = Lib_readData('session_'.$session);
$tab_session['db_link'] = $db_link;

// Le user agent ne correspond pas à celui qui est stocké => on sort
if ($tab_session['user_agent'] != $_SERVER['HTTP_USER_AGENT']) $stop = true;

// Si on sort, on affiche la fenêtre de login
if($stop) {    
    ob_end_clean();
		// data_in['ajax'] est positionné dans ajax.js
		if (!isset($data_in['ajax'])) {
			if (file_exists('../../admin/Login_Admin.php'))
				 header('Location: ../../admin/Login_Admin.php');
			if (file_exists('../Login_Admin.php'))
				 header('Location: ../Login_Admin.php');
			if (file_exists('Login_Admin.php'))
				 header('Location: Login_Admin.php');
		}
    exit;
}

// La session est OK. On récupere les informations concernant le groupe
$lang = (isset($tab_session['lang'])) ? $tab_session['lang'] : 'fr';
$taille_ecran = (isset($tab_session['taille_ecran'])) ? $tab_session['taille_ecran'] : 500;
$GLOBALS['nom_utilisateur'] = $nom_utilisateur = $tab_session['nom_utilisateur'];
$utilisateur = Utilisateur_recuperer($nom_utilisateur);
$groupe = Groupe_recuperer($utilisateur->nom_groupe);
$GLOBALS['id_utilisateur_session'] = $utilisateur->getId();
$tab = $groupe->getTab();
$GLOBALS['groupe'] = $nom_groupe = $utilisateur->nom_groupe;

//-----------------------
// Pays
//-----------------------
$TAB_PAYS = array();
$args_pays['id_param_pays'] = '*';
$TAB_PAYS = Param_pays_chercher($args_pays);

//==================================================================================
// Vérification d'acces aux modules 
// Le nom du module est positionné dans les actions.php juste avant l'appel à pre.php.
//==================================================================================
/*=============*/ Lib_myLog("Demande d'acces au module $module");
if (!isset($module) || ($module != '' && !in_array($module,$tab['modules']))) {
	/*=============*/ Lib_myLog("Module non positionne ou non autorise");
	ob_end_clean();
		if (file_exists('../accueil.php'))
			header('Location: ../accueil.php');
		if (file_exists('accueil.php'))
			header('Location: accueil.php');
	exit;
}

//==================================================================================
// Chargement de la configuration de l'utilisateur
//==================================================================================
/*=============*/ Lib_myLog("Chargement des parametres de l'utilisateur");
// $parametres = Parametres_recuperer($nom_utilisateur);    
// $USER_PARAMS = $parametres->getParametres();

//==================================================================================
// On récupère toutes les informations stockées dans le "cache"
//==================================================================================
$data = Lib_readData($session);
if ($data != '') foreach($data as $key => $value) $data_srv[$key] = $value;

// 'secure' indique que l'on veut un affichage des boutons securise
if (isset($secure_forms) && $secure_forms) $data_in['secure'] = 1;

// 'web' indique que l'on travaille avec de l'affichage WEB
// Si on ne veut pas d'affichage, pour les tests notamment, mettre $web a 0 dans le conf.php
if (isset($web) && $web) $data_in['web'] = 1;

// Tout ce qui sera stocké en base sera en iso-8851
// et tout ce qui sera affiché sera transformé en UTF8
// On force donc l'affichage des pages en UTF8
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date du passé

//==================================================================================
// Tout s'est bien deroulé, on retourne à la page actions.php qui nous a appelé
//==================================================================================
return 1;
?>