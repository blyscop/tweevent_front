<?
function GET_ALL_Utilisateurs($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $args_utilisateurs['id_tweevent_user'] = '*';
    $args_utilisateurs['etat'] = '*';
    $liste_utilisateurs = Tweevent_users_chercher($args_utilisateurs);

    echo json_encode($liste_utilisateurs);
}

function GET_Utilisateur($data_in = array())
{
    Lib_myLog("action : " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    // aucun id_utilisateur fourni => on affiche un message d'erreur
    if (empty($data_in['id_utilisateur']))
        $return['msg'] = "ERREUR : id_utilisateur fourni fourni est vide";
    $args_utilisateurs['id_tweevent_user'] = $data_in['id_utilisateur'];
    $utilisateur = Tweevent_users_chercher($args_utilisateurs);

    if (!empty($utilisateur))
        $return = $utilisateur;
    else
        $return['msg'] = "ERREUR : l'id_utilisateur fourni ne correspond a aucun utilisateur";

    echo json_encode($return);
}

function GET_Image($data_in = array())
{
    Lib_myLog("action : " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array();
    // aucun id_utilisateur fourni => on affiche un message d'erreur
    if (empty($data_in['id_image']))
        $return['msg'] = "ERREUR : id_image fourni fourni est vide";
    $args_image['id_tweevent_img'] = $data_in['id_image'];
    $image = Tweevent_imgs_chercher($args_image);

    if (!empty($image))
        $return = $image;
    else
        $return['msg'] = "ERREUR : l'id_image fourni ne correspond a aucune image";

    echo json_encode($return);
}

?>