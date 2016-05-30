<? 
/** @file
*  @brief this file in Fiche_memos
*/

/**
 * Classe pour la gestion de fiche_memos
 *
 * @author DiLaSoft
 * @version 1.0
 * @code

CREATE TABLE `cms_fiche_memos` (
	 `id_memo` INT(11) NOT NULL auto_increment,
	 `id_fiche` INT(11) NOT NULL,
	 `nom_utilisateur` VARCHAR(100) NOT NULL,
	 `date_memo` INT(11) NULL,
	 `memo` TEXT NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_memo` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_memo`));

 * @endcode
 *
 */

if (!defined('__FICHE_MEMO_INC__')){
	define('__FICHE_MEMO_INC__', 1);

class FicheMemo extends Element {
	var $id_memo;
	var $id_fiche;
	var $date_memo;
	var $memo;
	var $date_add;
	var $date_upd;
	var $info_memo;

/** 
Constructeur de la classe.
*/
function FicheMemo()
{
	$this->type_moi = "fiche_memo";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Fiche_memo.
*/
function getTab()
{
	$tab['id_memo']	= $this->id_memo;
	$tab['id_fiche']	= $this->id_fiche;
	$tab['date_memo']	= $this->date_memo;
	$tab['memo']		= $this->memo;
	$tab['date_add']	= $this->date_add;
	$tab['date_upd']	= $this->date_upd;
	$tab['info_memo']	= $this->info_memo;
	return $tab;
}

/**
Cette fonction ajoute un element de la table fiche_memo à la BDD. 
*/
function ADD()
{
	$id_fiche 	= is_numeric($this->id_fiche) ? $this->id_fiche : 0;
	$date_memo 	= $this->date_memo;
	$memo 		= Sql_prepareTexteStockage($this->memo);
	$date_add 	= time();
	$info_memo 	= $this->info_memo;

	$sql = " INSERT INTO ".$GLOBALS['prefix']."fiche_memos
					(id_fiche, date_memo, 
					memo, date_add, info_memo)
				VALUES 
					 ('$id_fiche', $date_memo, 
					'$memo', '$date_add', '$info_memo')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_memo = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_memo");
		$this->id_memo = $this->id_memo;
		return $id_memo;
	}
	return;
}

/**
Cette fonction modifie un élément de la table fiche_memo dans la BDD. 
*/
function UPD()
{
	$id_memo 				= is_numeric($this->id_memo) ? $this->id_memo : 0;
	$id_fiche 				= is_numeric($this->id_fiche) ? $this->id_fiche : 0;
	$date_memo 				= $this->date_memo;
	$memo 					= Sql_prepareTexteStockage($this->memo);
	$date_upd 				= time();
	$info_memo 	= Sql_prepareTexteStockage($this->info_memo);

	$sql = " UPDATE ".$GLOBALS['prefix']."fiche_memos
				SET id_fiche = '$id_fiche', date_memo = $date_memo, 
					memo = '$memo', date_upd = '$date_upd', 
					info_memo = '$info_memo'
				WHERE id_memo = $id_memo";

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

	$id_memo = $this->id_memo;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."fiche_memos
				WHERE id_memo = $id_memo";

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
	$str = Lib_addElem($str, $this->id_memo);
	$str = Lib_addElem($str, $this->id_fiche);
	$str = Lib_addElem($str, $this->date_memo);
	$str = Lib_addElem($str, $this->memo);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_memo);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un fiche_memo suivant son identifiant
et retourne la coquille "Fiche_memo" remplie avec les informations récupérées
de la base.
@param id_memo.
*/
function FicheMemo_recuperer($id_memo)
{
	$fiche_memo = new FicheMemo();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."fiche_memos
				WHERE id_memo = '$id_memo';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$fiche_memo->id_memo				= $row['id_memo'];
		$fiche_memo->id_fiche				= $row['id_fiche'];
		$fiche_memo->date_memo				= $row['date_memo'];
		$fiche_memo->memo					= Sql_prepareTexteAffichage($row['memo']);
		$fiche_memo->date_add				= $row['date_add'];
		$fiche_memo->date_upd				= $row['date_upd'];
		$fiche_memo->info_memo	= Sql_prepareTexteAffichage($row['info_memo']);
	}
	return $fiche_memo;
}

/**
Retourne un tableau de fiche_memos correspondant aux champs du tableau en argument.
@param $args
*/
function FicheMemos_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."fiche_memos
				WHERE 1";

	if (!isset($args['id_memo']) && !isset($args['id_fiche'])
		 && !isset($args['order_by']) && !isset($args['tab_ids_memos'])  
		 && !isset($args['tab_ids_fiches']))
		return $tab_result;

	$condition="";

	if (isset($args['id_memo']) && $args['id_memo'] != "*")
		$condition .= " AND id_memo = ".$args['id_memo']." ";
	if (isset($args['id_fiche']) && $args['id_fiche'] != "*")
		$condition .= " AND id_fiche = ".$args['id_fiche']." ";
	if (isset($args['date_memo_min']))
		$condition .= " AND date_memo >= ".$args['date_memo_min']." ";
	if (isset($args['date_memo_max']))
		$condition .= " AND date_memo <= ".$args['date_memo_max']." ";

	if (isset($args['tab_ids_memos']) && $args['tab_ids_memos'] != "*") {
		$ids = implode(",", $args['tab_ids_memos']);
		$condition .= " AND id_memo IN (0".$ids.") ";
	}
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

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_memo'];
			$tab_result[$id]["id_memo"]				= $id;
			$tab_result[$id]["id_fiche"]				= $row['id_fiche'];
			$tab_result[$id]["date_memo"]				= $row['date_memo'];
			$tab_result[$id]["memo"]					= Sql_prepareTexteAffichage($row['memo']);
			$tab_result[$id]["date_add"]				= $row['date_add'];
			$tab_result[$id]["date_upd"]				= $row['date_upd'];
			$tab_result[$id]["info_memo"]	= Sql_prepareTexteAffichage($row['info_memo']);
		}
	}

	if (count($tab_result) == 1 && ($args['id_memo'] != '' && $args['id_memo'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__FICHE_MEMO_INC__'))
?>