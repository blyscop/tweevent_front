<?
if (!defined('__INTERDICTION_INC__')){
define('__INTERDICTION_INC__', 1);

class Interdiction {

	var $error;
	var $nom_utilisateur;
	var $adresse_ip;
	var $nb_tentatives;
	var $date_add;
	var $date_upd;

	// Crée une nouvelle personne
	function Interdiction($nom_utilisateur, $adresse_ip)
	{
		$this->error = 0;
		$this->nom_utilisateur	= $nom_utilisateur;
		$this->adresse_ip			= $adresse_ip;
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
		$nom_utilisateur	= $this->nom_utilisateur;
		$adresse_ip			= $this->adresse_ip;
		$nb_tentatives		= $this->nb_tentatives;
		$date_add			= time();

		 // Inscription de la personne dans la table
		 $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_ip_interdictions
					 (nom_utilisateur, adresse_ip, nb_tentatives, date_add)
					 VALUES('$nom_utilisateur', '$adresse_ip', $nb_tentatives, '$date_add')";
		
		 if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		 if (!$this->isError()) {
			$id_interdiction = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_interdiction");
			$this->id_interdiction = $id_interdiction;
			return $id_interdiction;
		 }

		 return;
	 }

	 function UPD()
	 {
		$nom_utilisateur	= $this->nom_utilisateur;
		$adresse_ip		= $this->adresse_ip;
		$nb_tentatives	= $this->nb_tentatives;
		$date_upd		= time();

		// Inscription de la personne dans la table
		$sql = "UPDATE ".$GLOBALS['prefix']."sys_ip_interdictions
					SET date_upd = '$date_upd', nb_tentatives = $nb_tentatives
					WHERE adresse_ip = '$adresse_ip'
					AND nom_utilisateur = '$nom_utilisateur'";

		 if (!Sql_exec($sql)) $this->setError(ERROR);  
		 if (!$this->isError()) Lib_sqlLog($sql." -- $id_interdiction");

		 return;
	 }

	 function DEL() {
		 $nom_utilisateur	= $this->nom_utilisateur;
		 $adresse_ip		= $this->adresse_ip;

		 $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_ip_interdictions
					 WHERE adresse_ip = '$adresse_ip'
					 AND nom_utilisateur = '$nom_utilisateur'
					 LIMIT 1";

		 if (!Sql_exec($sql)) $this->setError(ERROR); 
		 if (!$this->isError()) Lib_sqlLog($sql);
		 
		 return;
	 }
}

/**
 Recupère toutes les données relatives à une interdiction
 et retourne la coquille "Interdiction" remplie avec les informations récupérées
 de la base.
 @param id_groupe:
 @param adresse_ip:
*/
function Interdiction_recuperer($nom_utilisateur, $adresse_ip) {
	$interdiction = new Interdiction($nom_utilisateur, $adresse_ip);

	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."sys_ip_interdictions
			WHERE adresse_ip = '$adresse_ip'
			AND nom_utilisateur = '$nom_utilisateur'";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$interdiction->nb_tentatives = $row['nb_tentatives'];
		$interdiction->date_add = $row['date_add'];
		$interdiction->date_upd = $row['date_upd'];
	}

	return $interdiction;
}

/**
 Renvoie la liste des interdictions ayant les données passées en argument sous forme d'un tableau
 @param id_groupe
 @param adresse_ip
 ...
*/
function Interdictions_chercher($adresse_ip = '')
{
	$RESULT = array();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."sys_ip_interdictions
				WHERE 1";

	if ($id_groupe == "" && $adresse_ip == "") return $RESULT;

	$condition="";

	if ( $adresse_ip != "" && $adresse_ip != "*") $condition .= " AND adresse_ip LIKE '%$adresse_ip%' ";

	$sql .= $condition;
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$indice = 0;
		while($row = Sql_fetch($result)) {
			 $RESULT[$indice]["nom_utilisateur"]	= $row['nom_utilisateur'];
			 $RESULT[$indice]["adresse_ip"]			= $row['adresse_ip'];
			 $RESULT[$indice]["nb_tentatives"]		= $row['nb_tentatives'];
			 $RESULT[$indice]["date_add"]				= $row['date_add'];
			 $RESULT[$indice]["date_upd"]				= $row['date_upd'];
			 $indice++;
		 }
	 }

	return $RESULT;
}

} // Fin if (!defined('__INTERDICTION_INC__')){
?>