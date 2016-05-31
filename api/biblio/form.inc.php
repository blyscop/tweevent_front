<?
/**
 * Classe pour la gestion de l'annuaire à l'OFJ
 *
 * @author		dilasoft
 * @version	1.0
 * @code	
 * @endcode
 * 
 */
if (!defined('__FORM_INC__')){
define('__FORM_INC__', 1);

class Form extends Element {
	var $id_form;
	var $nom;
	var $prenom;
	var $form0;
	var $form1;
	var $form2;
	var $form3;
	var $form4;
	var $form5;
	var $form6;
	var $form7;
	var $form8;
	var $form9;
	var $form10;
	var $form11;
	var $form12;
	var $form13;
	var $form14;
	var $form15;
	var $form16;
	var $form17;
	var $form18;
	var $form19;
	var $form20;
	var $form21;
	var $form22;
	var $form23;
	var $form24;
	var $form25;
	var $form26;
	var $form27;
	var $form28;
	var $form29;
	var $form30;
	var $date_add;
	var $date_upd;

	// Crée une nouvelle personne
	function Form()
	{
	$this->type_moi = "form";
	}

	function getTab() 
	{
		$tab['id_form'] = $this->id_form;

		for($i=0; $i<=30; $i++) {
			$frm = 'form'.$i;
			$form->$frm = $data_in[$frm];
		}

		return $tab;
	}

	function ADD()
	{
		$date_add 	= gmdate("Y-m-d");
		$nom			= Sql_prepareTexteStockage($this->nom);
		$prenom		= Sql_prepareTexteStockage($this->prenom);

		// Construction de la requête d'insertion
		$sql = " INSERT INTO ".$GLOBALS['prefix']."forms (nom, prenom, ";

		for($i=0; $i<=30; $i++) {
			$frm = 'form'.$i;
			$sql .= "{$frm}, ";
		}

		$sql .=  "date_add) VALUES({$id_fiche}, '{$nom}', '{$prenom}', ";

		for($i=0; $i<=30; $i++) {
			$frm = 'form'.$i;
			$value = Sql_prepareTexteStockage($this->$frm);
			$sql .= "'{$value}', ";
		}

		$sql .= "'{$date_add}')";

		Lib_cleanSlashes($sql);
		if (!Sql_exec($sql)) $this->setError(ERROR); 
 
		if (!$this->isError()) {
			$id_form = Sql_lastInsertId();
			Lib_sqlLog($sql." -- $id_form");
			$this->id_form = $id_form;
			return $id_form;
		}

		return;
	}

	function UPD() 
	{
		if ($this->isError()) return;

		$date_upd 	= gmdate("Y-m-d");
		$id_form		= $this->id_form;
		$nom			= Sql_prepareTexteStockage($this->nom);
		$prenom		= Sql_prepareTexteStockage($this->prenom);

		// Construction de la requête de mise à jour
		$sql = " UPDATE ".$GLOBALS['prefix']."forms SET nom = '$nom', prenom = '$prenom', date_upd = '$date_upd', ";

		for($i=0; $i<=30; $i++) {
			$frm = 'form'.$i;
			$value = Sql_prepareTexteStockage($this->$frm);
			$sql .= "form{$i} = '{$value}', ";
		}

		$sql .= " WHERE id_form = {$id_form}";

		Lib_cleanSlashes($sql);
		if (!Sql_exec($sql)) $this->setError(ERROR); 

		if (!$this->isError()) {
			Lib_sqlLog($sql);
		}

		return;
	}

	function DEL() 
	{
		if ($this->isError()) return;

		$id_form = $this->id_form;

		$sql = " DELETE FROM ".$GLOBALS['prefix']."forms
					WHERE id_form = $id_form";

		if (!Sql_exec($sql)) $this->setError(ERROR); 

		if (!$this->isError()) {
			Lib_sqlLog($sql);
		}
		
		return;
	}
}

/**
 Recupère toutes les données relatives à une form suivant son identifiant
 et retourne la coquille "Form" remplie avec les informations récupérées
 de la base.
 @param IdForm: Identifiant de la form à récupérer
*/
function Form_recuperer($id_form) {

	$form = new Form();

	// On récupère d'abord les données de la table personne
	$sql = "SELECT *
		FROM ".$GLOBALS['prefix']."forms
		WHERE id_form = $id_form";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);

		$form->id_form = $row['id_form'];
		$form->nom = $row['nom'];
		$form->prenom = $row['prenom'];
		$form->date_add = $row['date_add'];
		$form->date_upd = $row['date_upd'];

		for($i=0; $i<=30; $i++) {
			$frm = 'form'.$i;
			$bdd = 'form'.$i;
			$form->$frm = $row[$bdd];
		}
	}
	
	return $form;
}

/**
 Renvoie le nom, le prénom et l'identifiant des personnes ayant les données passées en argument sous forme d'un tableau
 @param IdForm
 @param NomPersonne
 @param PrenomPersonne
 ...
*/
function Forms_chercher($id_form = '', $form0 = '')
{
	$tab_result = array();

	$sql = " SELECT * 
			FROM ".$GLOBALS['prefix']."forms
			WHERE 1";

	if ("$id_form" == "" && $form0 == "") return $tab_result;

	$condition="";

	if ( $id_form != "" && $id_form != "*") $condition .= " AND id_form = $id_form ";
	if ( $form0 != "" && $form0 != "*") $condition .= " AND form0 = '$form0' ";

	$sql .= $condition;
	Lib_myLog("SQL: $sql");
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_form'];
			$tab_result[$id]["id_form"] = $id;
			$tab_result[$id]["nom"] = Sql_prepareTexteAffichage($row['nom']);
			$tab_result[$id]["prenom"] = Sql_prepareTexteAffichage($row['prenom']);
			$tab_result[$id]["date_add"] = $row['date_add'];

			for($i=0; $i<=30; $i++) {
				$tab_result[$id]['form'.$i] = Sql_prepareTexteAffichage($row['form'.$i]);
			}
		}
	}

	if (count($tab_result) == 1 && ("$id_form" != '' && "$id_form" != '*')) 
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__FORM_INC__')){
?>
