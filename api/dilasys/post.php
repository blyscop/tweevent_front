<? 
//==================================================================================
// On stocke les informations d'une page a l'autre sur le serveur
//==================================================================================
if (isset($data_srv)) Lib_writeData($data_srv, $session);

//==================================================================================
// Récupération de la page
//==================================================================================
if (isset($data_out['page'])) include($data_out['page']);

//==================================================================================
// On affiche la page sur le client
//==================================================================================
ob_end_flush();

//==================================================================================
// Fermeture systematique de l'acces a la base de donnees
//==================================================================================
Sql_close($tab_session['db_link']);
exit;
?>