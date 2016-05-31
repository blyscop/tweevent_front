<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_preferences
*/

/**
 * Classe pour la gestion de tweevent_preferences
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_preference` (
	 `id_tweevent_preference` INT(11) NOT NULL auto_increment,
	 `libelle_tweevent_preference` VARCHAR(255) NOT NULL,
	 `id_tweevent_categorie` INT(11) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_preference` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_preference`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_tweevent_categorie
// Clef de recherche 2 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_PREFERENCE_INC__')){
	define('__TWEEVENT_PREFERENCE_INC__', 1);

class Tweevent_preference extends Element {
	var $id_tweevent_preference;
	var $libelle_tweevent_preference;
	var $id_tweevent_categorie;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_preference;

/** 
Constructeur de la classe.
*/
function Tweevent_preference()
{
	$this->type_moi = "tweevent_preferences";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_preference.
*/
function getTab()
{
	$tab['id_tweevent_preference']		= $this->id_tweevent_preference;
	$tab['libelle_tweevent_preference']	= $this->libelle_tweevent_preference;
	$tab['id_tweevent_categorie']			= $this->id_tweevent_categorie;
	$tab['etat']								= $this->etat;
	$tab['date_add']							= $this->date_add;
	$tab['date_upd']							= $this->date_upd;
	$tab['info_tweevent_preference']		= $this->info_tweevent_preference;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_preference à la BDD. 
*/
function ADD()
{
	$libelle_tweevent_preference 	= Sql_prepareTexteStockage($this->libelle_tweevent_preference);
	$id_tweevent_categorie 			= is_numeric($this->id_tweevent_categorie) ? $this->id_tweevent_categorie : 0;
	$etat 								= $this->etat != '' ? $this->etat : 'actif';
	$date_add 							= time();
	$info_tweevent_preference 		= Sql_prepareTexteStockage($this->info_tweevent_preference);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_preference
					(libelle_tweevent_preference, id_tweevent_categorie, etat, 
					date_add, info_tweevent_preference
					)
				VALUES 
					 ('$libelle_tweevent_preference', '$id_tweevent_categorie', '$etat', 
					'$date_add', '$info_tweevent_preference'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_preference = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_preference");
		$this->id_tweevent_preference = $this->id_tweevent_preference;
		return $id_tweevent_preference;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_preference dans la BDD. 
*/
function UPD()
{
	$id_tweevent_preference 		= is_numeric($this->id_tweevent_preference) ? $this->id_tweevent_preference : 0;
	$libelle_tweevent_preference 	= Sql_prepareTexteStockage($this->libelle_tweevent_preference);
	$id_tweevent_categorie 			= is_numeric($this->id_tweevent_categorie) ? $this->id_tweevent_categorie : 0;
	$etat 								= $this->etat;
	$date_upd 							= time();
	$info_tweevent_preference 		= Sql_prepareTexteStockage($this->info_tweevent_preference);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_preference
				SET libelle_tweevent_preference = '$libelle_tweevent_preference', id_tweevent_categorie = '$id_tweevent_categorie', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_preference = '$info_tweevent_preference'
					
				WHERE id_tweevent_preference = $id_tweevent_preference";

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

	$id_tweevent_preference = $this->id_tweevent_preference;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_preference
				WHERE id_tweevent_preference = $id_tweevent_preference";

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
	$str = Lib_addElem($str, $this->id_tweevent_preference);
	$str = Lib_addElem($str, $this->libelle_tweevent_preference);
	$str = Lib_addElem($str, $this->id_tweevent_categorie);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_preference);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_preference suivant son identifiant
et retourne la coquille "Tweevent_preference" remplie avec les informations récupérées
de la base.
@param id_tweevent_preference.
*/
function Tweevent_preference_recuperer($id_tweevent_preference)
{
	$tweevent_preference = new Tweevent_preference();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_preference
				WHERE id_tweevent_preference = '$id_tweevent_preference';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_preference->id_tweevent_preference		= $row['id_tweevent_preference'];
		$tweevent_preference->libelle_tweevent_preference	= Sql_prepareTexteAffichage($row['libelle_tweevent_preference']);
		$tweevent_preference->id_tweevent_categorie			= $row['id_tweevent_categorie'];
		$tweevent_preference->etat								= $row['etat'];
		$tweevent_preference->date_add							= $row['date_add'];
		$tweevent_preference->date_upd							= $row['date_upd'];
		$tweevent_preference->info_tweevent_preference		= Sql_prepareTexteAffichage($row['info_tweevent_preference']);
	}
	return $tweevent_preference;
}

/**
Retourne un tableau de tweevent_preferences correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_preferences_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_preference
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_preference
					WHERE 1";
	}

	if (!isset($args['id_tweevent_preference']) && !isset($args['id_tweevent_categorie']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_preferences']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_preference']) && $args['id_tweevent_preference'] != "*")
		$condition .= " AND id_tweevent_preference = '".$args['id_tweevent_preference']."' ";
	if (isset($args['id_tweevent_categorie']) && $args['id_tweevent_categorie'] != "*")
		$condition .= " AND id_tweevent_categorie = '".$args['id_tweevent_categorie']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_preferences']) && $args['tab_ids_tweevent_preferences'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_preferences']);
		$condition .= " AND id_tweevent_preference IN (0".$ids.") ";
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
				$id = $row['id_tweevent_preference'];
				$tab_result[$id]["id_tweevent_preference"]		= $id;
				$tab_result[$id]["libelle_tweevent_preference"]	= Sql_prepareTexteAffichage($row['libelle_tweevent_preference']);
				$tab_result[$id]["id_tweevent_categorie"]			= $row['id_tweevent_categorie'];
				$tab_result[$id]["etat"]								= $row['etat'];
				$tab_result[$id]["date_add"]							= $row['date_add'];
				$tab_result[$id]["date_upd"]							= $row['date_upd'];
				$tab_result[$id]["info_tweevent_preference"]		= Sql_prepareTexteAffichage($row['info_tweevent_preference']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_preference'] != '' && $args['id_tweevent_preference'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_PREFERENCE_INC__'))
?>