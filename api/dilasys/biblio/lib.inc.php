<?
/** @file
 *  @ingroup group1
 *  @brief this file in Install
*/
if (!defined('__LIB_INC__')){

define('__LIB_INC__', 1);
define('__NORMAL__',2);
define('__WARNING__',1);
define('__ERROR__',0);
define('__CRITICAL__',8);
define('ERROR', 1);
define('OK', 0);

if (!defined('DIR'))
	define('DIR', substr(__FILE__, 0, strpos( __FILE__, "biblio" )));

/**
* Fonction spéciale de gestion des erreurs
* @param errno
* @param errmsg
* @param filename
* @param linenum
*/
function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars)
{
	if (!file_exists($filename)) return;

	// Date et heure de l'erreur
	$dt = gmdate("Y-m-d H:i:s (T)");
	//On récupère que le nom du fichier où a eu lieu l'erreur
	if ($result = strstr($filename, "/"))
		$file = explode("/",$filename);
	if ($result = strstr($filename, "\\"))
		$file = explode("\\",$filename);
	$nb = count($file);
	$file = $file[$nb-1];

	$err = $dt.": ".$errmsg." (".$file.":".$linenum.")\n";
	$msg = $dt.": ".$errmsg."\n";

	switch ($errno) {
	case E_USER_ERROR:
		echo "<b>ERROR</b>";
		echo "$msg <br>";
		Lib_myLog($errmsg," (".$file.":".$linenum.")",__ERROR__);
		if (preg_match("`BdD`", $msg))
			@mail("jplambert@dilasoft.fr","Erreur detectee",$_SERVER['SERVER_NAME']." (".$GLOBALS['prefix']."): ".$msg,"From: DiLaSoft");
	break;
	case E_USER_WARNING:
		echo "<b>WARNING</b> $err<br>\n";
		Lib_myLog($errmsg," (".$file.":".$linenum.")",__WARNING__);
	break;
	case E_NOTICE:
	break;
	default:
		echo "<b>ERROR</b> (Non user error. Err no $errno) $err. $vars<br>\n";
		Lib_myLog($errmsg," (".$file.":".$linenum.")",__ERROR__);		
		if (preg_match("`BdD`", $msg))
			@mail("jplambert@dilasoft.fr","Erreur detectee",$_SERVER['SERVER_NAME']." (".$GLOBALS['prefix']."): ".$msg,"From: DiLaSoft");
	break;
	}
}

$old_error_handler = set_error_handler("userErrorHandler");

/**
* Fonction de canonization en minuscules d'une chaine: que des minuscules, chiffres et underscores
* @param $texte Chaîne a canonizer
*/
function Lib_canonizeMin($texte) {
	$texte = utf8_decode($texte);
	return strtr($texte, 
					'AÀÁÂÃÄÅBCÇDEÈÉÊËFGHIÌÍÎÏJLKMNÒÓÔÕÖOPQRSTUÙÚÛÜVWXYÝZàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
					'aaaaaaabccdeeeeefghiiiiijlkmnoooooopqrstuuuuuvwxyyzaaaaaaceeeeiiiioooooouuuuyy');
}

/**
* Fonction de canonization en majuscules d'une chaine: que des majuscules, chiffres et underscores
* @param $texte Chaîne a canonizer
*/
function Lib_canonizeMaj($texte) {
	$texte = utf8_decode($texte);
	return strtr($texte, 
					'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝZaàáâãäåbcçdeèéêëfghiìíîïjklmnoðòóôõöpqrstuùúûüvwxyýÿz', 
					'AAAAAACEEEEIIIIOOOOOUUUUYZAAAAAAABCCDEEEEEFGHIIIIIJKLMNOOOOOOOPQRSTUUUUUVWXYYYZ');
}

/**
* Fonction de nettoyage des noms de fichiers
* @param $texte Texte à nettoyer
*/
function Lib_nettoie($texte) {
	// On remplace tous les caractères accentués d'abord :
	// Â
	$from[] = '/\xc3\x83\xc2\x82/';	$to[] = 'A';
	$from[] = '/\xc3\x82/';				$to[] = 'A';
	// À
	$from[] = '/\xc3\x83\xc2\x80/';	$to[] = 'A';
	$from[] = '/\xc3\x80/';				$to[] = 'A';
	// Á
	$from[] = '/\xc3\x83\xc2\x81/';	$to[] = 'A';
	$from[] = '/\xc3\x81/';				$to[] = 'A';
	// Ã
	$from[] = '/\xc3\x83\xc2\x83/';	$to[] = 'A';
	$from[] = '/\xc3\x83/';				$to[] = 'A';
	// Ä
	$from[] = '/\xc3\x83\xc2\x84/';	$to[] = 'A';
	$from[] = '/\xc3\x84/';				$to[] = 'A';
	// Å
	$from[] = '/\xc3\x83\xc2\x85/';	$to[] = 'A';
	$from[] = '/\xc3\x85/';				$to[] = 'A';
	// Ç
	$from[] = '/\xc3\x83\xc2\x87/';	$to[] = 'C';
	$from[] = '/\xc3\x87/';				$to[] = 'C';
	// È
	$from[] = '/\xc3\x83\xc2\x88/';	$to[] = 'E';
	$from[] = '/\xc3\x88/';				$to[] = 'E';
	// É
	$from[] = '/\xc3\x83\xc2\x89/';	$to[] = 'E';
	$from[] = '/\xc3\x89/';				$to[] = 'E';
	// Ê
	$from[] = '/\xc3\x83\xc2\x8a/';	$to[] = 'E';
	$from[] = '/\xc3\x8a/';				$to[] = 'E';
	// Ë
	$from[] = '/\xc3\x83\xc2\x8b/';	$to[] = 'E';
	$from[] = '/\xc3\x8b/';				$to[] = 'E';
	// Ì
	$from[] = '/\xc3\x83\xc2\x8c/';	$to[] = 'I';
	$from[] = '/\xc3\x8c/';				$to[] = 'I';
	// Í
	$from[] = '/\xc3\x83\xc2\x8d/';	$to[] = 'I';
	$from[] = '/\xc3\x8d/';				$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8e/';	$to[] = 'I';
	$from[] = '/\xc3\x8e/';				$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8f/';	$to[] = 'I';
	$from[] = '/\xc3\x8f/';				$to[] = 'I';
	// Ò
	$from[] = '/\xc3\x83\xc2\x92/';	$to[] = 'O';
	$from[] = '/\xc3\x92/';				$to[] = 'O';
	// Ó
	$from[] = '/\xc3\x83\xc2\x93/';	$to[] = 'O';
	$from[] = '/\xc3\x93/';				$to[] = 'O';
	// Ô
	$from[] = '/\xc3\x83\xc2\x94/';	$to[] = 'O';
	$from[] = '/\xc3\x94/';				$to[] = 'O';
	// Õ
	$from[] = '/\xc3\x83\xc2\x95/';	$to[] = 'O';
	$from[] = '/\xc3\x95/';				$to[] = 'O';
	// Ö
	$from[] = '/\xc3\x83\xc2\x96/';	$to[] = 'O';
	$from[] = '/\xc3\x96/';				$to[] = 'O';
	// Ù
	$from[] = '/\xc3\x83\xc2\x99/';	$to[] = 'U';
	$from[] = '/\xc3\x99/';				$to[] = 'U';
	// Ú
	$from[] = '/\xc3\x83\xc2\x9A/';	$to[] = 'U';
	$from[] = '/\xc3\x9A/';				$to[] = 'U';
	// Û
	$from[] = '/\xc3\x83\xc2\x9B/';	$to[] = 'U';
	$from[] = '/\xc3\x9B/';				$to[] = 'U';
	// Ü
	$from[] = '/\xc3\x83\xc2\x9C/';	$to[] = 'U';
	$from[] = '/\xc3\x9C/';				$to[] = 'U';
	// Ý
	$from[] = '/\xc3\x83\xc2\x9D/';	$to[] = 'Y';
	$from[] = '/\xc3\x9D/';				$to[] = 'Y';
	// à
	$from[] = '/\xc3\x83\xc2\xa0/';	$to[] = 'a';
	$from[] = '/\xc3\xa0/';				$to[] = 'a';
	// á
	$from[] = '/\xc3\x83\xc2\xa1/';	$to[] = 'a';
	$from[] = '/\xc3\xa1/';				$to[] = 'a';
	// â
	$from[] = '/\xc3\x83\xc2\xa2/';	$to[] = 'a';
	$from[] = '/\xc3\xa2/';				$to[] = 'a';
	// ã
	$from[] = '/\xc3\x83\xc2\xa3/';	$to[] = 'a';
	$from[] = '/\xc3\xa3/';				$to[] = 'a';
	// ä
	$from[] = '/\xc3\x83\xc2\xa4/';	$to[] = 'a';
	$from[] = '/\xc3\xa4/';				$to[] = 'a';
	// å
	$from[] = '/\xc3\x83\xc2\xa5/';	$to[] = 'a';
	$from[] = '/\xc3\xa5/';				$to[] = 'a';
	// ç
	$from[] = '/\xc3\x83\xc2\xa7/';	$to[] = 'c';
	$from[] = '/\xc3\xa7/';				$to[] = 'c';
	// è
	$from[] = '/\xc3\x83\xc2\xa8/';	$to[] = 'e';
	$from[] = '/\xc3\xa8/';				$to[] = 'e';
	// é
	$from[] = '/\xc3\x83\xc2\xa9/';	$to[] = 'e';
	$from[] = '/\xc3\xa9/';				$to[] = 'e';
	// ê
	$from[] = '/\xc3\x83\xc2\xaa/';	$to[] = 'e';
	$from[] = '/\xc3\xaa/';				$to[] = 'e';
	// ë
	$from[] = '/\xc3\x83\xc2\xab/';	$to[] = 'e';
	$from[] = '/\xc3\xab/';				$to[] = 'e';
	// ì
	$from[] = '/\xc3\x83\xc2\xac/';	$to[] = 'i';
	$from[] = '/\xc3\xac/';				$to[] = 'i';
	// í
	$from[] = '/\xc3\x83\xc2\xad/';	$to[] = 'i';
	$from[] = '/\xc3\xad/';				$to[] = 'i';
	// î
	$from[] = '/\xc3\x83\xc2\xae/';	$to[] = 'i';
	$from[] = '/\xc3\xae/';				$to[] = 'i';
	// ï
	$from[] = '/\xc3\x83\xc2\xaf/';	$to[] = 'i';
	$from[] = '/\xc3\xaf/';				$to[] = 'i';
	// ð
	$from[] = '/\xc3\x83\xc2\xb0/';	$to[] = 'o';
	$from[] = '/\xc3\xb0/';				$to[] = 'o';
	// ò
	$from[] = '/\xc3\x83\xc2\xb2/';	$to[] = 'o';
	$from[] = '/\xc3\xb2/';				$to[] = 'o';
	// ò
	$from[] = '/\xc3\x83\xc2\xb3/';	$to[] = 'o';
	$from[] = '/\xc3\xb3/';				$to[] = 'o';
	// ô
	$from[] = '/\xc3\x83\xc2\xb4/';	$to[] = 'o';
	$from[] = '/\xc3\xb4/';				$to[] = 'o';
	// õ
	$from[] = '/\xc3\x83\xc2\xb5/';	$to[] = 'o';
	$from[] = '/\xc3\xb5/';				$to[] = 'o';
	// ö
	$from[] = '/\xc3\x83\xc2\xb6/';	$to[] = 'o';
	$from[] = '/\xc3\xb6/';				$to[] = 'o';
	// ù
	$from[] = '/\xc3\x83\xc2\xb9/';	$to[] = 'u';
	$from[] = '/\xc3\xb9/';				$to[] = 'u';
	// ú
	$from[] = '/\xc3\x83\xc2\xba/';	$to[] = 'u';
	$from[] = '/\xc3\xba/';				$to[] = 'u';
	// û
	$from[] = '/\xc3\x83\xc2\xbb/';	$to[] = 'u';
	$from[] = '/\xc3\xbb/';				$to[] = 'u';
	// ü
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'u';
	$from[] = '/\xc3\xbc/';				$to[] = 'u';
	// ý
	$from[] = '/\xc3\x83\xc2\xbd/';	$to[] = 'y';
	$from[] = '/\xc3\xbd/';				$to[] = 'y';
	// ÿ
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'y';
	$from[] = '/\xc3\xbc/';				$to[] = 'y';
	// '
	$from[] = '/\xe2\x80\x99/';	$to[] = '-';
	$from[] = '/\'/';	$to[] = '-';

	// Il vaut mieux des tirets que des underscore pour séparer les mots :www.webrankinfo.com/actualites/200408-tiret-underscore.htm
	$texte = preg_replace($from, $to, $texte);
	// Ensuite, tout ce qui n'est pas une lettre, chiffre ou espace est supprimé :
	$texte = preg_replace('/([^.a-z0-9 \-]+)/i', '', $texte);
	// Enfin, tous les espaces sont remplacés par un tiret
	$texte = preg_replace('/([ ]+)/', '-', $texte);
	// Si on a plusieurs tirets à la suite, on n'en conserve qu'un
	$texte = preg_replace('/([-]+)/', '-', $texte);

	return $texte;
}


/**
* Fonction de nettoyage des accents
* @param $texte Chaîne a nettoyer
*/
function Lib_cleanTxt($texte) {
// for($i=0; $i<=strlen($texte); $i++)
//	$res .= ' '.(ord($texte[$i]));
// LogProd("INFO","{$texte} : {$res}");

	// On remplace tous les caractères accentués d'abord :
	// Â
	$from[] = '/\xc3\x83\xc2\x82/';	$to[] = 'A';
	$from[] = '/\xc3\x82/';				$to[] = 'A';
//	$from[] = '/\xc2/';					$to[] = 'A';
	// À
	$from[] = '/\xc3\x83\xc2\x80/';	$to[] = 'A';
	$from[] = '/\xc3\x80/';				$to[] = 'A';
	$from[] = '/\xc0/';					$to[] = 'A';
	// Á
	$from[] = '/\xc3\x83\xc2\x81/';	$to[] = 'A';
	$from[] = '/\xc3\x81/';				$to[] = 'A';
	$from[] = '/\xc1/';					$to[] = 'A';
	// Ã
	$from[] = '/\xc3\x83\xc2\x83/';	$to[] = 'A';
	$from[] = '/\xc3\x83/';				$to[] = 'A';
//	$from[] = '/\xc3/';					$to[] = 'A';
	// Ä
	$from[] = '/\xc3\x83\xc2\x84/';	$to[] = 'A';
	$from[] = '/\xc3\x84/';				$to[] = 'A';
	$from[] = '/\xc4/';					$to[] = 'A';
	// Å
	$from[] = '/\xc3\x83\xc2\x85/';	$to[] = 'A';
	$from[] = '/\xc3\x85/';				$to[] = 'A';
	$from[] = '/\xc5/';					$to[] = 'A';
	// Ç
	$from[] = '/\xc3\x83\xc2\x87/';	$to[] = 'C';
	$from[] = '/\xc3\x87/';				$to[] = 'C';
	$from[] = '/\xc7/';					$to[] = 'C';
	// È
	$from[] = '/\xc3\x83\xc2\x88/';	$to[] = 'E';
	$from[] = '/\xc3\x88/';				$to[] = 'E';
	$from[] = '/\xc8/';					$to[] = 'E';
	// É
	$from[] = '/\xc3\x83\xc2\x89/';	$to[] = 'E';
	$from[] = '/\xc3\x89/';				$to[] = 'E';
	$from[] = '/\xc9/';					$to[] = 'E';
	// Ê
	$from[] = '/\xc3\x83\xc2\x8a/';	$to[] = 'E';
	$from[] = '/\xc3\x8a/';				$to[] = 'E';
	$from[] = '/\xca/';					$to[] = 'E';
	// Ë
	$from[] = '/\xc3\x83\xc2\x8b/';	$to[] = 'E';
	$from[] = '/\xc3\x8b/';				$to[] = 'E';
	$from[] = '/\xcb/';					$to[] = 'E';
	// Ì
	$from[] = '/\xc3\x83\xc2\x8c/';	$to[] = 'I';
	$from[] = '/\xc3\x8c/';				$to[] = 'I';
	$from[] = '/\xcc/';					$to[] = 'I';
	// Í
	$from[] = '/\xc3\x83\xc2\x8d/';	$to[] = 'I';
	$from[] = '/\xc3\x8d/';				$to[] = 'I';
	$from[] = '/\xcd/';					$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8e/';	$to[] = 'I';
	$from[] = '/\xc3\x8e/';				$to[] = 'I';
	$from[] = '/\xce/';					$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8f/';	$to[] = 'I';
	$from[] = '/\xc3\x8f/';				$to[] = 'I';
	$from[] = '/\xcf/';					$to[] = 'I';
	// Ñ
	$from[] = '/\xd1/';					$to[] = 'N';
	// Ò
	$from[] = '/\xc3\x83\xc2\x92/';	$to[] = 'O';
	$from[] = '/\xc3\x92/';				$to[] = 'O';
	$from[] = '/\xd2/';					$to[] = 'O';
	// Ó
	$from[] = '/\xc3\x83\xc2\x93/';	$to[] = 'O';
	$from[] = '/\xc3\x93/';				$to[] = 'O';
	$from[] = '/\xd3/';					$to[] = 'O';
	// Ô
	$from[] = '/\xc3\x83\xc2\x94/';	$to[] = 'O';
	$from[] = '/\xc3\x94/';				$to[] = 'O';
	$from[] = '/\xd4/';					$to[] = 'O';
	// Õ
	$from[] = '/\xc3\x83\xc2\x95/';	$to[] = 'O';
	$from[] = '/\xc3\x95/';				$to[] = 'O';
	$from[] = '/\xd5/';					$to[] = 'O';
	// Ö
	$from[] = '/\xc3\x83\xc2\x96/';	$to[] = 'O';
	$from[] = '/\xc3\x96/';				$to[] = 'O';
	$from[] = '/\xd6/';					$to[] = 'O';
	// Ù
	$from[] = '/\xc3\x83\xc2\x99/';	$to[] = 'U';
	$from[] = '/\xc3\x99/';				$to[] = 'U';
	$from[] = '/\xd9/';					$to[] = 'U';
	// Ú
	$from[] = '/\xc3\x83\xc2\x9a/';	$to[] = 'U';
	$from[] = '/\xc3\x9a/';				$to[] = 'U';
	$from[] = '/\xda/';					$to[] = 'U';
	// Û
	$from[] = '/\xc3\x83\xc2\x9b/';	$to[] = 'U';
	$from[] = '/\xc3\x9b/';				$to[] = 'U';
	$from[] = '/\xdb/';					$to[] = 'U';
	// Ü
	$from[] = '/\xc3\x83\xc2\x9c/';	$to[] = 'U';
	$from[] = '/\xc3\x9c/';				$to[] = 'U';
	$from[] = '/\xdc/';					$to[] = 'U';
	// Ý
	$from[] = '/\xc3\x83\xc2\x9d/';	$to[] = 'Y';
	$from[] = '/\xc3\x9d/';				$to[] = 'Y';
	$from[] = '/\xdd/';					$to[] = 'Y';
	// à
	$from[] = '/\xc3\x83\xc2\xa0/';	$to[] = 'a';
	$from[] = '/\xc3\xa0/';				$to[] = 'a';
	$from[] = '/\xe0/';					$to[] = 'a';
	$from[] = '/\&agrave\;/';			$to[] = 'a';
	// á
	$from[] = '/\xc3\x83\xc2\xa1/';	$to[] = 'a';
	$from[] = '/\xc3\xa1/';				$to[] = 'a';
	$from[] = '/\xe1/';					$to[] = 'a';
	$from[] = '/\&aacute\;/';			$to[] = 'a';
	// â
	$from[] = '/\xc3\x83\xc2\xa2/';	$to[] = 'a';
	$from[] = '/\xc3\xa2/';				$to[] = 'a';
	$from[] = '/\xe2/';					$to[] = 'a';
	// ã
	$from[] = '/\xc3\x83\xc2\xa3/';	$to[] = 'a';
	$from[] = '/\xc3\xa3/';				$to[] = 'a';
	$from[] = '/\xe3/';					$to[] = 'a';
	// ä
	$from[] = '/\xc3\x83\xc2\xa4/';	$to[] = 'a';
	$from[] = '/\xc3\xa4/';				$to[] = 'a';
	$from[] = '/\xe4/';					$to[] = 'a';
	// å
	$from[] = '/\xc3\x83\xc2\xa5/';	$to[] = 'a';
	$from[] = '/\xc3\xa5/';				$to[] = 'a';
	$from[] = '/\xe5/';					$to[] = 'a';
	// ç
	$from[] = '/\xc3\x83\xc2\xa7/';	$to[] = 'c';
	$from[] = '/\xc3\xa7/';				$to[] = 'c';
	$from[] = '/\xe7/';					$to[] = 'c';
	$from[] = '/\&ccedil\;/';			$to[] = 'c';
	// è
	$from[] = '/\xc3\x83\xc2\xa8/';	$to[] = 'e';
	$from[] = '/\xc3\xa8/';				$to[] = 'e';
	$from[] = '/\xe8/';					$to[] = 'e';
	$from[] = '/\&egrave\;/';			$to[] = 'e';
	// é
	$from[] = '/\xc3\x83\xc2\xa9/';	$to[] = 'e';
	$from[] = '/\xc3\xa9/';				$to[] = 'e';
	$from[] = '/\xe9/';					$to[] = 'e';
	$from[] = '/\&eacute\;/';			$to[] = 'e';
	// ê
	$from[] = '/\xc3\x83\xc2\xaa/';	$to[] = 'e';
	$from[] = '/\xc3\xaa/';				$to[] = 'e';
	$from[] = '/\xea/';					$to[] = 'e';
	// ë
	$from[] = '/\xc3\x83\xc2\xab/';	$to[] = 'e';
	$from[] = '/\xc3\xab/';				$to[] = 'e';
	$from[] = '/\xeb/';					$to[] = 'e';
	// ì
	$from[] = '/\xc3\x83\xc2\xac/';	$to[] = 'i';
	$from[] = '/\xc3\xac/';				$to[] = 'i';
	$from[] = '/\xec/';					$to[] = 'i';
	$from[] = '/\&igrave\;/';			$to[] = 'i';
	// í
	$from[] = '/\xc3\x83\xc2\xad/';	$to[] = 'i';
	$from[] = '/\xc3\xad/';				$to[] = 'i';
	$from[] = '/\xed/';					$to[] = 'i';
	$from[] = '/\&iacute\;/';			$to[] = 'i';
	// î
	$from[] = '/\xc3\x83\xc2\xae/';	$to[] = 'i';
	$from[] = '/\xc3\xae/';				$to[] = 'i';
	$from[] = '/\xee/';					$to[] = 'i';
	// ï
	$from[] = '/\xc3\x83\xc2\xaf/';	$to[] = 'i';
	$from[] = '/\xc3\xaf/';				$to[] = 'i';
	$from[] = '/\xef/';					$to[] = 'i';
	// ð
	$from[] = '/\xc3\x83\xc2\xb0/';	$to[] = 'o';
	$from[] = '/\xc3\xb0/';				$to[] = 'o';
	// ñ
	$from[] = '/\xf1/';					$to[] = 'n';
	$from[] = '/\&ntilde\;/';			$to[] = 'n';
	// ò
	$from[] = '/\xc3\x83\xc2\xb2/';	$to[] = 'o';
	$from[] = '/\xc3\xb2/';				$to[] = 'o';
	$from[] = '/\xc3\xb2/';				$to[] = 'o';
	$from[] = '/\xf2/';					$to[] = 'o';
	$from[] = '/\&ograve\;/';			$to[] = 'o';
	// ò
	$from[] = '/\xc3\x83\xc2\xb3/';	$to[] = 'o';
	$from[] = '/\xc3\xb3/';				$to[] = 'o';
	$from[] = '/\xf3/';					$to[] = 'o';
	$from[] = '/\&oacute\;/';			$to[] = 'o';
	// ô
	$from[] = '/\xc3\x83\xc2\xb4/';	$to[] = 'o';
	$from[] = '/\xc3\xb4/';				$to[] = 'o';
	$from[] = '/\xf4/';					$to[] = 'o';
	// õ
	$from[] = '/\xc3\x83\xc2\xb5/';	$to[] = 'o';
	$from[] = '/\xc3\xb5/';				$to[] = 'o';
	$from[] = '/\xf5/';					$to[] = 'o';
	// ö
	$from[] = '/\xc3\x83\xc2\xb6/';	$to[] = 'o';
	$from[] = '/\xc3\xb6/';				$to[] = 'o';
	$from[] = '/\xf6/';					$to[] = 'o';
	// ù
	$from[] = '/\xc3\x83\xc2\xb9/';	$to[] = 'u';
	$from[] = '/\xc3\xb9/';				$to[] = 'u';
	$from[] = '/\xf9/';					$to[] = 'u';
	$from[] = '/\&ugrave\;/';			$to[] = 'u';
	// ú
	$from[] = '/\xc3\x83\xc2\xba/';	$to[] = 'u';
	$from[] = '/\xc3\xba/';				$to[] = 'u';
	$from[] = '/\xfa/';					$to[] = 'u';
	$from[] = '/\&uacute\;/';			$to[] = 'u';
	// û
	$from[] = '/\xc3\x83\xc2\xbb/';	$to[] = 'u';
	$from[] = '/\xc3\xbb/';				$to[] = 'u';
	$from[] = '/\xfb/';					$to[] = 'u';
	// ü
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'u';
	$from[] = '/\xc3\xbc/';				$to[] = 'u';
	$from[] = '/\xfc/';					$to[] = 'u';
	// ý
	$from[] = '/\xc3\x83\xc2\xbd/';	$to[] = 'y';
	$from[] = '/\xc3\xbd/';				$to[] = 'y';
	$from[] = '/\xfd/';					$to[] = 'y';
	// ÿ
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'y';
	$from[] = '/\xc3\xbc/';				$to[] = 'y';
	// 
	$from[] = '/\xc3\x82\xc2\xab/';	$to[] = '"';
	// '
	$from[] = '/\&apos\;/';	$to[] = "'";
	// °
	$from[] = '/\&deg\;/';	$to[] = "o";
	// €
	$from[] = '/\&euro\;/';	$to[] = "";

	$texte = preg_replace($from, $to, $texte);

	// Ensuite, tout ce qui n'est pas une lettre ou un chiffre est remplacé par un tiret :
	$texte = preg_replace('/([^a-z0-9]+)/i', '-', $texte);
// LogProd("INFO","{$texte}");
	$texte = strtolower($texte);
	return $texte;
}

/**
* Fonction de nettoyage des accents
* @param $texte Chaîne a nettoyer
*/
function Lib_cleanDirName($texte) {
// for($i=0; $i<=strlen($texte); $i++)
//	$res .= ' '.(ord($texte[$i]));
// LogProd("INFO","{$texte} : {$res}");

	// On remplace tous les caractères accentués d'abord :
	// Â
	$from[] = '/\xc3\x83\xc2\x82/';	$to[] = 'A';
	$from[] = '/\xc3\x82/';				$to[] = 'A';
//	$from[] = '/\xc2/';					$to[] = 'A';
	// À
	$from[] = '/\xc3\x83\xc2\x80/';	$to[] = 'A';
	$from[] = '/\xc3\x80/';				$to[] = 'A';
	$from[] = '/\xc0/';					$to[] = 'A';
	// Á
	$from[] = '/\xc3\x83\xc2\x81/';	$to[] = 'A';
	$from[] = '/\xc3\x81/';				$to[] = 'A';
	$from[] = '/\xc1/';					$to[] = 'A';
	// Ã
	$from[] = '/\xc3\x83\xc2\x83/';	$to[] = 'A';
	$from[] = '/\xc3\x83/';				$to[] = 'A';
//	$from[] = '/\xc3/';					$to[] = 'A';
	// Ä
	$from[] = '/\xc3\x83\xc2\x84/';	$to[] = 'A';
	$from[] = '/\xc3\x84/';				$to[] = 'A';
	$from[] = '/\xc4/';					$to[] = 'A';
	// Å
	$from[] = '/\xc3\x83\xc2\x85/';	$to[] = 'A';
	$from[] = '/\xc3\x85/';				$to[] = 'A';
	$from[] = '/\xc5/';					$to[] = 'A';
	// Ç
	$from[] = '/\xc3\x83\xc2\x87/';	$to[] = 'C';
	$from[] = '/\xc3\x87/';				$to[] = 'C';
	$from[] = '/\xc7/';					$to[] = 'C';
	// È
	$from[] = '/\xc3\x83\xc2\x88/';	$to[] = 'E';
	$from[] = '/\xc3\x88/';				$to[] = 'E';
	$from[] = '/\xc8/';					$to[] = 'E';
	// É
	$from[] = '/\xc3\x83\xc2\x89/';	$to[] = 'E';
	$from[] = '/\xc3\x89/';				$to[] = 'E';
	$from[] = '/\xc9/';					$to[] = 'E';
	// Ê
	$from[] = '/\xc3\x83\xc2\x8a/';	$to[] = 'E';
	$from[] = '/\xc3\x8a/';				$to[] = 'E';
	$from[] = '/\xca/';					$to[] = 'E';
	// Ë
	$from[] = '/\xc3\x83\xc2\x8b/';	$to[] = 'E';
	$from[] = '/\xc3\x8b/';				$to[] = 'E';
	$from[] = '/\xcb/';					$to[] = 'E';
	// Ì
	$from[] = '/\xc3\x83\xc2\x8c/';	$to[] = 'I';
	$from[] = '/\xc3\x8c/';				$to[] = 'I';
	$from[] = '/\xcc/';					$to[] = 'I';
	// Í
	$from[] = '/\xc3\x83\xc2\x8d/';	$to[] = 'I';
	$from[] = '/\xc3\x8d/';				$to[] = 'I';
	$from[] = '/\xcd/';					$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8e/';	$to[] = 'I';
	$from[] = '/\xc3\x8e/';				$to[] = 'I';
	$from[] = '/\xce/';					$to[] = 'I';
	// Î
	$from[] = '/\xc3\x83\xc2\x8f/';	$to[] = 'I';
	$from[] = '/\xc3\x8f/';				$to[] = 'I';
	$from[] = '/\xcf/';					$to[] = 'I';
	// Ñ
	$from[] = '/\xd1/';					$to[] = 'N';
	// Ò
	$from[] = '/\xc3\x83\xc2\x92/';	$to[] = 'O';
	$from[] = '/\xc3\x92/';				$to[] = 'O';
	$from[] = '/\xd2/';					$to[] = 'O';
	// Ó
	$from[] = '/\xc3\x83\xc2\x93/';	$to[] = 'O';
	$from[] = '/\xc3\x93/';				$to[] = 'O';
	$from[] = '/\xd3/';					$to[] = 'O';
	// Ô
	$from[] = '/\xc3\x83\xc2\x94/';	$to[] = 'O';
	$from[] = '/\xc3\x94/';				$to[] = 'O';
	$from[] = '/\xd4/';					$to[] = 'O';
	// Õ
	$from[] = '/\xc3\x83\xc2\x95/';	$to[] = 'O';
	$from[] = '/\xc3\x95/';				$to[] = 'O';
	$from[] = '/\xd5/';					$to[] = 'O';
	// Ö
	$from[] = '/\xc3\x83\xc2\x96/';	$to[] = 'O';
	$from[] = '/\xc3\x96/';				$to[] = 'O';
	$from[] = '/\xd6/';					$to[] = 'O';
	// Ù
	$from[] = '/\xc3\x83\xc2\x99/';	$to[] = 'U';
	$from[] = '/\xc3\x99/';				$to[] = 'U';
	$from[] = '/\xd9/';					$to[] = 'U';
	// Ú
	$from[] = '/\xc3\x83\xc2\x9a/';	$to[] = 'U';
	$from[] = '/\xc3\x9a/';				$to[] = 'U';
	$from[] = '/\xda/';					$to[] = 'U';
	// Û
	$from[] = '/\xc3\x83\xc2\x9b/';	$to[] = 'U';
	$from[] = '/\xc3\x9b/';				$to[] = 'U';
	$from[] = '/\xdb/';					$to[] = 'U';
	// Ü
	$from[] = '/\xc3\x83\xc2\x9c/';	$to[] = 'U';
	$from[] = '/\xc3\x9c/';				$to[] = 'U';
	$from[] = '/\xdc/';					$to[] = 'U';
	// Ý
	$from[] = '/\xc3\x83\xc2\x9d/';	$to[] = 'Y';
	$from[] = '/\xc3\x9d/';				$to[] = 'Y';
	$from[] = '/\xdd/';					$to[] = 'Y';
	// à
	$from[] = '/\xc3\x83\xc2\xa0/';	$to[] = 'a';
	$from[] = '/\xc3\xa0/';				$to[] = 'a';
	$from[] = '/\xe0/';					$to[] = 'a';
	$from[] = '/\&agrave\;/';			$to[] = 'a';
	// á
	$from[] = '/\xc3\x83\xc2\xa1/';	$to[] = 'a';
	$from[] = '/\xc3\xa1/';				$to[] = 'a';
	$from[] = '/\xe1/';					$to[] = 'a';
	$from[] = '/\&aacute\;/';			$to[] = 'a';
	// â
	$from[] = '/\xc3\x83\xc2\xa2/';	$to[] = 'a';
	$from[] = '/\xc3\xa2/';				$to[] = 'a';
	$from[] = '/\xe2/';					$to[] = 'a';
	// ã
	$from[] = '/\xc3\x83\xc2\xa3/';	$to[] = 'a';
	$from[] = '/\xc3\xa3/';				$to[] = 'a';
	$from[] = '/\xe3/';					$to[] = 'a';
	// ä
	$from[] = '/\xc3\x83\xc2\xa4/';	$to[] = 'a';
	$from[] = '/\xc3\xa4/';				$to[] = 'a';
	$from[] = '/\xe4/';					$to[] = 'a';
	// å
	$from[] = '/\xc3\x83\xc2\xa5/';	$to[] = 'a';
	$from[] = '/\xc3\xa5/';				$to[] = 'a';
	$from[] = '/\xe5/';					$to[] = 'a';
	// ç
	$from[] = '/\xc3\x83\xc2\xa7/';	$to[] = 'c';
	$from[] = '/\xc3\xa7/';				$to[] = 'c';
	$from[] = '/\xe7/';					$to[] = 'c';
	$from[] = '/\&ccedil\;/';			$to[] = 'c';
	// è
	$from[] = '/\xc3\x83\xc2\xa8/';	$to[] = 'e';
	$from[] = '/\xc3\xa8/';				$to[] = 'e';
	$from[] = '/\xe8/';					$to[] = 'e';
	$from[] = '/\&egrave\;/';			$to[] = 'e';
	// é
	$from[] = '/\xc3\x83\xc2\xa9/';	$to[] = 'e';
	$from[] = '/\xc3\xa9/';				$to[] = 'e';
	$from[] = '/\xe9/';					$to[] = 'e';
	$from[] = '/\&eacute\;/';			$to[] = 'e';
	// ê
	$from[] = '/\xc3\x83\xc2\xaa/';	$to[] = 'e';
	$from[] = '/\xc3\xaa/';				$to[] = 'e';
	$from[] = '/\xea/';					$to[] = 'e';
	// ë
	$from[] = '/\xc3\x83\xc2\xab/';	$to[] = 'e';
	$from[] = '/\xc3\xab/';				$to[] = 'e';
	$from[] = '/\xeb/';					$to[] = 'e';
	// ì
	$from[] = '/\xc3\x83\xc2\xac/';	$to[] = 'i';
	$from[] = '/\xc3\xac/';				$to[] = 'i';
	$from[] = '/\xec/';					$to[] = 'i';
	$from[] = '/\&igrave\;/';			$to[] = 'i';
	// í
	$from[] = '/\xc3\x83\xc2\xad/';	$to[] = 'i';
	$from[] = '/\xc3\xad/';				$to[] = 'i';
	$from[] = '/\xed/';					$to[] = 'i';
	$from[] = '/\&iacute\;/';			$to[] = 'i';
	// î
	$from[] = '/\xc3\x83\xc2\xae/';	$to[] = 'i';
	$from[] = '/\xc3\xae/';				$to[] = 'i';
	$from[] = '/\xee/';					$to[] = 'i';
	// ï
	$from[] = '/\xc3\x83\xc2\xaf/';	$to[] = 'i';
	$from[] = '/\xc3\xaf/';				$to[] = 'i';
	$from[] = '/\xef/';					$to[] = 'i';
	// ð
	$from[] = '/\xc3\x83\xc2\xb0/';	$to[] = 'o';
	$from[] = '/\xc3\xb0/';				$to[] = 'o';
	// ñ
	$from[] = '/\xf1/';					$to[] = 'n';
	$from[] = '/\&ntilde\;/';			$to[] = 'n';
	// ò
	$from[] = '/\xc3\x83\xc2\xb2/';	$to[] = 'o';
	$from[] = '/\xc3\xb2/';				$to[] = 'o';
	$from[] = '/\xc3\xb2/';				$to[] = 'o';
	$from[] = '/\xf2/';					$to[] = 'o';
	$from[] = '/\&ograve\;/';			$to[] = 'o';
	// ò
	$from[] = '/\xc3\x83\xc2\xb3/';	$to[] = 'o';
	$from[] = '/\xc3\xb3/';				$to[] = 'o';
	$from[] = '/\xf3/';					$to[] = 'o';
	$from[] = '/\&oacute\;/';			$to[] = 'o';
	// ô
	$from[] = '/\xc3\x83\xc2\xb4/';	$to[] = 'o';
	$from[] = '/\xc3\xb4/';				$to[] = 'o';
	$from[] = '/\xf4/';					$to[] = 'o';
	// õ
	$from[] = '/\xc3\x83\xc2\xb5/';	$to[] = 'o';
	$from[] = '/\xc3\xb5/';				$to[] = 'o';
	$from[] = '/\xf5/';					$to[] = 'o';
	// ö
	$from[] = '/\xc3\x83\xc2\xb6/';	$to[] = 'o';
	$from[] = '/\xc3\xb6/';				$to[] = 'o';
	$from[] = '/\xf6/';					$to[] = 'o';
	// ù
	$from[] = '/\xc3\x83\xc2\xb9/';	$to[] = 'u';
	$from[] = '/\xc3\xb9/';				$to[] = 'u';
	$from[] = '/\xf9/';					$to[] = 'u';
	$from[] = '/\&ugrave\;/';			$to[] = 'u';
	// ú
	$from[] = '/\xc3\x83\xc2\xba/';	$to[] = 'u';
	$from[] = '/\xc3\xba/';				$to[] = 'u';
	$from[] = '/\xfa/';					$to[] = 'u';
	$from[] = '/\&uacute\;/';			$to[] = 'u';
	// û
	$from[] = '/\xc3\x83\xc2\xbb/';	$to[] = 'u';
	$from[] = '/\xc3\xbb/';				$to[] = 'u';
	$from[] = '/\xfb/';					$to[] = 'u';
	// ü
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'u';
	$from[] = '/\xc3\xbc/';				$to[] = 'u';
	$from[] = '/\xfc/';					$to[] = 'u';
	// ý
	$from[] = '/\xc3\x83\xc2\xbd/';	$to[] = 'y';
	$from[] = '/\xc3\xbd/';				$to[] = 'y';
	$from[] = '/\xfd/';					$to[] = 'y';
	// ÿ
	$from[] = '/\xc3\x83\xc2\xbc/';	$to[] = 'y';
	$from[] = '/\xc3\xbc/';				$to[] = 'y';
	// 
	$from[] = '/\xc3\x82\xc2\xab/';	$to[] = '"';
	// '
	$from[] = '/\&apos\;/';	$to[] = "'";
	// °
	$from[] = '/\&deg\;/';	$to[] = "o";
	// €
	$from[] = '/\&euro\;/';	$to[] = "";

	$texte = preg_replace($from, $to, $texte);

	// Ensuite, tout ce qui n'est pas une lettre ou un chiffre est remplacé par un tiret :
	//$texte = preg_replace('/([^a-z0-9]+)/i', '-', $texte);
	// LogProd("INFO","{$texte}");
	//$texte = strtolower($texte);
	return $texte;
}

/**
* Fonction de préparation pour l'url-rewriting: tout en minuscules, on supprime les accents, on remplace les articles par des espaces ...
* @param $texte Chaîne a traiter
*/
function Lib_urlRewrite($texte) {
	$texte = utf8_decode($texte);
	// Remplacement de tous les caractères accentués et des majuscules en minuscules
	$texte = strtr($texte, 
				'AÀÁÂÃÄÅBCÇDEÈÉÊËFGHIÌÍÎÏJLKMNÒÓÔÕÖOPQRSTUÙÚÛÜVWXYÝZàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
				'aaaaaaabccdeeeeefghiiiiijlkmnoooooopqrstuuuuuvwxyyzaaaaaaceeeeiiiioooooouuuuyy');

	// Suppression de tout ce qui n'est pas caractère, chiffre et espace
	$texte = preg_replace('/([^\-\'a-z0-9 ]+)/i', '', $texte);

	// Remplacement de tous les articles (de, la, les ...) par un espace, qu'ils soient à l'intérieur d'une chaîne ou en début de chaîne
	$patterns[0] = "/( |^)a /";
	$patterns[1] = "/( |^)au /";
	$patterns[2] = "/( |^)aux /";
	$patterns[3] = "/( |^)de /";
	$patterns[4] = "/( |^)du /";
	$patterns[5] = "/( |^)des /";
	$patterns[6] = "/( |^)l'/";
	$patterns[7] = "/( |^)d'/";
	$patterns[8] = "/( |^)le /";
	$patterns[9] = "/( |^)les /";
	$patterns[10] = "/( |^)la /";
	$patterns[11] = "/( |^)un /";
	$patterns[12] = "/( |^)une /";
	$patterns[13] = "/( |^)en /";
	$texte = preg_replace($patterns, ' ', $texte);

	// Suppression des espaces en début et fin de chaîne
	$texte = trim($texte);

	// Remplacement de tous les espaces par un tiret
	$texte = preg_replace('/([^a-z0-9]+)/i', '-', $texte);

	return $texte;
}

/**
* Fonction de nettoyage de tous les anti-slashs en trop, on n'en garde qu'un!
* @param $input Ligne a nettoyer
*/
function Lib_cleanSlashes($input) {

	$long = strlen($input);

	for($i=0,$output="",$prec="";$i<$long;$prec=$char,$i++) {
		$char=$input[$i];
		if ($char == "\\" )
		{if ($prec != "\\") $output .= $char;}
		else
		$output .= $char;
	}

	return $output;
}

/**
* Ajout d'un élément à une liste
* @param liste Liste 
* @param elem élement à rajouter
*/
function Lib_addElem($liste, $elem) {
	$liste .= (($liste == "") ? $elem : ",".$elem);
}

/**
* Arrondi pour les besoins d'affichage
* @param val Valeur a arrondir
*/
function Lib_myRoundDisplay($val, $decimals = '.', $dec_point = ' ') {
  $val = round($val,2);
  $val = number_format($val,2, $decimals, $dec_point);
  return $val;
}

/**
* Redefinition de round
* @param val Valeur a arrondir
*/
function Lib_myRound($val) {
  $val = round($val,2);
  return $val;
}

/**
* Extraction des valeurs d'une colonne sur un tableau
* Si seul le parametre colonne_cle est fourni, les valeurs extraites seront aussi les indices du tableau.
* Si le parametre colonne_val est aussi fourni, les indices auront pour valeur celle de la premiere colonne,
* et la valeur sera celle de la deuxieme colonne.
* @param tableau Tableau sur lequel on doit recuperer la colonne
* @param colonne_cle Colonne a recuperer
* @param colonne_val 
*/
function Lib_getValCol($tableau, $colonne_cle, $colonne_val = '') {
	$result = array();
	foreach($tableau as $ligne)
		if ($ligne[$colonne_cle] != '')
			$result[$ligne[$colonne_cle]] = ($colonne_val == '') ? $ligne[$colonne_cle] : $ligne[$colonne_val];
	return $result;
}

/**
* Formatte un nombre sur un nombre donné de digits
* @param nb Nombre a formater
* @param nb_digits Nombre de digits a afficher
*
* Ex: Lib_formatNumber("5",3) renverra "005"
*/
function Lib_formatNumber($nb, $nb_digits, $format = '0', $cote = 'gauche') {
	if ( $nb < pow(10,$nb_digits-1) )
	{
		for ($i=strlen($nb)+1; $i<=$nb_digits; $i++)
			$nb = $cote == 'gauche' ? $format . $nb : $nb . $format;

	}
	if ($cote == 'gauche') $nb = substr($nb, -1*$nb_digits);
	if ($cote == 'droite') $nb = substr($nb, 0, $nb_digits);
	return $nb;	
}

/**
* Formatte une date anglaise en date française
* @param $english_date Date en format anglais a transformer
*/
function Lib_enToFr($english_date) {
	preg_match( "`(.*)-(.*)-(.*)`", $english_date, $data);
	return "$data[3]/$data[2]/$data[1]";
}

/**
* Formatte une date française en date anglaise
* @param $french_date Date en format francais a transformer
*/
function Lib_frToEn($french_date) {
	preg_match( "`(.*)\/(.*)\/(.*)`", $french_date, $data);
	return "$data[3]-$data[2]-$data[1]";
}

/**
* Formatte une date française en date anglaise
* @param $french_date Date en format francais a transformer
*/
function Lib_frToTmsp($french_date) {
	preg_match("`(.*)/(.*)/(.*)`", $french_date, $data);
	return gmmktime(0,0,0,$data[2], $data[1], $data[3]);
}

/**
* Formatte une date anglaise pour l'affichage
*/
function Lib_enToAff($english_date) {
	preg_match( "`(.*)-(.*)-(.*)`", $english_date, $data);
	return $data[3].".".$data[2].".".substr($data[1],2,2);
}

/**
* Détermine si une date passée en argument au format YYYY-MM-JJ est une date correcte
* @param $date Date a verifier
*/
function Lib_isDate($date) {
	if( $date != "") {
	if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $date, $regs))
		return checkdate($regs[2], $regs[3], $regs[1]);
	else
		return FALSE;
	} else {
		return FALSE;
	}
}

/**
* Retourne le jour précédent
* @param $date Date de reference au format YYYY-MM-DD
*/
function Lib_prevDay($date) {
	if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $date, $regs)) {
		if(checkdate($regs[2], $regs[3], $regs[1])) {
				$current = mktime(0,0,0,$regs[2],$regs[3],$regs[1]);
				// Take care of changing hours!
				$previous = $current - (22*3600);
				return gmdate("Y-m-d",$previous);
		}
	}
}

function Lib_nomMois($time) {
	global $lang;  

	// On affiche le nom du mois dans la langue du systeme
	setlocale(LC_TIME, $lang);
	return strftime("%B",$time);
}

/**
* Retourne le jour suivant
* @param $date Date de reference au format YYYY-MM-DD
*/
function Lib_nextDay($date) {
	if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $date, $regs)) {
		if(checkdate($regs[2], $regs[3], $regs[1])) {
				$current = mktime(0,0,0,$regs[2],$regs[3],$regs[1]);
				// Take care of changing hours!
				$next = $current + (26*3600);
				return gmdate("Y-m-d",$next);
		}
	}
}

/**
* Retourne le nombre de nuits entre 2 dates
* @param $begin Date de reference de debut au format YYYY-MM-DD
* @param $end Date de reference de fin au format YYYY-MM-DD
*/
function Lib_nbNuits($date1, $date2) {
	$debut = ($date1 >= $date2) ? $date2 : $date1;
	$fin = ($date1 >= $date2) ? $date1 : $date2;
	$nb_nuits = 0;

	// Tout d'abord, on regarde le nombre de secondes entre la date
	// de début et la fin du premier jour
	$premier_jour = mktime(0, 0, 0, gmdate('n',$debut), gmdate('j', $debut)+1, gmdate('Y', $debut));
	$delta_debut = $premier_jour - $debut;
	if ($delta_debut) $nb_nuits++;

	// Ensuitz, on regarde le nombre de secondes entre la date
	// de fin et la fin du dernier jour
	$dernier_jour = mktime(0, 0, 0, gmdate('n',$fin), gmdate('j', $fin), gmdate('Y', $fin));
	$delta_fin = $fin - $denier_jour;
	if ($delta_fin && ($dernier_jour != $premier_jour)) $nb_nuits++;

	if ($dernier_jour != $premier_jour) 
		$nb_nuits += (($dernier_jour - $premier_jour)/86400) - 1;

	return $nb_nuits;
}

/**
* Ajoute un commentaire à l'historique des actions sur la base
 @param $commentary Commentaire a rajouter
*/
function Lib_sqlLog($commentary) {

	$session = (isset($_COOKIE[$GLOBALS['instance'].'_session'])) ?
					$_COOKIE[$GLOBALS['instance'].'_session'] :
					$session = 'NO_SESSION';
	$log_file = DIR."log/sql.log";
	$session = ($session == '') ? '' : "session:$session";

	$commentary = preg_replace("`\r\n`"," ",$commentary);
	$commentary = preg_replace("`\n`"," ",$commentary);
	$commentary = preg_replace("`\t`"," ",$commentary);
	$commentary = preg_replace("` {2,}`"," ",$commentary);

	if( $hd = fopen($log_file, "a+" ) ){
		fputs($hd,gmdate("d/m/Y H:i:s")." $session $commentary\r\n");
		if (substr(sprintf('%o', fileperms($log_file)), -4) != '0775') chmod($log_file, 0775);
		fclose( $hd );
		return true;
	}

	else return false;
}

/**
* Ajoute un commentaire à l'historique des erreurs et
* affiche un message d'erreur à l'utilisateur
* @param $commentary Commentaire a rajouter
* @param $error_level Niveau d'erreur pour les traces (NORMAL, WARNING, ERROR)
*/
function Lib_myLog($commentary, $precision = '', $error_level=__NORMAL__) {
	if ($GLOBALS['log_level'] >= $error_level) {
		$session = (isset($_COOKIE[$GLOBALS['instance'].'_session'])) ?
						$_COOKIE[$GLOBALS['instance'].'_session'] :
						$session = 'NO_SESSION';

		if ($GLOBALS['log_level'] < 2 && $session == 'NO_SESSION') return;

		$log_file = DIR."log/".$session.".log";

		if (is_array($precision)) {
			ob_start();
			Lib_afficheTableau($precision, 0);
			$precision = ob_get_contents();
			ob_end_clean();
		}  

		$commentary = preg_replace("/\r\n/i"," ",$commentary);
		$commentary = preg_replace("/\n/i"," ",$commentary);
		$commentary = preg_replace("/\t/i"," ",$commentary);
		$commentary = preg_replace("/ {2,}/i"," ",$commentary);
	
		switch ($error_level) {
		case __WARNING__:
			$msg_level = "WARN ";
		break;
		case __ERROR__:
			$msg_level = "ERR  ";
		break;
		default:
			$msg_level = "NORM ";
		break;
		}

		if( $hd = fopen($log_file, "a+" ) ){
			fputs($hd,gmdate("d/m/Y H:i:s")." $msg_level $commentary $precision\r\n");
			fclose( $hd );
			return true;
		}
	
		else return false;
	}
}

/**
* Détermine quel est le caractère de fin de ligne en fonction du système:
* les retours chariot ne sont pas les memes sous Unix et Windows
*/
function Lib_endOfLine() {
	$crlf="\n";
	
	if (!isset($HTTP_USER_AGENT))
	{
		if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']))
			$HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
		else
			$HTTP_USER_AGENT = getenv('HTTP_USER_AGENT');
	}

	$client = $HTTP_USER_AGENT;

	if(preg_match("/[^(]*\((.*)\)[^)]*/",$client,$regs))
	{
		$os = $regs[1];
		// Ce retour chariot marche mieux sous Windows
		if (preg_match("`Win`i",$os))
			$crlf="\r\n";
	}

	return $crlf;
}

function Lib_moveUploadedFile($file) {

	if (file_exists($file) && is_uploaded_file($file)) {

		$open_basedir	= '';
		if (PMA_PHP_INT_VERSION >= 40000 ) {
			$open_basedir = @ini_get('open_basedir');
		}
		if (empty($open_basedir)) {
			$open_basedir = @get_cfg_var('open_basedir');
		}

		// Si on est sur un serveur avec open_basedir, on doit deplacer le fichier
		// avant de l'ouvrir. 
		if (!empty($open_basedir)) {
			// On verifie si '.' est accessible
			$pos = strpos(' ' . $open_basedir, '.');

			if (!$pos) {
				// Si '.' n'est pas accessible, ne pas bouger le fichier,
				// forcer l'erreur et laisser Php le signaler
				error_reporting(E_ALL);
			} else {
				$file_new = './tmp/' . basename($file);
				if (PMA_PHP_INT_VERSION < 40003) {
					copy($file, $file_new);
				} else {
					move_uploaded_file($file, $file_new);
				}
			}
		}
	}
}

/**
* Compression et encryptage d'un fichier 
* @param $in_file Fichier a traiter
* @param $bz_file Fichier destination
*/
function Lib_fileCrypt($in_file, $bz_file) {

	if (!file_exists($bz_file)) {
		$bz_handle = fopen($bz_file, "w");
		fclose($bz_handle);
	}

	$src_handle = fopen($out_file, "r");
	$bz_handle = bzopen($bz_file, "w");
	$key_tab = array();

	while($line = fgets($src_handle)) {
		$new = Lib_encrypt($line,$GLOBALS['clef']);
		$len = sprintf("%05d",strlen($new));
		bzwrite($bz_handle,$len);
		bzwrite($bz_handle,$new);
	}

	bzclose($bz_handle);
	fclose($src_handle);

	//===================================================================
	// On change l'en-tete bz2 pour ne pas rendre trop evident l'encodage
	//===================================================================
	$bz_handle = fopen($bz_file, "r+");
	fwrite($bz_handle,"JPLt");
	fclose($bz_handle);
}

/**
* Decompression d'un fichier et decryptage
* @param $bz_file Fichier a decompresser et decrypter
* @param $out_file Fichier destination
*/
function Lib_fileDecrypt($bz_file, $out_file) {

	// On change l'en-tete en bz2 
	$bz_handle = fopen($bz_file, "r+");
	fwrite($bz_handle,"BZh9");
	fclose($bz_handle);

	$bz_handle = bzopen($bz_file, "r");
	$xtr_handle = fopen($out_file, "w");
	$key_tab = array();

	while(true) {
		$len = (int) bzread($bz_handle,5);
		if ($len==0) break;
		$str = Lib_decrypt(bzread($bz_handle,$len),$GLOBALS['clef']);
		fputs($xtr_handle,$str);
	}

	bzclose($bz_handle);  
	fclose($xtr_handle);	
}

/**
*  Ouvre le fichier passé en paramètre et les données
*  sous format de tableau, objet, donnée simple...
*  @param $filename Fichier a lire
*/
function Lib_readCache($filename) {

	$filename = DIR."cache/".$filename;
	if( is_file($filename) && file_exists($filename) && $hd=fopen($filename,"r") ){
		$data=unserialize( fread( $hd, filesize( $filename )) );
		fclose( $hd );
		return $data;
	}
}

/**
* Créer un fichier avec le nom passé en paramètre et y stocke
* les données à sauvegarder (tableau, objet, donnée simple...)
* @param $data Données à sauvegarder
* @param $fileName Nom du fichier
*/
function Lib_writeCache($data, $filename) {

	$filename = DIR."cache/".$filename;
	if( $hd=fopen($filename, "w+") ){
		fputs( $hd, serialize( $data ) );
		fclose( $hd );
		return true;
	}
	else return false;
}

/**
*  Ouvre le fichier passé en paramètre et les données
*  sous format de tableau, objet, donnée simple...
*  @param $filename Fichier a lire
*/
function Lib_readData($filename) {

	$filename = DIR."tmp/".$filename;
	if( is_file($filename) && file_exists($filename) && $hd=fopen($filename,"r") ){
		$data=unserialize( fread( $hd, filesize( $filename )) );
		fclose( $hd );
		return $data;
	}
}

/**
* Créer un fichier avec le nom passé en paramètre et y stocke
* les données à sauvegarder (tableau, objet, donnée simple...)
* @param $data Données à sauvegarder
* @param $fileName Nom du fichier
*/
function Lib_writeData($data, $filename) {

	$filename = DIR."tmp/".$filename;
	if( $hd=fopen($filename, "w+") ){
		fputs( $hd, serialize( $data ) );
		fclose( $hd );
		return true;
	}
	else return false;
}

/**
*  Fonction de vérification d'une tentative de F5
*  @param $session
$  @param $tmsp_in
*/
function Lib_checkF5($session, $tmsp_in) {
	$F5 = false;
	$filename = DIR."tmp/{$session}_f5";

	// On récupère la valeur du timestamp
	if( is_file($filename) && file_exists($filename) && $hd=fopen($filename,"r") ){
		$tmsp_srv=unserialize( fread( $hd, filesize( $filename )) );
		fclose( $hd );
	}

	// On vérifie tout d'abord s'il y a tentative de F5
	if (isset($tmsp_srv) && $tmsp_in == $tmsp_srv) $F5 = true;

	// On mémorise le timestamp pour éviter les F5
	if( $hd=fopen($filename, "w+" ) ){
		fputs( $hd, serialize( $tmsp_in ) );
		fclose( $hd );
	}

	return $F5;
}

/**
* Génére un nom de fichier (à priori unique!)
*/
function Lib_buildFileName()
{
	$Id=0;
	$time=time();
	$length=8;// set this to the length of session variable desired

	mt_srand(time());
	$IdString="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$achar=strlen($IdString)-1;

	for ($i=0;$i<$length;$i++){
		$Id.=$IdString[mt_rand(0,$achar)];
	}

	return $Id;
}

/**
* Supprime les fichiers temporaires utilisés pour une session
* @param pattern Schema du nom des fichiers à supprimer
* @param ttl Time To Live ou durée de vie acceptée pour le fichier
*/
function Lib_deleteTmpFiles($pattern, $ttl = '') {

	$tmpdir = DIR."tmp/";
	if ($handle = opendir($tmpdir)) {
		while (false != ($file = readdir($handle))) {
				if (strstr($file,$pattern)) {
					if ($ttl != '' && (time()-filemtime($tmpdir.$file)) < $ttl)
						continue;
					unlink($tmpdir.$file);
				}
		}
		closedir($handle);
	}
}

function Lib_zipLogFile($session) {
    $log_dir = DIR."log/";
	$filename = $log_dir.$session.".log";
	$filename_gz = $log_dir.$session.".log.gz";

	// Création du zip des logs
	$fp = fopen($filename, 'r'); 
	$content = fread($fp, filesize($filename)); 
	fclose($fp); 
	// création d'un objet 'zipfile' 
	$zip = new zipfile(); 
	// ajout du fichier dans cet objet 
	$zip->addfile($content, $filename); 
	// production de l'archive' Zip 
	$archive = $zip->file();

	$fp = fopen($filename_gz, "w");
	fputs($fp,$archive);
	fclose($fp);

	unlink($filename);
}

function Lib_sessionExists($session) {
	$tmpdir = DIR."tmp/";
	$file = "session_".$session;
	return file_exists($tmpdir.$file);
}

/**
* Supprime les fichiers temporaires trop vieux
* @param $lifetime Duree de vie max des fichiers
*/
function Lib_deleteOldFiles($lifetime) {

	$tmpdir = DIR."tmp/";
	if ($handle = opendir($dmpdir)) {
		while (false != ($file = readdir($handle))) {
				if ((time()-filemtime($file))> $lifetime && $file != $tmpdir.'.' && $file != $tmpdir.'..') {
					unlink($file);
				}
		}
		closedir($handle);
	}
}

/**
* Récupère la liste des sessions identifiées dans le répertoire temporaire
*/
function Lib_getTmpSessions() {
	$TAB_SESSIONS = array();
	$tmpdir = (is_dir("dilasys/tmp/")) ? "dilasys/tmp/" : "tmp/" ;

	if ($handle = opendir($tmpdir)) {
		while (false != ($file = readdir($handle))) {
			if ($session = strstr($file,"session_")) {
				$session = substr($session, 8);
				array_push($TAB_SESSIONS, $session);
			}
		}

		$tab_return = array_unique($TAB_SESSIONS);
		closedir($handle);
	}

	return $tab_return;
}

/*
* Supprime les fichiers temporaires inutilisés
* Utilisé seulement par le fichier actions.php du login
*/
function Lib_deleteTmpOldFiles() {
	//Récupère le tableau avec la liste des sessions identifiées sous tmp
	$TAB_SESSIONS = Lib_getTmpSessions();

	foreach($TAB_SESSIONS as $session)
		Lib_deleteTmpFiles($session, $GLOBALS['elapse_time']);
}

/**
* Recuperation de la version en cours
*/
function Lib_getVersionFichier() {
	if ($handle = opendir(".")) {
	while (false != ($file = readdir($handle))) {
			if (preg_match("/(v)-([0-9a-z]).([0-9a-z]).([0-9a-z])/", $file, $ver)) {
			closedir($handle);
			return $ver[2].".".$ver[3].".".$ver[4];	
			}
	}
	closedir($handle);
	}		
}
/**
* Construire du fichier image d'un bouton de validation
* @param $fichier_img
* @param $filled
*/
function Lib_buildImg($fichier_img, $filled = 0) {

	$unit = 5;
	$image = imageCreate(12*$unit,4*$unit);

	$tab_col["black"] = imageColorAllocate($image, 0, 0, 0);
	$tab_col["grey"] = imageColorAllocate($image, 230, 230, 230);
	$tab_col["grey_white"] = imageColorAllocate($image, 200, 200, 200);
	$tab_col["grey_black"] = imageColorAllocate($image, 100, 100, 100);
	$tab_col["background"] = imageColorAllocate($image, 205, 205, 255);
	$fill_color = ($filled == 0) ? $tab_col["black"] : $tab_col["grey_white"];

	imageFilledRectangle($image, 0, 0, 12*$unit, 4*$unit, $tab_col["background"]);

	if ($filled) {
	imageFilledRectangle($image, 0, 0, 12*$unit, 4*$unit, $tab_col["grey"]);
	imagestring($image, 2, $unit, $unit, "Valider", $tab_col["black"]);
	}

	imagePng($image, $fichier_img);
	imageDestroy($image);

}

/**
* Generation aleatoire d'un nombre entier
* @param $nb Limite superieure pour la generation du nombre entier
*/
function Lib_myRandom($nb) {
	return rand(1, $nb);
}

/**
* 
*/
function Lib_intToHour($int){
	$tab = split("[.]",$int);
	$hour = ($tab[0] < 10) ? "0".$tab[0]."h" : $tab[0]."h";
	$hour .= (isset($tab[1])) ? "30" : "00";  
	return $hour;
}

/**
* Fonction nécessaire pour le tri d'un tableau multi-dimension avec usort
* La cle de tri GLOBAL correspond à la colonne sur laquelle on veut trier
*/
function Lib_compareUp($a,$b){
	global $cle;
	// On rajoute 1 car il faut retourner une valeur différente de 0
	return strcmp($a[$cle], $b[$cle])+1;
}

function Lib_compareUpInt($a,$b){
   global $cle;
   // On rajoute 1 car il faut retourner une valeur différente de 0
   return ((int)str_replace(CHR(32),"",$a[$cle]) > (int)str_replace(CHR(32),"",$b[$cle]));
}

function Lib_compareUp2($a,$b){
	global $cle1;
	global $cle2;
	// On rajoute 1 car il faut retourner une valeur différente de 0
	$res = strcmp($a[$cle1], $b[$cle1]);
	return ($res) ? $res : strcmp($a[$cle2], $b[$cle2])+1;
}

/**
* Fonction nécessaire pour le tri d'un tableau multi-dimension avec usort
* La cle de tri GLOBAL correspond à la colonne sur laquelle on veut trier
*/
function Lib_compareDown($a,$b){
	global $cle;
	return strcmp($b[$cle], $a[$cle])+1;
}

/**
* Transformation d'une chaine de caracteres dans la chaine des valeurs ascii
* correspondantes separees par un espace.
* @param $str Chaine a transformer
*/
function Lib_keyTab($str) {
	$key = $str;
	$new = preg_replace_callback("/./", create_function('$s','return sprintf("%03d ",ord($s[0]));'), $key);
	$key_tab = explode(" ",$new);
	array_pop($key_tab);
	array_unshift($key_tab, " ");
	return $key_tab;
}

/**
* Fonction de calcul du caractere d'un code ascii auquel on applique
* un decalage. Ce decalage est calcule a partir de la valeur ascii du caractere
* pointé sur le tableau realise a partir de la clef de cryptage. 
* @param $s Valeur dont il faut retrouver le caractere
*/
function Lib_myOrd($s) {
	global $key_tab;
	if(!next($key_tab)) reset($key_tab);
	return sprintf("%03d ",ord($s[0])+current($key_tab));
}

/**
* Fonction de calcul de la valeur ascii d'un charactere auquel on applique
* un decalage. Ce decalage est calcule a partir de la valeur ascii du caractere
* pointé sur le tableau realise a partir de la clef de cryptage. 
* @param $s Caractere dont il faut retrouver la valeur
*/
function Lib_myChr($s) {
	global $key_tab;	
	if(!next($key_tab)) reset($key_tab);
	return chr($s[0]-current($key_tab));  
}

/**
* Encryptage d'une chaine en fonction d'une clef passee en parametre.
* Appel a la fonction de callback Lib_myOrd qui calcule la valeur ascci
* de chaque caractere en lui appliquant un decalage grace a la clef 
* @param $str Chaine a encrypter
* @param $key Clef d'encryptage
*/
function Lib_encrypt($str,$key) {	
	global $key_tab;	
	$key_tab = Lib_keyTab($key);
	return preg_replace_callback("/./", "Lib_myOrd", $str);
}

/**
* Decryptage d'un chaine en fonction d'une clef passee en parametre.
* Appel a la fonction de callback Lib_myChr qui calcule le caractere correspondant
* a la valeur ascii des 3 chiffres sans decalage. 
* @param $str Chaine a decrypter
* @param $key Clef de decryptage
*/
function Lib_decrypt($str,$key) {
	global $key_tab;	
	$key_tab = Lib_keyTab($key);
	return preg_replace_callback("/([0-9]{3}) /", "Lib_myChr", $str);
}

/**
* Fonction pour telecharger des donnees texte afin de pouvoir les enregistrer
* sur le client leger.
* @param $data Donnees a telecharger
*/
function Lib_myExtract($data, $filename = '') {

	if ($filename == '') $filename = "data.csv";

	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	header("Pragma: no-cache");
	header("Expires: 0");	

	$crlf = Lib_endOfLine();

	foreach($data as $line) {
		print $line;
		if (!preg_match("/".$crlf."/",$line)) print $crlf;
	}
}

/**
* Fonction appelee par l'ob_start d'actions.php pour preparer la page HTML avant l'affichage.
* On remplace les mots-cles delimites par %% par leur valeur definitive issue du fichier 
* messages.php de chaque module.
* @param $buffer 
*/
function Lib_prepareAffichage($buffer) {
	return  preg_replace_callback("(%%[a-zA-Z_0-9]*%%)", create_function('$mots', 'global $MSG; global $lang; if($MSG[$lang][$mots[0]]!=""){return $MSG[$lang][$mots[0]];}else{return str_replace("_"," ",str_replace("%%","",$mots[0]));} '),$buffer);
//	return  preg_replace_callback("(%%[a-zA-Z_0-9]*%%)", create_function('$mots', 'global $MSG; global $lang; return $MSG[$lang][$mots[0]];'),$buffer);
}

/**
* Construction des boutons de validation si SecureForms est positionne a 1
* @param $nom Identifiant pour prefixer le nom des fichiers image
*/
function Lib_creerBoutons($prefix) {

	// On détermine quelle sera l'image valide
	$no_img = Lib_myRandom(4);

	// On cree toutes les images
	for ($i=1;$i<=4;$i++)
		Lib_buildImg("tmp/".$prefix."_img".$i.".png",0);
		
	// On cree l'image valide	
	Lib_buildImg("tmp/".$prefix."_img".$no_img.".png",1);
	
	/*=============*/ Lib_myLog("Mode secure => creation des boutons d'affichage");
	return $no_img;
}

/**
* Construction d'un tableau contenant 6 semaines maxi de 7 jours
* pour le mois contenu dans le timestamp passé en paramètre
* @param $time
*/
function Lib_getCalendrier($time = '', $complet = 0) {
	
	if ($time == '') $time = time();

	$mois_prec = mktime(0, 0, 0, gmdate("n",$time)-1, 1, gmdate("Y",$time));
	$mois_cour = mktime(0, 0, 0, gmdate("n",$time), 1, gmdate("Y",$time));
	$mois_suiv = mktime(0, 0, 0, gmdate("n",$time)+1, 1, gmdate("Y",$time));		
	
	$premier_jour_sem = gmdate("w",$mois_cour);
	if ($premier_jour_sem == 0) $premier_jour_sem = 7;
	
	$jours_mois_prec = round(($mois_cour - $mois_prec)/(60*60*24));	
	$jours_mois = round(($mois_suiv - $mois_cour)/(60*60*24));

	for($jour=($jours_mois_prec-$premier_jour_sem+2), $jour_pointe=1, $tmsp=($mois_cour-(($premier_jour_sem-1)*86400)); $jour_pointe < $premier_jour_sem; $jour_pointe++, $tmsp+=86400, $jour++) {
		$calp[$jour_pointe] = 0;
		$calj[$jour_pointe] = '';		
		$calt[$jour_pointe] = ($complet) ? $tmsp : '';		
	}	
		
	for($jour=1, $tmsp=$mois_cour; $jour<=$jours_mois; $jour++, $jour_pointe++, $tmsp+=86400) {
		$calp[$jour_pointe] = ($tmsp == $time) ? 1 : 0;
		if ($complet) $calp[$jour_pointe] = 0;
		$calj[$jour_pointe] = $jour;
		$calt[$jour_pointe] = $tmsp;
	}

	for($jour=1; $jour_pointe<=42; $jour_pointe++, $jour++, $tmsp+=86400) {
		$calp[$jour_pointe] = 0;
		$calj[$jour_pointe] = '';				
		$calt[$jour_pointe] = ($complet) ? $tmsp : '';		
	}	
		
	return array($calj,$calt,$calp);	
}

/**
* @param $time
*/
function Lib_getPeriode($time = '') {
	
	if ($time == '') $time = time();

	$tmsp_debut = mktime(0, 0, 0, gmdate("n",$time), gmdate("j",$time)-7, gmdate("Y",$time));
	$jour_debut = date("j",$tmsp_debut);
		
	for($tmsp=$tmsp_debut,$i=1; $i<=42; $i++, $tmsp+=43200) {
		$periodet[$tmsp] = $tmsp;		
		$jour = "%%".gmdate("D",$tmsp)."%% ".gmdate("j",$tmsp);					
		$periodej[$jour_pointe] = $jour;		
	}				
									
	return array($periodej,$periodet);									

}

/**
* Récupère un tableau avec les 12 mois de l'année
* @param $time
*/
function Lib_getMois($time = '') {
	
	$mois = array();
	if ($time == '') $time = time();
	
	for($i=0;$i<12;$i++) {
		$tmsp = mktime(0, 0, 0, gmdate("n",$time)+$i, 1, gmdate("Y",$time));
		$id = gmdate("n",$tmsp);
		$m = Lib_nomMois($tmsp);
		$mois[$id] = $m;
	}				
									
	return $mois;									
}

/**
* Récupère un tableau avec les n années suivant la date courante
* @param $time
*/
function Lib_getAnnees($time = '', $nb = 10) {
	
	$annees = array();
	if ($time == '') $time = time();
	
	for($i=0;$i<$nb;$i++) 
		array_push($annees,gmdate("Y",mktime(0, 0, 0, 1, 1, gmdate("Y",$time)+$i)));
									
	return $annees;									
}

/**
* Récupère l'année de travail courante
* @param $time
*/
function Lib_getAnneeTravail() {
	// Une saison d'embauche commence à l'arrivée du printemps!
	return (time() >= mktime(0,0,0,3,21,gmdate("Y"))) ? date("Y")+1 : gmdate("Y");
}

function Lib_diffMois($start,$end) {
	
	//$date_format = YYYY-m-d
	sscanf(Lib_frToEn($start), "%4s-%2s-%2s", $annee, $mois, $jour);
	$a1 = $annee;
	$m1 = $mois;
	sscanf(Lib_frToEn($end), "%4s-%2s-%2s", $annee, $mois, $jour);
	$a2 = $annee;
	$m2 = $mois;
 
	$dif_en_mois = ($m2-$m1)+12*($a2-$a1);
	return $dif_en_mois ;
}

function week_dates($week,$year) {
	$week_dates = array();
	// On récupère le timestamp de la première semaine de l'année
	$first_day = gmmktime(12,0,0,1,1,$year);
	$first_week = date("W",$first_day);
	// On récupère le timestamp de la semaine demandée
	$timestamp = strtotime("+$week week",$first_day);

	// On ajuste au lundi
	$what_day = date("w",$timestamp);
	if ($what_day==0) {
		// Dimanche, dernier jour de la semaine 
		$timestamp = strtotime("-6 days",$timestamp);
	} elseif ($what_day > 1) {
		$what_day--;
		$timestamp = strtotime("-$what_day days",$timestamp);
	}
	$week_dates[1] = date("Y-m-d",$timestamp); // Lundi
	$week_dates[2] = date("Y-m-d",strtotime("+1 day",$timestamp)); // Mardi
	$week_dates[3] = date("Y-m-d",strtotime("+2 day",$timestamp)); // Mercredi
	$week_dates[4] = date("Y-m-d",strtotime("+3 day",$timestamp)); // Jeudi
	$week_dates[5] = date("Y-m-d",strtotime("+4 day",$timestamp)); // Vendredi
	$week_dates[6] = date("Y-m-d",strtotime("+5 day",$timestamp)); // Samedi 
	$week_dates[7] = date("Y-m-d",strtotime("+6 day",$timestamp)); // Dimanche 
	return($week_dates);
}

function file_size($file)
	{
			$size = filesize($file);
			for($si = 0; $size >= 1024; $size /= 1024, $si++);
			return round($size, 1)." ".substr(' KMGT', $si, 1)."b";
	}

function droits($fichier)
	{
		$perms = fileperms($fichier);

		if (($perms & 0xC000) == 0xC000) {
			// Socket
			$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
			// Lien symbolique
			$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
			// Régulier
			$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
			// Block spécial
			$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
			// Dossier
			$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
			// Caractère spécial
			$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
			// FIFO pipe
			$info = 'p';
		} else {
			// Inconnu
			$info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
			(($perms & 0x0800) ? 's' : 'x' ) :
			(($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
			(($perms & 0x0400) ? 's' : 'x' ) :
			(($perms & 0x0400) ? 'S' : '-'));

		// All
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
			(($perms & 0x0200) ? 't' : 'x' ) :
			(($perms & 0x0200) ? 'T' : '-'));

		return $info;
	}

 // Recursive directory delete - Nexen.com
	function deldir($dir)
	{
		$current_dir = opendir($dir);
		while($entryname = readdir($current_dir))
		{
			if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")) {
				deldir("${dir}/${entryname}");
				$GLOBALS['dossiersup']++;
			}
			elseif($entryname != "." and $entryname!="..") {
				unlink("${dir}/${entryname}");
				$GLOBALS['fichiersup']++;
			}
		}
		closedir($current_dir);
		rmdir(${dir});
	}
  
 // Fonction de récupération de l'arborescence complète...
 // le niveau permettra de savoir à quel niveau on se situe dans l'arborescence
 // l'id permet de donner un identifiant unique à chaque répertoire pour les besoins de la fonction d'affichage
	function getdir($repertoire, $famille, $id)
	{
	$famille .= $id."-";
	$tab_dir['famille']			= $famille;
	$tab_dir['nom_repertoire']	= $repertoire;
	$tab_dir['liste_repertoires'] = array();
	$tab_dir['liste_fichiers']	= array();
	$id=1;

		$current_dir = opendir($repertoire);

		while($entryname = readdir($current_dir))
		{
			if(is_dir("$repertoire/$entryname") and ($entryname != "." and $entryname!="..")) {
		$tab_dir['liste_repertoires'][] = getdir("${repertoire}/${entryname}", $famille, $id);
		$id++;
			}
			elseif($entryname != "." and $entryname!="..") {
		$extension=substr(strrchr($entryname,"."),1);
		$ext="";
		if (file_exists('../img/'.$extension.'.ico')) $ext="ico";
		if (file_exists('../img/'.$extension.'.gif')) $ext="gif";
	
		if ($ext=="")
		{
			$extension="default";
			$ext="gif";
		}

		$fichier['nom_fichier'] = $entryname;	
		$fichier['type_fichier'] = $extension.".".$ext;		
		$fichier['taille_fichier'] = file_size($repertoire."/".$entryname);	
		$fichier['date_fichier'] = gmdate("d/m/Y H:i:s", filemtime($repertoire."/".$entryname)); 

		$tab_dir['liste_fichiers'][] = $fichier;
			}
		}

	closedir($current_dir);

	return $tab_dir;
	}  

//----------------------------------------------------------------------------------
// Sectionne un tableau et renvoie la section demandée
//----------------------------------------------------------------------------------
function Lib_selectSection($input_array, $section, $taille_tableaux = '') {
	if ($taille_tableaux == '') $taille_tableaux = $GLOBALS['taille_tableaux'];
	if ($section == "") $section=0;
	
	$indice = $section*$taille_tableaux;
	$return_array = array_slice($input_array, $indice, $taille_tableaux);

	return $return_array;
}

//----------------------------------------------------------------------------------
// Renvoie le nombre de sections que peut contenir un tableau
//----------------------------------------------------------------------------------
function Lib_nbSections($input_array) {
	global $taille_tableaux;

	$array_length = count($input_array);
	$nb_sections = ceil($array_length/$taille_tableaux);

	return $nb_sections;
}

//----------------------------------------------------------------------------------
// Affiche une ligne de navigation pour l'affichage de tableaux
//----------------------------------------------------------------------------------
function Lib_buildTabSections($NbSections, $section, $session, $page, $action, $mode) {
	global $taille_tableaux;

	if ($section == "") $section=0;
	$IdLink = $section;

	// On affiche maximum 10 champs de navigation (outre << et >>)!
	$NbCases = ((($NbSections-$section) > 12)? 12 : $NbSections-$section+2);
	$Tab = New Table(1,$NbCases);

	for($i=1; $i<=($NbCases-2); $i++) {
		$link = new Link("main.php?session=$session&page=$page&action=$action&mode=$mode&section=$IdLink",font("$IdLink"));
		$Tab->addObject($link, 0, $i);
		$IdLink++;
	}

	$link = new Link("main.php?session=$session&page=$page&action=$action&mode=$mode&section=0",font("<<"));
	$Tab->addObject($link, 0, 0);
	$Fin=$NbSections-1;
	$link = new Link("main.php?session=$session&page=$page&action=$action&mode=$mode&section=$Fin",font(">>"));
	$Tab->addObject($link, 0, ($NbCases-1));

	return $Tab;
}

/**
* Fonction de récupération de flux HTTP
* Permet ainsi de faire des includes à distance!
* @param $time
*/
function my_include($url, $srv) { 
	$out = "GET $url HTTP/1.0\n\n"; 

	$fp = fsockopen($srv, 80, $errno, $errstr, 12);
	fputs($fp, "GET $url HTTP/1.0\r\n");
	fputs($fp, "Host: $srv\r\n");
	fputs($fp, "Referer: http://$srv\r\n");
	fputs($fp, "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\r\n\r\n");	

	if(!$fp) {
		echo "$errstr ($errno)<br>\n";
	} else {	
		fwrite($fp, $out); 
		$ret = "";
			while(!feof($fp)) {
				$ret .= fgets($fp,128);
			}
			fclose($fp);
		return $ret;			
	}
} 
 
function Lib_afficheTableau($tab, $dec){
	$decalage = "";
	if ($dec == 0) echo "\r\n";
	for($i=0;$i<$dec;$i++)
		$decalage .= "  ";
	
	echo "array (\r\n";
	foreach($tab as $cle => $val){
		if( !is_array($val) ){
		echo $decalage."  \"$cle\" => $val,\r\n";
		}else{
		echo $decalage."  \"$cle\" => ";
		Lib_afficheTableau($val, $dec+1);
		}
	}
	echo $decalage.")\r\n";
} 
 
/**
* Fonction de découpage d'une chaîne de recherche
* Les chaînes sont reçues au format: avec "chaine 1..." avec "chaine 2..." sans "chaine 3..." sans "chaine4"
*
* @param $chaine
*/
function Lib_parseChaine($chaine) {
	$tab_res = array();
	$chaine = Lib_canonizeMin($chaine);

	// Si la chaîne reçue ne comporte pas de guillemets on la transforme pour la traiter avec la mécanique normale: 
	// on lui rajoute les guillemets et les mots-clefs 'avec'
	if (!preg_match('/"/', $chaine)) {
		// On remplace les tirets pour élargir la recherche
		$chaine = strtr($chaine, "-", " ");

		$tab_chaine = explode(" ", $chaine);
		foreach($tab_chaine as $elem) 
			$resultat .= 'avec "'.$elem.'"';
		$chaine = $resultat;
	}
	
	if (preg_match('/"/', $chaine)) {
		// On récupère chacun des blocs composés par l'opération (+, - ou |) et la chaine qui suit
		preg_match_all("/([ ]*avec[ ]*)?([ ]*sans[ ]*)?[ ]*\"[a-zA-Z0-9,' ]*\"/", $chaine, $res);
		$nom_orgs = array_shift($res);

			// Pour chacun des blocs récupérés, on construit un tableau contenant le type d'opération, la condition et la chaine
			for($i=0; $i<count($nom_orgs); $i++) {
				$regs = "";
				$org = $nom_orgs[$i];
				if (preg_match("`[ ]*avec[ ]*\"(.*)\"`",  $org, $regs)) { 
					$op = 'AND'; $not = ''; 
				} else if (preg_match("`[ ]*sans[ ]*\"(.*)\"`",  $org, $regs)) { 
					$op = 'AND'; $not = 'NOT'; 
				} else if ($i === 0) {
					preg_match("`[ ]*\"(.*)\"`",  $org, $regs);	
					$op = 'AND'; $not = ''; 	
				} else { 
					preg_match("`[ ]*\"(.*)\"`",  $org, $regs);
					$op = 'OR'; $not = ''; 
				}

				$ligne['operation'] = $op;
				$ligne['condition'] = $not;
				$ligne['chaine'] = ($regs[2] != '') ? $regs[2] : $regs[1];
				$tab_res[] = $ligne;
			}
	}
	return $tab_res;
}

/**
*
*/
function Lib_tstCar( $chaineSrc, $chaineRange ){
  for( $i=0 ; $i<strlen( $chaineSrc ) ; $i++ ){
	if( strstr( $chaineRange, $chaineSrc[$i] )===FALSE ){
		return true;
	}
  }
  return false;
}  
 
/**
* Attention : si le fichier est OK on renvoie 0 ! (0 erreur)
*/ 
function Lib_isValidFile($nom_fichier, $tab_extensions) {
	$ext = strrchr($nom_fichier, '.');
	/*=============*/ Lib_myLog("Extension : {$ext}");
	$accept = 1; 
	foreach($tab_extensions as $extension)
		if (preg_match("`{$extension}`i", $ext))
			$accept = 0;
	return $accept;
}

/**
* Fonction de redimensionnement des images
* 
* @param $tmp_photo
* @param $dest_width
* @param $dest_height
*/ 
function Lib_redimImage($tmp_photo, $dest_width = '', $dest_height = '', $priorite = '') {
	$ext = strrchr($tmp_photo, '.');

	// On vérifie si on travaille avec une extension valide
	if(!preg_match('`jpg`i', $ext) && !preg_match('`jpep`i', $ext) &&
		!preg_match('`gif`i', $ext) && !preg_match('`png`i', $ext))
		return;

	/*=============*/ Lib_myLog("Redimensionnement de {$tmp_photo} a w = {$dest_width} et h = {$dest_height}");
	$size1 = GetImageSize($tmp_photo);
	$src_w = $dst_w = $size1[0]; 
	$src_h = $dst_h = $size1[1]; 
	/*=============*/ Lib_myLog("Dimensions d'origine : w = {$src_w} et h = {$src_h}");

	// On travaille sur la largeur et la largeur est plus grande que la destination
	if ($dest_width != '' && $dest_height == '' && $src_w > $dest_width) {
		$dst_w = $dest_width;
		$dst_h = round($src_h*($dst_w/$src_w));
	}

	// On travaille sur la hauteur et la hauteur est plus grande que la destination
	if ($dest_height != '' && $dest_width == '' && $src_h > $dest_height) {
		$dst_h = $dest_height;
		$dst_w = round($src_w*($dst_h/$src_h));
	}

	if ($dest_height != '' && $dest_width != '') {
		if ($priorite != '' && ($src_w > $dest_width || $src_h > $dest_height)) {
			if ($priorite == 'h') {
				/*=============*/ Lib_myLog("Priorite a la hauteur");
				if ($src_w < $dest_width) {
					$dst_h = $dest_height;
					$dst_w = round($src_w*($dst_h/$src_h));
				} else {
					if ($src_h < $dest_height) {
						$dst_w = $dest_width;
						$dst_h = round($src_h*($dst_w/$src_w));
					} else {
						$dst_h = $dest_height;
						$dst_w = round($src_w*($dst_h/$src_h));
					}
				}
			} 

			if ($priorite == 'w') {
				/*=============*/ Lib_myLog("Priorite a la largeur");
				if ($src_h < $dest_height) {
					$dst_w = $dest_width;
					$dst_h = round($src_h*($dst_w/$src_w));
				} else {
					if ($src_w < $dest_width) {
						$dst_h = $dest_height;
						$dst_w = round($src_w*($dst_h/$src_h));
					} else {
						$dst_w = $dest_width;
						$dst_h = round($src_h*($dst_w/$src_w));
					}
				}
			} 
		} else {
			/*=============*/ Lib_myLog("On force le redimensionnement");
			$dst_h = $dest_height;
			$dst_w = $dest_width;
		}
	}

	/*=============*/ Lib_myLog("Dimensions finales : w = {$dst_w} et h = {$dst_h}");

	$dst_img = ImageCreateTrueColor($dst_w,$dst_h); 
	if(preg_match('`jpg`i', $ext) || preg_match('`jpep`i', $ext))
		$src_img = imagecreatefromjpeg($tmp_photo);
	elseif (preg_match('`gif`i', $ext))
		$src_img = imagecreatefromgif($tmp_photo);
	elseif (preg_match('`png`i', $ext))
		$src_img =imagecreatefrompng($tmp_photo);

	ImageCopyResampled($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);

	if(preg_match('`jpg`i', $ext) || preg_match('`jpep`i', $ext))
		imagejpeg($dst_img,$tmp_photo);
	elseif (preg_match('`gif`i', $ext))
		imagegif($dst_img,$tmp_photo);
	elseif (preg_match('`png`i', $ext))
		imagepng($dst_img,$tmp_photo);}
 
/**
*	Contrôle du fichier CSV à importer, la 1ère ligne contient le nom des colonnes
*
*/
function Lib_testeCSV( $data ){
  global $import_cfg;
  $tab_erreur = array();
  
  // valeur en fonction du type
  $strAlphaMin="abcdefghijklmnopqrstuvwxyz";
  $strAlphaMaj="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $strAlpha=$strAlphaMin.$strAlphaMaj."ÂÄÊËÉÈÎÏÔÖÛÜÇàäâëêéèïîôöùüûç&'_-/(). ";
  $strNum="0123456789.,";
  $strAlphaNum=$strAlpha.$strNum;
  $strAll=$strAlphaNum.",?.:/!§%ù*µ$£àà&é#([-|çà)]+=";

  $err=0;
  $numLigne=1;
  $tabCfg=array();
  $dynatabDataImport=array();

  ini_set( "max_execution_time", 2000 );

  foreach( $data as $ligne ){
	// On saute les lignes vides pour ne pas avoir des lignes avec que des ; (point-virgule)
	if (strlen($ligne) < 2) continue;
	$tabCol=explode( ";", $ligne );

	if( $numLigne==1 ){
		$nb_cols = count($tabCol);

		// on va récupérer les nom des champs dans la config
		foreach( $import_cfg as $field=>$row ){
		// pour tous les champs à importer
		if( $row["TRAITER"]){
		// on va rechercher si existant dans le fichier à importer
			$key=array_search( $row["CHAMP_CSV"], $tabCol, TRUE );
			if( $key!==FALSE ){
				$tabCfg[$key]=$field;
				$tabCol[$key]="#"; // on efface ce champ pour tracer son affectation
			}
			else {
				$msg = "La colonne '{$row["CHAMP_CSV"]}' n'est pas présente dans votre fichier d'importation";
				$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);
				$err.=0x02; // erreur fatale
			}
		}
		if( $err&0x02 ) break;
		}
		ksort( $tabCfg );		
	} else {
		// Chaque ligne doit comporter autant de colonnes que la première ligne!
		// Si ce n'est pas le cas, c'est que nous avons peut-être des retours chariots dans les cellules...
		if (count($tabCol) < $nb_cols) {
			$msg = "La ligne $num_ligne ne comporte pas suffisamment de colonnes";
			$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);				
		} else {
			foreach( $tabCfg as $key=>$field ){
			// il faut gérer les formats sauf pour les imports spécifiques
			$dataCol=trim($tabCol["$key"]);
			$errCol=false;			

			switch( $import_cfg[$field]["TYPE"] ){
				case "VARCHAR" :
					// Dans le cadre d'un varchar on laisse tout passer !

					// if(Lib_tstCar( $dataCol, $strAll )) {
					//	$msg = "'{$field}' contient des caracteres non valides ({$dataCol})";
					//	$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);
					//}
				break;
				case "INT" :
					if (Lib_tstCar( $dataCol, $strNum )) {
						$msg = "'{$field}' ne prend que des chiffres ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);
					}
				break;
				case "DATE" :
					if ( $dataCol != '' && !preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $dataCol) ) { 
						$msg = "'{$field}' devrait avoir un format date de type JJ/MM/AAAA ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);									
					}
				break;
				case "NONVIDE" :
					if ($dataCol=="") {
						$msg = "'{$field}' ne doit pas être vide ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);				
					}
				break;
				case "TEL" :
					if (Lib_tstCar( $dataCol, "1234567890/-.+() " )) {
						$msg = "'{$field}' ne prend que des chiffres avec ou sans espace ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);
					}
				break;
				case "CP":
					if (Lib_tstCar( $dataCol, $strAlphaMaj.$strNum." ")) { 
						$msg = "'{$field}' ne prend que des chiffres ou des lettres majuscules ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);				
					}
				break;
				case "EMAIL":
					if ( $dataCol != '' && !preg_match("/([0-9a-zA-Z._-])+@([0-9A-Za-z_-])+\.([0-9A-Za-z_-])+/", $dataCol) ) { 
						$msg = "'{$field}' ne prend que des lettres, chiffres, tirets, underscores, un arobase et un point dans le bloc suivant l'arobase ({$dataCol})";
						$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);				
					}
				break;			
				default :
				break;
			}
			$tabEnr["$field"]=$dataCol;
	
			if( $errCol ) {
				// $this->setErr( true, "i", $numLigne, "", "Ligne non traitée" );
				break 1;
			}
			}
		}
		if( $err&0x20 ) break;
	}
	// s'il y a une erreur fatale on arrête tout
	if( $err&0x20 ) break;
	$numLigne++;
  }

  return $tab_erreur;
}  
  
/**
*	Contrôle du fichier CSV à importer, la 1ère ligne contient le nom des colonnes
*
*/
function Lib_importeCSV( $data ){
  global $import_cfg;

  $tab_erreur = array();
  $numLigne=1;
  $tabCfg=array();
  $nbLignesKO = $nbLignesOK = 0;

  ini_set( "max_execution_time", 2000 );

  foreach( $data as $ligne ){

	// On saute les lignes vides pour ne pas avoir de lignes avec que des point-virgule
	if (isset($nb_cols) && strlen($ligne) <= $nb_cols+1) continue;
	$tabCol=explode( ";", $ligne );

	if( $numLigne==1 ){
		// on va récupérer les noms des champs dans la config
		foreach( $import_cfg as $field=>$row ){
		// pour tous les champs à importer
		if( $row["TRAITER"]){
			// on va rechercher dans le fichier à importer
			$key=array_search( $row["CHAMP_CSV"], $tabCol, TRUE );
			$tabCfg[$key]=$field;
			$tabCol[$key]="#"; // on efface ce champ pour tracer son affectation
		}
		}
		ksort( $tabCfg );
	} else {
		// La classe transfert doit être définie auparavant!
		$transfert = new Transfert();	

		foreach( $tabCfg as $key=>$field ){
		// il faut gérer les formats sauf pour les imports spécifiques
		$dataCol=trim($tabCol["$key"]);

		// On transforme les caractères spéciaux les plus courants
		$dataCol = str_replace(chr(133), "...", $dataCol);
		$dataCol = str_replace('’', "'", $dataCol);
		$dataCol = str_replace('–', "-", $dataCol);

		// Il faut encoder en utf8 car les fonctions internes de la classe import utf8_decodent tout ce qui arrive
		// avant de stocker l'information en base
		$dataCol = utf8_encode($dataCol);

		$transfert->$import_cfg[$field]["CHAMP_CLASSE"] = $dataCol;
		}

		$transfert->ADD();
		if ($transfert->isError()) {
			$msg = "Erreur d'insertion!";
			$tab_erreur[]=array("num_ligne"=>$numLigne, "msg"=>$msg);		
			$nbLignesKO++;
		}
		if (!$transfert->isError()) $nbLignesOK++;
	}
	$numLigne++;	
  }
  
  if ($nbLignesOK) {
		$msg = "$nbLignesOK ligne(s) insérée(s). ";
		$tab_erreur[]=array("num_ligne"=>"", "msg"=>$msg);  
  }
  return $tab_erreur;
}	
 
/**
*	Effectue une césure dans un texte sans toucher au code html.
*
*/
function htmlwrap($str, $width = 75, $break = "\n", $cut = false)
{
	/*=============*/ Lib_myLog("Nettoyage de {$str} a {$width} de long");
	$html = array(
		"/(<table(.*)>)(.*)(<\/table>)/si", 
		"/(<strong>)(.*)(<\/strong>)/U", 
		"/(<div>(.*))(.*)(<\/div>)/U", 
		"/(<span(.*)>)(.*)(<\/span>)/U", 
		"/(<img(.*))>/U",
		"/(<a href=\"http(.*)>)(.*)(<\/a>)/U");
	$replace = array(
		" ", // Suppression du tableau et de son contenu
		"\\2", // Suppression de la balise <strong>
		"\\3", // Suppression de la balise <div>
		"\\3", // Suppression de la balise <span>
		" ", // Suppression de la balise <img>
		"\\3"); // Suppression de la balise <a>
	$str = preg_replace($html, $replace, $str);

	//same functionality as wordwrap, but ignore html tags
	$unused_char = find_unused_char($str); //get a single character that is not used in the string
	$tags_arr = get_tags_array($str);
	$q = '?';
	$str1 = ''; //the string to be wrapped (will not contain tags)
	$element_lengths = array(); //an array containing the string lengths of each element
	foreach($tags_arr as $tag_or_words)
	{
		if(preg_match("/<.*$q>/", $tag_or_words)) continue;
		$str1 .= $tag_or_words;
		$element_lengths[] = strlen($tag_or_words);
	}
	$str1 = wordwrap($str1, $width, $unused_char, $cut);
	foreach($tags_arr as &$tag_or_words)
	{
		if(preg_match("/<.*$q>/", $tag_or_words)) continue;
		$tag_or_words = substr($str1, 0, $element_lengths[0]);
		$str1 = substr($str1, $element_lengths[0]);
		array_shift($element_lengths); //delete the first array element - we have used it now so we do not need it
	}
	$str2 = implode('', $tags_arr);
	$str3 = str_replace($unused_char, $break, $str2);

	return $str3;
}

function get_tags_array($str)
{
    //given a string, return a sequential array with html tags in their own elements
    $q = '?';
    return preg_split("/(<.*$q>)/",$str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
}

function find_unused_char($str)
{
    //find an unused character in a string
    $possible_chars = array('|', '!', '@', '#', '$', '%', '^', '&', '*', '~');
    foreach($possible_chars as $char) if(strpos($str, $char) === false) return $char;
    die('you must add another SINGLE unused character, not one of [|!@#$%^&*~], to the $possible_chars array in function find_unused_char');
}

function Lib_cesureTexte($texte, $long = 512) {
	$new_texte = '';
	$i=0;
	for($pos=0; $pos<strlen($texte) ; $pos++,$i++){
		$new_texte .= $texte[$pos];
		if ($i >= $long && $texte[$pos] == ' ') {
			$new_texte .= '
';
			$i = 0;
		}
	}
	return $new_texte;
}

/**
* Fonction pour éviter l'affichage de dates à 0 ou de chaînes vides
* @param stringAVider
* @param type
*/
function Lib_formatStringVide($stringAVider, $type='DATE', $nb_decimal=2){
	$replace = '';
	switch($type){
		case "DATE":{
			if($stringAVider == "00/00/0000" || $stringAVider == "0000-00-00"){
				$stringAVider = $replace;
			}
		}
		break;

		case "FLOAT":{
			$stringAVider = Lib_myRoundDisplayParam($stringAVider, $nb_decimal);
			if($stringAVider == Lib_myRoundDisplayParam(0, $nb_decimal)){
				$stringAVider = $replace;
			}
		}
		break;
		
		case "INT":{
			if($stringAVider == 0){
				$stringAVider = $replace;
			}		
		}
	}
	
	return $stringAVider;
}

function Lib_ArboAfficher($liste_elements, $html = ''){
	if(!empty($liste_elements)){
		echo '<ol class="dd-list">';
		foreach($liste_elements as $element){
			echo '<li class="dd-item" data-id="'.$element['id_arbo'].'">';
			if($element['id_arbo_pere'] != 0)
				echo '<div class="dd-handle">Dossier '.$element['intitule'].'</div>';
			else
				echo '<div class="dd-handle">Fichier '.$element['intitule'].'</div>';
			echo  '</li>';
			Lib_ArboAfficher($element['liste_fils'], $html);
		}
		echo '</ol>';
	}
}

function Lib_zipFile($filename, $replace = 0, $extension = '.zip') {
	$filename_gz = $filename.$extension;

	// Création du zip
	$fp = fopen($filename, 'r'); 
	$content = fread($fp, filesize($filename)); 
	fclose($fp); 
	// création d'un objet 'zipfile' 
	$zip = new zipfile(); 
	// ajout du fichier dans cet objet 
	$zip->addfile($content, $filename); 
	// production de l'archive' Zip 
	$archive = $zip->file();

	$fp = fopen($filename_gz, "w");
	fputs($fp,$archive);
	fclose($fp);

	if ($replace) unlink($filename);
}

function Lib_zipDirectory($filename, $replace = 0, $extension = '.zip', $tab_files = array()) {
	$filename_gz = '../../img_ftp/'.$filename.$extension;
	Lib_myLog("Debut zipDirectory {$filename}");
	if ($replace && file_exists($filename_gz)) unlink($filename_gz);
	
	if(!empty($tab_files)){
		// création d'un objet 'zipfile' 
		$zip = new zipfile(); 
		// Création du zip
		foreach($tab_files as $chemin_archive=>$file){
			$fp = fopen('../../img_ftp/'.$file, 'r');
			$content = fread($fp, filesize('../../img_ftp/'.$file)); 
			fclose($fp);
			// ajout du fichier dans l'objet 'zipfile'
			$zip->addfile($content, $chemin_archive); 
		}
		// production de l'archive' Zip 
		$archive = $zip->file();

		$fp = fopen($filename_gz, "w");
		fputs($fp, '../../img_ftp/'.$archive);
		fclose($fp);
	}
}

} // Fin if (!defined('__LIB_INC__')){
?>