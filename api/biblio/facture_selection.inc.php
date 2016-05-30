<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Selections
*/

/**
 * Classe pour la gestion de selections
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE bdd_facture_selections (
	  id_selection int(11) NOT NULL AUTO_INCREMENT,
	  position int(11) NOT NULL,
	  id_facture int(11) NOT NULL,
	  type_selection varchar(32) NOT NULL,
	  designation varchar(64) NOT NULL,
	  description text NOT NULL,
	  pu_ht decimal(10,2) NOT NULL,
	  remise int(11) NOT NULL,
	  quantite int(11) NOT NULL,
	  tva decimal(2,2) NOT NULL,
	  date_add varchar(255) NOT NULL,
	  date_upd varchar(255) NOT NULL,
	  info_selection varchar(255) NOT NULL,
	  PRIMARY KEY (id_selection)
);

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_facture
// Clef de recherche 2 : type_selection

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__SELECTION_INC__')){
	define('__SELECTION_INC__', 1);

class Selection extends Element {
	var $id_selection;
	var $position;
	var $id_facture;
	var $type_selection;
	var $designation;
	var $description;
	var $pu_ht;
	var $remise;
	var $quantite;
	var $tva;
	var $date_add;
	var $date_upd;
	var $info_selection;

/** 
Constructeur de la classe.
*/
function Selection()
{
	$this->type_moi = "selections";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Selection.
*/
function getTab()
{
	$tab['id_selection']		= $this->id_selection;
	$tab['position']			= $this->position;
	$tab['id_facture']		= $this->id_facture;
	$tab['type_selection']	= $this->type_selection;
	$tab['designation']		= $this->designation;
	$tab['description']		= $this->description;
	$tab['pu_ht']				= $this->pu_ht;
	$tab['remise']				= $this->remise;
	$tab['quantite']			= $this->quantite;
	$tab['tva']					= $this->tva;
	$tab['date_add']			= $this->date_add;
	$tab['date_upd']			= $this->date_upd;
	$tab['info_selection']	= $this->info_selection;
	return $tab;
}

/**
Cette fonction ajoute un element de la table selection à la BDD. 
*/
function ADD()
{
	$position	 		= is_numeric($this->position) ? $this->position : 0;
	$id_facture 		= is_numeric($this->id_facture) ? $this->id_facture : 0;
	$type_selection 	= $this->type_selection;
	$designation 		= Lib_prepareTexteStockage($this->designation);
	$description 		= Lib_prepareTexteStockage($this->description);
	$pu_ht 				= strtr($this->pu_ht, ",", ".");
	$remise 				= is_numeric($this->remise) ? $this->remise : 0;
	$quantite 			= is_numeric($this->quantite) ? $this->quantite : 0;
	$tva 					= strtr($this->tva, ",", ".");
	$date_add 			= time();
	$info_selection 	= $this->info_selection;

	$sql = " INSERT INTO ".$GLOBALS['prefix']."facture_selections
					(position, id_facture, type_selection, 
					designation, description, pu_ht, 
					remise, quantite, tva, 
					date_add, info_selection)
				VALUES 
					 ($position, $id_facture, '$type_selection', 
					 '$designation', '$description', '$pu_ht', 
					 '$remise', $quantite, '$tva', 
					 '$date_add', '$info_selection')";

	if (!Db_execSql($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_selection = mysql_insert_id(); 
		Lib_sqlLog($sql." -- $id_selection");
		$this->id_selection = $this->id_selection;
		return $id_selection;
	}
	return;
}

/**
Cette fonction modifie un élément de la table selection dans la BDD. 
*/
function UPD()
{
	$id_selection 		= is_numeric($this->id_selection) ? $this->id_selection : 0;
	$position	 		= is_numeric($this->position) ? $this->position : 0;
	$id_facture 		= is_numeric($this->id_facture) ? $this->id_facture : 0;
	$type_selection 	= $this->type_selection;
	$designation 		= Lib_prepareTexteStockage($this->designation);
	$description 		= Lib_prepareTexteStockage($this->description);
	$pu_ht 				= strtr($this->pu_ht, ",", ".");
	$remise 				= is_numeric($this->remise) ? $this->remise : 0;
	$quantite 			= is_numeric($this->quantite) ? $this->quantite : 0;
	$tva 					= strtr($this->tva, ",", ".");
	$date_upd 			= time();
	$info_selection 	= $this->info_selection;

	$sql = " UPDATE ".$GLOBALS['prefix']."facture_selections
				SET position = $position, id_facture = $id_facture, type_selection = '$type_selection', 
					designation = '$designation', description = '$description', pu_ht = '$pu_ht', 
					remise = '$remise', quantite = $quantite, tva = '$tva', 
					date_upd = '$date_upd', info_selection = '$info_selection'
				WHERE id_selection = $id_selection";

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

	$id_selection = $this->id_selection;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."facture_selections
				WHERE id_selection = $id_selection";

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
	$str = Lib_addElem($str, $this->id_selection);
	$str = Lib_addElem($str, $this->position);
	$str = Lib_addElem($str, $this->id_facture);
	$str = Lib_addElem($str, $this->type_selection);
	$str = Lib_addElem($str, $this->designation);
	$str = Lib_addElem($str, $this->description);
	$str = Lib_addElem($str, $this->pu_ht);
	$str = Lib_addElem($str, $this->remise);
	$str = Lib_addElem($str, $this->quantite);
	$str = Lib_addElem($str, $this->tva);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_selection);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un selection suivant son identifiant
et retourne la coquille "Selection" remplie avec les informations récupérées
de la base.
@param id_selection.
*/
function Selection_recuperer($id_selection)
{
	$selection = new Selection();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."facture_selections
				WHERE id_selection = '$id_selection';";

	$result = mysql_query($sql);

   if ($result != NULL && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_array($result);
		$selection->id_selection	= $row['id_selection'];
		$selection->position			= $row['position'];
		$selection->id_facture		= $row['id_facture'];
		$selection->type_selection	= $row['type_selection'];
		$selection->designation		= Lib_prepareTexteAffichage($row['designation']);
		$selection->description		= Lib_prepareTexteAffichage($row['description']);
		$selection->pu_ht				= $row['pu_ht'];
		$selection->remise			= $row['remise'];
		$selection->quantite			= $row['quantite'];
		$selection->tva				= $row['tva'];
		$selection->date_add			= $row['date_add'];
		$selection->date_upd			= $row['date_upd'];
		$selection->info_selection	= $row['info_selection'];
	}
	return $selection;
}

/**
Retourne un tableau de selections correspondant aux champs du tableau en argument.
@param $args
*/
function Selections_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."facture_selections
				WHERE 1";

	if (!isset($args['id_selection']) && !isset($args['id_facture']) && 
		!isset($args['type_selection']) && !isset($args['position']) && 
		!isset($args['order_by']) && !isset($args['tab_ids_selections']))
		return $tab_result;

	$condition="";

	if (isset($args['id_selection']) && $args['id_selection'] != "*")
		$condition .= " AND id_selection = ".$args['id_selection']." ";
	if (isset($args['id_facture']) && $args['id_facture'] != "*")
		$condition .= " AND id_facture = ".$args['id_facture']." ";
	if (isset($args['position']) && $args['position'] != "*")
		$condition .= " AND position = ".$args['position']." ";
	if (isset($args['type_selection']) && $args['type_selection'] != "*")
		$condition .= " AND type_selection LIKE '".$args['type_selection']."' ";

	if (isset($args['tab_ids_selections']) && $args['tab_ids_selections'] != "*") {
		$ids = implode(",", $args['tab_ids_selections']);
		$condition .= " AND id_selection IN (0".$ids.") ";
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
			$id = $row['id_selection'];
			$tab_result[$id]["id_selection"]		= $id;
			$tab_result[$id]["position"]			= $row['position'];
			$tab_result[$id]["id_facture"]		= $row['id_facture'];
			$tab_result[$id]["type_selection"]	= $row['type_selection'];
			$tab_result[$id]["designation"]		= Lib_prepareTexteAffichage($row['designation']);
			$tab_result[$id]["description"]		= Lib_prepareTexteAffichage($row['description']);
			$tab_result[$id]["pu_ht"]				= $row['pu_ht'];
			$tab_result[$id]["remise"]				= $row['remise'];
			$tab_result[$id]["quantite"]			= $row['quantite'];
			$tab_result[$id]["tva"]					= $row['tva'];
			$tab_result[$id]["date_add"]			= $row['date_add'];
			$tab_result[$id]["date_upd"]			= $row['date_upd'];
			$tab_result[$id]["info_selection"]	= $row['info_selection'];
		}
	}

	if (count($tab_result) == 1 && ($args['id_selection'] != '' && $args['id_selection'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__SELECTION_INC__'))
?>