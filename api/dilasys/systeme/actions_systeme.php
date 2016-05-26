<?
function ParametresSysteme_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation des valeurs positionnees dans le conf.php de la racine du systeme");
	global $db1, $dbuser1, $serveur_mysql1, $prefix, $systeme, $lang;
	/*=============*/ Lib_myLog("Recuperation des parametres de l'utilisateur system");
	$parametres = Parametres_chercher(1);
	foreach($parametres as $parametre) {
		$data_out['params'][$parametre['code_parametre']] = $parametre['designation'];
	}
	$data_out['params']['DB'] = $db1;
	$data_out['params']['DBUSER'] = $dbuser1;
	$data_out['params']['SERVEUR_MYSQL'] = $serveur_mysql1;
	$data_out['params']['PREFIX'] = $prefix;
	$data_out['action'] = "ParametresSysteme_Consulter";
	$data_out['page'] = 'ParametresSysteme_Consulter.php';
}

function Autorisations_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation des IPs autorisees de la base");
	$data_out['tab_ips_autorisees'] = Autorisation_chercher('*');

	/*=============*/ Lib_myLog("Recuperation des IPs interdites de la base");
	$data_out['tab_ips_interdites'] = Interdictions_chercher('*');

	/*=============*/ Lib_myLog("Recuperation de la liste de groupes de la base");
	$data_out['tab_groupes'] = Groupes_chercher('*');

	$data_out['action'] = "Autorisations_Consulter";
	$data_out['page'] = 'Autorisations_Consulter.php';
}

function Autorisations_Verifier($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;

	if ($continue && $data_in['id_groupe'] == "") {
		/*=============*/ Lib_myLog("Erreur: L'identification du groupe n'a pas ete saisie");
		$data_out['message_ko'] = $MSG[$lang]['%%Action_ErreurGroupe%%'];
		$continue = false;
	}

	if ($continue && $data_in['adresse_ip'] == "") {
		/*=============*/ Lib_myLog("Erreur: L'adresse IP n'a pas ete saisie");
		$data_out['message_ko'] = $MSG[$lang]['%%Action_ErreurIp%%'];
		$continue = false;
	}

	if ($continue) {
		/*=============*/ Lib_myLog("Creation nouvel objet Autorisation");
		$autorisation = new Autorisation();
		/*=============*/ Lib_myLog("Positionnement de l'IdGroupe ".$data_in['id_groupe']." et de l'adresse IP ".$data_in['adresse_ip']);
		$autorisation->id_groupe  = $data_in['id_groupe'];
		$autorisation->adresse_ip = $data_in['adresse_ip'];

		$data_in['action'] = 'Autorisations_ADD';
		call_user_func('Autorisations_ADD', $data_in);
	} else {
		$data_in['action'] = 'Autorisations_Consulter';
		call_user_func('Autorisations_Consulter', $data_in);
	} 
}

function Autorisations_ADD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Ajout en base de la nouvelle autorisation en base");
	$autorisation->ADD();

	$data_out['message_ok'] = $MSG[$lang]['%%autorisation_ADD%%'];
	$data_in['action'] = 'Autorisations_Consulter';
	call_user_func('Autorisations_Consulter', $data_in);
}

function Autorisations_DEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression de l'autorisation en base");
	Autorisation_supprimer($data_in['id_groupe'],$data_in['adresse_ip']);

	$data_out['message_ok'] = $MSG[$lang]['%%autorisation_DEL%%'];
	$data_in['action'] = 'Autorisations_Consulter';
	call_user_func('Autorisations_Consulter', $data_in);
}

function Interdictions_DEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression de l'interdiction en base");
	$interdiction = Interdiction_recuperer($data_in['nom_utilisateur'],$data_in['adresse_ip']);
	$interdiction->DEL();

	$data_out['message_ok'] = $MSG[$lang]['%%interdiction_DEL%%'];
	$data_in['action'] = 'Autorisations_Consulter';
	call_user_func('Autorisations_Consulter', $data_in);
}

function Utilisateurs_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation de la liste des utilisateurs de la base");
	$data_out['tab_groupes'] = Groupes_chercher('*');
	$data_out['tab_users'] = Utilisateurs_chercher('*');

	$data_out['action'] = "Utilisateurs_Consulter";
	$data_out['page'] = 'Utilisateurs_Consulter.php';
}

function Utilisateurs_Verifier($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;

	// On vérifie que l'utilisateur n'existe pas déjà
	if ($continue) {
		$utilisateur = Utilisateur_recuperer($data_in['nom_utilisateur']);
		
		if ($utilisateur->id_utilisateur) {
			/*=============*/ Lib_myLog("Le nom d'utilisateur existe deja");
			$data_out['message_ko'] = $MSG[$lang]['%%Action_ErreurUtilisateurExistant%%'];
			$continue = false;
		}
	}

	if($continue) {
		$data_in['action'] = 'Utilisateurs_ADD';
		call_user_func('Utilisateurs_ADD', $data_in);
	} else {
		$data_in['action'] = 'Utilisateurs_Consulter';
		call_user_func('Utilisateurs_Consulter', $data_in);
	}
}

function Utilisateurs_VerifierModification($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;
	$id = $data_in['id_utilisateur'];

	if($continue) {
		$utilisateur = Utilisateur_Recuperer($data_in['id_utilisateur']);
		$utilisateur->nom_utilisateur = $data_in['nom_utilisateur'];
		$utilisateur->nom_groupe = $data_in['nom_groupe'];
		$utilisateur->nb_connect = $data_in['nb_connect'];
		// Si l'administrateur n'a pas saisi de nouveau mot de passe, on garde l'ancien
		$password = ($data_in['password'] != "") ? $data_in['password'] : $utilisateur->password;
		$utilisateur->password = $password;
		$data_in['action'] = 'Utilisateurs_UPD';
		call_user_func('Utilisateurs_UPD', $data_in);
	} else {
		$data_in['action'] = 'Utilisateurs_Consulter';
		call_user_func('Utilisateurs_Consulter', $data_in);
	}
}

function Utilisateurs_ADD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Creation nouvel objet Utilisateur");
	$utilisateur = new Utilisateur();
	$utilisateur->nom_utilisateur = $data_in['nom_utilisateur'];
	$utilisateur->nom_groupe = $data_in['nom_groupe'];
	$utilisateur->password = $data_in['password'];
	$utilisateur->nb_connect = $data_in['nb_connect'];
	$utilisateur->etat = 'actif';
	$data_in['utilisateur'] = $utilisateur;

	$utilisateur = $data_in['utilisateur'];
	$nom_groupe = $utilisateur->nom_groupe;

	/*=============*/ Lib_myLog("Ajout en base du nouvel utilisateur");
	$id_utilisateur = $utilisateur->ADD();

	$data_out['message_ok'] = $MSG[$lang]['%%utilisateur_ADD%%'];
	$data_in['action'] = 'Utilisateurs_Consulter';
	call_user_func('Utilisateurs_Consulter', $data_in);
}

function Utilisateurs_DEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression de l'utilisateur avec l'identifiant ".$data_in['id_utilisateur']." de la base");
	$utilisateur = Utilisateur_recuperer($data_in['id_utilisateur']);
	$utilisateur->DEL();

	$data_out['message_ok'] = $MSG[$lang]['%%utilisateur_DEL%%'];
	$data_in['action'] = 'Utilisateurs_Consulter';
	call_user_func('Utilisateurs_Consulter', $data_in);
}

function Utilisateurs_UPD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Mise a jour des parametres en base pour l'utilisateur");
	$utilisateur->UPD();

	$data_out['message_ok'] = $MSG[$lang]['%%utilisateur_UPD%%'];
	$data_in['action'] = 'Utilisateurs_Consulter';
	call_user_func('Utilisateurs_Consulter', $data_in);
}

function Groupes_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation de la liste des modules autorises");
	$data_out['liste_modules'] = $GLOBALS['MODULES'];

	/*=============*/ Lib_myLog("Recuperation de la liste des groupes d'utilisateurs de la base");
	$data_out['tab_groupes'] = Groupes_chercher('*');

	$data_out['action'] = "Groupes_Consulter";
	$data_out['page'] = 'Groupes_Consulter.php';
}

function Groupes_Verifier($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;

	// On vérifie que le groupe n'existe pas déjà
	if ($continue) {
		$groupe = Groupe_recuperer($data_in['nom_groupe']);

		if ($groupe->id_groupe != '') {
			/*=============*/ Lib_myLog("Le groupe existe deja");
			$data_out['message_ko'] = $MSG[$lang]['%%Action_ErreurGroupeExistant%%'];
			$continue = false;
		}
	}

	if($continue) {
		$data_in['action'] = 'Groupes_ADD';
		call_user_func('Groupes_ADD', $data_in);
	} else {
		$data_in['action'] = 'Groupes_Consulter';
		call_user_func('Groupes_Consulter', $data_in);
	}
}

function Groupes_ADD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation de la liste des modules autorises");
	$liste_modules = $GLOBALS['MODULES'];

	/*=============*/ Lib_myLog("Creation nouveau Groupe");
	$groupe = new Groupe();
	$groupe->nom_groupe = $data_in['nom_groupe'];
	$groupe->nb_connect_defaut = $data_in['nb_connect_defaut'];

	foreach($liste_modules as $module) {
		/*=============*/ Lib_myLog("Rajout du module $module au groupe");
		if (isset($data_in[$module])) {
			$groupe->addModule($module);
		}
	}

	/*=============*/ Lib_myLog("Ajout en base du nouveau groupe");
	$id_groupe = $groupe->ADD();

	$data_out['message_ok'] = $MSG[$lang]['%%groupe_ADD%%'];
	$data_in['action'] = 'Groupes_Consulter';
	call_user_func('Groupes_Consulter', $data_in);
}

function Groupes_DEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression du groupe avec l'identifiant ".$data_in['id_groupe']." de la base");
	$groupe = Groupe_recuperer($data_in['id_groupe']);
	$groupe->DEL();

	$data_out['message_ok'] = $MSG[$lang]['%%groupe_DEL%%'];
	$data_in['action'] = 'Groupes_Consulter';
	call_user_func('Groupes_Consulter', $data_in);
}

function Groupes_VerifierModification($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;
	$id = $data_in['id_groupe'];

	if($continue) {
		$data_in['action'] = 'Groupes_UPD';
		call_user_func('Groupes_UPD', $data_in);
	} else {
		$data_in['action'] = 'Groupes_Consulter';
		call_user_func('Groupes_Consulter', $data_in);
	}
}

function Groupes_UPD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Recuperation de la liste des modules autorises");
	$liste_modules = $GLOBALS['MODULES'];

	$groupe = Groupe_recuperer($data_in['id_groupe']);
	$groupe->nom_groupe = $data_in['nom_groupe'];
	$groupe->nb_connect_defaut = $data_in['nb_connect_defaut'];

	// On supprime tous les modules que pouvait avoir le groupe auparavant
	$groupe->modules = array();
	foreach($liste_modules as $module) {
		/*=============*/ Lib_myLog("Rajout du module $module au groupe");
		if (isset($data_in[$module])) {
			$groupe->addModule($module);
		}
	}

	/*=============*/ Lib_myLog("Mise a jour du groupe");
	$groupe->UPD();

	$data_out['message_ok'] = $MSG[$lang]['%%groupe_UPD%%'];
	$data_in['action'] = 'Groupes_Consulter';
	call_user_func('Groupes_Consulter', $data_in);
}

function Groupe_DroitsADD($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	// On récupère le profil de base pour avoir tous les champs et modules auxquels le nouveau groupe peut accéder
	$groupe = Groupe_recuperer($data_in['nom_groupe']);
	$groupe->addDroits($data_in['champ'], 3);
	$groupe->UPD();

	$data_out['nom_groupe'] = $data_in['nom_groupe'];
	$data_out['nom_groupe'] = $data_in['nom_groupe'];
	$data_in['action'] = 'AJAX_DroitsGroupe';
	call_user_func('AJAX_DroitsGroupe', $data_in);
}

function Groupe_DroitsDEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	// On récupère le profil de base pour avoir tous les champs et modules auxquels le nouveau groupe peut accéder
	$groupe = Groupe_recuperer($data_in['nom_groupe']);
	$groupe->delDroits($data_in['champ']);
	$groupe->UPD();

	$data_out['nom_groupe'] = $data_in['nom_groupe'];
	$data_out['nom_groupe'] = $data_in['nom_groupe'];
	$data_in['action'] = 'AJAX_DroitsGroupe';
	call_user_func('AJAX_DroitsGroupe', $data_in);
}

function AJAX_DroitsGroupe($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$groupe = Groupe_recuperer($data_in['nom_groupe']);
	$groupe_tab = $groupe->getTab();
	foreach($groupe_tab['droits'] as $champ => $droits)
		 $data_out[$champ] = $droits;

	$data_out['nom_groupe'] = $data_in['nom_groupe'];
	$data_out['page'] = 'AJAX_DroitsGroupe.php';
}

function Sauvegarde_Importer($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;
	$fichier_sauvegarde = $_FILES['sauvegarde']['name'];
	$basename = basename($fichier_sauvegarde, ".sql");

	if ($fichier_sauvegarde == "") {
		/*=============*/ Lib_myLog("Nom sauvegarde non fournie");
		$continue = false;
	}

		if (!eregi("sql", $fichier_sauvegarde) && !eregi("cry", $fichier_sauvegarde)) {
				/*=============*/ Lib_myLog("Fichier interdit!");
			$data_out['message_ko'] = $MSG[$lang]['%%FichiersInterdits%%'];
			$continue = false;
		}


	if ($continue) {
		$sauvegarde = DIR."data/".$fichier_sauvegarde;

	/*=============*/ Lib_myLog("Deplacement du fichier telecharge");
		if (is_uploaded_file($_FILES['sauvegarde']['tmp_name'])) {
			// Contrôle de l'extension du fichier
			rename($_FILES['sauvegarde']['tmp_name'], $sauvegarde);
		}
		chmod ("$sauvegarde", 0644);

		$hd = 0;
		$tab_file = file($sauvegarde);
		foreach($tab_file as $ligne) {
			$ajout_ligne = true;
			if (ereg("(# Fichier: )([0-9a-z_]*.[sqlxtr]*).*", $ligne, $res)) {
				/*=============*/ Lib_myLog("Creation d'un nouveau fichier: ${res[2]}");
				if ($hd) fclose($hd);
				if (ereg("sql", $ligne))
					$file = DIR."data/".$basename."_".$res[2];
				if (ereg("xtr", $ligne))
					$file = DIR."data/".$res[2];
				$hd = fopen($file, "w+");
				$ajout_ligne = false;
			}
			if ($ajout_ligne && $hd) fputs($hd, $ligne);
		}
		if ($hd) fclose($hd);

		if ($result == "") $data_out['message_ok'] = $MSG[$lang]['%%ImportationOK%%'];
	}

	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function AfficherSauvegarde($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$datadir = DIR."data/";
	$data_out['liste_sauvegardes'] = array();
	if ($handle = opendir($datadir)) {
		while (false != ($file = readdir($handle))) {
			if (ereg(".xtr", $file)) {
				// On lit le fichier contenant l'état de la sauvegarde
				if($hd=fopen($datadir.$file,"r") ){
					$auth_tables=unserialize( fread( $hd, filesize($datadir.$file)) );
					fclose( $hd );
					/*=============*/ Lib_myLog("Etat des sauvegardes ", $auth_tables);
					// On parcourt l'ensemble des tables et l'état global de la sauvegarde est donné par 
					// l'état de la dernière table 
					if (is_array($auth_tables))
							foreach($auth_tables as $table => $etat) 
								$data_out['liste_sauvegardes'][$file] = $etat;
				}
			}

			if (ereg("([0-9]{8})_([0-9]{6}).sql", $file) && !file_exists(DIR."data/".basename($file, "sql")."xtr")) {
					$hd = 0;
					$basename = basename($file, ".sql");
					// $tab_file = file(DIR."data/".$file);
					// foreach($tab_file as $ligne) {
					$fd = fopen (DIR."data/".$file, "r");
					while (!feof ($fd)) {
						$ligne = fgets($fd, 4096);
						$ajout_ligne = true;
						if (ereg("(# Fichier: )([0-9a-z_]*.[sqlxtr]*).*", $ligne, $res)) {
							/*=============*/ Lib_myLog("Creation d'un nouveau fichier: ${res[2]}");
							if ($hd) fclose($hd);
							if (ereg("sql", $ligne))
								$file = DIR."data/".$basename."_".$res[2];
							if (ereg("xtr", $ligne))
								$file = DIR."data/".$res[2];
							$hd = fopen($file, "w+");
							$ajout_ligne = false;
						}
						if ($ajout_ligne && $hd) fputs($hd, $ligne);
					}
					if ($hd) fclose($hd);
					if ($fd) fclose($fd);
			}
		}
		closedir($handle);
	}

	$data_out['action'] = "AfficherSauvegarde";
	$data_out['page'] = 'Sauvegarde.php';
}

function Restauration($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$datadir  = DIR."data/";
	$xtr_file = $datadir.$data_in['sauvegarde'];
	$basename = basename($xtr_file,".xtr");

	// On récupère la liste des tables
	if( is_file($xtr_file) && file_exists($xtr_file) && $hd=fopen($xtr_file,"r") ){
		$tmp_tables=unserialize( fread( $hd, filesize( $xtr_file )) );
		fclose( $hd );
	}

	// On "marque" les tables avec un 2 pour indiquer que l'on a commencé un processus de restauration
	foreach($tmp_tables as $table => $etat) 
		$auth_tables[$table] = 2;

	if( $hd=fopen($xtr_file, "w+" ) ){
		fputs( $hd, serialize($auth_tables) );
		fclose( $hd );
	}

	// Pour chaque table à traiter on commence la restauration
	foreach($tmp_tables as $table => $etat) {
		/*=============*/ Lib_myLog("Restauration table $table ");
		$sql_file = $datadir.$basename."_".$table.".sql";

		if ($GLOBALS['encrypt']) {
			/*=============*/ Lib_myLog("Decryptage du fichier");
			Lib_fileDecrypt($sql_file, $sauvegarde_decryptee);
		}
		if (!$GLOBALS['encrypt']) $sauvegarde_decryptee = $sql_file;

		/*=============*/ Lib_myLog("Execution du fichier SQL");
		$result = Sql_execSqlFile($sauvegarde_decryptee);

		// Si on arrive ici c'est que la table a bien été restaurée. 
		// On écrase le fichier avec l'état des tables restaurées...
		$auth_tables[$table] = 3;
		if( $hd=fopen($xtr_file, "w+" ) ){
			fputs( $hd, serialize($auth_tables) );
			fclose( $hd );
		}
	}

	if ($result != "") $data_out['message_ko'] = $result;
	if ($result == "") $data_out['message_ok'] = $MSG[$lang]['%%FinRestauration%%'];

	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function CompleterRestauration($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$datadir  = DIR."data/";
	$xtr_file = $datadir.$data_in['sauvegarde'];
	$basename = basename($xtr_file,".xtr");

	// On récupère la liste des tables sauvegardées
	if( is_file($xtr_file) && file_exists($xtr_file) && $hd=fopen($xtr_file,"r") ){
		$tmp_tables=unserialize( fread( $hd, filesize( $xtr_file )) );
		fclose( $hd );
	}
	/*=============*/ Lib_myLog("Etat de la restauration: ", $tmp_tables);
	$auth_tables = $tmp_tables;

	// Pour chaque table à traiter on commence la sauvegarde
	foreach($tmp_tables as $table => $etat) {
		// Si l'état vaut 3 c'est que la table a déjà été sauvegardée.. On passe à la suivante...
		if ($etat == 3) continue;

		/*=============*/ Lib_myLog("Restauration table $table ");
		$sql_file = $datadir.$basename."_".$table.".sql";

		if ($GLOBALS['encrypt']) {
			/*=============*/ Lib_myLog("Decryptage du fichier");
			Lib_fileDecrypt($sql_file, $sauvegarde_decryptee);
		}
		if (!$GLOBALS['encrypt']) $sauvegarde_decryptee = $sql_file;

		/*=============*/ Lib_myLog("Execution du fichier SQL");
		$result = Sql_execSqlFile($sauvegarde_decryptee);

		// Si on arrive ici c'est que la table a bien été restaurée. 
		// On écrase le fichier avec l'état des tables restaurées...
		$auth_tables[$table] = 3;
		if( $hd=fopen($xtr_file, "w+" ) ){
			fputs( $hd, serialize($auth_tables) );
			fclose( $hd );
		}
	}

	if ($result != "") $data_out['message_ko'] = $result;
	if ($result == "") $data_out['message_ok'] = $MSG[$lang]['%%FinRestauration%%'];

	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function Sauvegarde($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$ext = date("dmY_His");
	$datadir = DIR."data/";
	$xtr_file = $datadir.$ext.".xtr";
	$bz_file  = $datadir.$ext.".cry";
	$data_out['message_ok'] = $data_out['message_ko'] = "";

	// On récupère la liste des tables à sauvegarder à partir de la config
	// et on construit le fichier de sauvegarde
	$tmp_tables = $GLOBALS['AUTH_TABLES'];
	foreach($tmp_tables as $table) {
		$table = ereg_replace("%%prefix%%", $GLOBALS['prefix'], $table);
		$auth_tables[$table] = 0;
	}

	if( $hd=fopen($xtr_file, "w+" ) ){
		fputs( $hd, serialize($auth_tables) );
		fclose( $hd );
	}

	// Pour chaque table à traiter on commence la sauvegarde
	foreach($tmp_tables as $table) {
		$table = ereg_replace("%%prefix%%", $GLOBALS['prefix'], $table);
		/*=============*/ Lib_myLog("Sauvegarde table $table ");
		$sql_file = $datadir.$ext."_".$table.".sql";

		/*=============*/ Lib_myLog("Sauvegarde dans $sql_file");
		Sql_buildSqlFile($sql_file, '', $table);
		if ($GLOBALS['encrypt']) Lib_fileCrypt($sql_file,$bz_file);

		// Si on arrive ici c'est que la table a bien été sauvegardée. 
		// On écrase le fichier avec l'état des tables sauvegardées...
		$auth_tables[$table] = 1;
		if( $hd=fopen($xtr_file, "w+" ) ){
			fputs( $hd, serialize($auth_tables) );
			fclose( $hd );
		}
	}

	$data_out['message_ok'] = $MSG[$lang]['%%FinSauvegarde%%'];

	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function CompleterSauvegarde($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$datadir  = DIR."data/";
	$xtr_file = $datadir.$data_in['sauvegarde'];
	$basename = basename($xtr_file,".xtr");
	$data_out['message_ok'] = $data_out['message_ko'] = "";

	// On récupère la liste des tables sauvegardées
	if( is_file($xtr_file) && file_exists($xtr_file) && $hd=fopen($xtr_file,"r") ){
		$auth_tables=unserialize( fread( $hd, filesize( $xtr_file )) );
		fclose( $hd );
	}
	/*=============*/ Lib_myLog("Etat de la sauvegarde: ", $auth_tables);

	// Pour chaque table à traiter on commence la sauvegarde
	foreach($auth_tables as $table => $etat) {
		// Si l'état vaut 1 c'est que la table a déjà été sauvegardée.. On passe à la suivante...
		if ($etat) continue;

		/*=============*/ Lib_myLog("Sauvegarde table $table ");
		$sql_file = $datadir.$basename."_".$table.".sql";

		/*=============*/ Lib_myLog("Sauvegarde dans $sql_file");
		Sql_buildSqlFile($sql_file, '', $table);
		if ($GLOBALS['encrypt']) Lib_fileCrypt($sql_file,$bz_file);

		// Si on arrive ici c'est que la table a bien été sauvegardée. 
		// On écrase le fichier avec l'état des tables sauvegardées...
		$auth_tables[$table] = 1;
		if( $hd=fopen($xtr_file, "w+" ) ){
			fputs( $hd, serialize($auth_tables) );
			fclose( $hd );
		}
	}

	$data_out['message_ok'] = $MSG[$lang]['%%FinSauvegarde%%'];

	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function Sauvegarde_DEL($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression de la sauvegarde $sauvegarde"); 
	$datadir = DIR."data/";
	$basename = basename($data_in['sauvegarde'],".xtr");

	if ($handle = opendir($datadir)) {
		while (false != ($file = readdir($handle))) {
			if (ereg($basename, $file))
					unlink($datadir.$file);
		}
		closedir($handle);
	}

	$data_out['message_ok'] = $MSG[$lang]['%%SauvegardeSupprimee%%'];
	$data_in['action'] = 'AfficherSauvegarde';
	call_user_func('AfficherSauvegarde', $data_in);
}

function Sauvegarde_FTP($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	// Tout d'abord on réunit tous les fichiers de la sauvegarde en un seul fichier
	$datadir  = DIR."data/";
	$xtr_file = $datadir.$data_in['sauvegarde'];
	$basename = basename($xtr_file,".xtr");
	$crlf	= Lib_endOfLine();

	// On récupère la liste des tables sauvegardées
	if( is_file($xtr_file) && file_exists($xtr_file) && $hd=fopen($xtr_file,"r") ){
		$auth_tables=unserialize( fread( $hd, filesize( $xtr_file )) );
		fclose( $hd );
	}

	/*=============s*/ Lib_myLog("Creation du fichier sql global"); 
	$ftp_file = $datadir.$basename.'.sql';
	$ftp_hd = fopen($ftp_file, 'w+');

	/*=============s*/ Lib_myLog("Ajout du fichier descriptif xtr"); 
	$hd = fopen($xtr_file,"r");
	$str = "# Fichier: ${data_in['sauvegarde']}$crlf";
	$str .= fread($hd, filesize($xtr_file));
	$str .= $crlf;
	fwrite($ftp_hd, $str);
	fclose($hd);

	// Pour chaque table on récupère le fichier et on rajoute au fichier total
	foreach($auth_tables as $table => $etat) {
		/*=============*/ Lib_myLog("Ajout du fichier sql de la table $table ");
		$sql_file = $datadir.$basename."_".$table.".sql";
		$hd = fopen($sql_file,"r");
		$str = "# Fichier: $basename_$table.sql$crlf";
		$str .= fread($hd, filesize($sql_file));
		fwrite($ftp_hd, $str);
		fclose($hd);
	}

	fclose($ftp_hd);

	// Obligés de nettoyer le buffer de sortie sinon les %%prefix%% sont remplacés!  
	ob_end_clean();

	$size = filesize($ftp_file);
	$filename = $basename.".sql";
	header("Content-Type: application/octet-stream"); 
	header("Content-Length: $size"); 
	header("Content-Disposition: attachment; filename=$filename"); 
	header("Content-Transfer-Encoding: binary"); 
	$fh = fopen("$ftp_file", "r"); 
	fpassthru($fh); 
}

function Fichiers_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;
	$racinedusite = $GLOBALS['racinedusite']; //root directory, set to "." for same or ".." for a lower level
	$data_out['racinedusite'] = $racinedusite;

	if (!is_dir($racinedusite)) {
		/*=============s*/ Lib_myLog("Erreur d'ouverture du repertoire");
		$data_out['message_ko'] = $MSG[$lang]['%%Action_ErreurRepertoire%%'];
		$continue = false;
	}

	if ($continue) {
		/*=============s*/ Lib_myLog("Nettoyage des fichiers temporaires");
		$current_dir = opendir("temp/");
		while($entryname = readdir($current_dir))
		{
			// Check dates, files older than 20 minutes are thrown away
			if(!(is_dir("temp/$entryname")) and ($entryname != "." and $entryname!="..")and filectime("temp/$entryname")<(time()-1200)) {
				unlink ("temp/$entryname");
			}
		}
		closedir($current_dir);

		/*=============s*/ Lib_myLog("Recuperation de l'arborescence");
		$data_out['liste_repertoires'] = getdir($racinedusite, '', 1);     

		clearstatcache();
	}

	$data_out['action'] = "Fichiers_Consulter";
	$data_out['page'] = 'Fichiers_Consulter.php';
}

function Documentation_Consulter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$data_out['action'] = "Documentation_Consulter";
	$data_out['page'] = "Documentation_Consulter.php";
}

function AJAX_ModifGroupe($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$groupe = Groupe_recuperer($data_in['id_groupe']);
	$data_out = $groupe->getTab();

	/*=============*/ Lib_myLog("Recuperation de la liste des modules autorises");
	$data_out['liste_modules'] = $GLOBALS['MODULES'];

	$data_out['page'] = 'AJAX_ModifGroupe.php';
}

function AJAX_ModifUtilisateur($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$utilisateur = Utilisateur_recuperer($data_in['id_utilisateur']);
	$data_out = $utilisateur->getTab();

	/*=============*/ Lib_myLog("Recuperation de la liste des groupes configures");
	$data_out['tab_groupes'] = Groupes_chercher('*');

	$data_out['page'] = 'AJAX_ModifUtilisateur.php';
}
?>