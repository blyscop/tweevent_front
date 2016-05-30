<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in News
*/

/**
 * Classe pour la gestion de news
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `cms_new` (
  `id_new` int(11) NOT NULL auto_increment,
  `code_news` varchar(255) NOT NULL default '',
  `code` int(11) NOT NULL default '0',
  `lang` varchar(64) NOT NULL default '',
  `etat` varchar(64) NOT NULL default '',
  `position` int(11) NOT NULL default '0',
  `titre` varchar(255) NOT NULL default '',
  `contenu` text NOT NULL,
  `texte_intro` text NOT NULL,
  `image_intro` varchar(255) NOT NULL,
  `date` varchar(64) NOT NULL default '',
  `titre_data1` varchar(255) NOT NULL,
  `data1` text NOT NULL,
  `titre_data2` varchar(255) NOT NULL,
  `data2` text NOT NULL,
  `titre_data3` varchar(255) NOT NULL,
  `data3` text NOT NULL,
  `titre_data4` varchar(255) NOT NULL,
  `data4` text NOT NULL,
  `titre_data5` varchar(255) NOT NULL,
  `data5` text NOT NULL,
  `titre_data6` varchar(255) NOT NULL,
  `data6` text NOT NULL,
  `url_image` varchar(255) NOT NULL default '',
  `url_image2` varchar(255) NOT NULL,
  `date_add` varchar(255) NOT NULL default '',
  `date_upd` varchar(255) NOT NULL default '',
  `info_new` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_new`)
) TYPE=MyISAM;
 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : code_news
// Clef de recherche 2 : code
// Clef de recherche 3 : lang
// Clef de recherche 4 : etat
// Clef de recherche 5 : position

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__NEW_INC__')){
	define('__NEW_INC__', 1);

class News extends Element {
	var $id_new;
	var $code_news;
	var $code;
	var $lang;
	var $etat;
	var $position;
	var $meta_titre;
	var $meta_description;
	var $meta_mots_clefs;
	var $meta_url;
	var $titre;
	var $contenu;
	var $texte_intro;
	var $image_intro;
	var $date;
	var $titre_data1;
	var $data1;
	var $titre_data2;
	var $data2;
	var $titre_data3;
	var $data3;
	var $titre_data4;
	var $data4;
	var $titre_data5;
	var $data5;
	var $titre_data6;
	var $data6;
	var $url_image;
	var $url_image2;
	var $date_add;
	var $date_upd;
	var $info_new;

/** 
Constructeur de la classe.
*/
function News()
{
	$this->type_moi = "news";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de New.
*/
function getTab()
{
	$tab['id_new']		= $this->id_new;
	$tab['code_news']	= $this->code_news;
	$tab['code']		= $this->code;
	$tab['lang']		= $this->lang;
	$tab['etat']		= $this->etat;
	$tab['position']	= $this->position;
	$tab['meta_titre']		= $this->meta_titre;
	$tab['meta_description']= $this->meta_description;
	$tab['meta_mots_clefs']	= $this->meta_mots_clefs;
	$tab['meta_url']			= $this->meta_url;
	$tab['titre']		= $this->titre;
	$tab['contenu']	= $this->contenu;
	$tab['texte_intro']	= $this->texte_intro;
	$tab['image_intro']	= $this->image_intro;
	$tab['date']		= $this->date;
	$tab['titre_data1']	= $this->titre_data1;
	$tab['data1']		= $this->data1;
	$tab['titre_data2']	= $this->titre_data2;
	$tab['data2']		= $this->data2;
	$tab['titre_data3']	= $this->titre_data3;
	$tab['data3']		= $this->data3;
	$tab['titre_data4']	= $this->titre_data4;
	$tab['data4']		= $this->data4;
	$tab['titre_data5']	= $this->titre_data5;
	$tab['data5']		= $this->data5;
	$tab['titre_data6']	= $this->titre_data6;
	$tab['data6']		= $this->data6;
	$tab['url_image']	= $this->url_image;
	$tab['url_image2']	= $this->url_image2;
	$tab['date_add']	= $this->date_add;
	$tab['date_upd']	= $this->date_upd;
	$tab['info_new']	= $this->info_new;
	return $tab;
}

/**
Cette fonction ajoute un element de la table new à la BDD. 
*/
function ADD()
{
	$code_news 	= Sql_prepareTexteStockage($this->code_news);
	$code 		= $this->code;
	$lang 		= Sql_prepareTexteStockage($this->lang);
	$etat 		= Sql_prepareTexteStockage($this->etat);
	$position 	= $this->position;
	$meta_titre			= Sql_prepareTexteStockage($this->meta_titre);
	$meta_description = Sql_prepareTexteStockage($this->meta_description);
	$meta_mots_clefs	= Sql_prepareTexteStockage($this->meta_mots_clefs);
	$meta_url			= Sql_prepareTexteStockage($this->meta_url);
	$titre 		= Sql_prepareTexteStockage($this->titre);
	$contenu 	= Sql_prepareTexteStockage($this->contenu);
	$texte_intro = Sql_prepareTexteStockage($this->texte_intro);
	$image_intro = Sql_prepareTexteStockage($this->image_intro);
	$date 		= Sql_prepareTexteStockage($this->date);
	$url_image 	= Sql_prepareTexteStockage($this->url_image);
	$url_image2 	= Sql_prepareTexteStockage($this->url_image2);
	$date_add 	= time();
	$titre_data1	= Sql_prepareTexteStockage($this->titre_data1);
	$data1		= Sql_prepareTexteStockage($this->data1);
	$titre_data2	= Sql_prepareTexteStockage($this->titre_data2);
	$data2		= Sql_prepareTexteStockage($this->data2);
	$titre_data3	= Sql_prepareTexteStockage($this->titre_data3);
	$data3		= Sql_prepareTexteStockage($this->data3);
	$titre_data4	= Sql_prepareTexteStockage($this->titre_data4);
	$data4		= Sql_prepareTexteStockage($this->data4);
	$titre_data5	= Sql_prepareTexteStockage($this->titre_data5);
	$data5		= Sql_prepareTexteStockage($this->data5);
	$titre_data6	= Sql_prepareTexteStockage($this->titre_data6);
	$data6		= Sql_prepareTexteStockage($this->data6);
	$info_new 	= Sql_prepareTexteStockage($this->info_new);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."new
					(code_news, code, lang, 
					etat, position, meta_titre, meta_description, meta_mots_clefs, meta_url, titre, 
					contenu, texte_intro, image_intro, date, url_image, url_image2, 
					date_add, info_new, titre_data1, data1, titre_data2, data2, titre_data3, data3, 
					titre_data4, data4, titre_data5, data5, titre_data6, data6
					)
				VALUES 
					 ('$code_news', '$code', '$lang', 
					'$etat', '$position', '$meta_titre','$meta_description', '$meta_mots_clefs', '$meta_url', '$titre', 
					'$contenu', '$texte_intro', '$image_intro', '$date', '$url_image', '$url_image2', 
					'$date_add', '$info_new', '$titre_data1', '$data1', '$titre_data2', '$data2', 
					'$titre_data3', '$data3', '$titre_data4', '$data4', '$titre_data5', '$data5', '$titre_data6', '$data6'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_new = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_new");
		$this->id_new = $this->id_new;
		return $id_new;
	}
	return;
}

/**
Cette fonction modifie un élément de la table new dans la BDD. 
*/
function UPD()
{
	$id_new 	= $this->id_new;
	$code_news 	= Sql_prepareTexteStockage($this->code_news);
	$code 	= $this->code;
	$lang 		= Sql_prepareTexteStockage($this->lang);
	$etat 		= Sql_prepareTexteStockage($this->etat);
	$position 	= $this->position;
	$meta_titre			= Sql_prepareTexteStockage($this->meta_titre);
	$meta_description	= Sql_prepareTexteStockage($this->meta_description);
	$meta_mots_clefs	= Sql_prepareTexteStockage($this->meta_mots_clefs);
	$meta_url			= Sql_prepareTexteStockage($this->meta_url);
	$titre 		= Sql_prepareTexteStockage($this->titre);
	$contenu 	= Sql_prepareTexteStockage($this->contenu);
	$texte_intro 	= Sql_prepareTexteStockage($this->texte_intro);
	$image_intro 	= Sql_prepareTexteStockage($this->image_intro);
	$date 		= Sql_prepareTexteStockage($this->date);
	$url_image 	= Sql_prepareTexteStockage($this->url_image);
	$url_image2 	= Sql_prepareTexteStockage($this->url_image2);
	$date_upd 	= time();
	$titre_data1	= Sql_prepareTexteStockage($this->titre_data1);
	$data1		= Sql_prepareTexteStockage($this->data1);
	$titre_data2	= Sql_prepareTexteStockage($this->titre_data2);
	$data2		= Sql_prepareTexteStockage($this->data2);
	$titre_data3	= Sql_prepareTexteStockage($this->titre_data3);
	$data3		= Sql_prepareTexteStockage($this->data3);
	$titre_data4	= Sql_prepareTexteStockage($this->titre_data4);
	$data4		= Sql_prepareTexteStockage($this->data4);
	$titre_data5	= Sql_prepareTexteStockage($this->titre_data5);
	$data5		= Sql_prepareTexteStockage($this->data5);
	$titre_data6	= Sql_prepareTexteStockage($this->titre_data6);
	$data6		= Sql_prepareTexteStockage($this->data6);
	$info_new 	= Sql_prepareTexteStockage($this->info_new);

	$sql = " UPDATE ".$GLOBALS['prefix']."new
				SET code_news = '$code_news', code = '$code', lang = '$lang', etat = '$etat', position = '$position', 
					meta_titre = '$meta_titre', meta_description = '$meta_description', meta_mots_clefs = '$meta_mots_clefs', meta_url = '$meta_url', titre = '$titre', 
					contenu = '$contenu', texte_intro = '$texte_intro', image_intro = '$image_intro', date = '$date', url_image = '$url_image', 
					url_image2 = '$url_image2', 
					date_upd = '$date_upd', info_new = '$info_new', 
					titre_data1 = '$titre_data1', data1 = '$data1', 
					titre_data2 = '$titre_data2', data2 = '$data2', 
					titre_data3 = '$titre_data3', data3 = '$data3', 
					titre_data4 = '$titre_data4', data4 = '$data4', 
					titre_data5 = '$titre_data5', data5 = '$data5', 
					titre_data6 = '$titre_data6', data6 = '$data6'
				WHERE id_new = $id_new";

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

	$id_new = $this->id_new;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."new
				WHERE id_new = $id_new";

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
	$str = Lib_addElem($str, $this->id_new);
	$str = Lib_addElem($str, $this->code_news);
	$str = Lib_addElem($str, $this->code);
	$str = Lib_addElem($str, $this->lang);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->position);
	$str = Lib_addElem($str, $this->meta_titre);
	$str = Lib_addElem($str, $this->meta_description);
	$str = Lib_addElem($str, $this->meta_mots_clefs);
	$str = Lib_addElem($str, $this->meta_url);
	$str = Lib_addElem($str, $this->titre);
	$str = Lib_addElem($str, $this->contenu);
	$str = Lib_addElem($str, $this->texte_intro);
	$str = Lib_addElem($str, $this->image_intro);
	$str = Lib_addElem($str, $this->date);
	$str = Lib_addElem($str, $this->titre_data1);
	$str = Lib_addElem($str, $this->data1);
	$str = Lib_addElem($str, $this->titre_data2);
	$str = Lib_addElem($str, $this->data2);
	$str = Lib_addElem($str, $this->titre_data3);
	$str = Lib_addElem($str, $this->data3);
	$str = Lib_addElem($str, $this->titre_data4);
	$str = Lib_addElem($str, $this->data4);
	$str = Lib_addElem($str, $this->titre_data5);
	$str = Lib_addElem($str, $this->data5);
	$str = Lib_addElem($str, $this->titre_data6);
	$str = Lib_addElem($str, $this->data6);
	$str = Lib_addElem($str, $this->url_image);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_new);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un new suivant son identifiant
et retourne la coquille "New" remplie avec les informations récupérées
de la base.
@param id_new.
*/
function News_recuperer($id_new)
{
	$new = new News();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."new
				WHERE id_new = '$id_new';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$new->id_new		= $row['id_new'];
		$new->code_news	= Sql_prepareTexteAffichage($row['code_news']);
		$new->code	= $row['code'];
		$new->lang		= Sql_prepareTexteAffichage($row['lang']);
		$new->etat		= Sql_prepareTexteAffichage($row['etat']);
		$new->position	= $row['position'];
		$new->titre		= Sql_prepareTexteAffichage($row['titre']);
		$new->meta_titre			= Sql_prepareTexteAffichage($row['meta_titre']);
		$new->meta_description	= Sql_prepareTexteAffichage($row['meta_description']);
		$new->meta_mots_clefs	= Sql_prepareTexteAffichage($row['meta_mots_clefs']);
		$new->meta_url			= Sql_prepareTexteAffichage($row['meta_url']);
		$new->contenu	= Sql_prepareTexteAffichage($row['contenu']);
		$new->texte_intro	= Sql_prepareTexteAffichage($row['texte_intro']);
		$new->image_intro	= Sql_prepareTexteAffichage($row['image_intro']);
		$new->date		= Sql_prepareTexteAffichage($row['date']);
		$new->titre_data1	= Sql_prepareTexteAffichage($row['titre_data1']);
		$new->data1		= Sql_prepareTexteAffichage($row['data1']);
		$new->titre_data2	= Sql_prepareTexteAffichage($row['titre_data2']);
		$new->data2		= Sql_prepareTexteAffichage($row['data2']);
		$new->titre_data3	= Sql_prepareTexteAffichage($row['titre_data3']);
		$new->data3		= Sql_prepareTexteAffichage($row['data3']);
		$new->titre_data4	= Sql_prepareTexteAffichage($row['titre_data4']);
		$new->data4		= Sql_prepareTexteAffichage($row['data4']);
		$new->titre_data5	= Sql_prepareTexteAffichage($row['titre_data5']);
		$new->data5		= Sql_prepareTexteAffichage($row['data5']);
		$new->titre_data6	= Sql_prepareTexteAffichage($row['titre_data6']);
		$new->data6		= Sql_prepareTexteAffichage($row['data6']);
		$new->url_image	= Sql_prepareTexteAffichage($row['url_image']);
		$new->url_image2	= Sql_prepareTexteAffichage($row['url_image2']);
		$new->date_add	= Sql_prepareTexteAffichage($row['date_add']);
		$new->date_upd	= Sql_prepareTexteAffichage($row['date_upd']);
		$new->info_new	= Sql_prepareTexteAffichage($row['info_new']);
	}
	return $new;
}

/**
Retourne un tableau de news correspondant aux champs du tableau en argument.
@param $args
*/
function News_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."new
				WHERE 1";

	if (!isset($args['id_new']) && !isset($args['code_news']) && !isset($args['code'])
		 && !isset($args['titre']) && !isset($args['contenu'])
		 && !isset($args['titre_data1']) && !isset($args['data1'])
		 && !isset($args['titre_data2']) && !isset($args['data2'])
		 && !isset($args['titre_data3']) && !isset($args['data3'])
		 && !isset($args['titre_data4']) && !isset($args['data4'])
		 && !isset($args['titre_data5']) && !isset($args['data5'])
		 && !isset($args['titre_data6']) && !isset($args['data6'])
		 && !isset($args['lang']) && !isset($args['etat']) && !isset($args['position'])
		 && !isset($args['order_by']) && !isset($args['tab_ids_news']))
		return $tab_result;

	$condition="";

	if (isset($args['id_new']) && $args['id_new'] != "*")
		$condition .= " AND id_new = '".$args['id_new']."' ";
	if (isset($args['code_news']))
		$condition .= " AND code_news LIKE '".Sql_prepareTexteStockage($args['code_news'])."' ";
	if (isset($args['code']))
		$condition .= " AND code = '".$args['code']."' ";
	if (isset($args['titre']))
		$condition .= " AND titre LIKE '".$args['titre']."' ";
	if (isset($args['titre_data1']))
		$condition .= " AND titre_data1 LIKE '".$args['titre_data1']."' ";
	if (isset($args['titre_data2']))
		$condition .= " AND titre_data2 LIKE '".$args['titre_data2']."' ";
	if (isset($args['titre_data3']))
		$condition .= " AND titre_data3 LIKE '".$args['titre_data3']."' ";
	if (isset($args['titre_data4']))
		$condition .= " AND titre_data4 LIKE '".$args['titre_data4']."' ";
	if (isset($args['titre_data5']))
		$condition .= " AND titre_data5 LIKE '".$args['titre_data5']."' ";
	if (isset($args['titre_data6']))
		$condition .= " AND titre_data6 LIKE '".$args['titre_data6']."' ";
	if (isset($args['contenu']))
		$condition .= " AND contenu LIKE '".$args['contenu']."' ";
	if (isset($args['data1']))
		$condition .= " AND data1 LIKE '".$args['data1']."' ";
	if (isset($args['data2']))
		$condition .= " AND data2 LIKE '".$args['data2']."' ";
	if (isset($args['data3']))
		$condition .= " AND data3 LIKE '".$args['data3']."' ";
	if (isset($args['data4']))
		$condition .= " AND data4 LIKE '".$args['data4']."' ";
	if (isset($args['data5']))
		$condition .= " AND data5 LIKE '".$args['data5']."' ";
	if (isset($args['data6']))
		$condition .= " AND data6 LIKE '".$args['data6']."' ";
	if (isset($args['lang']))
		$condition .= " AND lang LIKE '".Sql_prepareTexteStockage($args['lang'])."' ";
	if (isset($args['etat']))
		$condition .= " AND etat LIKE '".Sql_prepareTexteStockage($args['etat'])."' ";
	if (isset($args['position']) && $args['position'] != "*")
		$condition .= " AND position = '".$args['position']."' ";

	if (isset($args['tab_ids_news'])) {
		$ids = implode(",", $args['tab_ids_news']);
		$condition .= " AND id_new IN (0".$ids.") ";
	}

	$sql .= $condition;

	if (!isset($args['etat'])) 
		$sql .= " AND etat != 'supprime' ";  
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
			$id = $row['id_new'];
			$tab_result[$id]["id_new"]		= $id;
			$tab_result[$id]["code_news"]	= Sql_prepareTexteAffichage($row['code_news']);
			$tab_result[$id]["code"]	= $row['code'];
			$tab_result[$id]["lang"]		= Sql_prepareTexteAffichage($row['lang']);
			$tab_result[$id]["etat"]		= Sql_prepareTexteAffichage($row['etat']);
			$tab_result[$id]["position"]	= $row['position'];
			$tab_result[$id]["meta_titre"]		= Sql_prepareTexteAffichage($row['meta_titre']);
			$tab_result[$id]["meta_description"]= Sql_prepareTexteAffichage($row['meta_description']);
			$tab_result[$id]["meta_mots_clefs"]	= Sql_prepareTexteAffichage($row['meta_mots_clefs']);
			$tab_result[$id]["meta_url"]			= Sql_prepareTexteAffichage($row['meta_url']);
			$tab_result[$id]["titre"]		= Sql_prepareTexteAffichage($row['titre']);
			$tab_result[$id]["contenu"]	= Sql_prepareTexteAffichage($row['contenu']);
			$tab_result[$id]["texte_intro"]	= Sql_prepareTexteAffichage($row['texte_intro']);
			$tab_result[$id]["image_intro"]	= Sql_prepareTexteAffichage($row['image_intro']);
			$tab_result[$id]["date"]		= Sql_prepareTexteAffichage($row['date']);
			$tab_result[$id]["titre_data1"]	= Sql_prepareTexteAffichage($row['titre_data1']);
			$tab_result[$id]["data1"]		= Sql_prepareTexteAffichage($row['data1']);
			$tab_result[$id]["titre_data2"]	= Sql_prepareTexteAffichage($row['titre_data2']);
			$tab_result[$id]["data2"]		= Sql_prepareTexteAffichage($row['data2']);
			$tab_result[$id]["titre_data3"]	= Sql_prepareTexteAffichage($row['titre_data3']);
			$tab_result[$id]["data3"]		= Sql_prepareTexteAffichage($row['data3']);
			$tab_result[$id]["titre_data4"]	= Sql_prepareTexteAffichage($row['titre_data4']);
			$tab_result[$id]["data4"]		= Sql_prepareTexteAffichage($row['data4']);
			$tab_result[$id]["titre_data5"]	= Sql_prepareTexteAffichage($row['titre_data5']);
			$tab_result[$id]["data5"]		= Sql_prepareTexteAffichage($row['data5']);
			$tab_result[$id]["titre_data6"]	= Sql_prepareTexteAffichage($row['titre_data6']);
			$tab_result[$id]["data6"]		= Sql_prepareTexteAffichage($row['data6']);
			$tab_result[$id]["url_image"]	= Sql_prepareTexteAffichage($row['url_image']);
			$tab_result[$id]["url_image2"]	= Sql_prepareTexteAffichage($row['url_image2']);
			$tab_result[$id]["date_add"]	= Sql_prepareTexteAffichage($row['date_add']);
			$tab_result[$id]["date_upd"]	= Sql_prepareTexteAffichage($row['date_upd']);
			$tab_result[$id]["info_new"]	= Sql_prepareTexteAffichage($row['info_new']);
		}
	}

	if (count($tab_result) == 1 && ($args['id_new'] != '' && $args['id_new'] != '*'))
		$tab_result = array_pop($tab_result);
	if (count($tab_result) == 1 && ($args['code'] != '' && $args['lang'] != ''))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}

function News_suivant($code_news, $position, $lang, $concours, $data) {
	$precedent = array();
	$precedents = array();

	$liste_news = $data;
	foreach ($liste_news as $new){
		if ($new['code_news'] != $code_news) continue;
		if ($new['code'] == 999999999) continue;
		if ($new['lang'] != $lang) continue;
		if ($new['position'] >= $position) continue;
		if ($new['etat'] == 'supprime') continue;
		if (isset($concours) && $concours != '')
			if ($new['titre_data2'] != $concours) continue;
	$precedents[$new['position']] = $new;
	arsort($precedents);
	}
	/*=============*/ Lib_myLog("Precedents:" ,$precedents);
	$precedent = array_shift($precedents);
	
	//SQL
	if (isset($concours) && $concours != '')
		$cond_concours = "AND titre_data2 = '{$concours}' ";
		
	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."new
				WHERE code_news = '{$code_news}'
				AND lang = '{$lang}'
				AND position < {$position}
				AND etat != 'supprime' ".$cond_concours."
				ORDER BY position DESC
				LIMIT 0, 1";

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$precedent["id_new"]			= $row['id_new'];
		$precedent["titre_data1"]	= Sql_prepareTexteAffichage($row['titre_data1']);
		$precedent["data1"]			= Sql_prepareTexteAffichage($row['data1']);
		$precedent["titre_data2"]	= Sql_prepareTexteAffichage($row['titre_data2']);
		$precedent["data2"]			= Sql_prepareTexteAffichage($row['data2']);
		$precedent["titre_data3"]	= Sql_prepareTexteAffichage($row['titre_data3']);
		$precedent["data3"]			= Sql_prepareTexteAffichage($row['data3']);
		$precedent["titre_data4"]	= Sql_prepareTexteAffichage($row['titre_data4']);
		$precedent["data4"]			= Sql_prepareTexteAffichage($row['data4']);
		$precedent["titre_data5"]	= Sql_prepareTexteAffichage($row['titre_data5']);
		$precedent["data5"]			= Sql_prepareTexteAffichage($row['data5']);
		$precedent["titre_data6"]	= Sql_prepareTexteAffichage($row['titre_data6']);
		$precedent["data6"]			= Sql_prepareTexteAffichage($row['data6']);
		$precedent["code_news"]		= Sql_prepareTexteAffichage($row['code_news']);
		$precedent["code"]			= $row['code'];
		$precedent["lang"]			= Sql_prepareTexteAffichage($row['lang']);
		$precedent["etat"]			= Sql_prepareTexteAffichage($row['etat']);
		$precedent["position"]		= $row['position'];
		$precedent["titre"]			= Sql_prepareTexteAffichage($row['titre']);
		$precedent["contenu"]		= Sql_prepareTexteAffichage($row['contenu']);
		$precedent["texte_intro"]	= Sql_prepareTexteAffichage($row['texte_intro']);
		$precedent["image_intro"]	= Sql_prepareTexteAffichage($row['image_intro']);
		$precedent["date"]			= Sql_prepareTexteAffichage($row['date']);
		$precedent["url_image"]		= Sql_prepareTexteAffichage($row['url_image']);
		$precedent["url_image2"]		= Sql_prepareTexteAffichage($row['url_image2']);
		$precedent["date_add"]		= Sql_prepareTexteAffichage($row['date_add']);
		$precedent["date_upd"]		= Sql_prepareTexteAffichage($row['date_upd']);
		$precedent["info_new"]		= Sql_prepareTexteAffichage($row['info_new']);
	}
	return $precedent;
}

function News_precedent($code_news, $position, $lang, $concours, $data) {
	$suivant = array();
	$suivants = array();
	
	$liste_news = $data;
	foreach ($liste_news as $new){
		if ($new['code_news'] != $code_news) continue;
		if ($new['lang'] != $lang) continue;
		if ($new['position'] <= $position) continue;
		if ($new['code'] == 999999999) continue;
		if ($new['etat'] == 'supprime') continue;
		if (isset($concours) && $concours != '')
			if ($new['titre_data2'] != $concours) continue;
		$suivants[$new['position']] = $new;
		asort($suivants);
	}
	/*=============*/ Lib_myLog("Suivants:" ,$suivants);
	$suivant = array_shift($suivants);
	
	
	//SQL
	if (isset($concours) && $concours != '')
		$cond_concours = "AND titre_data2 = '{$concours}' ";
		
	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."new
				WHERE code_news = '{$code_news}'
				AND lang = '{$lang}'
				AND position > {$position}
				AND etat != 'supprime' ".$cond_concours."
				ORDER BY position ASC
				LIMIT 0, 1";

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$suivant["id_new"]		= $row['id_new'];
		$suivant["titre_data1"]	= Sql_prepareTexteAffichage($row['titre_data1']);
		$suivant["data1"]			= Sql_prepareTexteAffichage($row['data1']);
		$suivant["titre_data2"]	= Sql_prepareTexteAffichage($row['titre_data2']);
		$suivant["data2"]			= Sql_prepareTexteAffichage($row['data2']);
		$suivant["titre_data3"]	= Sql_prepareTexteAffichage($row['titre_data3']);
		$suivant["data3"]			= Sql_prepareTexteAffichage($row['data3']);
		$suivant["titre_data4"]	= Sql_prepareTexteAffichage($row['titre_data4']);
		$suivant["data4"]			= Sql_prepareTexteAffichage($row['data4']);
		$suivant["titre_data5"]	= Sql_prepareTexteAffichage($row['titre_data5']);
		$suivant["data5"]			= Sql_prepareTexteAffichage($row['data5']);
		$suivant["titre_data6"]	= Sql_prepareTexteAffichage($row['titre_data6']);
		$suivant["data6"]			= Sql_prepareTexteAffichage($row['data6']);
		$suivant["code_news"]	= Sql_prepareTexteAffichage($row['code_news']);
		$suivant["code"]			= $row['code'];
		$suivant["lang"]			= Sql_prepareTexteAffichage($row['lang']);
		$suivant["etat"]			= Sql_prepareTexteAffichage($row['etat']);
		$suivant["position"]		= $row['position'];
		$suivant["titre"]			= Sql_prepareTexteAffichage($row['titre']);
		$suivant["contenu"]		= Sql_prepareTexteAffichage($row['contenu']);
		$suivant["texte_intro"]	= Sql_prepareTexteAffichage($row['texte_intro']);
		$suivant["image_intro"]	= Sql_prepareTexteAffichage($row['image_intro']);
		$suivant["date"]			= Sql_prepareTexteAffichage($row['date']);
		$suivant["url_image"]	= Sql_prepareTexteAffichage($row['url_image']);
		$suivant["url_image2"]	= Sql_prepareTexteAffichage($row['url_image2']);
		$suivant["date_add"]		= Sql_prepareTexteAffichage($row['date_add']);
		$suivant["date_upd"]		= Sql_prepareTexteAffichage($row['date_upd']);
		$suivant["info_new"]		= Sql_prepareTexteAffichage($row['info_new']);
	}
	return $suivant;
}
} // Fin if (!defined('__NEW_INC__'))
?>