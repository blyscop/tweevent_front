<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Factures
*/

/**
 * Classe pour la gestion de factures
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE bdd_factures (
	  id_facture int(11) NOT NULL AUTO_INCREMENT,
	  id_pere int(11) NOT NULL,
	  type_pere varchar(32) NOT NULL,
	  montant_ttc decimal(10,2) NOT NULL,
	  etat enum('en_cours','validee','supprimee') NOT NULL,
	  date_facture date NOT NULL,
	  num_facture varchar(32) NOT NULL,
	  message text NOT NULL,
	  produit varchar(255) NOT NULL,
	  id_mode_reglement int(11) NOT NULL,
	  id_delai_reglement int(11) NOT NULL,
	  code_client varchar(32) NOT NULL,
	  nom_fact varchar(255) NOT NULL,
	  ligne1_fact varchar(255) NOT NULL,
	  ligne2_fact varchar(255) NOT NULL,
	  ligne3_fact varchar(255) NOT NULL,
	  cp_fact varchar(32) NOT NULL,
	  ville_fact varchar(255) NOT NULL,
	  tel1_fact varchar(50) NOT NULL,
	  tel2_fact varchar(50) NOT NULL,
	  fax_fact varchar(50) NOT NULL,
	  email_fact varchar(255) NOT NULL,
	  date_add varchar(255) NOT NULL,
	  date_upd varchar(255) NOT NULL,
	  info_facture varchar(255) NOT NULL,
	  PRIMARY KEY (id_facture)
)

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_pere
// Clef de recherche 2 : etat
// Clef de recherche 3 : date_facture
// Clef de recherche 4 : num_facture

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__FACTURE_INC__')){
	define('__FACTURE_INC__', 1);

class Facture extends Element {
	var $id_facture;
	var $id_pere;
	var $type_pere;
	var $montant_ttc;
	var $etat;
	var $date_facture;
	var $num_facture;
	var $message;
	var $facture;
	var $id_mode_reglement;
	var $id_delai_reglement;
	var $code_client;
	var $nom_fact;
	var $ligne1_fact;
	var $ligne2_fact;
	var $ligne3_fact;
	var $cp_fact;
	var $ville_fact;
	var $tel1_fact;
	var $tel2_fact;
	var $fax_fact;
	var $email_fact;
	var $date_add;
	var $date_upd;
	var $info_facture;

/** 
Constructeur de la classe.
*/
function Facture()
{
	$this->type_moi = "factures";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Facture.
*/
function getTab()
{
	$tab['id_facture']			= $this->id_facture;
	$tab['id_pere']				= $this->id_pere;
	$tab['type_pere']				= $this->type_pere;
	$tab['montant_ttc']			= $this->montant_ttc;
	$tab['etat']					= $this->etat;
	$tab['date_facture']			= $this->date_facture;
	$tab['num_facture']			= $this->num_facture;
	$tab['message']				= $this->message;
	$tab['produit']				= $this->produit;
	$tab['id_mode_reglement']	= $this->id_mode_reglement;
	$tab['id_delai_reglement']	= $this->id_delai_reglement;
	$tab['code_client']			= $this->code_client;
	$tab['nom_fact']				= $this->nom_fact;
	$tab['ligne1_fact']			= $this->ligne1_fact;
	$tab['ligne2_fact']			= $this->ligne2_fact;
	$tab['ligne3_fact']			= $this->ligne3_fact;
	$tab['cp_fact']				= $this->cp_fact;
	$tab['ville_fact']			= $this->ville_fact;
	$tab['tel1_fact']				= $this->tel1_fact;
	$tab['tel2_fact']				= $this->tel2_fact;
	$tab['fax_fact']				= $this->fax_fact;
	$tab['email_fact']			= $this->email_fact;	
	$tab['date_add']				= $this->date_add;
	$tab['date_upd']				= $this->date_upd;
	$tab['info_facture']			= $this->info_facture;
	return $tab;
}

/**
Cette fonction ajoute un element de la table facture à la BDD. 
*/
function ADD()
{
	$id_pere 				= is_numeric($this->id_pere) ? $this->id_pere : 0;
	$type_pere 				= $this->type_pere;
	$montant_ttc 			= strtr($this->montant_ttc, ",", ".");
	$etat 					= $this->etat;
	$date_facture 			= Lib_frToEn($this->date_facture);
	$num_facture 			= $this->num_facture;
	$message 				= Lib_prepareTexteStockage($this->message);
	$produit 				= Lib_prepareTexteStockage($this->produit);
	$id_mode_reglement	= is_numeric($this->id_mode_reglement) ? $this->id_mode_reglement : 0;
	$id_delai_reglement	= is_numeric($this->id_delai_reglement) ? $this->id_delai_reglement : 0;
	$code_client			= $this->code_client;
	$nom_fact				= Lib_prepareTexteStockage($this->nom_fact);
	$ligne1_fact			= Lib_prepareTexteStockage($this->ligne1_fact);
	$ligne2_fact			= Lib_prepareTexteStockage($this->ligne2_fact);
	$ligne3_fact			= Lib_prepareTexteStockage($this->ligne3_fact);
	$cp_fact					= $this->cp_fact;
	$ville_fact				= Lib_prepareTexteStockage($this->ville_fact);
	$tel1_fact				= $this->tel1_fact;
	$tel2_fact				= $this->tel2_fact;
	$fax_fact				= $this->fax_fact;
	$email_fact				= $this->email_fact;
	$date_add 				= time();
	$info_facture 			= $this->info_facture;

	$sql = " INSERT INTO ".$GLOBALS['prefix']."factures
					(id_pere, type_pere, montant_ttc, etat, 
					date_facture, num_facture, message,
					produit, id_mode_reglement, id_delai_reglement,
					code_client, nom_fact, ligne1_fact, 
					ligne2_fact, ligne3_fact, cp_fact, 
					ville_fact, tel1_fact, tel2_fact, 
					fax_fact, email_fact, date_add, 
					info_facture)
				VALUES 
					 ($id_pere, '$type_pere', '$montant_ttc', '$etat', 
					'$date_facture', '$num_facture', '$message',
					'$produit', $id_mode_reglement, $id_delai_reglement,
					'$code_client', '$nom_fact', '$ligne1_fact', 
					'$ligne2_fact', '$ligne3_fact', '$cp_fact', 
					'$ville_fact', '$tel1_fact', '$tel2_fact', 
					'$fax_fact', '$email_fact','$date_add', 
					'$info_facture')";

	if (!Db_execSql($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_facture = mysql_insert_id(); 
		Lib_sqlLog($sql." -- $id_facture");
		$this->id_facture = $this->id_facture;
		return $id_facture;
	}
	return;
}

/**
Cette fonction modifie un élément de la table facture dans la BDD. 
*/
function UPD()
{
	$id_facture 			= is_numeric($this->id_facture) ? $this->id_facture : 0;
	$id_pere 				= is_numeric($this->id_pere) ? $this->id_pere : 0;
	$type_pere 				= $this->type_pere;
	$montant_ttc 			= strtr($this->montant_ttc, ",", ".");
	$etat 					= $this->etat;
	$date_facture 			= Lib_frToEn($this->date_facture);
	$num_facture 			= $this->num_facture;
	$message 				= Lib_prepareTexteStockage($this->message);
	$produit 				= Lib_prepareTexteStockage($this->produit);
	$id_mode_reglement	= is_numeric($this->id_mode_reglement) ? $this->id_mode_reglement : 0;
	$id_delai_reglement	= is_numeric($this->id_delai_reglement) ? $this->id_delai_reglement : 0;
	$code_client			= $this->code_client;
	$nom_fact				= Lib_prepareTexteStockage($this->nom_fact);
	$ligne1_fact			= Lib_prepareTexteStockage($this->ligne1_fact);
	$ligne2_fact			= Lib_prepareTexteStockage($this->ligne2_fact);
	$ligne3_fact			= Lib_prepareTexteStockage($this->ligne3_fact);
	$cp_fact					= $this->cp_fact;
	$ville_fact				= Lib_prepareTexteStockage($this->ville_fact);
	$tel1_fact				= $this->tel1_fact;
	$tel2_fact				= $this->tel2_fact;
	$fax_fact				= $this->fax_fact;
	$email_fact				= $this->email_fact;
	$date_upd 				= time();
	$info_facture 			= $this->info_facture;

	$sql = " UPDATE ".$GLOBALS['prefix']."factures
				SET id_pere = $id_pere, type_pere = '$type_pere', montant_ttc = '$montant_ttc', etat = '$etat', 
					date_facture = '$date_facture', num_facture = '$num_facture', message = '$message', 
					produit = '$produit', id_mode_reglement = $id_mode_reglement, id_delai_reglement = $id_delai_reglement, 
					code_client = '$code_client', nom_fact = '$nom_fact', ligne1_fact = '$ligne1_fact', 
					ligne2_fact = '$ligne2_fact', ligne3_fact = '$ligne3_fact', cp_fact = '$cp_fact', 
					ville_fact = '$ville_fact', tel1_fact = '$tel1_fact', tel2_fact = '$tel2_fact', 
					fax_fact = '$fax_fact', email_fact = '$email_fact', date_upd = '$date_upd', 
					info_facture = '$info_facture'
				WHERE id_facture = $id_facture";

	if (!Db_execSql($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/**
	Cette fonction supprime un chantier de la BDD.
*/
function DEL()
{
	if ($this->isError()) return;

	$id_facture = $this->id_facture;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."factures
				WHERE id_facture = $id_facture";

	if (!Db_execSql($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/** 
Cette fonction transforme les attributs en chaine de caractères.
*/
function toStr()
{
	$str = "";
	$str = Lib_addElem($str, $this->id_facture);
	$str = Lib_addElem($str, $this->id_pere);
	$str = Lib_addElem($str, $this->type_pere);
	$str = Lib_addElem($str, $this->montant_ttc);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_facture);
	$str = Lib_addElem($str, $this->num_facture);
	$str = Lib_addElem($str, $this->message);
	$str = Lib_addElem($str, $this->produit);
	$str = Lib_addElem($str, $this->id_mode_reglement);
	$str = Lib_addElem($str, $this->id_delai_reglement);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_facture);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un facture suivant son identifiant
et retourne la coquille "Facture" remplie avec les informations récupérées
de la base.
@param id_facture.
*/
function Facture_recuperer($id_facture)
{
	$facture = new Facture();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."factures
				WHERE id_facture = '$id_facture';";

	$result = mysql_query($sql);

   if ($result != NULL && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_array($result);
		$facture->id_facture				= $row['id_facture'];
		$facture->id_pere					= $row['id_pere'];
		$facture->type_pere				= $row['type_pere'];
		$facture->montant_ttc			= $row['montant_ttc'];
		$facture->etat						= $row['etat'];
		$facture->date_facture			= Lib_enToFr($row['date_facture']);
		$facture->num_facture			= $row['num_facture'];
		$facture->message					= Lib_prepareTexteAffichage($row['message']);
		$facture->produit					= Lib_prepareTexteAffichage($row['produit']);
		$facture->id_delai_reglement	= $row['id_delai_reglement'];
		$facture->id_mode_reglement	= $row['id_mode_reglement'];
		$facture->code_client			= $row->code_client;
		$facture->nom_fact				= Lib_prepareTexteAffichage($row->nom_fact);
		$facture->ligne1_fact			= Lib_prepareTexteAffichage($row->ligne1_fact);
		$facture->ligne2_fact			= Lib_prepareTexteAffichage($row->ligne2_fact);
		$facture->ligne3_fact			= Lib_prepareTexteAffichage($row->ligne3_fact);
		$facture->cp_fact					= $row->cp_fact;
		$facture->ville_fact				= Lib_prepareTexteAffichage($row->ville_fact);
		$facture->tel1_fact				= $row->tel1_fact;
		$facture->tel2_fact				= $row->tel2_fact;
		$facture->fax_fact				= $row->fax_fact;
		$facture->email_fact				= $row->email_fact;
		$facture->date_add				= $row['date_add'];
		$facture->date_upd				= $row['date_upd'];
		$facture->info_facture	= $row['info_facture'];
	}
	return $facture;
}

/**
Retourne un tableau de factures correspondant aux champs du tableau en argument.
@param $args
*/
function Factures_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT * 
				FROM ".$GLOBALS['prefix']."factures
				WHERE 1";

	if (!isset($args['id_facture']) && !isset($args['id_pere']) && 
		!isset($args['type_pere']) && !isset($args['etat']) && 
		!isset($args['date_facture_debut']) && !isset($args['date_facture_fin']) && 
		!isset($args['date_facture']) && !isset($args['num_facture']) && 
		!isset($args['order_by']) && !isset($args['tab_ids_factures']))
		return $tab_result;

	$condition="";

	if (isset($args['id_facture']) && $args['id_facture'] != "*")
		$condition .= " AND id_facture = '".$args['id_facture']."' ";
	if (isset($args['id_pere']) && $args['id_pere'] != "*")
		$condition .= " AND id_pere = ".$args['id_pere']." ";
	if (isset($args['type_pere']) && $args['type_pere'] != "*")
		$condition .= " AND type_pere LIKE '".$args['type_pere']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";
	if (isset($args['date_facture']) && $args['date_facture'] != "*")
		$condition .= " AND date_facture = '".Lib_frToEn($args['date_facture'])."' ";
	if (isset($args['date_facture_debut']) && $args['date_facture_debut'] != "*")
		$condition .= " AND date_facture >= '".Lib_frToEn($args['date_facture_debut'])."' ";
	if (isset($args['date_facture_fin']) && $args['date_facture_fin'] != "*")
		$condition .= " AND date_facture <= '".Lib_frToEn($args['date_facture_fin'])."' ";
	if (isset($args['num_facture']) && $args['num_facture'] != "*")
		$condition .= " AND num_facture LIKE '".$args['num_facture']."' ";

	if (isset($args['tab_ids_factures']) && $args['tab_ids_factures'] != "*") {
		$ids = implode(",", $args['tab_ids_factures']);
		$condition .= " AND id_facture IN (0".$ids.") ";
	}

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
	$result = mysql_query($sql);

	if ($result) {
		while($row = mysql_fetch_array($result)) {
			$id = $row['id_facture'];
			$tab_result[$id]["id_facture"]			= $id;
			$tab_result[$id]["id_pere"]				= $row['id_pere'];
			$tab_result[$id]["type_pere"]				= $row['type_pere'];
			$tab_result[$id]["montant_ttc"]			= $row['montant_ttc'];
			$tab_result[$id]["etat"]					= $row['etat'];
			$tab_result[$id]["date_facture"]			= Lib_enToFr($row['date_facture']);
			$tab_result[$id]["num_facture"]			= $row['num_facture'];
			$tab_result[$id]["message"]				= Lib_prepareTexteAffichage($row['message']);
			$tab_result[$id]["produit"]				= Lib_prepareTexteAffichage($row['produit']);
			$tab_result[$id]["id_mode_reglement"]	= $row['id_mode_reglement'];
			$tab_result[$id]["id_delai_reglement"]	= $row['id_delai_reglement'];
			$tab_result[$id]["code_client"]			= $row['code_client'];
			$tab_result[$id]["nom_fact"]				= Lib_prepareTexteAffichage($row['nom_fact']);
			$tab_result[$id]["ligne1_fact"]			= Lib_prepareTexteAffichage($row['ligne1_fact']);
			$tab_result[$id]["ligne2_fact"]			= Lib_prepareTexteAffichage($row['ligne2_fact']);
			$tab_result[$id]["ligne3_fact"]			= Lib_prepareTexteAffichage($row['ligne3_fact']);
			$tab_result[$id]["cp_fact"]				= $row['cp_fact'];
			$tab_result[$id]["ville_fact"]			= Lib_prepareTexteAffichage($row['ville_fact']);
			$tab_result[$id]["tel1_fact"]				= $row['tel1_fact'];
			$tab_result[$id]["tel2_fact"]				= $row['tel2_fact'];
			$tab_result[$id]["fax_fact"]				= $row['fax_fact'];
			$tab_result[$id]["email_fact"]			= $row['email_fact'];
			$tab_result[$id]["date_add"]				= $row['date_add'];
			$tab_result[$id]["date_upd"]				= $row['date_upd'];
			$tab_result[$id]["info_facture"]			= $row['info_facture'];
		}
	}

	if (count($tab_result) == 1 && ($args['id_facture'] != '' && $args['id_facture'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__FACTURE_INC__'))
?>