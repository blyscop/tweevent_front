<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Saveurs
*/

/**
 * Classe pour la gestion de saveurs
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `vincent_saveur` (
	 `id_saveur` INT(11) NOT NULL auto_increment,
	 `pourcent_eth0_dans_arome_pur_1` DECIMAL(5,2) NOT NULL,
	 `pourcent_eth0_dans_arome_pur_2` DECIMAL(5,2) NOT NULL,
	 `pourcent_eth0_dans_arome_pur_3` DECIMAL(5,2) NOT NULL,
	 `pourcent_eth0_dans_arome_pur_4` DECIMAL(5,2) NOT NULL,
	 `pourcent_eth0_dans_arome_pur_5` DECIMAL(5,2) NOT NULL,
	 `pourcent_eth0_dans_arome_pur_6` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_1` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_2` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_3` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_4` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_5` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_pur_dans_arome_prod_6` DECIMAL(5,2) NOT NULL,
	 `pourcent_alcool_prod_dans_arome_prod` DECIMAL(5,2) NOT NULL,
	 `pourcent_eau_dans_arome_prod` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_prod_dans_e_liquide_1` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_prod_dans_e_liquide_2` DECIMAL(5,2) NOT NULL,
	 `pourcent_arome_prod_dans_e_liquide_3` DECIMAL(5,2) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_saveur` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_saveur`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : pourcent_eth0_dans_arome_pur_1
// Clef de recherche 2 : pourcent_eth0_dans_arome_pur_2
// Clef de recherche 3 : pourcent_eth0_dans_arome_pur_3
// Clef de recherche 4 : pourcent_eth0_dans_arome_pur_4
// Clef de recherche 5 : pourcent_eth0_dans_arome_pur_5
// Clef de recherche 6 : pourcent_eth0_dans_arome_pur_6
// Clef de recherche 7 : pourcent_arome_pur_dans_arome_prod_1
// Clef de recherche 8 : pourcent_arome_pur_dans_arome_prod_2
// Clef de recherche 9 : pourcent_arome_pur_dans_arome_prod_3
// Clef de recherche 10 : pourcent_arome_pur_dans_arome_prod_4
// Clef de recherche 11 : pourcent_arome_pur_dans_arome_prod_5
// Clef de recherche 12 : pourcent_arome_pur_dans_arome_prod_6
// Clef de recherche 13 : pourcent_alcool_prod_dans_arome_prod
// Clef de recherche 14 : pourcent_eau_dans_arome_prod
// Clef de recherche 15 : pourcent_arome_prod_dans_e_liquide_1
// Clef de recherche 16 : pourcent_arome_prod_dans_e_liquide_2
// Clef de recherche 17 : pourcent_arome_prod_dans_e_liquide_3
// Clef de recherche 18 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__SAVEUR_INC__')){
	define('__SAVEUR_INC__', 1);

class Saveur extends Element {
	var $id_saveur;
	var $pourcent_eth0_dans_arome_pur_1;
	var $pourcent_eth0_dans_arome_pur_2;
	var $pourcent_eth0_dans_arome_pur_3;
	var $pourcent_eth0_dans_arome_pur_4;
	var $pourcent_eth0_dans_arome_pur_5;
	var $pourcent_eth0_dans_arome_pur_6;
	var $pourcent_arome_pur_dans_arome_prod_1;
	var $pourcent_arome_pur_dans_arome_prod_2;
	var $pourcent_arome_pur_dans_arome_prod_3;
	var $pourcent_arome_pur_dans_arome_prod_4;
	var $pourcent_arome_pur_dans_arome_prod_5;
	var $pourcent_arome_pur_dans_arome_prod_6;
	var $pourcent_alcool_prod_dans_arome_prod;
	var $pourcent_eau_dans_arome_prod;
	var $pourcent_arome_prod_dans_e_liquide_1;
	var $pourcent_arome_prod_dans_e_liquide_2;
	var $pourcent_arome_prod_dans_e_liquide_3;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_saveur;

/** 
Constructeur de la classe.
*/
function Saveur()
{
	$this->type_moi = "saveurs";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Saveur.
*/
function getTab()
{
	$tab['id_saveur']										= $this->id_saveur;
	$tab['pourcent_eth0_dans_arome_pur_1']			= $this->pourcent_eth0_dans_arome_pur_1;
	$tab['pourcent_eth0_dans_arome_pur_2']			= $this->pourcent_eth0_dans_arome_pur_2;
	$tab['pourcent_eth0_dans_arome_pur_3']			= $this->pourcent_eth0_dans_arome_pur_3;
	$tab['pourcent_eth0_dans_arome_pur_4']			= $this->pourcent_eth0_dans_arome_pur_4;
	$tab['pourcent_eth0_dans_arome_pur_5']			= $this->pourcent_eth0_dans_arome_pur_5;
	$tab['pourcent_eth0_dans_arome_pur_6']			= $this->pourcent_eth0_dans_arome_pur_6;
	$tab['pourcent_arome_pur_dans_arome_prod_1']	= $this->pourcent_arome_pur_dans_arome_prod_1;
	$tab['pourcent_arome_pur_dans_arome_prod_2']	= $this->pourcent_arome_pur_dans_arome_prod_2;
	$tab['pourcent_arome_pur_dans_arome_prod_3']	= $this->pourcent_arome_pur_dans_arome_prod_3;
	$tab['pourcent_arome_pur_dans_arome_prod_4']	= $this->pourcent_arome_pur_dans_arome_prod_4;
	$tab['pourcent_arome_pur_dans_arome_prod_5']	= $this->pourcent_arome_pur_dans_arome_prod_5;
	$tab['pourcent_arome_pur_dans_arome_prod_6']	= $this->pourcent_arome_pur_dans_arome_prod_6;
	$tab['pourcent_alcool_prod_dans_arome_prod']	= $this->pourcent_alcool_prod_dans_arome_prod;
	$tab['pourcent_eau_dans_arome_prod']			= $this->pourcent_eau_dans_arome_prod;
	$tab['pourcent_arome_prod_dans_e_liquide_1']	= $this->pourcent_arome_prod_dans_e_liquide_1;
	$tab['pourcent_arome_prod_dans_e_liquide_2']	= $this->pourcent_arome_prod_dans_e_liquide_2;
	$tab['pourcent_arome_prod_dans_e_liquide_3']	= $this->pourcent_arome_prod_dans_e_liquide_3;
	$tab['etat']											= $this->etat;
	$tab['date_add']										= $this->date_add;
	$tab['date_upd']										= $this->date_upd;
	$tab['info_saveur']									= $this->info_saveur;
	return $tab;
}

/**
Cette fonction ajoute un element de la table saveur à la BDD. 
*/
function ADD()
{
	$pourcent_eth0_dans_arome_pur_1 			= strtr($this->pourcent_eth0_dans_arome_pur_1, ",", ".");
	$pourcent_eth0_dans_arome_pur_2 			= strtr($this->pourcent_eth0_dans_arome_pur_2, ",", ".");
	$pourcent_eth0_dans_arome_pur_3 			= strtr($this->pourcent_eth0_dans_arome_pur_3, ",", ".");
	$pourcent_eth0_dans_arome_pur_4 			= strtr($this->pourcent_eth0_dans_arome_pur_4, ",", ".");
	$pourcent_eth0_dans_arome_pur_5 			= strtr($this->pourcent_eth0_dans_arome_pur_5, ",", ".");
	$pourcent_eth0_dans_arome_pur_6 			= strtr($this->pourcent_eth0_dans_arome_pur_6, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_1 	= strtr($this->pourcent_arome_pur_dans_arome_prod_1, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_2 	= strtr($this->pourcent_arome_pur_dans_arome_prod_2, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_3 	= strtr($this->pourcent_arome_pur_dans_arome_prod_3, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_4 	= strtr($this->pourcent_arome_pur_dans_arome_prod_4, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_5 	= strtr($this->pourcent_arome_pur_dans_arome_prod_5, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_6 	= strtr($this->pourcent_arome_pur_dans_arome_prod_6, ",", ".");
	$pourcent_alcool_prod_dans_arome_prod 	= strtr($this->pourcent_alcool_prod_dans_arome_prod, ",", ".");
	$pourcent_eau_dans_arome_prod 			= strtr($this->pourcent_eau_dans_arome_prod, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_1 	= strtr($this->pourcent_arome_prod_dans_e_liquide_1, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_2 	= strtr($this->pourcent_arome_prod_dans_e_liquide_2, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_3 	= strtr($this->pourcent_arome_prod_dans_e_liquide_3, ",", ".");
	$etat 											= $this->etat != '' ? $this->etat : 'actif';
	$date_add 										= time();
	$info_saveur 									= Sql_prepareTexteStockage($this->info_saveur);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."saveur
					(pourcent_eth0_dans_arome_pur_1, pourcent_eth0_dans_arome_pur_2, pourcent_eth0_dans_arome_pur_3, 
					pourcent_eth0_dans_arome_pur_4, pourcent_eth0_dans_arome_pur_5, pourcent_eth0_dans_arome_pur_6, 
					pourcent_arome_pur_dans_arome_prod_1, pourcent_arome_pur_dans_arome_prod_2, pourcent_arome_pur_dans_arome_prod_3, 
					pourcent_arome_pur_dans_arome_prod_4, pourcent_arome_pur_dans_arome_prod_5, pourcent_arome_pur_dans_arome_prod_6, 
					pourcent_alcool_prod_dans_arome_prod, pourcent_eau_dans_arome_prod, pourcent_arome_prod_dans_e_liquide_1, 
					pourcent_arome_prod_dans_e_liquide_2, pourcent_arome_prod_dans_e_liquide_3, etat, 
					date_add, info_saveur
					)
				VALUES 
					 ('$pourcent_eth0_dans_arome_pur_1', '$pourcent_eth0_dans_arome_pur_2', '$pourcent_eth0_dans_arome_pur_3', 
					'$pourcent_eth0_dans_arome_pur_4', '$pourcent_eth0_dans_arome_pur_5', '$pourcent_eth0_dans_arome_pur_6', 
					'$pourcent_arome_pur_dans_arome_prod_1', '$pourcent_arome_pur_dans_arome_prod_2', '$pourcent_arome_pur_dans_arome_prod_3', 
					'$pourcent_arome_pur_dans_arome_prod_4', '$pourcent_arome_pur_dans_arome_prod_5', '$pourcent_arome_pur_dans_arome_prod_6', 
					'$pourcent_alcool_prod_dans_arome_prod', '$pourcent_eau_dans_arome_prod', '$pourcent_arome_prod_dans_e_liquide_1', 
					'$pourcent_arome_prod_dans_e_liquide_2', '$pourcent_arome_prod_dans_e_liquide_3', '$etat', 
					'$date_add', '$info_saveur'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_saveur = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_saveur");
		$this->id_saveur = $this->id_saveur;
		return $id_saveur;
	}
	return;
}

/**
Cette fonction modifie un élément de la table saveur dans la BDD. 
*/
function UPD()
{
	$id_saveur 										= is_numeric($this->id_saveur) ? $this->id_saveur : 0;
	$pourcent_eth0_dans_arome_pur_1 			= strtr($this->pourcent_eth0_dans_arome_pur_1, ",", ".");
	$pourcent_eth0_dans_arome_pur_2 			= strtr($this->pourcent_eth0_dans_arome_pur_2, ",", ".");
	$pourcent_eth0_dans_arome_pur_3 			= strtr($this->pourcent_eth0_dans_arome_pur_3, ",", ".");
	$pourcent_eth0_dans_arome_pur_4 			= strtr($this->pourcent_eth0_dans_arome_pur_4, ",", ".");
	$pourcent_eth0_dans_arome_pur_5 			= strtr($this->pourcent_eth0_dans_arome_pur_5, ",", ".");
	$pourcent_eth0_dans_arome_pur_6 			= strtr($this->pourcent_eth0_dans_arome_pur_6, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_1 	= strtr($this->pourcent_arome_pur_dans_arome_prod_1, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_2 	= strtr($this->pourcent_arome_pur_dans_arome_prod_2, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_3 	= strtr($this->pourcent_arome_pur_dans_arome_prod_3, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_4 	= strtr($this->pourcent_arome_pur_dans_arome_prod_4, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_5 	= strtr($this->pourcent_arome_pur_dans_arome_prod_5, ",", ".");
	$pourcent_arome_pur_dans_arome_prod_6 	= strtr($this->pourcent_arome_pur_dans_arome_prod_6, ",", ".");
	$pourcent_alcool_prod_dans_arome_prod 	= strtr($this->pourcent_alcool_prod_dans_arome_prod, ",", ".");
	$pourcent_eau_dans_arome_prod 			= strtr($this->pourcent_eau_dans_arome_prod, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_1 	= strtr($this->pourcent_arome_prod_dans_e_liquide_1, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_2 	= strtr($this->pourcent_arome_prod_dans_e_liquide_2, ",", ".");
	$pourcent_arome_prod_dans_e_liquide_3 	= strtr($this->pourcent_arome_prod_dans_e_liquide_3, ",", ".");
	$etat 											= $this->etat;
	$date_upd 										= time();
	$info_saveur 									= Sql_prepareTexteStockage($this->info_saveur);

	$sql = " UPDATE ".$GLOBALS['prefix']."saveur
				SET pourcent_eth0_dans_arome_pur_1 = '$pourcent_eth0_dans_arome_pur_1', pourcent_eth0_dans_arome_pur_2 = '$pourcent_eth0_dans_arome_pur_2', pourcent_eth0_dans_arome_pur_3 = '$pourcent_eth0_dans_arome_pur_3', 
					pourcent_eth0_dans_arome_pur_4 = '$pourcent_eth0_dans_arome_pur_4', pourcent_eth0_dans_arome_pur_5 = '$pourcent_eth0_dans_arome_pur_5', pourcent_eth0_dans_arome_pur_6 = '$pourcent_eth0_dans_arome_pur_6', 
					pourcent_arome_pur_dans_arome_prod_1 = '$pourcent_arome_pur_dans_arome_prod_1', pourcent_arome_pur_dans_arome_prod_2 = '$pourcent_arome_pur_dans_arome_prod_2', pourcent_arome_pur_dans_arome_prod_3 = '$pourcent_arome_pur_dans_arome_prod_3', 
					pourcent_arome_pur_dans_arome_prod_4 = '$pourcent_arome_pur_dans_arome_prod_4', pourcent_arome_pur_dans_arome_prod_5 = '$pourcent_arome_pur_dans_arome_prod_5', pourcent_arome_pur_dans_arome_prod_6 = '$pourcent_arome_pur_dans_arome_prod_6', 
					pourcent_alcool_prod_dans_arome_prod = '$pourcent_alcool_prod_dans_arome_prod', pourcent_eau_dans_arome_prod = '$pourcent_eau_dans_arome_prod', pourcent_arome_prod_dans_e_liquide_1 = '$pourcent_arome_prod_dans_e_liquide_1', 
					pourcent_arome_prod_dans_e_liquide_2 = '$pourcent_arome_prod_dans_e_liquide_2', pourcent_arome_prod_dans_e_liquide_3 = '$pourcent_arome_prod_dans_e_liquide_3', etat = '$etat', 
					date_upd = '$date_upd', info_saveur = '$info_saveur'
					
				WHERE id_saveur = $id_saveur";

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

	$id_saveur = $this->id_saveur;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."saveur
				WHERE id_saveur = $id_saveur";

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
	$str = Lib_addElem($str, $this->id_saveur);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_1);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_2);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_3);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_4);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_5);
	$str = Lib_addElem($str, $this->pourcent_eth0_dans_arome_pur_6);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_1);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_2);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_3);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_4);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_5);
	$str = Lib_addElem($str, $this->pourcent_arome_pur_dans_arome_prod_6);
	$str = Lib_addElem($str, $this->pourcent_alcool_prod_dans_arome_prod);
	$str = Lib_addElem($str, $this->pourcent_eau_dans_arome_prod);
	$str = Lib_addElem($str, $this->pourcent_arome_prod_dans_e_liquide_1);
	$str = Lib_addElem($str, $this->pourcent_arome_prod_dans_e_liquide_2);
	$str = Lib_addElem($str, $this->pourcent_arome_prod_dans_e_liquide_3);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_saveur);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un saveur suivant son identifiant
et retourne la coquille "Saveur" remplie avec les informations récupérées
de la base.
@param id_saveur.
*/
function Saveur_recuperer($id_saveur)
{
	$saveur = new Saveur();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."saveur
				WHERE id_saveur = '$id_saveur';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$saveur->id_saveur										= $row['id_saveur'];
		$saveur->pourcent_eth0_dans_arome_pur_1			= $row['pourcent_eth0_dans_arome_pur_1'];
		$saveur->pourcent_eth0_dans_arome_pur_2			= $row['pourcent_eth0_dans_arome_pur_2'];
		$saveur->pourcent_eth0_dans_arome_pur_3			= $row['pourcent_eth0_dans_arome_pur_3'];
		$saveur->pourcent_eth0_dans_arome_pur_4			= $row['pourcent_eth0_dans_arome_pur_4'];
		$saveur->pourcent_eth0_dans_arome_pur_5			= $row['pourcent_eth0_dans_arome_pur_5'];
		$saveur->pourcent_eth0_dans_arome_pur_6			= $row['pourcent_eth0_dans_arome_pur_6'];
		$saveur->pourcent_arome_pur_dans_arome_prod_1	= $row['pourcent_arome_pur_dans_arome_prod_1'];
		$saveur->pourcent_arome_pur_dans_arome_prod_2	= $row['pourcent_arome_pur_dans_arome_prod_2'];
		$saveur->pourcent_arome_pur_dans_arome_prod_3	= $row['pourcent_arome_pur_dans_arome_prod_3'];
		$saveur->pourcent_arome_pur_dans_arome_prod_4	= $row['pourcent_arome_pur_dans_arome_prod_4'];
		$saveur->pourcent_arome_pur_dans_arome_prod_5	= $row['pourcent_arome_pur_dans_arome_prod_5'];
		$saveur->pourcent_arome_pur_dans_arome_prod_6	= $row['pourcent_arome_pur_dans_arome_prod_6'];
		$saveur->pourcent_alcool_prod_dans_arome_prod	= $row['pourcent_alcool_prod_dans_arome_prod'];
		$saveur->pourcent_eau_dans_arome_prod			= $row['pourcent_eau_dans_arome_prod'];
		$saveur->pourcent_arome_prod_dans_e_liquide_1	= $row['pourcent_arome_prod_dans_e_liquide_1'];
		$saveur->pourcent_arome_prod_dans_e_liquide_2	= $row['pourcent_arome_prod_dans_e_liquide_2'];
		$saveur->pourcent_arome_prod_dans_e_liquide_3	= $row['pourcent_arome_prod_dans_e_liquide_3'];
		$saveur->etat											= $row['etat'];
		$saveur->date_add										= $row['date_add'];
		$saveur->date_upd										= $row['date_upd'];
		$saveur->info_saveur									= Sql_prepareTexteAffichage($row['info_saveur']);
	}
	return $saveur;
}

/**
Retourne un tableau de saveurs correspondant aux champs du tableau en argument.
@param $args
*/
function Saveurs_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."saveur
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."saveur
					WHERE 1";
	}

	if (!isset($args['id_saveur']) && !isset($args['pourcent_eth0_dans_arome_pur_1']) && !isset($args['pourcent_eth0_dans_arome_pur_2'])
		 && !isset($args['pourcent_eth0_dans_arome_pur_3']) && !isset($args['pourcent_eth0_dans_arome_pur_4']) && !isset($args['pourcent_eth0_dans_arome_pur_5'])
		 && !isset($args['pourcent_eth0_dans_arome_pur_6']) && !isset($args['pourcent_arome_pur_dans_arome_prod_1']) && !isset($args['pourcent_arome_pur_dans_arome_prod_2'])
		 && !isset($args['pourcent_arome_pur_dans_arome_prod_3']) && !isset($args['pourcent_arome_pur_dans_arome_prod_4']) && !isset($args['pourcent_arome_pur_dans_arome_prod_5'])
		 && !isset($args['pourcent_arome_pur_dans_arome_prod_6']) && !isset($args['pourcent_alcool_prod_dans_arome_prod']) && !isset($args['pourcent_eau_dans_arome_prod'])
		 && !isset($args['pourcent_arome_prod_dans_e_liquide_1']) && !isset($args['pourcent_arome_prod_dans_e_liquide_2']) && !isset($args['pourcent_arome_prod_dans_e_liquide_3'])
		 && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_saveurs']))
		return $tab_result;

	$condition="";

	if (isset($args['id_saveur']) && $args['id_saveur'] != "*")
		$condition .= " AND id_saveur = '".$args['id_saveur']."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_1']) && $args['pourcent_eth0_dans_arome_pur_1'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_1 = '".strtr($this->pourcent_eth0_dans_arome_pur_1, ",", ".")."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_2']) && $args['pourcent_eth0_dans_arome_pur_2'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_2 = '".strtr($this->pourcent_eth0_dans_arome_pur_2, ",", ".")."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_3']) && $args['pourcent_eth0_dans_arome_pur_3'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_3 = '".strtr($this->pourcent_eth0_dans_arome_pur_3, ",", ".")."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_4']) && $args['pourcent_eth0_dans_arome_pur_4'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_4 = '".strtr($this->pourcent_eth0_dans_arome_pur_4, ",", ".")."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_5']) && $args['pourcent_eth0_dans_arome_pur_5'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_5 = '".strtr($this->pourcent_eth0_dans_arome_pur_5, ",", ".")."' ";
	if (isset($args['pourcent_eth0_dans_arome_pur_6']) && $args['pourcent_eth0_dans_arome_pur_6'] != "*")
		$condition .= " AND pourcent_eth0_dans_arome_pur_6 = '".strtr($this->pourcent_eth0_dans_arome_pur_6, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_1']) && $args['pourcent_arome_pur_dans_arome_prod_1'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_1 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_1, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_2']) && $args['pourcent_arome_pur_dans_arome_prod_2'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_2 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_2, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_3']) && $args['pourcent_arome_pur_dans_arome_prod_3'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_3 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_3, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_4']) && $args['pourcent_arome_pur_dans_arome_prod_4'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_4 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_4, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_5']) && $args['pourcent_arome_pur_dans_arome_prod_5'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_5 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_5, ",", ".")."' ";
	if (isset($args['pourcent_arome_pur_dans_arome_prod_6']) && $args['pourcent_arome_pur_dans_arome_prod_6'] != "*")
		$condition .= " AND pourcent_arome_pur_dans_arome_prod_6 = '".strtr($this->pourcent_arome_pur_dans_arome_prod_6, ",", ".")."' ";
	if (isset($args['pourcent_alcool_prod_dans_arome_prod']) && $args['pourcent_alcool_prod_dans_arome_prod'] != "*")
		$condition .= " AND pourcent_alcool_prod_dans_arome_prod = '".strtr($this->pourcent_alcool_prod_dans_arome_prod, ",", ".")."' ";
	if (isset($args['pourcent_eau_dans_arome_prod']) && $args['pourcent_eau_dans_arome_prod'] != "*")
		$condition .= " AND pourcent_eau_dans_arome_prod = '".strtr($this->pourcent_eau_dans_arome_prod, ",", ".")."' ";
	if (isset($args['pourcent_arome_prod_dans_e_liquide_1']) && $args['pourcent_arome_prod_dans_e_liquide_1'] != "*")
		$condition .= " AND pourcent_arome_prod_dans_e_liquide_1 = '".strtr($this->pourcent_arome_prod_dans_e_liquide_1, ",", ".")."' ";
	if (isset($args['pourcent_arome_prod_dans_e_liquide_2']) && $args['pourcent_arome_prod_dans_e_liquide_2'] != "*")
		$condition .= " AND pourcent_arome_prod_dans_e_liquide_2 = '".strtr($this->pourcent_arome_prod_dans_e_liquide_2, ",", ".")."' ";
	if (isset($args['pourcent_arome_prod_dans_e_liquide_3']) && $args['pourcent_arome_prod_dans_e_liquide_3'] != "*")
		$condition .= " AND pourcent_arome_prod_dans_e_liquide_3 = '".strtr($this->pourcent_arome_prod_dans_e_liquide_3, ",", ".")."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_saveurs']) && $args['tab_ids_saveurs'] != "*") {
		$ids = implode(",", $args['tab_ids_saveurs']);
		$condition .= " AND id_saveur IN (0".$ids.") ";
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
				$id = $row['id_saveur'];
				$tab_result[$id]["id_saveur"]										= $id;
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_1"]			= $row['pourcent_eth0_dans_arome_pur_1'];
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_2"]			= $row['pourcent_eth0_dans_arome_pur_2'];
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_3"]			= $row['pourcent_eth0_dans_arome_pur_3'];
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_4"]			= $row['pourcent_eth0_dans_arome_pur_4'];
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_5"]			= $row['pourcent_eth0_dans_arome_pur_5'];
				$tab_result[$id]["pourcent_eth0_dans_arome_pur_6"]			= $row['pourcent_eth0_dans_arome_pur_6'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_1"]	= $row['pourcent_arome_pur_dans_arome_prod_1'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_2"]	= $row['pourcent_arome_pur_dans_arome_prod_2'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_3"]	= $row['pourcent_arome_pur_dans_arome_prod_3'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_4"]	= $row['pourcent_arome_pur_dans_arome_prod_4'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_5"]	= $row['pourcent_arome_pur_dans_arome_prod_5'];
				$tab_result[$id]["pourcent_arome_pur_dans_arome_prod_6"]	= $row['pourcent_arome_pur_dans_arome_prod_6'];
				$tab_result[$id]["pourcent_alcool_prod_dans_arome_prod"]	= $row['pourcent_alcool_prod_dans_arome_prod'];
				$tab_result[$id]["pourcent_eau_dans_arome_prod"]			= $row['pourcent_eau_dans_arome_prod'];
				$tab_result[$id]["pourcent_arome_prod_dans_e_liquide_1"]	= $row['pourcent_arome_prod_dans_e_liquide_1'];
				$tab_result[$id]["pourcent_arome_prod_dans_e_liquide_2"]	= $row['pourcent_arome_prod_dans_e_liquide_2'];
				$tab_result[$id]["pourcent_arome_prod_dans_e_liquide_3"]	= $row['pourcent_arome_prod_dans_e_liquide_3'];
				$tab_result[$id]["etat"]											= $row['etat'];
				$tab_result[$id]["date_add"]										= $row['date_add'];
				$tab_result[$id]["date_upd"]										= $row['date_upd'];
				$tab_result[$id]["info_saveur"]									= Sql_prepareTexteAffichage($row['info_saveur']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_saveur'] != '' && $args['id_saveur'] != '*'))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__SAVEUR_INC__'))
?>