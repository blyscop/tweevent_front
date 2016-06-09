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
            if ($data_in['type'] == "pro") {
                $utilisateur_add = new Tweevent_user();
                $utilisateur_add->pseudo_tweevent_user = $data_in['mail'];
                $utilisateur_add->email_tweevent_user = $data_in['mail'];
                $utilisateur_add->nom_tweevent_user = $data_in['nom'];
                $utilisateur_add->password_tweevent_user = $data_in['password'];
                $utilisateur_add->ville_tweevent_user = $data_in['ville'];
                $utilisateur_add->code_postal_tweevent_user = $data_in['code_postal'];
                $utilisateur_add->adresse_1_tweevent_user = $data_in['adresse'];
                $utilisateur_add->tel_tweevent_user = $data_in['tel'];
                $utilisateur_add->mob_tweevent_user = $data_in['mob'];
                $utilisateur_add->siret = $data_in['siret'];
                $utilisateur_add->type_tweevent_user = "pro";
                $id_utilisateur = $utilisateur_add->ADD();

                Lib_myLog("Ajout d'un pro... ", $utilisateur_add->getTab());
            } else {
                $utilisateur_add = new Tweevent_user();
                $utilisateur_add->pseudo_tweevent_user = $data_in['email'];
                $utilisateur_add->email_tweevent_user = $data_in['email'];
                $utilisateur_add->nom_tweevent_user = $data_in['pseudo'];
                $utilisateur_add->password_tweevent_user = $data_in['password'];
                $utilisateur_add->type_tweevent_user = "par";
                $id_utilisateur = $utilisateur_add->ADD();
                Lib_myLog("Ajout d'un par... ", $utilisateur_add->getTab());
            }

            if ($utilisateur_add) {
                // Création du lien de confirmation de mail à envoyer à l'utilisateur, basé sur le timestamp
                $validation = new Tweevent_email_validation();
                $validation->id_tweevent_user = $id_utilisateur;
                $validation->est_valide = 0;
                $validation->timestamp = time();
                $id_validation = $validation->ADD();

                $lien_validation = "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_Valider_Email&id_utilisateur=" . $id_utilisateur . "&k=" . $validation->timestamp;

                // Préparation de l'envoi de l'email à l'utilisateur pour qu'il valide son compte (sécurité supp. du captcha)
                $subject = "Confirmation de votre compte sur Tweevent";
                $email = " Merci de votre inscription. Afin de confirmer votre compte, merci de vous rendre sur le lien suivant : <br/>
                           <a href='" . $lien_validation . "'>Valider mon compte</a> <br/>";
                $headers = array();
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-type: text/plain; charset=iso-8859-1";
                $headers[] = "From: Tweevent <admin@tweevent.fr>";
                $headers[] = "Subject: {$subject}";
                $headers[] = "X-Mailer: PHP/" . phpversion();
                $headers[] = "Content-type: text/html; charset=UTF-8";

                if (mail($utilisateur_add->email_tweevent_user, $subject, $email, implode("\r\n", $headers))) {
                    $return['confirmation'] = true;
                    $return['message'] = "Votre utilisateur a bien ete creer";
                    $return['utilisateur'] = $utilisateur_add->getTab();
                    $data_in['id_utilisateur'] = $id_utilisateur;
                    Lib_myLog("Initialisation des préférénces ...");
                    Utilisateur_Preferences_INIT($data_in);
                } else {
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

function Post_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if ($data_in['id_utilisateur'] > 0) {
        $user_tweevent['id_tweevent_user'] = $data_in['id_utilisateur'];
        $test_user_tweevent = Tweevent_users_chercher($user_tweevent);

        if (!empty($test_user_tweevent)) {
            $post_add = new Tweevent_post();
            $post_add->id_user_tweevent_post = $data_in['id_utilisateur'];
            $post_add->message_tweevent_post = !empty($data_in['message']) ? $data_in['message'] : '';

            $id_image = 0;

            if (!empty($_FILES['file']['name'])) { // Fichier entrant
                $image = $_FILES['file']; // Récupère l'image donnée en AJAX
                $nom_image_serveur = time() . "_" . basename($image['name']); // Nom unique d'image
                $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); // extension de l'image uploadée

                $destination_dossier = "../uploads/"; // dossier de stination
                $destination_fichier = $destination_dossier . $nom_image_serveur; // Futur emplacement de l'image
                $destination_sql = "api/uploads/" . $nom_image_serveur;

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
                        $sql_image->nom_tweevent_img = $image['name'];
                        $sql_image->url_tweevent_img = $destination_sql;
                        $sql_image->id_user_tweevent_img = $data_in['id_utilisateur'];
                        $id_image = $sql_image->ADD();
                    } else
                        $return['msg'] = "Erreur lors de l'upload du fichier sur le serveur ! (droit ecriture ?) ";
                }
            }

            $post_add->ids_imgs_tweevent_post = $sql_image->id_tweevent_img > 0 ? $sql_image->id_tweevent_img : $id_image;

            // Si l'ajout de post avec/sans image s'est bien déroulé, on retoure vrai pour l'affichage. Sinon, le front affichera $return['msg'] en cas d'erreur
            if ($post_add && ((!empty($_FILES['file']['name']) && $id_image > 0) || empty($_FILES['file']['name']))) {
                $post_add->ADD();
                $return['confirmation'] = true;
            } else
                $return['message'] = "Erreur lors de l'ajout du post !";
        }
    } else
        $return['message'] = "Les parametres id_utilisateur et message sont invalides !";

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

// Ajout d'évènement pour un pro
function Utilisateur_Evenement_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if ($data_in['id_utilisateur'] > 0) {
        $user_tweevent['id_tweevent_user'] = $data_in['id_utilisateur'];
        $test_user_tweevent = Tweevent_users_chercher($user_tweevent);

        if (!empty($test_user_tweevent)) {
            $event = new Tweevent_event();
            $event->nom_tweevent_event = $data_in['eventName'] . " (" . $data_in['eventHeure'] . ")";
            $event->date_debut_tweevent_event = $data_in['eventDateDebut'];
            $event->date_fin_tweevent_event = $data_in['eventDateFin'];
            $event->lieu_tweevent_event = $data_in['eventLieu'];
            $event->ids_posts_tweevent_event = $data_in['preferences'];
            $id_event = $event->ADD();

            Lib_myLog("Date de debut : " . $event->date_debut_tweevent_event . " et date de fin : " . $event->date_fin_tweevent_event);
            // On ajoute l'évènement dans le calendrier de l'utilsateur qui a créer l'event !
            $data_in['id_event'] = $id_event;
            if (Utilisateur_Calendrier_Event_ADD($data_in))
                $return['confirmation'] = true;
            else
                $return['msg'] = "Erreur lors de l'ajout de l'event !";
        } else {
            $return['msg'] = "Erreur lors de la récupération de l'utilisateur !";
        }
    } else {
        $return['msg'] = "Aucun id_utilisateur fourni !";
    }

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Calendrier_Event_ADD($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if ($data_in['id_utilisateur'] > 0 && $data_in['id_event'] > 0) {
        $user_event = new Tweevent_user_event();
        $user_event->id_tweevent_user = $data_in['id_utilisateur'];
        $user_event->id_tweevent_event = $data_in['id_event'];
        $id_tweevent_user = $user_event->ADD();

        if ($id_tweevent_user > 0)
            $return['confirmation'] = true;

    } else
        $return['msg'] = "Il manque des informations dans la requête : id_utilisateur et id_event";

    return $return['confirmation'];
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

                $preference_user_init = New Tweevent_user_preference();
                $preference_user_init->id_tweevent_user = $data_in['id_utilisateur'];
                $preference_user_init->id_tweevent_preference = $id_preference;
                $preference_user_init->etat = "supprime";
                $preference_user_init->ADD();

                Lib_myLog("PReferences creer : ", $preference_user_init->getTab());
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

                Lib_myLog("Validation de l'email recuperee avec l'id_user " . $args_email_user_valid['id_tweevent_user'] . " : " . $email_user_valid['est_valide']);

                if ($email_user_valid['est_valide'] == 1 || $email_user_valid['est_valide'] == '1' || $email_user_valid['est_valide']) {
                    $return['confirmation'] = true;
                    $return['message'] = "Utilisateur recupere !";
                    $return['utilisateur'] = $tweevent_user;
                } else {
                    $return['email_non_valide'] = true;
                    $return['message'] = "Erreur ! L'utilisateur n'a pas validé son email";
                }
            }
        } else
            $return['message'] = "Erreur ! L'utilisateur est introuvable.";
    } else
        $return['message'] = "Le pseudo et/ou mot de passe est vide !";

    Lib_myLog("return : ", $return);
    Lib_myLog("user : ", $tweevent_user);
    Lib_myLog("valid : ", $email_user_valid);
    // permet d'éxecuter la requete sur le post client qui est sur un serveur différent (client en local - api en ligne)
    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);

}

function Utilisateur_GET($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;
    if (!empty($data_in['id_utilisateur'])) {
        $args_tweevent_user['id_tweevent_user'] = $data_in['id_utilisateur'];
        $tweevent_user = Tweevent_users_chercher($args_tweevent_user);

        if (!empty($tweevent_user)) {
            $return['confirmation'] = true;
            $return['message'] = "Utilisateur recupere !";
            $return['utilisateur'] = $tweevent_user;
        } else {
            $return['email_non_valide'] = true;
            $return['message'] = "Erreur ! L'utilisateur n'a pas validé son email";
        }

    } else
        $return['message'] = "Le pseudo et/ou mot de passe est vide !";

    Lib_myLog("alex : ", $return);
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
            $args_preferences['tab_ids_tweevent_preferences'] = Lib_getValCol($liste_preferences_utilisateur, 'id_tweevent_preference');
            $liste_preferences = Tweevent_preferences_chercher($args_preferences);

            if (!empty($liste_preferences)) {
                $return['liste_preferences'] = array(); // Initialisation du tableau de retour
                foreach ($liste_preferences_utilisateur as $id_preference_utilisateur => $preference_utilisateur) {
                    // Lien avec l'autre table
                    $preference = !empty($liste_preferences[$preference_utilisateur['id_tweevent_preference']]) ? $liste_preferences[$preference_utilisateur['id_tweevent_preference']] : array();
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
        // Récupération de l'utilisateur
        $utilisateur = Tweevent_user_recuperer($data_in['id_utilisateur']);
        $return['utilisateur'] = $utilisateur->getTab();
        $args_tweevent_user['id_user_tweevent_post'] = $data_in['id_utilisateur'];
        $posts = Tweevent_posts_chercher($args_tweevent_user);


        if (!empty($posts)) {
            foreach ($posts as $id_post => $post) {
                $return['liste_actualites'][$id_post] = $post;
                $return['liste_actualites'][$id_post]['type'] = "actualite";
                $return['liste_actualites'][$id_post]['date_creation'] = date("d-m-Y H:i", $post['date_add']);

                $return['liste_actualites'][$id_post]['image'] = "";
                if ($post['ids_imgs_tweevent_post'] > 0) {
                    // Récupération de l'image du post
                    $image_post = Tweevent_img_recuperer($post['ids_imgs_tweevent_post']);
                    Lib_myLog("IMAGE : ", $image_post->getTab());
                    $return['liste_actualites'][$id_post]['image'] = $image_post->url_tweevent_img;
                    $return['liste_actualites'][$id_post]['nb_plus'] = 10;
                    $return['liste_actualites'][$id_post]['nb_moins'] = 1;
                    $return['liste_actualites'][$id_post]['possede_image'] = 1;
                }
            }

            // Recherche d'évènements auquel l'utilisateur peut adhérer
            $args_tweevent_user_preferences['id_tweevent_user'] = $data_in['id_utilisateur'];
            $args_tweevent_user_preferences['etat'] = 'actif';
            $liste_preferences_user = Tweevent_user_preferences_chercher($args_tweevent_user_preferences);

            if (!empty($liste_preferences_user)) {
                // Création de la liste de retour des préférences en liant les id_preference de la table user_preference vers la table preference
                $args_preferences['tab_ids_tweevent_preferences'] = Lib_getValCol($liste_preferences_user, 'id_tweevent_preference');
                $liste_preferences = Tweevent_preferences_chercher($args_preferences);

                $liste_pref = array();
                if (!empty($liste_preferences)) {
                    $return['liste_preferences'] = array(); // Initialisation du tableau de retour
                    foreach ($liste_preferences_user as $id_preference_utilisateur => $preference_utilisateur) {
                        // Lien avec l'autre table
                        $preference = !empty($liste_preferences[$preference_utilisateur['id_tweevent_preference']]) ? $liste_preferences[$preference_utilisateur['id_tweevent_preference']] : array();
                        $preference_libelle = str_replace(",", "", $preference['libelle_tweevent_preference']);
                        $liste_pref['liste_preferences'][$preference_libelle] = $preference_libelle;
                    }
                }

                if (!empty($liste_pref)) {
                    $args_event['id_tweevent_event'] = '*';
                    $liste_events = Tweevent_events_chercher($args_event);

                    if (!empty($liste_events)) {
                        foreach ($liste_events as $id_tweevent_event => $evenement) {
                            $possede_preference = false;
                            $tab_preferences = explode(',', $evenement['ids_posts_tweevent_event']);
                            $liste_preferences_actuelle = array();
                            foreach ($tab_preferences as $index => $tmp_pref)
                                $liste_preferences_actuelle[str_replace(",", "", $tmp_pref)] = str_replace(",", "", $tmp_pref);
                            Lib_myLog("pref: ", $liste_preferences_actuelle);
                            foreach ($liste_preferences_actuelle as $index_pref => $ref) {
                                if (isset($liste_preferences_actuelle[$index_pref])) {
                                    $possede_preference = true;
                                }
                            }
                            if ($possede_preference) {
                                $return['liste_evenements'][$id_tweevent_event] = $evenement;
                                $return['liste_evenements'][$id_tweevent_event]['type'] = "evenement";
                                $return['liste_evenements'][$id_tweevent_event]['date_creation'] = date("d-m-Y H:i", $evenement['date_add']);
                            }
                        }
                    }
                }
            }

            Lib_myLog("Liste des préférences : ", $liste_pref);


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
            $args_evenements['date_debut_tweevent_event'] = $data_in['start'];
            $args_evenements['date_fin_tweevent_event'] = $data_in['end'];
            $liste_evenements = Tweevent_events_chercher($args_evenements);

            if (!empty($liste_evenements)) {
                // Construction du tableau final
                $i = 0;
                foreach ($liste_evenements as $id_evenement => $evenement) {
                    $return[$i] = $evenement;
                    $i++;
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
    if (!empty($data_in['id_utilisateur']) && !empty($data_in['k'])) {
        $args_email_validation['id_tweevent_user'] = $data_in['id_utilisateur'];
        $args_email_validation['timestamp'] = $data_in['k'];
        $email_validation = Tweevent_email_validations_chercher($args_email_validation);

        Lib_myLog("email: ", $email_validation);
        if (!empty($email_validation)) {
            // Clé valide => on active le compte
            $validation = Tweevent_email_validation_recuperer($email_validation['id_tweevent_email_validation']);
            $validation->est_valide = 1;
            $validation->UPD();
            header('Location: ../../index.php#conf_validation');
        } else {
            // Clé / User  invalide
            header('Location: ../../index.php#erreur_validation');
        }

    }
}

function Utilisateur_Rein_Mdp($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    // Recherche de l'utilisateur
    if (!empty($data_in['email'])) {
        $args_mail_reinit['id_tweevent_user'] = '*';
        $args_mail_reinit['email_tweevent_user'] = $data_in['email'];
        $mail_reinit = Tweevent_users_chercher($args_mail_reinit);

        if (!empty($mail_reinit)) {
            // Réinitialisation du mdp
            $time = time();
            $time_crypte = md5($time);
            $user_reinit = Tweevent_user_recuperer($mail_reinit['id_tweevent_user']);
            $user_reinit->password_tweevent_user = $time_crypte; // On met le timestamp en attendant que l'utilisateur change son mdp
            $user_reinit->UPD();

            $lien_validation = "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Changement_Mdp&id=utilisateur=" . $user_reinit->id_tweevent_user;

            $subject = "Changement de votre mot de passe sur Tweevent";
            $email = " Vous pouvez désormais vous connecter avec le mot de passe ci-dessous (pensez à le changer dans l'interface) : <br/>
                           " . $time . " <br/> Attention à ne pas prendre en compte l'espace à la fin du mot de passe.";
            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/plain; charset=iso-8859-1";
            $headers[] = "From: Tweevent <admin@tweevent.fr>";
            $headers[] = "Subject: {$subject}";
            $headers[] = "X-Mailer: PHP/" . phpversion();
            $headers[] = "Content-type: text/html; charset=UTF-8";

            if (mail($data_in['email'], $subject, $email, implode("\r\n", $headers))) {
                $return['confirmation'] = true;
                $return['message'] = "Email envoyé";
            } else {
                $return['message'] = "Une erreur est survenue lors de l'envoi de l'email !";
            }
        } else {
            $return['message'] = "L'email fourni ne correspond à aucun compte utilisateur";
        }

    } else {
        $return['message'] = "Aucun email passé en paramètre !";
    }

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Changer_Mdp($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    $return['confirmation'] = false;

    if (!empty($data_in['id_utilisateur'])) {
        $user_mdp_upd = Tweevent_user_recuperer($data_in['id_utilisateur']);
        if ($user_mdp_upd->password_tweevent_user == md5($data_in['old_password'])) {
            // L'utilisateur a bien saisi son ancien mdp : on va le mettre à jour avec le nouveau
            $user_mdp_upd->password_tweevent_user = md5($data_in['new_password']);
            $user_mdp_upd->UPD();

            $return['confirmation'] = true;
            $return['message'] = "Le mot de passe a bien été mis à jour !";
        } // Ancien mot de passe saisi invalide
        else {
            $return['message'] = "L'ancien mot de passe saisi est invalide !";
        }
    } // id_utilisateur passé en paramètre invalide
    else
        $return['message'] = "L'identifiant d'utilisateur est invalide ";

    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);
}

function Utilisateur_Modifier_Infos($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    if (!empty($data_in['id_utilisateur'])) {
        $user_upd = Tweevent_user_recuperer($data_in['id_utilisateur']);

        if ($data_in['type_utilisateur'] == "pro") {
            $user_upd->pseudo_tweevent_user = $data_in['pseudo'] != $user_upd->pseudo_tweevent_user ? $data_in['pseudo'] : $user_upd->pseudo_tweevent_user;
        } else {

        }

        $user_upd->UPD();
        $return['confirmation'] = true;
    }
    $return = array();
    $return['confirmation'] = false;


    header('Access-Control-Allow-Origin: *');
    echo json_encode($return);


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
