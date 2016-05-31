<?
/**
 * Fonctions diverses pour la manipulation de requêtes SQL
 *
 * @author      dilasoft
 * @version     1.0
 */
if (!defined('__DB_INC__')){
define('__DB_INC__', 1);

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
      if (is_integer($pos) && ereg("^([ \r\n]*)$", substr($line, $pos+1, strlen($line)))) {
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
    $sql          = trim($sql);
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $time0        = time();

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
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    else {
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
            $in_string    = TRUE;
            $string_start = $char;
        } // end else if (is start of string)

        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#' || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                              ? strpos(' ' . $sql, "\012", $i+2)
                              : strpos(' ' . $sql, "\015", $i+2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    return trim(substr($sql, 0, $start_of_comment));
                }
            } else {
                $sql          = substr($sql, 0, $start_of_comment)
                              . ltrim(substr($sql, $end_of_comment));
                $sql_len      = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment)

    } // end for

    // add any rest to the returned array
    if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
        return $sql;
    }
}

/**
* Creation d'un fichier temporaire de sauvegarde contenant les instructions SQL
*
* @param out_file Fichier cible pour stockage des instructions SQL
*/
function Sql_buildSqlFile($out_file, $sql = '') {
    $crlf=Lib_endOfLine();
    
    $out_handle = fopen($out_file, "w");
    
    fputs($out_handle,"# BdD: ".$GLOBALS['db']."$crlf");
    
    //===========================================================================
    // auth_tables[] vient du .conf et contient la liste des tables a sauvegarder
    //===========================================================================
    foreach($GLOBALS['AUTH_TABLES'] as $table )  {
    
       fputs($out_handle,$crlf);
       fputs($out_handle,"# --------------------------------------------------------$crlf");
       fputs($out_handle,"# DumpingData '".$GLOBALS['prefix']."$table'$crlf");
       fputs($out_handle,"# --------------------------------------------------------$crlf");
       fputs($out_handle,$crlf);
       
       fputs($out_handle,"DELETE from ".$GLOBALS['prefix']."$table;$crlf");
       fputs($out_handle,$crlf);

       if ($sql != "") {
          $sql = ereg_replace(';',' ',$sql);
       } else {
          $sql = "SELECT * FROM ".$GLOBALS['db'].".".$GLOBALS['prefix'].$table;   
       } 

       $result = Sql_query($sql);
       $sql = "";
       
       if(!$result) {
          echo $MSG[$lang]['ProblemeSql'];
          echo $MSG['fr']['MessageBase']. Sql_errorCode($result)." : ".Sql_errorInfo($result)."<BR>";
          break;
       }
    
       $first_line = Sql_fetch($result);

       //============================================================================
       // Si la table n'a pas de lignes, on continue avec la table suivante
       //============================================================================
       if (count($first_line) <= 1)
          continue;
    
       //============================================================================
       // On construit la liste des champs pour eviter d'avoir des problemes d'INSERT
       //============================================================================
		 $fields = "(";
       foreach($first_line as $index => $val) {
			$fields .= $index.",";
       }
		 $fields .= ")";
//       $fields = "(";
//       $list_fields = mysql_list_fields($GLOBALS['db'], $GLOBALS['prefix'].$table);
//       $columns = mysql_num_fields($list_fields);
//       for ($i = 0; $i < $columns; $i++)
//           $fields .= (strcmp($fields,"(") == 0) ? mysql_field_name($list_fields, $i) : ",".mysql_field_name($list_fields, $i);
//       $fields .= ")";
    
       $insert_table = "INSERT INTO ".$GLOBALS['prefix']."$table $fields VALUES";
       $insert_table = trim($insert_table);
    
       while($row = Sql_fetch($result)) {
          fputs($out_handle,"$insert_table $crlf");
          $k = 0;
    
          //=============================================================
          // $lines_max represente le nombre de lignes maximum par INSERT
          // defini dans le conf.php
          //=============================================================
          while($k < $GLOBALS['lines_max']){
    
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
                   $schema_insert .= " '".$dummy."',";
                } else
                   $schema_insert .= " '',";
             }
    
             $schema_insert = ereg_replace(",$", "", $schema_insert);
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
           eregi("(select|insert|delete) (into|from) ([a-zA-Z0-9_]+)",$sql_query,$tab);
    
           foreach ($GLOBALS['AUTH_TABLES'] as $table) {
              Lib_sqlLog("Verification pour ".$tab[3]);
              if(eregi($table, $tab[3])) $bad_request = FALSE;
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
    
           $result = Sql_query($sql_query);
    
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
        $tmp_file     .= '/' . basename($filename);

        // User might have trailing slash in php.ini...
        return (ereg_replace('/+', '/', $tmp_file) == $filename);
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
function Sql_connect($database = 'bdd') {
   $message = "";

   $continue = true;

   if ($database == '') $database = $GLOBALS['db'];

    if ($continue) {
		if (file_exists(DIR.'data/'.$database) && empty($GLOBALS['db_link'])) {
			try {
				$db = new PDO('sqlite:'.DIR.'data/'.$database,'','',array( PDO::ATTR_PERSISTENT => true));
			}
			 catch (PDOException $error) {
					print "error1 : " . $error->getMessage() . "<br/>";
					die();
			}
		}
		if (file_exists('../data/'.$database) && empty($GLOBALS['db_link'])) {
			try {
				$db = new PDO('sqlite:../data/'.$database,'','',array( PDO::ATTR_PERSISTENT => true));
			}
			catch (PDOException $error) {
				print "error2: " . $error->getMessage() . "<br/>";
				die();
			}    

		}
	}

	return $db;
	exit;
}

function Sql_exec($sql) {
	$GLOBALS['db_link']->exec($sql);
	return 1;
}

function Sql_query($sql) {
	$result = $GLOBALS['db_link']->query($sql);
	return $result;
}

function Sql_lastInsertId() {
	return $GLOBALS['db_link']->lastInsertId();
}

function Sql_errorCode($result) {
	$code = $result->errorCode(); 
	return $code;
}

function Sql_errorInfo($result) {
	$info = $result->errorInfo(); 
	return $info;
}

function Sql_fetch($result) {
	return $result->fetch();
}

function Sql_fetchColumn($result) {
	return $result->fetchColumn();
}

/**
* Fonction de préparation des chaînes de caractères avant insertion
* en base
* @param $texte Chaîne a nettoyer
*/
function Sql_prepareTexteStockage($texte) {
    // Tout ce qui sera stocké sera en iso-8851
    // et tout ce qui sera affiché sera transformé en UTF8
    // Pour info, la fonction pre.php force un affichage en UTF8
    $texte = str_replace("&#39;","'",$texte);    
    $texte = str_replace("'", "''", $texte);
    // Les ; sont problèmatiques dans les bases de données (délimiteurs de requêtes)
    $texte = strtr($texte, ';', '');    
    $texte = utf8_decode($texte);
    // Suppression des espaces en début et fin de chaîne
    $texte = trim($texte);
    // Suppression des espaces inutiles
    $texte = ereg_replace("( )+", " ", $texte);    
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
    $texte = utf8_encode($texte);
    // Suppression des espaces en début et fin de chaîne
    $texte = trim($texte);
    // Suppression des espaces inutiles
    $texte = ereg_replace("( )+", " ", $texte);
    return str_replace("''", "'", $texte);
}

/**
* Fermeture connexion à la base de données.
*
* @param db_link Identifiant MySql de connexion a la base de donnees
*/
function Sql_close($db_link) {
//   mysql_close($db_link);
}
}
?>
