<?php
// Fichier contenant toutes les fonctions utilisées par le front office

// Gestion des sessions (appeler à chaque page)
function check_session()
{
    session_start();
    // Utilisateur non-connecté
    if(!$_SESSION['est_connecte'])
        header('Location: index.html'); // redirection page accueil
}

// Connexion de l'utilisateur - Création de la session si utilisateur valide
function connexion()

{
    $redirection_actualite = false;

    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $pwd_crypte=md5($_POST['password']);
        $url = 'http://martinfrouin.fr/projets/tweevent/api/q/req.php?action=Utilisateur_SELECT&username='.$_POST['username'].'&password='.$pwd_crypte;
        $obj = file_get_contents($url);
        $content = json_decode($obj, true);

        // Si l'API répond que l'utilisateur existe bien, on créer la session
        if($content['confirmation']) {
            $redirection_actualite = true;

            // Création de la session en récupérant les infos comp. de la base
            session_start();
            $_SESSION['utilisateur_id'] = $content['utilisateur']['id_tweevent_user'] > 0 ? $content['utilisateur']['id_tweevent_user'] : 0;
            $_SESSION['utilisateur_type'] = !empty($content['utilisateur']['type_tweevent_user']) ? $content['utilisateur']['type_tweevent_user'] : "";
            $_SESSION['utilisateur_connexion'] = time();
            $_SESSION['est_connecte'] = true;
            $_SESSION['username']=$_POST['username'];


        }
    }
    else
       header('Location: index.html#login_error'); // redirection page accueil (pas de login et mdp fourni)
    if($redirection_actualite) {
        //echo json_encode(true);
        header('Location: Actualite.php');
    }
    else
        header('Location: index.html#login_error'); // redirection page accueil (login/mdp invalide)
}

// Appel de la fonction de connexion - on passe le post en paramètre de la requête
if($_GET['action'] == "connexion")
    call_user_func("connexion");


?>