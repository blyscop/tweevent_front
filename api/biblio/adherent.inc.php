<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Adherents
*/

/**
 * Classe pour la gestion de adherents
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `cms3_adherent` (
	 `id_adherent` INT(11) NOT NULL auto_increment,
	 `id_interne` INT(11) NOT NULL,
	 `enseigne` VARCHAR(255) NOT NULL,
	 `raison_sociale` VARCHAR(255) NOT NULL,
	 `adresse1` VARCHAR(255) NOT NULL,
	 `adresse2` VARCHAR(255) NOT NULL,
	 `cp` VARCHAR(255) NOT NULL,
	 `ville` VARCHAR(255) NOT NULL,
	 `pays` VARCHAR(255) NOT NULL,
	 `telephone` VARCHAR(255) NOT NULL,
	 `fax` VARCHAR(255) NOT NULL,
	 `email` VARCHAR(255) NOT NULL,
	 `site_internet` VARCHAR(255) NOT NULL,
	 `latitude` VARCHAR(255) NOT NULL,
	 `longitude` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_adherent` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_adherent`));

ALTER TABLE `quellien_adherent` ADD `nom` VARCHAR( 255 ) NOT NULL AFTER `id_interne` ,
ADD `prenom` VARCHAR( 255 ) NOT NULL AFTER `nom` ;

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : id_interne
// Clef de recherche 2 : enseigne
// Clef de recherche 3 : raison_sociale
// Clef de recherche 4 : cp
// Clef de recherche 5 : ville
// Clef de recherche 6 : pays
// Clef de recherche 7 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__ADHERENT_INC__')){
	define('__ADHERENT_INC__', 1);

class Adherent extends Utilisateur {
	var $id_adherent;
	var $id_utilisateur;
	var $id_interne;
	var $nom;
	var $prenom;
	var $enseigne;
	var $raison_sociale;
	var $adresse1;
	var $adresse2;
	var $cp;
	var $ville;
	var $pays;
	var $telephone;
	var $fax;
	var $email;
	var $site_internet;
	var $entreprise_qualifiee;
	var $logo;
	var $categorie;
	var $nature_lien;
	var $info_publique;
	var $categorie1;
	var $categorie2;
	var $categorie3;
	var $categorie4;
	var $categorie5;
	var $categorie6;
	var $categorie7;
	var $categorie8;
	var $categorie9;
	var $categorie10;
	var $latitude;
	var $longitude;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_adherent;

/** 
Constructeur de la classe.
*/
function Adherent()
{
	$this->type_moi = "adherents";
}

/**
Cette fonction retourne un tableau correspondant aux différents attributs de Adherent.
*/
function getTab()
{
	$tab['id_adherent']				= $this->id_adherent;
	$tab['id_utilisateur']			= $this->id_utilisateur;
	$tab['id_interne']				= $this->id_interne;
	$tab['nom']					= $this->nom;
	$tab['prenom']					= $this->prenom;
	$tab['enseigne']					= $this->enseigne;
	$tab['raison_sociale']			= $this->raison_sociale;
	$tab['adresse1']					= $this->adresse1;
	$tab['adresse2']					= $this->adresse2;
	$tab['cp']							= $this->cp;
	$tab['ville']						= $this->ville;
	$tab['pays']						= $this->pays;
	$tab['telephone']					= $this->telephone;
	$tab['fax']							= $this->fax;
	$tab['email']						= $this->email;
	$tab['site_internet']			= $this->site_internet;
	$tab['entreprise_qualifiee']	= $this->entreprise_qualifiee;
	$tab['logo']						= $this->logo;
	$tab['categorie']					= $this->categorie;
	$tab['nature_lien']				= $this->nature_lien;
	$tab['info_publique']			= $this->info_publique;
	$tab['categorie1']				= $this->categorie1;
	$tab['categorie2']				= $this->categorie2;
	$tab['categorie3']				= $this->categorie3;
	$tab['categorie4']				= $this->categorie4;
	$tab['categorie5']				= $this->categorie5;
	$tab['categorie6']				= $this->categorie6;
	$tab['categorie7']				= $this->categorie7;
	$tab['categorie8']				= $this->categorie8;
	$tab['categorie9']				= $this->categorie9;
	$tab['categorie10']				= $this->categorie10;
	$tab['latitude']					= $this->latitude;
	$tab['longitude']					= $this->longitude;
	$tab['etat']						= $this->etat;
	$tab['date_add']					= $this->date_add;
	$tab['date_upd']					= $this->date_upd;
	$tab['info_adherent']			= $this->info_adherent;
	return $tab;
}

/**
Cette fonction ajoute un element de la table adherent à la BDD. 
*/
function ADD()
{
	$util = new Utilisateur();
	$util->code_utilisateur = $this->code_utilisateur;
	$util->nom_groupe			= ($this->nom_groupe != '') ? $this->nom_groupe : 'utilisateur';
	$util->nom_utilisateur  = $this->nom_utilisateur;
	$util->password			= $this->password;
	$util->nb_connect			= ($this->nb_connect != '') ? $this->nb_connect : 10;
	$util->etat					= $this->etat != '' ? $this->etat : 'actif';
	$util->lang					= $this->lang;
	$id_utilisateur 			= $util->ADD();

	$id_interne 				= is_numeric($this->id_interne) ? $this->id_interne : 0;
	$nom 					= Sql_prepareTexteStockage($this->nom);
	$prenom 					= Sql_prepareTexteStockage($this->prenom);
	$enseigne 					= Sql_prepareTexteStockage($this->enseigne);
	$raison_sociale 			= Sql_prepareTexteStockage($this->raison_sociale);
	$adresse1 					= Sql_prepareTexteStockage($this->adresse1);
	$adresse2 					= Sql_prepareTexteStockage($this->adresse2);
	$cp 							= Sql_prepareTexteStockage($this->cp);
	$ville 						= Sql_prepareTexteStockage($this->ville);
	$pays 						= Sql_prepareTexteStockage($this->pays);
	$telephone 					= Sql_prepareTexteStockage($this->telephone);
	$fax 							= Sql_prepareTexteStockage($this->fax);
	$email 						= $this->email;
	$site_internet 			= $this->site_internet;
	$entreprise_qualifiee	= $this->entreprise_qualifiee;
	$logo							= $this->logo;
	$categorie					= Sql_prepareTexteStockage($this->categorie);
	$nature_lien				= Sql_prepareTexteStockage($this->nature_lien);
	$info_publique				= Sql_prepareTexteStockage($this->info_publique);
	$categorie1					= $this->categorie1;
	$categorie2					= $this->categorie2;
	$categorie3					= $this->categorie3;
	$categorie4					= $this->categorie4;
	$categorie5					= $this->categorie5;
	$categorie6					= $this->categorie6;
	$categorie7					= $this->categorie7;
	$categorie8					= $this->categorie8;
	$categorie9					= $this->categorie9;
	$categorie10				= $this->categorie10;
	$latitude 					= strtr($this->latitude, ",", ".");
	$longitude 					= strtr($this->longitude, ",", ".");
	$etat 						= $this->etat != '' ? $this->etat : 'actif';
	$date_add 					= time();
	$info_adherent 			= $this->info_adherent;

	$sql = " INSERT INTO ".$GLOBALS['prefix']."adherent
					(id_utilisateur, id_interne, enseigne, nom, prenom, raison_sociale, adresse1, adresse2, 
					cp, ville, pays, telephone, fax, 
					email, site_internet, entreprise_qualifiee, logo, latitude, longitude, categorie, nature_lien, info_publique,
					categorie1, categorie2, categorie3, categorie4, categorie5, 
					categorie6, categorie7, categorie8, categorie9, categorie10, 
					etat, date_add, info_adherent)
				VALUES 
					('$id_utilisateur', '$id_interne', '$enseigne', '$nom','$prenom', '$raison_sociale', '$adresse1', '$adresse2', 
					'$cp', '$ville', '$pays', '$telephone', '$fax', 
					'$email', '$site_internet', '$entrprise_qualifiee', '$logo', '$latitude', '$longitude', '$categorie', '$nature_lien', '$info_publique', 
					'$categorie1', '$categorie2', '$categorie3', '$categorie4', '$categorie5', 
					'$categorie6', '$categorie7', '$categorie8', '$categorie9', '$categorie10', 
					'$etat', '$date_add', '$info_adherent')";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_adherent = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_adherent");
		$this->id_adherent = $this->id_adherent;
		return $id_adherent;
	}
	return;
}

/**
Cette fonction modifie un élément de la table adherent dans la BDD. 
*/
function UPD()
{
	$util = Utilisateur_recuperer($this->id_utilisateur);
	$util->code_utilisateur = $this->code_utilisateur;
	$util->nom_groupe			= $this->nom_groupe;
	$util->nom_utilisateur  = $this->nom_utilisateur;
	$util->password			= $this->password;
	$util->nb_connect			= ($this->nb_connect != '') ? $this->nb_connect : 10;
	$util->etat					= $this->etat != '' ? $this->etat : 'actif';
	$util->lang					= $this->lang;
	$util->UPD();

	$id_adherent 				= is_numeric($this->id_adherent) ? $this->id_adherent : 0;
	$id_interne 				= is_numeric($this->id_interne) ? $this->id_interne : 0;
	$nom 					= Sql_prepareTexteStockage($this->nom);
	$prenom 					= Sql_prepareTexteStockage($this->prenom);
	$enseigne 					= Sql_prepareTexteStockage($this->enseigne);
	$raison_sociale 			= Sql_prepareTexteStockage($this->raison_sociale);
	$adresse1 					= Sql_prepareTexteStockage($this->adresse1);
	$adresse2 					= Sql_prepareTexteStockage($this->adresse2);
	$cp 							= Sql_prepareTexteStockage($this->cp);
	$ville 						= Sql_prepareTexteStockage($this->ville);
	$pays 						= Sql_prepareTexteStockage($this->pays);
	$telephone 					= Sql_prepareTexteStockage($this->telephone);
	$fax 							= Sql_prepareTexteStockage($this->fax);
	$email 						= $this->email;
	$site_internet 			= $this->site_internet;
	$entreprise_qualifiee	= $this->entreprise_qualifiee;
	$logo							= $this->logo;
	$categorie					= Sql_prepareTexteStockage($this->categorie);
	$nature_lien				= Sql_prepareTexteStockage($this->nature_lien);
	$info_publique				= Sql_prepareTexteStockage($this->info_publique);
	$categorie1					= $this->categorie1;
	$categorie2					= $this->categorie2;
	$categorie3					= $this->categorie3;
	$categorie4					= $this->categorie4;
	$categorie5					= $this->categorie5;
	$categorie6					= $this->categorie6;
	$categorie7					= $this->categorie7;
	$categorie8					= $this->categorie8;
	$categorie9					= $this->categorie9;
	$categorie10				= $this->categorie10;
	$latitude 					= strtr($this->latitude, ",", ".");
	$longitude 					= strtr($this->longitude, ",", ".");
	$etat 						= $this->etat != '' ? $this->etat : 'actif';
	$date_add 					= time();
	$info_adherent 			= $this->info_adherent;

	$sql = " UPDATE ".$GLOBALS['prefix']."adherent
				SET id_interne = '$id_interne', enseigne = '$enseigne', nom = '$nom', prenom = '$prenom',
				       raison_sociale = '$raison_sociale', 
					adresse1 = '$adresse1', adresse2 = '$adresse2', cp = '$cp', ville = '$ville', pays = '$pays', telephone = '$telephone', 
					fax = '$fax', email = '$email', site_internet = '$site_internet', entreprise_qualifiee = '$entreprise_qualifiee', 
					logo = '$logo', categorie = '$categorie', nature_lien = '$nature_lien', info_publique = '$info_publique',
					categorie1 = '$categorie1', categorie2 = '$categorie2', categorie3 = '$categorie3', categorie4 = '$categorie4', categorie5 = '$categorie5', 
					categorie6 = '$categorie6', categorie7 = '$categorie7', categorie8 = '$categorie8', categorie9 = '$categorie9', categorie10 = '$categorie10', 
					latitude = '$latitude', longitude = '$longitude', 
					etat = '$etat', date_upd = '$date_upd', 
					info_adherent = '$info_adherent'
				WHERE id_adherent = $id_adherent";

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

	$util = Utilisateur_recuperer($this->id_utilisateur);
	$util->DEL();

	$id_adherent = $this->id_adherent;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."adherent A, ".$GLOBALS['prefix']."sys_utilisateurs S
				WHERE id_adherent = $id_adherent
				AND A.id_utilisateur = U.id_utilisateur";

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
	$str = Lib_addElem($str, $this->id_adherent);
	$str = Lib_addElem($str, $this->id_utilisateur);
	$str = Lib_addElem($str, $this->id_interne);
	$str = Lib_addElem($str, $this->nom);
	$str = Lib_addElem($str, $this->prenom);
	$str = Lib_addElem($str, $this->enseigne);
	$str = Lib_addElem($str, $this->raison_sociale);
	$str = Lib_addElem($str, $this->adresse1);
	$str = Lib_addElem($str, $this->adresse2);
	$str = Lib_addElem($str, $this->cp);
	$str = Lib_addElem($str, $this->ville);
	$str = Lib_addElem($str, $this->pays);
	$str = Lib_addElem($str, $this->telephone);
	$str = Lib_addElem($str, $this->fax);
	$str = Lib_addElem($str, $this->email);
	$str = Lib_addElem($str, $this->site_internet);
	$str = Lib_addElem($str, $this->entreprise_qualifiee);
	$str = Lib_addElem($str, $this->logo);
	$str = Lib_addElem($str, $this->categorie);
	$str = Lib_addElem($str, $this->nature_lien);
	$str = Lib_addElem($str, $this->info_publique);
	$str = Lib_addElem($str, $this->categorie1);
	$str = Lib_addElem($str, $this->categorie2);
	$str = Lib_addElem($str, $this->categorie3);
	$str = Lib_addElem($str, $this->categorie4);
	$str = Lib_addElem($str, $this->categorie5);
	$str = Lib_addElem($str, $this->categorie6);
	$str = Lib_addElem($str, $this->categorie7);
	$str = Lib_addElem($str, $this->categorie8);
	$str = Lib_addElem($str, $this->categorie9);
	$str = Lib_addElem($str, $this->categorie10);
	$str = Lib_addElem($str, $this->site_internet);
	$str = Lib_addElem($str, $this->latitude);
	$str = Lib_addElem($str, $this->longitude);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_adherent);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recupère toutes les données relatives à un adherent suivant son identifiant
et retourne la coquille "Adherent" remplie avec les informations récupérées
de la base.
@param id_adherent.
*/
function Adherent_recuperer($id_adherent)
{
	$adherent = new Adherent();

	$sql = " SELECT A.*, U.code_utilisateur, U.nom_groupe, U.nom_utilisateur, U.password, U.nb_connect, U.lang, U.info_utilisateur
				FROM ".$GLOBALS['prefix']."adherent A, ".$GLOBALS['prefix']."sys_utilisateurs U
				WHERE id_adherent = '$id_adherent'
				AND A.id_utilisateur = U.id_utilisateur";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$adherent->id_adherent				= $row['id_adherent'];
		$adherent->id_utilisateur			= $row['id_utilisateur'];
		$adherent->nom_utilisateur			= $row['nom_utilisateur'];
		$adherent->password					= $row['password'];
		$adherent->id_interne				= $row['id_interne'];
		$adherent->nom					= Sql_prepareTexteAffichage($row['nom']);
		$adherent->prenom					= Sql_prepareTexteAffichage($row['prenom']);
		$adherent->enseigne					= Sql_prepareTexteAffichage($row['enseigne']);
		$adherent->raison_sociale			= Sql_prepareTexteAffichage($row['raison_sociale']);
		$adherent->adresse1					= Sql_prepareTexteAffichage($row['adresse1']);
		$adherent->adresse2					= Sql_prepareTexteAffichage($row['adresse2']);
		$adherent->cp							= Sql_prepareTexteAffichage($row['cp']);
		$adherent->ville						= Sql_prepareTexteAffichage($row['ville']);
		$adherent->pays						= Sql_prepareTexteAffichage($row['pays']);
		$adherent->telephone					= Sql_prepareTexteAffichage($row['telephone']);
		$adherent->fax							= Sql_prepareTexteAffichage($row['fax']);
		$adherent->email						= $row['email'];
		$adherent->site_internet			= $row['site_internet'];
		$adherent->entreprise_qualifiee	= $row['entreprise_qualifiee'];
		$adherent->logo						= $row['logo'];
		$adherent->categorie					= $row['categorie'];
		$adherent->nature_lien				= $row['nature_lien'];
		$adherent->info_publique			= $row['info_publique'];
		$adherent->categorie1				= $row['categorie1'];
		$adherent->categorie2				= $row['categorie2'];
		$adherent->categorie3				= $row['categorie3'];
		$adherent->categorie4				= $row['categorie4'];
		$adherent->categorie5				= $row['categorie5'];
		$adherent->categorie6				= $row['categorie6'];
		$adherent->categorie7				= $row['categorie7'];
		$adherent->categorie8				= $row['categorie8'];
		$adherent->categorie9				= $row['categorie9'];
		$adherent->categorie10				= $row['categorie10'];
		$adherent->latitude					= $row['latitude'];
		$adherent->longitude					= $row['longitude'];
		$adherent->etat						= $row['etat'];
		$adherent->date_add					= $row['date_add'];
		$adherent->date_upd					= $row['date_upd'];
		$adherent->info_adherent			= $row['info_adherent'];
		$adherent->code_utilisateur		= $row['code_utilisateur'];
		$adherent->nom_groupe				= $row['nom_groupe'];
		$adherent->nom_utilisateur			= $row['nom_utilisateur'];
		$adherent->password					= $row['password'];
		$adherent->nb_connect				= $row['nb_connect'];
		$adherent->lang						= $row['lang'];
		$adherent->info_utilisateur = $row['info_utilisateur'];
	}
	return $adherent;
}

/**
Retourne un tableau de adherents correspondant aux champs du tableau en argument.
@param $args
*/
function Adherents_chercher($args)
{
	$tab_result = array();

	$sql = " SELECT A.*, U.nom_utilisateur, U.password
				FROM ".$GLOBALS['prefix']."adherent A, ".$GLOBALS['prefix']."sys_utilisateurs U
				WHERE A.id_utilisateur = U.id_utilisateur";

	if (!isset($args['id_adherent']) && !isset($args['id_interne']) && !isset($args['id_utilisateur']) && !isset($args['nom']) && !isset($agrs['prenom'])
		 && !isset($args['enseigne']) && !isset($args['email']) && !isset($args['not_email'])
		 && !isset($args['raison_sociale']) && !isset($args['cp']) && !isset($args['ville']) && !isset($args['not_latitude']) && !isset($args['categorie']) && !isset($args['nature_lien']) 
		 && !isset($args['categorie1']) && !isset($args['categorie2']) && !isset($args['categorie3']) && !isset($args['categorie4']) && !isset($args['categorie5']) 
		 && !isset($args['categorie6']) && !isset($args['categorie7']) && !isset($args['categorie8']) && !isset($args['categorie9']) && !isset($args['categorie10']) 
		 && !isset($args['tab_categorie1']) && !isset($args['tab_categorie2']) && !isset($args['tab_categorie3'])
		 && !isset($args['pays']) && !isset($args['etat']) && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['entreprise_qualifiee']) 
		 && !isset($args['tab_ids_adherents']) && !isset($args['tab_cps']))
		return $tab_result;

	$condition="";

	if (isset($args['id_adherent']) && $args['id_adherent'] != "*")
		$condition .= " AND id_adherent = '".$args['id_adherent']."' ";
	if (isset($args['id_interne']))
		$condition .= " AND id_interne = '".$args['id_interne']."' ";
	if (isset($args['id_utilisateur']))
		$condition .= " AND A.id_utilisateur = '".$args['id_utilisateur']."' ";
	if (isset($args['nom']))
		$condition .= " AND nom LIKE '".Sql_prepareTexteStockage($args['nom'])."' ";
	if (isset($args['prenom']))
		$condition .= " AND prenom LIKE '".Sql_prepareTexteStockage($args['prenom'])."' ";
	if (isset($args['enseigne']))
		$condition .= " AND enseigne LIKE '".Sql_prepareTexteStockage($args['enseigne'])."' ";
	if (isset($args['email']))
		$condition .= " AND email LIKE '".$args['email']."' ";
	if (isset($args['not_email']))
		$condition .= " AND email NOT LIKE '".$args['not_email']."' ";
	if (isset($args['raison_sociale']))
		$condition .= " AND raison_sociale LIKE '".Sql_prepareTexteStockage($args['raison_sociale'])."' ";
	if (isset($args['cp']))
		$condition .= " AND cp LIKE '".Sql_prepareTexteStockage($args['cp'])."' ";
	if (isset($args['ville']))
		$condition .= " AND ville LIKE '".Sql_prepareTexteStockage($args['ville'])."' ";
	if (isset($args['pays']))
		$condition .= " AND pays LIKE '".Sql_prepareTexteStockage($args['pays'])."' ";
	if (isset($args['not_latitude']))
		$condition .= " AND latitude NOT LIKE '".$args['not_latitude']."' ";
	if (isset($args['entreprise_qualifiee']))
		$condition .= " AND entreprise_qualifiee = ".$args['entreprise_qualifiee']." ";
	if (isset($args['categorie']))
		$condition .= " AND categorie LIKE '".$args['categorie']."' ";
	if (isset($args['nature_lien']))
		$condition .= " AND nature_lien LIKE '".$args['nature_lien']."' ";
	if (isset($args['categorie1']))
		$condition .= " AND categorie1 LIKE '".$args['categorie1']."' ";
	if (isset($args['categorie2']))
		$condition .= " AND categorie2 LIKE '".$args['categorie2']."' ";
	if (isset($args['categorie3']))
		$condition .= " AND categorie3 LIKE '".$args['categorie3']."' ";
	if (isset($args['categorie4']))
		$condition .= " AND categorie4 LIKE '".$args['categorie4']."' ";
	if (isset($args['categorie5']))
		$condition .= " AND categorie5 LIKE '".$args['categorie5']."' ";
	if (isset($args['categorie6']))
		$condition .= " AND categorie6 LIKE '".$args['categorie6']."' ";
	if (isset($args['categorie7']))
		$condition .= " AND categorie7 LIKE '".$args['categorie7']."' ";
	if (isset($args['categorie8']))
		$condition .= " AND categorie8 LIKE '".$args['categorie8']."' ";
	if (isset($args['categorie9']))
		$condition .= " AND categorie9 LIKE '".$args['categorie9']."' ";
	if (isset($args['categorie10']))
		$condition .= " AND categorie10 LIKE '".$args['categorie10']."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND A.etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_adherents']) && $args['tab_ids_adherents'] != "*") {
		$ids = implode(",", $args['tab_ids_adherents']);
		$condition .= " AND id_adherent IN (0".$ids.") ";
	}
	if (isset($args['tab_cps'])) { 
		$condition .= " AND ( ";
		$nb = count($args['tab_cps']);
		for($i=1; $i<=$nb; $i++) {
			$cp = array_pop($args['tab_cps']);
			$condition .= " cp LIKE '".$cp."%' ";
			if ($i < $nb) $condition .= " OR ";
		}
		$condition .= " ) ";
	}

	if (isset($args['tab_categorie'])) { 
		$condition .= " AND (";
		for($i=0; count($args['tab_categorie']); $i++) {
			$id = array_pop($args['tab_categorie']);
			$condition .= " categorie LIKE '%{$id}%' ";
			if (count($args['tab_categorie'])) 
				$condition .= " OR ";
		}
		$condition .= ")";
	}
	if (isset($args['tab_categorie1'])) { 
		$condition .= " AND (";
		for($i=0; count($args['tab_categorie1']); $i++) {
			$id = array_pop($args['tab_categorie1']);
			$condition .= " categorie1 LIKE '%|{$id}|%' ";
			if (count($args['tab_categorie1'])) 
				$condition .= " OR ";
		}
		$condition .= ")";
	}
	if (isset($args['tab_categorie2'])) { 
		$condition .= " AND (";
		for($i=0; count($args['tab_categorie2']); $i++) {
			$id = array_pop($args['tab_categorie2']);
			$condition .= " categorie2 LIKE '%|{$id}|%' ";
			if (count($args['tab_categorie2'])) 
				$condition .= " OR ";
		}
		$condition .= ")";
	}
	if (isset($args['tab_categorie3'])) { 
		$condition .= " AND (";
		for($i=0; count($args['tab_categorie3']); $i++) {
			$id = array_pop($args['tab_categorie3']);
			$condition .= " categorie3 LIKE '%|{$id}|%' ";
			if (count($args['tab_categorie3'])) 
				$condition .= " OR ";
		}
		$condition .= ")";
	}

	if (!isset($args['etat']))
		$condition .= " AND A.etat != 'supprime' ";

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

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
			$id = $row['id_adherent'];
			$tab_result[$id]["id_adherent"]				= $id;
			$tab_result[$id]["id_utilisateur"]			= $row['id_utilisateur'];
			$tab_result[$id]["id_interne"]				= $row['id_interne'];
			$tab_result[$id]["nom"]					= Sql_prepareTexteAffichage($row['nom']);
			$tab_result[$id]["prenom"]					= Sql_prepareTexteAffichage($row['prenom']);
			$tab_result[$id]["enseigne"]					= Sql_prepareTexteAffichage($row['enseigne']);
			$tab_result[$id]["raison_sociale"]			= Sql_prepareTexteAffichage($row['raison_sociale']);
			$tab_result[$id]["adresse1"]					= Sql_prepareTexteAffichage($row['adresse1']);
			$tab_result[$id]["adresse2"]					= Sql_prepareTexteAffichage($row['adresse2']);
			$tab_result[$id]["cp"]							= Sql_prepareTexteAffichage($row['cp']);
			$tab_result[$id]["ville"]						= Sql_prepareTexteAffichage($row['ville']);
			$tab_result[$id]["pays"]						= Sql_prepareTexteAffichage($row['pays']);
			$tab_result[$id]["telephone"]					= Sql_prepareTexteAffichage($row['telephone']);
			$tab_result[$id]["fax"]							= Sql_prepareTexteAffichage($row['fax']);
			$tab_result[$id]["email"]						= $row['email'];
			$tab_result[$id]["site_internet"]			= $row['site_internet'];
			$tab_result[$id]["entreprise_qualifiee"]	= $row['entreprise_qualifiee'];
			$tab_result[$id]["logo"]						= $row['logo'];
			$tab_result[$id]["categorie"]					= Sql_prepareTexteAffichage($row['categorie']);
			$tab_result[$id]["nature_lien"]				= Sql_prepareTexteAffichage($row['nature_lien']);
			$tab_result[$id]["info_publique"]			= Sql_prepareTexteAffichage($row['info_publique']);
			$tab_result[$id]["categorie1"]				= $row['categorie1'];
			$tab_result[$id]["categorie2"]				= $row['categorie2'];
			$tab_result[$id]["categorie3"]				= $row['categorie3'];
			$tab_result[$id]["categorie4"]				= $row['categorie4'];
			$tab_result[$id]["categorie5"]				= $row['categorie5'];
			$tab_result[$id]["categorie6"]				= $row['categorie6'];
			$tab_result[$id]["categorie7"]				= $row['categorie7'];
			$tab_result[$id]["categorie8"]				= $row['categorie8'];
			$tab_result[$id]["categorie9"]				= $row['categorie9'];
			$tab_result[$id]["categorie10"]				= $row['categorie10'];
			$tab_result[$id]["latitude"]					= $row['latitude'];
			$tab_result[$id]["longitude"]					= $row['longitude'];
			$tab_result[$id]["etat"]						= $row['etat'];
			$tab_result[$id]["date_add"]					= $row['date_add'];
			$tab_result[$id]["date_upd"]					= $row['date_upd'];
			$tab_result[$id]["info_adherent"]			= $row['info_adherent'];
			$tab_result[$id]["nom_utilisateur"]			= $row['nom_utilisateur'];
			$tab_result[$id]["password"]					= $row['password'];
		}
	}

	if (count($tab_result) == 1 && !isset($args['tab']) && ($args['id_adherent'] != '' && $args['id_adherent'] != '*'))
		$tab_result = array_pop($tab_result);
	if (count($tab_result) == 1 && !isset($args['tab']) && ($args['id_utilisateur'] != '' && $args['id_utilisateur'] != '*'))
		$tab_result = array_pop($tab_result);

	return $tab_result;
}
} // Fin if (!defined('__ADHERENT_INC__'))
?>