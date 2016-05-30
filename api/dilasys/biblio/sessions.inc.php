<?
if (!defined('__SESSIONS_INC__')){
define('__SESSIONS_INC__', 1);
define('__NO_SESSION__',2);
define('__SESSION_TIMEOUT__',3);
define('__LOG_IN__',4);
define('__LOG_OUT__',5);
define('__DUPE_FORCE_OUT__',6);
define('__DATABASE_ERROR__',7);

//----------------------------------------------------------------------------------
// Paramètres pour la gestion des sessions
//----------------------------------------------------------------------------------
$SessionDuration = (isset($elapse_time)) ? $elapse_time : 7200; // Durée maximale d'une session exprimée en secondes
$session_id_length = 8;

//----------------------------------------------------------------------------------
// Error message
//----------------------------------------------------------------------------------
function Sessions_error($msg)
{
    echo "$msg <br>";
}

//----------------------------------------------------------------------------------
// Look for expiration for 1 session
//----------------------------------------------------------------------------------
function Sessions_clean($session)
{
   global $SessionDuration;

   if (Sessions_exists($session)) {

      $session_time = Sessions_getTime($session);
      $nom_utilisateur = Sessions_getUtilisateur($session);
      $adresse_ip = Sessions_getAdresseIp($session);

      $ElapsedTime = time()-$session_time;

      if ( $ElapsedTime > $SessionDuration) {
         Sessions_writeLog("$nom_utilisateur ($session)",$adresse_ip,__SESSION_TIMEOUT__);
         Sessions_delete($session);
         return false;
      } else {
       	return true;
      }
   }
   return true;
}

//----------------------------------------------------------------------------------
// Look for, log out, and delete all old sessions
//----------------------------------------------------------------------------------
function Sessions_cleanAll()
{
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_sessions";

   $result = mysql_query($sql);

   if ($result) {
      if (mysql_num_rows($result) > 0) {
         while($row = mysql_fetch_object($result)){
            Sessions_clean($row->session_id);
         }
      }
      mysql_free_result($result);
      return true;
    } else  {
       Sessions_error("Impossible de mettre à jour les Sessions !");
       return false;
    }
}

//----------------------------------------------------------------------------------
// Update session time.
//----------------------------------------------------------------------------------
function Sessions_update($session)
{
   $time = time();
   if (Sessions_exists($session)) {
      $sql = "UPDATE ".$GLOBALS['prefix']."sys_sessions
              SET time = '$time'
              WHERE session_id = '$session'";

      $result = mysql_query($sql);

      if ($result)
         return true;
      else {
         Sessions_writeLog($session,"---",__DATABASE_ERROR__);      
         return false;
      }
   }
}

//----------------------------------------------------------------------------------
// Set a session.
//----------------------------------------------------------------------------------
function Sessions_new()
{
   global $session_id_length;

   $session=0;
   $time=time();
   $length=$session_id_length;// set this to the length of session variable desired

   mt_srand(time());

   $session_string="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

   $achar=strlen($session_string)-1;

   for ($i=0;$i<$length;$i++){
      $session.=$session_string[mt_rand(0,$achar)];
   }

   return $session;
}

//----------------------------------------------------------------------------------
// Ajoute une session
//----------------------------------------------------------------------------------
function Sessions_add($session,$id_utilisateur,$adresse_ip)
{
   $time=time();

   $sql = "INSERT INTO ".$GLOBALS['prefix']."sys_sessions
           VALUES ('$session','$id_utilisateur','$adresse_ip','$time')";

   $result = mysql_query($sql);

   if ($result){
      $nom_utilisateur = Sessions_getUtilisateur($session);
      Sessions_writeLog("$nom_utilisateur ($session)",$adresse_ip,__LOG_IN__);
      return true;
   } else {
    echo mysql_error();
      Sessions_error("Impossible d'ouvrir une session !");
      return false;
   }

}

//----------------------------------------------------------------------------------
// Détruit une session à partir de son identifiant
//----------------------------------------------------------------------------------
function Sessions_delete($session)
{
   if (Sessions_exists($session)) {
      // On récupere d'abord les infos sur la session pour la log
      $adresse_ip = Sessions_getAdresseIp($session);
      $nom_utilisateur = Sessions_getUtilisateur($session);

      $sql = "DELETE
              FROM ".$GLOBALS['prefix']."sys_sessions
              WHERE session_id = '$session'";

      $result = mysql_query($sql);

      if ($result) {
         Sessions_writeLog("$nom_utilisateur ($session)",$adresse_ip,__LOG_OUT__);
         return true;
      } else {
         Sessions_error("Problème lors de la suppression de la session!");
         return false;
      }
   }

}

//-----------------------------------------------------------------------------------
// Check if a session exists in the system.
//-----------------------------------------------------------------------------------
function Sessions_exists($session)
{
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_sessions
           WHERE session_id = '$session'";

   $result = mysql_query($sql);

   if ($result) {
      if (mysql_num_rows($result) == 0) {
      	 mysql_free_result($result);
         return false;
      }
   } else {
      Sessions_error("Sessions_exists: problème pour accéder à la table des sessions");
      exit;
   }

   return true;
}

//-----------------------------------------------------------------------------------
// Check if a session associated with an AdresseIp adress is allowed.
//-----------------------------------------------------------------------------------
function Sessions_auth($session,$adresse_ip)
{
   if (Sessions_exists($session)) {
      $ip_BASE = Sessions_getAdresseIp($session);
      if ($ip_BASE == $adresse_ip) return true;
   }

   Sessions_writeLog("$session",$adresse_ip,__DUPE_FORCE_OUT__);
   return false;
}

//-----------------------------------------------------------------------------------
// Retreive the IP adress associated with a session.
//-----------------------------------------------------------------------------------
function Sessions_getAdresseIp($session)
{
   $adresse_ip = "";

   if (Sessions_exists($session)) {
      $sql = "SELECT *
              FROM ".$GLOBALS['prefix']."sys_sessions
              WHERE session_id = '$session'";

      $result = mysql_query($sql);

      if ($result) {
          $row = mysql_fetch_object($result);
          $adresse_ip = $row->adresse_ip;
      } else {
         Sessions_error("Problème lors de l'accès à la table des sessions");
      }

      mysql_free_result($result);
   }
   return $adresse_ip;
}

//-----------------------------------------------------------------------------------
// Retreive the user id associated with a session.
//-----------------------------------------------------------------------------------
function Sessions_getUtilisateur($session)
{
   $nom_utilisateur = "";
   if (Sessions_exists($session)) {
      $query = "SELECT U.nom_utilisateur nom_utilisateur
                FROM ".$GLOBALS['prefix']."sys_sessions S, ".$GLOBALS['prefix']."sys_utilisateurs U                
                WHERE S.session_id = '$session'
                AND U.id_utilisateur = S.id_utilisateur";

      $result = mysql_query($query);

      if ($result) {
          $row = mysql_fetch_object($result);
          $nom_utilisateur = $row->nom_utilisateur;
      } else {
         Sessions_error("Problème lors de l'accès à la table des sessions");
      }

      mysql_free_result($result);
   }
   return $nom_utilisateur;
}

//-----------------------------------------------------------------------------------
// Retreive the time associated to a session.
//-----------------------------------------------------------------------------------
function Sessions_getTime($session)
{
   $Time = "";

   if (Sessions_exists($session)) {
      $query = "SELECT *
                FROM ".$GLOBALS['prefix']."sys_sessions
                WHERE session_id = '$session'";

      $result = mysql_query($query);

      if ($result) {
          $row = mysql_fetch_object($result);
          $time = $row->time;
      } else {
         Sessions_error("Problème lors de l'accès à la table des sessions");
      }

      mysql_free_result($result);
   }

   return $time;

}

//-----------------------------------------------------------------------------------
// Retreive the session ID associated to an IP adress and to a user ID.
//-----------------------------------------------------------------------------------
function Sessions_getSession($id_utilisateur,$adresse_ip)
{
   $session = "NO_SESSION";

   $query = "SELECT *
             FROM ".$GLOBALS['prefix']."sys_sessions
             WHERE id_utilisateur = '$id_utilisateur'
             AND adresse_ip = '$adresse_ip'";

   $result = mysql_query($query);

   if ($result) {
       $row = mysql_fetch_object($result);
       if (mysql_num_rows($result) != 0 ) $session = $row->session_id;
   } else {
      Sessions_error("Problème lors de l'accès à la table des sessions");
   }

   mysql_free_result($result);

   return $session;
}

//-----------------------------------------------------------------------------------
// Retreive the number of session opened by a user ID.
//-----------------------------------------------------------------------------------
function Sessions_getNbSessions($id_utilisateur)
{
   $nb_sessions = 0;

   $query = "SELECT *
             FROM ".$GLOBALS['prefix']."sys_sessions
             WHERE id_utilisateur = '$id_utilisateur'";

   $result = mysql_query($query);

   if ($result) {
       $nb_sessions = mysql_num_rows($result);
       mysql_free_result($result);
   } else {
      Sessions_error("Problème lors de l'accès à la table des sessions");
      mysql_free_result($result);
      exit;
   }

   return $nb_sessions;
}

//----------------------------------------------------------------------------------
// Write to the user log depending on what the user is doing.
//----------------------------------------------------------------------------------
function Sessions_writeLog($utilisateur,$adresse_ip,$comment, $session = '')
{

     switch ($comment){
          case __NO_SESSION__:
               $comment = "No session was found for this IP";
          break;

          case __LOG_IN__:
               $comment = "Log-in";
          break;

          case __SESSION_TIMEOUT__:
               $comment = "Session time-out";
          break;

          case __LOG_OUT__:
               $comment = "Log-out";
          break;

          case __DUPE_FORCE_OUT__:
               $comment = "Dupe Force Out";
          break;

          case ____DATABASE_ERROR____:
               $comment = "Database error!";
          break;
     }

   $log_file=DIR."log/sessions.log";
   error_log( gmdate("d/m/Y H:i:s") . " $utilisateur, $adresse_ip, $session => $comment\r\n", 3, "$log_file");
   if (substr(sprintf('%o', fileperms($log_file)), -4) != '0775') chmod($log_file, 0775);
}

}
?>