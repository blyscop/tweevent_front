<form name="frm_modif_groupe" action="actions.php?tmsp=<?=time()?>" method="post" onsubmit="return check_groupe('frm_modif_groupe')">
		  <table border="0" cellpadding="3" cellspacing="1">
			<tr class="LigneImpaire">
			  <td width="150" align="right">%%Groupe%%:&nbsp;</td>
			  <td width="150"><input name="nom_groupe" type="text" class="formulaire" value="<?=$data_out['nom_groupe']?>" /></td>
			</tr>
			<? foreach($data_out['liste_modules'] as $module) { ?>
			<tr class="LigneImpaire">
			  <td width="150" align="right"><input type="checkbox" name="<?=$module?>" <? if(in_array($module, $data_out['modules'])) echo "checked"; ?> /></td>
			  <td width="150" align="left"><?=$module?></td>
			</tr>				
			<? } ?>
		  </table>
			<br />
			<input type="submit" name="Submit" value="%%Modifier%%" />
	  <input name="id_groupe" type="hidden" value="<?=$data_out['id_groupe']?>">
	  <input name="action" value="Groupes_VerifierModification" type="hidden">
</form>
