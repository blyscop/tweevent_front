<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_events
*/

/**
 * Classe pour la gestion de tweevent_events
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_event` (
	 `id_tweevent_event` INT(11) NOT NULL auto_increment,
	 `nom_tweevent_event` VARCHAR(255) NOT NULL,
	 `id_img_tweevent_event` INT(11) NOT NULL,
	 `id_img2_tweevent_event` INT(11) NOT NULL,
	 `ids_posts_tweevent_event` VARCHAR(255) NOT NULL,
	 `date_debut_tweevent_event` DATE NOT NULL,
	 `date_fin_tweevent_event` DATE NOT NULL,
	 `lieu_tweevent_event` VARCHAR(255) NOT NULL,
	 `infos_tweevent_event` TEXT NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_event` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_event`));

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
if (!defined('__TWEEVENT_EVENT_INC__')){
	define('__TWEEVENT_EVENT_INC__', 1);

class Tweevent_event extends Element {
	var $id_tweevent_event;
	var $nom_tweevent_event;
	var $id_img_tweevent_event;
	var $id_img2_tweevent_event;
	var $ids_posts_tweevent_event;
	var $date_debut_tweevent_event;
	var $date_fin_tweevent_event;
	var $lieu_tweevent_event;
	var $infos_tweevent_event;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_event;

/** 
Constructeur de la classe.
*/
function Tweevent_event()
{
	$this->type_moi = "tweevent_events";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_event.
*/
function getTab()
{
	$tab['id_tweevent_event']				= $this->id_tweevent_event;
	$tab['nom_tweevent_event']				= $this->nom_tweevent_event;
	$tab['id_img_tweevent_event']			= $this->id_img_tweevent_event;
	$tab['id_img2_tweevent_event']		= $this->id_img2_tweevent_event;
	$tab['ids_posts_tweevent_event']		= $this->ids_posts_tweevent_event;
	$tab['date_debut_tweevent_event']	= $this->date_debut_tweevent_event;
	$tab['date_fin_tweevent_event']		= $this->date_fin_tweevent_event;
	$tab['lieu_tweevent_event']			= $this->lieu_tweevent_event;
	$tab['infos_tweevent_event']			= $this->infos_tweevent_event;
	$tab['etat']								= $this->etat;
	$tab['date_add']							= $this->date_add;
	$tab['date_upd']							= $this->date_upd;
	$tab['info_tweevent_event']			= $this->info_tweevent_event;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_event à la BDD. 
*/
function ADD()
{
	$nom_tweevent_event 				= Sql_prepareTexteStockage($this->nom_tweevent_event);
	$id_img_tweevent_event 			= is_numeric($this->id_img_tweevent_event) ? $this->id_img_tweevent_event : 0;
	$id_img2_tweevent_event 		= is_numeric($this->id_img2_tweevent_event) ? $this->id_img2_tweevent_event : 0;
	$ids_posts_tweevent_event 		= Sql_prepareTexteStockage($this->ids_posts_tweevent_event);
	$date_debut_tweevent_event 	= Lib_frToEn($this->date_debut_tweevent_event);
	$date_fin_tweevent_event 		= Lib_frToEn($this->date_fin_tweevent_event);
	$lieu_tweevent_event 			= Sql_prepareTexteStockage($this->lieu_tweevent_event);
	$infos_tweevent_event 			= Sql_prepareTexteStockage($this->infos_tweevent_event);
	$etat 								= $this->etat != '' ? $this->etat : 'actif';
	$date_add 							= time();
	$info_tweevent_event 			= Sql_prepareTexteStockage($this->info_tweevent_event);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_event
					(nom_tweevent_event, id_img_tweevent_event, id_img2_tweevent_event, 
					ids_posts_tweevent_event, date_debut_tweevent_event, date_fin_tweevent_event, 
					lieu_tweevent_event, infos_tweevent_event, etat, 
					date_add, info_tweevent_event
					)
				VALUES 
					 ('$nom_tweevent_event', '$id_img_tweevent_event', '$id_img2_tweevent_event', 
					'$ids_posts_tweevent_event', '$date_debut_tweevent_event', '$date_fin_tweevent_event', 
					'$lieu_tweevent_event', '$infos_tweevent_event', '$etat', 
					'$date_add', '$info_tweevent_event'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_event = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_event");
		$this->id_tweevent_event = $this->id_tweevent_event;
		return $id_tweevent_event;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_event dans la BDD. 
*/
function UPD()
{
	$id_tweevent_event 				= is_numeric($this->id_tweevent_event) ? $this->id_tweevent_event : 0;
	$nom_tweevent_event 				= Sql_prepareTexteStockage($this->nom_tweevent_event);
	$id_img_tweevent_event 			= is_numeric($this->id_img_tweevent_event) ? $this->id_img_tweevent_event : 0;
	$id_img2_tweevent_event 		= is_numeric($this->id_img2_tweevent_event) ? $this->id_img2_tweevent_event : 0;
	$ids_posts_tweevent_event 		= Sql_prepareTexteStockage($this->ids_posts_tweevent_event);
	$date_debut_tweevent_event 	= Lib_frToEn($this->date_debut_tweevent_event);
	$date_fin_tweevent_event 		= Lib_frToEn($this->date_fin_tweevent_event);
	$lieu_tweevent_event 			= Sql_prepareTexteStockage($this->lieu_tweevent_event);
	$infos_tweevent_event 			= Sql_prepareTexteStockage($this->infos_tweevent_event);
	$etat 								= $this->etat;
	$date_upd 							= time();
	$info_tweevent_event 			= Sql_prepareTexteStockage($this->info_tweevent_event);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_event
				SET nom_tweevent_event = '$nom_tweevent_event', id_img_tweevent_event = '$id_img_tweevent_event', id_img2_tweevent_event = '$id_img2_tweevent_event', 
					ids_posts_tweevent_event = '$ids_posts_tweevent_event', date_debut_tweevent_event = '$date_debut_tweevent_event', date_fin_tweevent_event = '$date_fin_tweevent_event', 
					lieu_tweevent_event = '$lieu_tweevent_event', infos_tweevent_event = '$infos_tweevent_event', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_event = '$info_tweevent_event'
					
				WHERE id_tweevent_event = $id_tweevent_event";

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

	$id_tweevent_event = $this->id_tweevent_event;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_event
				WHERE id_tweevent_event = $id_tweevent_event";

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
	$str = Lib_addElem($str, $this->id_tweevent_event);
	$str = Lib_addElem($str, $this->nom_tweevent_event);
	$str = Lib_addElem($str, $this->id_img_tweevent_event);
	$str = Lib_addElem($str, $this->id_img2_tweevent_event);
	$str = Lib_addElem($str, $this->ids_posts_tweevent_event);
	$str = Lib_addElem($str, $this->date_debut_tweevent_event);
	$str = Lib_addElem($str, $this->date_fin_tweevent_event);
	$str = Lib_addElem($str, $this->lieu_tweevent_event);
	$str = Lib_addElem($str, $this->infos_tweevent_event);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_event);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_event suivant son identifiant
et retourne la coquille "Tweevent_event" remplie avec les informations récupérées
de la base.
@param id_tweevent_event.
*/
function Tweevent_event_recuperer($id_tweevent_event)
{
	$tweevent_event = new Tweevent_event();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_event
				WHERE id_tweevent_event = '$id_tweevent_event';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_event->id_tweevent_event				= $row['id_tweevent_event'];
		$tweevent_event->nom_tweevent_event				= Sql_prepareTexteAffichage($row['nom_tweevent_event']);
		$tweevent_event->id_img_tweevent_event			= $row['id_img_tweevent_event'];
		$tweevent_event->id_img2_tweevent_event		= $row['id_img2_tweevent_event'];
		$tweevent_event->ids_posts_tweevent_event		= Sql_prepareTexteAffichage($row['ids_posts_tweevent_event']);
		$tweevent_event->date_debut_tweevent_event	= Lib_enToFr($row['date_debut_tweevent_event']);
		$tweevent_event->date_fin_tweevent_event		= Lib_enToFr($row['date_fin_tweevent_event']);
		$tweevent_event->lieu_tweevent_event			= Sql_prepareTexteAffichage($row['lieu_tweevent_event']);
		$tweevent_event->infos_tweevent_event			= Sql_prepareTexteAffichage($row['infos_tweevent_event']);
		$tweevent_event->etat								= $row['etat'];
		$tweevent_event->date_add							= $row['date_add'];
		$tweevent_event->date_upd							= $row['date_upd'];
		$tweevent_event->info_tweevent_event			= Sql_prepareTexteAffichage($row['info_tweevent_event']);
	}
	return $tweevent_event;
}

/**
Retourne un tableau de tweevent_events correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_events_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_event
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_event
					WHERE 1";
	}

	if (!isset($args['id_tweevent_event']) && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_events']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_event']) && $args['id_tweevent_event'] != "*")
		$condition .= " AND id_tweevent_event = '".$args['id_tweevent_event']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_events']) && $args['tab_ids_tweevent_events'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_events']);
		$condition .= " AND id_tweevent_event IN (0".$ids.") ";
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
				$id = $row['id_tweevent_event'];
				$tab_result[$id]["id_tweevent_event"]				= $id;
				$tab_result[$id]["nom_tweevent_event"]				= Sql_prepareTexteAffichage($row['nom_tweevent_event']);
				$tab_result[$id]["id_img_tweevent_event"]			= $row['id_img_tweevent_event'];
				$tab_result[$id]["id_img2_tweevent_event"]		= $row['id_img2_tweevent_event'];
				$tab_result[$id]["ids_posts_tweevent_event"]		= Sql_prepareTexteAffichage($row['ids_posts_tweevent_event']);
				$tab_result[$id]["date_debut_tweevent_event"]	= Lib_enToFr($row['date_debut_tweevent_event']);
				$tab_result[$id]["date_fin_tweevent_event"]		= Lib_enToFr($row['date_fin_tweevent_event']);
				$tab_result[$id]["lieu_tweevent_event"]			= Sql_prepareTexteAffichage($row['lieu_tweevent_event']);
				$tab_result[$id]["infos_tweevent_event"]			= Sql_prepareTexteAffichage($row['infos_tweevent_event']);
				$tab_result[$id]["etat"]								= $row['etat'];
				$tab_result[$id]["date_add"]							= $row['date_add'];
				$tab_result[$id]["date_upd"]							= $row['date_upd'];
				$tab_result[$id]["info_tweevent_event"]			= Sql_prepareTexteAffichage($row['info_tweevent_event']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_event'] != '' && $args['id_tweevent_event'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_EVENT_INC__'))
?>