<?
//==================================================================================
// Si cette variable n'a pas ete positionnee par actions.php de la racine, 
// le fichier present ne sera pas execute
//==================================================================================
if (!defined('__AUTHORIZED__')) exit;

function Maj_Version($version) {
   echo "<b>Mise à jour de la version d'AroBase: </b>";

   $sql = "UPDATE ".$GLOBALS['prefix']."parametres
           SET ValParametre = '$version'
           WHERE NomParametre = 'Version'";

   $result = mysql_query($sql);
   if ($result)
      echo "Version mise à jour!<br>";
   else
      trigger_error("BdD: ".mysql_error()." (".mysql_errno().")", E_USER_ERROR);

}

$params = Parametres_recuperer("system");
$PARAMS = $params->getParametres();
$versionEnCours = $PARAMS['Version'];
$version = Lib_getVersionFichier();

echo "<b>Version en cours: </b>".$versionEnCours."<br>";
echo "<b>Nouvelle version: </b>".$version."<br> <br>";

switch($versionEnCours)
{
   case "0.0.e":
      Maj_Version($version);
   break;
   
   default:
      Maj_Version($version);
   break;
}

echo "<br> <b> <font color=\"green\"> Corrections terminées  </font> </b> <br>";

?>
