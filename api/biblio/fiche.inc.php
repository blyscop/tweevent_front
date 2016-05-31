<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Fiches
*/

/**
 * Classe pour la gestion de fiches
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `annuaire_fiche` (
	 `id_fiche` INT(11) NOT NULL auto_increment,
	 `id_type_fiche` INT(11) NOT NULL,
	 `fic_prenom` VARCHAR(255) NOT NULL,
	 `fic_nom` VARCHAR(255) NOT NULL,
	 `fic_adresse1` VARCHAR(255) NOT NULL,
	 `fic_adresse2` VARCHAR(255) NOT NULL,
	 `fic_adresse3` VARCHAR(255) NOT NULL,
	 `fic_cp` VARCHAR(255) NOT NULL,
	 `fic_ville` VARCHAR(255) NOT NULL,
	 `fic_email` VARCHAR(255) NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_fiche` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_fiche`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_type_fiche
// Clef de recherche 2 : fic_prenom
// Clef de recherche 3 : fic_nom
// Clef de recherche 4 : fic_email

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__FICHE_INC__')){
	define('__FICHE_INC__', 1);

class Fiche extends Element {
	var $id_fiche;
	var $id_type_fiche;
	var $fic_prenom;
	var $fic_nom;
	var $fic_adresse1;
	var $fic_adresse2;
	var $fic_adresse3;
	var $fic_cp;
	var $fic_ville;
	var $fic_email;
	var $fic_document;
	var $date_add;
	var $date_upd;
	var $info_fiche;

/** 
Constructeur de la classe.
*/
function Fiche()
{
	$this->type_moi = "fiches";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Fiche.
*/
function getTab()
{
	$tab['id_fiche']			= $this->id_fiche;
	$tab['id_type_fiche']		= $this->id_type_fiche;
	$tab['fic_prenom']			= $this->fic_prenom;
	$tab['fic_nom']				= $this->fic_nom;
	$tab['fic_adresse1']		= $this->fic_adresse1;
	$tab['fic_adresse2']		= $this->fic_adresse2;
	$tab['fic_adresse3']		= $this->fic_adresse3;
	$tab['fic_cp']				= $this->fic_cp;
	$tab['fic_ville']			= $this->fic_ville;
	$tab['fic_email']			= $this->fic_email;
	$tab['fic_document']		= $this->fic_document;
	$tab['date_add']			= $this->date_add;
	$tab['date_upd']			= $this->date_upd;
	$tab['info_fiche']		= $this->info_fiche;
	return $tab;
}

/**
Cette fonction ajoute un element de la table fiche à la BDD. 
*/
function ADD()
{
	$id_type_fiche 		= $this->id_type_fiche;
	$fic_prenom 		= Sql_prepareTexteStockage($this->fic_prenom);
	$fic_nom 			= Sql_prepareTexteStockage($this->fic_nom);
	$fic_adresse1 		= Sql_prepareTexteStockage($this->fic_adresse1);
	$fic_adresse2 		= Sql_prepareTexteStockage($this->fic_adresse2);
	$fic_adresse3 		= Sql_prepareTexteStockage($this->fic_adresse3);
	$fic_cp 			= Sql_prepareTexteStockage($this->fic_cp);
	$fic_ville 			= Sql_prepareTexteStockage($this->fic_ville);
	$fic_email 			= Sql_prepareTexteStockage($this->fic_email);
	$fic_document 		= Sql_prepareTexteStockage($this->fic_document);
	$date_add 			= time();
	$info_fiche 		= Sql_prepareTexteStockage($this->info_fiche);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."fiche
					(id_type_fiche, fic_prenom, fic_nom, 
					fic_adresse1, fic_adresse2, fic_adresse3, 
					fic_cp, fic_ville, fic_email, fic_document,
					date_add, info_fiche
					)
				VALUES 
					 ('$id_type_fiche', '$fic_prenom', '$fic_nom', 
					'$fic_adresse1', '$fic_adresse2', '$fic_adresse3', 
					'$fic_cp', '$fic_ville', '$fic_email', '$fic_document', 
					'$date_add', '$info_fiche'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_fiche = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_fiche");
		$this->id_fiche = $this->id_fiche;
		return $id_fiche;
	}
	return;
}

/**
Cette fonction modifie un élément de la table fiche dans la BDD. 
*/
function UPD()
{
	$id_fiche 			= $this->id_fiche;
	$id_type_fiche 		= $this->id_type_fiche;
	$fic_prenom 		= Sql_prepareTexteStockage($this->fic_prenom);
	$fic_nom 			= Sql_prepareTexteStockage($this->fic_nom);
	$fic_adresse1 		= Sql_prepareTexteStockage($this->fic_adresse1);
	$fic_adresse2 		= Sql_prepareTexteStockage($this->fic_adresse2);
	$fic_adresse3 		= Sql_prepareTexteStockage($this->fic_adresse3);
	$fic_cp 			= Sql_prepareTexteStockage($this->fic_cp);
	$fic_ville 			= Sql_prepareTexteStockage($this->fic_ville);
	$fic_email 			= Sql_prepareTexteStockage($this->fic_email);
	$fic_document 		= Sql_prepareTexteStockage($this->fic_document);
	$date_upd 			= time();
	$info_fiche 		= Sql_prepareTexteStockage($this->info_fiche);

	$sql = " UPDATE ".$GLOBALS['prefix']."fiche
				SET id_type_fiche = '$id_type_fiche', fic_prenom = '$fic_prenom', fic_nom = '$fic_nom', 
					fic_adresse1 = '$fic_adresse1', fic_adresse2 = '$fic_adresse2', fic_adresse3 = '$fic_adresse3', 
					fic_cp = '$fic_cp', fic_ville = '$fic_ville', fic_email = '$fic_email', fic_document = '$fic_document', 
					date_upd = '$date_upd', info_fiche = '$info_fiche'
					
				WHERE id_fiche = $id_fiche";

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

	$id_fiche = $this->id_fiche;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."fiche
				WHERE id_fiche = $id_fiche";

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
	$str = Lib_addElem($str, $this->id_fiche);
	$str = Lib_addElem($str, $this->id_type_fiche);
	$str = Lib_addElem($str, $this->fic_prenom);
	$str = Lib_addElem($str, $this->fic_nom);
	$str = Lib_addElem($str, $this->fic_adresse1);
	$str = Lib_addElem($str, $this->fic_adresse2);
	$str = Lib_addElem($str, $this->fic_adresse3);
	$str = Lib_addElem($str, $this->fic_cp);
	$str = Lib_addElem($str, $this->fic_ville);
	$str = Lib_addElem($str, $this->fic_email);
	$str = Lib_addElem($str, $this->fic_document);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_fiche);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un fiche suivant son identifiant
et retourne la coquille "Fiche" remplie avec les informations récupérées
de la base.
@param id_fiche.
*/
function Fiche_recuperer($id_fiche = '', $fic_prenom = '', $fic_nom = '')
{
	$fiche = new Fiche();

	if ($id_fiche != '') {
		$sql = " SELECT *
					FROM ".$GLOBALS['prefix']."fiche
					WHERE id_fiche = '$id_fiche';";
	}

	if ($fic_prenom != '' && $fic_nom != '') {
		$sql = " SELECT *
					FROM ".$GLOBALS['prefix']."fiche
					WHERE fic_prenom = '$fic_prenom' AND fic_nom = '$fic_nom';";
	}

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$fiche->id_fiche			= $row['id_fiche'];
		$fiche->id_type_fiche		= $row['id_type_fiche'];
		$fiche->fic_prenom			= Sql_prepareTexteAffichage($row['fic_prenom']);
		$fiche->fic_nom				= Sql_prepareTexteAffichage($row['fic_nom']);
		$fiche->fic_adresse1		= Sql_prepareTexteAffichage($row['fic_adresse1']);
		$fiche->fic_adresse2		= Sql_prepareTexteAffichage($row['fic_adresse2']);
		$fiche->fic_adresse3		= Sql_prepareTexteAffichage($row['fic_adresse3']);
		$fiche->fic_cp				= Sql_prepareTexteAffichage($row['fic_cp']);
		$fiche->fic_ville			= Sql_prepareTexteAffichage($row['fic_ville']);
		$fiche->fic_email			= Sql_prepareTexteAffichage($row['fic_email']);
		$fiche->fic_document		= Sql_prepareTexteAffichage($row['fic_document']);
		$fiche->date_add			= Sql_prepareTexteAffichage($row['date_add']);
		$fiche->date_upd			= Sql_prepareTexteAffichage($row['date_upd']);
		$fiche->info_fiche			= Sql_prepareTexteAffichage($row['info_fiche']);
	}
	return $fiche;
}

/**
Retourne un tableau de fiches correspondant aux champs du tableau en argument.
@param $args
*/
function Fiches_chercher($args)
{
	$count = 0;
	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements
					FROM ".$GLOBALS['prefix']."fiche
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."fiche
					WHERE 1";
	}

	if (!isset($args['id_fiche']) && !isset($args['id_type_fiche']) && !isset($args['fic_prenom'])
		 && !isset($args['fic_nom']) && !isset($args['fic_email']) && !isset($args['order_by']) && !isset($args['tab_ids_fiches']))
		return $tab_result;

	$condition="";

	if (isset($args['id_fiche']) && $args['id_fiche'] != "*")
		$condition .= " AND id_fiche = '".$args['id_fiche']."' ";
	if (isset($args['id_type_fiche']) && $args['id_type_fiche'] != "*")
		$condition .= " AND id_type_fiche = '".$args['id_type_fiche']."' ";
	if (isset($args['fic_prenom']) && $args['fic_prenom'] != "*")
		$condition .= " AND fic_prenom LIKE '".Sql_prepareTexteStockage($args['fic_prenom'])."' ";
	if (isset($args['fic_nom']) && $args['fic_nom'] != "*")
		$condition .= " AND fic_nom LIKE '".Sql_prepareTexteStockage($args['fic_nom'])."' ";
	if (isset($args['fic_email']) && $args['fic_email'] != "*")
		$condition .= " AND fic_email LIKE '".Sql_prepareTexteStockage($args['fic_email'])."' ";

	if (isset($args['tab_ids_fiches']) && $args['tab_ids_fiches'] != "*") {
		$ids = implode(",", $args['tab_ids_fiches']);
		$condition .= " AND id_fiche IN (0".$ids.") ";
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
				$id = $row['id_fiche'];
				$tab_result[$id]["id_fiche"]			= $id;
				$tab_result[$id]["id_type_fiche"]		= $row['id_type_fiche'];
				$tab_result[$id]["fic_prenom"]			= Sql_prepareTexteAffichage($row['fic_prenom']);
				$tab_result[$id]["fic_nom"]				= Sql_prepareTexteAffichage($row['fic_nom']);
				$tab_result[$id]["fic_adresse1"]		= Sql_prepareTexteAffichage($row['fic_adresse1']);
				$tab_result[$id]["fic_adresse2"]		= Sql_prepareTexteAffichage($row['fic_adresse2']);
				$tab_result[$id]["fic_adresse3"]		= Sql_prepareTexteAffichage($row['fic_adresse3']);
				$tab_result[$id]["fic_cp"]				= Sql_prepareTexteAffichage($row['fic_cp']);
				$tab_result[$id]["fic_ville"]			= Sql_prepareTexteAffichage($row['fic_ville']);
				$tab_result[$id]["fic_email"]			= Sql_prepareTexteAffichage($row['fic_email']);
				$tab_result[$id]["fic_document"]		= Sql_prepareTexteAffichage($row['fic_document']);
				$tab_result[$id]["date_add"]			= Sql_prepareTexteAffichage($row['date_add']);
				$tab_result[$id]["date_upd"]			= Sql_prepareTexteAffichage($row['date_upd']);
				$tab_result[$id]["info_fiche"]			= Sql_prepareTexteAffichage($row['info_fiche']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_fiche'] != '' && $args['id_fiche'] != '*'))
			$tab_result = array_pop($tab_result);

		return $tab_result;
	}
}

function Fiches_count($args)
{
	$count = 0;

	$sql = " SELECT count(*) nb_enregistrements
				FROM ".$GLOBALS['prefix']."fiche
				WHERE 1";

	if (!isset($args['id_fiche']) && !isset($args['id_type_fiche']) && !isset($args['fic_prenom'])
		 && !isset($args['fic_nom']) && !isset($args['fic_email']) && !isset($args['order_by']) && !isset($args['tab_ids_fiches']))
		return $count;

	$condition="";

	if (isset($args['id_fiche']) && $args['id_fiche'] != "*")
		$condition .= " AND id_fiche = '".$args['id_fiche']."' ";
	if (isset($args['id_type_fiche']) && $args['id_type_fiche'] != "*")
		$condition .= " AND id_type_fiche = '".$args['id_type_fiche']."' ";
	if (isset($args['fic_prenom']) && $args['fic_prenom'] != "*")
		$condition .= " AND fic_prenom LIKE '".Sql_prepareTexteStockage($args['fic_prenom'])."' ";
	if (isset($args['fic_nom']) && $args['fic_nom'] != "*")
		$condition .= " AND fic_nom LIKE '".Sql_prepareTexteStockage($args['fic_nom'])."' ";
	if (isset($args['fic_email']) && $args['fic_email'] != "*")
		$condition .= " AND fic_email LIKE '".Sql_prepareTexteStockage($args['fic_email'])."' ";

	if (isset($args['tab_ids_fiches']) && $args['tab_ids_fiches'] != "*") {
		$ids = implode(",", $args['tab_ids_fiches']);
		$condition .= " AND id_fiche IN (0".$ids.") ";
	}

	$sql .= $condition;

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$count = $row['nb_enregistrements'];
	}

	return $count;
}

} // Fin if (!defined('__FICHE_INC__'))
?>