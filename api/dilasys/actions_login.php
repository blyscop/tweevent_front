<?
/**
* - Cas Login_AfficheLogin :
* . 
*      Le cas (par défaut) Login_AfficheLogin patati patata....
*/
function Login_AfficheLogin($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$session = $_COOKIE[$GLOBALS['instance'].'_session'];
	$tab_session = Lib_readData('session_'.$session);
	$nom_utilisateur = $tab_session['nom_utilisateur'];

	// Lib_myLog("Session php recuperee: $session");
	if ($session != '' && $session != 'NOSESSION') {
		 Sessions_writeLog($nom_utilisateur,$ip,__DUPE_FORCE_OUT__, $session); 
		 // Lib_myLog("Suppression de la session".$session);
		 $session = $_COOKIE[$GLOBALS['instance'].'_session'];            
		 Lib_deleteTmpFiles($session);
		 setcookie($GLOBALS['instance'].'_session','');
	}

	$lang = (isset($data_in['lang'])) ? $data_in['lang'] : 'fr' ;
	Lib_deleteTmpOldFiles();
	$ip = $_SERVER["REMOTE_ADDR"];
}

/**
* - Cas Login_Quitter :
* . 
*      Le cas Login_Quitter patati patata....
*/
function Login_Quitter($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);


	$session = $_COOKIE[$GLOBALS['instance'].'_session'];
	$tab_session = Lib_readData('session_'.$session);
	$nom_utilisateur = $tab_session['nom_utilisateur'];

	/*=============*/ Lib_myLog("Fermeture de la session ".$session);
	Sessions_writeLog($nom_utilisateur, $ip, __LOG_OUT__, $session);
	Lib_deleteTmpFiles($session);
	if ($GLOBALS['zip_log_files']) Lib_zipLogFile($session);

	unset($_COOKIE[$GLOBALS['instance'].'_session']);
	setcookie($GLOBALS['instance'].'_session','');
	unset($action);
	if(isset($data_in['message'])) $data_out['message'] = $data_in['message'];

	// HTTP 1.1 n'accepte que des url absolues!
	header("Location: http://" . $_SERVER['HTTP_HOST']
			 . rtrim(dirname($_SERVER['PHP_SELF']), '/\\')
			 . "/../Login_Admin.php");
}

/**
* - Cas Login_Nouveau :
* . 
*      Le cas Login_Nouveau patati patata....
*/		
function Login_Nouveau($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;
	preg_match("`([0-9]{2})/([0-9]{2})/([0-9]{4})`", $data_in['date_naissance'], $regs);
	
	/*=============*/ Lib_myLog("Une nouvelle personne tente de s'inscrire. On recherche si elle n'existe pas deja");
	$personnes = BasePersonnes_chercher($data_in['nom'], $data_in['prenom']);

	if (count($personnes) != 0) {
		 /*=============*/ Lib_myLog("Plusieurs personnes portant ce nom et prenom ont ete trouvees");
		 foreach($personnes as $personne) {
			  if ($personne['date_naissance'] == $data_in['date_naissance']) {
					/*=============*/ Lib_myLog("Une personne avec la meme date de naissance a ete trouvee");
					$utilisateurs = Utilisateurs_chercher('', '', $personne['id_personne']);

					if (count($utilisateurs) != 0) {
						 /*=============*/ Lib_myLog("Un login a ete trouve pour cette personne");
						 // On la re-dirige sur la page de login en affichant le formulaire de demande de mot de passe perdu
						 $data_out['message_oubli'] = $MSG[$lang]['%%Action_DoublonPersonne%%'];
						 $data_out['email'] = $data_in['email'];
						 $data_out['date_naissance'] = $data_in['date_naissance'];
						 $data_out['login_oubli_visible'] = 1;
						 $continue = false;
					}

					// On mémorise l'identifiant de la personne trouvée et on sort de la boucle foreach
					$id_personne = $personne['id_personne'];
					break;
			  }
		 }
	}

	if ($continue && !checkdate($regs[2],$regs[1],$regs[3])) {
		 $data_out = $data_in;
		 $data_out['login_nouveau_visible'] = 1;
		 $data_out['message_nouveau'] = $MSG[$lang]['%%Action_ErreurDateNaissance%%'];
		 $continue = false;
	}

	if ($continue && $data_in['mdp_souhaite'] != $data_in['mdp_bis']) {
		 $data_out = $data_in;
		 $data_out['mdp_souhaite'] = $data_out['mdp_bis'] = '';
		 $data_out['login_nouveau_visible'] = 1;
		 $data_out['message_nouveau'] = $MSG[$lang]['%%Action_ErreurDefinitionMDP%%'];
		 $continue = false;
	}

	if ($continue) {
		 $data_out = $data_in;
		 $utilisateurs = Utilisateurs_chercher($data_in['utilisateur_souhaite']);

		 if (count($utilisateurs) != 0) {
			  $data_out['login_nouveau_visible'] = 1;           
			  $data_out['utilisateur_souhaite'] = $data_out['mdp_souhaite'] = $data_out['mdp_bis'] = '';
			  $data_out['message_nouveau'] = $MSG[$lang]['%%Action_UtilisateurExistant%%'];
			  $continue = false;
		 }
	}

	if ($continue) {
		 // Si aucune personne n'avait été trouvée précédemment, on rajoute la personne
		 if (!isset($id_personne)) {
			  /*=============*/ Lib_myLog("Ajout du nouvel objet personne");
			  $personne = new BasePersonne($data_in['nom'], $data_in['prenom'], $data_in['date_naissance']);
			  $id_personne = $personne->ADD();

		 } else {
			  $personne = BasePersonne_recuperer($id_personne);   
		 }

		 /*=============*/ Lib_myLog("Ajout du nouvel email");
		 $email = new BaseEmail($personne->getId(), $personne->getTypeMoi(), 'contact', $data_in['email']);
		 $email->ADD();

		 preg_match("`([0-9]{2})/([0-9]{2})/([0-9]{4})`", $personne->DateNaissance(), $regs);
		 $code_utilisateur = substr(Lib_canonize($personne->getPrenom()), 0, 1);
		 $code_utilisateur .= $regs[1].$regs[2].$regs[3];
		 $code_utilisateur .= substr(Lib_canonize($personne->getNom()), 0, 1); 
		 /*=============*/ Lib_myLog("Code genere: $code_utilisateur");

		 /*=============*/ Lib_myLog("Ajout du nouvel utilisateur");
		 $utilisateur = new Utilisateur($id_personne, $code_utilisateur, '',
												  $data_in['utilisateur_souhaite'], $data_in['mdp_souhaite'], '', 
												  'attente_activation', $data_in['info_utilisateur']);
		 $utilisateur->ADD();

		 // On stocke le nouvel événement
		 $evenement = Evenement_ajout(1, $utilisateur->getId(), $utilisateur->getTypeMoi(), 
												'add', $utilisateur->getEtat());
		 $data_out = "";
		 $data_out['message'] = "Vous allez recevoir un mail...";

		 /*=============*/ Lib_myLog("On informe l'administrateur qu'une demande de compte a ete faite");
		 $entete       = "MIME-Version: 1.0\n";
		 $entete       .= "Content-type: text/html; charset=iso-8859-1\n";
		 $entete       .= "From: SITE AROEVEN <".$GLOBALS['mail_admin'].">\n";
		 $destinataire = $GLOBALS['mail_admin'];
		 $sujet        = "Demande d'acces";

		 $modele_mail = file("modeles/Mail_DemandeAcces.htm");
		 $modele_mail = implode($modele_mail, "");
		 $corps = preg_replace("`%%prenom%%`", $personne->getPrenom(), $modele_mail);
		 $corps = preg_replace("`%%nom%%`", $personne->getNom(), $corps);

		 // On envoie l'email
		 @mail($destinataire,$sujet,$corps,$entete);

		 $data_out['message'] = $MSG[$lang]['%%Action_ConfirmationInscription%%'];   
	}
}

/**
 * - Cas Login_Oubli :
 * . 
 *      Le cas Login_Oubli patati patata....
 */
function Login_Oubli($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	sleep($GLOBALS['wait_time']);
	$continue = true;

	/*=============*/ Lib_myLog("On verifie que le compte existe bien et est actif");
	$utilisateur = Utilisateurs_chercher($data_in['user'], '', '', 'actif');

	if ($continue && count($utilisateur) == 0) {
		 $continue = false;
	}   

	if ($continue) {
		 /*=============*/ Lib_myLog("Le compte est actif, on envoie le mail");
		 $entete       = "MIME-Version: 1.0\n";
		 $entete       .= "Content-type: text/html; charset=iso-8859-1\n";
		 $entete       .= "From: ".$GLOBALS['nom_admin']." <".$GLOBALS['mail_admin'].">\n";
		 $destinataire = $utilisateur['email'];
		 $sujet        = "Oubli de mot de passe";

		 $modele_mail = file("modeles/Mail_OubliMotDePasse.htm");
		 $modele_mail = implode($modele_mail, "");
		 $corps = preg_replace("`%%utilisateur%%`", $utilisateur['nom_utilisateur'], $modele_mail);
		 $corps = preg_replace("`%%password%%`", $utilisateur['password'], $corps);

		 // On envoie l'email
		 @mail($destinataire,$sujet,$corps,$entete);
		 $data_out['message_retour'] = "Votre mot de passe vient d'&ecirc;tre envoy&eacute; &agrave; votre adresse.";
	}
}

/**
* - Cas Login_Modif :
* . 
*      Le cas Login_Oubli patati patata....
*/
function Login_Modif($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	sleep($GLOBALS['wait_time']);
	$continue = true;

	if ($continue && $data_in['user'] == '') {
		/*=============*/ Lib_myLog("Utilisateur non saisi","",__ERROR__);
		$data_out['message'] = $MSG[$lang]['%%Action_ErreurNomUtilisateur%%'];
		$continue = false;         
	} 

	if ($continue)
		 /*=============*/ Lib_myLog("Utilisateur recupere: ".$data_in['user']);

	if ($continue && ($data_in['old_mdp'] == '' || $data_in['new_mdp'] == '' || $data_in['new_mdp2'] == '')) {
		/*=============*/ Lib_myLog("Mots de passe non saisis","",__ERROR__);
		$data_out['message'] = $MSG[$lang]['%%Action_ErreurMotDePasse%%'];
		$continue = false;         
	} 

	if ($continue) {
		/*=============*/ Lib_myLog("Mots de passe recupere");
	}

	if ($continue && ($data_in['new_mdp'] != $data_in['new_mdp2'])) {
		/*=============*/ Lib_myLog("Nouveaux mots de passe differents","",__ERROR__);
		$data_out['message'] = $MSG[$lang]['%%Action_ErreurDifference%%'];
		$continue = false;         
	} 

	if ($continue) {
		/*=============*/ Lib_myLog("Verification que le user ".$data_in['user']." existe, est actif et recuperation de ses donnees");
		$utilisateur = Utilisateur_recuperer($data_in['user']);

		if (!$utilisateur) {               
			 /*=============*/ Lib_myLog("Nom utilisateur errone","",__WARNING__);
			 $data_out['message'] = $MSG[$lang]['%%Action_UtilisateurErrone%%'];
			 $continue = false;
		} 

		if ($continue && $utilisateur->etat != 'actif') {
			 /*=============*/ Lib_myLog("Utilisateur non actif","",__WARNING__);
			 $data_out['message'] = $MSG[$lang]['%%Action_UtilisateurNonActif%%'];
			 $continue = false;
		}
	}

	/*=============*/ Lib_myLog("Verification du mot de passe");
	if ($continue && $data_in['old_mdp'] != md5($utilisateur->password)) {
		 $data_out['message'] = $MSG[$lang]['%%Action_MDPIncorrect%%'];
		 /*=============*/ Lib_myLog("Mot de passe incorrect");
		 $continue = false;
	}

	if ($continue) {
		$utilisateur->password = $data_in['new_mdp'];
		$utilisateur->UPD();

		$data_out['message'] = $MSG[$lang]['%%Action_ModificationMDP%%'];
	}
}

/**
* - Cas Login_Verifier :
* . 
*      Le cas Login_Verifier patati patata....
*/
function Login_Verifier($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	sleep($GLOBALS['wait_time']);
	$continue = true;

	$lang = $data_in['lang'];
	/*=============*/ Lib_myLog("Langue recuperee: $lang");

	if ($continue && $data_in['user'] == '') {
		/*=============*/ Lib_myLog("Utilisateur non saisi","",__ERROR__);                                        
		$data_out['message'] = $MSG[$lang]['%%Action_ErreurNomUtilisateur%%'];
		$continue = false;         
	} 

	if ($continue)
		 /*=============*/ Lib_myLog("Utilisateur recupere: ".$data_in['user']);                                        

	if ($continue && $data_in['mdp'] == '') {
		/*=============*/ Lib_myLog("Mot de passe non saisi","",__ERROR__);                                        
		$data_out['message'] = $MSG[$lang]['%%Action_ErreurMotDePasse%%'];
		$continue = false;         
	} 

	if ($continue)
		/*=============*/ Lib_myLog("Mot de passe recupere");                                        
		
	if ($continue) {
		$data_in['action'] = 'Login_CheckUtilisateur';
		call_user_func('Login_CheckUtilisateur', $data_in);
	} 
}

/**
* - Cas Login_CheckUtilisateur :
* . 
*      Le cas Login_CheckUtilisateur patati patata....
*/
function Login_CheckUtilisateur($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;

	/*=============*/ Lib_myLog("Verification que le user ".$data_in['user']." existe, est actif et recuperation de ses donnees");
	$utilisateur = Utilisateur_recuperer($data_in['user']);

	if (!$utilisateur) {               
		 /*=============*/ Lib_myLog("Nom utilisateur errone","",__WARNING__);            
		 $data_out['message'] = $MSG[$lang]['%%Action_UtilisateurErrone%%'];
		 $continue = false;
	} 

	if ($continue && $utilisateur->etat != 'actif') {               
		 /*=============*/ Lib_myLog("Utilisateur non actif","",__WARNING__);            
		 $data_out['message'] = $MSG[$lang]['%%Action_UtilisateurNonActif%%'];
		 $continue = false;
	}             

	if ($continue) {
		$data_in['action'] = 'Login_CheckSecurity';
		call_user_func('Login_CheckSecurity', $data_in);
	}
}

/**
* - Cas Login_CheckSecurity :
* . 
*      Le cas Login_CheckSecurity patati patata....
*/
function Login_CheckSecurity($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$continue = true;

	if ($GLOBALS['controle_ip'] && !Autorisation_recuperer($utilisateur->nom_groupe, $_SERVER['REMOTE_ADDR'])) {
		/*=============*/ Lib_myLog("Verification que le user se connecte depuis une IP autorisee (".$_SERVER['REMOTE_ADDR'].")");
		 $data_out['message'] = $MSG[$lang]['%%Action_IpNonAutorisee%%'];
		 /*=============*/ Lib_myLog("IP non autorisee");
		 $continue = false;
	}

	/*=============*/ Lib_myLog("Verification que le user se connecte depuis une IP non interdite (".$_SERVER['REMOTE_ADDR'].")");
	$interdiction = Interdiction_recuperer($utilisateur->nom_utilisateur, $_SERVER['REMOTE_ADDR']);
	if ($continue && $interdiction->nb_tentatives >= $GLOBALS['nb_tentatives_max']) {
		$data_out['message'] = $MSG[$lang]['%%Action_IpInterdite%%'];
		/*=============*/ Lib_myLog("IP non autorisee");
		$interdiction->UPD();
		$continue = false;
	} 

	if ($continue) {
		if ($interdiction->date_add != '') {
			/*=============*/ Lib_myLog("Mise a jour du nombre de tentatives");;
			$interdiction->nb_tentatives += 1;
			$interdiction->UPD();
		} else {
			/*=============*/ Lib_myLog("Initialisation du controle de tentatives");;
			$interdiction->nb_tentatives = 1;
			$interdiction->ADD();
		}
	}

	/*=============*/ Lib_myLog("Verification du mot de passe");                            
	if ($continue && $data_in['mdp'] != md5($utilisateur->password)) {
		 $data_out['message'] = $MSG[$lang]['%%Action_MDPIncorrect%%'];
		 /*=============*/ Lib_myLog("Mot de passe incorrect");
		 $continue = false;
	}

	if ($continue) {
		$data_in['action'] = 'Login_Go';
		call_user_func('Login_Go', $data_in);
	}
}

/**
* - Cas Login_Go :
* . 
*      Le cas Login_Go patati patata....
*/
function Login_Go($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	/*=============*/ Lib_myLog("Suppression du controle de tentatives");;
	$interdiction = Interdiction_recuperer($utilisateur->nom_utilisateur, $_SERVER['REMOTE_ADDR']);
	$interdiction->DEL();

	// Génération de l'identifiant de session...
	$session = Sessions_new();
	Sessions_writeLog($utilisateur->nom_utilisateur,$ip,__LOG_IN__, $session);

	/*=============*/ Lib_myLog("Nouvelle session: $session");
	setcookie($GLOBALS['instance'].'_session',$session,0,'/');
	$_COOKIE[$GLOBALS['instance'].'_session'] = $session;

	/*=============*/ Lib_myLog("Langue recuperee: $lang");
	/*=============*/ Lib_myLog("Taille recuperee: ".$data_in['taille_ecran']);

	// On sauvegarde la valeur de la langue et de la taille d'écran dans les variables de la session
	$tab_session['lang'] = $lang;
	$tab_session['taille_ecran'] = $data_in['taille_ecran'];
	$tab_session['taille_tableaux'] = $GLOBALS['taille_tableaux'];

	/*=============*/ Lib_myLog("Recherche des modules autorises");
	$groupe = Groupe_recuperer($utilisateur->nom_groupe);
	$tab_groupe = $groupe->getTab();

	foreach($tab_groupe['modules'] as $module) {
		 /*=============*/ Lib_myLog("Module autorise: $module");                        
		 $tab_session[$module] = 1;
	}

	$tab_utilisateur = $utilisateur->getTab();
	/*=============*/ Lib_myLog("Affectation des droits de l'utilisateur");
	foreach($tab_utilisateur['droits'] as $champ => $droits) {
		 /*=============*/ Lib_myLog("Champ autorise : $champ, droits : $droits");
		 $tab_session[$champ] = $droits;
	}

	$tab_session['nom_utilisateur'] = $utilisateur->nom_utilisateur;
	$tab_session['id_utilisateur'] = $utilisateur->id_utilisateur;
	$tab_session['nom_groupe'] = $utilisateur->nom_groupe;
	// Pour sécuriser davantage le système, on mémorise le user_agent de l'utilisateur
	$tab_session['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	// On initialise le fichier qui nous sert à stocker les données de la session dans /tmp
	Lib_writeData($tab_session, "session_".$session);

	/*=============*/ Lib_myLog("Redirection sur accueil");
	// C'est l'accueil qui doit effectuer la redirection, on ne doit jamais "configurer" l'actions.php de dilasys !
	$racine = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL={$racine}/accueil.php?groupe={$utilisateur->nom_groupe}\">";
	echo "</head>\n";
	echo "<body>\n";
	echo "</body>\n";
	echo "<html>\n";

	// On sort pour ne pas continuer à afficher Login_Admin.php!
	exit;
}

/**
* - Cas Accueil_Go :
* . 
*      Le cas Accueil_Go patati patata....
*/
function Accueil_Go($data_in = array())
{
	Lib_myLog("action: ".$data_in['action']);
	foreach($GLOBALS['tab_globals'] as $global) global $$global;
	Lib_myLog("IN: ",$data_in);
	Lib_myLog("FILE: ",__FILE__);

	$session = $_COOKIE[$GLOBALS['instance'].'_session'];
					
	/*=============*/ Lib_myLog("Accueil. Identifiant de session: $session");

	// On verifie si la session est OK.
	// Si ce n'est pas le cas, on n'affiche pas accueil.php et 
	// on renvoie sur Login_Admin.php
	if ($session == '') {
		 /*=============*/ Lib_myLog("Accueil non autorise pour $session");
		 // HTTP 1.1 n'accepte que des url absolues!
		 header("Location: http://" . $_SERVER['HTTP_HOST']
				 . rtrim(dirname($_SERVER['PHP_SELF']), '/\\')
				 . "/Login_Admin.php");
	}
}
?>