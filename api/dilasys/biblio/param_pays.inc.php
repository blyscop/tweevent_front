<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Param_pays
*/

/**
 * Classe pour la gestion de param_pays
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `cms_v5_param_pays` (
	 `id_param_pays` INT(11) NOT NULL auto_increment,
	 `code` INT(3) NOT NULL,
	 `alpha2` VARCHAR(2) NOT NULL,
	 `alpha3` VARCHAR(3) NOT NULL,
	 `nom_en` VARCHAR(255) NOT NULL,
	 `nom_fr` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_param_pays` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_param_pays`));

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
if (!defined('__PARAM_PAYS_INC__')){
	define('__PARAM_PAYS_INC__', 1);

class Param_pays extends Element {
	var $id_param_pays;
	var $code;
	var $alpha2;
	var $alpha3;
	var $nom_en;
	var $nom_fr;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_param_pays;

/** 
Constructeur de la classe.
*/
function Param_pays()
{
	$this->type_moi = "param_pays";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Param_pays.
*/
function getTab()
{
	$tab['id_param_pays']	= $this->id_param_pays;
	$tab['code']				= $this->code;
	$tab['alpha2']				= $this->alpha2;
	$tab['alpha3']				= $this->alpha3;
	$tab['nom_en']				= $this->nom_en;
	$tab['nom_fr']				= $this->nom_fr;
	$tab['etat']				= $this->etat;
	$tab['date_add']			= $this->date_add;
	$tab['date_upd']			= $this->date_upd;
	$tab['info_param_pays']	= $this->info_param_pays;
	return $tab;
}

/**
Cette fonction ajoute un element de la table param_pays à la BDD. 
*/
function ADD()
{
	$code 				= is_numeric($this->code) ? $this->code : 0;
	$alpha2 				= Sql_prepareTexteStockage($this->alpha2);
	$alpha3 				= Sql_prepareTexteStockage($this->alpha3);
	$nom_en 				= Sql_prepareTexteStockage($this->nom_en);
	$nom_fr 				= Sql_prepareTexteStockage($this->nom_fr);
	$etat 				= $this->etat != '' ? $this->etat : 'actif';
	$date_add 			= time();
	$info_param_pays 	= Sql_prepareTexteStockage($this->info_param_pays);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."param_pays
					(code, alpha2, alpha3, 
					nom_en, nom_fr, etat, 
					date_add, info_param_pays
					)
				VALUES 
					 ('$code', '$alpha2', '$alpha3', 
					'$nom_en', '$nom_fr', '$etat', 
					'$date_add', '$info_param_pays'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_param_pays = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_param_pays");
		$this->id_param_pays = $this->id_param_pays;
		return $id_param_pays;
	}
	return;
}

/**
Cette fonction modifie un élément de la table param_pays dans la BDD. 
*/
function UPD()
{
	$id_param_pays 	= is_numeric($this->id_param_pays) ? $this->id_param_pays : 0;
	$code 				= is_numeric($this->code) ? $this->code : 0;
	$alpha2 				= Sql_prepareTexteStockage($this->alpha2);
	$alpha3 				= Sql_prepareTexteStockage($this->alpha3);
	$nom_en 				= Sql_prepareTexteStockage($this->nom_en);
	$nom_fr 				= Sql_prepareTexteStockage($this->nom_fr);
	$etat 				= $this->etat;
	$date_upd 			= time();
	$info_param_pays 	= Sql_prepareTexteStockage($this->info_param_pays);

	$sql = " UPDATE ".$GLOBALS['prefix']."param_pays
				SET code = '$code', alpha2 = '$alpha2', alpha3 = '$alpha3', 
					nom_en = '$nom_en', nom_fr = '$nom_fr', etat = '$etat', 
					date_upd = '$date_upd', info_param_pays = '$info_param_pays'
					
				WHERE id_param_pays = $id_param_pays";

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

	$id_param_pays = $this->id_param_pays;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."param_pays
				WHERE id_param_pays = $id_param_pays";

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
	$str = Lib_addElem($str, $this->id_param_pays);
	$str = Lib_addElem($str, $this->code);
	$str = Lib_addElem($str, $this->alpha2);
	$str = Lib_addElem($str, $this->alpha3);
	$str = Lib_addElem($str, $this->nom_en);
	$str = Lib_addElem($str, $this->nom_fr);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_param_pays);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un param_pays suivant son identifiant
et retourne la coquille "Param_pays" remplie avec les informations récupérées
de la base.
@param id_param_pays.
*/
function Param_pays_recuperer($id_param_pays)
{
	$param_pays = new Param_pays();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."param_pays
				WHERE id_param_pays = '$id_param_pays';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$param_pays->id_param_pays	= $row['id_param_pays'];
		$param_pays->code				= $row['code'];
		$param_pays->alpha2				= Sql_prepareTexteAffichage($row['alpha2']);
		$param_pays->alpha3				= Sql_prepareTexteAffichage($row['alpha3']);
		$param_pays->nom_en				= Sql_prepareTexteAffichage($row['nom_en']);
		$param_pays->nom_fr				= Sql_prepareTexteAffichage($row['nom_fr']);
		$param_pays->etat				= $row['etat'];
		$param_pays->date_add			= $row['date_add'];
		$param_pays->date_upd			= $row['date_upd'];
		$param_pays->info_param_pays	= Sql_prepareTexteAffichage($row['info_param_pays']);
	}
	return $param_pays;
}

/**
Retourne un tableau de param_pays correspondant aux champs du tableau en argument.
@param $args
*/
function Param_pays_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."param_pays
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."param_pays
					WHERE 1";
	}

	if (!isset($args['id_param_pays']) && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_param_pays']))
		return $tab_result;

	$condition="";

	if (isset($args['id_param_pays']) && $args['id_param_pays'] != "*")
		$condition .= " AND id_param_pays = '".$args['id_param_pays']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_param_pays']) && $args['tab_ids_param_pays'] != "*") {
		$ids = implode(",", $args['tab_ids_param_pays']);
		$condition .= " AND id_param_pays IN (0".$ids.") ";
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
				$id = $row['id_param_pays'];
				$tab_result[$id]["id_param_pays"]	= $id;
				$tab_result[$id]["code"]				= $row['code'];
				$tab_result[$id]["alpha2"]				= Sql_prepareTexteAffichage($row['alpha2']);
				$tab_result[$id]["alpha3"]				= Sql_prepareTexteAffichage($row['alpha3']);
				$tab_result[$id]["nom_en"]				= Sql_prepareTexteAffichage($row['nom_en']);
				$tab_result[$id]["nom_fr"]				= Sql_prepareTexteAffichage($row['nom_fr']);
				$tab_result[$id]["etat"]				= $row['etat'];
				$tab_result[$id]["date_add"]			= $row['date_add'];
				$tab_result[$id]["date_upd"]			= $row['date_upd'];
				$tab_result[$id]["info_param_pays"]	= Sql_prepareTexteAffichage($row['info_param_pays']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_param_pays'] != '' && $args['id_param_pays'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__PARAM_PAYS_INC__'))
?>