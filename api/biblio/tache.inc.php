<?
/** @file
 *  @ingroup group3
 *  @brief this file in Taches
*/

/**
 * Classe pour la gestion de taches de personnes
 *
 * @author	dilasoft
 * @version	1.0
 * @code	
CREATE TABLE cms_taches (
  id_tache int(11) NOT NULL auto_increment,
  `code` varchar(64) NOT NULL,
  lang varchar(64) NOT NULL default '',
  position_une int(11) NOT NULL default '0',
  id_new varchar(255) NOT NULL default '0',
  texte text NOT NULL,
  etat varchar(32) NOT NULL default '',
  texte_intro text NOT NULL,
  titre_page varchar(255) NOT NULL,
  titre varchar(255) NOT NULL default '',
  meta_titre varchar(255) NOT NULL,
  meta_description varchar(255) NOT NULL,
  meta_mots_clefs varchar(255) NOT NULL,
  meta_url varchar(255) NOT NULL,
  titre_canonize varchar(255) NOT NULL default '',
  url_vignette varchar(255) NOT NULL default '',
  url_image2 varchar(255) NOT NULL,
  categorie varchar(32) NOT NULL default '',
  titre_data1 varchar(255) NOT NULL,
  data1 text NOT NULL,
  titre_data2 varchar(255) NOT NULL,
  data2 text NOT NULL,
  titre_data3 varchar(255) NOT NULL,
  data3 text NOT NULL,
  titre_data4 varchar(255) NOT NULL,
  data4 text NOT NULL,
  titre_data5 varchar(255) NOT NULL,
  data5 text NOT NULL,
  titre_data6 varchar(255) NOT NULL,
  data6 text NOT NULL,
  titre_data7 varchar(255) NOT NULL,
  data7 text NOT NULL,
  titre_data8 varchar(255) NOT NULL,
  data8 text NOT NULL,
  titre_data9 varchar(255) NOT NULL,
  data9 text NOT NULL,
  titre_data10 varchar(255) NOT NULL,
  data10 text NOT NULL,
  titre_data11 varchar(255) NOT NULL,
  data11 text NOT NULL,
  titre_data12 varchar(255) NOT NULL,
  data12 text NOT NULL,
  titre_data13 varchar(255) NOT NULL,
  data13 text NOT NULL,
  titre_data14 varchar(255) NOT NULL,
  data14 text NOT NULL,
  titre_data15 varchar(255) NOT NULL,
  data15 text NOT NULL,
  titre_data16 varchar(255) NOT NULL,
  data16 text NOT NULL,
  titre_data17 varchar(255) NOT NULL,
  data17 text NOT NULL,
  titre_data18 varchar(255) NOT NULL,
  data18 text NOT NULL,
  titre_data19 varchar(255) NOT NULL,
  data19 text NOT NULL,
  titre_data20 varchar(255) NOT NULL,
  data20 text NOT NULL,
  titre_fichier1 varchar(255) NOT NULL,
  fichier1 varchar(255) NOT NULL,
  titre_fichier2 varchar(255) NOT NULL,
  fichier2 varchar(255) NOT NULL,
  titre_fichier3 varchar(255) NOT NULL,
  fichier3 varchar(255) NOT NULL,
  titre_fichier4 varchar(255) NOT NULL,
  fichier4 varchar(255) NOT NULL,
  titre_fichier5 varchar(255) NOT NULL,
  fichier5 varchar(255) NOT NULL,
  date_add varchar(64) NOT NULL default '',
  date_upd varchar(64) NOT NULL default '',
  info_tache varchar(64) NOT NULL default '',
  PRIMARY KEY  (id_tache)
) TYPE=MyISAM;
 * @endcode
 *
 * 
 * FUSION TACHE ET NEWS

ALTER TABLE `cms_taches` ADD `code_news` VARCHAR( 255 ) NOT NULL AFTER `id_new` ,
ADD `position` INT NOT NULL AFTER `code_news` ,
ADD `url_image` VARCHAR( 255 ) NOT NULL AFTER `position` ,
ADD `contenu` TEXT NOT NULL AFTER `url_image` ,
ADD `image_intro` VARCHAR( 255 ) NOT NULL AFTER `contenu` ,
ADD `date` VARCHAR( 255 ) NOT NULL AFTER `image_intro` 
 */
if (!defined('__TACHE_INC__')){
define('__TACHE_INC__', 1);

class Tache extends Element {
	var $id_tache;
	var $code;
	var $lang;
	var $position_une;
	var $texte;
	var $code_news;
	var $position;
	var $url_image;
	var $contenu;
	var $date;
	var $image_intro;
	var $etat;
	var $texte_intro;
	var $titre_page;
	var $titre;
	var $meta_titre;
	var $meta_description;
	var $meta_mots_clefs;
	var $meta_url;
	var $titre_canonize;
	var $url_vignette;
	var $url_image2;
	var $categorie;
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
	var $titre_data7;
	var $data7;
	var $titre_data8;
	var $data8;
	var $titre_data9;
	var $data9;
	var $titre_data10;
	var $data10;
	var $titre_data11;
	var $data11;
	var $titre_data12;
	var $data12;
	var $titre_data13;
	var $data13;
	var $titre_data14;
	var $data14;
	var $titre_data15;
	var $data15;
	var $titre_data16;
	var $data16;
	var $titre_data17;
	var $data17;
	var $titre_data18;
	var $data18;
	var $titre_data19;
	var $data19;
	var $titre_data20;
	var $data20;
	var $titre_fichier1;
	var $fichier1;
	var $titre_fichier2;
	var $fichier2;
	var $titre_fichier3;
	var $fichier3;
	var $titre_fichier4;
	var $fichier4;
	var $titre_fichier5;
	var $fichier5;
	var $date_add;
	var $date_upd;
	var $info_tache;

	/**
	Cette fonction est un grand switch qui sert à renvoyer vers une action donnée en paramètre. 
	@param type_tache : TypeTache de l'tache
	@param date : date de création de l'tache
	@param lang : lang, titre de l'tache
	@param texte : Corps de l'tache
	*/
	function Tache()
	{
		$this->type_moi = "taches";
	}

	/**
	Cette fonction retourne un tableau correspondant aux différents attributs de l'tache.
	*/
	function getTab() 
	{
		$tab['id_tache']		= $this->id_tache;
		$tab['code']				= $this->code;
		$tab['lang']				= $this->lang;
		$tab['position_une']		= $this->position_une;
		$tab['texte']				= $this->texte;
		$tab['code_news']			= $this->code_news;
		$tab['position']			= $this->position;
		$tab['url_image']			= $this->url_image;
		$tab['contenu']				= $this->contenu;
		$tab['date']				= $this->date;
		$tab['image_intro']				= $this->image_intro;
		$tab['etat']				= $this->etat;
		$tab['texte_intro']		= $this->texte_intro;
		$tab['titre_page']		= $this->titre_page;
		$tab['titre']				= $this->titre;
		$tab['meta_titre']		= $this->meta_titre;
		$tab['meta_description']= $this->meta_description;
		$tab['meta_mots_clefs']	= $this->meta_mots_clefs;
		$tab['meta_url']			= $this->meta_url;
		$tab['titre_canonize'] 	= $this->titre_canonize;
		$tab['url_vignette']		= $this->url_vignette;
		$tab['url_image2']		= $this->url_image2;
		$tab['categorie']			= $this->categorie;
		$tab['titre_data1']		= $this->titre_data1;
		$tab['data1']				= $this->data1;
		$tab['titre_data2']		= $this->titre_data2;
		$tab['data2']				= $this->data2;
		$tab['titre_data3']		= $this->titre_data3;
		$tab['data3']				= $this->data3;
		$tab['titre_data4']		= $this->titre_data4;
		$tab['data4']				= $this->data4;
		$tab['titre_data5']		= $this->titre_data5;
		$tab['data5']				= $this->data5;
		$tab['titre_data6']		= $this->titre_data6;
		$tab['data6']				= $this->data6;
		$tab['titre_data7']		= $this->titre_data7;
		$tab['data7']				= $this->data7;
		$tab['titre_data8']		= $this->titre_data8;
		$tab['data8']				= $this->data8;
		$tab['titre_data9']		= $this->titre_data9;
		$tab['data9']				= $this->data9;
		$tab['titre_data10']		= $this->titre_data10;
		$tab['data10']				= $this->data10;
		$tab['titre_data11']		= $this->titre_data11;
		$tab['data11']				= $this->data11;
		$tab['titre_data12']		= $this->titre_data12;
		$tab['data12']				= $this->data12;
		$tab['titre_data13']		= $this->titre_data13;
		$tab['data13']				= $this->data13;
		$tab['titre_data14']		= $this->titre_data14;
		$tab['data14']				= $this->data14;
		$tab['titre_data15']		= $this->titre_data15;
		$tab['data15']				= $this->data15;
		$tab['titre_data16']		= $this->titre_data16;
		$tab['data16']				= $this->data16;
		$tab['titre_data17']		= $this->titre_data17;
		$tab['data17']				= $this->data17;
		$tab['titre_data18']		= $this->titre_data18;
		$tab['data18']				= $this->data18;
		$tab['titre_data19']		= $this->titre_data19;
		$tab['data19']				= $this->data19;
		$tab['titre_data20']		= $this->titre_data20;
		$tab['data20']				= $this->data20;
		$tab['titre_fichie1']	= $this->titre_fichier1;
		$tab['fichier1']			= $this->fichier1;
		$tab['titre_fichie2']	= $this->titre_fichier2;
		$tab['fichier2']			= $this->fichier2;
		$tab['titre_fichie3']	= $this->titre_fichier3;
		$tab['fichier3']			= $this->fichier3;
		$tab['titre_fichie4']	= $this->titre_fichier4;
		$tab['fichier4']			= $this->fichier4;
		$tab['titre_fichie5']	= $this->titre_fichier5;
		$tab['fichier5']			= $this->fichier5;
		$tab['date_add']			= $this->date_add;
		$tab['date_upd']			= $this->date_upd;
		$tab['info_tache']		= $this->info_tache;
		return $tab;
	}

	/**
	Cette fonction ajoute un tache à la BDD.
	*/
	function ADD()
	{
		$code					= Sql_prepareTexteStockage($this->code); 
		$lang					= Sql_prepareTexteStockage($this->lang);
		$position			= Sql_prepareTexteStockage($this->position);
		$texte				= Sql_prepareTexteStockage($this->texte);
		$code_news			= Sql_prepareTexteStockage($this->code_news);
		$contenu			= Sql_prepareTexteStockage($this->contenu);
		$date				= Lib_frToEn($this->date); //Date d'échéance
		$image_intro			= Sql_prepareTexteStockage($this->image_intro);
		$etat					= Sql_prepareTexteStockage($this->etat);
		$texte_intro		= Sql_prepareTexteStockage($this->texte_intro);
		$titre_page			= Sql_prepareTexteStockage($this->titre_page);
		$titre				= Sql_prepareTexteStockage($this->titre);
		$meta_titre			= Sql_prepareTexteStockage($this->meta_titre);
		$meta_description = Sql_prepareTexteStockage($this->meta_description);
		$meta_mots_clefs	= Sql_prepareTexteStockage($this->meta_mots_clefs);
		$meta_url			= Sql_prepareTexteStockage($this->meta_url);
		$titre_canonize 	= Lib_canonizeMin(Sql_prepareTexteStockage($this->titre));
		$url_vignette		= Sql_prepareTexteStockage($this->url_vignette);
		$url_image			= Sql_prepareTexteStockage($this->url_image);
		$url_image2			= Sql_prepareTexteStockage($this->url_image2);
		$categorie 			= Sql_prepareTexteStockage($this->categorie);
		$titre_data1 		= Sql_prepareTexteStockage($this->titre_data1);
		$data1				= Sql_prepareTexteStockage($this->data1);
		$titre_data2 		= Sql_prepareTexteStockage($this->titre_data2);
		$data2				= Lib_frToEn($this->data2); //Date de fin des développements
		$titre_data3 		= Sql_prepareTexteStockage($this->titre_data3);
		$data3				= Lib_frToEn($this->data3); //Date de mise à disposition sur test
		$titre_data4 		= Sql_prepareTexteStockage($this->titre_data4);
		$data4				= Lib_frToEn($this->data4); //Date de mise en production
		$titre_data5 		= Sql_prepareTexteStockage($this->titre_data5);
		$data5				= Sql_prepareTexteStockage($this->data5);
		$titre_data6 		= Sql_prepareTexteStockage($this->titre_data6);
		$data6				= Sql_prepareTexteStockage($this->data6);
		$titre_data7 		= Sql_prepareTexteStockage($this->titre_data7);
		$data7				= Sql_prepareTexteStockage($this->data7);
		$titre_data8 		= Sql_prepareTexteStockage($this->titre_data8);
		$data8				= Sql_prepareTexteStockage($this->data8);
		$titre_data9 		= Sql_prepareTexteStockage($this->titre_data9);
		$data9				= Sql_prepareTexteStockage($this->data9);
		$titre_data10 		= Sql_prepareTexteStockage($this->titre_data10);
		$data10				= Sql_prepareTexteStockage($this->data10);
		$titre_data11 		= Sql_prepareTexteStockage($this->titre_data11);
		$data11				= Sql_prepareTexteStockage($this->data11);
		$titre_data12 		= Sql_prepareTexteStockage($this->titre_data12);
		$data12				= Sql_prepareTexteStockage($this->data12);
		$titre_data13 		= Sql_prepareTexteStockage($this->titre_data13);
		$data13				= Sql_prepareTexteStockage($this->data13);
		$titre_data14 		= Sql_prepareTexteStockage($this->titre_data14);
		$data14				= Sql_prepareTexteStockage($this->data14);
		$titre_data15 		= Sql_prepareTexteStockage($this->titre_data15);
		$data15				= Sql_prepareTexteStockage($this->data15);
		$titre_data16 		= Sql_prepareTexteStockage($this->titre_data16);
		$data16				= Sql_prepareTexteStockage($this->data16);
		$titre_data17 		= Sql_prepareTexteStockage($this->titre_data17);
		$data17				= Sql_prepareTexteStockage($this->data17);
		$titre_data18 		= Sql_prepareTexteStockage($this->titre_data18);
		$data18				= Sql_prepareTexteStockage($this->data18);
		$titre_data19 		= Sql_prepareTexteStockage($this->titre_data19);
		$data19				= Sql_prepareTexteStockage($this->data19);
		$titre_data20 		= Sql_prepareTexteStockage($this->titre_data20);
		$data20				= Sql_prepareTexteStockage($this->data20);
		$titre_fichier1 	= Sql_prepareTexteStockage($this->titre_fichier1);
		$fichier1			= Sql_prepareTexteStockage($this->fichier1);
		$titre_fichier2 	= Sql_prepareTexteStockage($this->titre_fichier2);
		$fichier2			= Sql_prepareTexteStockage($this->fichier2);
		$titre_fichier3 	= Sql_prepareTexteStockage($this->titre_fichier3);
		$fichier3			= Sql_prepareTexteStockage($this->fichier3);
		$titre_fichier4 	= Sql_prepareTexteStockage($this->titre_fichier4);
		$fichier4			= Sql_prepareTexteStockage($this->fichier4);
		$titre_fichier5 	= Sql_prepareTexteStockage($this->titre_fichier5);
		$fichier5			= Sql_prepareTexteStockage($this->fichier5);
		$date_add			= time();
		$info_tache  	= Sql_prepareTexteStockage($this->info_tache);

		$sql = " INSERT INTO ".$GLOBALS['prefix']."taches
					(code, lang, position_une, texte, 
					etat, texte_intro, titre_page, titre, code_news, position, url_image, contenu, date, image_intro,
					meta_titre, meta_description, meta_mots_clefs, meta_url, 
					titre_canonize, url_vignette, url_image2, categorie, 
					titre_data1, data1, titre_data2, data2, titre_data3, data3, titre_data4, data4, titre_data5, data5, 
					titre_data6, data6, titre_data7, data7, titre_data8, data8, titre_data9, data9, titre_data10, data10, 
					titre_data11, data11, titre_data12, data12, titre_data13, data13, titre_data14, data14, titre_data15, data15,
					titre_data16, data16, titre_data17, data17, titre_data18, data18, titre_data19, data19, titre_data20, data20,
					titre_fichier1, fichier1, titre_fichier2, fichier2, titre_fichier3, fichier3, titre_fichier4, fichier4, titre_fichier5, fichier5,
					date_add, info_tache)
					VALUES('$code', '$lang', '$position_une', '$texte', 
							'$etat', '$texte_intro', '$titre_page', '$titre', '$code_news', '$position', '$url_image', '$contenu',
							'$date', '$image_intro',
							'$meta_titre','$meta_description', '$meta_mots_clefs', '$meta_url', 
							'$titre_canonize', '$url_vignette', '$url_image2', '$categorie',
							'$titre_data1', '$data1', '$titre_data2', '$data2', '$titre_data3', '$data3', '$titre_data4', '$data4', '$titre_data5', '$data5', 
							'$titre_data6', '$data6', '$titre_data7', '$data7', '$titre_data8', '$data8', '$titre_data9', '$data9', '$titre_data10', '$data10', 
							'$titre_data11', '$data11', '$titre_data12', '$data12', '$titre_data13', '$data13', '$titre_data14', '$data14', '$titre_data15', '$data15', 
							'$titre_data16', '$data16', '$titre_data17', '$data17', '$titre_data18', '$data18', '$titre_data19', '$data19', '$titre_data20', '$data20', 
							'$titre_fichier1', '$fichier1', '$titre_fichier2', '$fichier2', '$titre_fichier3', '$fichier3', '$titre_fichier4', '$fichier4', '$titre_fichier5', '$fichier5', 
							'$date_add', '$info_tache')";

		if (!Sql_exec($sql)) $this->setError(ERROR);  
		if (!$this->isError()) {
			$id_tache = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_tache");
			$this->id_tache = $id_tache;
			return $id_tache;
		}

		return;
	}

	/**
	Cette fonction met à jour un tache sur la BDD.
	*/
	function UPD() 
	{
		if ($this->isError()) return;

		$id_tache			= $this->id_tache;
		$code					= Sql_prepareTexteStockage($this->code); 
		$lang					= Sql_prepareTexteStockage($this->lang);
		$position			= Sql_prepareTexteStockage($this->position);
		$texte				= Sql_prepareTexteStockage($this->texte);
		$code_news			= Sql_prepareTexteStockage($this->code_news);
		$contenu			= Sql_prepareTexteStockage($this->contenu);
		$date				= Lib_frToEn($this->date); //Date d'échéance
		$image_intro			= Sql_prepareTexteStockage($this->image_intro);
		$etat					= Sql_prepareTexteStockage($this->etat);
		$texte_intro		= Sql_prepareTexteStockage($this->texte_intro);
		$titre_page			= Sql_prepareTexteStockage($this->titre_page);
		$titre				= Sql_prepareTexteStockage($this->titre);
		$meta_titre			= Sql_prepareTexteStockage($this->meta_titre);
		$meta_description = Sql_prepareTexteStockage($this->meta_description);
		$meta_mots_clefs	= Sql_prepareTexteStockage($this->meta_mots_clefs);
		$meta_url			= Sql_prepareTexteStockage($this->meta_url);
		$titre_canonize 	= Lib_canonizeMin(Sql_prepareTexteStockage($this->titre));
		$url_vignette		= Sql_prepareTexteStockage($this->url_vignette);
		$url_image			= Sql_prepareTexteStockage($this->url_image);
		$url_image2			= Sql_prepareTexteStockage($this->url_image2);
		$categorie 			= Sql_prepareTexteStockage($this->categorie);
		$titre_data1 		= Sql_prepareTexteStockage($this->titre_data1);
		$data1				= Sql_prepareTexteStockage($this->data1);
		$titre_data2 		= Sql_prepareTexteStockage($this->titre_data2);
		$data2				= Lib_frToEn($this->data2); //Date de fin des développements
		$titre_data3 		= Sql_prepareTexteStockage($this->titre_data3);
		$data3				= Lib_frToEn($this->data3); //Date de mise à disposition sur test
		$titre_data4 		= Sql_prepareTexteStockage($this->titre_data4);
		$data4				= Lib_frToEn($this->data4); //Date de mise en production
		$titre_data5 		= Sql_prepareTexteStockage($this->titre_data5);
		$data5				= Sql_prepareTexteStockage($this->data5);
		$titre_data6 		= Sql_prepareTexteStockage($this->titre_data6);
		$data6				= Sql_prepareTexteStockage($this->data6);
		$titre_data7 		= Sql_prepareTexteStockage($this->titre_data7);
		$data7				= Sql_prepareTexteStockage($this->data7);
		$titre_data8 		= Sql_prepareTexteStockage($this->titre_data8);
		$data8				= Sql_prepareTexteStockage($this->data8);
		$titre_data9 		= Sql_prepareTexteStockage($this->titre_data9);
		$data9				= Sql_prepareTexteStockage($this->data9);
		$titre_data10 		= Sql_prepareTexteStockage($this->titre_data10);
		$data10				= Sql_prepareTexteStockage($this->data10);
		$titre_data11 		= Sql_prepareTexteStockage($this->titre_data11);
		$data11				= Sql_prepareTexteStockage($this->data11);
		$titre_data12 		= Sql_prepareTexteStockage($this->titre_data12);
		$data12				= Sql_prepareTexteStockage($this->data12);
		$titre_data13 		= Sql_prepareTexteStockage($this->titre_data13);
		$data13				= Sql_prepareTexteStockage($this->data13);
		$titre_data14 		= Sql_prepareTexteStockage($this->titre_data14);
		$data14				= Sql_prepareTexteStockage($this->data14);
		$titre_data15 		= Sql_prepareTexteStockage($this->titre_data15);
		$data15				= Sql_prepareTexteStockage($this->data15);
		$titre_data16 		= Sql_prepareTexteStockage($this->titre_data16);
		$data16				= Sql_prepareTexteStockage($this->data16);
		$titre_data17 		= Sql_prepareTexteStockage($this->titre_data17);
		$data17				= Sql_prepareTexteStockage($this->data17);
		$titre_data18 		= Sql_prepareTexteStockage($this->titre_data18);
		$data18				= Sql_prepareTexteStockage($this->data18);
		$titre_data19 		= Sql_prepareTexteStockage($this->titre_data19);
		$data19				= Sql_prepareTexteStockage($this->data19);
		$titre_data20 		= Sql_prepareTexteStockage($this->titre_data20);
		$data20				= Sql_prepareTexteStockage($this->data20);
		$titre_fichier1 	= Sql_prepareTexteStockage($this->titre_fichier1);
		$fichier1			= Sql_prepareTexteStockage($this->fichier1);
		$titre_fichier2 	= Sql_prepareTexteStockage($this->titre_fichier2);
		$fichier2			= Sql_prepareTexteStockage($this->fichier2);
		$titre_fichier3 	= Sql_prepareTexteStockage($this->titre_fichier3);
		$fichier3			= Sql_prepareTexteStockage($this->fichier3);
		$titre_fichier4 	= Sql_prepareTexteStockage($this->titre_fichier4);
		$fichier4			= Sql_prepareTexteStockage($this->fichier4);
		$titre_fichier5 	= Sql_prepareTexteStockage($this->titre_fichier5);
		$fichier5			= Sql_prepareTexteStockage($this->fichier5);
		$date_upd			= time();
 		$info_tache 		= Sql_prepareTexteStockage($this->info_tache);
		
		// Mise à jour de la base
		$sql = " UPDATE ".$GLOBALS['prefix']."taches
					SET code = '$code', lang = '$lang', position_une = '$position_une', texte = '$texte', etat = '$etat',
						code_news = '$code_news', position = '$position', url_image = '$url_image', contenu = '$contenu', date = '$date', image_intro = '$image_intro',
						texte_intro = '$texte_intro', titre_page = '$titre_page', titre = '$titre', meta_titre = '$meta_titre', meta_description = '$meta_description', 
						meta_mots_clefs = '$meta_mots_clefs', meta_url = '$meta_url',titre_canonize = '$titre_canonize',
						url_vignette = '$url_vignette', url_image2 = '$url_image2', categorie = '$categorie',
						titre_data1 = '$titre_data1', data1 = '$data1', titre_data2 = '$titre_data2', data2 = '$data2', 
						titre_data3 = '$titre_data3', data3 = '$data3', titre_data4 = '$titre_data4', data4 = '$data4', 
						titre_data5 = '$titre_data5', data5 = '$data5', titre_data6 = '$titre_data6', data6 = '$data6',
						titre_data7 = '$titre_data7', data7 = '$data7', titre_data8 = '$titre_data8', data8 = '$data8',
						titre_data9 = '$titre_data9', data9 = '$data9', titre_data10 = '$titre_data10', data10 = '$data10',
						titre_data11 = '$titre_data11', data11 = '$data11', titre_data12 = '$titre_data12', data12 = '$data12',
						titre_data13 = '$titre_data13', data13 = '$data13', titre_data14 = '$titre_data14', data14 = '$data14',
						titre_data15 = '$titre_data15', data15 = '$data15', titre_data16 = '$titre_data16', data16 = '$data16',
						titre_data17 = '$titre_data17', data17 = '$data17', titre_data18 = '$titre_data18', data18 = '$data18',
						titre_data19 = '$titre_data19', data19 = '$data19', titre_data20 = '$titre_data20', data20 = '$data20',
						titre_fichier1 = '$titre_fichier1', fichier1 = '$fichier1', titre_fichier2 = '$titre_fichier2', fichier2 = '$fichier2',
						titre_fichier3 = '$titre_fichier3', fichier3 = '$fichier3', titre_fichier4 = '$titre_fichier4', fichier4 = '$fichier4',
						titre_fichier5 = '$titre_fichier5', fichier5 = '$fichier5', date_upd = '$date_upd', info_tache = '$info_tache'
					WHERE id_tache = $id_tache";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);
		
		return;
	}
	/**
	Cette fonction supprime un tache de la BDD.
	*/
	function DEL() 
	{
		if ($this->isError()) return;

		$id_tache = $this->id_tache;

		$sql = " DELETE FROM ".$GLOBALS['prefix']."taches
					WHERE id_tache = $id_tache";

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
		$str = Lib_addElem($str, $this->id_tache);
		$str = Lib_addElem($str, $this->code);
		$str = Lib_addElem($str, $this->lang);
		$str = Lib_addElem($str, $this->position_une);
		$str = Lib_addElem($str, $this->position);
		$str = Lib_addElem($str, $this->code_news);
		$str = Lib_addElem($str, $this->url_image);
		$str = Lib_addElem($str, $this->contenu);
		$str = Lib_addElem($str, $this->date);
		$str = Lib_addElem($str, $this->image_intro);
		$str = Lib_addElem($str, $this->texte);
		$str = Lib_addElem($str, $this->etat);
		$str = Lib_addElem($str, $this->texte_intro);
		$str = Lib_addElem($str, $this->titre_page);
		$str = Lib_addElem($str, $this->titre);
		$str = Lib_addElem($str, $this->meta_titre);
		$str = Lib_addElem($str, $this->meta_description);
		$str = Lib_addElem($str, $this->meta_mots_clefs);
		$str = Lib_addElem($str, $this->meta_url);
		$str = Lib_addElem($str, $this->titre_canonize);
		$str = Lib_addElem($str, $this->url_vignette);
		$str = Lib_addElem($str, $this->url_image2);
		$str = Lib_addElem($str, $this->categorie);
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
		$str = Lib_addElem($str, $this->titre_data7);
		$str = Lib_addElem($str, $this->data7);
		$str = Lib_addElem($str, $this->titre_data8);
		$str = Lib_addElem($str, $this->data8);
		$str = Lib_addElem($str, $this->titre_data9);
		$str = Lib_addElem($str, $this->data9);
		$str = Lib_addElem($str, $this->titre_data10);
		$str = Lib_addElem($str, $this->data10);
		$str = Lib_addElem($str, $this->titre_data11);
		$str = Lib_addElem($str, $this->data11);
		$str = Lib_addElem($str, $this->titre_data12);
		$str = Lib_addElem($str, $this->data12);
		$str = Lib_addElem($str, $this->titre_data13);
		$str = Lib_addElem($str, $this->data13);
		$str = Lib_addElem($str, $this->titre_data14);
		$str = Lib_addElem($str, $this->data14);
		$str = Lib_addElem($str, $this->titre_data15);
		$str = Lib_addElem($str, $this->data15);
		$str = Lib_addElem($str, $this->titre_data16);
		$str = Lib_addElem($str, $this->data16);
		$str = Lib_addElem($str, $this->titre_data17);
		$str = Lib_addElem($str, $this->data17);
		$str = Lib_addElem($str, $this->titre_data18);
		$str = Lib_addElem($str, $this->data18);
		$str = Lib_addElem($str, $this->titre_data19);
		$str = Lib_addElem($str, $this->data19);
		$str = Lib_addElem($str, $this->titre_data20);
		$str = Lib_addElem($str, $this->data20);
		$str = Lib_addElem($str, $this->titre_fichier1);
		$str = Lib_addElem($str, $this->fichier1);
		$str = Lib_addElem($str, $this->titre_fichier2);
		$str = Lib_addElem($str, $this->fichier2);
		$str = Lib_addElem($str, $this->titre_fichier3);
		$str = Lib_addElem($str, $this->fichier3);
		$str = Lib_addElem($str, $this->titre_fichier4);
		$str = Lib_addElem($str, $this->fichier4);
		$str = Lib_addElem($str, $this->titre_fichier5);
		$str = Lib_addElem($str, $this->fichier5);
		$str = Lib_addElem($str, $this->date_add);
		$str = Lib_addElem($str, $this->date_upd);
		$str = Lib_addElem($str, $this->info_tache);
		$str = "(".$str.")";
		return $str;
	}
}

/**
 Recupère toutes les données relatives à un tache suivant son identifiant
 et retourne la coquille "Tache" remplie avec les informations récupérées
 de la base.
 @param id_tache: Identifiant du tache à récupérer
*/
function Tache_recuperer($id_tache) {

	$tache = new Tache();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."taches
			WHERE id_tache = $id_tache";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tache->id_tache			= $row['id_tache'];
		$tache->code					= $row['code'];
		$tache->lang					= $row['lang'];
		$tache->position_une		= $row['position_une'];
		$tache->position		= $row['position'];
		$tache->texte				= Sql_prepareTexteAffichage($row['texte']);
		$tache->code_news				= Sql_prepareTexteAffichage($row['code_news']);
		$tache->url_image				= Sql_prepareTexteAffichage($row['url_image']);
		$tache->contenu				= Sql_prepareTexteAffichage($row['contenu']);
		$tache->date				= Lib_enToFr($row['date']);
		$tache->image_intro				= Sql_prepareTexteAffichage($row['image_intro']);
		$tache->etat					= $row['etat'];
		$tache->texte_intro		= Sql_prepareTexteAffichage($row['texte_intro']);
		$tache->titre				= Sql_prepareTexteAffichage($row['titre']);
		$tache->meta_titre			= Sql_prepareTexteAffichage($row['meta_titre']);
		$tache->meta_description	= Sql_prepareTexteAffichage($row['meta_description']);
		$tache->meta_mots_clefs	= Sql_prepareTexteAffichage($row['meta_mots_clefs']);
		$tache->meta_url			= Sql_prepareTexteAffichage($row['meta_url']);
		$tache->canonize			= $row['titre_canonize'];
		$tache->url_vignette		= $row['url_vignette'];
		$tache->url_image2			= $row['url_image2'];
		$tache->categorie			= $row['categorie'];
		$tache->titre_data1		= Sql_prepareTexteAffichage($row['titre_data1']);
		$tache->data1				= Sql_prepareTexteAffichage($row['data1']);
		$tache->titre_data2		= Sql_prepareTexteAffichage($row['titre_data2']);
		$tache->data2				= Lib_enToFr($row['data2']);
		$tache->titre_data3		= Sql_prepareTexteAffichage($row['titre_data3']);
		$tache->data3				= Lib_enToFr($row['data3']);
		$tache->titre_data4		= Sql_prepareTexteAffichage($row['titre_data4']);
		$tache->data4				= Lib_enToFr($row['data4']);
		$tache->titre_data5		= Sql_prepareTexteAffichage($row['titre_data5']);
		$tache->data5				= Sql_prepareTexteAffichage($row['data5']);
		$tache->titre_data6		= Sql_prepareTexteAffichage($row['titre_data6']);
		$tache->data6				= Sql_prepareTexteAffichage($row['data6']);
		$tache->titre_data7		= Sql_prepareTexteAffichage($row['titre_data7']);
		$tache->data7				= Sql_prepareTexteAffichage($row['data7']);
		$tache->titre_data8		= Sql_prepareTexteAffichage($row['titre_data8']);
		$tache->data8				= Sql_prepareTexteAffichage($row['data8']);
		$tache->titre_data9		= Sql_prepareTexteAffichage($row['titre_data9']);
		$tache->data9				= Sql_prepareTexteAffichage($row['data9']);
		$tache->titre_data10		= Sql_prepareTexteAffichage($row['titre_data10']);
		$tache->data10				= Sql_prepareTexteAffichage($row['data10']);
		$tache->titre_data11		= Sql_prepareTexteAffichage($row['titre_data11']);
		$tache->data11				= Sql_prepareTexteAffichage($row['data11']);
		$tache->titre_data12		= Sql_prepareTexteAffichage($row['titre_data12']);
		$tache->data12				= Sql_prepareTexteAffichage($row['data12']);
		$tache->titre_data13		= Sql_prepareTexteAffichage($row['titre_data13']);
		$tache->data13				= Sql_prepareTexteAffichage($row['data13']);
		$tache->titre_data14		= Sql_prepareTexteAffichage($row['titre_data14']);
		$tache->data14				= Sql_prepareTexteAffichage($row['data14']);
		$tache->titre_data15		= Sql_prepareTexteAffichage($row['titre_data15']);
		$tache->data15				= Sql_prepareTexteAffichage($row['data15']);
		$tache->titre_data16		= Sql_prepareTexteAffichage($row['titre_data16']);
		$tache->data16				= Sql_prepareTexteAffichage($row['data16']);
		$tache->titre_data17		= Sql_prepareTexteAffichage($row['titre_data17']);
		$tache->data17				= Sql_prepareTexteAffichage($row['data17']);
		$tache->titre_data18		= Sql_prepareTexteAffichage($row['titre_data18']);
		$tache->data18				= Sql_prepareTexteAffichage($row['data18']);
		$tache->titre_data19		= Sql_prepareTexteAffichage($row['titre_data19']);
		$tache->data19				= Sql_prepareTexteAffichage($row['data19']);
		$tache->titre_data20		= Sql_prepareTexteAffichage($row['titre_daTa20']);
		$tache->data20				= Sql_prepareTexteAffichage($row['data20']);
		$tache->date_add			= $row['date_add'];
		$tache->date_upd			= $row['date_upd'];
		$tache->info_tache		= Sql_prepareTexteAffichage($row['info_tache']);
	}
	
	return $tache;
}

/**
 Renvoie le lang, le prélang et l'identifiant des personnes ayant les données passées en argument sous forme d'un tableau
 @param id_tache
 @param langPersonne
 @param textePersonne
 ...
*/
function Taches_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
			FROM ".$GLOBALS['prefix']."taches
			WHERE 1";

	if (!isset($args['id_tache']) && !isset($args['code']) && !isset($args['code_news']) && 
		!isset($args['date']) && !isset($args['lang']) && !isset($args['titre'])  && !isset($args['position'])
		 && !isset($args['titre_data1']) && !isset($args['data1'])
		 && !isset($args['titre_data2']) && !isset($args['data2'])
		 && !isset($args['titre_data3']) && !isset($args['data3'])
		 && !isset($args['titre_data4']) && !isset($args['data4'])
		 && !isset($args['titre_data5']) && !isset($args['data5'])
		 && !isset($args['titre_data6']) && !isset($args['data6']) &&
		!isset($args['texte']) && !isset($args['etat']) && 
		!isset($args['position_une']) && !isset($args['not_position_une']) && 
		!isset($args['code']) && !isset($args['titre_canonize']) && 
		!isset($args['tab_ids_taches']) && !isset($args['categorie'])) 
		return $tab_result;

	$condition="";

	if (isset($args['id_tache']) && $args['id_tache'] != "*") 
		$condition .= " AND id_tache = ".Sql_prepareTexteStockage($args['id_tache'])." ";
	if (isset($args['code_news']))
		$condition .= " AND code_news LIKE '".Sql_prepareTexteStockage($args['code_news'])."' ";
	if (isset($args['position']) && $args['position'] != "*")
		$condition .= " AND position = '".$args['position']."' ";
	if (isset($args['position_une'])) 
		$condition .= " AND position_une = ".$args['position_une']." ";
	if (isset($args['not_position_une'])) 
		$condition .= " AND position_une != ".$args['not_position_une']." ";
	if (isset($args['position_une_min'])) 
		$condition .= " AND position_une >= ".$args['position_une_min']." ";
	if (isset($args['code'])) 
		$condition .= " AND code = '".$args['code']."' ";
	if (isset($args['lang'])) 
		$condition .= " AND lang = '".$args['lang']."' ";
	if (isset($args['texte'])) 
		$condition .= " AND texte LIKE '".Sql_prepareTexteStockage($args['texte'])."' ";
	if (isset($args['titre'])) 
		$condition .= " AND titre LIKE '".Sql_prepareTexteStockage($args['titre'])."' ";
	if (isset($args['etat'])) 
		$condition .= " AND etat = '".$args['etat']."' ";
	if (isset($args['meta_titre'])) 
		$condition .= " AND meta_titre = '".$args['meta_titre']."' ";
	if (isset($args['meta_description'])) 
		$condition .= " AND meta_description = '".$args['meta_description']."' ";
	if (isset($args['meta_mots_clefs'])) 
		$condition .= " AND meta_mots_clefs = '".$args['meta_mots_clefs']."' ";
	if (isset($args['meta_url'])) 
		$condition .= " AND meta_url = '".$args['meta_url']."' ";
	if (isset($args['titre_canonize'])) 
		$condition .= " AND titre_canonize LIKE '".$args['titre_canonize']."' ";
	if (isset($args['categorie'])) 
		$condition .= " AND categorie LIKE '".$args['categorie']."' ";
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
	if (isset($args['titre_data7']))
		$condition .= " AND titre_data7 LIKE '".$args['titre_data7']."' ";
	if (isset($args['titre_data8']))
		$condition .= " AND titre_data8 LIKE '".$args['titre_data8']."' ";
	if (isset($args['titre_data9']))
		$condition .= " AND titre_data9 LIKE '".$args['titre_data9']."' ";
	if (isset($args['titre_data10']))
		$condition .= " AND titre_data10 LIKE '".$args['titre_data10']."' ";
	if (isset($args['titre_data11']))
		$condition .= " AND titre_data11 LIKE '".$args['titre_data11']."' ";
	if (isset($args['titre_data12']))
		$condition .= " AND titre_data12 LIKE '".$args['titre_data12']."' ";
	if (isset($args['titre_data13']))
		$condition .= " AND titre_data13 LIKE '".$args['titre_data13']."' ";
	if (isset($args['titre_data14']))
		$condition .= " AND titre_data14 LIKE '".$args['titre_data14']."' ";
	if (isset($args['titre_data15']))
		$condition .= " AND titre_data15 LIKE '".$args['titre_data15']."' ";
	if (isset($args['titre_data16']))
		$condition .= " AND titre_data16 LIKE '".$args['titre_data16']."' ";
	if (isset($args['titre_data17']))
		$condition .= " AND titre_data17 LIKE '".$args['titre_data17']."' ";
	if (isset($args['titre_data18']))
		$condition .= " AND titre_data18 LIKE '".$args['titre_data18']."' ";
	if (isset($args['titre_data19']))
		$condition .= " AND titre_data19 LIKE '".$args['titre_data19']."' ";
	if (isset($args['titre_data20']))
		$condition .= " AND titre_data620 LIKE '".$args['titre_data20']."' ";
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
	if (isset($args['data7']))
		$condition .= " AND data7 LIKE '".$args['data7']."' ";
	if (isset($args['data8']))
		$condition .= " AND data8 LIKE '".$args['data8']."' ";
	if (isset($args['data9']))
		$condition .= " AND data9 LIKE '".$args['data9']."' ";
	if (isset($args['data10']))
		$condition .= " AND data10 LIKE '".$args['data10']."' ";
	if (isset($args['data11']))
		$condition .= " AND data11 LIKE '".$args['data11']."' ";
	if (isset($args['data12']))
		$condition .= " AND data12 LIKE '".$args['data12']."' ";
	if (isset($args['data13']))
		$condition .= " AND data13 LIKE '".$args['data13']."' ";
	if (isset($args['data14']))
		$condition .= " AND data14 LIKE '".$args['data14']."' ";
	if (isset($args['data15']))
		$condition .= " AND data15 LIKE '".$args['data15']."' ";
	if (isset($args['data16']))
		$condition .= " AND data16 LIKE '".$args['data16']."' ";
	if (isset($args['data17']))
		$condition .= " AND data17 LIKE '".$args['data17']."' ";
	if (isset($args['data18']))
		$condition .= " AND data18 LIKE '".$args['data18']."' ";
	if (isset($args['data19']))
		$condition .= " AND data19 LIKE '".$args['data19']."' ";
	if (isset($args['data20']))
		$condition .= " AND data20 LIKE '".$args['data20']."' ";

	if (isset($args['tab_ids_taches'])) { 
		$ids = implode(",", $args['tab_ids_taches']);
		$condition .= " AND id_tache IN (".$ids.") ";  
	}

	if (!isset($args['etat'])) 
		$condition .= " AND etat != 'supprime' ";  
	if (isset($args['order_by']) && $args['order_by'] != "*") 
		$condition .= " ORDER BY ".$args['order_by']." ASC ";  
	else $condition .= " ORDER BY id_tache ASC ";  
	
	$sql .= $condition;

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_tache'];
			$tab_result[$id]["id_tache"]		= $id;
			$tab_result[$id]["code"]				= $row['code'];
			$tab_result[$id]["lang"]				= $row['lang'];
			$tab_result[$id]["position_une"]		= $row['position_une'];
			$tab_result[$id]["position"]		= $row['position'];
			$tab_result[$id]["code_news"]		= $row['code_news'];
			$tab_result[$id]["contenu"]		= $row['contenu'];
			$tab_result[$id]["date"]		= Lib_enToFr($row['date']);
			$tab_result[$id]["texte"]				= Sql_prepareTexteAffichage($row['texte']);
			$tab_result[$id]["etat"]				= $row['etat'];
			$tab_result[$id]["image_intro"]		= Sql_prepareTexteAffichage($row['image_intro']);
			$tab_result[$id]["texte_intro"]		= Sql_prepareTexteAffichage($row['texte_intro']);
			$tab_result[$id]["titre"]				= Sql_prepareTexteAffichage($row['titre']);
			$tab_result[$id]["titre_page"]		= Sql_prepareTexteAffichage($row['titre_page']);
			$tab_result[$id]["meta_titre"]		= Sql_prepareTexteAffichage($row['meta_titre']);
			$tab_result[$id]["meta_description"]= Sql_prepareTexteAffichage($row['meta_description']);
			$tab_result[$id]["meta_mots_clefs"]	= Sql_prepareTexteAffichage($row['meta_mots_clefs']);
			$tab_result[$id]["meta_url"]			= Sql_prepareTexteAffichage($row['meta_url']);
			$tab_result[$id]["titre_canonize"]	= $row['titre_canonize'];
			$tab_result[$id]["url_vignette"]		= $row['url_vignette'];
			$tab_result[$id]["url_image"]		= $row['url_image'];
			$tab_result[$id]["url_image2"]		= $row['url_image2'];
			$tab_result[$id]["categorie"]			= $row['categorie'];
			$tab_result[$id]["titre_data1"]		= Sql_prepareTexteAffichage($row['titre_data1']);
			$tab_result[$id]["data1"]				= Sql_prepareTexteAffichage($row['data1']);
			$tab_result[$id]["titre_data2"]		= Sql_prepareTexteAffichage($row['titre_data2']);
			$tab_result[$id]["data2"]				= Lib_enToFr($row['data2']);
			$tab_result[$id]["titre_data3"]		= Sql_prepareTexteAffichage($row['titre_data3']);
			$tab_result[$id]["data3"]				= Lib_enToFr($row['data3']);
			$tab_result[$id]["titre_data4"]		= Sql_prepareTexteAffichage($row['titre_data4']);
			$tab_result[$id]["data4"]				= Lib_enToFr($row['data4']);
			$tab_result[$id]["titre_data5"]		= Sql_prepareTexteAffichage($row['titre_data5']);
			$tab_result[$id]["data5"]				= Sql_prepareTexteAffichage($row['data5']);
			$tab_result[$id]["titre_data6"]		= Sql_prepareTexteAffichage($row['titre_data6']);
			$tab_result[$id]["data6"]				= Sql_prepareTexteAffichage($row['data6']);
			$tab_result[$id]["titre_data7"]		= Sql_prepareTexteAffichage($row['titre_data7']);
			$tab_result[$id]["data7"]				= Sql_prepareTexteAffichage($row['data7']);
			$tab_result[$id]["titre_data8"]		= Sql_prepareTexteAffichage($row['titre_data8']);
			$tab_result[$id]["data8"]				= Sql_prepareTexteAffichage($row['data8']);
			$tab_result[$id]["titre_data9"]		= Sql_prepareTexteAffichage($row['titre_data9']);
			$tab_result[$id]["data9"]				= Sql_prepareTexteAffichage($row['data9']);
			$tab_result[$id]["titre_data10"]		= Sql_prepareTexteAffichage($row['titre_data10']);
			$tab_result[$id]["data10"]				= Sql_prepareTexteAffichage($row['data10']);
			$tab_result[$id]["titre_data11"]		= Sql_prepareTexteAffichage($row['titre_data11']);
			$tab_result[$id]["data11"]				= Sql_prepareTexteAffichage($row['data11']);
			$tab_result[$id]["titre_data12"]		= Sql_prepareTexteAffichage($row['titre_data12']);
			$tab_result[$id]["data12"]				= Sql_prepareTexteAffichage($row['data12']);
			$tab_result[$id]["titre_data13"]		= Sql_prepareTexteAffichage($row['titre_data13']);
			$tab_result[$id]["data13"]				= Sql_prepareTexteAffichage($row['data13']);
			$tab_result[$id]["titre_data14"]		= Sql_prepareTexteAffichage($row['titre_data14']);
			$tab_result[$id]["data14"]				= Sql_prepareTexteAffichage($row['data14']);
			$tab_result[$id]["titre_data15"]		= Sql_prepareTexteAffichage($row['titre_data15']);
			$tab_result[$id]["data15"]				= Sql_prepareTexteAffichage($row['data15']);
			$tab_result[$id]["titre_data16"]		= Sql_prepareTexteAffichage($row['titre_data16']);
			$tab_result[$id]["data16"]				= Sql_prepareTexteAffichage($row['data16']);
			$tab_result[$id]["titre_data17"]		= Sql_prepareTexteAffichage($row['titre_data17']);
			$tab_result[$id]["data17"]				= Sql_prepareTexteAffichage($row['data17']);
			$tab_result[$id]["titre_data18"]		= Sql_prepareTexteAffichage($row['titre_data18']);
			$tab_result[$id]["data18"]				= Sql_prepareTexteAffichage($row['data18']);
			$tab_result[$id]["titre_data19"]		= Sql_prepareTexteAffichage($row['titre_data19']);
			$tab_result[$id]["data19"]				= Sql_prepareTexteAffichage($row['data19']);
			$tab_result[$id]["titre_data20"]		= Sql_prepareTexteAffichage($row['titre_data20']);
			$tab_result[$id]["data20"]				= Sql_prepareTexteAffichage($row['data20']);
			$tab_result[$id]["titre_fichier1"]	= Sql_prepareTexteAffichage($row['titre_fichier1']);
			$tab_result[$id]["fichier1"]			= Sql_prepareTexteAffichage($row['fichier1']);
			$tab_result[$id]["titre_fichier2"]	= Sql_prepareTexteAffichage($row['titre_fichier1']);
			$tab_result[$id]["fichier2"]			= Sql_prepareTexteAffichage($row['fichier2']);
			$tab_result[$id]["titre_fichier3"]	= Sql_prepareTexteAffichage($row['titre_fichier3']);
			$tab_result[$id]["fichier3"]			= Sql_prepareTexteAffichage($row['fichier3']);
			$tab_result[$id]["titre_fichier4"]	= Sql_prepareTexteAffichage($row['titre_fichier4']);
			$tab_result[$id]["fichier4"]			= Sql_prepareTexteAffichage($row['fichier4']);
			$tab_result[$id]["titre_fichier5"]	= Sql_prepareTexteAffichage($row['titre_fichier5']);
			$tab_result[$id]["fichier5"]			= Sql_prepareTexteAffichage($row['fichier5']);
			$tab_result[$id]["date_add"]			= $row['date_add'];
			$tab_result[$id]["date_upd"]			= $row['date_upd'];
			$tab_result[$id]["info_tache"] 	= Sql_prepareTexteAffichage($row['info_tache']);
		}
	}

	if (count($tab_result) == 1 && ($args['id_tache'] != '' && $args['id_tache'] != '*')) 
		$tab_result = array_pop($tab_result);
	if (count($tab_result) == 1 && $args['code'] != '' && $args['lang'] != '') 
		$tab_result = array_pop($tab_result);

	return $tab_result;
}

function Tache_suivant($code_news, $position, $lang) {
	$id_suivant = 0;
	$sql = " SELECT id_tache
				FROM ".$GLOBALS['prefix']."new
				WHERE code_news = '{$code_news}'
				AND lang = '{$lang}'
				AND position > {$position}
				AND etat != 'supprime' ".$cond_concours."
				ORDER BY position DESC
				LIMIT 0, 1";

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		return $row['id_tache'];
	}
	return $id_suivant;
}

function Tache_precedent($code_news, $position, $lang) {
	$id_precedent = 0;
	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."new
				WHERE code_news = '{$code_news}'
				AND lang = '{$lang}'
				AND position < {$position}
				AND etat != 'supprime' ".$cond_concours."
				ORDER BY position ASC
				LIMIT 0, 1";

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		return $row['id_tache'];
	}
	return $id_precedent;
}
} // Fin if (!defined('__TACHE_INC__')){
?>
