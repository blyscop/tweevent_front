<?php
// Fichier contenant toutes les fonctions utilisées par le front office

// Gestion des sessions (appeler à chaque page)
function check_session()
{
    // Utilisateur non-connecté
    if(!$_COOKIE['est_connecte'])
        header('Location: http://martinfrouin.fr/projets/tweevent/index.html'); // redirection page accueil
}

// Connexion de l'utilisateur - Création de la session si utilisateur valide
function connexion()
{

    $redirection_actualite = false;

    if(!empty($_POST['username']) && !empty($_POST['password'])) {

        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_SELECT&username='.$_POST['username'].'&password='.md5($_POST['password']);
        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        // Si l'API répond que l'utilisateur existe bien, on créer la session
        if($content['confirmation']) {
            $redirection_actualite = true;

            // Création de la session en récupérant les infos comp. de la base
            setcookie('utilisateur_id', $content['utilisateur']['id_tweevent_user'] > 0 ? $content['utilisateur']['id_tweevent_user'] : 0, time() + 365*24*3600);
            setcookie('utilisateur_type', !empty($content['utilisateur']['type_tweevent_user']) ? $content['utilisateur']['type_tweevent_user'] : "", time() + 365*24*3600);
            setcookie('utilisateur_connexion', $content['utilisateur']['id_tweevent_user'] > 0 ? $content['utilisateur']['id_tweevent_user'] : 0, time() + 365*24*3600);
            setcookie('username', $content['utilisateur']['pseudo_tweevent_user'], time() + 365*24*3600);
            setcookie('est_connecte', true, time() + 365*24*3600);
        }
    }
    else
       header('Location: http://martinfrouin.fr/projets/tweevent/index.html#login_error'); // redirection page accueil (pas de login et mdp fourni)
    if($redirection_actualite) {
        header('Location: http://martinfrouin.fr/projets/tweevent/Actualite.php'); // redirection page accueil (pas de login et mdp fourni)
    }
    else
        header('Location: http://martinfrouin.fr/projets/tweevent/index.html#login_error'); // redirection page accueil (login/mdp invalide)
}

function inscription()
{
    $redirection_accueil = false;

    if($_POST['choix_inscription'] == "pro")
    {
        $url = "http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_ADD";
        $url .= "&pseudo=".$_POST['pseudo'];

        if($redirection_accueil)
            header('Location: http://martinfrouin.fr/projets/tweevent/index.html#insc_pro_ok');
    }
    if($_POST['choix_inscription'] == "par")
    {
        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_ADD&pseudo='.$_POST['pseudo'].'&password='.md5($_POST['password']);
        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        // Si l'API répond que la création s'est bien effectuée, on va rediriger vers la page d'accueil avec un message de confirmation invitant l'utilisateur à valider son email pour
        // pouvoir se connecter, sinon il ne pourra pas
        if($content['confirmation'])
            $redirection_accueil = true;
        else
            header('Location: http://martinfrouin.fr/projets/tweevent/index.html#insc_error'); // redirection page accueil (nom d'utilisateur déjà utilisé)
    }

    if($redirection_accueil)
        header('Location: http://martinfrouin.fr/projets/tweevent/index.html#insc_ok');
}

// Appel de la fonction de connexion - on passe le post en paramètre de la requête
// Sécurité pour empêcher d'executer d'autre fct
if($_GET['action'] == "connexion" || $_GET['action'] == "ajouter_publication" || $_GET['action'] == "inscription")
    call_user_func($_GET['action']);

?>