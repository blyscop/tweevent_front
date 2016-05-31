<?
//Préparation des POST et des GET dans le tableau data_in
foreach($_GET as $key => $value) $data_in[$key] = stripslashes($value);
foreach($_POST as $key => $value) $data_in[$key] = stripslashes($value);
?>