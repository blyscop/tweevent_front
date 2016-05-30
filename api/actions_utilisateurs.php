<?
//==================================================================================
// UTILISATEURS
//==================================================================================
function Utilisateurs_Accueil($data_in = array())
{
    Lib_myLog("action: ".$data_in['action']);
    foreach($GLOBALS['tab_globals'] as $global) global $$global;

    $data_out['page'] = 'page_utilisateurs_accueil.php';
}
?>