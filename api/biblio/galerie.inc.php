<?
/** @file
 *  @ingroup group3                           
 *  @brief this file in Mobilier_Images
*/

/**
 * Classe pour la gestion des objets de type Galerie d'images
 *
 * @author      dilasoft
 * @url_vignette     1.0
 * @code_pere    
	CREATE TABLE `_galeries` (
	`id_galerie` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`id_pere` INT(11) NOT NULL, 
	`type_pere` VARCHAR(64) NOT NULL, 
	`position` INT NOT NULL, 
	`url_vignette` VARCHAR(255) NOT NULL, 
	`url_gde_image` VARCHAR(255) NOT NULL, 
	`info_galerie` VARCHAR(64) NOT NULL
	); 

	CREATE TABLE _galeries_lang (
		`id_galerie` INT NOT NULL ,
		`lang` VARCHAR( 4 ) NOT NULL ,
		`data1` TEXT NOT NULL,
		`data2` TEXT NOT NULL,
		`data3` TEXT NOT NULL,
		`data4` TEXT NOT NULL,
		`data5` TEXT NOT NULL,
		`legende` TEXT NOT NULL 
	);

 * @endcode_pere
 * 
 */
if (!defined('__GALERIE_INC__')){
define('__GALERIE_INC__', 1);

class Galerie extends Element {
	var $id_galerie;
	var $id_pere;
	var $type_pere;
	var $position;
	var $url_vignette;
	var $url_gde_image;
	var $largeur_vignette;
	var $hauteur_vignette;
	var $info_galerie;
	var $code_pere;
   var $versions;

	/**
	*/
	function Galerie($code_pere = '', $type_pere = '')
	{
		$this->code_pere		= $code_pere;
		$this->type_pere	= $type_pere;
		$this->type_moi	= "galerie";
		$this->versions	= array();
	}

		/**
	Cette fonction retourne un tableau correspondant aux différents attributs de l'objet Galerie
	*/
	function getTab() 
	{
		 $tab['id_galerie']			= $this->id_galerie;
		 $tab['id_pere']				= $this->id_pere;
		 $tab['code_pere']			= $this->code_pere;
		 $tab['type_pere']			= $this->type_pere;
		 $tab['position']				= $this->position;
		 $tab['url_vignette']		= $this->url_vignette;
		 $tab['url_gde_image']		= $this->url_gde_image;
		 $tab['largeur_vignette']	= $this->largeur_vignette;
		 $tab['hauteur_vignette']	= $this->hauteur_vignette;
		 $tab['info_galerie']		= $this->info_galerie;

		foreach($this->versions as $lang => $legende) {
			$tab['versions'][$lang]['legende'] = $legende; 
			$tab['versions'][$lang]['data1'] = $legende; 
			$tab['versions'][$lang]['data2'] = $legende;
			$tab['versions'][$lang]['data3'] = $legende;
			$tab['versions'][$lang]['data4'] = $legende;
			$tab['versions'][$lang]['data5'] = $legende;
		}

		 return $tab;
	}

	 /**
	Cette fonction ajoute une image à la BDD.
	*/
	 function ADD()
	 {
		 $id_pere			= $this->id_pere;
		 $type_pere			= $this->type_pere;
		 $code_pere			= $this->code_pere;
		 $position			= $this->position;
		 $url_vignette		= $this->url_vignette;
		 $url_gde_image	= $this->url_gde_image;
		 $largeur_vignette= $this->largeur_vignette;
		 $hauteur_vignette= $this->hauteur_vignette;
		 $info_galerie		= $this->info_galerie;

		 $sql = " INSERT INTO ".$GLOBALS['prefix']."galeries
					 (id_pere, type_pere, 
					 position, code_pere, url_vignette, 
					 url_gde_image, largeur_vignette, hauteur_vignette, info_galerie)
					 VALUES('$id_pere', '$type_pere', 
							'$position', '$code_pere', '$url_vignette', 
							'$url_gde_image', '$largeur_vignette', '$hauteur_vignette', '$info_galerie')";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		 if (!$this->isError()) {
			  $id_galerie = Sql_lastInsertId();
			  Lib_sqlLog($sql." -- $id_galerie");
			  $this->id_galerie = $id_galerie;
			  return $id_galerie;
		 }

		 // Inscription des modules dans la base        
		 foreach ($this->versions as $lang => $doc) {
			$legende = Sql_prepareTexteStockage($doc['legende']);
			$data1 = Sql_prepareTexteStockage($doc['data1']);
			$data2 = Sql_prepareTexteStockage($doc['data2']);
			$data3 = Sql_prepareTexteStockage($doc['data3']);
			$data4 = Sql_prepareTexteStockage($doc['data4']);
			$data5 = Sql_prepareTexteStockage($doc['data5']);
			 $sql = " INSERT INTO ".$GLOBALS['prefix']."galeries_lang
					 (id_galerie, lang, legende, data1, data2, data3, data4, data5)
					 VALUES($id_galerie, '{$lang}', '{$legende}', '{$data1}', '{$data2}', '{$data3}', '{$data4}', '{$data5}')";

			 Sql_exec($sql); 
			 Lib_sqlLog($sql);
		 }

		 return;
	 }

	 /**
	Cette fonction met à jour l'objet Galerie dans la BDD.
	*/
	 function UPD() 
	 {
		if ($this->isError()) return;

		 $id_galerie		= $this->id_galerie;
		 $id_pere			= $this->id_pere;
		 $type_pere			= $this->type_pere;
		 $code_pere			= $this->code_pere;
		 $position			= $this->position;
		 $url_vignette		= $this->url_vignette;
		 $url_gde_image	= $this->url_gde_image;
		 $largeur_vignette= $this->largeur_vignette;
		 $hauteur_vignette= $this->hauteur_vignette;
		 $info_galerie		= $this->info_galerie;

		 // Mise à jour de la base
		 $sql = " UPDATE ".$GLOBALS['prefix']."galeries
					 SET largeur_vignette = $largeur_vignette, hauteur_vignette = $hauteur_vignette, id_pere = $id_pere, type_pere = '$type_pere', code_pere = '$code_pere',
						position = '$position', url_vignette = '$url_vignette', 
						url_gde_image = '$url_gde_image', info_galerie = '$info_galerie'
					 WHERE id_galerie = $id_galerie";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);

		 // Mise à jour de la base pour les langues de la galerie
		 // Tout d'abord, on supprime les anciennes langues
		 $sql = " DELETE FROM ".$GLOBALS['prefix']."galeries_lang
					 WHERE id_galerie = $id_galerie";

		 Sql_exec($sql); 
		 Lib_sqlLog($sql);

		 // Puis on insère les nouvelles langues
		 foreach($this->versions as $lang => $doc) {
			$legende = Sql_prepareTexteStockage($doc['legende']);
			$data1 = Sql_prepareTexteStockage($doc['data1']);
			$data2 = Sql_prepareTexteStockage($doc['data2']);
			$data3 = Sql_prepareTexteStockage($doc['data3']);
			$data4 = Sql_prepareTexteStockage($doc['data4']);
			$data5 = Sql_prepareTexteStockage($doc['data5']);
			 $sql = "INSERT INTO ".$GLOBALS['prefix']."galeries_lang
						(id_galerie, lang, legende, data1, data2, data3, data4, data5)
						VALUES($id_galerie, '{$lang}', '{$legende}', '{$data1}', '{$data2}', '{$data3}', '{$data4}', '{$data5}')";

			 Sql_exec($sql); 
			 Lib_sqlLog($sql);
		 }

		 return;
	}
	 /**
	Cette fonction supprime un objet Galerie de la BDD.
	*/
	 function DEL() 
	 {
		 if ($this->isError()) return;

		 $id_galerie = $this->id_galerie;

		 $sql = " DELETE FROM ".$GLOBALS['prefix']."galeries
					 WHERE id_galerie = $id_galerie";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
		if (!$this->isError()) Lib_sqlLog($sql);

		 $sql = " DELETE FROM ".$GLOBALS['prefix']."galeries_lang
					 WHERE id_galerie = $id_galerie";

		 Sql_exec($sql); 
		 Lib_sqlLog($sql);

		 return;
	 }

	 function addLang($new_lang, $new_legende = '', $new_data1 = '', $new_data2 = '', $new_data3 = '', $new_data4 = '', $new_data5 = '')
	 {
		 $ajouter = true;
		 foreach($this->versions as $lang => $doc)
			 if ($lang == $new_lang) $ajouter = false;

		if ($ajouter) {
			$this->versions[$new_lang]['legende'] = $new_legende;
			$this->versions[$new_lang]['data1'] = $new_data1;
			$this->versions[$new_lang]['data2'] = $new_data2;
			$this->versions[$new_lang]['data3'] = $new_data3;
			$this->versions[$new_lang]['data4'] = $new_data4;
			$this->versions[$new_lang]['data5'] = $new_data5;
		}
	 }

	 function delLang($lang_to_del)
	 {
		 $old_versions = $this->versions;
		 $this->versions = array();

		 foreach ($old_versions as $lang => $doc) {
			 if ($lang == $lang_to_del) continue;
			 $this->versions[$lang]['legende'] = $doc['legende']; 
			 $this->versions[$lang]['data1'] = $doc['data1']; 
			 $this->versions[$lang]['data2'] = $doc['data2']; 
			 $this->versions[$lang]['data3'] = $doc['data3']; 
			 $this->versions[$lang]['data4'] = $doc['data4']; 
			 $this->versions[$lang]['data5'] = $doc['data5']; 
		 }
	 }

	 /**
	Cette fonction transforme les attributs en chaine de caractères.
	*/
	 function toStr()
	 {
		  $str = "";
		  $str = Lib_addElem($str, $this->id_galerie);
		  $str = Lib_addElem($str, $this->id_pere);
		  $str = Lib_addElem($str, $this->type_pere);
		  $str = Lib_addElem($str, $this->position);
		  $str = Lib_addElem($str, $this->url_vignette);
		  $str = Lib_addElem($str, $this->url_gde_image);
		  $str = Lib_addElem($str, $this->info_galerie);
		  $str = "(".$str.")";
		  return $str;
	 }
}

/**
 Recupère toutes les données relatives à une galerie suivant son identifiant
 et retourne la coquille "Galerie" remplie avec les informations récupérées
 de la base.
 @param id_galerie: Identifiant de la galerie à récupérer
*/
function Galerie_recuperer($id_galerie = '', $code_pere = '', $type_pere = '') {

	$galerie = new Galerie();

	if ($id_galerie != '') {
		$sql = "SELECT *
				  FROM ".$GLOBALS['prefix']."galeries
				  WHERE id_galerie = $id_galerie";
	}
	if ($code_pere != '' && $type_pere != '') {
		$sql = "SELECT *
				  FROM ".$GLOBALS['prefix']."galeries
				  WHERE code_pere = $code_pere
				  AND type_pere = '$type_pere'";
	}

	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);

		$galerie->id_galerie 		= $row['id_galerie'];
		$galerie->code_pere			= $row['code_pere'];
		$galerie->id_pere				= $row['id_pere'];
		$galerie->type_pere			= $row['type_pere'];
		$galerie->position			= $row['position'];
		$galerie->url_vignette		= $row['url_vignette'];
		$galerie->url_gde_image		= $row['url_gde_image'];
		$galerie->largeur_vignette	= $row['largeur_vignette'];
		$galerie->hauteur_vignette	= $row['hauteur_vignette'];
		$galerie->info_galerie 		= $row['info_galerie'];

		// On récupère ensuite les données de la table modules
		$sql2 = "SELECT *
				  FROM ".$GLOBALS['prefix']."galeries_lang
				  WHERE id_galerie = {$row['id_galerie']}";

		$result2 = Sql_query($sql2);

		if ($result2 && Sql_errorCode($result2) === "00000") {
			while($row2 = Sql_fetch($result2)) {
				$galerie->addLang($row2['lang'], Sql_prepareTexteAffichage($row2['legende']), Sql_prepareTexteAffichage($row2['data1']), Sql_prepareTexteAffichage($row2['data2'])
						, Sql_prepareTexteAffichage($row2['data3']), Sql_prepareTexteAffichage($row2['data4']), Sql_prepareTexteAffichage($row2['data5']));
			}
		}
	}

	return $galerie;
}

/**
 Renvoie le position, le préposition et l'identifiant des personnes ayant les données passées en argument sous forme d'un tableau
 @param id_mobilier_image
 @param positionPersonne
 @param url_gde_imagePersonne
 ...
*/
function Galeries_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
			 FROM ".$GLOBALS['prefix']."galeries
			 WHERE 1";

	if (!isset($args['id_galerie']) && !isset($args['id_pere']) &&
		 !isset($args['type_pere']) && !isset($args['position']) && 
		 !isset($args['order_by']) && !isset($args['code_pere'])) 
		 return $tab_result;

	$condition="";

	if (isset($args['id_galerie']) && $args['id_galerie'] != "*") 
		$condition .= " AND id_galerie = ".$args['id_galerie']." ";
	if (isset($args['id_pere']) && $args['id_pere'] != "*") 
		$condition .= " AND id_pere = '".$args['id_pere']."' ";
	if (isset($args['code_pere']) && $args['code_pere'] != "*")
		$condition .= " AND code_pere LIKE '".$args['code_pere']."' ";
	if (isset($args['type_pere']) && $args['type_pere'] != "*") 
		$condition .= " AND type_pere LIKE '".$args['type_pere']."' ";
	if (isset($args['position']) && $args['position'] != "*") 
		$condition .= " AND position = '".$args['position']."' ";
	$condition .= " ORDER BY position ASC ";
	$sql .= $condition;
	 
	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_galerie'];
			$tab_result[$id]["id_galerie"]		= $row['id_galerie'];
			$tab_result[$id]["id_pere"]			= $row['id_pere'];
			$tab_result[$id]["code_pere"]			= $row['code_pere'];
			$tab_result[$id]["type_pere"]			= $row['type_pere'];
			$tab_result[$id]["position"]			= $row['position'];
			$tab_result[$id]["url_vignette"]		= $row['url_vignette'];
			$tab_result[$id]["largeur_vignette"]= $row['largeur_vignette'];
			$tab_result[$id]["hauteur_vignette"]= $row['hauteur_vignette'];
			$tab_result[$id]["url_gde_image"]	= $row['url_gde_image'];
			$tab_result[$id]["info_galerie"]		= $row['info_galerie'];

			// On récupère ensuite les données de la table modules
			$sql2 = "SELECT *
					  FROM ".$GLOBALS['prefix']."galeries_lang
					  WHERE id_galerie = {$id}";

			$result2 = Sql_query($sql2);
			
			$tab_result[$id]['versions'][$row2['lang']] = array();
			if ($result2) {
				while($row2 = Sql_fetch($result2)) {
					$tab_result[$id]['versions'][$row2['lang']]['legende'] = Sql_prepareTexteAffichage($row2['legende']);
					$tab_result[$id]['versions'][$row2['lang']]['data1'] = Sql_prepareTexteAffichage($row2['data1']);
					$tab_result[$id]['versions'][$row2['lang']]['data2'] = Sql_prepareTexteAffichage($row2['data2']);
					$tab_result[$id]['versions'][$row2['lang']]['data3'] = Sql_prepareTexteAffichage($row2['data3']);
					$tab_result[$id]['versions'][$row2['lang']]['data4'] = Sql_prepareTexteAffichage($row2['data4']);
					$tab_result[$id]['versions'][$row2['lang']]['data5'] = Sql_prepareTexteAffichage($row2['data5']);
				}
			}
		}
	}

	return $tab_result;
}

} // Fin if (!defined('__GALERIE_INC__')){
?>
