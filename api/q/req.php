<?

//==================================================================================
// Definir ici le nom du module qui sera verifie avec la table des autorisations
//==================================================================================
$module = "";

//==================================================================================
// Si pre.php renvoie 0, on ne doit pas poursuivre l'execution du script!
//==================================================================================
if (!include('pre.php')) exit;

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
include('../dilasys/biblio/tweevent_preference.inc.php');
include('../dilasys/biblio/tweevent_preference_categorie.inc.php');
include('../dilasys/biblio/tweevent_user_preference.inc.php');
include('../dilasys/biblio/tweevent_email_validation.inc.php');

//==================================================================================
// Initialisation des variables globals qui seront utilis?es dans les actions
//==================================================================================
$GLOBALS['tab_globals'] = array('lang', 'taille_ecran', 'MSG', 'secure', 'cle', 'config', 'data_out', 'data_srv', 'session', 'tab_session', 'message', 'article', 'fiche');

//==================================================================================
// CREATE
//==================================================================================
function Utilisateur_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if (empty($data_in['type']))
        $return['message'] = "ERREUR : Le type est vide !";
    else if (empty($data_in['pseudo']) || empty($data_in['password']))
        $return['message'] = "ERREUR : Le pseudo / password est vide !";
    else {

        $args_tweevent_user['pseudo_tweevent_user'] = $data_in['pseudo'];
        $tweevent_user = Tweevent_users_chercher($args_tweevent_user);

        if (empty($tweevent_user)) {
            if($data_in['type'] == "pro") {
                $utilisateur_add = new Tweevent_user();
                $utilisateur_add->pseudo_tweevent_user = $data_in['pseudo'];
                $utilisateur_add->email_tweevent_user = $data_in['pseudo'];
                $utilisateur_add->password_tweevent_user = $data_in['password'];
                $utilisateur_add->ville_tweevent_user = $data_in['ville'];
                $utilisateur_add->code_postal_tweevent_user = $data_in['code_postal'];
                $utilisateur_add->adresse_1_tweevent_user = $data_in['adresse'];
                $utilisateur_add->tel_tweevent_user = $data_in['tel'];
                $utilisateur_add->mob_tweevent_user = $data_in['mob'];
                $utilisateur_add->type_tweevent_user = "pro";
                $id_utilisateur = $utilisateur_add->ADD();
            }
            else {
                $utilisateur_add = new Tweevent_user();
                $utilisateur_add->pseudo_tweevent_user = $data_in['pseudo'];
                $utilisateur_add->email_tweevent_user = $data_in['pseudo'];
                $utilisateur_add->password_tweevent_user = $data_in['password'];
                $utilisateur_add->type_tweevent_user = "par";
                $id_utilisateur = $utilisateur_add->ADD();
            }

            if ($utilisateur_add) {
                // Création du lien de confirmation de mail à envoyer à l'utilisateur, basé sur le timestamp
                $validation = new Tweevent_email_validation();
                $validation->id_tweevent_user = $id_utilisateur;
                $validation->est_valide = 0;
                $validation->timestamp = time();
                $id_validation = $validation->ADD();

                $lien_validation = "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_Valider_Email&id_utilisateur=".$id_utilisateur."&k=".$validation->timestamp;

                // Préparation de l'envoi de l'email à l'utilisateur pour qu'il valide son compte (sécurité supp. du captcha)
                $subject = "Confirmation de votre compte sur Tweevent";
                $email = " Merci de votre inscription. Afin de confirmer votre compte, merci de vous rendre sur le lien suivant : <br/>
                           <a href='".$lien_validation."'>Valider mon compte</a> <br/>";
                $headers   = array();
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-type: text/plain; charset=iso-8859-1";
                $headers[] = "From: Tweevent <admin@tweevent.fr>";
                $headers[] = "Subject: {$subject}";
                $headers[] = "X-Mailer: PHP/".phpversion();
                $headers[] = "Content-type: text/html; charset=UTF-8";

                // todo reprendre l'affichage html du mail
                if(mail($utilisateur_add->email_tweevent_user, $subject, $email, implode("\r\n", $headers))) {
                    $return['confirmation'] = true;
                    $return['message'] = "Votre utilisateur a bien ete creer";
                    $return['utilisateur'] = $utilisateur_add->getTab();
                    $data_in['id_utilisateur'] = $utilisateur_add->id_tweevent_user;
                    Utilisateur_Preferences_INIT($data_in);
                }
                else {
                    $return['erreur_envoi_email'] = true;
                }

            }
        } else
            $return['message'] = "ERREUR : Le pseudo est deja utilise !";

    }

    // permet d'éxecuter la requete sur le post client qui est sur un serveur différent (client en local - api en ligne)
    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Image_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array(); // Tableau de retour
    $image = $_FILES['image']; // Récupère l'image donnée en AJAX
    $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); // extension de l'image uploadée

    $destination_dossier = "../uploads/"; // dossier de stination
    $destination_fichier = $destination_dossier . basename($image['name']); // Futur emplacement de l'image
    $destination_sql = "api/uploads/" . basename($image['name']);

    if (file_exists($destination_fichier))
        $return['msg'] = "Le fichier existe deja !";
    else if ($image['size'] > 1000000)
        $return['msg'] = "Le fichier est trop gros !";
    else if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif")
        $return['msg'] = "L'extension n'est pas autorisee ! jpg png jpeg gif seulement !";
    else {
        if (move_uploaded_file($image['tmp_name'], $destination_fichier)) {
            $return['msg'] = "Fichier disponible sur " . $destination_sql;

            $sql_image = new Tweevent_img();
            $sql_image->nom_tweevent_img = "une image";
            $sql_image->url_tweevent_img = $destination_sql;
            $sql_image->ADD();

            if ($sql_image->id_tweevent_img != 0)
                $return['id'] = $sql_image->id_tweevent_img;
        } else
            $return['msg'] = "Erreur lors de l'upload du fichier sur le serveur ! (droit ecriture ?) ";
    }

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Post_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;
    if ($data_in['id_utilisateur'] > 0 && !empty($data_in['message'])) {
        $user_tweevent['id_tweevent_user'] = $data_in['id_utilisateur'];
        $test_user_tweevent = Tweevent_users_chercher($user_tweevent);

        if (!empty($test_user_tweevent)) {
            $post_add = new Tweevent_post();
            $post_add->id_user_tweevent_post = $data_in['id_utilisateur'];
            $post_add->message_tweevent_post = $data_in['message'];
            $post_add->ADD();

            $return['utilisateur'] = $test_user_tweevent;

            if ($post_add)
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

// Permet d'initialiser les préférences de l'utilisateur, lors de la création
function Utilisateur_Preferences_INIT($data_in = array())
{
    if (!empty($data_in['id_utilisateur'])) {
        $args_preferences['id_tweevent_preference'] = '*';
        $liste_preferences = Tweevent_preferences_chercher($args_preferences);

        if (!empty($liste_preferences)) {
            foreach ($liste_preferences as $id_preference => $preference) {
                $args_user_preference['id_tweevent_preference'] = $id_preference;
                $args_user_preference['id_tweevent_user'] = $data_in['id_utilisateur'];
                $user_preference = Tweevent_user_preferences_chercher($args_user_preference);

                if (!empty($user_preference))
                    continue; // La préférence a déjà été créée ! on ne traite pas cet élément
                $preference_user_init = New Tweevent_user_preference();
                $preference_user_init->id_tweevent_user = $data_in['id_utilisateur'];
                $preference_user_init->id_tweevent_preference = $id_preference;
                $preference_user_init->etat = "supprime";
                $preference_user_init->ADD();
            }
        }
    }
}

//==================================================================================
// READ
//==================================================================================
function Utilisateur_SELECT($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;
    if (!empty($data_in['username'])) {
        $args_tweevent_user['pseudo_tweevent_user'] = $data_in['username'];
        $tweevent_user = Tweevent_users_chercher($args_tweevent_user);

        if (!empty($tweevent_user)) {
            if ($tweevent_user['password_tweevent_user'] == $data_in['password']) {

                // Vérification que l'utilisateur a bien validé son email auparavant
                $args_email_user_valid['id_tweevent_user'] = $tweevent_user['id_tweevent_user'];
                $email_user_valid = Tweevent_email_validations_chercher($args_email_user_valid);

                if(empty($email_user_valid) || (!empty($email_user_valid) && !$email_user_valid['est_valide'])) {
                    $return['email_non_valide'] = true;
                    $return['message'] = "Erreur ! L'utilisateur n'a pas validé son email";
                }
                else {
                    $return['confirmation'] = true;
                    $return['message'] = "Utilisateur recupere !";
                    $return['utilisateur'] = $tweevent_user;
                }
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
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;
    if (!empty($data_in['id_utilisateur'])) {
        // Récupération des préférences de l'utilsiateur passé en paramètre
        $args_preferences_utilisateur['id_tweevent_user'] = $data_in['id_utilisateur'];
        $liste_preferences_utilisateur = Tweevent_user_preferences_chercher($args_preferences_utilisateur);

        if (!empty($liste_preferences_utilisateur)) {
            // Création de la liste de retour des préférences en liant les id_preference de la table user_preference vers la table preference
            $args_preferences['tab_ids_tweevent_preferences'] = Lib_getValCol($liste_preferences_utilisateur, 'id_preference');
            $liste_preferences = Tweevent_preferences_chercher($args_preferences);

            if (!empty($liste_preferences)) {
                $return['liste_preferences'] = array(); // Initialisation du tableau de retour
                foreach ($liste_preferences_utilisateur as $id_preference_utilisateur => $preference_utilisateur) {
                    // Lien avec l'autre table
                    $preference = !empty($liste_preferences[$preference_utilisateur['id_preference']]) ? $liste_preferences[$preference_utilisateur['id_preference']] : array();
                    $return['liste_preferences'][] = $preference;
                }
                $return['confirmation'] = true;
                $return['message'] = "Les preferences de l'utilisateur ont bien ete recuperees !";
            }
        } else
            $return['message'] = "L'utilisateur ne possede aucune preference !";
    } else
        $return['message'] = "ERREUR ! Il manque id_utilisateur a passé en paramètre!";

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Posts_SELECT($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if ($data_in['id_utilisateur'] > 0) {
        $args_tweevent_user['id_user_tweevent_post'] = $data_in['id_utilisateur'];
        $posts = Tweevent_posts_chercher($args_tweevent_user);


        if (!empty($posts)) {
            foreach ($posts as $id_post => $post) {
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

function Utilisateur_Calendrier_SELECT_ALL($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();

    if (Lib_frToEn($data_in['start']) == "0000-00-00" || Lib_frToEn($data_in['end']) == '0000-00-00' && !$data_in['utilisateur_id'])
        $return['message'] = "Il manque un paramètre dans la requête!";
    else {
        // Recherche d'évenements que l'utilisateur a sélectionné
        $args_evenements['id_tweevent_user'] = $data_in['utilisateur_id'];
        $liste_evenements_user = Tweevent_user_events_chercher($args_evenements);

        if (empty($liste_evenements_user))
            $return['message'] = "L'utilisateur a adherer a aucun evenement pour ce mois";

        if (!empty($liste_evenements_user)) {
            // Recherche d'evenements pour le mois actuel du calendrier
            $args_evenements['tri_pour_calendrier'] = true;
            $args_evenements['tab_ids_tweevent_events'] = Lib_getValCol($liste_evenements_user, 'id_tweevent_event');
            $args_evenements['date_debut_tweevent_event'] = Lib_enToFr($data_in['start']);
            $args_evenements['date_fin_tweevent_event'] = Lib_enToFr($data_in['end']);
            $liste_evenements = Tweevent_events_chercher($args_evenements);

            if (!empty($liste_evenements)) {
                // Construction du tableau final
                $i = 0;
                foreach ($liste_evenements as $id_evenement => $evenement) {
                    $return[$i] = $evenement;
                }

            }
        }

    }

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Preferences_Categories_SELECT_ALL($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();

    $args_preferences_categories['id_tweevent_preference_categorie'] = '*';
    $liste_preferences_categories = Tweevent_preference_categories_chercher($args_preferences_categories);

    if (!empty($liste_preferences_categories))
        foreach ($liste_preferences_categories as $id_preference_categorie => $preference_categorie)
            $return[$preference_categorie['libelle_tweevent_preference_categorie']] = $preference_categorie['libelle_tweevent_preference_categorie'];


    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Preferences_SELECT_ALL($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();

    if ($data_in['id_utilisateur'] > 0) {
        $args_preferences_categories['id_tweevent_preference_categorie'] = '*';
        $liste_preferences_categories = Tweevent_preference_categories_chercher($args_preferences_categories);

        $args_preferences['id_tweevent_preference'] = '*';
        $args_preferences['tab_ids_tweevent_preferences_categories'] = Lib_getValCol($liste_preferences_categories, 'id_tweevent_preference_categorie');
        $liste_preferences = Tweevent_preferences_chercher($args_preferences);

        $args_preferences_utilisateur['id_tweevent_user'] = $data_in['id_utilisateur'];
        $liste_preferences_utilisateur_tmp = Tweevent_user_preferences_chercher($args_preferences_utilisateur);

        // On réindexe la liste des préférences utilisateur, par id de catégorie afin de faire le lien avec les 2 autres tables
        // on initialise le tableau et on teste qu'il en a déjà coché une ! sinon une erreur risque de survenir
        $liste_preferences_utilisateur = array();
        if (!empty($liste_preferences_utilisateur_tmp)) {
            foreach ($liste_preferences_utilisateur_tmp as $id_preference_utilisateur => $preference_utilisateur) {
                $id_categorie = $liste_preferences[$preference_utilisateur['id_tweevent_preference']]['id_tweevent_categorie'];
                $categorie_actuelle = $liste_preferences_categories[$id_categorie]['libelle_tweevent_preference_categorie'];
                $liste_preferences_utilisateur[$categorie_actuelle][$preference_utilisateur['id_tweevent_preference']] = $preference_utilisateur['etat'] != "actif" ? 0 : 1;
            }
        }
        // Même si l'utilisateur ne possède pas de préférences, il faut construire la totalité de la liste des préférences pour que ce soit dynamique !
        foreach ($liste_preferences as $id_preference => $preference) {
            // pour chaque préférence, on récupère d'abord la catégorie associée qui sera l'index principal, afin de boucler par catégorie sur l'affichage
            $categorie_actuelle = $liste_preferences_categories[$preference['id_tweevent_categorie']]['libelle_tweevent_preference_categorie'];
            $possede_preference = false; // initialisation du booléen
            // on teste si l'utilisateur à déjà coché une préférence, afin de la retourner dans l'affichage pour les checkbox
            if ($liste_preferences_utilisateur[$categorie_actuelle][$id_preference])
                $possede_preference = true;
            $return[$categorie_actuelle][$preference['libelle_tweevent_preference']] = $possede_preference;
        }
    } else
        $return['erreur'] = "Aucun id_utilisteur fourni !";

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);


}

function Utilisateur_Fil_Actualite_SELECT($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    // todo

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

//==================================================================================
// UPDATE
//==================================================================================
function Utilisateur_Preferences_UPD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    $return['print'] = $return['print2'] = $return['print3'] = "";
    if (!empty($data_in['id_utilisateur']) && !empty($data_in['preferences'])) {
        // pizza_0,kebab_1,hamburger_0, etc..
        $tmp_categories = explode("|", $data_in['preferences']);
        print_r($tmp_categories);
        foreach ($tmp_categories as $id => $categorie) {
            // pizza_1
            $preference_tmp = explode("_", $categorie);
            $droit_preference = $preference_tmp[0]; // 1
            $nom_preference = $preference_tmp[1]; // pizza

            $preference_actuelle_a_upd = Tweevent_preference_recuperer('', $nom_preference);
            $args_user_preferences['id_utilisateur'] = $data_in['id_utilisateur'];
            $args_user_preferences['id_preference'] = $preference_actuelle_a_upd->id_tweevent_preference;
            $user_preference = Tweevent_user_preference_recuperer('', $args_user_preferences);
            $return['print'] .= $args_user_preferences['id_preference'] . " ";
            $return['print2'] .= $user_preference->etat . " ";
            if ($droit_preference == '1')
                $user_preference->etat = "actif";
            else
                $user_preference->etat = "supprime";
            $user_preference->UPD();
            $return['print3'] .= $user_preference->etat . " ";
        }
        $return['confirmation'] = true;
    }

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Valider_Email($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    // Validation provenant de l'email
    if(!empty($data_in['id_utilisateur']) && !empty($data_in['k'])) {
        $args_email_validation['id_tweevent_user'] = $data_in['id_utilisateur'];
        $args_email_validation['timestamp'] = $data_in['k'];
        $email_validation = Tweevent_email_validations_chercher($args_email_validation);

        Lib_myLog("email: ",$email_validation);
        if(!empty($email_validation)) {
            // Clé valide => on active le compte
            $validation = Tweevent_email_validation_recuperer($email_validation['id_tweevent_email_validation']);
            $validation->est_valide = 1;
            $validation->UPD();
            header('Location: ../../index.html#conf_validation');
        }
        else {
            // Clé / User  invalide
            header('Location: ../../index.html#erreur_validation');
        }

    }
}

//==================================================================================
// DELETE
//==================================================================================


call_user_func($data_in['action'], $data_in);
/*=============*/
Lib_myLog("OUT: ", $data_out);
include('post.php');
return $data_out;
?>
