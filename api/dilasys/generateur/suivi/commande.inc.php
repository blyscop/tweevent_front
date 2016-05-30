<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Commandes
*/

/**
 * Classe pour la gestion de commandes
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `suivi_commande` (
	 `id_commande` INT(11) NOT NULL auto_increment,
	 `id_utilisateur` INT(11) NOT NULL,
	 `id_customer` INT(11) NOT NULL,
	 `id_pg_vg` INT(11) NOT NULL,
	 `date_commande` DATE NOT NULL,
	 `nb_imp` INT(11) NOT NULL,
	 `num_lot` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_commande` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_commande`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_utilisateur
// Clef de recherche 2 : id_customer
// Clef de recherche 3 : id_pg_vg
// Clef de recherche 4 : date_commande
// Clef de recherche 5 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__COMMANDE_INC__')){
	define('__COMMANDE_INC__', 1);

class Commande extends Element {
	var $id_commande;
	var $id_utilisateur;
	var $id_customer;
	var $id_pg_vg;
	var $date_commande;
	var $nb_imp;
	var $num_lot;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_commande;

/** 
Constructeur de la classe.
*/
function Commande()
{
	$this->type_moi = "commandes";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Commande.
*/
function getTab()
{
	$tab['id_commande']		= $this->id_commande;
	$tab['id_utilisateur']	= $this->id_utilisateur;
	$tab['id_customer']		= $this->id_customer;
	$tab['id_pg_vg']			= $this->id_pg_vg;
	$tab['date_commande']	= $this->date_commande;
	$tab['nb_imp']				= $this->nb_imp;
	$tab['num_lot']			= $this->num_lot;
	$tab['etat']				= $this->etat;
	$tab['date_add']			= $this->date_add;
	$tab['date_upd']			= $this->date_upd;
	$tab['info_commande']	= $this->info_commande;
	return $tab;
}

/**
Cette fonction ajoute un element de la table commande à la BDD. 
*/
function ADD()
{
	$id_utilisateur 	= is_numeric($this->id_utilisateur) ? $this->id_utilisateur : 0;
	$id_customer 		= is_numeric($this->id_customer) ? $this->id_customer : 0;
	$id_pg_vg 			= is_numeric($this->id_pg_vg) ? $this->id_pg_vg : 0;
	$date_commande 	= Lib_frToEn($this->date_commande);
	$nb_imp 				= is_numeric($this->nb_imp) ? $this->nb_imp : 0;
	$num_lot 			= Sql_prepareTexteStockage($this->num_lot);
	$etat 				= $this->etat != '' ? $this->etat : 'actif';
	$date_add 			= time();
	$info_commande 	= Sql_prepareTexteStockage($this->info_commande);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."commande
					(id_utilisateur, id_customer, id_pg_vg, 
					date_commande, nb_imp, num_lot, 
					etat, date_add, info_commande)
				VALUES 
					 ('$id_utilisateur', '$id_customer', '$id_pg_vg', 
					'$date_commande', '$nb_imp', '$num_lot', 
					'$etat', '$date_add', '$info_commande')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_commande = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_commande");
		$this->id_commande = $this->id_commande;
		return $id_commande;
	}
	return;
}

/**
Cette fonction modifie un élément de la table commande dans la BDD. 
*/
function UPD()
{
	$id_commande 		= is_numeric($this->id_commande) ? $this->id_commande : 0;
	$id_utilisateur 	= is_numeric($this->id_utilisateur) ? $this->id_utilisateur : 0;
	$id_customer 		= is_numeric($this->id_customer) ? $this->id_customer : 0;
	$id_pg_vg 			= is_numeric($this->id_pg_vg) ? $this->id_pg_vg : 0;
	$date_commande 	= Lib_frToEn($this->date_commande);
	$nb_imp 				= is_numeric($this->nb_imp) ? $this->nb_imp : 0;
	$num_lot 			= Sql_prepareTexteStockage($this->num_lot);
	$etat 				= $this->etat;
	$date_upd 			= time();
	$info_commande 	= Sql_prepareTexteStockage($this->info_commande);

	$sql = " UPDATE ".$GLOBALS['prefix']."commande
				SET id_utilisateur = '$id_utilisateur', id_customer = '$id_customer', id_pg_vg = '$id_pg_vg', 
					date_commande = '$date_commande', nb_imp = '$nb_imp', num_lot = '$num_lot', 
					etat = '$etat', date_upd = '$date_upd', 
					info_commande = '$info_commande'
				WHERE id_commande = $id_commande";

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

	$id_commande = $this->id_commande;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."commande
				WHERE id_commande = $id_commande";

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
	$str = Lib_addElem($str, $this->id_commande);
	$str = Lib_addElem($str, $this->id_utilisateur);
	$str = Lib_addElem($str, $this->id_customer);
	$str = Lib_addElem($str, $this->id_pg_vg);
	$str = Lib_addElem($str, $this->date_commande);
	$str = Lib_addElem($str, $this->nb_imp);
	$str = Lib_addElem($str, $this->num_lot);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_commande);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un commande suivant son identifiant
et retourne la coquille "Commande" remplie avec les informations récupérées
de la base.
@param id_commande.
*/
function Commande_recuperer($id_commande)
{
	$commande = new Commande();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."commande
				WHERE id_commande = '$id_commande';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$commande->id_commande		= $row['id_commande'];
		$commande->id_utilisateur	= $row['id_utilisateur'];
		$commande->id_customer		= $row['id_customer'];
		$commande->id_pg_vg			= $row['id_pg_vg'];
		$commande->date_commande	= Lib_enToFr($row['date_commande']);
		$commande->nb_imp				= $row['nb_imp'];
		$commande->num_lot			= Sql_prepareTexteAffichage($row['num_lot']);
		$commande->etat				= $row['etat'];
		$commande->date_add			= $row['date_add'];
		$commande->date_upd			= $row['date_upd'];
		$commande->info_commande	= Sql_prepareTexteAffichage($row['info_commande']);
	}
	return $commande;
}

/**
Retourne un tableau de commandes correspondant aux champs du tableau en argument.
@param $args
*/
function Commandes_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."commande
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."commande
					WHERE 1";
	}

	if (!isset($args['id_commande']) && !isset($args['id_utilisateur']) && !isset($args['id_customer'])
		 && !isset($args['id_pg_vg']) && !isset($args['date_commande']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_commandes']))
		return $tab_result;

	$condition="";

	if (isset($args['id_commande']) && $args['id_commande'] != "*")
		$condition .= " AND id_commande = '".$args['id_commande']."' ";
	if (isset($args['id_utilisateur']) && $args['id_utilisateur'] != "*")
		$condition .= " AND id_utilisateur = '".$args['id_utilisateur']."' ";
	if (isset($args['id_customer']) && $args['id_customer'] != "*")
		$condition .= " AND id_customer = '".$args['id_customer']."' ";
	if (isset($args['id_pg_vg']) && $args['id_pg_vg'] != "*")
		$condition .= " AND id_pg_vg = '".$args['id_pg_vg']."' ";
	if (isset($args['date_commande']) && $args['date_commande'] != "*")
		$condition .= " AND date_commande = '".Lib_frToEn($args['date_commande'])."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_commandes']) && $args['tab_ids_commandes'] != "*") {
		$ids = implode(",", $args['tab_ids_commandes']);
		$condition .= " AND id_commande IN (0".$ids.") ";
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
				$id = $row['id_commande'];
				$tab_result[$id]["id_commande"]		= $id;
				$tab_result[$id]["id_utilisateur"]	= $row['id_utilisateur'];
				$tab_result[$id]["id_customer"]		= $row['id_customer'];
				$tab_result[$id]["id_pg_vg"]			= $row['id_pg_vg'];
				$tab_result[$id]["date_commande"]	= Lib_enToFr($row['date_commande']);
				$tab_result[$id]["nb_imp"]				= $row['nb_imp'];
				$tab_result[$id]["num_lot"]			= Sql_prepareTexteAffichage($row['num_lot']);
				$tab_result[$id]["etat"]				= $row['etat'];
				$tab_result[$id]["date_add"]			= $row['date_add'];
				$tab_result[$id]["date_upd"]			= $row['date_upd'];
				$tab_result[$id]["info_commande"]	= Sql_prepareTexteAffichage($row['info_commande']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_commande'] != '' && $args['id_commande'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__COMMANDE_INC__'))
?>