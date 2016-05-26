<?
/** @file
 *  @ingroup group1
 *  @brief this file in Install
*/
session_id('INSTALL');
session_start();

include('pre.php');
Lib_myLog("FILE: ",__FILE__);
Lib_myLog("IN: ",$data_in);
include('../lang/messages_install_fr.php');
restore_error_handler();

$data_out['message'] = '';
$data_out['etapes'] = array();
$ip = $_SERVER["REMOTE_ADDR"];
if(!isset($_COOKIE['lang'])) $_COOKIE['lang'] = "fr";

/**
* - Cas Install_Accueil :
* . 
*		Le cas (par défaut) Install_Accueil patati patata....
*/
function Install_Accueil($data_in = array())
{
	global $lang, $MSG, $data_in, $data_out, $data_srv, $catalogue, $ip;
	Lib_myLog("Verification si le fichier de conf existe...");

	if (!file_exists("../conf.php")) {
		Lib_myLog("Le fichier conf.php n'existe pas => nouvelle installation");
		$lang = (isset($data_in['lang'])) ? $data_in['lang'] : 'fr' ;
		$data_out['bdd']		= $GLOBALS['bdd'];
		$data_out['login']		= $GLOBALS['login'];
		$data_out['mdp']		= $data_out['mdp_bis'] = $GLOBALS['mdp'];
		$data_out['serveur']	= $GLOBALS['serveur'];
		$data_out['prefix']		= $GLOBALS['prefix'];
		$data_out['instance']	= $GLOBALS['instance'];
		$data_out['sgbd']		= $GLOBALS['sgbd'];
		$data_out['phrase']		= $GLOBALS['phrase'];
		$data_out['page']		= "Install_Nouvelle.php";

	} else {
		Lib_myLog("Le fichier existe, on affiche la page des mises a jour");
	}
}

/**
* - Cas Install_Verifier :
* . 
*		Le cas Install_Verifier patati patata....
*/
function Install_Verifier($data_in = array())
{
	global $lang, $MSG, $data_in, $data_out, $data_srv, $catalogue, $ip;
	$continue = true;
	$lang = $data_in['lang'];
	/*=============*/ Lib_myLog("Langue recuperee: $lang");	

	// On initialise la variable COOKIE pour la langue car setcookie n'est valide qu'a
	// partir de l'affichage de la page suivante, pas pour la page en cours...
	$_COOKIE['lang'] = $lang;
	setcookie('lang',$lang);

	Lib_myLog("Verification des donnees rentrees dans la page de saisie");
	
	if ($continue && !isset($data_in['bdd']) || $data_in['bdd'] == '') {
		Lib_myLog("bdd vide!");
		$message = $MSG[$lang]['%%Action_ErreurBdd%%'];
		$continue = false;
	}

	if ($continue && !isset($data_in['login']) || $data_in['login'] == '') {
		Lib_myLog("login vide!");
		$message = $MSG[$lang]['%%Action_ErreurLogin%%'];
		$continue = false;
	}

	if ($continue && !isset($data_in['mdp']) || $data_in['mdp'] == '') { 
		Lib_myLog("mdp vide!");
		$message = $MSG[$lang]['%%Action_ErreurMdp%%'];
		$continue = false;
	}

	/*
	if ($continue && !isset($data_in['phrase']) || $data_in['phrase'] == '') {
		Lib_myLog("phrase vide!");
		$message = $MSG[$lang]['%%Action_ErreurPhrase%%'];
		$continue = false;
	}
	*/
	
	if ($continue) {
		call_user_func("Install_Installer");
	} else {
		// Si erreur, on affiche Install_Nouvelle a nouveau avec le message d'erreur
		$data_out['message']	= $message;
		$data_out['bdd']		= $data_in['bdd'];
		$data_out['login']		= $data_in['login'];
		$data_out['mdp']		= $data_out['mdp_bis'] = $data_in['mdp'];
		$data_out['serveur']	= $data_in['serveur'];
		$data_out['prefix']		= $data_in['prefix'];
		$data_out['instance']	= $data_in['instance'];
		$data_out['sgbd']		= $data_in['sgbd'];
		$data_out['phrase']		= $data_in['phrase'];
		$data_out['page']		= "Install_Nouvelle.php";
	}
}

/**
* - Cas Install_Installer :
* . 
*		Le cas Install_Installer patati patata....
*/
function Install_Installer($data_in = array())
{
	global $lang, $MSG, $data_in, $data_out, $data_srv, $catalogue, $ip;
	$continue = true;

	//-------------------------------------------------
	// Tout d'abord, on verifie si le user existe deja
	//-------------------------------------------------
	Lib_myLog("Tentative de connexion avec l'utilisateur ".$data_in['login']);
	$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionUser%%']." ".$data_in['login'];
	$db_link = @mysql_connect($data_in['serveur'],$data_in['login'],$data_in['mdp']);

	if($db_link) {
		Lib_myLog("Connexion reussie");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionUserOK%%'];
	} else {
		Lib_myLog("Erreur de connexion");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionUserKO%%'];
	}

	//-------------------------------------------------
	// On essaye d'ouvrir la base
	//-------------------------------------------------
	if ($continue) {
		Lib_myLog("Tentative d'ouverture de la base de donnees");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionBase%%'];
		$res = @mysql_select_db($data_in['bdd']);

		if ($res) {
			 Lib_myLog("Ouverture reussie");
			 $data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionBaseOK%%'];
		} else {
			 Lib_myLog("Erreur d'ouverture");
			 $data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConnexionBaseKO%%'].": ".mysql_error();
			 $continue = false;
		}
	}

	//-------------------------------------------------
	// Maintenant que la base est ouverte, on essaye de creer les tables systeme
	//-------------------------------------------------
	if ($continue) {
		Lib_myLog("Tentative de creation des tables systeme");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesSysteme%%'];

		$sql_file = "dilasys_MDD.sql";
		$sizes_array = Sql_getSqlLenghts($sql_file);
		$handle = @fopen($sql_file, "r");

		foreach($sizes_array as $size_unit) {
			$sql_query = @fread($handle, $size_unit);
			if ($sql_query != '') {
				if (get_magic_quotes_runtime() == 1) 
				 $sql_query = stripslashes($sql_query);

				$sql_query = trim($sql_query);
				$sql_query = Sql_getSqlTxt($sql_query);
				$sql_query = preg_replace("`%%prefix%%`", $data_in['prefix'], $sql_query);

				$result = Sql_exec($sql_query);

				if (!$result) {
					$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesSystemeKO%%'].": ".mysql_error();
					$continue = false;
					break;
				}
			}
		}
	}

	if ($continue) {
		Lib_myLog("Creation tables systeme reussie");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesSystemeOK%%'];

		Lib_myLog("Tentative de creation des autres tables");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesAutres%%'];

		$sql_file = "./config/MDD.sql";
		$sizes_array = Sql_getSqlLenghts($sql_file);
		$handle = @fopen($sql_file, "r");

		foreach($sizes_array as $size_unit) {
			$sql_query = fread($handle, $size_unit);
			if ($sql_query != '') {
				if (get_magic_quotes_runtime() == 1) 
				 $sql_query = stripslashes($sql_query);

				$sql_query = trim($sql_query);
				$sql_query = Sql_getSqlTxt($sql_query);
				$sql_query = preg_replace("`%%prefix%%`", $data_in['prefix'], $sql_query);

				$result = Sql_exec($sql_query);

				if (!$result) {
					$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesAutresKO%%'].": ".mysql_error();
					$continue = false;
					break;
				}
			}
		}
	}

	if ($continue) {
		Lib_myLog("Creation autres tables reussie");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeCreationTablesAutresOK%%'];

		Lib_myLog("Ajout des modules autorises");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeAjoutModulesAutorises%%'];

		$sql_file = "./config/modules.sql";
		$sizes_array = Sql_getSqlLenghts($sql_file);
		$handle = fopen($sql_file, "r");

		foreach($sizes_array as $size_unit) {
			$sql_query = fread($handle, $size_unit);
			if ($sql_query != '') {
				if (get_magic_quotes_runtime() == 1) 
				 $sql_query = stripslashes($sql_query);

				$sql_query = trim($sql_query);
				$sql_query = Sql_getSqlTxt($sql_query);	
				$sql_query = preg_replace("`%%prefix%%`", $data_in['prefix'], $sql_query);

				$result = Sql_exec($sql_query);

				if (!$result) {
					$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeAjoutModulesAutorisesKO%%'].": ".mysql_error();
					$continue = false;
					break;
				}
			}
		}
	 }

	if ($continue) {
		Lib_myLog("Ajout des modules autorises reussi");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeAjoutModulesAutorisesOK%%'];
	}

	//-------------------------------------------------
	// On cree le fichier de conf
	//-------------------------------------------------
	if ($continue) {
		Lib_myLog("Configuration du fichier de conf");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConfigurationConf%%'];

		$conf = file('dilasys_conf.txt');
		$conf = implode($conf, "");

		$Out = preg_replace("`%%bdd%%`", $data_in['bdd'], $conf);
		$Out = preg_replace("`%%login%%`", $data_in['login'], $Out);
		$Out = preg_replace("`%%mdp%%`", $data_in['mdp'], $Out);
		$Out = preg_replace("`%%serveur%%`", $data_in['serveur'], $Out);
		$Out = preg_replace("`%%prefix%%`", $data_in['prefix'], $Out);
		$Out = preg_replace("`%%instance%%`", $data_in['instance'], $Out);
		$Out = preg_replace("`%%sgbd%%`", $data_in['sgbd'], $Out);
		$Out = preg_replace("`%%phrase%%`", $data_in['phrase'], $Out);
		$Out = preg_replace("`\r\n`", "\n", $Out);

		Lib_myLog("Creation du fichier conf pour la partie privee (administration)");
		$handle = fopen('../conf.php','w+');
		fwrite($handle,$Out);
		fclose($handle);

		Lib_myLog("Configuration terminee");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConfigurationConfOK%%'];
	}

	//-------------------------------------------------
	// On cree le fichier de params
	//-------------------------------------------------
	if ($continue) {
		Lib_myLog("Configuration du fichier params");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConfigurationParams%%'];

		$conf = file('dilasys_params.txt');
		$conf = implode($conf, "");

		$Out = preg_replace("`%%bdd%%`", $data_in['bdd'], $conf);
		$Out = preg_replace("`\r\n`", "\n", $Out);

		$var = "";
		foreach($GLOBALS['auth_modules'] as $module) 
			$var .= "\"$module\",\n";
		$Out = preg_replace("`%%modules%%`", $var, $Out);

		$var = "";
		if (isset($GLOBALS['auth_tables'])) 
			foreach($GLOBALS['auth_tables'] as $table) 
				$var .= "\"".$table."\",\n";
		$Out = preg_replace("`%%tables%%`", $var, $Out);

		Lib_myLog("Creation du fichier params");
		$handle = fopen('../params.php','w+');
		fwrite($handle,$Out);
		fclose($handle);

		Lib_myLog("Configuration terminee");
		$data_out['etapes'][] = $MSG[$lang]['%%Action_EtapeConfigurationParamsOK%%'];
	}

	if ($continue) {
			 // Sinon, message d'erreur indiquant qu'il n'est pas possible d'installer le systeme avec ce user
		$data_out['message'] = "Installation réussie !";
		$data_out['page'] = "Install_Resultat.php";
	} else {
		$data_out['message'] = "MEEEEEEEEEEEEERDE!!!";
		$data_out['page'] = "Install_Resultat.php";
	}
}

call_user_func($data_in['action']);
include('post.php');
Lib_myLog("OUT: ",$data_out);
return $data_out;
?>