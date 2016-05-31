<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Commande_details
*/

/**
 * Classe pour la gestion de commande_details
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `suivi_commande_detail` (
	 `id_commande_detail` INT(11) NOT NULL auto_increment,
	 `id_commande` INT(11) NOT NULL,
	 `id_saveur` INT(11) NOT NULL,
	 `id_taux_nicotine` INT(11) NOT NULL,
	 `quantite` INT(11) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_commande_detail` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_commande_detail`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_commande
// Clef de recherche 2 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__COMMANDE_DETAIL_INC__')){
	define('__COMMANDE_DETAIL_INC__', 1);

class Commande_detail extends Element {
	var $id_commande_detail;
	var $id_commande;
	var $id_saveur;
	var $id_taux_nicotine;
	var $quantite;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_commande_detail;

/** 
Constructeur de la classe.
*/
function Commande_detail()
{
	$this->type_moi = "commande_details";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Commande_detail.
*/
function getTab()
{
	$tab['id_commande_detail']		= $this->id_commande_detail;
	$tab['id_commande']				= $this->id_commande;
	$tab['id_saveur']					= $this->id_saveur;
	$tab['id_taux_nicotine']		= $this->id_taux_nicotine;
	$tab['quantite']					= $this->quantite;
	$tab['etat']						= $this->etat;
	$tab['date_add']					= $this->date_add;
	$tab['date_upd']					= $this->date_upd;
	$tab['info_commande_detail']	= $this->info_commande_detail;
	return $tab;
}

/**
Cette fonction ajoute un element de la table commande_detail à la BDD. 
*/
function ADD()
{
	$id_commande 				= is_numeric($this->id_commande) ? $this->id_commande : 0;
	$id_saveur 					= is_numeric($this->id_saveur) ? $this->id_saveur : 0;
	$id_taux_nicotine 		= is_numeric($this->id_taux_nicotine) ? $this->id_taux_nicotine : 0;
	$quantite 					= is_numeric($this->quantite) ? $this->quantite : 0;
	$etat 						= $this->etat != '' ? $this->etat : 'actif';
	$date_add 					= time();
	$info_commande_detail 	= Sql_prepareTexteStockage($this->info_commande_detail);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."commande_detail
					(id_commande, id_saveur, id_taux_nicotine, 
					quantite, etat, date_add, 
					info_commande_detail)
				VALUES 
					 ('$id_commande', '$id_saveur', '$id_taux_nicotine', 
					'$quantite', '$etat', '$date_add', 
					'$info_commande_detail')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_commande_detail = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_commande_detail");
		$this->id_commande_detail = $this->id_commande_detail;
		return $id_commande_detail;
	}
	return;
}

/**
Cette fonction modifie un élément de la table commande_detail dans la BDD. 
*/
function UPD()
{
	$id_commande_detail 		= is_numeric($this->id_commande_detail) ? $this->id_commande_detail : 0;
	$id_commande 				= is_numeric($this->id_commande) ? $this->id_commande : 0;
	$id_saveur 					= is_numeric($this->id_saveur) ? $this->id_saveur : 0;
	$id_taux_nicotine 		= is_numeric($this->id_taux_nicotine) ? $this->id_taux_nicotine : 0;
	$quantite 					= is_numeric($this->quantite) ? $this->quantite : 0;
	$etat 						= $this->etat;
	$date_upd 					= time();
	$info_commande_detail 	= Sql_prepareTexteStockage($this->info_commande_detail);

	$sql = " UPDATE ".$GLOBALS['prefix']."commande_detail
				SET id_commande = '$id_commande', id_saveur = '$id_saveur', id_taux_nicotine = '$id_taux_nicotine', 
					quantite = '$quantite', etat = '$etat', date_upd = '$date_upd', info_commande_detail = '$info_commande_detail'
				WHERE id_commande_detail = $id_commande_detail";

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

	$id_commande_detail = $this->id_commande_detail;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."commande_detail
				WHERE id_commande_detail = $id_commande_detail";

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
	$str = Lib_addElem($str, $this->id_commande_detail);
	$str = Lib_addElem($str, $this->id_commande);
	$str = Lib_addElem($str, $this->id_saveur);
	$str = Lib_addElem($str, $this->id_taux_nicotine);
	$str = Lib_addElem($str, $this->quantite);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_commande_detail);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un commande_detail suivant son identifiant
et retourne la coquille "Commande_detail" remplie avec les informations récupérées
de la base.
@param id_commande_detail.
*/
function Commande_detail_recuperer($id_commande_detail)
{
	$commande_detail = new Commande_detail();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."commande_detail
				WHERE id_commande_detail = '$id_commande_detail';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$commande_detail->id_commande_detail		= $row['id_commande_detail'];
		$commande_detail->id_commande				= $row['id_commande'];
		$commande_detail->id_saveur					= $row['id_saveur'];
		$commande_detail->id_taux_nicotine		= $row['id_taux_nicotine'];
		$commande_detail->quantite					= $row['quantite'];
		$commande_detail->etat						= $row['etat'];
		$commande_detail->date_add					= $row['date_add'];
		$commande_detail->date_upd					= $row['date_upd'];
		$commande_detail->info_commande_detail	= Sql_prepareTexteAffichage($row['info_commande_detail']);
	}
	return $commande_detail;
}

/**
Retourne un tableau de commande_details correspondant aux champs du tableau en argument.
@param $args
*/
function Commande_details_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."commande_detail
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."commande_detail
					WHERE 1";
	}

	if (!isset($args['id_commande_detail']) && !isset($args['id_commande']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_commande_details']))
		return $tab_result;

	$condition="";

	if (isset($args['id_commande_detail']) && $args['id_commande_detail'] != "*")
		$condition .= " AND id_commande_detail = '".$args['id_commande_detail']."' ";
	if (isset($args['id_commande']) && $args['id_commande'] != "*")
		$condition .= " AND id_commande = '".$args['id_commande']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_commande_details']) && $args['tab_ids_commande_details'] != "*") {
		$ids = implode(",", $args['tab_ids_commande_details']);
		$condition .= " AND id_commande_detail IN (0".$ids.") ";
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
				$id = $row['id_commande_detail'];
				$tab_result[$id]["id_commande_detail"]		= $id;
				$tab_result[$id]["id_commande"]				= $row['id_commande'];
				$tab_result[$id]["id_saveur"]					= $row['id_saveur'];
				$tab_result[$id]["id_taux_nicotine"]		= $row['id_taux_nicotine'];
				$tab_result[$id]["quantite"]					= $row['quantite'];
				$tab_result[$id]["etat"]						= $row['etat'];
				$tab_result[$id]["date_add"]					= $row['date_add'];
				$tab_result[$id]["date_upd"]					= $row['date_upd'];
				$tab_result[$id]["info_commande_detail"]	= Sql_prepareTexteAffichage($row['info_commande_detail']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_commande_detail'] != '' && $args['id_commande_detail'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__COMMANDE_DETAIL_INC__'))
?>