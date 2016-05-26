<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Module de g&eacute;n&eacute;ration de classes</title>
	<script type="text/javascript" language='javascript'>
	
	function ajouter_une_ligne(nb_lignes){
		var id = nb_lignes + 1;
    	document.getElementById('nb_lignes').value++;
		var ln = new Number(document.getElementById('table_lignes').rows.length);
		var newRow = document.getElementById('table_lignes').insertRow(ln-4);
		var newCell = newRow.insertCell(0);
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input name="nom_'+id+'" size="20" maxlength="64" value="" type="text">*';
		var newCell = newRow.insertCell(1);
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<select name="type_'+id+'"><option value="VARCHAR">VARCHAR</option><option value="TEXT">TEXT</option><option value="DATE">DATE</option><option value="INT">INT</option><option value="CHAR">CHAR</option><option value="DECIMAL">DECIMAL</option><option value="ENUM">ENUM</option></select>';
		var newCell = newRow.insertCell(2);
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input name="taille_'+id+'" size="8" value="" type="text">';
		var newCell = newRow.insertCell(3);
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '&nbsp;';
		var newCell = newRow.insertCell(4);
		newCell.align = "center";
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input type="checkbox" name="recherche_'+id+'" />'; 
		var newCell = newRow.insertCell(5);
		newCell.align = "center";
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input type="checkbox" name="clef_'+id+'_1" />'; 
		var newCell = newRow.insertCell(6);
		newCell.align = "center";
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input type="checkbox" name="clef_'+id+'_2" />'; 
		var newCell = newRow.insertCell(7);
		newCell.align = "center";
		newCell.bgColor = "#dddddd";
		newCell.innerHTML = '<input type="checkbox" name="clef_'+id+'_3" />'; 
		newCell = newRow.insertCell(8);
		newCell.bgColor = "#dddddd";
		newCell.align = "center";
		newCell.innerHTML = '<a href="#" onclick="javascript:if(confirm(\'Confirmer la suppression de la ligne ?\')) supprimer_la_ligne('+(ln-3)+')"><img src="sup.gif" border="0" /></a>';
	}
	
	function supprimer_la_ligne(id){
		//On fait disparaitre la ligne à l'affichage seulement
	   document.getElementById('table_lignes').rows[id].style.display = 'none';
		//On crée un champ hidden permettant de savoir que la ligne effacée est inactive
	   document.getElementById('input_hidden').innerHTML += '<input type="hidden" id="ligne_'+(id-1)+'" name="ligne_'+(id-1)+'" value="inactif" />';
		
	}
	
	function creer_classe(){
		var test = 1;
		if(document.form_creation.nom_bdd.value == "" || document.form_creation.nom_table.value == "")
			test = 0;
		for(i = 1 ; i <= document.form_creation.nb_lignes.value ; i++){
			if(eval("document.form_creation.nom_"+i+".value") == ""){
				if(eval("document.form_creation.ligne_"+i) == undefined)
					test = 0;
			}
		}
		if (test == 1) 
			document.form_creation.submit();
		else 
			alert("Certains champs sont vides.");
	}
	</script>
    <style type="text/css">
<!--
.Style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000; }
.Style4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
    </style>
</head>
<body>
	<div align="center">
	<span class="Style4">GENERATEUR DE CLASSES</span><br />
	<span class="Style3">
    <?=(isset($data_out['message'])) ? $data_out['message'] : ''?>
	  </span>
</div>
<form action="actions.php" method="post" enctype="multipart/form-data" name="form_mise_a_jour" class="Style1" id="form_mise_a_jour">
		<div align="center">
		  <table>
		    <tbody>
		      <tr>
		        <td bgcolor="#CCCCCC">Classe &agrave; mettre &agrave; jour : 
	            <input name="path" type="file" class="formulaire8"></td>
			  </tr>
		      <tr><td bgcolor="#CCCCCC"><div align="right"><input type="submit" name="submit" style="height: 24px" value="Update..." />
		        <input type="hidden" name="action" value="Class_UPD" /></div></td>
			  </tr>
	        </tbody>
		      </table>
  </div>
</form>
	<form action="actions.php" method="post" name="form_creation" class="Style1" id="form_creation">
    	<div align="center">
    	  <table>
    	    <tbody>
    	      <tr>
    	        <td width="181" bgcolor="#CCCCCC">Nom du projet : </td>
                <td width="196" bgcolor="#CCCCCC"><input name="nom_bdd" size="20" maxlength="64" value="<?=$data_out['nom_bdd']?>" type="text" />*</td>
              </tr>
    	      <tr>
    	        <td bgcolor="#CCCCCC">Nom de la table (au singulier) : </td>
                <td bgcolor="#CCCCCC"><input name="nom_table" size="20" onchange="document.getElementById('span_nom_table').innerHTML = '_'+document.form_creation.nom_table.value" maxlength="64" value="<?=$data_out['nom_table']?>" type="text" />*</td>
              </tr>
   	        </tbody>
   	      </table>
    	  <br />
        <table border="1" id="table_lignes">
          <tbody>
            <tr>
              <th>Champ</th>
                <th>Type<br></th>
   			    <th>Taille/Valeurs</th>
   			    <th>Extra</th>
		        <th>Recherche </th>
   		        <th colspan="3">Clefs secondaires </th>
   		        <th>&nbsp;</th>
			  </tr>
            <tr>
              <td bgcolor="#dddddd">id<span id="span_nom_table"></span></td>
			    <td bgcolor="#dddddd">INT</td>
			    <td bgcolor="#dddddd">11</td>
			    <td bgcolor="#dddddd">
				    auto_increment					</td>
              <td align="center"><img src="ok.gif"  /></td>
       	        <td colspan="3" align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td align="center" bgcolor="#dddddd">&nbsp;</td>
   			  </tr>
            <?  $i = 1;
					if(!empty($data_out['liste_champs'])){
						foreach($data_out['liste_champs'] as $champ){ ?>
            <tr>
              <td bgcolor="#dddddd">
                <input name="nom_<?=$i?>" size="20" maxlength="64" value="<?=$champ['nom']?>" type="text">*</td>
			    <td bgcolor="#dddddd">
				    <select name="type_<?=$i?>">
				        <option value="VARCHAR" <? if($champ['type'] == 'VARCHAR') echo 'selected="selected"' ?>>VARCHAR</option>
				        <option value="TEXT" <? if($champ['type'] == 'TEXT') echo 'selected="selected"' ?>>TEXT</option>
				        <option value="DATE" <? if($champ['type'] == 'DATE') echo 'selected="selected"' ?>>DATE</option>
				        <option value="INT" <? if($champ['type'] == 'INT') echo 'selected="selected"' ?>>INT</option>
				        <option value="CHAR" <? if($champ['type'] == 'CHAR') echo 'selected="selected"' ?>>CHAR</option>
				        <option value="DECIMAL" <? if($champ['type'] == 'DECIMAL') echo 'selected="selected"' ?>>DECIMAL</option>
				        <option value="ENUM" <? if($champ['type'] == 'ENUM') echo 'selected="selected"' ?>>ENUM</option>
			        </select>					</td>
			    <td bgcolor="#dddddd">
				    <input name="taille_<?=$i?>" size="8" value="<?=$champ['taille']?>" type="text"></td>
			    <td bgcolor="#dddddd">&nbsp;</td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="recherche_<?=$i?>"
								<?  if(!empty($data_out['clefs_recherche'])){
									   	foreach($data_out['clefs_recherche'] as $clef_recherche) 
											if($champ['nom'] == $clef_recherche) echo 'checked'; 
									} ?> 
									/></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_1" 
									<? if(!empty($data_out['clef_1'])) { foreach($data_out['clef_1'] as $clef) if($champ['nom'] == $clef) echo 'checked'; } ?> /></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_2" 
									<? if(!empty($data_out['clef_2'])) { foreach($data_out['clef_2'] as $clef) if($champ['nom'] == $clef) echo 'checked'; } ?> /></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_3" 
									<? if(!empty($data_out['clef_3'])) { foreach($data_out['clef_3'] as $clef) if($champ['nom'] == $clef) echo 'checked'; } ?> /></td>
			    <td align="center" bgcolor="#dddddd"><a href="#" onclick="javascript: if(confirm('Confirmer la suppression de la ligne ?')) supprimer_la_ligne(<?=$i+1?>);"><img src="sup.gif" border="0" /></a></td>
					  </tr>
            <? $i++; } $i--;
				   } 
				   if($i == 1){ ?>
            <tr>
              <td bgcolor="#dddddd">
                <input name="nom_<?=$i?>" size="20" maxlength="64" value="" type="text">*</td>
			    <td bgcolor="#dddddd">
				    <select name="type_<?=$i?>">
				        <option value="VARCHAR">VARCHAR</option>
				        <option value="TEXT">TEXT</option>
				        <option value="DATE">DATE</option>
				        <option value="INT">INT</option>
				        <option value="CHAR">CHAR</option>
				        <option value="DECIMAL">DECIMAL</option>
				        <option value="ENUM">ENUM</option>
			        </select>					</td>
			    <td bgcolor="#dddddd">
				    <input name="taille_<?=$i?>" size="8" value="" type="text">					</td>
			    <td bgcolor="#dddddd">&nbsp;</td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="recherche_<?=$i?>" /></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_1" /></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_2" /></td>
			    <td align="center" bgcolor="#dddddd"><input type="checkbox" name="clef_<?=$i?>_3" /></td>
			    <td align="center" bgcolor="#dddddd"><a href="#" onclick="javascript: if(confirm('Confirmer la suppression de la ligne ?')) supprimer_la_ligne(<?=$i+1?>);"><img src="sup.gif" border="0" /></a></td>
					  </tr>
            <? } ?>
            <tr>
              <td bgcolor="#dddddd">etat</td>
			    <td bgcolor="#dddddd">ENUM</td>
			    <td bgcolor="#dddddd">'actif', 'inactif', 'supprime'</td>
			    <td bgcolor="#dddddd">&nbsp;</td>
              <td align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td colspan="3" align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td align="center" bgcolor="#dddddd">&nbsp;</td>
   			  </tr>
            <tr>
              <td bgcolor="#dddddd">date_add</td>
			    <td bgcolor="#dddddd">VARCHAR</td>
			    <td bgcolor="#dddddd">255</td>
			    <td bgcolor="#dddddd">&nbsp;</td>
              <td align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td colspan="3" align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td align="center" bgcolor="#dddddd">&nbsp;</td>
   			  </tr>
            <tr>
              <td bgcolor="#dddddd">date_upd</td>
			    <td bgcolor="#dddddd">VARCHAR</td>
			    <td bgcolor="#dddddd">255</td>
			    <td bgcolor="#dddddd">&nbsp;</td>
              <td align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td colspan="3" align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td align="center" bgcolor="#dddddd">&nbsp;</td>
   			  </tr>
            <tr>
              <td bgcolor="#dddddd">info</td>
			    <td bgcolor="#dddddd">VARCHAR</td>
			    <td bgcolor="#dddddd">255</td>
			    <td bgcolor="#dddddd">&nbsp;</td>
              <td align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td colspan="3" align="center" bgcolor="#dddddd">&nbsp;</td>
       	        <td align="center" bgcolor="#dddddd">&nbsp;</td>
   			  </tr>
            </tbody>
          </table>
    	  <br />
    	  <input name="ajouter" value="Ajouter une ligne" type="button" style="height: 24px" onclick="javascript: ajouter_une_ligne(new Number(document.form_creation.nb_lignes.value))">
    	  <input name="sauvegarder" value="Sauvegarder" type="button" style="height: 24px" onclick="javascript: creer_classe();">
    	  <input name="nb_lignes" id="nb_lignes" value="<?=$i?>" type="hidden"/>
    	  <input name="action" value="Class_ADD" type="hidden" />
  	  </div>
    	<div id="input_hidden"></div>
	</form>
	<div align="center"><span class="Style1"><br>
    </span>
    </div>
</body>
</html>
