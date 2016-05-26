<?
/** @file
 *  @ingroup group3
 *  @brief this file in Arbo
*/

/**
 * Classe pour la gestion de l'arborescence des catégories et des taches
 *
 * @author		dilasoft
 * @version	1.0
 * @code
	CREATE TABLE foeven_arbos (
	id_arbo int(11) NOT NULL auto_increment,
	famille int(11) NOT NULL default '0',
	id_pere varchar(255) NOT NULL default '',
	type_pere varchar(255) NOT NULL default '',
	etat enum
	ordre ordre NOT NULL default '0000-00-00',
	arbo varchar(255) NOT NULL default '',
	annexe1 varchar(255) NOT NULL default '',
	annexe2 varchar(255) NOT NULL default '',
	annexe3 varchar(255) NOT NULL default '',
	annexe4 varchar(255) NOT NULL default '',
	date_add varchar(255) NOT NULL default '',
	date_upd varchar(255) NOT NULL default '',
	intitule varchar(255) NOT NULL default '',
	PRIMARY KEY  (id_arbo)
	) TYPE=MyISAM;
 * @endcode
 * 
 */
if (!defined('__ARBO_INC__')){
define('__ARBO_INC__', 1);

class Arbo extends Element {
	var $id_arbo;
	var $id_arbo_pere;
	var $code_arbo;
	var $famille;
	var $id_pere;
	var $type_pere;
	var $etat;
	var $ordre;
	var $date_add;
	var $date_upd;
	var $intitule;
	var $intitule_canonize;
	var $couleur;

	/**
	Cette fonction est un grand switch qui sert à renvoyer vers une action donnée en paramètre. 
	@param id_pere_arbo : type_perearbo de l'arbo
	@param ordre : ordre de création de l'arbo
	@param id_pere : id_pere, annexe1 de l'arbo
	@param type_pere : Corps de arbo
	*/
	function Arbo()
	{
		$this->type_pere_moi = "arbo";
	}

		/**
	Cette fonction retourne un tableau correspondant aux différents attributs de l'arbo.
	*/
	function getTab() 
	{
		$tab['id_arbo']				= $this->id_arbo;
		$tab['id_arbo_pere']			= $this->id_arbo_pere;
		$tab['code_arbo']				= $this->code_arbo;
		$tab['famille']				= $this->famille;
		$tab['id_pere']				= $this->id_pere;
		$tab['type_pere']				= $this->type_pere;
		$tab['etat']					= $this->etat;
		$tab['ordre']					= $this->ordre;
		$tab['date_add']				= $this->date_add;
		$tab['date_upd']				= $this->date_upd;
		$tab['intitule']				= $this->intitule;
		$tab['intitule_canonize']	= $this->intitule_canonize;
		$tab['couleur'] 				= $this->couleur;
		return $tab;
	}
	
	/**
	Cette fonction ajoute un arbo à la BDD.
	*/
	function ADD()
	{
		$id_arbo_pere			= $this->id_arbo_pere;
		$famille					= $this->famille; 
		$code_arbo				= $this->code_arbo; 
		$id_pere					= $this->id_pere;
		$type_pere				= $this->type_pere;
		$etat						= $this->etat;
		$ordre					= $this->ordre;
		$date_add				= time();
		$intitule				= Sql_prepareTexteStockage($this->intitule);
		$intitule_canonize	= Lib_canonizeMin(Sql_prepareTexteStockage($this->intitule));
		$couleur					= $this->couleur;

		$sql = " INSERT INTO ".$GLOBALS['prefix']."arbo
					(id_arbo_pere, code_arbo, famille, id_pere, 
					type_pere, etat,
					ordre, date_add, 
					intitule, intitule_canonize, 
					couleur)
					VALUES('$id_arbo_pere', '$code_arbo', '$famille', '$id_pere', 
							'$type_pere', '$etat', 
							'$ordre', '$date_add',
							'$intitule', '$intitule_canonize', 
							'$couleur')";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		if (!$this->isError()) {
			$id_arbo = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_arbo");
			$this->id_arbo = $id_arbo;
			return $id_arbo;
		}

		return;
	}

	/**
	Cette fonction met à jour un arbo sur la BDD.
	*/
	function UPD() 
	{
		if ($this->isError()) return;

		$id_arbo					= $this->id_arbo;
		$id_arbo_pere			= $this->id_arbo_pere;
		$code_arbo				= $this->code_arbo;
		$famille					= $this->famille;
		$id_pere					= $this->id_pere;
		$type_pere				= $this->type_pere;
		$etat						= $this->etat;
		$ordre					= $this->ordre;
		$date_upd				= time();
 		$intitule 				=	Sql_prepareTexteStockage($this->intitule);
 		$intitule_canonize	=	Lib_canonizeMin(Sql_prepareTexteStockage($this->intitule));
		$couleur					= $this->couleur;

		// Mise à jour de la base
		$sql = " UPDATE ".$GLOBALS['prefix']."arbo
					SET id_arbo_pere = '$id_arbo_pere', code_arbo = '$code_arbo', 
						famille = '$famille', id_pere = '$id_pere', 
						type_pere = '$type_pere', etat = '$etat',
						ordre = '$ordre', date_upd = '$date_upd',
						intitule = '$intitule', intitule_canonize = '$intitule_canonize',
						couleur = '$couleur'
					WHERE id_arbo = $id_arbo";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);

		return;
	}
	/**
	Cette fonction supprime un arbo de la BDD.
	*/
	function DEL() 
	{
		if ($this->isError()) return;

		$id_arbo = $this->id_arbo;

		$sql = " DELETE FROM ".$GLOBALS['prefix']."arbo
					WHERE id_arbo = $id_arbo";

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
		$str = Lib_addElem($str, $this->id_arbo);
		$str = Lib_addElem($str, $this->id_arbo_pere);
		$str = Lib_addElem($str, $this->code_arbo);
		$str = Lib_addElem($str, $this->famille);
		$str = Lib_addElem($str, $this->id_pere);
		$str = Lib_addElem($str, $this->type_pere);
		$str = Lib_addElem($str, $this->etat);
		$str = Lib_addElem($str, $this->ordre);
		$str = Lib_addElem($str, $this->date_add);
		$str = Lib_addElem($str, $this->date_upd);
		$str = Lib_addElem($str, $this->intitule);
		$str = Lib_addElem($str, $this->intitule_canonize);
		$str = Lib_addElem($str, $this->couleur);
		$str = "(".$str.")";
		return $str;
	}
}

/**
 Recupère toutes les données relatives à un arbo suivant son identifiant
 et retourne la coquille "arbo" remplie avec les informations récupérées
 de la base.
 @param id_arbo: Identifiant du arbo à récupérer
*/
function Arbo_recuperer($id_arbo) {

	$arbo = new Arbo();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."arbo
			WHERE id_arbo = $id_arbo";

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$arbo->id_arbo					= $row['id_arbo'];
		$arbo->id_arbo_pere			= $row['id_arbo_pere'];
		$arbo->code_arbo				= $row['code_arbo'];
		$arbo->famille					= $row['famille'];
		$arbo->id_pere					= $row['id_pere'];
		$arbo->type_pere				= $row['type_pere'];
		$arbo->etat						= $row['etat'];
		$arbo->ordre					= $row['ordre'];
		$arbo->date_add				= $row['date_add'];
		$arbo->date_upd				= $row['date_upd'];
		$arbo->intitule				= Sql_prepareTexteAffichage($row['intitule']);
		$arbo->intitule_canonize	= $row['intitule_canonize'];
		$arbo->couleur					= $row['couleur'];
	}
	
	return $arbo;
}
function Arbo_recuperer_par_ordre($famille, $ordre, $code_arbo = '') {

	$arbo = new Arbo();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."arbo
			WHERE code_arbo = '$code_arbo'
			AND famille = '$famille' 
			AND ordre = $ordre";

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$arbo->id_arbo					= $row['id_arbo'];
		$arbo->id_arbo_pere			= $row['id_arbo_pere'];
		$arbo->famille					= $row['famille'];
		$arbo->code_arbo				= $row['code_arbo'];
		$arbo->id_pere					= $row['id_pere'];
		$arbo->type_pere				= $row['type_pere'];
		$arbo->etat						= $row['etat'];
		$arbo->ordre					= $row['ordre'];
		$arbo->date_add				= $row['date_add'];
		$arbo->date_upd				= $row['date_upd'];
		$arbo->intitule 				= Sql_prepareTexteAffichage($row['intitule']);
		$arbo->intitule_canonize	= $row['intitule_canonize'];
		$arbo->couleur					= $row['couleur'];
	}
	
	return $arbo;
}
function Arbo_recuperer_par_element($id_pere, $type_pere, $code_arbo = '') {

	$arbo = new Arbo();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."arbo
			WHERE code_arbo = '$code_arbo'
			AND id_pere = $id_pere 
			AND type_pere = '$type_pere'";

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$arbo->id_arbo					= $row['id_arbo'];
		$arbo->id_arbo_pere			= $row['id_arbo_pere'];
		$arbo->code_arbo				= $row['code_arbo'];
		$arbo->famille					= $row['famille'];
		$arbo->id_pere					= $row['id_pere'];
		$arbo->type_pere				= $row['type_pere'];
		$arbo->etat						= $row['etat'];
		$arbo->ordre					= $row['ordre'];
		$arbo->date_add				= $row['date_add'];
		$arbo->date_upd				= $row['date_upd'];
		$arbo->intitule				= Sql_prepareTexteAffichage($row['intitule']);
		$arbo->intitule_canonize	= $row['intitule_canonize'];
		$arbo->couleur					= $row['couleur'];
	}
	
	return $arbo;
}
/**
 Renvoie le id_pere, le préid_pere et l'identifiant des personnes ayant les données passées en argument sous forme d'un tableau
 @param id_arbo
 @param id_perePersonne
 @param type_perePersonne
 ...
*/
function Arbos_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
			FROM ".$GLOBALS['prefix']."arbo
			WHERE 1";

	if (!isset($args['id_arbo']) && !isset($args['id_arbo_pere']) && !isset($args['not_id_arbo_pere']) && 
		!isset($args['famille']) && !isset($args['code_arbo']) && 
		!isset($args['id_pere']) && !isset($args['type_pere']) && 
		!isset($args['etat']) && !isset($args['ordre']) && !isset($args['intitule'])) 
		return $tab_result;

	$condition="";

	if (isset($args['id_arbo']) && $args['id_arbo'] != "*") 
		$condition .= " AND id_arbo = ".$args['id_arbo']." ";
	if (isset($args['id_arbo_pere'])) 
		$condition .= " AND id_arbo_pere = ".$args['id_arbo_pere']." ";
	if (isset($args['not_id_arbo_pere'])) 
		$condition .= " AND id_arbo_pere != ".$args['not_id_arbo_pere']." ";
	if (isset($args['intitule']))
		$condition .= " AND intitule LIKE '".$args['intitule']."' ";
	if (isset($args['code_arbo'])) 
		$condition .= " AND code_arbo LIKE '".$args['code_arbo']."' ";
	if (isset($args['famille'])) 
		$condition .= " AND famille LIKE '".$args['famille']."' ";
	if (isset($args['id_pere'])) 
		$condition .= " AND id_pere = '".$args['id_pere']."' ";
	if (isset($args['ordre'])) 
		$condition .= " AND ordre = '".$args['ordre']."' ";
	if (isset($args['etat'])) 
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['sup_ordre']) && $args['sup_ordre'] != "*") 
		$condition .= " AND ordre > '".$args['sup_ordre']."' ";
	
	if (isset($args['type_pere']) && $args['type_pere'] != "*") 
		$condition .= " AND type_pere LIKE '".Sql_prepareTexteStockage($args['type_pere'])."' ";
		
	$sql .= $condition;
	if (isset($args['order_by']))
		$sql .= " ORDER BY '".$args['order_by']."' ASC";
	else
		$sql .= " ORDER BY ordre ASC";
	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_arbo'];
			$tab_result[$id]["id_arbo"]				= $id;
			$tab_result[$id]["id_arbo_pere"]			= $row['id_arbo_pere'];
			$tab_result[$id]["code_arbo"]				= $row['code_arbo'];
			$tab_result[$id]["famille"]				= $row['famille'];
			$tab_result[$id]["id_pere"]				= $row['id_pere'];
			$tab_result[$id]["type_pere"]				= $row['type_pere'];
			$tab_result[$id]["etat"]					= $row['etat'];
			$tab_result[$id]["ordre"]					= $row['ordre'];
			$tab_result[$id]["date_add"]				= $row['date_add'];
			$tab_result[$id]["date_upd"]				= $row['date_upd'];
			$tab_result[$id]["intitule"]				= Sql_prepareTexteAffichage($row['intitule']);
			$tab_result[$id]["intitule_canonize"]	= $row['intitule_canonize'];
			$tab_result[$id]["couleur"]				= $row['couleur'];
		}
	}

	if (count($tab_result) == 1 && ($args['id_arbo'] != '' && $args['id_arbo'] != '*')) 
		$tab_result = array_pop($tab_result);	

	return $tab_result;
}

function Arbo_getTab($tab_sql, $niveau, $famille) {
	/*=============*/ Lib_myLog("Appel de Arbo_getTab avec niveau=[$niveau] et famille=[$famille]");
	$tab_result = array();
	$tab_sql2 = $tab_sql;

	foreach ($tab_sql as $sql) {
		if ($sql['niveau'] == $niveau && $sql['famille'] == $famille) {
			$tab_result[$sql['ordre']] = $sql;
			$tab_result[$sql['ordre']]['liste_fils'] = Arbo_getTab($tab_sql2, $niveau+1, $sql['famille'].$sql['id_arbo'].'-');
		}
	}

	return $tab_result;
}

// Fonction de construction de l'arborescence.
// Celle-ci se présentera sous la forme:
/*
array (
	"1" => array (
			"id_arbo" => 1,
			"famille" => '1-',
			"id_pere" => 1,
			"type_pere" => 'page',
			"intitule" => 'bla bla',
			"liste_fils" => array (
				"id_arbo" => 1,
				"famille" => '1-',
				"id_pere" => 1,
				"type_pere" => 'page',
				"intitule" => 'bla bla',
				"liste_fils" => 
			)
		)
	"1" => array (
			"id_arbo" => 1,
			"famille" => '1-',
			"id_pere" => 1,
			"type_pere" => 'page',
			"intitule" => 'bla bla',
			"liste_fils" => array ()
		)
)
*/
// On récupère en une seule fois la table pour ne pas effectuer n requêtes SQL
function Arbo_construire($code_arbo = '', $type = 'article') {
	/*=============*/ Lib_myLog("Recuperation de l'arbo a partir de la BDD");

	if($type == 'tache'){
	    // On récupère tous les taches de la base
	    $args_taches['id_tache'] = '*';
	    $liste_taches = Taches_chercher($args_taches);
	    $tab_intitules = array();
	    foreach($liste_taches as $tache) {
		    $tab_intitules[$tache['id_tache']] = $tache['titre'];
		    $tab_etats[$tache['id_tache']] = $tache['etat'];
		    $tab_priorites[$tache['id_tache']] = $tache['data1'];
	    }
	}
	if($type == 'article'){
	    // On récupère tous les articles de la base
	    $args_articles['id_article'] = '*';
	    $liste_articles = Articles_chercher($args_articles);

	    $tab_intitules = array();
	    $tab_urls = array();
	    foreach($liste_articles as $article) {
		    $tab_intitules[$article['id_article']] = $article['titre'];
		    $tab_etats[$article['id_article']] = $article['etat'];
		    $tab_urls[$article['id_article']] = $article['meta_url'];
	    }
	}

	$sql = " SELECT * 
			FROM ".$GLOBALS['prefix']."arbo
			WHERE code_arbo = '{$code_arbo}'
			ORDER BY famille ASC, ordre ASC";

	$result = Sql_query($sql);

	$tab_sql = array();
	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_arbo'];
			$id_pere = $row['id_pere'];
			$type_pere = $row['type_pere'];

			$tab_sql[$id]["id_arbo"]	= $id;
			$tab_sql[$id]["id_arbo_pere"]	= $row['id_arbo_pere'];
			$tab_sql[$id]["code_arbo"]	= $row['code_arbo'];
			$tab_sql[$id]["famille"]	= $row['famille'];
			$tab_sql[$id]["id_pere"]	= $id_pere;
			if($type == 'tache')
			    $tab_sql[$id]["tache"]	= $liste_taches[$id_pere];
			if($type == 'article')
			    $tab_sql[$id]["article"]	= $liste_articles[$id_pere];
			$tab_sql[$id]["type_pere"]	= $type_pere;
			$tab_sql[$id]["ordre"]		= $row['ordre'];
			$tab_sql[$id]["couleur"]	= $row['couleur'];
			$tab_sql[$id]["etat"]		= (($type_pere == 'article' || $type_pere == 'tache') && isset($tab_etats[$id_pere]) && $tab_etats[$id_pere] != '') ?
												$tab_etats[$id_pere] : 
												$row['etat'];
			$tab_sql[$id]["intitule"]	= (($type_pere == 'article' || $type_pere == 'tache') && isset($tab_intitules[$id_pere]) && $tab_intitules[$id_pere] != '') ?
												$tab_intitules[$id_pere] : 
												Sql_prepareTexteAffichage($row['intitule']);
			$tab_sql[$id]["intitule_canonize"] = $row['intitule_canonize'];
			$tab_sql[$id]["priorite"] = ($type_pere == 'tache' && isset($tab_priorites[$id_pere]) && $tab_priorites[$id_pere] != '') ?
												$tab_priorites[$id_pere] : '';
			if($type_pere == 'tache' && isset($tab_etats[$id_pere]) && $tab_etats[$id_pere] == 'inactif'){
			    if($row['famille'] != '' && $row['id_arbo_pere'] == 0){
				$tab_famille = explode('-', $row['famille']);
				$index_pere = count($tab_famille)-2;
				$tab_sql[$tab_famille[$index_pere]]['nb_taches_a_faire']++;
				if(!empty($tab_famille[$index_pere-1]))
				    $tab_sql[$tab_famille[$index_pere-1]]['nb_taches_a_faire']++;
			    }else{
				$tab_sql[$id]['nb_taches_a_faire'] = 0;
			    }
			}
			if($type_pere == 'tache' && isset($tab_etats[$id_pere]) && $tab_etats[$id_pere] == 'actif'){
			    if($row['famille'] != '' && $row['id_arbo_pere'] == 0){
				$tab_famille = explode('-', $row['famille']);
				$index_pere = count($tab_famille)-2;
				$tab_sql[$tab_famille[$index_pere]]['nb_taches_terminees']++;
				if(!empty($tab_famille[$index_pere-1]))
				    $tab_sql[$tab_famille[$index_pere-1]]['nb_taches_terminees']++;
			    }else{
				$tab_sql[$id]['nb_taches_terminees'] = 0;
			    }
			}

			// On détermine le niveau de profondeur dans l'arborescence
			$tab_sql[$id]["niveau"]		= substr_count($row['famille'], "-");
		}
	}

	/*=============*/ Lib_myLog("Tab sql:", $tab_sql);
	/*=============*/ Lib_myLog("Construction de l'arbo");
	$tab_result = Arbo_getTab($tab_sql, 0, '');
	return $tab_result;
}

function Arbo_recalcul($liste_elements, $id = '', $famille = ''){
	if(!empty($liste_elements)){
		$i = 1;
		if($id != '')
			$famille .= $id.'-';
		foreach($liste_elements as $element){
			$id_pere = $element['id'];
			$element_upd = Arbo_recuperer($element['id']);
			if($element_upd->id_arbo_pere != 0)
				$element_upd->id_arbo_pere = $id != '' ? $id : $id_pere;
			$element_upd->famille = $famille;
			$element_upd->ordre = $i;
			$element_upd->UPD();
			$i++;
			Arbo_recalcul($element['children'], $id_pere, $famille);
		}
	}
}

function Arbo_zipDocuments($code_arbo = 'arbo_docs', $tab_ids_arbos = array()){
	/*=============*/ Lib_myLog("On zip les documents", $tab_ids_arbos);
	$arbos_modification = Arbos_chercher(array('tab_ids_arbos'=>$tab_ids_arbos));
	$tab_ids_niv1 = array();
	$tab_ids_niv2 = array();
	foreach($arbos_modification as $arbo_modif){
	    if($arbo_modif['id_arbo_pere']){
		$tab_ids_niv1[$arbo_modif['id_arbo_pere']] = $arbo_modif['id_arbo_pere'];
	    }else{
		$tab_famille = explode('-',$arbo_modif['famille']);
		$tab_ids_niv1[$tab_famille[0]] = $tab_famille[0];
		$tab_ids_niv2[$tab_famille[1]] = $tab_famille[1];
	    }
	}
	$arbo_docs = Arbo_construire($code_arbo);
	foreach($arbo_docs as $elem){
		if(!in_array($elem['id_arbo'], $tab_ids_niv1)) continue;
		$tab_files = array();
		foreach($elem['liste_fils'] as $elem1){
			if(!in_array($elem1['id_arbo'], $tab_ids_niv2)) continue;
			foreach($elem1['liste_fils'] as $elem2){
				$tab_files[$elem2['tache']['url_vignette']] = $elem2['tache']['url_vignette'];
				$dir2 = Lib_cleanDirName($elem2['intitule']).'/';
				foreach($elem2['liste_fils'] as $elem3){
					$tab_files[$dir2.$elem3['tache']['url_vignette']] = $elem3['tache']['url_vignette'];
				}
				Lib_zipDirectory(Lib_cleanTxt($elem1['intitule']), 1, '.zip', $tab_files); //ZIP du deuxieme niveau
			}
		}
		if(count($elem1['liste_fils']) == 0)
			Lib_zipDirectory(Lib_cleanTxt($elem['intitule']), 1, '.zip', $tab_files); //ZIP du premier niveau
	}
}

} // Fin if (!defined('__ARBO_INC__')){
?>