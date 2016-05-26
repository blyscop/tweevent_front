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
<table width="980" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="137" align="center" valign="top">&nbsp;</td>
    <td width="15" align="center" valign="top">&nbsp;</td>
    <td width="813" align="left" valign="top"> 
      <table width="100%" border="0" cellspacing="0">
        <tr> 
          <td height="40" width="813" align="center" class="titrepage">Chargement de la base de donn&eacute;es</td>
        </tr>
      </table>
	  <table align="center">
	 <tr>
	  <td>
		<? foreach($data_out['etapes'] as $etape) { ?>		
		  <? if(stristr($etape, 'KO')) { ?>
		  <span class="MessageKo">&nbsp;&nbsp;<img src="../img/ko.gif" />&nbsp;<?=$etape?></span><br>
		  <? } ?> 
		  <? if(stristr($etape, 'OK')) { ?>
		  <span class="MessageOk">&nbsp;&nbsp;<img src="../img/ok.gif" />&nbsp;<?=$etape?></span><br>	
		  <? } ?>
		  <? if(!stristr($etape, 'OK') && !stristr($etape, 'KO')) { ?>
		  <span>&nbsp;&nbsp;&nbsp;<?=$etape?></span><br>	
		  <? } ?>
	    <? } ?> 
		<? if(!stristr($etape, 'KO')) { ?>
		<form name="formulaire" method="post" action="../../Login_Admin.php">
		 <div align="center">
		  <span class="MessageSucces">&nbsp;&nbsp;<?=$data_out['message']?></span><br>
		  <br>
		  <input name="Entrer" value="%%Travailler%%" type="submit" />
		  <input name="lang" value="<?=$lang?>" type="hidden">
		 </div>
		</form>
		<? } else { ?>
			<a href="actions.php?action=Install_Accueil">%%Recommencer%%</a>
		<? } ?>
	  </td>
	 </tr>
	</table>
    </td>
    <td width="15">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4" align="left" valign="top" height="1">
	  <img src="../../../images1/ligne_bas.gif" width="980" height="1"></td>
  </tr>
</table>
<br>
</body>
</html>
