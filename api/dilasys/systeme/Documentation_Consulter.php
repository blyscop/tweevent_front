<?
/* Fonction r�cursive d'affichage de l'arborescence */
function Arbo_Afficher($arbo, $appel=1) {
      /* Tout d'abord il faut r�cup�rer le niveau pour savoir s'il faut afficher le r�pertoire ou pas */
			$tab = explode("-", $arbo['famille']);
			$niveau = count($tab);

			/* Si nous avons affaire � la racine, on affiche la ligne */
			if ($niveau == 2 || $niveau == 3) {
				echo "<div>\n";
			} else {
                echo "<div id='".$arbo['famille']."' style=\"display:none\">\n";
			}
			$dec=($niveau==2)?0:$niveau-2;
      		echo "<div class='LigneRepertoire'\">";

			echo "<div style=\"width: 50%; float: left;\">"; /* D�but div nom r�pertoire */
			
			/* Un click sur l'ic�ne "expand" ouvre la sous-arborescence */
			if ($niveau == 2) {
				echo "";					
			} else {
			    if (count($arbo['liste_repertoires']) || count($arbo['liste_fichiers'])) {
				/* En fonction du niveau auquel se trouve la sous-arborescence on applique 
			   		un d�calage vers la droite pour bien voir qu'il s'agit d'une sous arborescence */				
				for($d=1;$d<=$dec;$d++) 
					echo "<img src=\"../img/tree_space.gif\" border=0 width=16 height=16>";
				
					echo "<img src=\"../img/tree_split.gif\" border=0 width=16 height=16><img src=\"../img/tree_expand.gif\"  border=0 width=16 height=16 style=\"cursor:pointer\" onclick=\"";			
					foreach($arbo['liste_repertoires'] as $rep)
							echo "showhide('".$rep['famille']."'); ";
					/* On rajoute une ligne pour le traitement des fichiers propres au r�pertoire */
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

			/* On n'affiche que le nom du r�pertoire, sans toute l'arobrescence */
			$tab_rep = explode("/",$arbo['nom_repertoire']);
			$rep = array_pop($tab_rep);
			echo "<strong class=\"titre-dossier\">".$rep."</strong>";			
			echo "</div>\n"; /* Fin div nom r�pertoire */
			echo "<div style=\"float: left; width: 20%;\"> &nbsp;</div>"; /* Espacement */

			echo "<div style=\"width: 25%; float: left;\">"; /* D�but div actions */
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

			/* on remet a 0 les class des div pour ne pas avoir de probl�mes de chevauchement */
			echo "<div class=\"end\"></div>";
			
			/* Si des fichiers pour ce r�pertoire existent, on les affiche */
			if (count($arbo['liste_fichiers'])) {
//					echo "</div>\n";
					if ($appel == 1) {
						echo "<div style=\"display:\">\n";
					} else {
						echo "<div id='".$arbo['famille']."f-' style=\"display:none\">\n";					
					}
					
					/* On va afficher les lignes de fichier en 2 couleurs diff�rentes altern�es */
					$i=0; foreach($arbo['liste_fichiers'] as $fichier) { $i++;
							if ($i%2)
								echo "<div class='LignePaire'\">";
							else 
								echo "<div class='LigneImpaire'\">";

							echo "<div style=\"width: 50%; float: left;\">"; /* D�but div nom fichier */
												 			
							/* En fonction du niveau auquel se trouve la sous-arborescence on applique 
							   un d�calage vers la droite pour bien voir qu'il s'agit d'une sous arborescence */
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
							echo "<div style=\"float: left; width: 5%;\">"; /* D�but div taille fichier */
							echo $fichier['taille_fichier'];
							echo "</div>\n"; /* Fin div taille fichier */
							echo "<div style=\"float: left; width: 15%; \">"; /* D�but div date fichier */
							echo "&nbsp;&nbsp;".$fichier['date_fichier'];		
							echo "</div>\n"; /* Fin div date fichier */
							 /* Fin div actions */
							
							/* on remet a 0 les class des div pour ne pas avoir de probl�mes de chevauchement */
							echo "<div class=\"end\"></div>";
							echo "</div>\n";
					}
					echo "</div>\n";
			}

			echo "</div>\n";			
			/* Si des sous-r�pertoires existent pour le r�pertoire en cours de traitement,
			   on fait un appel r�cursif pour balayer ces sous-r�pertoires. */
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
	<div class="divMenu">
	&nbsp;
	</div>
	<div class="end"></div>	
	<div id="divDonnees">
		<a href="../doc/DOC_DILASYS.txt" target="_blank">Pr&eacute;sentation du syst&egrave;me</a><br /><br />
		<a href="../doc/DOC_NORMES.txt" target="_blank">Normes</a><br /><br />
		Interface admin: cr&eacute;ation de pages statiques pour un site<br /><br />
		Interface admin: cr&eacute;ation de pages dynamiques pour un site<br /><br />
		Cr&eacute;ation d'une application<br /><br />
		Exemples de code:
		<ul>
			<li><a href="../doc/DOC_AJAX.txt" target="_blank">r&eacute;cup&eacute;ration de donn&eacute;es par AJAX</a></li>
			<li><a href="../doc/DOC_AUTOCOMPLETE.txt" target="_blank">mise en place d'un autocomplete</a></li>
			<li><a href="../doc/DOC_EXTERNE.txt" target="_blank">echanges entre syst&egrave;mes</a></li>
			<li><a href="../doc/DOC_IMG.txt" target="_blank">redimensionnement des images</a></li>
		</ul>
		Administration du syst&eacute;me<br /><br />
	</div>
</div>
</body>
</html>