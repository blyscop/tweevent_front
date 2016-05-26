<table border="0" class="Tableau">
  <tr>
	<td class="Colonne" colspan="2" width="200">%%Droits%% <?=$data_out['nom_groupe']?></td>
  </tr>
<? $i=0; foreach($GLOBALS['TAB_DROITS'] as $droit => $libelle) { $i++; ?>	  
	  <tr class="<?=($i%2)?'LigneImpaire':'LignePaire'?>">
			<td class="DataTxt"> <?=$libelle?> </td>
			<td align="center" class="Lien" width="10">
			<? if ($data_out[$droit]&1) { ?>
				<a href="javascript: del_droits('<?=$data_out['nom_groupe']?>', '<?=$droit?>');"> oui </a>
			<? } else { ?> 
				<a href="javascript: add_droits('<?=$data_out['nom_groupe']?>', '<?=$droit?>');"> non </a>
			<? } ?>
			</td>
		  </tr>
<? } ?>
</table>
