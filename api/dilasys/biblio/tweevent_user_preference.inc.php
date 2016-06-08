<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_user_preferences
*/

/**
 * Classe pour la gestion de tweevent_user_preferences
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_user_preference` (
	 `id_tweevent_user_preference` INT(11) NOT NULL auto_increment,
	 `id_tweevent_user` INT(11) NOT NULL,
	 `id_tweevent_preference` INT(11) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_user_preference` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_user_preference`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_tweevent_user
// Clef de recherche 2 : id_tweevent_preference
// Clef de recherche 3 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_USER_PREFERENCE_INC__')){
	define('__TWEEVENT_USER_PREFERENCE_INC__', 1);

class Tweevent_user_preference extends Element {
	var $id_tweevent_user_preference;
	var $id_tweevent_user;
	var $id_tweevent_preference;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_user_preference;

/** 
Constructeur de la classe.
*/
function Tweevent_user_preference()
{
	$this->type_moi = "tweevent_user_preferences";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_user_preference.
*/
function getTab()
{
	$tab['id_tweevent_user_preference']		= $this->id_tweevent_user_preference;
	$tab['id_tweevent_user']					= $this->id_tweevent_user;
	$tab['id_tweevent_preference']			= $this->id_tweevent_preference;
	$tab['etat']									= $this->etat;
	$tab['date_add']								= $this->date_add;
	$tab['date_upd']								= $this->date_upd;
	$tab['info_tweevent_user_preference']	= $this->info_tweevent_user_preference;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_user_preference à la BDD. 
*/
function ADD()
{
	$id_tweevent_user 					= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$id_tweevent_preference 			= is_numeric($this->id_tweevent_preference) ? $this->id_tweevent_preference : 0;
	$etat 									= $this->etat != '' ? $this->etat : 'actif';
	$date_add 								= time();
	$info_tweevent_user_preference 	= Sql_prepareTexteStockage($this->info_tweevent_user_preference);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_user_preference
					(id_tweevent_user, id_tweevent_preference, etat, 
					date_add, info_tweevent_user_preference
					)
				VALUES 
					 ('$id_tweevent_user', '$id_tweevent_preference', '$etat', 
					'$date_add', '$info_tweevent_user_preference'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_user_preference = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_user_preference");
		$this->id_tweevent_user_preference = $this->id_tweevent_user_preference;
		return $id_tweevent_user_preference;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_user_preference dans la BDD. 
*/
function UPD()
{
	$id_tweevent_user_preference 		= is_numeric($this->id_tweevent_user_preference) ? $this->id_tweevent_user_preference : 0;
	$id_tweevent_user 					= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$id_tweevent_preference 			= is_numeric($this->id_tweevent_preference) ? $this->id_tweevent_preference : 0;
	$etat 									= $this->etat;
	$date_upd 								= time();
	$info_tweevent_user_preference 	= Sql_prepareTexteStockage($this->info_tweevent_user_preference);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_user_preference
				SET id_tweevent_user = '$id_tweevent_user', id_tweevent_preference = '$id_tweevent_preference', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_user_preference = '$info_tweevent_user_preference'
					
				WHERE id_tweevent_user_preference = $id_tweevent_user_preference";

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

	$id_tweevent_user_preference = $this->id_tweevent_user_preference;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_user_preference
				WHERE id_tweevent_user_preference = $id_tweevent_user_preference";

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
	$str = Lib_addElem($str, $this->id_tweevent_user_preference);
	$str = Lib_addElem($str, $this->id_tweevent_user);
	$str = Lib_addElem($str, $this->id_tweevent_preference);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_user_preference);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_user_preference suivant son identifiant
et retourne la coquille "Tweevent_user_preference" remplie avec les informations récupérées
de la base.
@param id_tweevent_user_preference.
*/
function Tweevent_user_preference_recuperer($id_tweevent_user_preference, $tab_preferences)
{
	$tweevent_user_preference = new Tweevent_user_preference();

	if(empty($tab_preferences)) {
		$sql = " SELECT *
				FROM " . $GLOBALS['prefix'] . "tweevent_user_preference
				WHERE id_tweevent_user_preference = '$id_tweevent_user_preference';";
	}
	else {
		$id_utilisateur = $tab_preferences['id_utilisateur'];
		$id_preference = $tab_preferences['id_preference'];
		$sql = " SELECT *
				FROM " . $GLOBALS['prefix'] . "tweevent_user_preference
				WHERE id_tweevent_user = '$id_utilisateur' AND id_tweevent_preference = '$id_preference';";
	}

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_user_preference->id_tweevent_user_preference		= $row['id_tweevent_user_preference'];
		$tweevent_user_preference->id_tweevent_user					= $row['id_tweevent_user'];
		$tweevent_user_preference->id_tweevent_preference			= $row['id_tweevent_preference'];
		$tweevent_user_preference->etat									= $row['etat'];
		$tweevent_user_preference->date_add								= $row['date_add'];
		$tweevent_user_preference->date_upd								= $row['date_upd'];
		$tweevent_user_preference->info_tweevent_user_preference	= Sql_prepareTexteAffichage($row['info_tweevent_user_preference']);
	}
	return $tweevent_user_preference;
}

/**
Retourne un tableau de tweevent_user_preferences correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_user_preferences_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_user_preference
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_user_preference
					WHERE 1";
	}

	if (!isset($args['id_tweevent_user_preference']) && !isset($args['id_tweevent_user']) && !isset($args['id_tweevent_preference'])
		 && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_user_preferences']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_user_preference']) && $args['id_tweevent_user_preference'] != "*")
		$condition .= " AND id_tweevent_user_preference = '".$args['id_tweevent_user_preference']."' ";
	if (isset($args['id_tweevent_user']) && $args['id_tweevent_user'] != "*")
		$condition .= " AND id_tweevent_user = '".$args['id_tweevent_user']."' ";
	if (isset($args['id_tweevent_preference']) && $args['id_tweevent_preference'] != "*")
		$condition .= " AND id_tweevent_preference = '".$args['id_tweevent_preference']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_user_preferences']) && $args['tab_ids_tweevent_user_preferences'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_user_preferences']);
		$condition .= " AND id_tweevent_user_preference IN (0".$ids.") ";
	}
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
				$id = $row['id_tweevent_user_preference'];
				$tab_result[$id]["id_tweevent_user_preference"]		= $id;
				$tab_result[$id]["id_tweevent_user"]					= $row['id_tweevent_user'];
				$tab_result[$id]["id_tweevent_preference"]			= $row['id_tweevent_preference'];
				$tab_result[$id]["etat"]									= $row['etat'];
				$tab_result[$id]["date_add"]								= $row['date_add'];
				$tab_result[$id]["date_upd"]								= $row['date_upd'];
				$tab_result[$id]["info_tweevent_user_preference"]	= Sql_prepareTexteAffichage($row['info_tweevent_user_preference']);
			}
		}

		if (count($tab_result) == 1 && (($args['id_tweevent_user_preference'] != '' && $args['id_tweevent_user_preference'] != '*') || ($args['email_tweevent_user'] != '' )))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_USER_PREFERENCE_INC__'))
?>