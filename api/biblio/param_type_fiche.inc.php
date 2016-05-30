<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Type_fiches
*/

/**
 * Classe pour la gestion de type_fiches
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `param_type_fiche` (
	 `id_type_fiche` INT(11) NOT NULL auto_increment,
	 `libelle` VARCHAR(255) NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_type_fiche` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_type_fiche`));

 * @endcode
 *
 */

// Clefs de recherche 

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TYPE_FICHE_INC__')){
	define('__TYPE_FICHE_INC__', 1);

class TypeFiche extends Element {
	var $id_type_fiche;
	var $libelle;
	var $date_add;
	var $date_upd;
	var $info_type_fiche;

/** 
Constructeur de la classe.
*/
function TypeFiche()
{
	$this->type_moi = "type_fiches";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Type_fiche.
*/
function getTab()
{
	$tab['id_type_fiche']	= $this->id_type_fiche;
	$tab['libelle']			= $this->libelle;
	$tab['date_add']			= $this->date_add;
	$tab['date_upd']			= $this->date_upd;
	$tab['info_type_fiche']	= $this->info_type_fiche;
	return $tab;
}

/**
Cette fonction ajoute un element de la table type_fiche à la BDD. 
*/
function ADD()
{
	$libelle 			= Sql_prepareTexteStockage($this->libelle);
	$date_add 			= time();
	$info_type_fiche 	= Sql_prepareTexteStockage($this->info_type_fiche);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."param_type_fiche
					(libelle, date_add, info_type_fiche)
				VALUES 
					 ('$libelle', '$date_add', '$info_type_fiche')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_type_fiche = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_type_fiche");
		$this->id_type_fiche = $this->id_type_fiche;
		return $id_type_fiche;
	}
	return;
}

/**
Cette fonction modifie un élément de la table type_fiche dans la BDD. 
*/
function UPD()
{
	$id_type_fiche 	= $this->id_type_fiche;
	$libelle 			= Sql_prepareTexteStockage($this->libelle);
	$date_upd 			= time();
	$info_type_fiche 	= Sql_prepareTexteStockage($this->info_type_fiche);

	$sql = " UPDATE ".$GLOBALS['prefix']."param_type_fiche
				SET  = '$', date_upd = '$date_upd', 
					info_type_fiche = '$info_type_fiche'
				WHERE id_type_fiche = $id_type_fiche";

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

	$id_type_fiche = $this->id_type_fiche;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."param_type_fiche
				WHERE id_type_fiche = $id_type_fiche";

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
	$str = Lib_addElem($str, $this->id_type_fiche);
	$str = Lib_addElem($str, $this->libelle);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_type_fiche);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un type_fiche suivant son identifiant
et retourne la coquille "Type_fiche" remplie avec les informations récupérées
de la base.
@param id_type_fiche.
*/
function TypeFiche_recuperer($id_type_fiche)
{
	$type_fiche = new Type_fiche();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."param_type_fiche
				WHERE id_type_fiche = '$id_type_fiche';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$type_fiche->id_type_fiche		= $row['id_type_fiche'];
		$type_fiche->libelle				= Sql_prepareTexteAffichage($row['libelle']);
		$type_fiche->date_add			= $row['date_add'];
		$type_fiche->date_upd			= $row['date_upd'];
		$type_fiche->info_type_fiche	= Sql_prepareTexteAffichage($row['info_type_fiche']);
	}
	return $type_fiche;
}

/**
Retourne un tableau de type_fiches correspondant aux champs du tableau en argument.
@param $args
*/
function TypesFiches_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."param_type_fiche
				WHERE 1";

	if (!isset($args['id_type_fiche']) && !isset($args['order_by']) && 
		!isset($args['libelle']) && !isset($args['tab_ids_type_fiches']))
		return $tab_result;

	$condition="";

	if (isset($args['id_type_fiche']) && $args['id_type_fiche'] != "*")
		$condition .= " AND id_type_fiche = '".$args['id_type_fiche']."' ";
	if (isset($args['libelle']) && $args['libelle'] != "*")
		$condition .= " AND libelle LIKE '".$args['libelle']."' ";

	if (isset($args['tab_ids_type_fiches']) && $args['tab_ids_type_fiches'] != "*") {
		$ids = implode(",", $args['tab_ids_type_fiches']);
		$condition .= " AND id_type_fiche IN (0".$ids.") ";
	}

	$sql .= $condition;

	if (isset($args['order_by']))
		$sql .= " ORDER BY ".$args['order_by']." ASC";
	if (isset($args['limit']) && !isset($args['start']))
		$sql .= " LIMIT ".$args['limit'];

	if (isset($args['limit']) && isset($args['start']))
		$sql .= " LIMIT ".$args['start'].",".$args['limit'];

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_type_fiche'];
			$tab_result[$id]["id_type_fiche"]	= $id;
			$tab_result[$id]["libelle"]			= Sql_prepareTexteAffichage($row['libelle']);
			$tab_result[$id]["date_add"]			= $row['date_add'];
			$tab_result[$id]["date_upd"]			= $row['date_upd'];
			$tab_result[$id]["info_type_fiche"]	= Sql_prepareTexteAffichage($row['info_type_fiche']);
		}
	}

	if (count($tab_result) == 1 && ($args['id_type_fiche'] != '' && $args['id_type_fiche'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}

function TypesFiches_getCache() {
	$data = Lib_readData('LISTE_TYPES_FICHES');
	// On essaye d'optimiser un peu les accès à la base de données.
	// Le fichier LISTE_TYPES_FICHES sera créé au premier accés et sera effacé lorsque l'administrateur
	// mettra à jour le parametrage avec de nouvelles informations
	if (count($data) > 1) {
		/*=============*/ Lib_myLog("Recuperation du parametrage des types de fiches a partir du cache");
		$liste_types = $data;
	} else {            
		/*=============*/ Lib_myLog("Recuperation du parametrage de l'etat des barriques a partir de la base");
		$args_etat['id_type_fiche'] = '*';
		$args_etat['order_by'] = 'id_type_fiche';
		$liste_types = TypesFiches_chercher($args_etat);
		Lib_writeData($liste_types, 'LISTE_TYPES_FICHES');
	}
	return $liste_types;
}

} // Fin if (!defined('__TYPE_FICHE_INC__'))
?>