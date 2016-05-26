<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin DiLaSoft</title>
<meta content="0" http-equiv="Expires">
<meta content="0" http-equiv="Last-Modified">
<meta content="no-cache, must-revalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="Pragma">
<script type="text/javascript" src='../scripts/drag.js'></script>
<script type="text/javascript" src='../scripts/lance.js'></script>
<script type="text/javascript" src='../scripts/ajax.js'></script>
<script type="text/javascript" src='../scripts/show-hide.js'></script>
<script type="text/javascript" src='../scripts/app-disp.js'></script>
<script type="text/javascript" src='../scripts/saisie.js'></script>
<script language='JavaScript'>
function check_groupe(formulaire) {
	var tab=Array("nom_groupe:NONVIDE");
	ret = valideForm(formulaire,tab);		
	return ret;
}

function modif_groupe(id_groupe){
	var httpRequest = getXMLHTTP();
	var url = 'actions.php?action=AJAX_ModifGroupe';
	url += '&id_groupe='+id_groupe;
	envoi_AJAX(httpRequest, url, 'div_modif_groupe', true);
}

function rechercher_droits(nom_groupe) {
	var httpRequest = getXMLHTTP();
	var url = 'actions.php?action=AJAX_DroitsGroupe';
	url += '&nom_groupe='+nom_groupe;
	envoi_AJAX(httpRequest, url, 'divDonneesDroits', true);				 		 		 		 		 		 		 		 				
}

function add_droits(nom_groupe, champ) {
	var httpRequest = getXMLHTTP();
	var url = 'actions.php?action=Groupe_DroitsADD';
	url += '&nom_groupe='+nom_groupe;
	url += '&champ='+champ;
	envoi_AJAX(httpRequest, url, 'divDonneesDroits', true);				 		 		 		 		 		 		 		 				
}

function del_droits(nom_groupe, champ) {
	var httpRequest = getXMLHTTP();
	var url = 'actions.php?action=Groupe_DroitsDEL';
	url += '&nom_groupe='+nom_groupe;
	url += '&champ='+champ;
	envoi_AJAX(httpRequest, url, 'divDonneesDroits', true);				 		 		 		 		 		 		 		 				
}
</script>
<link href="../style/dilasoft.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="divMain">
	<div id="divClose">
	<a href="../actions.php?action=Login_Quitter">[%%deconnexion%%]</a></div>	
	<div id="headerAdmin">
	<? include('menu_haut.php') ?>
	</div>
	<div>
	<? if($data_out['message_ok']) { ?><div id="msg_ok"><?=$data_out['message_ok']?></div><? } ?>
	<? if($data_out['message_ko']) { ?><div id="msg_ko"><?=$data_out['message_ko']?></div><? } ?></div>
	<div class="end"></div>			
	<div class="divMenu">
		<a href="#" onClick="App('AjoutGroupe_WD')">[%%AjouterGroupe%%]</a>
	</div>
	<div class="end"></div>
	<div><span class="MessageErreur"><?=$data_out['message']?></span></div>
	<div class="end"></div>
	<div id="divDonneesGroupe">
  <table border="0" class="Tableau">
	  <tr>
		<td class="Colonne" width="200">%%Groupe%%</td>
		<td class="Colonne" colspan="3">%%Actions%%</td>
	  </tr>
<? $i=0; foreach($data_out['tab_groupes'] as $groupe) { $i++; ?>	  
		  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
				<td class="DataTxt"> <?=$groupe['nom_groupe']?> </td>
				<td align="center" class="Lien" width="50">
					<? if ($groupe['modifiable']) {?>
					<a href="javascript: modif_groupe(<?=$groupe['id_groupe']?>); App('ModifGroupe_WD');">[%%modifier%%]</a></td>         
					<? } else { ?>
					&nbsp;
					<? } ?>
				<td align="center" class="Lien" width="50">
					<? if ($groupe['effacable']) {?>					
					<a href="javascript:if(confirm('%%ConfirmerSuppressionGroupe%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Groupes_DEL&id_groupe=<?=$groupe['id_groupe']?>'">[%%supprimer%%]</a>
					<? } else { ?>
					&nbsp;
					<? } ?>				
				</td>
				<td align="center" class="Lien" width="50">
					<a href="javascript: rechercher_droits('<?=$groupe['nom_groupe']?>');">[%%droits%%]</a>
				</td>
			  </tr>	  				  
	<? } ?>			
		  </table>
	</div>
	<div id="divDonneesDroits">
	</div>
</div>
<div id="AjoutGroupe_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:300px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="AjoutGroupe" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>Ajouter un groupe</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('AjoutGroupe_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData"  id="div_ajout_groupe">
	<form name="ajout" action="actions.php?tmsp=<?=time()?>" method="post" onsubmit="return check_groupe('ajout');">
			  <table border="0" cellpadding="3" cellspacing="1">
				<tr class="LigneImpaire">
				  <td width="150" align="right">%%Groupe%%:&nbsp;</td>
				  <td width="150"><input name="nom_groupe" type="text" class="formulaire" /></td>
				</tr>
				<? foreach($data_out['liste_modules'] as $module) { ?>
				<tr class="LigneImpaire">
				  <td width="150" align="right"><input type="checkbox" name="<?=$module?>" /></td>
				  <td width="150" align="left"><?=$module?></td>
				</tr>				
				<? } ?>
			  </table>
				<br />
				<input type="submit" name="Submit" value="%%Ajouter%%" />
	<input name="action" value="Groupes_Verifier" type="hidden">
	</form>
	</div>
</div>	 
 
<div id="ModifGroupe_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:300px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="ModifGroupe" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>Modifier un groupe</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('ModifGroupe_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData" id="div_modif_groupe"></div>
</div>	 

<div id="FondGris" 
	style="width: 100%;
	position: absolute;
	height: 98%;
	background-color: #5f5b6a; 
	opacity : 0.35;  
	filter:alpha(opacity=35);
	-moz-opacity: 0.35;
	top: 0px;
	right: 0px;
	z-index:1;
	visibility:hidden;">&nbsp;</div>
</body>
<script type=text/javascript>
Drag.init(document.getElementById("AjoutGroupe"));
Drag.init(document.getElementById("ModifGroupe"));
</script>
</html>