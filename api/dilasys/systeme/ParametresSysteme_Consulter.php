<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin DiLaSoft</title>
<meta content="0" http-equiv="Expires">
<meta content="0" http-equiv="Last-Modified">
<meta content="no-cache, must-revalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="Pragma">
<link href="../style/dilasoft.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="divMain">
	<div id="divClose">
	<a href="../actions.php?action=Login_Quitter">[%%deconnexion%%]</a></div>	
	<div id="headerAdmin">
	<? include('menu_haut.php') ?>
	</div>
	<div class="end"></div>	
	<div class="divMenu">&nbsp;
	</div>
	<div class="end"></div>	
	<span class="MessageErreur"><?=$data_out['message']?></span>
	<div class="end"></div>	
	<div id="divDonnees">
		 <table border="0"  class="Tableau">
		  <tr>
		    <td width="25%" class="Colonne">%%Parametre%%</td>
		    <td class="Colonne">%%Valeur%%</td>
		  </tr>
<? $i = 0; foreach($data_out['params'] as $key => $value) { $i++; ?>		  
		  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
		    <td class="DataTxt"><strong><?=$key?></strong></td>
		    <td class="DataTxt"><?=$value?></td>
		  </tr>
<? } ?>		 
		 </table>
</body>
</html>