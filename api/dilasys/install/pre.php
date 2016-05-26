<? 
//==================================================================================
// pre.php, situe a la racine du systeme, est systematiquement appele.
// Il effectue le chargement des bibilotheques de travail, 
// des controles de securite et ouvre un acces a la base de donnees 
// qui sera ferme par post.php
//==================================================================================

//==================================================================================
// Chargement des bibliotheques de base
//==================================================================================
include("config/conf.php");
include("../biblio/lib.inc.php");
include("../biblio/sql.inc.php");

//==================================================================================
// Rien ne sera affiche sur le client tant avant l'appel a end_flush dans post.php
// Lib_prepareAffichage est appele pour remplacer les tags %%tag%% avant affichage final
//==================================================================================
ob_start("Lib_prepareAffichage");

//==================================================================================
// Verification de securite diverses 
//==================================================================================
$ip = $_SERVER["REMOTE_ADDR"];
if (isset($_COOKIE['lang'])) $lang = $_COOKIE['lang'];
if (isset($_COOKIE['session'])) $session = $_COOKIE['session'];

// Oblige d'initialiser action ici ou sinon le return empechera l'action d'etre connu dans actions.php
foreach($_GET as $key => $value) $data_in[$key] = $value;
foreach($_POST as $key => $value) $data_in[$key] = $value;
      
//==================================================================================
// On recupere toutes les informations stockees d'une page a l'autre sur le serveur
//==================================================================================
$data = Lib_readData("data");
if ($data != '') foreach($data as $key => $value) $data_in[$key] = $value;

// 'web' indique que l'on travaille avec de l'affichage WEB
// Si on ne veut pas d'affichage, pour les tests notamment, mettre $web a 0 dans le conf.php
if (isset($web) && $web) $data_in['web'] = 1;

// On positionne un cookie factice de session pour l'enregistrement des logs
$_COOKIE[$GLOBALS['instance'].'_session'] = 'install';

//==================================================================================
// Tout s'est bien deroule, on retourne a la page actions.php qui nous a appele
//==================================================================================
return 1;
           
?>