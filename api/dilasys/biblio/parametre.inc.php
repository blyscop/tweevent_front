<?
/*
CREATE TABLE sys_parametres (
  id_utilisateur int(10) NOT NULL default '1',
  code_parametre varchar(32) NOT NULL default '',
  type_parametre enum('materiel') NOT NULL default 'materiel',
  designation varchar(64) default NULL,
  etat enum('actif','inactif') NOT NULL default 'actif',
  info_parametre text,
  PRIMARY KEY  (code_parametre,id_utilisateur)
) TYPE=MyISAM;
*/
if (!defined('__PARAMETRE_INC__')){
define('__PARAMETRE_INC__', 1);

class Parametre extends Element {
   var $id_utilisateur;
   var $code_parametre;
   var $type_parametre;
   var $designation;
   var $etat;
   var $info_parametre;

    function Parametre($id_utilisateur = '', $code_parametre = '', $type_parametre = '', $designation = '', $etat = '', $info_parametre = '')
    {
        $this->id_utilisateur     = $id_utilisateur;
        $this->code_parametre     = $code_parametre;
        $this->type_parametre     = $type_parametre;
        $this->designation        = $designation;        
        $this->etat               = $etat;
        $this->info_parametre     = $info_parametre;
        $this->type_parametre_moi = 'parametres';
    } 
	
   function getTab() 
   {
       $tab['id_utilisateur'] = $this->id_utilisateur;
       $tab['code_parametre'] = $this->code_parametre;
       $tab['type_parametre'] = $this->type_parametre;
       $tab['designation']    = $this->designation; 
       $tab['etat']           = $this->etat;
       $tab['info_parametre'] = $this->info_parametre;
       
       return $tab;    
   }
   
    function ADD()
    {
       $id_utilisateur   = $this->id_utilisateur;
       $code_parametre   = $this->code_parametre;
       $type_parametre   = $this->type_parametre;
       $designation      = $this->designation;
       $etat             = $this->etat;
       $info_parametre   = Sql_prepareTexteStockage($this->info_parametre);
     
       // Inscription de l'utilisateur dans la table
       $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_parametres
                (id_utilisateur, code_parametre, type_parametre, designation, etat, info_parametre)
                VALUES($id_utilisateur, '$code_parametre', '$type_parametre', '$designation', '$etat', '$info_parametre')";

		 if (!Sql_exec($sql)) $this->setError(ERROR); 
		 if (!$this->isError()) Lib_sqlLog($sql);

       return $code_parametre;
    }

    function UPD() 
    {
       $id_utilisateur   = $this->id_utilisateur;
       $code_parametre   = $this->code_parametre; 
       $type_parametre   = $this->type_parametre;
       $designation      = $this->designation;
       $etat             = $this->etat;
       $info_parametre   = Sql_prepareTexteStockage($this->info_parametre);
         	   
       // Mise à jour de la base
       $sql = " UPDATE ".$GLOBALS['prefix']."sys_parametres
                SET type_parametre = '$type_parametre', designation = '$designation', 
                etat = '$etat', info_parametre = '$info_parametre'
                WHERE code_parametre = '$code_parametre'
                AND id_utilisateur = $id_utilisateur";

		 if (!Sql_exec($sql)) $this->setError(ERROR); 
		 if (!$this->isError()) Lib_sqlLog($sql);

       return;
   }  	   

    function DEL() {

       $code_parametre = $this->code_parametre;

       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_parametres
                WHERE code_parametre = '$code_parametre'
                AND id_utilisateur = $id_utilisateur";

		 if (!Sql_exec($sql)) $this->setError(ERROR); 
		 if (!$this->isError()) Lib_sqlLog($sql);
       
       return;
    }
  	   
    function ToStr()
    {
        $str = "";

        if ($this->id_utilisateur() != "") $str .= (($str == "") ? $this->id_utilisateur() : ",".$this->id_utilisateur());
        if ($this->code_parametre() != "") $str .= (($str == "") ? $this->code_parametre() : ",".$this->code_parametre());
        if ($this->type_parametre() != "") $str .= (($str == "") ? $this->type_parametre() : ",".$this->type_parametre());
        if ($this->designation() != "")   $str .= (($str == "") ? $this->designation() : ",".$this->designation());
        if ($this->etat() != "")          $str .= (($str == "") ?  $this->etat() : ",".$this->etat());
        if ($this->info_pParametre() != "") $str .= (($str == "") ? $this->info_parametre() : ",".$this->info_parametre());
                
        $str = "(".$str.")";
        return $str;
    }
}

/**
 Récupere les compétences pour un id et un type_parametre
 /param id
*/
function Parametre_recuperer($code_parametre) {

   $parametre = new Parametre();

   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_parametres
           WHERE code_parametre = '$code_parametre'";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
      $parametre->id_utilisateur = $row['id_utilisateur'];
      $parametre->code_parametre = $row['code_parametre'];
      $parametre->type_parametre = $row['type_parametre'];
      $parametre->designation = $row['designation']; 
      $parametre->etat = $row['etat'];
      $parametre->info_parametre = Sql_prepareTexteAffichage($row['info_parametre']);  
   }
   
   return $parametre;
}


/**
    Récupère tous les identifiants verifiant le etat fourni
    /param etat
    /param type_parametre
*/
function Parametres_chercher($id_utilisateur = '', $code_parametre = '', $type_parametre = '', $designation = '', $etat = '') {

   $tab_result = array();

   $sql = " SELECT distinct(code_parametre), type_parametre, designation, etat, info_parametre
            FROM ".$GLOBALS['prefix']."sys_parametres
            WHERE 1";

   if ("$id_utilisateur" == "" &&
       $code_parametre == "" && 
       $etat == "" && 
       $type_parametre == "" &&
       $designation == "") return $tab_result;

   $condition="";

   if ( $id_utilisateur != "" && $id_utilisateur != "*") $condition .= " AND id_utilisateur = $id_utilisateur ";
   if ( $code_parametre != "" && $code_parametre != "*") $condition .= " AND code_parametre = '$code_parametre' ";
   if ( $etat != "" && $etat != "*") $condition .= " AND etat = '$etat' ";
   if ( $type_parametre != "" && $type_parametre != "*") $condition .= " AND type_parametre = '$type_parametre' ";
   if ( $designation != "" && $designation != "*") $condition .= " AND designation LIKE '%$designation%' ";

   $sql .= $condition;
	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
      $i = 0;
		while($row = Sql_fetch($result)) {
         $tab_result[$i]["id_utilisateur"]   = $row['id_utilisateur'];
         $tab_result[$i]["code_parametre"]   = $row['code_parametre'];        
         $tab_result[$i]["type_parametre"]   = $row['type_parametre'];
         $tab_result[$i]["designation"]      = $row['designation'];
         $tab_result[$i]["etat"]             = $row['etat'];  
         $tab_result[$i]["info_parametre"]   = Sql_prepareTexteAffichage($row['info_parametre']);
         $i++;
      }
   }
   
   if (count($tab_result) == 1 && ($code_parametre != '' && "$id_utilisateur" != '*')) 
      $tab_result = array_pop($tab_result);   
   return $tab_result;
}

} // Fin if (!defined('__PARAMETRE_INC__')){
?>