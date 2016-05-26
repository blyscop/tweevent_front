<?
/*
CREATE TABLE test_sys_utilisateurs (
  id_utilisateur int(10) NOT NULL auto_increment,
  code_utilisateur varchar(16) NOT NULL default '',  
  nom_groupe varchar(32) NOT NULL default '0',
  nom_utilisateur varchar(50) NOT NULL default '',
  password varchar(200) NOT NULL default '',
  nb_connect tinyint(2) NOT NULL default '0',
  etat enum('attente_activation','actif','inactif') NOT NULL default 'attente_activation',
  lang varchar(16) NOT NULL default 'fr',
  effacable enum('0','1') NOT NULL default '1',
  modifiable enum('0','1') NOT NULL default '1',
  info_utilisateur text,
  PRIMARY KEY (id_utilisateur)
)

CREATE TABLE ha_sys_utilisateurs_droits (
  id_utilisateur int(11)  NOT NULL DEFAULT '0',
  champ varchar(64) NOT NULL DEFAULT '',
  droits int(11) NOT NULL DEFAULT '0'
) 

*/
if (!defined('__UTILISATEUR_INC__')){
define('__UTILISATEUR_INC__', 1);
define('__UNKNOWN_UTILISATEUR__',0);

class Utilisateur extends Element {
	var $id_utilisateur;
	var $code_utilisateur;
	var $nom_groupe;
	var $nom_utilisateur;
	var $password;
	var $nb_connect;
	var $etat;
	var $lang;
	var $info_utilisateur;
	var $droits;

	// Crée un nouveau utilisateur
	function Utilisateur($code_utilisateur = '', $nom_groupe = '', 
								$nom_utilisateur = '', $password = '', $nb_connect = '', 
								$etat = '', $info_utilisateur = '')
	{
		$this->id_utilisateur	= $id_utilisateur;
		$this->code_utilisateur = $code_utilisateur;
		$this->nom_groupe		= $nom_groupe;
		$this->nom_utilisateur  = $nom_utilisateur;
		$this->password			= $password;
		$this->nb_connect		= $nb_connect;
		$this->etat				= $etat;
		$this->lang				= $lang;
		$this->info_utilisateur = $info_utilisateur;
		$this->droits				= array();
		$this->type_moi			= 'utilisateurs';
	}

	function getId()
	{
	return $this->id_utilisateur;
	}

	function getTab() 
	{
		$tab['id_utilisateur']	= $this->id_utilisateur;
		$tab['code_utilisateur'] = $this->code_utilisateur;
		$tab['nom_groupe']		= $this->nom_groupe;
		$tab['nom_utilisateur']  = $this->nom_utilisateur;
		$tab['password']			= $this->password;
		$tab['nb_connect']		= $this->nb_connect;
		$tab['etat']				= $this->etat;	
		$tab['lang']				= $this->lang;	
		$tab['info_utilisateur'] = $this->info_utilisateur;
		$tab['type']				= 'utilisateurs';
		$tab['droits']				= array();
		foreach ($this->droits as $champ => $droits) 
			$tab['droits'][$champ] = $droits; 

		return $tab;	
	}

	function setId($id_utilisateur)
	{
	$this->id_utilisateur = $id_utilisateur;
	}

	function ADD()
	{
		$code_utilisateur = $this->code_utilisateur;
		$nom_groupe		= $this->nom_groupe;
		$nom_utilisateur  = $this->nom_utilisateur;
		$password			= $this->password;
		$nb_connect		= ($this->nb_connect != '') ? $this->nb_connect : 10;
		$etat				= $this->etat;
		$lang				= $this->lang;
		$info_utilisateur = Sql_prepareTexteStockage($this->info_utilisateur);

		// Inscription de l'utilisateur dans la table
		$sql = " INSERT INTO ".$GLOBALS['prefix']."sys_utilisateurs
					(code_utilisateur, nom_groupe, 
					nom_utilisateur, password, nb_connect, 
					etat, lang, 
					info_utilisateur)
					VALUES('$code_utilisateur', '$nom_groupe', 
							'$nom_utilisateur', '$password', '$nb_connect', 
							'$etat', '$lang', 
							'$info_utilisateur')";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		
		if (!$this->isError()) {
			$id_utilisateur = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_utilisateur");
			$this->id_utilisateur = $id_utilisateur;
		}

		// Inscription des droits dans la base		
		foreach ($this->droits as $champ => $droits) {
			$sql = " INSERT INTO ".$GLOBALS['prefix']."sys_utilisateurs_droits
					(id_utilisateur, champ, droits)
					VALUES($id_utilisateur, '$champ', $droits)";

			Sql_exec($sql); 
			Lib_sqlLog($sql);
		}

		return $id_utilisateur;
	}

	function UPD() 
	{
		$id_utilisateur	= $this->id_utilisateur;
		$code_utilisateur = $this->code_utilisateur;
		$nom_groupe		= $this->nom_groupe;
		$nom_utilisateur  = $this->nom_utilisateur;
		$password			= $this->password;
		$nb_connect		= ($this->nb_connect != '') ? $this->nb_connect : 10;
		$etat				= $this->etat;
		$lang				= $this->lang;
  	$info_utilisateur = Sql_prepareTexteStockage($this->info_utilisateur);

		// Mise à jour de la base
		$sql = " UPDATE ".$GLOBALS['prefix']."sys_utilisateurs
					SET nom_groupe = '$nom_groupe', nom_utilisateur = '$nom_utilisateur', 
						password = '$password', nb_connect = $nb_connect, 
						etat = '$etat', lang = '$lang',
						info_utilisateur = '$info_utilisateur'
					WHERE id_utilisateur = $id_utilisateur";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);

		// Mise à jour de la base pour les droits
		// Tout d'abord, on supprime tous les anciens droits
		$sql = " DELETE FROM ".$GLOBALS['prefix']."sys_utilisateurs_droits
					WHERE id_utilisateur = $id_utilisateur";

		Sql_exec($sql); 
		Lib_sqlLog($sql);

		// Puis on insère les nouveaux droits
		foreach ($this->droits as $champ => $droits) {
			$sql = " INSERT INTO ".$GLOBALS['prefix']."sys_utilisateurs_droits
					(id_utilisateur, champ, droits)
					VALUES($id_utilisateur, '$champ', $droits)";

			Sql_exec($sql); 
			Lib_sqlLog($sql);
		}

		return;
	}

	function DEL() {

		$id_utilisateur = $this->id_utilisateur;

		$sql = " DELETE FROM ".$GLOBALS['prefix']."sys_utilisateurs
					WHERE id_utilisateur = $id_utilisateur
					AND effacable = '1'";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);

		// Puis on supprime tous les droits
		$sql = " DELETE FROM ".$GLOBALS['prefix']."sys_utilisateurs_droits
					WHERE id_utilisateur = $id_utilisateur";

		Sql_exec($sql); 
		Lib_sqlLog($sql);

		return;
	}

	function addDroits($new_champ, $droits)
	{
		$ajouter = true;
		foreach($this->droits as $champ => $droits)
			if ($champ == $new_champ) $ajouter = false;
		
		if ($ajouter)
			$this->droits[$new_champ] = $droits;
	}	

	function delDroits($champ_to_del)
	{
		$old_droits = $this->droits;
		$this->droits = array();

		foreach ($old_droits as $champ => $droits) {
			if ($champ == $champ_to_del) continue;
			$this->droits[$champ] = $droits; 
		}
	}

	function toStr()
	{
		$str = "";

		if ($this->getId() != "")				$str .= (($str == "") ? $this->getId() : ",".$this->getId());
		if ($this->code_utilisateur != "")	$str .= (($str == "") ? $this->code_utilisateur() : ",".$this->code_utilisateur());
		if ($this->nom_groupe != "")			$str .= (($str == "") ? $this->nom_groupe() : ",".$this->nom_groupe());
		if ($this->nom_utilisateur != "")	$str .= (($str == "") ? $this->nom_utilisateur() : ",".$this->nom_utilisateur());
		if ($this->password() != "")			$str .= (($str == "") ? $this->password() : ",".$this->password());
		if ($this->nb_connect() != "")		$str .= (($str == "") ? $this->nb_connect() : ",".$this->nb_connect());
		if ($this->etat() != "")				$str .= (($str == "") ? $this->etat() : ",".$this->etat());
		if ($this->lang() != "")				$str .= (($str == "") ? $this->lang() : ",".$this->lang());
		if ($this->info_utilisateur() != "")  $str .= (($str == "") ? $this->info_utilisateur() : ",".$this->info_utilisateur());

		$str = "(".$str.")";
		return $str;
	}
}

/**
 Recupère toutes les données relatives à un utilisateur suivant son identifiant
 et retourne la coquille "Utilisateur" remplie avec les informations récupérées
 de la base.
 @param IdUtilisateur: Identifiant du utilisateur à récupérer
*/
function Utilisateur_recuperer($arg) {

	$utilisateur = new Utilisateur();

	// On récupère d'abord les données de la table sys_utilisateurs
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."sys_utilisateurs
			WHERE 1";
			
  $condition = "";
  $condition = (is_numeric($arg)) ? " AND id_utilisateur = '$arg'" : " AND nom_utilisateur = '$arg'";
  $sql.=$condition;

  $result = Sql_query($sql);
	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$utilisateur->id_utilisateur = $row['id_utilisateur'];
			$utilisateur->code_utilisateur = $row['code_utilisateur'];
			$utilisateur->nom_groupe = $row['nom_groupe'];
			$utilisateur->nom_utilisateur = $row['nom_utilisateur'];
			$utilisateur->password = $row['password'];
			$utilisateur->nb_connect = $row['nb_connect'];
			$utilisateur->etat = $row['etat'];
			$utilisateur->lang = $row['lang'];
			$utilisateur->info_utilisateur = $row['info_utilisateur'];

			// On récupère ensuite les données de la table des droits
			$sql = "SELECT *
					FROM ".$GLOBALS['prefix']."sys_utilisateurs_droits
					WHERE id_utilisateur = {$utilisateur->id_utilisateur}";

			$result = Sql_query($sql);

			if ($result && Sql_errorCode($result) === "00000")
				while($row = Sql_fetch($result)) 
					$utilisateur->addDroits($row['champ'], $row['droits']);
		}
	}

	return $utilisateur;
}

/**
 Renvoie le nom et l'identifiant des utilisateurs ayant les données passées en argument sous forme d'un tableau
 @param IdUtilisateur
 @param NomUtilisateur
 ...
*/
function Utilisateurs_chercher($nom_utilisateur = '', $id_utilisateur = '', $id_personne = '', $etat = '', $code_utilisateur = '', $tab_ids = '')
{
	$tab_result = array();

	$sql = " SELECT *
			FROM ".$GLOBALS['prefix']."sys_utilisateurs
			WHERE modifiable = '1'";

	if ($nom_utilisateur == "" && "$id_utilisateur" == "" &&
		"$id_personne" == "" && $etat == "" && 
		$code_utilisateur == "" && $tab_ids == "") 
		return $tab_result;

	$condition="";
	if ( "$id_utilisateur" != "" && "$id_utilisateur" != "*") $condition .= " AND id_utilisateur = $id_utilisateur ";	
	if ( $nom_utilisateur != "" && $nom_utilisateur != "*")	$condition .= " AND nom_utilisateur = '$nom_utilisateur' ";
	if ( $etat != "" && $etat != "*")								$condition .= " AND etat = '$etat' ";
	if ( $code_utilisateur != "" && $code_utilisateur != "*") $condition .= " AND code_utilisateur = '$code_utilisateur' ";
	if ($tab_ids != "") {
		$ids = implode(",", $tab_ids);
		$condition .= " AND id_utilisateur IN (0".$ids.") ";
	}

	$condition .= " ORDER by id_utilisateur ASC";
	$sql .= $condition;	

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_utilisateur'];
			$tab_result[$id]["id_utilisateur"]	= $id;
			$tab_result[$id]["code_utilisateur"]	= $row['code_utilisateur'];
			$tab_result[$id]["nom_groupe"]			= $row['nom_groupe'];
			$tab_result[$id]["nom_utilisateur"]		= $row['nom_utilisateur'];
			$tab_result[$id]["password"]				= $row['password'];
			$tab_result[$id]["nb_connect"]			= $row['nb_connect'];
			$tab_result[$id]["etat"]					= $row['etat'];
			$tab_result[$id]["lang"]					= $row['lang'];
			$tab_result[$id]["info_utilisateur"]	= $row['info_utilisateur'];
			$tab_result[$id]["modifiable"]			= $row['modifiable'];
			$tab_result[$id]["effacable"]				= $row['effacable'];
			$tab_result[$id]["type"]					= 'utilisateurs';

			// On récupère ensuite les données de la table des droits
			$sql3 = "SELECT *
					FROM ".$GLOBALS['prefix']."sys_utilisateurs_droits
					WHERE id_utilisateur = $id";

			$result3 = Sql_query($sql3);

			if ($result3) 
				while($row3 = Sql_fetch($result3)) 
					$tab_result[$id]['droits'][$row3['champ']] = $row3['droits'];
		}
	}

	if (count($tab_result) == 1 && ($nom_utilisateur != '' && $nom_utilisateur != '*') || 
		("$id_utilisateur" != '' && "$id_utilisateur" != '*') ||  
		($code_utilisateur != '' && $code_utilisateur != '*')) 
		$tab_result = array_pop($tab_result);	
	return $tab_result;
}

/**
	Supprime un utilisateur de la base.
	@param IdUtilisateur
*/
function Utilisateurs_supprimer($id_utilisateur)
{
	if ($id_utilisateur == '') {
		trigger_error("La suppression ne peut être effectuée si l'identifiant de l'utilisateur n'est pas fourni!", E_USER_ERROR);
		exit;
	}

	$utilisateur = new Utilisateur($id_utilisateur);
	$utilisateur->DEL();
}

} // Fin if (!defined('__UTILISATEUR_INC__')){
?>