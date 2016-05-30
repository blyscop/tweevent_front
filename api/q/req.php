<?

//==================================================================================
// Definir ici le nom du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script!
//==================================================================================
if ( !include('pre.php') ) exit;

//==================================================================================
// On trace le fichier actuel et les donn?es entrantes
//==================================================================================
/*=============*/
Lib_myLog("FILE: ", __FILE__);
/*=============*/
Lib_myLog("IN: ", $data_in);

//==================================================================================
// Inclusion librairies n?cessaires aux actions
//==================================================================================
include('../dilasys/biblio/tweevent_user.inc.php');
include('../dilasys/biblio/tweevent_img.inc.php');
include('../dilasys/biblio/tweevent_event.inc.php');
include('../dilasys/biblio/tweevent_post.inc.php');
include('../dilasys/biblio/tweevent_user_event.inc.php');

//==================================================================================
// Initialisation des variables globals qui seront utilis?es dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article', 'fiche');

//==================================================================================
// CREATE
//==================================================================================
function Utilisateur_ADD( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array();
   $return['confirmation'] = false;

   if ( empty($data_in['pseudo']) || empty($data_in['password']) )
      $return['message'] = "ERREUR : Le pseudo et/ou password est vide !";
   else {
      if ( !empty($data_in['pseudo']) && !empty($data_in['password']) ) {
         $args_tweevent_user['pseudo_tweevent_user'] = $data_in['pseudo'];
         $tweevent_user = Tweevent_users_chercher($args_tweevent_user);

         if ( empty($tweevent_user) ) {
            $utilisateur_add = new Tweevent_user();
            $utilisateur_add->pseudo_tweevent_user = $data_in['pseudo'];
            $utilisateur_add->password_tweevent_user = md5($data_in['password']);
            $utilisateur_add->ADD();

            if ( $utilisateur_add ) {
               $return['confirmation'] = true;
               $return['message'] = "Votre utilisateur a bien ete creer";
               $return['utilisateur'] = $utilisateur_add->getTab();
            }
         } else
            $return['message'] = "ERREUR : Le pseudo est deja utilise !";
      }
   }

   // permet d'éxecuter la requete sur le post client qui est sur un serveur différent (client en local - api en ligne)
   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);
}

function Image_ADD( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array(); // Tableau de retour
   $image = $_FILES['image']; // Récupère l'image donnée en AJAX
   $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); // extension de l'image uploadée

   $destination_dossier = "../uploads/"; // dossier de stination
   $destination_fichier = $destination_dossier . basename($image['name']); // Futur emplacement de l'image
   $destination_sql = "api/uploads/" . basename($image['name']);

   if ( file_exists($destination_fichier) )
      $return['msg'] = "Le fichier existe deja !";
   else if ( $image['size'] > 1000000 )
      $return['msg'] = "Le fichier est trop gros !";
   else if ( $extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" )
      $return['msg'] = "L'extension n'est pas autorisee ! jpg png jpeg gif seulement !";
   else {
      if ( move_uploaded_file($image['tmp_name'], $destination_fichier) ) {
         $return['msg'] = "Fichier disponible sur " . $destination_sql;

         $sql_image = new Tweevent_img();
         $sql_image->nom_tweevent_img = "une image";
         $sql_image->url_tweevent_img = $destination_sql;
         $sql_image->ADD();

         if ( $sql_image->id_tweevent_img != 0 )
            $return['id'] = $sql_image->id_tweevent_img;
      } else
         $return['msg'] = "Erreur lors de l'upload du fichier sur le serveur ! (droit ecriture ?) ";
   }

   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);
}

function Post_ADD( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array();
   $return['confirmation'] = false;
   if ( $data_in['id_utilisateur'] > 0 && !empty($data_in['message']) ) {
      $user_tweevent['id_tweevent_user'] = $data_in['id_utilisateur'];
      $test_user_tweevent = Tweevent_users_chercher($user_tweevent);

      if ( !empty($test_user_tweevent) ) {
         $post_add = new Tweevent_post();
         $post_add->id_user_tweevent_post = $data_in['id_utilisateur'];
         $post_add->message_tweevent_post = $data_in['message'];
         $post_add->ADD();

         $return['utilisateur'] = $test_user_tweevent;

         if ( $post_add )
            $return['confirmation'] = true;
         else
            $return['message'] = "Erreur lors de l'ajout du post !";
      } else
         $return['message'] = "Erreur l'utilisateur n'existe pas !";
   } else
      $return['message'] = "Les parametres id_utilisateur et message sont invalides !";

   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);
}

//==================================================================================
// READ
//==================================================================================
function Utilisateur_SELECT( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array();
   $return['confirmation'] = false;
   if ( !empty($data_in['username']) ) {
      $args_tweevent_user['pseudo_tweevent_user'] = $data_in['username'];
      $tweevent_user = Tweevent_users_chercher($args_tweevent_user);

      if ( !empty($tweevent_user) ) {
         if ( $tweevent_user['password_tweevent_user'] == md5($data_in['password']) ) {
            $return['confirmation'] = true;
            $return['message'] = "Utilisateur recupere !";
            $return['utilisateur'] = $tweevent_user;
         }
      } else
         $return['message'] = "Erreur ! L'utilisateur est introuvable.";
   } else
      $return['message'] = "Le pseudo et/ou mot de passe est vide !";

   // permet d'éxecuter la requete sur le post client qui est sur un serveur différent (client en local - api en ligne)
   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);

}

function Utilisateur_Preferences_SELECT($data_in = array())
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;
   
   $return = array();
   $return['confirmation'] = false;
   if(!empty($data_in['id_utilisateur'])) {
      // Récupération des préférences de l'utilsiateur passé en paramètre
      $args_preferences_utilisateur['id_tweevent_user'] = $data_in['id_utilisateur'];
      $liste_preferences_utilisateur = Tweevent_users_preference_chercher($args_preferences_utilisateur);

      if(!empty($liste_preferences_utilisateur)) {
         // Création de la liste de retour des préférences en liant les id_preference de la table user_preference vers la table preference
         $args_preferences['tab_ids_tweevent_preferences'] = Lib_getValCol($liste_preferences_utilisateur, 'id_preference');
         $liste_preferences = Tweevent_preferences_chercher($args_preferences);

         if(!empty($liste_preferences)) {
            $return['liste_preferences'] = array(); // Initialisation du tableau de retour
            foreach($liste_preferences_utilisateur as $id_preference_utilisateur => $preference_utilisateur) {
               // Lien avec l'autre table
               $preference = !empty($liste_preferences[$preference_utilisateur['id_preference']]) ? $liste_preferences[$preference_utilisateur['id_preference']] : array();
               $return['liste_preferences'][] = $preference;
            }
            $return['confirmation'] = true;
            $return['message'] = "Les preferences de l'utilisateur ont bien ete recuperees !";
         }
      }
      else
         $return['message'] = "L'utilisateur ne possede aucune preference !";
   }
   else
      $return['message'] = "ERREUR ! Il manque id_utilisateur a passé en paramètre!";
}

function Utilisateur_Posts_SELECT( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array();
   $return['confirmation'] = false;

   if ( $data_in['id_utilisateur'] > 0 ) {
      $args_tweevent_user['id_user_tweevent_post'] = $data_in['id_utilisateur'];
      $posts = Tweevent_posts_chercher($args_tweevent_user);


      if ( !empty($posts) ) {
         foreach ( $posts as $id_post => $post ) {
            $return['liste_actualites'][$id_post] = $post;
            $return['liste_actualites'][$id_post]['type'] = "actualite";
         }
         $return['actualites'] = $posts;
         $return['confirmation'] = true;
      } else
         $return['message'] = "Aucun post pour l'utilisateur ";
   } else
      $return['message'] = "Aucun id_utilisateur fourni";

   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);
}

function Utilisateur_Calendrier_SELECT_ALL( $data_in = array() )
{
   Lib_myLog("action: " . $data_in['action']);
   foreach ( $GLOBALS['tab_globals'] as $global ) global $$global;

   $return = array();

   if ( Lib_frToEn($data_in['start']) == "0000-00-00" || Lib_frToEn($data_in['end']) == '0000-00-00' && !$data_in['utilisateur_id'] )
      $return['message'] = "Il manque un paramètre dans la requête!";
   else {
      // Recherche d'évenements que l'utilisateur a sélectionné
      $args_evenements['id_tweevent_user'] = $data_in['utilisateur_id'];
      $liste_evenements_user = Tweevent_user_events_chercher($args_evenements);

      if ( empty($liste_evenements_user) )
         $return['message'] = "L'utilisateur a adherer a aucun evenement pour ce mois";

      if ( !empty($liste_evenements_user) ) {
         // Recherche d'evenements pour le mois actuel du calendrier
         $args_evenements['tri_pour_calendrier'] = true;
         $args_evenements['tab_ids_tweevent_events'] = Lib_getValCol($liste_evenements_user, 'id_tweevent_event');
         $args_evenements['date_debut_tweevent_event'] = Lib_enToFr($data_in['start']);
         $args_evenements['date_fin_tweevent_event'] = Lib_enToFr($data_in['end']);
         $liste_evenements = Tweevent_events_chercher($args_evenements);

         if ( !empty($liste_evenements) ) {
            // Construction du tableau final
            $i = 0;
            foreach ( $liste_evenements as $id_evenement => $evenement ) {
               $return[$i] = $evenement;
            }

         }
      }

   }

   header('Access-Control-Allow-Origin: *');
   echo json_encode($return);
}

//==================================================================================
// UPDATE
//==================================================================================

//==================================================================================
// DELETE
//==================================================================================


call_user_func($data_in['action'], $data_in);
/*=============*/
Lib_myLog("OUT: ", $data_out);
include('post.php');
return $data_out;
?>
