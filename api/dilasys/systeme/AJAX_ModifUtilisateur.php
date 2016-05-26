<form name="frm_modif_utilisateur" action="actions.php?tmsp=<?=time()?>" method="post" onsubmit="return check_utilisateur('frm_modif_utilisateur');">
		  <table border="0" cellpadding="3" cellspacing="1">
			<tr class="LigneImpaire">
			  <td width="150" align="right">%%Utilisateur%%:&nbsp;</td>
			  <td width="150"><input name="nom_utilisateur" type="text" class="formulaire" value="<?=$data_out['nom_utilisateur']?>" /></td>
			</tr>
			<tr class="LigneImpaire">
			  <td width="150" align="right">%%MDP%%:&nbsp;</td>
			  <td width="150"><input name="password" type="password" class="formulaire" value="<?=$data_out['password']?>" /></td>
			</tr>
			<tr class="LigneImpaire">
			  <td width="150" align="right">%%Groupe%%:&nbsp;</td>
			  <td width="150">
				<select name="nom_groupe">
				<option> </option>
				<? foreach($data_out['tab_groupes'] as $groupe) { ?>            
					<option value="<?=$groupe['nom_groupe']?>" <? if ($groupe['nom_groupe'] == $data_out['nom_groupe']) echo "selected" ?>><?=$groupe['nom_groupe']?></option>
				<? } ?>            
				</select>
			  </td>
			</tr>
		  </table>
			<br />
	<input type="submit" name="Submit" value="%%Modifier%%"/>
	<input name="id_utilisateur" type="hidden" value="<?=$data_out['id_utilisateur']?>">
	<input name="action" value="Utilisateurs_VerifierModification" type="hidden">
</form>