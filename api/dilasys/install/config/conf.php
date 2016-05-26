<?
/** @file
 *  @ingroup group1                           
 *  @brief this file in Install
*/

//============================
// Configuration par defaut
//============================
$bdd     = 'dilasoft';
$login   = 'dilasoft';
$mdp     = 'dilasoft';
$serveur = 'localhost';

$sgbd = 'mysql';
$prefix = 'dilasoft_';
$phrase = 'Comme il fait beau!';

//============================
// Configuration diverses
//============================
$elapse_time = 3600;     // duree des sessions en secondes
$log_level = 2;          // 0:erreurs seulement 1:erreurs+warnings 2:tout tracer
$instance = 'install';          // 0:erreurs seulement 1:erreurs+warnings 2:tout tracer

//===============================================================================================
// Liste des modules autorises.
// Le nom des modules est inscrit dans l'en-tete des fichiers actions.php dans chaque repertoire 
// Ne pas oublier de configurer aussi les autorisations dans modules.sql
//===============================================================================================
$auth_modules[] = 'site';
$auth_modules[] = 'annuaire';
$auth_modules[] = 'news';

//============================
// Liste des tables autorisees 
//============================
$auth_tables[] = 'articles';
$auth_tables[] = 'fiches';

?>