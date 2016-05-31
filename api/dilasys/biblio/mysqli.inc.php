<?
/**
 * Fonctions diverses pour la manipulation de requ�tes SQL
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
	global $tab_session;
	$handle = fopen($sql_file, "r");

	$SQL_SIZES = array();
	$size = 0;

	// On estime � 8192 la taille maximale des lignes. 1024 c'est trop court!
	// On doit positionner cette valeur pour compatibilit� ascendante avec php 4.1.x
	while($line = fgets($handle,8192)) {
		$size += strlen($line);
		// Une requ�te se termine par un ";". Comme une requ�te peut aussi contenir d'autres ";",
		// on cherche un ";" � partir de la fin de ligne.
		$pos = strrpos($line,';');

		// Pour d�terminer si la ligne est une fin de requ�te, il faut que les caract�res apr�s
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
	global $tab_session;
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
	global $tab_session;
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
		echo $MSG['fr']['MessageBase']. mysqli_errno($tab_session['db_link'])." : ".mysqli_error($tab_session['db_link'])."<BR>";
		return;
	}

	$nb_lines = mysqli_num_rows($result);

	//============================================================================
	// Si la table n'a pas de lignes, on continue avec la table suivante
	//============================================================================
	if ($nb_lines == 0)
		return;

	//============================================================================
	// On construit la liste des champs pour eviter d'avoir des problemes d'INSERT
	//============================================================================
	$result = mysqli_query($tab_session['db_link'], "SHOW COLUMNS FROM ".$GLOBALS['prefix'].$table);
	if (!$result) {
		echo 'Impossible d\'ex�cuter la requ�te : ' . mysqli_error($tab_session['db_link']);
		exit;
	}
/* TODO
	$list_fields = array();
	if (mysqli_num_rows($result) > 0)
		while ($row = mysql_fetch_assoc($result))
			$list_fields[] = $row;

	$fields = "(";
	$columns = mysqli_num_fields($list_fields);
	for ($i = 0; $i < $columns; $i++)
		$fields .= (strcmp($fields,"(") == 0) ? mysql_field_name($list_fields, $i) : ",".mysql_field_name($list_fields, $i);
	$fields .= ")";
*/
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
					// JPLt: Avant d'effectuer la boucle sur chaque ligne, on v�rifie si les caract�res � remplacer existent
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
* Lecture d'un fichier contenant les requetes SQL et ex�cution
*
* @param sql_file Fichier contenant les requetes
*/
function Sql_execSqlFile($sql_file) {
	global $tab_session;
	global $MSG, $lang;
	
	/**
	* On construit un tableau avec les longueurs de chaque requete SQL
	* Chaque element du tableau nous aide a r�cup�rer requ�te par requ�te
	* pour �viter des problemes de chargement avec de gros fichiers
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
	
			$result = mysqli_query($tab_session['db_link'], $sql_query);
	
			//=================================================================
			// On verifie la bonne execution de la requete
			//=================================================================
			if ($result == FALSE) { 
				$error_message = "<b> ".$MSG[$lang]['%%ProblemeSql%%']." </b>";				
				$error_message .= "<b> ".mysqli_error()." </b>";
				$error_message .= "<br> <b> Requ&egrave;te: </b> $sql_query <br>";
				Lib_sqlLog(mysqli_error($tab_session['db_link']));
				fclose($handle);
				return $error_message; 
			} else {
				Lib_sqlLog("Requete executee avec succes: ".mysqli_error($tab_session['db_link']));
			}
		}
	}
	
	fclose($handle);
	return "";
}

if (!function_exists('is_uploaded_file')) {
	global $tab_session;
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
* Fonction de connexion � la base de donn�es.
* Pour info, PHP ne va pas ouvrir une nouvelle connexion si un second appel �
* mysqli_connect() est fait avec les m�mes arguments mais va retourner l'identifiant
* de la connexion d�j� ouverte et nous n'aurons pas n connexions ouvertes simultan�ment.
*
* @param user Utilisateur pour se connecter a la base de donnees
* @param passwd Mot de passe de l'utilisateur
* @param database Base de donn�es sur laquelle on veut se connecter
* @param serveur Serveur o� se trouve la base de donn�es. Peut �tre une adresse IP ou un nom de serveur
*/
function Sql_connect($user = '', $passwd = '', $database = '', $serveur = '') {
	$message = "";
		
	$continue = true;

	/** 
	* On utilise les sessions car les fonctions "gethostbyname" et "ereg" utilis�es plus loin 
	* sont tr�s gourmandes en CPU et ralentissent �norm�ment la navigation.
	* Ces variables de session sont initialis�es au premier acc�s r�ussi et dureront le temps de la 
	* connexion de l'utilisateur...
	*/
	if (isset($_SESSION[$GLOBALS['prefix'].'id'])) {
		$id = $_SESSION[$GLOBALS['prefix'].'id'];	
		$db_link = mysqli_connect($GLOBALS['serveur_mysql'.$id],$GLOBALS['dbuser'.$id],$GLOBALS['dbpass'.$id]);

		if ($db_link ) {
			if (mysqli_select_db($db_link, $GLOBALS['db'.$id])){ 
					return $db_link;
				} else {
				echo "<font color=\"red\"> <b> Impossible de se re-connecter � la base! </b> </font><br>"; 
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

	// On v�rifie tout d'abord si on a une adresse ip ou pas
	$is_ip = preg_match("/([0-9]{1,}).([0-9]{1,}).([0-9]{1,}).([0-9]{1,})/", $serveur, $regs);	

	// S'il s'agit d'un nom de serveur, on tente de r�cup�rer l'adresse IP
	if (!$is_ip) {
	$ip = gethostbyname($serveur);

	// Si les cha�nes "ip" et "serveur" sont identiques, c'est que nous
	// n'avons pas pu d�terminer l'adresse ip et mysql ne pourra pas se connecter
	// avec ce nom de serveur...
	if ($ip == $serveur) {
		$message .= "<font color=\"red\"> <b> Impossible de trouver l'IP du serveur MySql primaire!</b> </font><br>";
		$continue = false;
		} 
	}
	
	if ($continue) {
		$db_link = mysqli_connect($serveur,$user,$passwd);
	
		if ($db_link ) {
			if (mysqli_select_db($db_link, $database) ){
				// On m�morise dans la session le block dans le conf.php qui nous a servi a �tablir la connexion 
				// les donn�es de connexion pour �viter de refaire tous les tests � chaque fois... 
					$_SESSION[$GLOBALS['prefix'].'id'] = 1;
					return $db_link;
				} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter � la base primaire! </b> </font><br>"; 
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
		$db_link = mysqli_connect($serveur,$user,$passwd);

		if ($db_link ) {
			if (mysqli_select_db($tab_session['db_link'], $database) ){
					// On m�morise dans la session le block dans le conf.php qui nous a servi a �tablir la connexion 
					// les donn�es de connexion pour �viter de refaire tous les tests � chaque fois... 
					$_SESSION[$GLOBALS['prefix'].'id'] = 2;
					return $db_link;
				} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter � la base secondaire! </b> </font><br>"; 
				}
		} else {
				$message .= "<font color=\"red\"> <b> Impossible de se connecter au serveur MySQL secondaire! </b> </font><br>";
		}
	}

	$message .= "<font color=\"red\"> <b> V�rifiez que le serveur MySQL est lanc�. </b> </font><br>";

	echo $message;
	exit;
}

/**
* Fermeture connexion � la base de donn�es.
*
* @param db_link Identifiant MySql de connexion a la base de donnees
*/
function Sql_close($db_link) {
	mysqli_close($db_link);
}

/**
* Ex�cution d'une requ�te.
*
* @param sql Requ�te � ex�cuter
*/
function Sql_exec($sql) {
	global $tab_session;
	$result = mysqli_query($tab_session['db_link'], $sql);
	
	if (!$result) {
		Lib_sqlLog("ERREUR SQL: $sql");
		Lib_sqlLog("REPONSE BdD: ".mysqli_error($tab_session['db_link'])." (".mysqli_errno($tab_session['db_link']).")", E_USER_ERROR);

		trigger_error("Probl�me SQL!", E_USER_ERROR);
		trigger_error("SQL: $sql", E_USER_ERROR);
		trigger_error("BdD: ".mysqli_error($tab_session['db_link'])." (".mysqli_errno($tab_session['db_link']).")", E_USER_ERROR);
		return 0;	
	}
	
	return 1;
}

function Sql_query($sql) {
	global $tab_session;
	$result = mysqli_query($tab_session['db_link'], $sql);
	
	if (!$result) {		
		trigger_error("Probl�me SQL!", E_USER_ERROR);
		trigger_error("SQL: $sql", E_USER_ERROR);
		trigger_error("BdD: ".mysqli_error($tab_session['db_link'])." (".mysqli_errno($tab_session['db_link']).")", E_USER_ERROR);
		return 0;	
	}
	
	return $result;
}

function Sql_lastInsertId() {
	global $tab_session;
	return mysqli_insert_id($tab_session['db_link']);
}

function Sql_errorCode($result) {
	global $tab_session;
	$code = mysqli_errno($tab_session['db_link']); 
	if ($code == 0) $code = "00000";
	return $code;
}

function Sql_error($result = '') {
	global $tab_session;
	$error = mysqli_error($tab_session['db_link']); 
	return $error;
}

function Sql_fetch($result) {
	global $tab_session;
	return(mysqli_fetch_array($result));
}

/**
* Fonction de pr�paration des cha�nes de caract�res avant insertion
* en base
* @param $texte Cha�ne a nettoyer
*/
function Sql_prepareTexteStockage($texte) {
	global $tab_session;
	if (is_numeric($texte)) return $texte;

	if (preg_match('` SELECT `i', $texte)) exit;
	if (preg_match('` UPDATE `i', $texte)) exit;
	if (preg_match('` DELETE `i', $texte)) exit;
	if (preg_match('` INSERT `i', $texte)) exit;

	// Tout ce qui sera stock� sera en iso-8851
	// et tout ce qui sera affich� sera transform� en UTF8
	// Pour info, la fonction pre.php force un affichage en UTF8
	$texte = str_replace("&#39;","'",$texte);    
	$texte = mysqli_real_escape_string($tab_session['db_link'], $texte);
	// Les ; sont probl�matiques dans les bases de donn�es (d�limiteurs de requ�tes)
	$texte = strtr($texte, ';', '');
 
	// Pour les besoins des WZ, il faut supprimer l'espace ins�cable se trouvant en d�but 
	// de <td> si celui-ci n'est pas tout seul
	$texte = preg_replace("`<td>([ ])*&nbsp;([ ])*</td>`i","td_espace_td", $texte);
	$texte = preg_replace("`<td>&nbsp;(.+)</td>`iU","<td>$1</td>", $texte);
	$texte = preg_replace("`td_espace_td`","<td>&nbsp;</td>", $texte);

	$res = "";

	for( $i=0 ; $i<strlen( $texte ) ; $i++ ){
		if(ord($texte[$i]) == 226 && ord($texte[$i+1]) == 130 && ord($texte[$i+2]) == 172){
			$res .= "&euro;";
			$i+=2; // On saute 2 caract�res car l'euro semble cod� sur 3 octects
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
	// Suppression des espaces en d�but et fin de cha�ne
	$texte = trim($texte);
	// Suppression des espaces inutiles
	$texte = preg_replace("/( )+/", " ", $texte);    
	return $texte;
}

/**
* Fonction de pr�paration des cha�nes de caract�res avant affichage
* en base
* @param $texte Cha�ne a nettoyer
*/
function Sql_prepareTexteAffichage($texte) {
	global $tab_session;
	// Tout ce qui sera stock� sera en iso-8851
	// et tout ce qui sera affich� sera transform� en UTF8
	// Pour info, la fonction pre.php force un affichage en UTF8
	// Suppression des espaces en d�but et fin de cha�ne
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
