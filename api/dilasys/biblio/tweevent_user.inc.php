<? // DEBUT DU BLOC PARAMETRAGE NE PAS MODIFIER
/** @file
*  @brief this file in Tweevent_users
*/

/**
 * Classe pour la gestion de tweevent_users
 *
 * @author dilas0ft & z3cN@$
 * @version 1.0
 * @code

CREATE TABLE `app_tweevent_user` (
	 `id_tweevent_user` INT(11) NOT NULL auto_increment,
	 `pseudo_tweevent_user` VARCHAR(255) NOT NULL,
	 `password_tweevent_user` VARCHAR(255) NOT NULL,
	 `type_tweevent_user` VARCHAR(255) NOT NULL,
	 `email_tweevent_user` VARCHAR(255) NOT NULL,
	 `date_de_naissance_tweevent_user` VARCHAR(255) NOT NULL,
	 `nb_jetons_tweevent_user` VARCHAR(255) NOT NULL,
	 `nb_connect_tweevent_user` VARCHAR(255) NOT NULL,
	 `ville_tweevent_user` VARCHAR(255) NOT NULL,
	 `code_postal_tweevent_user` VARCHAR(255) NOT NULL,
	 `adresse_1_tweevent_user` VARCHAR(255) NOT NULL,
	 `adresse_2_tweevent_user` VARCHAR(255) NOT NULL,
	 `tel_tweevent_user` VARCHAR(255) NOT NULL,
	 `mob_tweevent_user` VARCHAR(255) NOT NULL,
	 `derniere_ip_tweevent_user` VARCHAR(255) NOT NULL,
	 `etat` ENUM('actif', 'inactif', 'supprime') NOT NULL,
	 `date_add` VARCHAR(255) NOT NULL,
	 `date_upd` VARCHAR(255) NOT NULL,
	 `info_tweevent_user` VARCHAR(255) NOT NULL,
PRIMARY KEY(`id_tweevent_user`));

 * @endcode
 *
 */

// Clefs de recherche 
// Clef de recherche 1 : pseudo_tweevent_user
// Clef de recherche 2 : type_tweevent_user
// Clef de recherche 3 : date_de_naissance_tweevent_user
// Clef de recherche 4 : nb_connect_tweevent_user
// Clef de recherche 5 : etat

// Clefs secondaires
//
//
//
// FIN DU BLOC PARAMETRAGE
if (!defined('__TWEEVENT_USER_INC__')){
	define('__TWEEVENT_USER_INC__', 1);

class Tweevent_user extends Element {
	var $id_tweevent_user;
	var $pseudo_tweevent_user;
	var $password_tweevent_user;
	var $type_tweevent_user;
	var $email_tweevent_user;
	var $date_de_naissance_tweevent_user;
	var $nb_jetons_tweevent_user;
	var $nb_connect_tweevent_user;
	var $ville_tweevent_user;
	var $code_postal_tweevent_user;
	var $adresse_1_tweevent_user;
	var $adresse_2_tweevent_user;
	var $tel_tweevent_user;
	var $mob_tweevent_user;
	var $derniere_ip_tweevent_user;
	var $etat;
	var $date_add;
	var $date_upd;
	var $info_tweevent_user;

/** 
Constructeur de la classe.
*/
function Tweevent_user()
{
	$this->type_moi = "tweevent_users";
}

/**
Cette fonction retourne un tableau correspondant aux diff�rents attributs de Tweevent_user.
*/
function getTab()
{
	$tab['id_tweevent_user']						= $this->id_tweevent_user;
	$tab['pseudo_tweevent_user']					= $this->pseudo_tweevent_user;
	$tab['password_tweevent_user']				= $this->password_tweevent_user;
	$tab['type_tweevent_user']						= $this->type_tweevent_user;
	$tab['email_tweevent_user']					= $this->email_tweevent_user;
	$tab['date_de_naissance_tweevent_user']	= $this->date_de_naissance_tweevent_user;
	$tab['nb_jetons_tweevent_user']				= $this->nb_jetons_tweevent_user;
	$tab['nb_connect_tweevent_user']				= $this->nb_connect_tweevent_user;
	$tab['ville_tweevent_user']					= $this->ville_tweevent_user;
	$tab['code_postal_tweevent_user']			= $this->code_postal_tweevent_user;
	$tab['adresse_1_tweevent_user']				= $this->adresse_1_tweevent_user;
	$tab['adresse_2_tweevent_user']				= $this->adresse_2_tweevent_user;
	$tab['tel_tweevent_user']						= $this->tel_tweevent_user;
	$tab['mob_tweevent_user']						= $this->mob_tweevent_user;
	$tab['derniere_ip_tweevent_user']			= $this->derniere_ip_tweevent_user;
	$tab['etat']										= $this->etat;
	$tab['date_add']									= $this->date_add;
	$tab['date_upd']									= $this->date_upd;
	$tab['info_tweevent_user']						= $this->info_tweevent_user;
	return $tab;
}

/**
Cette fonction ajoute un element de la table tweevent_user � la BDD. 
*/
function ADD()
{
	$pseudo_tweevent_user 					= Sql_prepareTexteStockage($this->pseudo_tweevent_user);
	$password_tweevent_user 				= Sql_prepareTexteStockage($this->password_tweevent_user);
	$type_tweevent_user 						= Sql_prepareTexteStockage($this->type_tweevent_user);
	$email_tweevent_user 					= Sql_prepareTexteStockage($this->email_tweevent_user);
	$date_de_naissance_tweevent_user 	= Sql_prepareTexteStockage($this->date_de_naissance_tweevent_user);
	$nb_jetons_tweevent_user 				= Sql_prepareTexteStockage($this->nb_jetons_tweevent_user);
	$nb_connect_tweevent_user 				= Sql_prepareTexteStockage($this->nb_connect_tweevent_user);
	$ville_tweevent_user 					= Sql_prepareTexteStockage($this->ville_tweevent_user);
	$code_postal_tweevent_user 			= Sql_prepareTexteStockage($this->code_postal_tweevent_user);
	$adresse_1_tweevent_user 				= Sql_prepareTexteStockage($this->adresse_1_tweevent_user);
	$adresse_2_tweevent_user 				= Sql_prepareTexteStockage($this->adresse_2_tweevent_user);
	$tel_tweevent_user 						= Sql_prepareTexteStockage($this->tel_tweevent_user);
	$mob_tweevent_user 						= Sql_prepareTexteStockage($this->mob_tweevent_user);
	$derniere_ip_tweevent_user 			= Sql_prepareTexteStockage($this->derniere_ip_tweevent_user);
	$etat 										= $this->etat != '' ? $this->etat : 'actif';
	$date_add 									= time();
	$info_tweevent_user 						= Sql_prepareTexteStockage($this->info_tweevent_user);

	$sql = " INSERT INTO ".$GLOBALS['prefix']."tweevent_user
					(pseudo_tweevent_user, password_tweevent_user, type_tweevent_user, 
					email_tweevent_user, date_de_naissance_tweevent_user, nb_jetons_tweevent_user, 
					nb_connect_tweevent_user, ville_tweevent_user, code_postal_tweevent_user, 
					adresse_1_tweevent_user, adresse_2_tweevent_user, tel_tweevent_user, 
					mob_tweevent_user, derniere_ip_tweevent_user, etat, 
					date_add, info_tweevent_user
					)
				VALUES 
					 ('$pseudo_tweevent_user', '$password_tweevent_user', '$type_tweevent_user', 
					'$email_tweevent_user', '$date_de_naissance_tweevent_user', '$nb_jetons_tweevent_user', 
					'$nb_connect_tweevent_user', '$ville_tweevent_user', '$code_postal_tweevent_user', 
					'$adresse_1_tweevent_user', '$adresse_2_tweevent_user', '$tel_tweevent_user', 
					'$mob_tweevent_user', '$derniere_ip_tweevent_user', '$etat', 
					'$date_add', '$info_tweevent_user'
					)";

	if (!Sql_exec($sql)) $this->setError(ERROR);

	if (!$this->isError()) {
		$id_tweevent_user = Sql_lastInsertId(); 
		Lib_sqlLog($sql." -- $id_tweevent_user");
		$this->id_tweevent_user = $this->id_tweevent_user;
		return $id_tweevent_user;
	}
	return;
}

/**
Cette fonction modifie un �l�ment de la table tweevent_user dans la BDD. 
*/
function UPD()
{
	$id_tweevent_user 						= is_numeric($this->id_tweevent_user) ? $this->id_tweevent_user : 0;
	$pseudo_tweevent_user 					= Sql_prepareTexteStockage($this->pseudo_tweevent_user);
	$password_tweevent_user 				= Sql_prepareTexteStockage($this->password_tweevent_user);
	$type_tweevent_user 						= Sql_prepareTexteStockage($this->type_tweevent_user);
	$email_tweevent_user 					= Sql_prepareTexteStockage($this->email_tweevent_user);
	$date_de_naissance_tweevent_user 	= Sql_prepareTexteStockage($this->date_de_naissance_tweevent_user);
	$nb_jetons_tweevent_user 				= Sql_prepareTexteStockage($this->nb_jetons_tweevent_user);
	$nb_connect_tweevent_user 				= Sql_prepareTexteStockage($this->nb_connect_tweevent_user);
	$ville_tweevent_user 					= Sql_prepareTexteStockage($this->ville_tweevent_user);
	$code_postal_tweevent_user 			= Sql_prepareTexteStockage($this->code_postal_tweevent_user);
	$adresse_1_tweevent_user 				= Sql_prepareTexteStockage($this->adresse_1_tweevent_user);
	$adresse_2_tweevent_user 				= Sql_prepareTexteStockage($this->adresse_2_tweevent_user);
	$tel_tweevent_user 						= Sql_prepareTexteStockage($this->tel_tweevent_user);
	$mob_tweevent_user 						= Sql_prepareTexteStockage($this->mob_tweevent_user);
	$derniere_ip_tweevent_user 			= Sql_prepareTexteStockage($this->derniere_ip_tweevent_user);
	$etat 										= $this->etat;
	$date_upd 									= time();
	$info_tweevent_user 						= Sql_prepareTexteStockage($this->info_tweevent_user);

	$sql = " UPDATE ".$GLOBALS['prefix']."tweevent_user
				SET pseudo_tweevent_user = '$pseudo_tweevent_user', password_tweevent_user = '$password_tweevent_user', type_tweevent_user = '$type_tweevent_user', 
					email_tweevent_user = '$email_tweevent_user', date_de_naissance_tweevent_user = '$date_de_naissance_tweevent_user', nb_jetons_tweevent_user = '$nb_jetons_tweevent_user', 
					nb_connect_tweevent_user = '$nb_connect_tweevent_user', ville_tweevent_user = '$ville_tweevent_user', code_postal_tweevent_user = '$code_postal_tweevent_user', 
					adresse_1_tweevent_user = '$adresse_1_tweevent_user', adresse_2_tweevent_user = '$adresse_2_tweevent_user', tel_tweevent_user = '$tel_tweevent_user', 
					mob_tweevent_user = '$mob_tweevent_user', derniere_ip_tweevent_user = '$derniere_ip_tweevent_user', etat = '$etat', 
					date_upd = '$date_upd', info_tweevent_user = '$info_tweevent_user'
					
				WHERE id_tweevent_user = $id_tweevent_user";

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

	$id_tweevent_user = $this->id_tweevent_user;

	$sql = " DELETE FROM ".$GLOBALS['prefix']."tweevent_user
				WHERE id_tweevent_user = $id_tweevent_user";

	if (!Sql_exec($sql)) $this->setError(ERROR);
	if (!$this->isError()) Lib_sqlLog($sql);

	return;
}

/** 
Cette fonction transforme les attributs en chaine de caract�res.
*/
function toStr()
{
	$str = "";
	$str = Lib_addElem($str, $this->id_tweevent_user);
	$str = Lib_addElem($str, $this->pseudo_tweevent_user);
	$str = Lib_addElem($str, $this->password_tweevent_user);
	$str = Lib_addElem($str, $this->type_tweevent_user);
	$str = Lib_addElem($str, $this->email_tweevent_user);
	$str = Lib_addElem($str, $this->date_de_naissance_tweevent_user);
	$str = Lib_addElem($str, $this->nb_jetons_tweevent_user);
	$str = Lib_addElem($str, $this->nb_connect_tweevent_user);
	$str = Lib_addElem($str, $this->ville_tweevent_user);
	$str = Lib_addElem($str, $this->code_postal_tweevent_user);
	$str = Lib_addElem($str, $this->adresse_1_tweevent_user);
	$str = Lib_addElem($str, $this->adresse_2_tweevent_user);
	$str = Lib_addElem($str, $this->tel_tweevent_user);
	$str = Lib_addElem($str, $this->mob_tweevent_user);
	$str = Lib_addElem($str, $this->derniere_ip_tweevent_user);
	$str = Lib_addElem($str, $this->etat);
	$str = Lib_addElem($str, $this->date_add);
	$str = Lib_addElem($str, $this->date_upd);
	$str = Lib_addElem($str, $this->info_tweevent_user);
	$str = "(".$str.")";
	return $str;
}
}

/**
Recup�re toutes les donn�es relatives � un tweevent_user suivant son identifiant
et retourne la coquille "Tweevent_user" remplie avec les informations r�cup�r�es
de la base.
@param id_tweevent_user.
*/
function Tweevent_user_recuperer($id_tweevent_user)
{
	$tweevent_user = new Tweevent_user();

	$sql = " SELECT *
				FROM ".$GLOBALS['prefix']."tweevent_user
				WHERE id_tweevent_user = '$id_tweevent_user';";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
		$tweevent_user->id_tweevent_user						= $row['id_tweevent_user'];
		$tweevent_user->pseudo_tweevent_user					= Sql_prepareTexteAffichage($row['pseudo_tweevent_user']);
		$tweevent_user->password_tweevent_user				= Sql_prepareTexteAffichage($row['password_tweevent_user']);
		$tweevent_user->type_tweevent_user						= Sql_prepareTexteAffichage($row['type_tweevent_user']);
		$tweevent_user->email_tweevent_user					= Sql_prepareTexteAffichage($row['email_tweevent_user']);
		$tweevent_user->date_de_naissance_tweevent_user	= Sql_prepareTexteAffichage($row['date_de_naissance_tweevent_user']);
		$tweevent_user->nb_jetons_tweevent_user				= Sql_prepareTexteAffichage($row['nb_jetons_tweevent_user']);
		$tweevent_user->nb_connect_tweevent_user				= Sql_prepareTexteAffichage($row['nb_connect_tweevent_user']);
		$tweevent_user->ville_tweevent_user					= Sql_prepareTexteAffichage($row['ville_tweevent_user']);
		$tweevent_user->code_postal_tweevent_user			= Sql_prepareTexteAffichage($row['code_postal_tweevent_user']);
		$tweevent_user->adresse_1_tweevent_user				= Sql_prepareTexteAffichage($row['adresse_1_tweevent_user']);
		$tweevent_user->adresse_2_tweevent_user				= Sql_prepareTexteAffichage($row['adresse_2_tweevent_user']);
		$tweevent_user->tel_tweevent_user						= Sql_prepareTexteAffichage($row['tel_tweevent_user']);
		$tweevent_user->mob_tweevent_user						= Sql_prepareTexteAffichage($row['mob_tweevent_user']);
		$tweevent_user->derniere_ip_tweevent_user			= Sql_prepareTexteAffichage($row['derniere_ip_tweevent_user']);
		$tweevent_user->etat										= $row['etat'];
		$tweevent_user->date_add									= $row['date_add'];
		$tweevent_user->date_upd									= $row['date_upd'];
		$tweevent_user->info_tweevent_user						= Sql_prepareTexteAffichage($row['info_tweevent_user']);
	}
	return $tweevent_user;
}

/**
Retourne un tableau de tweevent_users correspondant aux champs du tableau en argument.
@param $args
*/
function Tweevent_users_chercher($args)
{
	$count = 0;

	$tab_result = array();

	if (isset($args['count'])) {
		$sql = " SELECT count(*) nb_enregistrements 
					FROM ".$GLOBALS['prefix']."tweevent_user
					WHERE 1";
	} else {
		$sql = " SELECT * 
					FROM ".$GLOBALS['prefix']."tweevent_user
					WHERE 1";
	}

	if (!isset($args['id_tweevent_user']) && !isset($args['pseudo_tweevent_user']) && !isset($args['type_tweevent_user'])
		 && !isset($args['date_de_naissance_tweevent_user']) && !isset($args['nb_connect_tweevent_user']) && !isset($args['etat'])
		 && !isset($args['order_by']) && !isset($args['etat']) && !isset($args['tab_ids_tweevent_users']))
		return $tab_result;

	$condition="";

	if (isset($args['id_tweevent_user']) && $args['id_tweevent_user'] != "*")
		$condition .= " AND id_tweevent_user = '".$args['id_tweevent_user']."' ";
	if (isset($args['pseudo_tweevent_user']) && $args['pseudo_tweevent_user'] != "*")
		$condition .= " AND pseudo_tweevent_user LIKE '".Sql_prepareTexteStockage($args['pseudo_tweevent_user'])."' ";
	if (isset($args['type_tweevent_user']) && $args['type_tweevent_user'] != "*")
		$condition .= " AND type_tweevent_user LIKE '".Sql_prepareTexteStockage($args['type_tweevent_user'])."' ";
	if (isset($args['date_de_naissance_tweevent_user']) && $args['date_de_naissance_tweevent_user'] != "*")
		$condition .= " AND date_de_naissance_tweevent_user LIKE '".Sql_prepareTexteStockage($args['date_de_naissance_tweevent_user'])."' ";
	if (isset($args['nb_connect_tweevent_user']) && $args['nb_connect_tweevent_user'] != "*")
		$condition .= " AND nb_connect_tweevent_user LIKE '".Sql_prepareTexteStockage($args['nb_connect_tweevent_user'])."' ";
	if (isset($args['etat']) && $args['etat'] != "*")
		$condition .= " AND etat = '".$args['etat']."' ";

	if (isset($args['tab_ids_tweevent_users']) && $args['tab_ids_tweevent_users'] != "*") {
		$ids = implode(",", $args['tab_ids_tweevent_users']);
		$condition .= " AND id_tweevent_user IN (0".$ids.") ";
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
				$id = $row['id_tweevent_user'];
				$tab_result[$id]["id_tweevent_user"]						= $id;
				$tab_result[$id]["pseudo_tweevent_user"]					= Sql_prepareTexteAffichage($row['pseudo_tweevent_user']);
				$tab_result[$id]["password_tweevent_user"]				= Sql_prepareTexteAffichage($row['password_tweevent_user']);
				$tab_result[$id]["type_tweevent_user"]						= Sql_prepareTexteAffichage($row['type_tweevent_user']);
				$tab_result[$id]["email_tweevent_user"]					= Sql_prepareTexteAffichage($row['email_tweevent_user']);
				$tab_result[$id]["date_de_naissance_tweevent_user"]	= Sql_prepareTexteAffichage($row['date_de_naissance_tweevent_user']);
				$tab_result[$id]["nb_jetons_tweevent_user"]				= Sql_prepareTexteAffichage($row['nb_jetons_tweevent_user']);
				$tab_result[$id]["nb_connect_tweevent_user"]				= Sql_prepareTexteAffichage($row['nb_connect_tweevent_user']);
				$tab_result[$id]["ville_tweevent_user"]					= Sql_prepareTexteAffichage($row['ville_tweevent_user']);
				$tab_result[$id]["code_postal_tweevent_user"]			= Sql_prepareTexteAffichage($row['code_postal_tweevent_user']);
				$tab_result[$id]["adresse_1_tweevent_user"]				= Sql_prepareTexteAffichage($row['adresse_1_tweevent_user']);
				$tab_result[$id]["adresse_2_tweevent_user"]				= Sql_prepareTexteAffichage($row['adresse_2_tweevent_user']);
				$tab_result[$id]["tel_tweevent_user"]						= Sql_prepareTexteAffichage($row['tel_tweevent_user']);
				$tab_result[$id]["mob_tweevent_user"]						= Sql_prepareTexteAffichage($row['mob_tweevent_user']);
				$tab_result[$id]["derniere_ip_tweevent_user"]			= Sql_prepareTexteAffichage($row['derniere_ip_tweevent_user']);
				$tab_result[$id]["etat"]										= $row['etat'];
				$tab_result[$id]["date_add"]									= $row['date_add'];
				$tab_result[$id]["date_upd"]									= $row['date_upd'];
				$tab_result[$id]["info_tweevent_user"]						= Sql_prepareTexteAffichage($row['info_tweevent_user']);
			}
		}

		if (count($tab_result) == 1 && ($args['id_tweevent_user'] != '' && $args['id_tweevent_user'] != '*') || ($args['pseudo_tweevent_user'] != '' ))
			$tab_result = array_pop($tab_result);
	}

	return $tab_result;
}
} // Fin if (!defined('__TWEEVENT_USER_INC__'))
?>