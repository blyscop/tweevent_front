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
include("../dilasys/conf.php");
include("../dilasys/biblio/lib.inc.php");
include("../dilasys/biblio/libmail.php");
include("../dilasys/biblio/zip.lib.php");
include("../dilasys/biblio/sql.inc.php");
include("../dilasys/biblio/sessions.inc.php");
include("../dilasys/biblio/collection.inc.php");
include("../dilasys/biblio/element.inc.php");
include("../dilasys/biblio/groupe.inc.php");
include("../dilasys/biblio/utilisateur.inc.php");
include("../dilasys/biblio/ip_autorisation.inc.php");
include("../dilasys/biblio/ip_interdiction.inc.php");
include("../dilasys/biblio/parametre.inc.php");
include("../dilasys/biblio/evenement.inc.php");
include("../dilasys/biblio/param_pays.inc.php");

//==================================================================================
// Connexion a la base de données. La déconnexion se fait plus loin systématiquement
// On stocke la connexion à la BDD dans $tab_session
//==================================================================================
$db_link = Sql_connect();

$tab_session = array();
$tab_session['db_link'] = $db_link;
//==================================================================================
// Rien ne sera affiché sur le client avant l'appel a end_flush dans post.php
// Lib_prepareAffichage est appelé pour remplacer les tags %%tag%% situés dans les pages HTML
// avant affichage final (utilisé principalement pour les messages pouvant être en plusieurs langues)
//==================================================================================
ob_start("Lib_prepareAffichage");


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

//==================================================================================
// !! IMPORTANT : A chaque actions appelé (ou requête voulant être effectuée sur le serveur,
// !! on doit asbolument vérifier que la clé d'API donnée est dans nos bases, sinon on doit
// !! arrêter l'execution du script avec @see exit()
////==================================================================================
//if(empty($data_in['api'])) exit;
//$args_cles_api['id_cle_api'] = '*';
//$args_cles_api['no_limit'] = 1;
//$liste_cles_api_tmp = Cle_apis_chercher($args_cles_api);
//
//if(!empty($liste_cles_api_tmp)) {
//    $liste_cles_api = array();
//    foreach ($liste_cles_api_tmp as $cle_api)
//        $liste_cles_api[$cle_api['valeur_cle_api']] = $cle_api['valeur_cle_api'];
//    if(!in_array($data_in['api'], $liste_cles_api)) exit;
//}



// Tout ce qui sera stocké en base sera en iso-8851
// et tout ce qui sera affiché sera transformé en UTF8
// On force donc l'affichage des pages en UTF8
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date du passé

//==================================================================================
// Tout s'est bien deroulé, on retourne à la page actions.php qui nous a appelé
//==================================================================================x²
return 1;
?>
