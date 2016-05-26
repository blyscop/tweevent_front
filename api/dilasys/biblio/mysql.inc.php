<?
/**
 * Fonctions diverses pour la manipulation de requêtes SQL
 *
 * @author		dilasoft
 * @version	1.0
 */
if (!defined('__SQL_INC__')){
define('__SQL_INC__', 1);

/**
* Contruction d'un tableau avec la taille des requetes SQL trouvees dans un fichier
*
* @param sql_file Fichier contenant les requetes SQL
*/
function Sql_getSqlLenghts($sql_file)
{
	$handle = fopen($sql_file, "r");

	$SQL_SIZES = array();
	$size = 0;

	// On estime à 8192 la taille maximale des lignes. 1024 c'est trop court!
	// On doit positionner cette valeur pour compatibilité ascendante avec php 4.1.x
	while($line = fgets($handle,8192)) {
		$size += strlen($line);
		// Une requête se termine par un ";". Comme une requête peut aussi contenir d'autres ";",
		// on cherche un ";" à partir de la fin de ligne.
		$pos = strrpos($line,';');

		// Pour déterminer si la ligne est une fin de requête, il faut que les caractères après
		// le dernier ";" soient des espaces, retour chariot ou fin de ligne...
		if (is_integer($pos) && preg_match("/^([ \r\n]*)$/", substr($line, $pos+1, strlen($line)))) {
			array_push($SQL_SIZES, $size);
			$size = 0;
		}
	}

	fclose($handle);
	return $SQL_SIZES;	
}

/**
* Suppression des lignes de commentaire dans une requete SQL
*
* @param sql Ligne a nettoyer
*/
function Sql_getSqlTxt($sql)
{
	$sql			= trim($sql);
	$sql_len		= strlen($sql);
	$char			= '';
	$string_start = '';
	$in_string	= FALSE;
	$time0		= time();

	for ($i = 0; $i < $sql_len; ++$i) {
		$char = $sql[$i];

		// We are in a string, check for not escaped end of strings except for
		// backquotes that can't be escaped
		if ($in_string) {
			for (;;) {
				$i = strpos($sql, $string_start, $i);

				// No end of string found -> add the current substring to the
				// returned array
				if (!$i) {
					return $sql;
				}
				// Backquotes or no backslashes before quotes: it's indeed the
				// end of the string -> exit the loop
				else if ($string_start == '`' || $sql[$i-1] != '\\') {
					$string_start		= '';
					$in_string			= FALSE;
					break;
				}
				// one or more Backslashes before the presumed end of string...
				else {
					// ... first checks for escaped backslashes
					$j = 2;
					$escaped_backslash	= FALSE;
					while ($i-$j > 0 && $sql[$i-$j] == '\\') {
						$escaped_backslash = !$escaped_backslash;
						$j++;
					}
					// ... if escaped backslashes: it's really the end of the
					// string -> exit the loop
					if ($escaped_backslash) {
						$string_start  = '';
						$in_string	= FALSE;
						break;
					} else {
						$i++;
					}
				}
			}
		}

		// We are not in a string, first check for delimiter...
		else if ($char == ';') {
			// if delimiter found, add the parsed part to the returned array
			return $sql;
		}

		// ... then check for start of a string,...
		else if (($char == '"') || ($char == '\'') || ($char == '`')) {
			$in_string	= TRUE;
			$string_start = $char;
		} // end else if (is start of string)

		// ... for start of a comment (and remove this comment if found)...
		else if ($char == '#' || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
			// starting position of the comment depends on the comment type
			$start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
			// if no "\n" exits in the remaining string, checks for "\r"
			// (Mac eol style)
			$end_of_comment	= (strpos(' ' . $sql, "\012", $i+2))
									? strpos(' ' . $sql, "\012", $i+2)
									: strpos(' ' . $sql, "\015", $i+2);
			if (!$end_of_comment) {
				// no eol found after '#', add the parsed part to the returned
				// array if required and exit
				if ($start_of_comment > 0) {
					return trim(substr($sql, 0, $start_of_comment));
				}
			} else {
				$sql			= substr($sql, 0, $start_of_comment)
									. ltrim(substr($sql, $end_of_comment));
				$sql_len		= strlen($sql);
				$i--;
			} // end if...else
		} // end else if (is comment)
	} // end for

	// add any rest to the returned array
	if (!empty($sql) && preg_match('/[^[:space:]]+/', $sql)) {
		return $sql;
	}
}

/**
* Creation d'un fichier temporaire de sauvegarde contenant les instructions SQL
*
* @param out_file Fichier cible pour stockage des instructions SQL
*/
function Sql_buildSqlFile($out_file, $sql = '', $table = '') {
	$crlf=Lib_endOfLine();

	$out_handle = fopen($out_file, "w");

	fputs($out_handle,"# Serveur: " . $GLOBALS['serveur_mysql1']." BdD: ".$GLOBALS['db1']."$crlf");

	fputs($out_handle,$crlf);
	fputs($out_handle,"# --------------------------------------------------------$crlf");
	fputs($out_handle,"# DumpingData '".$GLOBALS['prefix']."$table'$crlf");
	fputs($out_handle,"# --------------------------------------------------------$crlf");
	fputs($out_handle,$crlf);

	fputs($out_handle,"DELETE from ".$GLOBALS['prefix']."$table;$crlf");
	fputs($out_handle,$crlf);

	if ($sql != "") {
		$sql = preg_replace('`;`',' ',$sql);
	} else {
		$sql = "SELECT * FROM ".$GLOBALS['db1'].".".$GLOBALS['prefix'].$table;	
	} 

	$result = Sql_query($sql);
	$sql = "";
	
	if(!$result) {
		echo $MSG[$lang]['ProblemeSql'];
		echo $MSG['fr']['MessageBase']. mysql_errno()." : ".mysql_error()."<BR>";
		return;
	}

	$nb_lines = mysql_num_rows($result);

	//============================================================================
	// Si la table n'a pas de lignes, on continue avec la table suivante
	//============================================================================
	if ($nb_lines == 0)
		return;

	//============================================================================
	// On construit la liste des champs pour eviter d'avoir des problemes d'INSERT
	//============================================================================
	$fields = "(";
	$list_fields = mysql_list_fields($GLOBALS['db1'], $GLOBALS['prefix'].$table);
	$columns = mysql_num_fields($list_fields);
	for ($i = 0; $i < $columns; $i++)
		$fields .= (strcmp($fields,"(") == 0) ? mysql_field_name($list_fields, $i) : ",".mysql_field_name($list_fields, $i);
	$fields .= ")";

	$insert_table = "INSERT INTO ".$GLOBALS['prefix']."$table $fields VALUES";
	$insert_table = trim($insert_table);

	$i = 0;
	while($i < $nb_lines) {
		fputs($out_handle,"$insert_table $crlf");
		$k = 0;

		//=============================================================
		// $lines_max represente le nombre de lignes maximum par INSERT
		// defini dans le conf.php
		//=============================================================
		while($k < $GLOBALS['lines_max']){
			$row = mysql_fetch_row($result);

			$schema_insert = "(";
			@set_time_limit(60);
			$table_list = "(";

			for($j=0; $j<mysql_num_fields($result);$j++)
				$table_list .= mysql_field_name($result,$j).", ";

			$table_list = substr($table_list,0,-2);
			$table_list .= ")";

			for($j=0; $j<mysql_num_fields($result);$j++) {
				if(!isset($row[$j]))
					$schema_insert .= " NULL,";

				elseif($row[$j] != "") {
					$dummy = "";
					// JPLt: Avant d'effectuer la boucle sur chaque ligne, on vérifie si les caractères à remplacer existent
					if (preg_match("/[\\\'\"\\x00\\x0a\\x0d\\x08\t\\x1a]/", $row[$j])) {
						$srcstr = $row[$j];
						for($xx=0; $xx < strlen($srcstr); $xx++) {
							$yy = strlen($dummy);
							if($srcstr[$xx] == "\\") $dummy .= "\\\\";
							if($srcstr[$xx] == "'") $dummy .= "\\'";
							if($srcstr[$xx] == "\"") $dummy .= "\\\"";
							if($srcstr[$xx] == "\x00") $dummy .= "\\0";
							if($srcstr[$xx] == "\x0a") $dummy .= "\\n";
							if($srcstr[$xx] == "\x0d") $dummy .= "\\r";
							if($srcstr[$xx] == "\x08") $dummy .= "\\b";
							if($srcstr[$xx] == "\t") $dummy .= "\\t";
							if($srcstr[$xx] == "\x1a") $dummy .= "\\Z";
							if(strlen($dummy) == $yy) $dummy .= $srcstr[$xx];
						}
					} else {
						$dummy = $row[$j];
					}	

					$schema_insert .= " '".$dummy."',";
				} else
					$schema_insert .= " '',";
			}

			$schema_insert = preg_replace("`,$`", "", $schema_insert);
			$schema_insert .= ")";
			$schema_insert = trim($schema_insert);

			//============================================================================
			// On ecrit dans le fichier temporaire
			//============================================================================
			if ($k == ($GLOBALS['lines_max']-1) || $i == ($nb_lines-1))
				fputs($out_handle,"$schema_insert;$crlf");			
			else
				fputs($out_handle,"$schema_insert,$crlf");			

			$k++;
			$i++;
			if ($i == $nb_lines) break;
		}
	}

	fclose($out_handle);  
}

/**
* Lecture d'un fichier contenant les requetes SQL et exécution
*
* @param sql_file Fichier contenant les requetes
*/
function Sql_execSqlFile($sql_file) {
	global $MSG, $lang;
	
	/**
	* On construit un tableau avec les longueurs de chaque requete SQL
	* Chaque element du tableau nous aide a récupérer requête par requête
	* pour éviter des problemes de chargement avec de gros fichiers
	*/
	$sizes_array = Sql_getSqlLenghts($sql_file);
	$handle = fopen($sql_file, "r");
	
	foreach($sizes_array as $size_unit) {
		$sql_query = fread($handle, $size_unit);
	
		if ($sql_query != '') {
			if (get_magic_quotes_runtime() == 1) {
				$sql_query = stripslashes($sql_query);
			}
	
			$sql_query = trim($sql_query);
			$sql_query = Sql_getSqlTxt($sql_query);
	
			//==================================================================================
			// On effectue quelques controles sur les requetes
			// On ne laisse passer que les requetes dont les tables sont referencees
			// dans le conf.php et de type INSERT, SELECT et DELETE
			//==================================================================================		
			$bad_request =  TRUE;
			preg_match("`(select|insert|delete) (into|from) ([a-zA-Z0-9_]+)`i",$sql_query,$tab);
	
			foreach ($GLOBALS['AUTH_TABLES'] as $table) {
				Lib_sqlLog("Verification pour ".$tab[3]);
				if(preg_match("`".$table."`i", $tab[3])) {
					/*=============*/ Lib_sqlLog("{$tab[3]} autorisee");
					$bad_request = FALSE;
				} else {
					/*=============*/ Lib_sqlLog("{$tab[3]} non autorisee");
				}
			}
			
			if($bad_request && $GLOBALS['stop_bad_sql']) {
				$error_message = "<b> ".$MSG[$lang]['%%RequeteInterdite%%']." </b>";
				$error_message .= "<br>$sql_query<br>";
				fclose($handle);
				return $error_message;
			} 

			if($bad_request) {					
					continue;
			}
	
			$result = mysql_query($sql_query);
	
			//=================================================================
			// On verifie la bonne execution de la requete
			//=================================================================
			if ($result == FALSE) { 
				$error_message = "<b> ".$MSG[$lang]['%%ProblemeSql%%']." </b>";				
				$error_message .= "<b> ".mysql_error()." </b>";
				$error_message .= "<br> <b> Requ&egrave;te: </b> $sql_query <br>";
				Lib_sqlLog(mysql_error());
				fclose($handle);
				return $error_message; 
			} else {
				Lib_sqlLog("Requete executee avec succes: ".mysql_error());
			}
		}
	}
	
	fclose($handle);
	return "";
}

if (!function_exists('is_uploaded_file')) {
	function is_uploaded_file($filename) {
		if (!$tmp_file = @get_cfg_var('upload_tmp_dir')) {
				$tmp_file = tempnam('','');
				$deleted  = @unlink($tmp_file);
				$tmp_file = dirname($tmp_file);
		}
		$tmp_file	.= '/' . basename($filename);

		// User might have trailing slash in php.ini...
		return (preg_replace('`/+`', '/', $tmp_file) == $filename);
	}
}

/* 
* Fonction de connexion à la base de données.
* Pour info, PHP ne va pas ouvrir une nouvelle connexion si un second appel à
* mysql_connect() est fait avec les mêmes arguments mais va retourner l'identifiant
* de la connexion déjà ouverte et nous n'aurons pas n connexions ouvertes simultanément.
*
* @param user Utilisateur pour se connecter a la base de donnees
* @param passwd Mot de passe de l'utilisateur
* @param database Base de données sur laquelle on veut se connecter
* @param serveur Serveur où se trouve la base de données. Peut être une adresse IP ou un nom de serveur
*/
function Sql_connect($user = '', $passwd = '', $database = '', $serveur = '') {
	$message = "";
		
	$continue = true;

	/** 
	* On utilise les sessions car les fonctions "gethostbyname" et "ereg" utilisées plus loin 
	* sont très gourmandes en CPU et ralentissent énormément la navigation.
	* Ces variables de session sont initialisées au premier accés réussi et dureront le temps de la 
	* connexion de l'utilisateur...
	*/
	if (isset($_SESSION[$GLOBALS['prefix'].'id'])) {
		$id = $_SESSION[$GLOBALS['prefix'].'id'];	
		$db_link = mysql_connect($GLOBALS['serveur_mysql'.$id],$GLOBALS['dbuser'.$id],$GLOBALS['dbpass'.$id]);

		if ($db_link ) {
			if (mysql_select_db($GLOBALS['db'.$id])){ 
					return $db_link;
				} else {
				echo "<font color=\"red\"> <b> Impossible de se re-connecter à la base! </b> </font><br>"; 
				exit;
				}
		} else {
				echo "<font color=\"red\"> <b> Impossible de se re-connecter au serveur MySQL! </b> </font><br>";
			exit;
		}
	}
	
	if ($user == '')	$user = $GLOBALS['dbuser1'];
	if ($passwd == '')	$passwd = $GLOBALS['dbpass1'];
	if ($database == '') $database = $GLOBALS['db1'];
	if ($serveur == '')  $serveur = $GLOBALS['serveur_mysql1'];	

	// On vérifie tout d'abord si on a une adresse ip ou pas
	$is_ip = preg_match("/([0-9]{1,}).([0-9]{1,}).([0-9]{1,}).([0-9]{1,})/", $serveur, $regs);	

	// S'il s'agit d'un nom de serveur, on tente de récupérer l'adresse IP
	if (!$is_ip) {
	$ip = gethostbyname($serveur);

	// Si les chaînes "ip" et "serveur" sont identiques, c'est que nous
	// n'avons pas pu déterminer l'adresse ip et mysql ne pourra pas se connecter
	// avec ce nom de serveur...
	if ($ip == $serveur) {
		$message .= "<font color=\"red\"> <b> Impossible de trouver l'IP du serveur MySql primaire!</b> </font><br>";
		$continue = false;
		} 
	}
	
	if ($continue) {
		$db_link = mysql_connect($serveur,$user,$passwd);
	
		if ($db_link ) {
			if (mysql_select_db($database) ){
				// On mémorise dans la session le block dans le conf.php qui nous a servi a établir la connexion 
				// les données de connexion pour éviter de refaire tous les tests à chaque fois... 
					$_SESSION[$GLOBALS['prefix'].'id'] = 1;
					return $db_link;
				} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter à la base primaire! </b> </font><br>"; 
				}
		} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter au serveur MySQL primaire! </b> </font><br>";
		}
	}

	$continue = true;	

	$user	= $GLOBALS['dbuser2'];
	$passwd	= $GLOBALS['dbpass2'];
	$database = $GLOBALS['db2'];
	$serveur  = $GLOBALS['serveur_mysql2'];	
	
	$is_ip = preg_match("/([0-9]{1,}).([0-9]{1,}).([0-9]{1,}).([0-9]{1,})/", $serveur);

	if (!$is_ip) {
	$ip = gethostbyname($serveur);

	if ($ip == $serveur) {
		$message .= "<font color=\"red\"> <b> Impossible de trouver l'IP du serveur MySql secondaire!</b> </font><br>";
		$continue = false;
	} 
	}
		
	if ($continue) {
		$db_link = mysql_connect($serveur,$user,$passwd);
					
		if ($db_link ) {
			if (mysql_select_db($database) ){
					// On mémorise dans la session le block dans le conf.php qui nous a servi a établir la connexion 
					// les données de connexion pour éviter de refaire tous les tests à chaque fois... 
					$_SESSION[$GLOBALS['prefix'].'id'] = 2;
					return $db_link;
				} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter à la base secondaire! </b> </font><br>"; 
				}
		} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter au serveur MySQL secondaire! </b> </font><br>";
		}
	}

	$message .= "<font color=\"red\"> <b> Vérifiez que le serveur MySQL est lancé. </b> </font><br>";

	echo $message;
	exit;
}

/**
* Fermeture connexion à la base de données.
*
* @param db_link Identifiant MySql de connexion a la base de donnees
*/
function Sql_close($db_link) {
	mysql_close($db_link);
}

/**
* Exécution d'une requête.
*
* @param sql Requête à exécuter
*/
function Sql_exec($sql) {
	if (preg_match("`information_schema`", $sql)) exit;
	$result = mysql_query($sql);

	if (!$result) {
		Lib_sqlLog("ERREUR SQL: $sql");
		Lib_sqlLog("REPONSE BdD: ".mysql_error()." (".mysql_errno().")", E_USER_ERROR);

		trigger_error("Problème SQL!", E_USER_ERROR);
		trigger_error("SQL: $sql", E_USER_ERROR);
		trigger_error("BdD: ".mysql_error()." (".mysql_errno().")", E_USER_ERROR);
		return 0;	
	}
	
	return 1;
}

function Sql_query($sql) {
	if (preg_match("`information_schema`", $sql)) exit;
	$result = mysql_query($sql);

	if (!$result) {		
		trigger_error("Problème SQL!", E_USER_ERROR);
		trigger_error("SQL: $sql", E_USER_ERROR);
		trigger_error("BdD: ".mysql_error()." (".mysql_errno().")", E_USER_ERROR);
		return 0;	
	}
	
	return $result;
}

function Sql_lastInsertId() {
	return mysql_insert_id();
}

function Sql_errorCode($result) {
	$code = mysql_errno(); 
	if ($code == 0) $code = "00000";
	return $code;
}

function Sql_error($result = '') {
	$error = mysql_error(); 
	return $error;
}

function Sql_fetch($result) {
	return(mysql_fetch_array($result));
}

/**
* Fonction de préparation des chaînes de caractères avant insertion
* en base
* @param $texte Chaîne a nettoyer
*/
function Sql_prepareTexteStockage($texte) {
	if (is_numeric($texte)) return $texte;

	if (preg_match('` SELECT `i', $texte)) exit;
	if (preg_match('` UPDATE `i', $texte)) exit;
	if (preg_match('` DELETE `i', $texte)) exit;
	if (preg_match('` INSERT `i', $texte)) exit;

	// Tout ce qui sera stocké sera en iso-8851
	// et tout ce qui sera affiché sera transformé en UTF8
	// Pour info, la fonction pre.php force un affichage en UTF8
	$texte = str_replace("&#39;","'",$texte);    
	$texte = mysql_real_escape_string($texte);
	// Les ; sont problèmatiques dans les bases de données (délimiteurs de requêtes)
	$texte = strtr($texte, ';', '');
 
	// Pour les besoins des WZ, il faut supprimer l'espace insécable se trouvant en début 
	// de <td> si celui-ci n'est pas tout seul
	$texte = preg_replace("`<td>([ ])*&nbsp;([ ])*</td>`i","td_espace_td", $texte);
	$texte = preg_replace("`<td>&nbsp;(.+)</td>`iU","<td>$1</td>", $texte);
	$texte = preg_replace("`td_espace_td`","<td>&nbsp;</td>", $texte);

	$res = "";

	for( $i=0 ; $i<strlen( $texte ) ; $i++ ){
		if(ord($texte[$i]) == 226 && ord($texte[$i+1]) == 130 && ord($texte[$i+2]) == 172){
			$res .= "&euro;";
			$i+=2; // On saute 2 caractères car l'euro semble codé sur 3 octects
			continue;
		}
		if(ord($texte[$i]) == 226 && ord($texte[$i+1]) == 128 && ord($texte[$i+2]) == 162){
			$res .= "&bull;";
			$i+=2; 
			continue;
		}
		if(ord($texte[$i]) == 226 && ord($texte[$i+1]) == 128 && ord($texte[$i+2]) == 153){
			$res .= "\'";
			$i+=2; 
			continue;
		}
		if(ord($texte[$i]) == 197 && ord($texte[$i+1]) == 147){
			$res .= "&oelig;";
			$i++; 
			continue;
		}
		$res .= $texte[$i];
	}

	$texte = $res;
	$texte = utf8_decode($texte);
	// Suppression des espaces en début et fin de chaîne
	$texte = trim($texte);
	// Suppression des espaces inutiles
	$texte = preg_replace("/( )+/", " ", $texte);    
	return $texte;
}

/**
* Fonction de préparation des chaînes de caractères avant affichage
* en base
* @param $texte Chaîne a nettoyer
*/
function Sql_prepareTexteAffichage($texte) {
	// Tout ce qui sera stocké sera en iso-8851
	// et tout ce qui sera affiché sera transformé en UTF8
	// Pour info, la fonction pre.php force un affichage en UTF8
	// Suppression des espaces en début et fin de chaîne
	$texte = trim($texte);
	if (function_exists(iconv))
		$texte = iconv("ISO-8859-1//TRANSLIT", "UTF-8", $texte);
	else
		$texte = utf8_encode($texte);
	// Suppression des espaces inutiles
	$texte = preg_replace("`( )+`", " ", $texte);
	return stripslashes($texte);
}

}
?>