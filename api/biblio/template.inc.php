<?
/** @file
 *  @ingroup group3
 *  @brief this file in Modules
*/

/**
 * Classe pour la gestion de chantiers de personnes
 *
 * @author	dilasoft
 * @version	1.0
 * @code
CREATE TABLE dilasoft_modules (
  id_module int(11) NOT NULL default '0',
  champ0 enum('oui','non') NOT NULL default 'non',
  champ1 enum('oui','non') NOT NULL default 'non',
  champ2 enum('oui','non') NOT NULL default 'non',
  champ3 enum('oui','non') NOT NULL default 'non',
  champ4 varchar(255) NOT NULL default '',
  champ5 varchar(255) NOT NULL default '',
  champ6 varchar(255) NOT NULL default '',
  champ7 varchar(255) NOT NULL default '',
  champ8 varchar(255) NOT NULL default '',
  champ9 varchar(255) NOT NULL default '',
  champa varchar(255) NOT NULL default '',
  champb varchar(255) NOT NULL default '',
  champc varchar(255) NOT NULL default '',
  champd enum('oui','non') NOT NULL default 'non',
  champe enum('oui','non') NOT NULL default 'non',
  champf float NOT NULL default '0',
  champg varchar(255) NOT NULL default '',
  champh varchar(255) NOT NULL default 'off',
  champi varchar(255) NOT NULL default 'off',
  champj varchar(255) NOT NULL default 'off',
  champk varchar(255) NOT NULL default 'off',
  champl varchar(255) NOT NULL default 'off',
  champm varchar(255) NOT NULL default 'off',
  champn varchar(255) NOT NULL default 'off',
  champo varchar(255) NOT NULL default 'off',
  champp varchar(255) NOT NULL default 'off',
  champq varchar(255) NOT NULL default 'off',
  champr text NOT NULL,
  champs varchar(255) NOT NULL default '',
  champt varchar(255) NOT NULL default 'off',
  champu varchar(255) NOT NULL default 'off',
  champv varchar(255) NOT NULL default 'off',
  champw varchar(255) NOT NULL default 'off',
  champx varchar(255) NOT NULL default 'off',
  champy varchar(255) NOT NULL default 'off',
  champz varchar(255) NOT NULL default 'off',
  PRIMARY KEY  (id_module)
) TYPE=MyISAM;
 * @endcode
 * 
 */
if (!defined('__MODULE_INC__')){
define('__MODULE_INC__', 1);

class Module extends Element {
	var $id_module;
	var $champ0;
	var $champ1;
	var $champ2;
	var $champ3;
	var $champ4;
	var $champ5;
	var $champ6;
	var $champ7;
	var $champ8;
	var $champ9;
	var $champa;
	var $champb;
	var $champc;
	var $champd;
	var $champe;
	var $champf;
	var $champg;
   var $champh;
   var $champi;
   var $champj;
   var $champk;
   var $champl;
   var $champm;
   var $champn;
   var $champo;
   var $champp;
   var $champq;
   var $champr;
   var $champs;
   var $champt;
   var $champu;
   var $champv;
   var $champw;
   var $champx;
   var $champy;
   var $champz;
	var $info_module;

	/**
	Cette fonction est un grand switch qui sert à renvoyer vers une action donnée en paramètre. 
	@param type_chantier : TypeFiche_Chantier de l'chantier
	@param date : date de création de l'chantier
	@param champ6 : champ6, email_responsable de l'chantier
	@param champ7 : Corps de l'chantier
	*/
	function Module()
	{
		$this->type_moi	= "modules";
	}

		/**
	Cette fonction retourne un tableau correspondant aux différents attributs de l'entreprise.
	*/
	function getTab() 
	{
		$tab['id_module']	= $this->id_module;
		$tab['champ0']		= $this->champ0;
		$tab['champ1']		= $this->champ1;
		$tab['champ2']		= $this->champ2;
		$tab['champ3']		= $this->champ3;
		$tab['champ4']		= $this->champ4;
		$tab['champ5']		= $this->champ5;
		$tab['champ6']		= $this->champ6;
		$tab['champ7']		= $this->champ7;
		$tab['champ8']		= $this->champ8;
		$tab['champ9']		= $this->champ9; 
		$tab['champa']		= $this->champa;
		$tab['champb']		= $this->champb;
		$tab['champc']		= $this->champc;
		$tab['champd']		= $this->champd; 
		$tab['champe']		= $this->champe; 
		$tab['champf']		= $this->champf; 
		$tab['champg']		= $this->champg;
		$tab['champh']		= $this->champh;
		$tab['champi']		= $this->champi;
		$tab['champj']		= $this->champj;
		$tab['champk']		= $this->champk;
		$tab['champl']		= $this->champl;
		$tab['champm']		= $this->champm;
		$tab['champn']		= $this->champn;
		$tab['champo']		= $this->champo;
		$tab['champp']		= $this->champp;
		$tab['champq']		= $this->champq;
		$tab['champr']		= $this->champr;
		$tab['champs']		= $this->champs;
		$tab['champt']		= $this->champt;
		$tab['champu']		= $this->champu;
		$tab['champv']		= $this->champv;
		$tab['champw']		= $this->champw;
		$tab['champx']		= $this->champx;
		$tab['champy']		= $this->champy;
		$tab['champz']		= $this->champz;
		$tab['date_add']	= $this->date_add;
		$tab['date_upd']	= $this->date_upd;
		$tab['info_module']	= $this->info_module;

		return $tab;
	}

	/**
	Cette fonction ajoute un chantier à la BDD.
	*/
	function ADD()
	{
		$champ0	= $this->champ0;
		$champ1	= Sql_prepareTexteStockage($this->champ1);
		$champ2	= Lib_frToEn($this->champ2);
		$champ3	= strtr($this->champ3, ",", ".");
		$champ4	= $this->champ4;
		$champ5	= $this->champ5;
		$champ6	= $this->champ6;
		$champ7	= $this->champ7;
		$champ8	= $this->champ8;
		$champ9	= $this->champ9; 
		$champa	= $this->champa;
		$champb	= $this->champb;
		$champc	= $this->champc;
		$champd	= $this->champd;
		$champe	= $this->champe;
		$champf	= $this->champf;
		$champg	= $this->champg;
		$champh	= $this->champh;
		$champi	= $this->champi;
		$champj	= $this->champj;
		$champk	= $this->champk;
		$champl	= $this->champl;
		$champm	= $this->champm;
		$champn	= $this->champn;
		$champo	= $this->champo;
		$champp	= $this->champp;
		$champq	= $this->champq;
		$champr	= $this->champr;
		$champs	= $this->champs;
		$champt	= $this->champt;
		$champu	= $this->champu;
		$champv	= $this->champv;
		$champw	= $this->champw;
		$champx	= $this->champx;
		$champy	= $this->champy;
		$champz	= $this->champz;
		$date_add	= time();
		$info_module	= Sql_prepareTexteStockage($this->info_module);

		$sql = " INSERT INTO ".$GLOBALS['prefix']."modules
						(champ0, champ1, 
						champ2, champ3,
						champ4, champ5, 
						champ6, champ7, 
						champ8, champ9, 
						champa, champb, 
						champc,  champd, 
						champe, champf, 
						champg, champh, 
						champi, champj, 
						champk, champl, 
						champm, champn, 
						champo, champp, 
						champq, champr, 
						champs, champt, 
						champu, champv, 
						champw, champx, 
						champy, champz, 
						date_add, info_module)
					VALUES('$champ0', '$champ1', 
							'$champ2', '$champ3',
							'$champ4', '$champ5', 
							'$champ6', '$champ7', 
							'$champ8', '$champ9', 
							'$champa', '$champb', 
							'$champc', '$champd', 
							'$champe', '$champf', 
							'$champg', '$champh', 
							'$champi', '$champj',
							'$champk', '$champl', 
							'$champm', '$champn', 
							'$champo', '$champp', 
							'$champq', '$champr',
							'$champs', '$champt',
							'$champu', '$champv',
							'$champw', '$champx',
							'$champy', '$champz',
							'$date_add', '$info_module')";

		if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		if (!$this->isError()) {
			$id_module = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_module");
			$this->id_module = $this->id_module;
			return $id_module;
		}
		
		return;
	}

	/**
	Cette fonction met à jour un chantier sur la BDD.
	*/
	function UPD() 
	{
		if ($this->isError()) return;
		
		$id_module		= $this->id_module;
		$champ0	= $this->champ0;
		$champ1	= Sql_prepareTexteStockage($this->champ1);
		$champ2	= Lib_frToEn($this->champ2);
		$champ3	= strtr($this->champ3, ",", ".");
		$champ4	= $this->champ4;
		$champ5	= $this->champ5;
		$champ6	= $this->champ6;
		$champ7	= $this->champ7;
		$champ8	= $this->champ8;
		$champ9	= $this->champ9; 
		$champa	= $this->champa;
		$champb	= $this->champb;
		$champc	= $this->champc;
		$champd	= $this->champd;
		$champe	= $this->champe;
		$champf	= $this->champf;
		$champg	= $this->champg;
		$champh	= $this->champh;
		$champi	= $this->champi;
		$champj	= $this->champj;
		$champk	= $this->champk;
		$champl	= $this->champl;
		$champm	= $this->champm;
		$champn	= $this->champn;
		$champo	= $this->champo;
		$champp	= $this->champp;
		$champq	= $this->champq;
		$champr	= $this->champr;
		$champs	= $this->champs;
		$champt	= $this->champt;
		$champu	= $this->champu;
		$champv	= $this->champv;
		$champw	= $this->champw;
		$champx	= $this->champx;
		$champy	= $this->champy;
		$champz	= $this->champz;
		$date_upd	= time();
		$info_module		= Sql_prepareTexteStockage($this->info_module);

		// Mise à jour de la base
		$sql = " UPDATE ".$GLOBALS['prefix']."modules
					SET champ0 = '$champ0', champ1 = '$champ1', 
						champ2 = '$champ2', champ3 = '$champ3',
						champ4 = '$champ4', champ5 = '$champ5', 
						champ6 = '$champ6', champ7 = '$champ7', 
						champ8 = '$champ8', champ9 = '$champ9', 
						champa = '$champa', champb = '$champb', 
						champc = '$champc', champd = '$champd', 
						champe = '$champe', champf = '$champf', 
						champg = '$champg', champh = '$champh', 
						champi = '$champi', champj = '$champj',
						champk = '$champk', champl = '$champl', 
						champm = '$champm', champn = '$champn', 
						champo = '$champo', champp = '$champp', 
						champq = '$champq', champr = '$champr',
						champs = '$champs', champt = '$champt',
						champu = '$champu', champv = '$champv',
						champw = '$champw', champx = '$champx',
						champy = '$champy', champz = '$champz',
						date_upd = '$date_upd', info_module = '$info_module'
					WHERE id_module = '$id_module'";

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

		$id_module = $this->id_module;

		$sql = " DELETE FROM ".$GLOBALS['prefix']."modules
					WHERE id_module = $id_module";

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
		$str = Lib_addElem($str, $this->id_module);
		$str = Lib_addElem($str, $this->champ0);
		$str = Lib_addElem($str, $this->champ1);
		$str = Lib_addElem($str, $this->champ2);
		$str = Lib_addElem($str, $this->champ3);
		$str = Lib_addElem($str, $this->champ4);
		$str = Lib_addElem($str, $this->champ5);
		$str = Lib_addElem($str, $this->champ6);
		$str = Lib_addElem($str, $this->champ7);
		$str = Lib_addElem($str, $this->champ8);
		$str = Lib_addElem($str, $this->champ9);
		$str = Lib_addElem($str, $this->champa);
		$str = Lib_addElem($str, $this->champb);
		$str = Lib_addElem($str, $this->champc);
		$str = Lib_addElem($str, $this->champd);
		$str = Lib_addElem($str, $this->champe);
		$str = Lib_addElem($str, $this->champf);
		$str = Lib_addElem($str, $this->champg); 
		$str = Lib_addElem($str, $this->champh); 
		$str = Lib_addElem($str, $this->champi); 
		$str = Lib_addElem($str, $this->champj);
		$str = Lib_addElem($str, $this->champk); 
		$str = Lib_addElem($str, $this->champl); 
		$str = Lib_addElem($str, $this->champm); 
		$str = Lib_addElem($str, $this->champn);
		$str = Lib_addElem($str, $this->champo); 
		$str = Lib_addElem($str, $this->champp); 
		$str = Lib_addElem($str, $this->champq); 
		$str = Lib_addElem($str, $this->champr);
		$str = Lib_addElem($str, $this->champs); 
		$str = Lib_addElem($str, $this->champt);
		$str = Lib_addElem($str, $this->champu); 
		$str = Lib_addElem($str, $this->champv);
		$str = Lib_addElem($str, $this->champw); 
		$str = Lib_addElem($str, $this->champx);
		$str = Lib_addElem($str, $this->champy); 
		$str = Lib_addElem($str, $this->champz);
		$str = Lib_addElem($str, $this->date_add);
		$str = Lib_addElem($str, $this->date_upd);
		$str = Lib_addElem($str, $this->info_module);
		$str = "(".$str.")";
		return $str;
	}
}

/**
 Recupère toutes les données relatives à un chantier suivant son identifiant
 et retourne la coquille "Fiche_Chantier" remplie avec les informations récupérées
 de la base.
 @param id_module: Identifiant du chantier à récupérer
*/
function Module_recuperer($id_module) {

	$module = new Module();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
			FROM ".$GLOBALS['prefix']."modules
			WHERE id_module = $id_module";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$module->id_module	= $row['id_module'];
		$module->champ0		= $row['champ0'];
		$module->champ1		= $row['champ1'];
		$module->champ2		= $row['champ2'];
		$module->champ3		= $row['champ3'];
		$module->champ4		= $row['champ4'];
		$module->champ5		= $row['champ5'];
		$module->champ6		= $row['champ6'];
		$module->champ7		= $row['champ7'];
		$module->champ8		= $row['champ8'];
		$module->champ9		= $row['champ9']; 
		$module->champa		= $row['champa'];
		$module->champb		= $row['champb'];
		$module->champc		= $row['champc'];
		$module->champd		= $row['champd']; 
		$module->champe		= $row['champe']; 
		$module->champf		= $row['champf']; 
		$module->champg		= $row['champg'];
		$module->champh		= $row['champh'];
		$module->champi		= $row['champi'];
		$module->champj		= $row['champj'];
		$module->champk		= $row['champk'];
		$module->champl		= $row['champl'];
		$module->champm		= $row['champm'];
		$module->champn		= $row['champn'];
		$module->champo		= $row['champo'];
		$module->champp		= $row['champp'];
		$module->champq		= $row['champq'];
		$module->champr		= $row['champr'];
		$module->champs		= $row['champs'];
		$module->champt		= $row['champt'];
		$module->champu		= $row['champu'];
		$module->champv		= $row['champv'];
		$module->champw		= $row['champw'];
		$module->champx		= $row['champx'];
		$module->champy		= $row['champy'];
		$module->champz		= $row['champz'];
		$module->date_add		= gmdate("d/m/Y", $row['date_add']);
		$module->date_upd		= gmdate("d/m/Y", $row['date_upd']);
		$module->info_module	= Sql_prepareTexteAffichage($row['info_module']);
	}

	return $module;
}

/**
 Renvoie le champ6, le préchamp6 et l'identifiant des personnes ayant les données passées en argument sous forme d'un tableau
 @param id_module
 ...
*/
function Modules_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
			FROM ".$GLOBALS['prefix']."modules
			WHERE 1";

	if (!isset($args['id_module']) && !isset($args['tab_ids_modules'])) 
		return $tab_result;

	$condition="";

	if (isset($args['id_module']) && $args['id_module'] != "*") 
		$condition .= " AND id_module = ".$args['id_module']." ";
	if (isset($args['tab_ids_fiches']) && $args['tab_ids_fiches'] != "*") { 
		$ids = implode(",", $args['tab_ids_fiches']);
		$condition .= " AND id_module IN (".$ids.") ";  
	}

	$sql .= $condition;
	$sql .= " ORDER BY id_module ASC";	
	/*=============*/ Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_module'];
			$tab_result[$id]["id_module"]		= $id;
			$tab_result[$id]["champ0"]			= Sql_prepareTexteAffichage($row['champ0']=;
			$tab_result[$id]["champ1"]			= Lib_enToFr($row['champ1']);
			$tab_result[$id]["champ2"]			= $row['champ2'];
			$tab_result[$id]["champ3"]			= $row['champ3'];
			$tab_result[$id]["champ4"]			= $row['champ4'];
			$tab_result[$id]["champ5"]			= $row['champ5'];
			$tab_result[$id]["champ6"]			= $row['champ6'];
			$tab_result[$id]["champ7"]			= $row['champ7'];
			$tab_result[$id]["champ8"]			= $row['champ8'];
			$tab_result[$id]["champ9"]			= $row['champ9']; 
			$tab_result[$id]["champa"]			= $row['champa'];
			$tab_result[$id]["champb"]			= $row['champb'];
			$tab_result[$id]["champc"]			= $row['champc'];
			$tab_result[$id]["champd"]			= $row['champd']; 
			$tab_result[$id]["champe"]			= $row['champe']; 
			$tab_result[$id]["champf"]			= $row['champf']; 
			$tab_result[$id]["champg"]			= $row['champg'];
			$tab_result[$id]["champh"]			= $row['champh'];
			$tab_result[$id]["champi"]			= $row['champi'];
			$tab_result[$id]["champj"]			= $row['champj'];
			$tab_result[$id]["champk"]			= $row['champk'];
			$tab_result[$id]["champl"]			= $row['champl'];
			$tab_result[$id]["champm"]			= $row['champm'];
			$tab_result[$id]["champn"]			= $row['champn'];
			$tab_result[$id]["champo"]			= $row['champo'];
			$tab_result[$id]["champp"]			= $row['champp'];
			$tab_result[$id]["champq"]			= $row['champq'];
			$tab_result[$id]["champr"]			= $row['champr'];
			$tab_result[$id]["champs"]			= $row['champs'];
			$tab_result[$id]["champt"]			= $row['champt'];
			$tab_result[$id]["champu"]			= $row['champu'];
			$tab_result[$id]["champv"]			= $row['champv'];
			$tab_result[$id]["champw"]			= $row['champw'];
			$tab_result[$id]["champx"]			= $row['champx'];
			$tab_result[$id]["champy"]			= $row['champy'];
			$tab_result[$id]["champz"]			= $row['champz'];
			$tab_result[$id]["date_add"]		= gmdate("d/m/Y", $row['date_add']);
			$tab_result[$id]["date_upd"]		= gmdate("d/m/Y", $row['date_upd']);
			$tab_result[$id]["info_module"]	= Sql_prepareTexteAffichage($row['info_module']);
		}
	}

	if (count($tab_result) == 1 && ($args['id_module'] != '' && $args['id_module'] != '*')) 
		$tab_result = array_pop($tab_result);	
		
	return $tab_result;
}

} // Fin if (!defined('__MODULE_INC__')){
?>