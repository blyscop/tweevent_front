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
		<a href="actions.php?tmsp=<?=time()?>&action=Sauvegarde" onClick="App('Patienter')">[%%CreerSauvegarde%%]</a> ::
		<a href="#" onClick="App('Import_WD')">[%%ImporterSauvegarde%%]</a>
	</div>
	<div class="end"></div>	
	<div id="divDonnees">						
      <div style="width: 600px; height: 400px; z-index: 1; left: 10px; top: 10px; overflow: auto; visibility: visible;">
      <form name="sauvegardes" action="actions.php?tmsp=<?=time()?>" method="post">
        <table border="0" width="600" class="Tableau">
          <tr>
            <td class="Colonne" colspan="2">%%Sauvegarde%%</td>
            <td class="Colonne" colspan="2">%%Actions%%</td>
          </tr>      		  
<? $i = 0; foreach($data_out['liste_sauvegardes'] as $sauvegarde => $etat) { $i++; ?>	  		
          <tr class="<?=($i%2) ? "LigneImpaire" : "LignePaire"?>">
            <td width="300" class="DataTxt"><a href="javascript:lance('form=sauvegardes', 'action=Sauvegarde_FTP', 'sauvegarde=<?=$sauvegarde?>')"> <?=$sauvegarde?> </a>
            </td>
            <td align="center" class="Lien" width="200">
			  <? if ($etat === 0) { ?>
              <a href="actions.php?tmsp=<?=time()?>&action=CompleterSauvegarde&sauvegarde=<?=$sauvegarde?>" onclick="App('Patienter')" >
							%%CompleterSauvegarde%%
              </a>
			  <? } ?> &nbsp;
			  <? if ($etat === 2) { ?>
              <a href="actions.php?tmsp=<?=time()?>&action=CompleterRestauration&sauvegarde=<?=$sauvegarde?>" onclick="App('Patienter')">
							%%CompleterRestauration%%
              </a>
			  <? } ?> &nbsp;			  
            </td>    
						<td align="center" class="Lien">
              <a href="javascript:if(confirm('%%ConfirmerSuppressionSauvegarde%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Sauvegarde_DEL&sauvegarde=<?=$sauvegarde?>'">
                [%%supprimer%%]</a>
            </td>    
            <td align="center" class="Lien">
              <a href="javascript:if(confirm('%%ConfirmerRestaurationSauvegarde%%')) { App('Patienter'); location.href = 'actions.php?tmsp=<?=time()?>&action=Restauration&sauvegarde=<?=$sauvegarde?>';}">
                [%%restaurer%%]</a>            </td>
          </tr>
				<? } ?>
        </table>
		  <input name="sauvegarde" type="hidden" >
      <input name="action" value="Sauvegarde" type="hidden">
	    </form>		  
	   </div>
  </div>
</div>
<div id="Patienter" style="position: absolute;
		top:50%;
		left:50% ;
		height:100px;
		width:200px;
		margin-top:-50px ;
		margin-left:-100px ;
		text-align: center;
		border: 2px solid #C7C799;
		z-index:100; 
		padding: 6px; 
		background-color:#F2F2D3;
		visibility:hidden;">
  <p class="body1"><br><br><br><strong>%%Patienter%%</strong></p>
</div>
<div id="Import_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:500px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="Import" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>%%ImporterSauvegarde%%</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('Import_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData">
		<form name="importation_sauvegarde" action="actions.php?tmsp=<?=time()?>" method="post" enctype="multipart/form-data">
			<input name="sauvegarde" type="file" size="40">&nbsp;<input type="submit" value="%%Importer%%" />
		<input name="action" type="hidden" value="Sauvegarde_Importer">
		</form>
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
	visibility:hidden">&nbsp;</div>
</body>
<script type=text/javascript>
Drag.init(document.getElementById("Import"));
</script>
</html>