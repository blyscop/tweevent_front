<?
/** @file
*  @brief this file in Factures
*/

/**
 * Classe pour la génération d'urls externes
 *
 * @author dilas0ft
 * @version 1.0

CREATE TABLE IF NOT EXISTS `lucine_sys_rewriting` (
  `url_externe` text NOT NULL,
  `url_interne` text NOT NULL
)

 */

if (!defined('__REWRITING_INC__')) {
	define('__REWRITING_INC__', 1);

/**
Génération d'une url interne aléatoire
*/
function Rewriting_new()
{
	$url_externe='';
	$length=20;// set this to the length of session variable desired
	$session_string="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$achar=strlen($session_string)-1;

	for ($i=0;$i<$length;$i++)
		$url_externe.=$session_string[mt_rand(0,$achar)];

	return $url_externe;
}


/**
Créé une url externe pour une url interne donnée.
@param $url_interne
*/
function Rewriting_add($url_interne)
{
	$url_externe = Rewriting_new();
	$sql = "INSERT INTO ".$GLOBALS['prefix']."sys_rewriting VALUES ('$url_externe','$url_interne')";
	$result = mysql_query($sql);
	return $url_externe;
}

/**
Retourne l'url interne correspondant à l'url externe fournie en paramètre.
@param $url_externe
*/
function Rewriting_getUrlInterne($url_externe)
{
	$url_interne = "";

	$sql = "SELECT * FROM ".$GLOBALS['prefix']."sys_rewriting WHERE url_externe = '$url_externe'";
	$result = mysql_query($sql);

	if ($result) {
		while($row = mysql_fetch_object($result)) {
			$url_interne = $row->url_interne;
		}
	}

	return $url_interne;
}

}
?>