		<ul id="tabnav">
			<li><a href="../../accueil.php">[%%quitter%%]</a></li>
			<li <?=($data_out['action'] == 'Groupes_Consulter') ? 'class="active"' : ''?>><a href="actions.php?action=Groupes_Consulter">%%Groupes%%</a></li>
			<li <?=($data_out['action'] == 'Utilisateurs_Consulter') ? 'class="active"' : ''?>><a href="actions.php?action=Utilisateurs_Consulter">%%Utilisateurs%%</a></li>
			<li <?=($data_out['action'] == 'Autorisations_Consulter') ? 'class="active"' : ''?>><a href="actions.php?action=Autorisations_Consulter">%%Adresses%%</a></li>
			<li <?=($data_out['action'] == 'ParametresSysteme_Consulter') ? 'class="active"' : ''?>><a href="actions.php?tmsp=<?=time()?>&action=ParametresSysteme_Consulter">%%Parametres%%</a></li>
			<li <?=($data_out['action'] == 'AfficherSauvegarde') ? 'class="active"' : ''?>><a href="actions.php?tmsp=<?=time()?>&action=AfficherSauvegarde">%%Sauvegarde%%</a></li>
<!--			<li <?=($data_out['action'] == 'Fichiers_Consulter') ? 'class="active"' : ''?>><a href="actions.php?tmsp=<?=time()?>&action=Fichiers_Consulter">%%Fichiers%%</a></li> -->
			<li <?=($data_out['action'] == 'Documentation_Consulter') ? 'class="active"' : ''?>><a href="actions.php?tmsp=<?=time()?>&action=Documentation_Consulter">%%Documentation%%</a></li>
		</ul>