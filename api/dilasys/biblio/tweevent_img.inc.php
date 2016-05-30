<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_imgs
*/

/**
 * Classe pour la gestion de tweevent_imgs
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_img` (
	 `id_tweevent_img` INT(11) NOT NULL auto_increment,
	 `id_user_tweevent_img` INT(11) NOT NULL,
	 `nom_tweevent_img` VARCHAR(255) NOT NULL,
	 `date_tweevent_img` DATE NOT NULL,
	 `url_tweevent_img` VARCHAR(255) NOT NULL,
	 `alt_tweevent_img` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_img` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_img`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_user_tweevent_img
// Clef de recherche 2 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_IMG_INC__')){
	define('__TWEEVENT_IMG_INC__', 1);

class Tweevent_img extends Element {
	var $id_tweevent_img;
	var $id_user_tweevent_img;
	var $nom_tweevent_img;
	var $date_tweevent_img;
	var $url_tweevent_img;
	var $alt_tweevent_img;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_img;

/** 
Constructeur de la classe.
*/
function Tweevent_img()
{
	$this->type_moi = "tweevent_imgs";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_img.
*/
function getTab()
{
	$tab['id_tweevent_img']			= $this->id_tweevent_img;
	$tab['id_user_tweevent_img']	= $this->id_user_tweevent_img;
	$tab['nom_tweevent_img']		= $this->nom_tweevent_img;
	$tab['date_tweevent_img']		= $this->date_tweevent_img;
	$tab['url_tweevent_img']		= $this->url_tweevent_img;
	$tab['alt_tweevent_img']		= $this->alt_tweevent_img;
	$tab['etat']						= $this->etat;
	$tab['date_add']					= $this->date_add;
	$tab['date_upd']					= $this->date_upd;
	$tab['info_tweevent_img']		= $this->info_tweevent_img;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_img à la BDD. 
*/
function ADD()
{
	$id_user_tweevent_img 	= is_numeric($this->id_user_tweevent_img) ? $this->id_user_tweevent_img : 0;
	$nom_tweevent_img 		= Sql_prepareTexteStockage($this->nom_tweevent_img);
	$date_tweevent_img 		= Lib_frToEn($this->date_tweevent_img);
	$url_tweevent_img 		= Sql_prepareTexteStockage($this->url_tweevent_img);
	$alt_tweevent_img 		= Sql_prepareTexteStockage($this->alt_tweevent_img);
	$etat 						= $this->etat != '' ? $this->etat : 'actif';
	$date_add 					= time();
	$info_tweevent_img 		= Sql_prepareTexteStockage($this->info_tweevent_img);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_img
					(id_user_tweevent_img, nom_tweevent_img, date_tweevent_img, 
					url_tweevent_img, alt_tweevent_img, etat, 
					date_add, info_tweevent_img
					)
				VALUES 
					 ('$id_user_tweevent_img', '$nom_tweevent_img', '$date_tweevent_img', 
					'$url_tweevent_img', '$alt_tweevent_img', '$etat', 
					'$date_add', '$info_tweevent_img'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_img = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_img");
		$this->id_tweevent_img = $this->id_tweevent_img;
		return $id_tweevent_img;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_img dans la BDD. 
*/
function UPD()
{
	$id_tweevent_img 			= is_numeric($this->id_tweevent_img) ? $this->id_tweevent_img : 0;
	$id_user_tweevent_img 	= is_numeric($this->id_user_tweevent_img) ? $this->id_user_tweevent_img : 0;
	$nom_tweevent_img 		= Sql_prepareTexteStockage($this->nom_tweevent_img);
	$date_tweevent_img 		= Lib_frToEn($this->date_tweevent_img);
	$url_tweevent_img 		= Sql_prepareTexteStockage($this->url_tweevent_img);
	$alt_tweevent_img 		= Sql_prepareTexteStockage($this->alt_tweevent_img);
	$etat 						= $this->etat;
	$date_upd 					= time();
	$info_tweevent_img 		= Sql_prepareTexteStockage($this->info_tweevent_img);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_img
				SET id_user_tweevent_img = '$id_user_tweevent_img', nom_tweevent_img = '$nom_tweevent_img', date_tweevent_img = '$date_tweevent_img', 
					url_tweevent_img = '$url_tweevent_img', alt_tweevent_img = '$alt_tweevent_img', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_img = '$info_tweevent_img'
					
				WHERE id_tweevent_img = $id_tweevent_img";

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

	$id_tweevent_img = $this->id_tweevent_img;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_img
				WHERE id_tweevent_img = $id_tweevent_img";

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
	$str = Lib_addElem($str, $this->id_tweevent_img);
	$str = Lib_addElem($str, $this->id_user_tweevent_img);
	$str = Lib_addElem($str, $this->nom_tweevent_img);
	$str = Lib_addElem($str, $this->date_tweevent_img);
	$str = Lib_addElem($str, $this->url_tweevent_img);
	$str = Lib_addElem($str, $this->alt_tweevent_img);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_img);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_img suivant son identifiant
et retourne la coquille "Tweevent_img" remplie avec les informations récupérées
de la base.
@param id_tweevent_img.
*/
function Tweevent_img_recuperer($id_tweevent_img)
{
	$tweevent_img = new Tweevent_img();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_img
				WHERE id_tweevent_img = '$id_tweevent_img';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_img->id_tweevent_img			= $row['id_tweevent_img'];
		$tweevent_img->id_user_tweevent_img	= $row['id_user_tweevent_img'];
		$tweevent_img->nom_tweevent_img		= Sql_prepareTexteAffichage($row['nom_tweevent_img']);
		$tweevent_img->date_tweevent_img		= Lib_enToFr($row['date_tweevent_img']);
		$tweevent_img->url_tweevent_img		= Sql_prepareTexteAffichage($row['url_tweevent_img']);
		$tweevent_img->alt_tweevent_img		= Sql_prepareTexteAffichage($row['alt_tweevent_img']);
		$tweevent_img->etat						= $row['etat'];
		$tweevent_img->date_add					= $row['date_add'];
		$tweevent_img->date_upd					= $row['date_upd'];
		$tweevent_img->info_tweevent_img		= Sql_prepareTexteAffichage($row['info_tweevent_img']);
	}
	return $tweevent_img;
}

/**
Retourne un tableau de tweevent_imgs correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_imgs_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_img
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_img
					WHERE 1";
	}

	if (!isset($args['id_tweevent_img']) && !isset($args['id_user_tweevent_img']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_imgs']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_img']) && $args['id_tweevent_img'] != "*")
		$condition .= " AND id_tweevent_img = '".$args['id_tweevent_img']."' ";
	if (isset($args['id_user_tweevent_img']) && $args['id_user_tweevent_img'] != "*")
		$condition .= " AND id_user_tweevent_img = '".$args['id_user_tweevent_img']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_imgs']) && $args['tab_ids_tweevent_imgs'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_imgs']);
		$condition .= " AND id_tweevent_img IN (0".$ids.") ";
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
				$id = $row['id_tweevent_img'];
				$tab_result[$id]["id_tweevent_img"]			= $id;
				$tab_result[$id]["id_user_tweevent_img"]	= $row['id_user_tweevent_img'];
				$tab_result[$id]["nom_tweevent_img"]		= Sql_prepareTexteAffichage($row['nom_tweevent_img']);
				$tab_result[$id]["date_tweevent_img"]		= Lib_enToFr($row['date_tweevent_img']);
				$tab_result[$id]["url_tweevent_img"]		= Sql_prepareTexteAffichage($row['url_tweevent_img']);
				$tab_result[$id]["alt_tweevent_img"]		= Sql_prepareTexteAffichage($row['alt_tweevent_img']);
				$tab_result[$id]["etat"]						= $row['etat'];
				$tab_result[$id]["date_add"]					= $row['date_add'];
				$tab_result[$id]["date_upd"]					= $row['date_upd'];
				$tab_result[$id]["info_tweevent_img"]		= Sql_prepareTexteAffichage($row['info_tweevent_img']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_img'] != '' && $args['id_tweevent_img'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_IMG_INC__'))
?>