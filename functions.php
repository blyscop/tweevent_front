<?php
// Fichier contenant toutes les fonctions utilisées par le front office
// Gestion des sessions (appeler à chaque page)
function check_session()
{
    // Utilisateur non-connecté

    if (!$_COOKIE['est_connecte'])
        header('Location: index.php'); // redirection page accueil
}

function disconnect()
{
    setcookie("est_connecte", "", time()-3600);
    setcookie("username", "", time()-3600);
    setcookie("utilisateur_connexion", "", time()-3600);
    setcookie("utilisateur_id", "", time()-3600);
    setcookie("utilisateur_type", "", time()-3600);
    header('Location: index.php'); // redirection page accueil
}

// Connexion de l'utilisateur - Création de la session si utilisateur valide
function connexion()

{
    $redirection_actualite = false;

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $pwd_crypte = md5($_POST['password']);
        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_SELECT&username=' . $_POST['username'] . '&password=' . $pwd_crypte;
        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        // Si l'API répond que l'utilisateur existe bien, on créer la session
        if ($content['confirmation']) {
            $redirection_actualite = true;

            // Création de la session en récupérant les infos comp. de la base
            setcookie('utilisateur_id', $content['utilisateur']['id_tweevent_user'] > 0 ? $content['utilisateur']['id_tweevent_user'] : 0, time() + 365 * 24 * 3600);
            setcookie('utilisateur_type', !empty($content['utilisateur']['type_tweevent_user']) ? $content['utilisateur']['type_tweevent_user'] : "", time() + 365 * 24 * 3600);
            setcookie('utilisateur_connexion', $content['utilisateur']['id_tweevent_user'] > 0 ? $content['utilisateur']['id_tweevent_user'] : 0, time() + 365 * 24 * 3600);
            setcookie('username', $content['utilisateur']['pseudo_tweevent_user'], time() + 365 * 24 * 3600);
            setcookie('est_connecte', true, time() + 365 * 24 * 3600);
        } else if ($content['email_non_valide'])
            header('Location: index.php#email_invalide'); // redirection page accueil (adresse email pas encore validée)
        else
            header('Location: index.php#login_error'); // redirection page accueil (login / mdp invalide)
    } else {
        header('Location: index.php#login_error'); // redirection page accueil (pas de login et mdp fourni)
    }
    if ($redirection_actualite) {
        header('Location: Actualite');
    }
}

function inscription()
{
    $redirection_accueil = $captcha = false;
    // Vérification du captcha
    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] != "")
        $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6LcDniETAAAAACZlKXLOp8YnnuLiAjrysL4TIy9J";
    $ip = $_SERVER['REMOTE_ADDR'];

    // Envoi sur serveur google et attente de la réponse
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $_POST['g-recaptcha-response'] . "&remoteip=" . $ip);
    $responseKeys = json_decode($response, true);


    // Professionels
    if ($_POST['choix_inscription'] == "pro" && !empty($captcha)) {
        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_ADD&type=pro';
        $url .= '&pseudo=' . $_POST['pseudo'];
        $url .= '&password=' . md5($_POST['password']);
        $url .= '&ville=' . $_POST['ville'];
        $url .= '&code_postal=' . $_POST['code_postal'];
        $url .= '&adresse=' . $_POST['adresse'];
        $url .= '&tel=' . $_POST['tel'];
        $url .= '&mob=' . $_POST['mob'];

        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        if ($content['confirmation'] && !$content['erreur_envoi_email'])
            $redirection_accueil = true;
        else if ($content['erreur_envoi_email'])
            header('Location: http://martinfrouin.fr/projets/tweevent/index.php#email_error'); // redirection page accueil (erreur lors de l'envoi de l'email)
        else
            header('Location: index.php#insc_error'); // redirection page accueil (nom d'utilisateur déjà utilisé)
    }

    // Particuliers
    if ($_POST['choix_inscription'] == "par" && !empty($captcha)) {
        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_ADD&type=par&pseudo=' . $_POST['pseudo'] . '&password=' . md5($_POST['password']);
        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        // Si l'API répond que la création s'est bien effectuée, on va rediriger vers la page d'accueil avec un message de confirmation invitant l'utilisateur à valider son email pour
        // pouvoir se connecter, sinon il ne pourra pas
        if ($content['confirmation'] && !$content['erreur_envoi_email'])
            $redirection_accueil = true;
        else if ($content['erreur_envoi_email'])
            header('Location: http://martinfrouin.fr/projets/tweevent/index.php#email_error'); // redirection page accueil (erreur lors de l'envoi de l'email)
        else if (!$content['confirmation'])
            header('Location: http://martinfrouin.fr/projets/tweevent/index.php#insc_error'); // redirection page accueil (nom d'utilisateur déjà utilisé)
    }

    if ($redirection_accueil)
        header('Location: http://martinfrouin.fr/projets/tweevent/index.php#insc_ok');
    if (empty($captcha))
        header('Location: index.php#erreur_captchaNonSaisi'); // redirection page accueil
}

// Appel de la fonction de connexion - on passe le post en paramètre de la requête
// Sécurité pour empêcher d'executer d'autre fct
if ($_GET['action'] == "disconnect" || $_GET['action'] == "connexion" || $_GET['action'] == "ajouter_publication" || $_GET['action'] == "inscription")
    call_user_func($_GET['action']);


?>
