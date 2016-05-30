<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Reglements
*/

/**
 * Classe pour la gestion de reglements
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `idcommunes_reglement` (
	 `id_reglement` INT(11) NOT NULL auto_increment,
	 `id_facture` INT(11) NOT NULL,
	 `montant` DECIMAL(10,2) NOT NULL,
	 `date_reglement` DATE NOT NULL,
	 `id_mode_reglement` INT(11) NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_reglement` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_reglement`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_facture
// Clef de recherche 2 : date_reglement
// Clef de recherche 3 : id_mode_reglement

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__REGLEMENT_INC__')){
	define('__REGLEMENT_INC__', 1);

class Reglement extends Element {
	var $id_reglement;
	var $id_facture;
	var $montant;
	var $date_reglement;
	var $id_mode_reglement;
	var $date_add;
	var $date_upd;
	var $info_reglement;

/** 
Constructeur de la classe.
*/
function Reglement()
{
	$this->type_moi = "reglements";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Reglement.
*/
function getTab()
{
	$tab['id_reglement']			= $this->id_reglement;
	$tab['id_facture']			= $this->id_facture;
	$tab['montant']				= $this->montant;
	$tab['date_reglement']		= $this->date_reglement;
	$tab['id_mode_reglement']	= $this->id_mode_reglement;
	$tab['date_add']				= $this->date_add;
	$tab['date_upd']				= $this->date_upd;
	$tab['info_reglement']		= $this->info_reglement;
	return $tab;
}

/**
Cette fonction ajoute un element de la table reglement à la BDD. 
*/
function ADD()
{
	$id_facture 			= is_numeric($this->id_facture) ? $this->id_facture : 0;
	$montant 				= strtr($this->montant, ",", ".");
	$date_reglement 		= Lib_frToEn($this->date_reglement);
	$id_mode_reglement 	= is_numeric($this->id_mode_reglement) ? $this->id_mode_reglement : 0;
	$date_add 				= time();
	$info_reglement 		= $this->info_reglement;

	$sql = " INSERT INTO ".$GLOBALS['prefix']."facture_reglements
					(id_facture, montant, date_reglement, 
					id_mode_reglement, date_add, info_reglement)
				VALUES 
					 ($id_facture, '$montant', '$date_reglement', 
					$id_mode_reglement, '$date_add', '$info_reglement')";

	if (!Db_execSql($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_reglement = mysql_insert_id(); 
		Lib_sqlLog($sql." -- $id_reglement");
		$this->id_reglement = $this->id_reglement;
		return $id_reglement;
	}
	return;
}

/**
Cette fonction modifie un élément de la table reglement dans la BDD. 
*/
function UPD()
{
	$id_reglement 			= is_numeric($this->id_reglement) ? $this->id_reglement : 0;
	$id_facture 			= is_numeric($this->id_facture) ? $this->id_facture : 0;
	$montant 				= strtr($this->montant, ",", ".");
	$date_reglement 		= Lib_frToEn($this->date_reglement);
	$id_mode_reglement 	= is_numeric($this->id_mode_reglement) ? $this->id_mode_reglement : 0;
	$date_upd 				= time();
	$info_reglement 		= $this->info_reglement;

	$sql = " UPDATE ".$GLOBALS['prefix']."facture_reglements
				SET id_facture = $id_facture, montant = '$montant', date_reglement = '$date_reglement', 
					id_mode_reglement = $id_mode_reglement, date_upd = '$date_upd', 
					info_reglement = '$info_reglement'
				WHERE id_reglement = $id_reglement";

	if (!Db_execSql($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/**
	Cette fonction supprime un chantier de la BDD.
*/
function DEL()
{
	if ($this->isError()) return;

	$id_reglement = $this->id_reglement;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."facture_reglements
				WHERE id_reglement = $id_reglement";

	if (!Db_execSql($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/** 
Cette fonction transforme les attributs en chaine de caractères.
*/
function toStr()
{
	$str = "";
	$str = Lib_addElem($str, $this->id_reglement);
	$str = Lib_addElem($str, $this->id_facture);
	$str = Lib_addElem($str, $this->montant);
	$str = Lib_addElem($str, $this->date_reglement);
	$str = Lib_addElem($str, $this->id_mode_reglement);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_reglement);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un reglement suivant son identifiant
et retourne la coquille "Reglement" remplie avec les informations récupérées
de la base.
@param id_reglement.
*/
function Reglement_recuperer($id_reglement)
{
	$reglement = new Reglement();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."facture_reglements
				WHERE id_reglement = '$id_reglement';";

	$result = mysql_query($sql);

   if ($result != NULL && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_array($result);
		$reglement->id_reglement			= $row['id_reglement'];
		$reglement->id_facture			= $row['id_facture'];
		$reglement->montant				= $row['montant'];
		$reglement->date_reglement		= Lib_enToFr($row['date_reglement']);
		$reglement->id_mode_reglement	= $row['id_mode_reglement'];
		$reglement->date_add				= $row['date_add'];
		$reglement->date_upd				= $row['date_upd'];
		$reglement->info_reglement		= $row['info_reglement'];
	}
	return $reglement;
}

/**
Retourne un tableau de reglements correspondant aux champs du tableau en argument.
@param $args
*/
function Reglements_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."facture_reglements
				WHERE 1";

	if (!isset($args['id_reglement']) && !isset($args['id_facture']) && !isset($args['date_reglement'])
		 && !isset($args['id_mode_reglement']) && !isset($args['order_by']) && !isset($args['tab_ids_reglements']))
		return $tab_result;

	$condition="";

	if (isset($args['id_reglement']) && $args['id_reglement'] != "*")
		$condition .= " AND id_reglement = '".$args['id_reglement']."' ";
	if (isset($args['id_facture']) && $args['id_facture'] != "*")
		$condition .= " AND id_facture = '".$args['id_facture']."' ";
	if (isset($args['date_reglement']) && $args['date_reglement'] != "*")
		$condition .= " AND date_reglement = '".Lib_frToEn($args['date_reglement'])."' ";
	if (isset($args['id_mode_reglement']) && $args['id_mode_reglement'] != "*")
		$condition .= " AND id_mode_reglement = '".$args['id_mode_reglement']."' ";

	if (isset($args['tab_ids_reglements']) && $args['tab_ids_reglements'] != "*") {
		$ids = implode(",", $args['tab_ids_reglements']);
		$condition .= " AND id_reglement IN (0".$ids.") ";
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
	$result = mysql_query($sql);

	if ($result) {
		while($row = mysql_fetch_array($result)) {
			$id = $row['id_reglement'];
			$tab_result[$id]["id_reglement"]			= $id;
			$tab_result[$id]["id_facture"]			= $row['id_facture'];
			$tab_result[$id]["montant"]				= $row['montant'];
			$tab_result[$id]["date_reglement"]		= Lib_enToFr($row['date_reglement']);
			$tab_result[$id]["id_mode_reglement"]	= $row['id_mode_reglement'];
			$tab_result[$id]["date_add"]				= $row['date_add'];
			$tab_result[$id]["date_upd"]				= $row['date_upd'];
			$tab_result[$id]["info_reglement"]		= $row['info_reglement'];
		}
	}

	if (count($tab_result) == 1 && ($args['id_reglement'] != '' && $args['id_reglement'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__REGLEMENT_INC__'))
?>