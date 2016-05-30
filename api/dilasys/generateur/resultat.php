<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Cr&eacute;ation effectu&eacute;e</title>
</head>
<body>
	<div align="center">
		<p>Le fichier &eacute;t&eacute; cr&eacute;&eacute; : ./<?=$data_out['nom_bdd']?>/<?=$data_out['nom_table']?>.inc.php</p>
		<p><a href="actions.php?action=Classe_Accueil">Retour...</a></p>
		<p>Requ&ecirc;te &agrave; effectuer pour cr&eacute;er la table dans la base : <br />
	        <textarea name="content_sql" cols="100" rows="25"><?=$sql?></textarea>
	    </p>
	</div>
</body>
</html>