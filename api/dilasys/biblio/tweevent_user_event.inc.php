<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_user_events
*/

/**
 * Classe pour la gestion de tweevent_user_events
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_user_event` (
	 `id_tweevent_user_event` INT(11) NOT NULL auto_increment,
	 `id_tweevent_event` INT(11) NOT NULL,
	 `id_tweevent_user` INT(11) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_user_event` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_user_event`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_tweevent_event
// Clef de recherche 2 : id_tweevent_user
// Clef de recherche 3 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_USER_EVENT_INC__')){
	define('__TWEEVENT_USER_EVENT_INC__', 1);

class Tweevent_user_event extends Element {
	var $id_tweevent_user_event;
	var $id_tweevent_event;
	var $id_tweevent_user;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_user_event;

/** 
Constructeur de la classe.
*/
function Tweevent_user_event()
{
	$this->type_moi = "tweevent_user_events";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_user_event.
*/
function getTab()
{
	$tab['id_tweevent_user_event']	= $this->id_tweevent_user_event;
	$tab['id_tweevent_event']			= $this->id_tweevent_event;
	$tab['id_tweevent_user']			= $this->id_tweevent_user;
	$tab['etat']							= $this->etat;
	$tab['date_add']						= $this->date_add;
	$tab['date_upd']						= $this->date_upd;
	$tab['info_tweevent_user_event']	= $this->info_tweevent_user_event;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_user_event à la BDD. 
*/
function ADD()
{
	$id_tweevent_event 			= is_numeric($this->id_tweevent_event) ? $this->id_tweevent_event : 0;
	$id_tweevent_user 			= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$etat 							= $this->etat != '' ? $this->etat : 'actif';
	$date_add 						= time();
	$info_tweevent_user_event 	= Sql_prepareTexteStockage($this->info_tweevent_user_event);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_user_event
					(id_tweevent_event, id_tweevent_user, etat, 
					date_add, info_tweevent_user_event
					)
				VALUES 
					 ('$id_tweevent_event', '$id_tweevent_user', '$etat', 
					'$date_add', '$info_tweevent_user_event'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_user_event = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_user_event");
		$this->id_tweevent_user_event = $this->id_tweevent_user_event;
		return $id_tweevent_user_event;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_user_event dans la BDD. 
*/
function UPD()
{
	$id_tweevent_user_event 	= is_numeric($this->id_tweevent_user_event) ? $this->id_tweevent_user_event : 0;
	$id_tweevent_event 			= is_numeric($this->id_tweevent_event) ? $this->id_tweevent_event : 0;
	$id_tweevent_user 			= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$etat 							= $this->etat;
	$date_upd 						= time();
	$info_tweevent_user_event 	= Sql_prepareTexteStockage($this->info_tweevent_user_event);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_user_event
				SET id_tweevent_event = '$id_tweevent_event', id_tweevent_user = '$id_tweevent_user', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_user_event = '$info_tweevent_user_event'
					
				WHERE id_tweevent_user_event = $id_tweevent_user_event";

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

	$id_tweevent_user_event = $this->id_tweevent_user_event;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_user_event
				WHERE id_tweevent_user_event = $id_tweevent_user_event";

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
	$str = Lib_addElem($str, $this->id_tweevent_user_event);
	$str = Lib_addElem($str, $this->id_tweevent_event);
	$str = Lib_addElem($str, $this->id_tweevent_user);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_user_event);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_user_event suivant son identifiant
et retourne la coquille "Tweevent_user_event" remplie avec les informations récupérées
de la base.
@param id_tweevent_user_event.
*/
function Tweevent_user_event_recuperer($id_tweevent_user_event)
{
	$tweevent_user_event = new Tweevent_user_event();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_user_event
				WHERE id_tweevent_user_event = '$id_tweevent_user_event';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_user_event->id_tweevent_user_event	= $row['id_tweevent_user_event'];
		$tweevent_user_event->id_tweevent_event			= $row['id_tweevent_event'];
		$tweevent_user_event->id_tweevent_user			= $row['id_tweevent_user'];
		$tweevent_user_event->etat							= $row['etat'];
		$tweevent_user_event->date_add						= $row['date_add'];
		$tweevent_user_event->date_upd						= $row['date_upd'];
		$tweevent_user_event->info_tweevent_user_event	= Sql_prepareTexteAffichage($row['info_tweevent_user_event']);
	}
	return $tweevent_user_event;
}

/**
Retourne un tableau de tweevent_user_events correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_user_events_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_user_event
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_user_event
					WHERE 1";
	}

	if (!isset($args['id_tweevent_user_event']) && !isset($args['id_tweevent_event']) && !isset($args['id_tweevent_user'])
		 && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_user_events']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_user_event']) && $args['id_tweevent_user_event'] != "*")
		$condition .= " AND id_tweevent_user_event = '".$args['id_tweevent_user_event']."' ";
	if (isset($args['id_tweevent_event']) && $args['id_tweevent_event'] != "*")
		$condition .= " AND id_tweevent_event = '".$args['id_tweevent_event']."' ";
	if (isset($args['id_tweevent_user']) && $args['id_tweevent_user'] != "*")
		$condition .= " AND id_tweevent_user = '".$args['id_tweevent_user']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_user_events']) && $args['tab_ids_tweevent_user_events'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_user_events']);
		$condition .= " AND id_tweevent_user_event IN (0".$ids.") ";
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
				$id = $row['id_tweevent_user_event'];
				$tab_result[$id]["id_tweevent_user_event"]	= $id;
				$tab_result[$id]["id_tweevent_event"]			= $row['id_tweevent_event'];
				$tab_result[$id]["id_tweevent_user"]			= $row['id_tweevent_user'];
				$tab_result[$id]["etat"]							= $row['etat'];
				$tab_result[$id]["date_add"]						= $row['date_add'];
				$tab_result[$id]["date_upd"]						= $row['date_upd'];
				$tab_result[$id]["info_tweevent_user_event"]	= Sql_prepareTexteAffichage($row['info_tweevent_user_event']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_user_event'] != '' && $args['id_tweevent_user_event'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_USER_EVENT_INC__'))
?>