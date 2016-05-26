<?
/* Fonction récursive d'affichage de l'arborescence */
function Arbo_Afficher($arbo, $appel=1) {
      /* Tout d'abord il faut récupérer le niveau pour savoir s'il faut afficher le répertoire ou pas */
			$tab = explode("-", $arbo['famille']);
			$niveau = count($tab);

			/* Si nous avons affaire à la racine, on affiche la ligne */
			if ($niveau == 2 || $niveau == 3) {
				echo "<div>\n";
			} else {
                echo "<div id='".$arbo['famille']."' style=\"display:none\">\n";
			}
			$dec=($niveau==2)?0:$niveau-2;
      		echo "<div class='LigneRepertoire'\">";

			echo "<div style=\"width: 50%; float: left;\">"; /* Début div nom répertoire */
			
			/* Un click sur l'icône "expand" ouvre la sous-arborescence */
			if ($niveau == 2) {
				echo "";					
			} else {
			    if (count($arbo['liste_repertoires']) || count($arbo['liste_fichiers'])) {
				/* En fonction du niveau auquel se trouve la sous-arborescence on applique 
			   		un décalage vers la droite pour bien voir qu'il s'agit d'une sous arborescence */				
				for($d=1;$d<=$dec;$d++) 
					echo "<img src=\"../img/tree_space.gif\" border=0 width=16 height=16>";
				
					echo "<img src=\"../img/tree_split.gif\" border=0 width=16 height=16><img src=\"../img/tree_expand.gif\"  border=0 width=16 height=16 style=\"cursor:pointer\" onclick=\"";			
					foreach($arbo['liste_repertoires'] as $rep)
							echo "showhide('".$rep['famille']."'); ";
					/* On rajoute une ligne pour le traitement des fichiers propres au répertoire */
					echo "showhide('".$arbo['famille']."f-');";
					echo "\"> ";			
				} else {
					for($d=1;$d<=$dec;$d++) 
						echo "<img src=\"../img/tree_space.gif\" border=0 width=16 height=16>";				
					echo "<img src=\"../img/tree_split.gif\" border=0 width=16 height=16>";				
				}
				echo "<a href=\"#\" onClick=\"document.nouvdossier.dossierpere.value='";
				echo $arbo['nom_repertoire'];
				echo "'; App('ActionsDossier_WD'); return false;\" class=\"lien\">";
				echo "<img src=\"../img/closefold.gif\" border=0>";
				echo "</a>&nbsp;&nbsp;";

//				echo "<a href=\"#\" onClick=\"document.nouvdossier.dossierpere.value='";
//				echo $arbo['nom_repertoire'];
//				echo "'; App('AjoutDossier_WD');\" class=\"lien\">";
//				echo "<img src=\"../img/closefold.gif\" border=0>";
//				echo "</a>&nbsp;&nbsp;";
			}

			/* On n'affiche que le nom du répertoire, sans toute l'arobrescence */
			$tab_rep = explode("/",$arbo['nom_repertoire']);
			$rep = array_pop($tab_rep);
			echo "<strong class=\"titre-dossier\">".$rep."</strong>";			
			echo "</div>\n"; /* Fin div nom répertoire */
			echo "<div style=\"float: left; width: 20%;\"> &nbsp;</div>"; /* Espacement */

			echo "<div style=\"width: 25%; float: left;\">"; /* Début div actions */
			/* On affiche les actions de suppression, d'ajout de dossier et document */
			if ($niveau != 2) {
				echo "<a href=\"javascript:if(confirm('%%lang_confsup_dossier%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Fichiers_DELDir&dossierpere=";
				echo $arbo['nom_repertoire'];
				echo "'\" class=\"lien\">[supprimer]</a>&nbsp;&nbsp;";
			} else {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}

			echo "<a href=\"#\" onClick=\"document.nouvdossier.dossierpere.value='";
			echo $arbo['nom_repertoire'];
			echo "'; App('AjoutDossier_WD');\" class=\"lien\">";
			echo "[ajout dossier]";
			echo "</a>&nbsp;&nbsp;";
			echo "<a href=\"#\" onClick=\"document.nouvfic.dossierlien.value='";
			echo $arbo['nom_repertoire'];	
			echo "', App('ActionsFichier_WD')\" class=\"lien\">";
			echo "[ajout document]";
			echo "</a>";
			echo "</div>\n"; /* Fin div actions */

			/* on remet a 0 les class des div pour ne pas avoir de problèmes de chevauchement */
			echo "<div class=\"end\"></div>";
			
			/* Si des fichiers pour ce répertoire existent, on les affiche */
			if (count($arbo['liste_fichiers'])) {
//					echo "</div>\n";
					if ($appel == 1) {
						echo "<div style=\"display:\">\n";
					} else {
						echo "<div id='".$arbo['famille']."f-' style=\"display:none\">\n";					
					}
					
					/* On va afficher les lignes de fichier en 2 couleurs différentes alternées */
					$i=0; foreach($arbo['liste_fichiers'] as $fichier) { $i++;
							if ($i%2)
								echo "<div class='LignePaire'\">";
							else 
								echo "<div class='LigneImpaire'\">";

							echo "<div style=\"width: 50%; float: left;\">"; /* Début div nom fichier */
												 			
							/* En fonction du niveau auquel se trouve la sous-arborescence on applique 
							   un décalage vers la droite pour bien voir qu'il s'agit d'une sous arborescence */
							for($d=0;$d<=$dec;$d++) 
								echo "<img src=\"../img/tree_space.gif\" border=0 width=16 height=16>";

							/* On affiche le type de fichier et le lien pour son ouverture */
							echo "<img src=\"../img/tree_split.gif\" border=0 width=16 height=16>";

							echo "<a href=\"#\" onContextMenu=\"App('ActionsFichier_WD'); return false\" onClick=\"document.download_fic.file.value='";
							echo $arbo['nom_repertoire'];
							echo "'; document.download_fic.nomfichier.value='";
							echo $fichier['nom_fichier'];
							echo "'; App('ActionsFichier_WD');\" class=\"lien\">";
							echo "<img src=\"../img/tree_leaf.gif\" border=0 width=16 height=16><img src='../img/";
							echo $fichier['type_fichier'];
							echo "' width='17' height='17' align='absbottom' border=0>";
							echo htmlentities(utf8_decode($fichier['nom_fichier']));
							echo "</a> ";

							echo "</div>\n"; /* Fin div nom fichier */
							echo "<div style=\"float: left; width: 5%;\">"; /* Début div taille fichier */
							echo $fichier['taille_fichier'];
							echo "</div>\n"; /* Fin div taille fichier */
							echo "<div style=\"float: left; width: 15%; \">"; /* Début div date fichier */
							echo "&nbsp;&nbsp;".$fichier['date_fichier'];		
							echo "</div>\n"; /* Fin div date fichier */
							 /* Fin div actions */
							
							/* on remet a 0 les class des div pour ne pas avoir de problèmes de chevauchement */
							echo "<div class=\"end\"></div>";
							echo "</div>\n";
					}
					echo "</div>\n";
			}

			echo "</div>\n";			
			/* Si des sous-répertoires existent pour le répertoire en cours de traitement,
			   on fait un appel récursif pour balayer ces sous-répertoires. */
			if (count($arbo['liste_repertoires'])) {			
			   foreach($arbo['liste_repertoires'] as $repertoire) {
			   		$appel++;
					Arbo_Afficher($repertoire, $appel);
				}
			}
			echo "</div>\n";
} 

?>
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
	<? if($data_out['message_ko']) { ?><div id="msg_ko"><?=$data_out['message_ko']?></div><? } ?>
	</div>
	<div class="end"></div>			
	<div class="divMenu">
	&nbsp;
	</div>
	<div class="end"></div>	
	<div id="divDonnees">
<? Arbo_Afficher($data_out['liste_repertoires']); ?>
	</div>
</div>
<div id="ID_MENUActionsDossier_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:500px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="ID_MENUActionsDossier" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>%%AjoutDossier%%</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('ActionsDossier_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData">
			<a class="lien" href="#" onclick="App('DivAjoutDossier');">[cr&eacute;er un dossier dans ce r&eacute;pertoire]</a>			
			<div id="ID_MENUDivAjoutDossier" style="display:none">
			<form name="nouvdossier" method="post" action="actions.php?tmsp=<?=time()?>">
			<input type='text' size='15' name='nouveau_dossier'>
			<input type='hidden' name='dossierpere'>
			<input type='hidden' name='action' value='Fichiers_ADDDir'>
			<input type='submit' value='%%lang_cre%%'>
			</form>
			</div>
			<div class="end"></div>
			<a class="lien" href="#" onclick="App('DivAjoutFichier');">[ajouter un fichier dans ce r&eacute;pertoire]</a><br>
			<div id="ID_MENUDivAjoutFichier" style="display:none">
			<form method="post" name="nouvfic" action="actions.php?tmsp=<?=time()?>" enctype="multipart/form-data">
			<input type="file" size=60 name="fichier">
			<input type="hidden" name="action" value="Fichiers_FTP">
			<input type="hidden" name="dossierlien">
			<input type="submit" value="%%lang_send%%">
			</form>
			</div>
			<div class="end"></div>
		</div>
</div>	  
<div id="ID_MENUActionsFichier_WD" style="
	position:absolute; 
	top:73px; 
	left:250px; 
	width:500px; 
	z-index:500; 
	bgcolor: #FFFFFF;
	padding:0;
	display:none">
		<div class="divPopupHeader" id="ID_MENUActionsFichier" style="top:73px; left:250px;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		 	 <tr>
				 <td width="30" height="30" style="cursor:move">&nbsp;</td>
		 		 <td align="center" class="texte12-blc" style="cursor:move"><strong>%%AjoutFichier%%</strong></td>
			 	 <td width="30" align="center" valign="middle">
			  	  <a href="#" onClick="Disp('ActionsFichier_WD')" >[%%fermer%%]</a>&nbsp;
				  </td>
		     </tr>
			</table>
		</div>
		<div class="divPopupData">
			<form method="post" name="download_fic" action="actions.php?tmsp=<?=time()?>">
          	<a class="lien" href="javascript: lance('form=download_fic')">[t&eacute;l&eacute;charger le fichier]</a>
			<input type="hidden" name="file" />
			<input type="hidden" name="nomfichier" />
			<input type="hidden" name="action" value="download" />
			</form>		
			<a class="lien" href="javascript:if(confirm('%%lang_confsup_doc%%')) location.href = 'actions.php?tmsp=<?=time()?>&action=Fichiers_DELDoc&fichier=<?=$arbo['nom_repertoire']."/".$fichier['nom_fichier']?>'">[supprimer le fichier]</a>
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
<script type=text/javascript>
Drag.init(document.getElementById("ID_MENUActionsFichier"));
Drag.init(document.getElementById("ID_MENUActionsDossier"));
</script>
</body>
</html>