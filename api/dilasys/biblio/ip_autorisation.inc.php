<?
if (!defined('__AUTORISATION_INC__')){
define('__AUTORISATION_INC__', 1);

class Autorisation {

	var $error;
	var $id_groupe;
	var $adresse_ip;
	var $effacable;

	// Crée une nouvelle personne
	function Autorisation( $id_groupe = '', $adresse_ip = '', $effacable = '')
	{
		$this->error = 0;
		$this->id_groupe = $id_groupe;
		$this->adresse_ip = $adresse_ip;
		$this->effacable = $effacable;
	}

	function isError()
	{
		return $this->error;
	}

	function setError($error)
	{
		$this->error = $error;
	}

	 function ADD()
	 {
		 if ($this->id_groupe == "" || $this->adresse_ip == "") {
			trigger_error("L'autorisation ne peut être ajoutée sans groupe ni adresse IP!", E_USER_ERROR);
			return NULL;
		 }

		 $id_groupe = $this->id_groupe;
		 $adresse_ip = $this->adresse_ip;
		 $effacable = $this->effacable;

		 // Inscription de la personne dans la table
		 $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_ip_autorisations
					 (id_groupe, adresse_ip)
					 VALUES($id_groupe, '$adresse_ip')";
		
		 if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		 if (!$this->isError()) {
			$id_autorisation = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_autorisation");
			$this->id_autorisation = $id_autorisation;
			return $id_autorisation;
		 }

		 return;
	 }

	 function DEL() {

		 if ($this->id_groupe == "" || $this->adresse_ip == "") {
			trigger_error("L'autorisation ne peut être supprimée sans groupe ni adresse IP!", E_USER_ERROR);
			return NULL;
		 }

		 $id_groupe = $this->id_groupe;
		 $adresse_ip = $this->adresse_ip;

		 $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_ip_autorisations
					 WHERE id_groupe = $id_groupe
					 AND adresse_ip = '$adresse_ip'
					 LIMIT 1";

		 if (!Sql_exec($sql)) $this->setError(ERROR); 
		 if (!$this->isError()) Lib_sqlLog($sql);
		 
		 return;
	 }

	 function toStr()
	 {
		$str = "";

		if ($this->getIdGroupe() != "") $str .= (($str == "") ? $this->getIdGroupe() : ",".$this->getIdGroupe());
		if ($this->getAdresseIp() != "") $str .= (($str == "") ? $this->getAdresseIp() : ",".$this->getAdresseIp());
		if ($this->getEffacable() != "") $str .= (($str == "") ? $this->getEffacable() : ",".$this->getEffacable());

		$str = "(".$str.")";
		return $str;
	 }
}

/**
 Recupère toutes les données relatives à une autorisation
 et retourne la coquille "Autorisation" remplie avec les informations récupérées
 de la base.
 @param id_groupe:
 @param adresse_ip:
*/
function Autorisation_recuperer($nom_groupe, $adresse_ip) {

	$sql = "SELECT A.id_groupe, A.adresse_ip, A.effacable 
			FROM ".$GLOBALS['prefix']."sys_ip_autorisations A, ".$GLOBALS['prefix']."sys_groupes G
			WHERE G.nom_groupe = '$nom_groupe'
			AND G.id_groupe = A.id_groupe
			AND ((A.adresse_ip = '$adresse_ip') OR
					 (A.adresse_ip = '*'))";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$autorisation = new Autorisation();
		$autorisation->id_groupe = $row['id_groupe'];
		$autorisation->adresse_ip = $row['adresse_ip'];
		$autorisation->effacable = $row['effacable'];
	}

	return $autorisation;
}

/**
	Enregistre une autorisation en base
	@param Autorisation: coquille sur laquelle on est en train de travailler
*/
function Autorisation_enregistrer(&$autorisation)
{
	$id_groupe = $autorisation->id_groupe;
	$adresse_ip = $autorisation->adresse_ip;

	$autorisation->DEL();
	$autorisation->ADD();

	if ($autorisation->isError() == ERROR) {
		trigger_error("L'autorisation n'a pas pu être ajoutée!", E_USER_ERROR);
		return NULL;
	}

	return $autorisation;
}

/**
	Supprime une autorisation de la base.
	@param id_groupe
	@param adresse_ip
*/
function Autorisation_supprimer($id_groupe, $adresse_ip)
{
	if ($id_groupe == '' || $adresse_ip == '') {
		trigger_error("La suppression ne peut être effectué si le groupe et son adresse ip ne sont pas fournis!", E_USER_ERROR);
		exit;
	}

	$autorisation = new Autorisation($id_groupe, $adresse_ip);
	$autorisation->DEL();
}

/**
	Crée une autorisation SANS l'enregistrer en base.
	La coquille est remplie avec les informations de base.
	@param: id_groupe
	@param: adresse_ip
	@param: effacable
*/
function Autorisation_creer($id_groupe, $adresse_ip, $effacable = '')
{

	$autorisation = new Autorisation($id_groupe,$adresse_ip,$effacable);

	if ($autorisation->isError() != ERROR) {
		 return $autorisation;
	} else {
		 return NULL;
	}
}

/**
 Renvoie la liste des autorisations ayant les données passées en argument sous forme d'un tableau
 @param id_groupe
 @param adresse_ip
 ...
*/
function Autorisation_chercher($id_groupe = '', $adresse_ip = '')
{
	$RESULT = array();

	$sql = " SELECT SA.id_groupe, SA.adresse_ip, SA.effacable, SG.nom_groupe
				FROM ".$GLOBALS['prefix']."sys_ip_autorisations SA, ".$GLOBALS['prefix']."sys_groupes SG
				WHERE SA.id_groupe = SG.id_groupe";

	if ($id_groupe == "" && $adresse_ip == "") return $RESULT;

	$condition="";

	if ( $id_groupe != "" && $id_groupe != "*") $condition .= " AND id_groupe = $id_groupe ";
	if ( $adresse_ip != "" && $adresse_ip != "*") $condition .= " AND adresse_ip LIKE '%$adresse_ip%' ";

	$sql .= $condition;
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$indice = 0;
		while($row = Sql_fetch($result)) {
			 $RESULT[$indice]["id_groupe"] = $row['id_groupe'];
			 $RESULT[$indice]["nom_groupe"] = $row['nom_groupe'];
			 $RESULT[$indice]["adresse_ip"] = $row['adresse_ip'];
			 $RESULT[$indice]["effacable"] = $row['effacable'];
			 $indice++;
		 }
	 }

	return $RESULT;
}

} // Fin if (!defined('__AUTORISATION_INC__')){
?>