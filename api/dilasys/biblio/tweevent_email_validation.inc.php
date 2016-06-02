<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_email_validations
*/

/**
 * Classe pour la gestion de tweevent_email_validations
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_email_validation` (
	 `id_tweevent_email_validation` INT(11) NOT NULL auto_increment,
	 `id_tweevent_user` INT(11) NOT NULL,
	 `est_valide` INT(11) NOT NULL,
	 `timestamp` VARCHAR(55) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_email_validation` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_email_validation`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_tweevent_user
// Clef de recherche 2 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_EMAIL_VALIDATION_INC__')){
	define('__TWEEVENT_EMAIL_VALIDATION_INC__', 1);

class Tweevent_email_validation extends Element {
	var $id_tweevent_email_validation;
	var $id_tweevent_user;
	var $est_valide;
	var $timestamp;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_email_validation;

/** 
Constructeur de la classe.
*/
function Tweevent_email_validation()
{
	$this->type_moi = "tweevent_email_validations";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_email_validation.
*/
function getTab()
{
	$tab['id_tweevent_email_validation']	= $this->id_tweevent_email_validation;
	$tab['id_tweevent_user']					= $this->id_tweevent_user;
	$tab['est_valide']							= $this->est_valide;
	$tab['timestamp']								= $this->timestamp;
	$tab['etat']									= $this->etat;
	$tab['date_add']								= $this->date_add;
	$tab['date_upd']								= $this->date_upd;
	$tab['info_tweevent_email_validation']	= $this->info_tweevent_email_validation;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_email_validation à la BDD. 
*/
function ADD()
{
	$id_tweevent_user 					= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$est_valide 							= is_numeric($this->est_valide) ? $this->est_valide : 0;
	$timestamp 								= Sql_prepareTexteStockage($this->timestamp);
	$etat 									= $this->etat != '' ? $this->etat : 'actif';
	$date_add 								= time();
	$info_tweevent_email_validation 	= Sql_prepareTexteStockage($this->info_tweevent_email_validation);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_email_validation
					(id_tweevent_user, est_valide, timestamp, 
					etat, date_add, info_tweevent_email_validation)
				VALUES 
					 ('$id_tweevent_user', '$est_valide', '$timestamp', 
					'$etat', '$date_add', '$info_tweevent_email_validation')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_email_validation = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_email_validation");
		$this->id_tweevent_email_validation = $this->id_tweevent_email_validation;
		return $id_tweevent_email_validation;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_email_validation dans la BDD. 
*/
function UPD()
{
	$id_tweevent_email_validation 	= is_numeric($this->id_tweevent_email_validation) ? $this->id_tweevent_email_validation : 0;
	$id_tweevent_user 					= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$est_valide 							= is_numeric($this->est_valide) ? $this->est_valide : 0;
	$timestamp 								= Sql_prepareTexteStockage($this->timestamp);
	$etat 									= $this->etat;
	$date_upd 								= time();
	$info_tweevent_email_validation 	= Sql_prepareTexteStockage($this->info_tweevent_email_validation);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_email_validation
				SET id_tweevent_user = '$id_tweevent_user', est_valide = '$est_valide', timestamp = '$timestamp', 
					etat = '$etat', date_upd = '$date_upd', 
					info_tweevent_email_validation = '$info_tweevent_email_validation'
				WHERE id_tweevent_email_validation = $id_tweevent_email_validation";

	if (!Sql_exec($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/**
	Cette fonction supprime un chantier de la BDD.
*/
function DEL()
{
	if ($this->isError()) return;

	$id_tweevent_email_validation = $this->id_tweevent_email_validation;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_email_validation
				WHERE id_tweevent_email_validation = $id_tweevent_email_validation";

	if (!Sql_exec($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/** 
Cette fonction transforme les attributs en chaine de caractères.
*/
function toStr()
{
	$str = "";
	$str = Lib_addElem($str, $this->id_tweevent_email_validation);
	$str = Lib_addElem($str, $this->id_tweevent_user);
	$str = Lib_addElem($str, $this->est_valide);
	$str = Lib_addElem($str, $this->timestamp);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_email_validation);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_email_validation suivant son identifiant
et retourne la coquille "Tweevent_email_validation" remplie avec les informations récupérées
de la base.
@param id_tweevent_email_validation.
*/
function Tweevent_email_validation_recuperer($id_tweevent_email_validation)
{
	$tweevent_email_validation = new Tweevent_email_validation();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_email_validation
				WHERE id_tweevent_email_validation = '$id_tweevent_email_validation';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_email_validation->id_tweevent_email_validation	= $row['id_tweevent_email_validation'];
		$tweevent_email_validation->id_tweevent_user					= $row['id_tweevent_user'];
		$tweevent_email_validation->est_valide							= $row['est_valide'];
		$tweevent_email_validation->timestamp								= Sql_prepareTexteAffichage($row['timestamp']);
		$tweevent_email_validation->etat									= $row['etat'];
		$tweevent_email_validation->date_add								= $row['date_add'];
		$tweevent_email_validation->date_upd								= $row['date_upd'];
		$tweevent_email_validation->info_tweevent_email_validation	= Sql_prepareTexteAffichage($row['info_tweevent_email_validation']);
	}
	return $tweevent_email_validation;
}

/**
Retourne un tableau de tweevent_email_validations correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_email_validations_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_email_validation
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_email_validation
					WHERE 1";
	}

	if (!isset($args['id_tweevent_email_validation']) && !isset($args['id_tweevent_user']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_email_validations']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_email_validation']) && $args['id_tweevent_email_validation'] != "*")
		$condition .= " AND id_tweevent_email_validation = '".$args['id_tweevent_email_validation']."' ";
	if (isset($args['id_tweevent_user']) && $args['id_tweevent_user'] != "*")
		$condition .= " AND id_tweevent_user = '".$args['id_tweevent_user']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_email_validations']) && $args['tab_ids_tweevent_email_validations'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_email_validations']);
		$condition .= " AND id_tweevent_email_validation IN (0".$ids.") ";
	}
	if (!isset($args['etat']))
		$condition .= " AND etat != 'supprime' ";

	$sql .= $condition;

	if (isset($args['order_by']) && !isset($args['asc_desc']))
		$sql .= " ORDER BY ".$args['order_by']." ASC";
	if (isset($args['order_by']) && isset($args['asc_desc']))
		$sql .= " ORDER BY ".$args['order_by']." ".$args['asc_desc'];

	if (isset($args['limit']) && !isset($args['start']))
		$sql .= " LIMIT ".$args['limit'];

	if (isset($args['limit']) && isset($args['start']))
		$sql .= " LIMIT ".$args['start'].",".$args['limit'];

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if (isset($args['count'])) {
		if ($result && Sql_errorCode($result) === "00000") {
			$row = Sql_fetch($result);
			$count = $row['nb_enregistrements'];
		}
		return $count;
	} else {
		if ($result && Sql_errorCode($result) === "00000") {
			while($row = Sql_fetch($result)) {
				$id = $row['id_tweevent_email_validation'];
				$tab_result[$id]["id_tweevent_email_validation"]	= $id;
				$tab_result[$id]["id_tweevent_user"]					= $row['id_tweevent_user'];
				$tab_result[$id]["est_valide"]							= $row['est_valide'];
				$tab_result[$id]["timestamp"]								= Sql_prepareTexteAffichage($row['timestamp']);
				$tab_result[$id]["etat"]									= $row['etat'];
				$tab_result[$id]["date_add"]								= $row['date_add'];
				$tab_result[$id]["date_upd"]								= $row['date_upd'];
				$tab_result[$id]["info_tweevent_email_validation"]	= Sql_prepareTexteAffichage($row['info_tweevent_email_validation']);
			}
		}

		if (count($tab_result) == 1 && $args['timestamp'])
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_EMAIL_VALIDATION_INC__'))
?>