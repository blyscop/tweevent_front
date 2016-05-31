<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_preference_categories
*/

/**
 * Classe pour la gestion de tweevent_preference_categories
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_preference_categorie` (
	 `id_tweevent_preference_categorie` INT(11) NOT NULL auto_increment,
	 `libelle_tweevent_preference_categorie` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_preference_categorie` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_preference_categorie`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_PREFERENCE_CATEGORIE_INC__')){
	define('__TWEEVENT_PREFERENCE_CATEGORIE_INC__', 1);

class Tweevent_preference_categorie extends Element {
	var $id_tweevent_preference_categorie;
	var $libelle_tweevent_preference_categorie;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_preference_categorie;

/** 
Constructeur de la classe.
*/
function Tweevent_preference_categorie()
{
	$this->type_moi = "tweevent_preference_categories";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_preference_categorie.
*/
function getTab()
{
	$tab['id_tweevent_preference_categorie']			= $this->id_tweevent_preference_categorie;
	$tab['libelle_tweevent_preference_categorie']	= $this->libelle_tweevent_preference_categorie;
	$tab['etat']												= $this->etat;
	$tab['date_add']											= $this->date_add;
	$tab['date_upd']											= $this->date_upd;
	$tab['info_tweevent_preference_categorie']		= $this->info_tweevent_preference_categorie;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_preference_categorie à la BDD. 
*/
function ADD()
{
	$libelle_tweevent_preference_categorie 	= Sql_prepareTexteStockage($this->libelle_tweevent_preference_categorie);
	$etat 												= $this->etat != '' ? $this->etat : 'actif';
	$date_add 											= time();
	$info_tweevent_preference_categorie 		= Sql_prepareTexteStockage($this->info_tweevent_preference_categorie);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_preference_categorie
					(libelle_tweevent_preference_categorie, etat, date_add, 
					info_tweevent_preference_categorie)
				VALUES 
					 ('$libelle_tweevent_preference_categorie', '$etat', '$date_add', 
					'$info_tweevent_preference_categorie')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_preference_categorie = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_preference_categorie");
		$this->id_tweevent_preference_categorie = $this->id_tweevent_preference_categorie;
		return $id_tweevent_preference_categorie;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_preference_categorie dans la BDD. 
*/
function UPD()
{
	$id_tweevent_preference_categorie 			= is_numeric($this->id_tweevent_preference_categorie) ? $this->id_tweevent_preference_categorie : 0;
	$libelle_tweevent_preference_categorie 	= Sql_prepareTexteStockage($this->libelle_tweevent_preference_categorie);
	$etat 												= $this->etat;
	$date_upd 											= time();
	$info_tweevent_preference_categorie 		= Sql_prepareTexteStockage($this->info_tweevent_preference_categorie);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_preference_categorie
				SET libelle_tweevent_preference_categorie = '$libelle_tweevent_preference_categorie', etat = '$etat', date_upd = '$date_upd', info_tweevent_preference_categorie = '$info_tweevent_preference_categorie'
				WHERE id_tweevent_preference_categorie = $id_tweevent_preference_categorie";

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

	$id_tweevent_preference_categorie = $this->id_tweevent_preference_categorie;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_preference_categorie
				WHERE id_tweevent_preference_categorie = $id_tweevent_preference_categorie";

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
	$str = Lib_addElem($str, $this->id_tweevent_preference_categorie);
	$str = Lib_addElem($str, $this->libelle_tweevent_preference_categorie);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_preference_categorie);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_preference_categorie suivant son identifiant
et retourne la coquille "Tweevent_preference_categorie" remplie avec les informations récupérées
de la base.
@param id_tweevent_preference_categorie.
*/
function Tweevent_preference_categorie_recuperer($id_tweevent_preference_categorie)
{
	$tweevent_preference_categorie = new Tweevent_preference_categorie();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_preference_categorie
				WHERE id_tweevent_preference_categorie = '$id_tweevent_preference_categorie';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_preference_categorie->id_tweevent_preference_categorie			= $row['id_tweevent_preference_categorie'];
		$tweevent_preference_categorie->libelle_tweevent_preference_categorie	= Sql_prepareTexteAffichage($row['libelle_tweevent_preference_categorie']);
		$tweevent_preference_categorie->etat												= $row['etat'];
		$tweevent_preference_categorie->date_add											= $row['date_add'];
		$tweevent_preference_categorie->date_upd											= $row['date_upd'];
		$tweevent_preference_categorie->info_tweevent_preference_categorie		= Sql_prepareTexteAffichage($row['info_tweevent_preference_categorie']);
	}
	return $tweevent_preference_categorie;
}

/**
Retourne un tableau de tweevent_preference_categories correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_preference_categories_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_preference_categorie
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_preference_categorie
					WHERE 1";
	}

	if (!isset($args['id_tweevent_preference_categorie']) && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_preference_categories']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_preference_categorie']) && $args['id_tweevent_preference_categorie'] != "*")
		$condition .= " AND id_tweevent_preference_categorie = '".$args['id_tweevent_preference_categorie']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_preference_categories']) && $args['tab_ids_tweevent_preference_categories'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_preference_categories']);
		$condition .= " AND id_tweevent_preference_categorie IN (0".$ids.") ";
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
				$id = $row['id_tweevent_preference_categorie'];
				$tab_result[$id]["id_tweevent_preference_categorie"]			= $id;
				$tab_result[$id]["libelle_tweevent_preference_categorie"]	= Sql_prepareTexteAffichage($row['libelle_tweevent_preference_categorie']);
				$tab_result[$id]["etat"]												= $row['etat'];
				$tab_result[$id]["date_add"]											= $row['date_add'];
				$tab_result[$id]["date_upd"]											= $row['date_upd'];
				$tab_result[$id]["info_tweevent_preference_categorie"]		= Sql_prepareTexteAffichage($row['info_tweevent_preference_categorie']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_preference_categorie'] != '' && $args['id_tweevent_preference_categorie'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_PREFERENCE_CATEGORIE_INC__'))
?>