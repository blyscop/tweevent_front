<?
/*
Pour migrer des cases aux fonctions :

1- Déclarer la ligne 
	$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article');
  à la place des lignes avec l'instruction "global" se trouvant au début de la fonction ExecActions($action)

2- Remplacer tous les 
	case "CasExemple" :
	{
  par 
	function CasExemple($data_in = array())
	{
		Lib_myLog("action: ".$data_in['action']);
		foreach($GLOBALS['tab_globals'] as $global) global $$global;
		Lib_myLog("IN: ",$data_in);
		Lib_myLog("FILE: ",__FILE__);
  et supprimer l'instruction "break" suivant immédiatement la fermeture du case

2b- Si on a la situation suivante :
	case "Case1" :
	case "Case2" :
	case "Case3" :
	{
  remplacer par
	function Case1($data_in = array()) { call_user_func('Case3', $data_in); }
	function Case2($data_in = array()) { call_user_func('Case3', $data_in); }
	function Case3($data_in = array())
	{
		Lib_myLog("action: ".$data_in['action']);
		foreach($GLOBALS['tab_globals'] as $global) global $$global;
		Lib_myLog("IN: ",$data_in);
		Lib_myLog("FILE: ",__FILE__);

3- Supprimer la ligne
	function ExecActions($action) {
  et sa fermeture située tout à la fin du fichier et décaler tout le contenu de la fonction d'un cran à gauche

4- Supprimer la ligne
	switch($action)
	{
  et sa fermeture située tout à la fin du fichier et décaler tout le contenu de la fonction d'un cran à gauche

5- Remplacer tous les 
	ExecActions("CasExemple");
  présents dans des blocs "case" par 
	$data_in['action'] = 'CasExemple';
	call_user_func('CasExemple', $data_in);

6- Remplacer en fin de fichier la ligne 
	ExecActions($data_in['action'])
   par 
	call_user_func($data_in['action'], $data_in);

7- Remplacer tous les 
      $action = 
   par
	  $data_in['action'] =
*/

//==================================================================================
// Definir ici le auteur du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "site";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script! 
//==================================================================================
if (!include('../dilasys/pre.php')) exit;
include('../biblio/groupe_client.inc.php');

//==================================================================================
// L'inclusion du fichier langues pose des soucis d'encodage au moment de traiter XL
//==================================================================================
if (!isset($data_in['xl']) || $data_in['xl'] == "0") include('../lang/messages.php');

$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article');

//==================================================================================
// Chaque fonction represente un enchainement fonctionnel unitaire.
//==================================================================================

/**
* - Cas Accueil :
* . 
*      Le cas (par défaut)
*/
function Case1a($data_in) { call_user_func('Case1', $data_in); }
/**
* - Cas Accueil :
* . 
*      Le cas (par défaut)
*/
function Case1b($data_in) { call_user_func('Case1', $data_in); }
/**
* - Cas Accueil :
* . 
*      Le cas (par défaut)
*/
function Case1($data_in) 
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	/*=============*/ Lib_myLog("IN: ",$data_in);
	/*=============*/ Lib_myLog("FILE: ",__FILE__);

	echo "Case 1";
	print_r($data_in);
	$data_in['action'] = "Case2";
	call_user_func("Case2", $data_in);
}

function Case2($data_in)
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	/*=============*/ Lib_myLog("IN: ",$data_in);
	/*=============*/ Lib_myLog("FILE: ",__FILE__);

	echo "Case 2";
}

if (empty($data_in['action'])) $data_in['action'] = 'Case1';
call_user_func($data_in['action'], $data_in);
/*=============*/ Lib_myLog("OUT: ",$data_out);
include('../dilasys/post.php');
return $data_out;
?>