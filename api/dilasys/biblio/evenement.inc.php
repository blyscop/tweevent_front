<?
/*
CREATE TABLE sys_evenements (
  id_evenement int(10) NOT NULL auto_increment,
  id_utilisateur int(10) default '0',
  id_pere int(10) default '0',
  type_pere varchar(32) default NULL,
  date_evenement int(24) NOT NULL default '0',
  type_evenement varchar(32) NOT NULL default '',
  info_evenement text,
  PRIMARY KEY (id_evenement)
)
*/
if (!defined('__EVENEMENT_INC__')){
define('__EVENEMENT_INC__', 1);

class Evenement extends Element {
   var $id_evenement;
   var $id_utilisateur;
   var $type_evenement;
   var $date_evenement;
   var $info_evenement;

   function Evenement($id_utilisateur = 0, $id_pere = 0, $type_pere = '', $type_evenement = '', $info_evenement = '')
   {
      $this->id_utilisateur = $id_utilisateur;    
      $this->date_evenement = time();
      $this->info_evenement = $info_evenement;
      $this->type_evenement = $type_evenement;      
      $this->type_moi = "evenements";
      $this->type_pere = $type_pere;    
      $this->id_pere = $id_pere;               
   }

   function getId()
   {
     return $this->id_evenement;
   }

   function getIdUtilisateur()
   {
     return $this->id_utilisateur;
   }
      
   function getDateEvenement()
   {
     return $this->date_evenement;
   }

   function getTypeEvenement()
   {
     return $this->type_evenement;
   }
               
   function getInfoEvenement()
   {
     return $this->info_evenement;
   }
               
    function getTab() 
    {
        $tab['id_evenement']    = $this->id_evenement;
        $tab['id_utilisateur']  = $this->id_utilisateur;
        $tab['id_pere']         = $this->id_pere;
        $tab['type_pere']       = $this->type_pere;        
        $tab['date_evenement']  = $this->date_evenement;
        $tab['type_evenement']  = Sql_prepareTexteAffichage($this->type_evenement);        
        $tab['info_evenement']  = Sql_prepareTexteAffichage($this->info_evenement);
        
        return $tab;        
    }

   function setId($id_evenement)
   {
     $this->id_evenement = $id_evenement;
   }

   function setIdUtilisateur($id_utilisateur)
   {
     $this->id_utilisateur = $id_utilisateur;
   }

   function setDateEvenement($date_evenement)
   {
     $this->date_evenement = $date_evenement;
   }
   
   function setTypeEvenement($type_evenement)
   {
     $this->type_evenement = $type_evenement;
   }
                     
   function setInfoEvenement($info_evenement)
   {
     $this->info_evenement = $info_evenement;
   }
               
    function ADD()
    {
       $id_utilisateur  = $this->id_utilisateur;        
       $type_pere       = $this->type_pere;
       $id_pere         = ($this->id_pere == '') ? 0 : $this->id_pere;
       $date_evenement  = $this->date_evenement;
  	   $type_evenement  = Sql_prepareTexteStockage($this->type_evenement);       
  	   $info_evenement  = Sql_prepareTexteStockage($this->info_evenement);

       // Inscription de la evenement dans la table
       $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_evenements
                (id_utilisateur, id_pere, type_pere, date_evenement, type_evenement, info_evenement)
                VALUES($id_utilisateur, $id_pere, '$type_pere', $date_evenement, '$type_evenement', '$info_evenement')";

      Sql_exec($sql);  
       return;
    }

    function toStr()
    {
        $str = "";

        if ($this->getId() != "") $str .= (($str == "") ? $this->getId() : ",".$this->getId());
        if ($this->getIdUtilisateur() != "") $str .= (($str == "") ? $this->getIdUtilisateur() : ",".$this->getIdUtilisateur());
        if ($this->getIdPere() != "") $str .= (($str == "") ? $this->getIdPere() : ",".$this->getIdPere());
        if ($this->getTypePere() != "") $str .= (($str == "") ? $this->getTypePere() : ",".$this->getTypePere());
        if ($this->getDateEvenement() != "") $str .= (($str == "") ? $this->getDateEvenement() : ",".$this->getDateEvenement());
        if ($this->getTypeEvenement() != "") $str .= (($str == "") ? $this->getTypeEvenement() : ",".$this->getTypeEvenement());        
        if ($this->getInfoEvenement() != "") $str .= (($str == "") ? $this->getInfoEvenement() : ",".$this->getInfoEvenement());

        $str = "(".$str.")";
        return $str;
    }
}

/**
 Recupère toutes les données relatives à un evenement suivant son identifiant
 et retourne la coquille "Evenement" remplie avec les informations récupérées
 de la base.
 @param $id_evenement Identifiant de l'evenement à récupérer
*/
function Evenement_recuperer($id_evenement) {

   $evenement = new Evenement();

   // On récupère d'abord les données de la table evenements
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_evenements
           WHERE id_evenement = $id_evenement";

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		$row = Sql_fetch($result);
      $evenement->id_evenement = $row['id_evenement'];
      $evenement->id_utilisateur = $row['id_utilisateur'];
      $evenement->id_pere = $row['id_pere'];
      $evenement->type_pere = $row['type_pere'];
      $evenement->date_evenement = $row['date_evenement'];
      $evenement->type_evenement = Sql_prepareTexteAffichage($row['type_evenement']);      
      $evenement->info_evenement = Sql_prepareTexteAffichage($row['info_evenement']);   
   }
   
   return $evenement;
}

/**
 Renvoie la liste des événements vérifiant les conditions passées en argument sous forme d'un tableau
 @param $id_evenement Identifiant de l'evenement a chercher
 ...
*/
function Evenements_chercher($id_utilisateur = '', $type_pere = '', $id_pere = '', $date_evenement = '', $type_evenement = '', $info_evenement = '')
{
   $tab_result = array();

   $sql = " SELECT distinct(id_evenement), id_utilisateur, date_evenement, type_pere, id_pere, type_evenement, info_evenement
          FROM ".$GLOBALS['prefix']."sys_evenements
          WHERE 1";

   if ("$id_utilisateur" == "" && $type_pere == "" && "$id_pere" == "" && 
       "$date_evenement" == "" && $type_evenement == "" && 
       $type_evenement == "" && $info_evenement == "") 
       return $tab_result;

   $condition="";

   if ( "$id_utilisateur" != "" && "$id_utilisateur" != "*") $condition .= " AND id_utilisateur = $id_utilisateur ";
   if ( $type_pere != "" && $type_pere != "*") $condition .= " AND type_pere = '$type_pere' ";
   if ( "$id_pere" != "" && "$id_pere" != "*") $condition .= " AND id_pere = $id_pere ";
   if ( "$date_evenement" != "" && "$date_evenement" != "*") $condition .= " AND date_evenement = $date_evenement ";
   if ( $type_evenement != "" && $type_evenement != "*") $condition .= " AND type_evenement = '$type_evenement' ";
   if ( $info_evenement != "" && $info_evenement != "*") $condition .= " AND info_evenement = '$info_evenement' ";

   $condition .= " ORDER by date_evenement ASC";
   $sql .= $condition;

	$result = Sql_query($sql);

	if ($result && Sql_errorCode($result) === "00000") {
		while($row = Sql_fetch($result)) {
         $tab_result[$row->id_evenement]["id_utilisateur"] = $row['id_utilisateur']; 
         $tab_result[$row->id_evenement]["type_pere"]      = $row['type_pere'];         
         $tab_result[$row->id_evenement]["id_pere"]        = $row['id_pere'];         
         $tab_result[$row->id_evenement]["id_evenement"]   = $row['id_evenement'];
         $tab_result[$row->id_evenement]["date_evenement"] = $row['date_evenement'];
         $tab_result[$row->id_evenement]["type_evenement"] = Sql_prepareTexteAffichage($row['type_evenement']);
         $tab_result[$row->id_evenement]["info_evenement"] = Sql_prepareTexteAffichage($row['info_evenement']);
      }
   }   

   if (count($tab_result) == 1 && ($type_pere != '' && '$id_pere' != '' && $type_evenement != '' && $info_evenement != '')) 
      $tab_result = array_pop($tab_result);
   return $tab_result;
}

function Evenement_ajout($id_utilisateur, $id_pere, $type_pere, $type_evenement, $info_evenement = '') {

    $evenement = new Evenement($id_utilisateur, $id_pere, $type_pere, $type_evenement, $info_evenement);
    $evenement->ADD();      
    return $evenement;
}

} // Fin if (!defined('__EVENEMENT_INC__')){
?>