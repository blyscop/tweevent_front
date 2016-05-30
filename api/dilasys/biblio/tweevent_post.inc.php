<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_posts
*/

/**
 * Classe pour la gestion de tweevent_posts
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_post` (
	 `id_tweevent_post` INT(11) NOT NULL auto_increment,
	 `id_user_tweevent_post` INT(11) NOT NULL,
	 `ids_imgs_tweevent_post` VARCHAR(255) NOT NULL,
	 `date_heure_tweevent_post` VARCHAR(255) NOT NULL,
	 `message_tweevent_post` TEXT NOT NULL,
	 `lieu_tweevent_post` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_post` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_post`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_user_tweevent_post
// Clef de recherche 2 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_POST_INC__')){
	define('__TWEEVENT_POST_INC__', 1);

class Tweevent_post extends Element {
	var $id_tweevent_post;
	var $id_user_tweevent_post;
	var $ids_imgs_tweevent_post;
	var $date_heure_tweevent_post;
	var $message_tweevent_post;
	var $lieu_tweevent_post;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_post;

/** 
Constructeur de la classe.
*/
function Tweevent_post()
{
	$this->type_moi = "tweevent_posts";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Tweevent_post.
*/
function getTab()
{
	$tab['id_tweevent_post']			= $this->id_tweevent_post;
	$tab['id_user_tweevent_post']		= $this->id_user_tweevent_post;
	$tab['ids_imgs_tweevent_post']	= $this->ids_imgs_tweevent_post;
	$tab['date_heure_tweevent_post']	= $this->date_heure_tweevent_post;
	$tab['message_tweevent_post']		= $this->message_tweevent_post;
	$tab['lieu_tweevent_post']			= $this->lieu_tweevent_post;
	$tab['etat']							= $this->etat;
	$tab['date_add']						= $this->date_add;
	$tab['date_upd']						= $this->date_upd;
	$tab['info_tweevent_post']			= $this->info_tweevent_post;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_post à la BDD. 
*/
function ADD()
{
	$id_user_tweevent_post 		= is_numeric($this->id_user_tweevent_post) ? $this->id_user_tweevent_post : 0;
	$ids_imgs_tweevent_post 	= Sql_prepareTexteStockage($this->ids_imgs_tweevent_post);
	$date_heure_tweevent_post 	= Sql_prepareTexteStockage($this->date_heure_tweevent_post);
	$message_tweevent_post 		= Sql_prepareTexteStockage($this->message_tweevent_post);
	$lieu_tweevent_post 			= Sql_prepareTexteStockage($this->lieu_tweevent_post);
	$etat 							= $this->etat != '' ? $this->etat : 'actif';
	$date_add 						= time();
	$info_tweevent_post 			= Sql_prepareTexteStockage($this->info_tweevent_post);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_post
					(id_user_tweevent_post, ids_imgs_tweevent_post, date_heure_tweevent_post, 
					message_tweevent_post, lieu_tweevent_post, etat, 
					date_add, info_tweevent_post
					)
				VALUES 
					 ('$id_user_tweevent_post', '$ids_imgs_tweevent_post', '$date_heure_tweevent_post', 
					'$message_tweevent_post', '$lieu_tweevent_post', '$etat', 
					'$date_add', '$info_tweevent_post'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_post = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_post");
		$this->id_tweevent_post = $this->id_tweevent_post;
		return $id_tweevent_post;
	}
	return;
}

/**
Cette fonction modifie un élément de la table tweevent_post dans la BDD. 
*/
function UPD()
{
	$id_tweevent_post 			= is_numeric($this->id_tweevent_post) ? $this->id_tweevent_post : 0;
	$id_user_tweevent_post 		= is_numeric($this->id_user_tweevent_post) ? $this->id_user_tweevent_post : 0;
	$ids_imgs_tweevent_post 	= Sql_prepareTexteStockage($this->ids_imgs_tweevent_post);
	$date_heure_tweevent_post 	= Sql_prepareTexteStockage($this->date_heure_tweevent_post);
	$message_tweevent_post 		= Sql_prepareTexteStockage($this->message_tweevent_post);
	$lieu_tweevent_post 			= Sql_prepareTexteStockage($this->lieu_tweevent_post);
	$etat 							= $this->etat;
	$date_upd 						= time();
	$info_tweevent_post 			= Sql_prepareTexteStockage($this->info_tweevent_post);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_post
				SET id_user_tweevent_post = '$id_user_tweevent_post', ids_imgs_tweevent_post = '$ids_imgs_tweevent_post', date_heure_tweevent_post = '$date_heure_tweevent_post', 
					message_tweevent_post = '$message_tweevent_post', lieu_tweevent_post = '$lieu_tweevent_post', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_post = '$info_tweevent_post'
					
				WHERE id_tweevent_post = $id_tweevent_post";

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

	$id_tweevent_post = $this->id_tweevent_post;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_post
				WHERE id_tweevent_post = $id_tweevent_post";

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
	$str = Lib_addElem($str, $this->id_tweevent_post);
	$str = Lib_addElem($str, $this->id_user_tweevent_post);
	$str = Lib_addElem($str, $this->ids_imgs_tweevent_post);
	$str = Lib_addElem($str, $this->date_heure_tweevent_post);
	$str = Lib_addElem($str, $this->message_tweevent_post);
	$str = Lib_addElem($str, $this->lieu_tweevent_post);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_post);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un tweevent_post suivant son identifiant
et retourne la coquille "Tweevent_post" remplie avec les informations récupérées
de la base.
@param id_tweevent_post.
*/
function Tweevent_post_recuperer($id_tweevent_post)
{
	$tweevent_post = new Tweevent_post();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_post
				WHERE id_tweevent_post = '$id_tweevent_post';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_post->id_tweevent_post			= $row['id_tweevent_post'];
		$tweevent_post->id_user_tweevent_post		= $row['id_user_tweevent_post'];
		$tweevent_post->ids_imgs_tweevent_post	= Sql_prepareTexteAffichage($row['ids_imgs_tweevent_post']);
		$tweevent_post->date_heure_tweevent_post	= Sql_prepareTexteAffichage($row['date_heure_tweevent_post']);
		$tweevent_post->message_tweevent_post		= Sql_prepareTexteAffichage($row['message_tweevent_post']);
		$tweevent_post->lieu_tweevent_post			= Sql_prepareTexteAffichage($row['lieu_tweevent_post']);
		$tweevent_post->etat							= $row['etat'];
		$tweevent_post->date_add						= $row['date_add'];
		$tweevent_post->date_upd						= $row['date_upd'];
		$tweevent_post->info_tweevent_post			= Sql_prepareTexteAffichage($row['info_tweevent_post']);
	}
	return $tweevent_post;
}

/**
Retourne un tableau de tweevent_posts correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_posts_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_post
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_post
					WHERE 1";
	}

	if (!isset($args['id_tweevent_post']) && !isset($args['id_user_tweevent_post']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_posts']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_post']) && $args['id_tweevent_post'] != "*")
		$condition .= " AND id_tweevent_post = '".$args['id_tweevent_post']."' ";
	if (isset($args['id_user_tweevent_post']) && $args['id_user_tweevent_post'] != "*")
		$condition .= " AND id_user_tweevent_post = '".$args['id_user_tweevent_post']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_posts']) && $args['tab_ids_tweevent_posts'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_posts']);
		$condition .= " AND id_tweevent_post IN (0".$ids.") ";
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
				$id = $row['id_tweevent_post'];
				$tab_result[$id]["id_tweevent_post"]			= $id;
				$tab_result[$id]["id_user_tweevent_post"]		= $row['id_user_tweevent_post'];
				$tab_result[$id]["ids_imgs_tweevent_post"]	= Sql_prepareTexteAffichage($row['ids_imgs_tweevent_post']);
				$tab_result[$id]["date_heure_tweevent_post"]	= Sql_prepareTexteAffichage($row['date_heure_tweevent_post']);
				$tab_result[$id]["message_tweevent_post"]		= Sql_prepareTexteAffichage($row['message_tweevent_post']);
				$tab_result[$id]["lieu_tweevent_post"]			= Sql_prepareTexteAffichage($row['lieu_tweevent_post']);
				$tab_result[$id]["etat"]							= $row['etat'];
				$tab_result[$id]["date_add"]						= $row['date_add'];
				$tab_result[$id]["date_upd"]						= $row['date_upd'];
				$tab_result[$id]["info_tweevent_post"]			= Sql_prepareTexteAffichage($row['info_tweevent_post']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_post'] != '' && $args['id_tweevent_post'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_POST_INC__'))
?>