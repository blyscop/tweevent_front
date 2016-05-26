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
function check_utilisateur(formulaire) {
	var tab=Array("nom_utilisateur:NONVIDE", "password:NONVIDE",
	              "nom_groupe:NONVIDE");
	ret = valideForm(formulaire,tab);		
	return ret;
}

function modif_utilisateur(id_utilisateur){
	var httpRequest = getXMLHTTP();
	var url = 'actions.php?action=AJAX_ModifUtilisateur';
	url += '&id_utilisateur='+id_utilisateur;
	envoi_AJAX(httpRequest, url, 'div_modif_utilisateur', true);
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
		<a href="#" onClick="App('AjoutUtilisateur_WD')">[%%AjouterUtilisateur%%]</a>
	</div>
	<div class="end"></div>
	<div><span class="MessageErreur"><?=$data_out['message']?></span></div>
	<div class="end"></div>
	<div id="divDonnees">
		  <table border="0" class="Tableau">
			  <tr>
				<td class="Colonne">%%Utilisateur%%</td>
				<td class="Colonne">%%Groupe%%</td>
				<td class="Colonne" colspan="2">%%Actions%%</td>
			  </tr>
<? $i=0; foreach($data_out['tab_users'] as $USER) { $i++; ?>	  
		  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
				<td class="DataTxt" width="200"><?=$USER['nom_utilisateur']?></td>
				<td class="DataTxt" width="200"><?=$USER['nom_groupe']?></td>
					<? if ($USER['modifiable']) {?>
				<td align="center" class="Lien" width="50">
					<a href="javascript: modif_utilisateur(<?=$USER['id_utilisateur']?>); App('ModifUtilisateur_WD');">[%%modifier%%]</a></td>         
					<? } else { ?>
					<? } ?>
					<? if ($USER['effacable']) {?>					
				<td align="center" class="Lien" width="50">
					<a href="javascript:if(confirm('%%ConfirmerSuppressionUtilisateur%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Utilisateurs_DEL&id_utilisateur=<?=$USER['id_utilisateur']?>'">[%%supprimer%%]</a></td>
					<? } else { ?>
				<td>&nbsp;</td>
					<? } ?>
			  </tr>	  				  
	<? } ?>			
		  </table>
</div>
</div>		  
<div id="AjoutUtilisateur_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:300px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="AjoutUtilisateur" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>Ajouter un utilisateur</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('AjoutUtilisateur_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData" id="div_ajout_utilisateur">
	<form name="ajout" action="actions.php?tmsp=<?=time()?>" method="post" onsubmit="return check_utilisateur('ajout')">
			  <table border="0" cellpadding="3" cellspacing="1">
				<tr class="LigneImpaire">
				  <td width="150" align="right">%%Utilisateur%%:&nbsp;</td>
				  <td width="150"><input name="nom_utilisateur" type="text" class="formulaire" /></td>
				</tr>
				<tr class="LigneImpaire">
				  <td width="150" align="right">%%MDP%%:&nbsp;</td>
				  <td width="150"><input name="password" type="password" class="formulaire" /></td>
				</tr>
				<tr class="LigneImpaire">
				  <td width="150" align="right">%%Groupe%%:&nbsp;</td>
				  <td width="150">
				   <select name="nom_groupe">
					<option> </option>
					<? foreach($data_out['tab_groupes'] as $groupe) { ?>            
					   <option value="<?=$groupe['nom_groupe']?>"><?=$groupe['nom_groupe']?></option>
					<? } ?>            
				   </select>				  
				  </td>
				</tr>
			  </table>
				<br />
				<input type="submit" name="Submit" value="%%Ajouter%%" />
	<input name="action" value="Utilisateurs_Verifier" type="hidden">
	</form>
	</div>
</div>	 

<div id="ModifUtilisateur_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:300px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
	<div class="divPopupHeader" id="ModifUtilisateur" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>Modifier un utilisateur</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('ModifUtilisateur_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
	<div class="divPopupData" id="div_modif_utilisateur"></div>
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
Drag.init(document.getElementById("AjoutUtilisateur"));
Drag.init(document.getElementById("ModifUtilisateur"));
</script>
</html>
