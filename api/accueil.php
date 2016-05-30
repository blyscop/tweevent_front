<?
// S'il faut une redirection sp�cifique en fonction du groupe, utiliser alors la m�canique suivante en rempla�ant "admin" par le nom du groupe concern�
// Mettre autant de blocs qu'il y a de groupes � g�rer...
if ($_GET['groupe'] == 'admin') {
	$racine = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL={$racine}/actions.php\">";
	echo "</head>\n";
	echo "<body>\n";
	echo "</body>\n";
	echo "<html>\n";
}

if ($_GET['groupe'] == 'utilisateur') {
	$racine = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL={$racine}/annuaire/actions.php\">";
	echo "</head>\n";
	echo "<body>\n";
	echo "</body>\n";
	echo "<html>\n";
}

if ($_GET['groupe'] == 'system') {
	$racine = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL={$racine}/dilasys/systeme/actions.php\">";
	echo "</head>\n";
	echo "<body>\n";
	echo "</body>\n";
	echo "<html>\n";
}

?>