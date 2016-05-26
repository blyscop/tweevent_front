<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Language" content="fr">
<meta http-equiv="Pragma" content="no-cache">
<meta name="document-state" content="Dynamic">
<meta name="cache-control" content="no-cache, must-revalidate">
<META NAME="Robots" CONTENT="none">
<meta name="Category" content="Webmaster">
<meta name="Author" lang="fr" content="DiLaSoft">
<title>DiLaSoft</title>
<link rel="stylesheet" href="../style/dilasoft.css" type="text/css">
</head>

<body bgcolor="#FFFFFF">
<table  width="980" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="137" align="center" valign="top">&nbsp;</td>
    <td width="15" align="center" valign="top">&nbsp;</td>
    <td width="813" align="left" valign="top"> 
      <table width="100%" border="0" cellspacing="0">
        <tr> 
          <td height="40" width="813" align="center" class="titrepage">Chargement de la base de donn&eacute;es</td>
        </tr>
      </table>
	  <table width="100%">
	   <tr>
	   <td height="300" align="left" valign="top">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td>
		<form name="formulaire" method="post" action="actions.php?tmsp=<?=time()?>">
		  <span class="MessageErreur">&nbsp;&nbsp;<?=$data_out['message']?></span>
		  <br>
		  <table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
			<tbody>
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%BDD%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="bdd" type="text" value="<?=$data_out['bdd']?>"></td>
			  </tr>
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%Login%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="login" type="text" value="<?=$data_out['login']?>"></td>
			  </tr>
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%MotDePasse%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="mdp" type="text" value="<?=$data_out['mdp']?>"></td>
			  </tr>
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%ServeurBdd%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="serveur" type="text" value="<?=$data_out['serveur']?>"></td>
			  </tr>
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%Sgbd%% :&nbsp;</td>
				<td bgcolor="#FFFFFF">
				<input name="sgbd" type="radio" value="mysql" <? if ($data_out['sgbd'] == 'mysql'){ ?>checked="checked"<? } ?>> mysql&nbsp;&nbsp;
				<input name="sgbd" type="radio" value="sqlite" <? if ($data_out['sgbd'] == 'sqlite'){ ?>checked="checked"<? } ?>> sqlite&nbsp;&nbsp;
				</td>
			  </tr>	
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%Prefix%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="prefix" type="text" value="<?=$data_out['prefix']?>"></td>
			  </tr>	
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%Instance%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="instance" type="text" value="<?=$data_out['instance']?>"></td>
			  </tr>	
			  <tr>
				<td width="200" align="right" bgcolor="#FFFFFF">%%Phrase%% :&nbsp;</td>
				<td bgcolor="#FFFFFF"><input name="phrase" type="text" value="<?=$data_out['phrase']?>"></td>
			  </tr>	
			  <tr>
				<td bgcolor="#DDDDDD">&nbsp;</td>
				<td align="center" bgcolor="#DDDDDD">
				  <input name="Entrer" value="%%Installer%%" type="submit" /></td>
			  </tr>
			</tbody>
		  </table>
		  <input name="action" value="Install_Verifier" type="hidden">
		  <input name="lang" value="<?=$lang?>" type="hidden">
		</form>
		</td>
	  </tr>
	</table>
	 </td>
	  </tr>
	  </table>
    </td>
    <td width="15">&nbsp;</td>
  </tr>
</table>
<br>
</body>
</html>
