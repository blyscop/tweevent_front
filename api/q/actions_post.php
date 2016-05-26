<?

function POST_Utilisateur_Image($data_in = array())
{
    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    $return = array(); // Tableau de retour
    $image = $_FILES['image']; // Récupère l'image donnée en AJAX
    $extension = strtolower(pathinfo($image['name'],PATHINFO_EXTENSION)); // extension de l'image uploadée

    $destination_dossier = "../uploads/"; // dossier de stination
    $destination_fichier = $destination_dossier.basename($image['name']); // Futur emplacement de l'image
    $destination_sql = "api/uploads/".basename($image['name']);

    if(file_exists($destination_fichier))
        $return['msg'] = "Le fichier existe deja !";
    else if($image['size'] > 1000000)
        $return['msg'] = "Le fichier est trop gros !";
    else if($extension!= "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" )
        $return['msg'] = "L'extension n'est pas autorisee ! jpg png jpeg gif seulement !";
    else {
        if(move_uploaded_file($image['tmp_name'], $destination_fichier)) {
            $return['msg'] = "Fichier disponible sur " . $destination_sql;

            $sql_image = new Tweevent_img();
            $sql_image->nom_tweevent_img = "une image";
            $sql_image->url_tweevent_img = $destination_sql;
            $sql_image->ADD();

            if($sql_image->id_tweevent_img != 0)
                $return['id'] = $sql_image->id_tweevent_img;
        }
        else
            $return['msg'] = "Erreur lors de l'upload du fichier sur le serveur ! (droit ecriture ?) ";
    }

    echo json_encode($return);
}

function PUT_Utilisateur($data_in = array())
{
    if ($data_in['chk'] != 'enregistrer') exit; // controle pour vérifier que l'action vient d'un formulaire POST

    Lib_myLog("action: " . $data_in['action']);
    foreach ($GLOBALS['tab_globals'] as $global) global $$global;

    // Récupération pseudo / mdp en GET
    $pseudo = !empty($data_in['pseudo']) ? $data_in['pseudo'] : "";
    $mdp = !empty($data_in['password']) ? $data_in['password'] : "";

    // Test chaine non vide
    if (empty($pseudo) || empty($mdp)) exit;

    // Test pseudo non existant
    $args_utilisateurs['nom_tweevent_user'] = $data_in['pseudo'];
    $args_utilisateurs['etat'] = '*';
    $utilisateur = Tweevent_users_chercher($args_utilisateurs);

    $return = array();
    if (!empty($utilisateur))
        $return['message'] = "ERREUR ! Le nom d'utilisateur existe deja ! ";
    else {
        $utilisateur_add = new Tweevent_user();
        $utilisateur_add->nom_tweevent_user = $pseudo;
        $utilisateur_add->mdp_tweevent_user = crypt($mdp);
        $utilisateur_add->email_tweevent_user = "a_definir_plus_tard@email.fr";
        $utilisateur_add->ADD();
        $return['message'] = "Votre utilisateur a bien ete creer";
        $return['id'] = $utilisateur;
    }

    echo json_encode($return);
}

?>