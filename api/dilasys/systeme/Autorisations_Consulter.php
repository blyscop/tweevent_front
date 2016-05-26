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
<script type="text/javascript" src='../scripts/show-hide.js'></script>
<script type="text/javascript" src='../scripts/app-disp.js'></script>
<script type="text/javascript" src='../scripts/saisie.js'></script>
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
		<a href="#"onClick="App('AjoutAutorisation_WD')">[%%AjouterAdresse%%]</a>
	</div>
	<div class="end"></div>
	<div><span class="MessageErreur"><?=$data_out['message']?></span></div>
	<div class="end"></div>
	<div id="divDonneesGroupe">
	<table width="350" border="0" background="#FFFFFF" cellpadding="1" cellspacing="1">
		  <tr>
		   <td width="200" class="Colonne">%%Groupe%%</td>
		   <td width="200" class="Colonne">%%IpAutorisee%%</td>
		   <td class="Colonne" width="50">%%Actions%%</td>
		  </tr>
	<? $i = 0; foreach($data_out['tab_ips_autorisees'] as $ip) { $i++; ?>
		  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
			<td width="45%" class="DataTxt"><?=$ip['nom_groupe']?></td>
			<td width="45%" class="DataTxt"><?=$ip['adresse_ip']?></td>
			<td align="center" class="Lien">	    			    
					<? if ($ip['effacable']) {?>					
				<a href="javascript:if(confirm('%%ConfirmerSuppressionIp%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Autorisations_DEL&id_groupe=<?=$ip['id_groupe']?>&adresse_ip=<?=$ip['adresse_ip']?>'">[%%supprimer%%]</a>
					<? } else { ?>
					&nbsp;
					<? } ?>								
			</td>               
		  </tr>
	<? } ?>			  
	</table>
	</div>
	<div id="divDonneesDroits">
	<table width="350" border="0" background="#FFFFFF" cellpadding="1" cellspacing="1">
		  <tr>
		   <td width="200" class="Colonne">%%Utilisateur%%</td>
		   <td width="200" class="Colonne">%%IpInterdite%%</td>
		   <td class="Colonne" width="50">%%Actions%%</td>
		  </tr>
	<? $i = 0; foreach($data_out['tab_ips_interdites'] as $ip) { $i++; ?>
		  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
			<td width="45%" class="DataTxt"><?=$ip['nom_utilisateur']?></td>
			<td width="45%" class="DataTxt"><?=$ip['adresse_ip']?></td>
			<td align="center" class="Lien">	    			    
				<a href="javascript:if(confirm('%%ConfirmerSuppressionIp%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Interdictions_DEL&nom_utilisateur=<?=$ip['nom_utilisateur']?>&adresse_ip=<?=$ip['adresse_ip']?>'">[%%supprimer%%]</a>
			</td>               
		  </tr>
	<? } ?>			  
	</table>
	</div>

</div>

<div id="FondGris" style="width: 100%;
	position: absolute;
	height: <?=$taille_ecran?>px;
	background-color: #5f5b6a; 
  	opacity : 0.35;  
	filter:alpha(opacity=35);
	-moz-opacity: 0.35;
	top: 0px;
	right: 0px;
	z-index:1;
	visibility:hidden;">&nbsp;</div>
<div id="AjoutAutorisation_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:300px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="AjoutAutorisation" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>Ajouter une adresse autoris&eacute;e</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('AjoutAutorisation_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData">
	<form name="ajout" action="actions.php?tmsp=<?=time()?>" method="post">
			  <table border="0" cellpadding="3" cellspacing="1">
				<tr class="LigneImpaire">
				  <td width="150" align="right">%%Groupe%%:&nbsp;</td>
				  <td width="150">
				   <select name="id_groupe">
					<option> </option>
					<? foreach($data_out['tab_groupes'] as $groupe) { ?>            
					   <option value="<?=$groupe['id_groupe']?>"><?=$groupe['nom_groupe']?></option>
					<? } ?>            
				   </select>				  
				  </td>
				</tr>
        <tr class="LigneImpaire">
          <td width="150" align="right">%%IP%%:&nbsp;</td>
          <td width="150"><input name="adresse_ip" type="text" class="formulaire" /></td>
        </tr>
			  </table>
				<br />
				<input type="submit" name="Submit" value="%%Ajouter%%" />
	<input name="action" value="Autorisations_Verifier" type="hidden">
	</form>
	</div>
</div>
</body>
<script type=text/javascript>
Drag.init(document.getElementById("AjoutAutorisation"));
</script>
</html>