<?
/*
CREATE TABLE test_sys_groupes (
  id_groupe int(11) NOT NULL auto_increment,
  nom_groupe varchar(32) NOT NULL default '',
  nb_connect_defaut int(11) NOT NULL default '1',
  effacable enum('0','1') NOT NULL default '1',
  modifiable enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (id_groupe)
)
*/
if (!defined('__GROUPE_INC__')){
define('__GROUPE_INC__', 1);

class Groupe extends Element {
   var $id_groupe;
   var $nom_groupe;
   var $nb_connect_defaut;
   var $modules;
   var $droits;
   
	// Crée un nouveau groupe
	function Groupe($id_groupe = '', $nom_groupe = '', $nb_connect_defaut = 1)
	{
      $this->id_groupe         = $id_groupe;
      $this->nom_groupe        = $nom_groupe;
      $this->nb_connect_defaut = $nb_connect_defaut;
      $this->modules           = array();
      $this->droits            = array();
      $this->type_moi          = 'groupes';
	}

   function getTab() 
   {

       $tab['id_groupe']         = $this->id_groupe;
       $tab['nom_groupe']        = $this->nom_groupe;
       $tab['nb_connect_defaut'] = $this->nb_connect_defaut;
       $tab['modules']           = array();
       $tab['droits']            = array();

       foreach ($this->modules as $module) 
          $tab['modules'][] = $module; 
       foreach ($this->droits as $champ => $droits) 
          $tab['droits'][$champ] = $droits; 

       return $tab;       
   }

   function setError($error)
   {
      $this->error = $error;
   }


    function ADD()
    {
       $nom_groupe        = $this->nom_groupe;
       $nb_connect_defaut = ($this->nb_connect_defaut != '') ? $this->nb_connect_defaut : 10;
       
       // Inscription du groupe dans la table
       $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_groupes
                (nom_groupe, nb_connect_defaut)
                VALUES('$nom_groupe', $nb_connect_defaut)";

      if (!Sql_exec($sql)) $this->setError(ERROR); 
      
       if (!$this->isError()) {
           $id_groupe = Sql_lastInsertId();
           Lib_sqlLog($sql." -- $id_groupe");
           $this->id_groupe = $id_groupe;
           $id_groupe;
       }

       // Inscription des modules dans la base        
       foreach ($this->modules as $module) {
          $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_groupes_modules
                (nom_groupe, module)
                VALUES('$nom_groupe', '$module')";

	       Sql_exec($sql); 
	       Lib_sqlLog($sql);
       }

       // Inscription des droits dans la base        
       foreach ($this->droits as $champ => $droits) {
          $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_groupes_droits
                (nom_groupe, champ, droits)
                VALUES('$nom_groupe', '$champ', $droits)";

	       Sql_exec($sql); 
	       Lib_sqlLog($sql);
       }       

       return $id_groupe;
    }

    function UPD() {

       $id_groupe         = $this->id_groupe;
       $nom_groupe        = $this->nom_groupe;
       $nb_connect_defaut = ($this->nb_connect_defaut != '') ? $this->nb_connect_defaut : 10;

       // Mise à jour de la base
       $sql = " UPDATE ".$GLOBALS['prefix']."sys_groupes
                SET nom_groupe = '$nom_groupe', nb_connect_defaut = $nb_connect_defaut 
                WHERE id_groupe = $id_groupe";

       Sql_exec($sql); 
       Lib_sqlLog($sql);
       
       // Mise à jour de la base pour les modules
       // Tout d'abord, on supprime tous les anciens modules
       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_groupes_modules
                WHERE nom_groupe = '$nom_groupe'";

       Sql_exec($sql); 
       Lib_sqlLog($sql);

       // Puis on insère les nouveaux modules
       foreach ($this->modules as $module) {                   
          $sql = "INSERT INTO ".$GLOBALS['prefix']."sys_groupes_modules
                  (nom_groupe, module)
                  VALUES('$nom_groupe', '$module')";

	       Sql_exec($sql); 
	       Lib_sqlLog($sql);
       }

       // Mise à jour de la base pour les droits
       // Tout d'abord, on supprime tous les anciens droits
       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_groupes_droits
                WHERE nom_groupe = '$nom_groupe'";

       Sql_exec($sql); 
       Lib_sqlLog($sql);

       // Puis on insère les nouveaux droits
       foreach ($this->droits as $champ => $droits) {
          $sql = " INSERT INTO ".$GLOBALS['prefix']."sys_groupes_droits
                (nom_groupe, champ, droits)
                VALUES('$nom_groupe', '$champ', $droits)";

	       Sql_exec($sql); 
	       Lib_sqlLog($sql);
       }
       
       return;
   }

    function DEL() {

       $id_groupe = $this->id_groupe;
       $nom_groupe = $this->nom_groupe;

       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_groupes
                WHERE id_groupe = $id_groupe
                AND effacable = '1'";

       Sql_exec($sql); 
       Lib_sqlLog($sql);

       // Puis on supprime tous les modules
       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_groupes_modules
                WHERE nom_groupe = '$nom_groupe'";

       Sql_exec($sql); 
       Lib_sqlLog($sql);

       // Puis on supprime tous les droits
       $sql = " DELETE FROM ".$GLOBALS['prefix']."sys_groupes_droits
                WHERE nom_groupe = '$nom_groupe'";

       Sql_exec($sql); 
       Lib_sqlLog($sql);
       
       return;
    }

    function addModule($new_module)
    {
       $ajouter = true;
       foreach($this->modules as $module)
          if ($module == $new_module) $ajouter = false;
    
       if ($ajouter)
          $this->modules[] = $new_module;
    }

    function delModule($module_to_del)
    {
       $old_modules = $this->modules;
       $this->modules = array();

       foreach ($old_modules as $module) {
          if ($module == $module_to_del) continue;
          $this->modules[] = $module; 
       }
    }    
    
    function addDroits($new_champ, $droits)
    {
       $ajouter = true;
       foreach($this->droits as $champ => $droits)
          if ($champ == $new_champ) $ajouter = false;
       
       if ($ajouter)
          $this->droits[$new_champ] = $droits;
    }    

    function delDroits($champ_to_del)
    {
       $old_droits = $this->droits;
       $this->droits = array();

       foreach ($old_droits as $champ => $droits) {
          if ($champ == $champ_to_del) continue;
          $this->droits[$champ] = $droits; 
       }
    }        
    
    function toStr()
    {
        $str = "";

        if ($this->id_groupe != "")            $str .= (($str == "") ? $this->id_groupe : ",".$this->id_groupe);
        if ($this->nom_groupe() != "")       $str .= (($str == "") ? $this->nom_groupe() : ",".$this->nom_groupe);
        if ($this->nb_connect_defaut() != "") $str .= (($str == "") ? $this->nb_connect_defaut() : ",".$this->nb_connect_defaut());

        $str = "(".$str.")";
        return $str;
    }
}

/**
 Recupère toutes les données relatives à un groupe suivant son identifiant
 et retourne la coquille "Groupe" remplie avec les informations récupérées
 de la base.
*/
function Groupe_recuperer($arg) {

   $groupe = new Groupe();

   // On récupère d'abord les données de la table groupes
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_groupes
           WHERE 1";
           
  $condition = "";
  $condition = (is_numeric($arg)) ? " AND id_groupe = '$arg'" : " AND nom_groupe = '$arg'";
  $sql.=$condition;
  
   $result = Sql_query($sql);

	$row = Sql_fetch($result);
   $groupe->id_groupe = $row['id_groupe'];
   $groupe->nom_groupe = $row['nom_groupe'];
   $groupe->nb_connect_defaut = $row['nb_connect_defaut'];
   $nom_groupe = $row['nom_groupe'];
   
   // On récupère ensuite les données de la table modules
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_groupes_modules
           WHERE nom_groupe = '$nom_groupe'";

   $result = Sql_query($sql);

   if ($result && Sql_errorCode($result) === "00000") {
      while($row = Sql_fetch($result)) {
         $groupe->addModule($row['module']);
      }
   }

   // On récupère ensuite les données de la table des droits
   $sql = "SELECT *
           FROM ".$GLOBALS['prefix']."sys_groupes_droits
           WHERE nom_groupe = '$nom_groupe'";

   $result = Sql_query($sql);

   if ($result && Sql_errorCode($result) === "00000") {
      while($row = Sql_fetch($result)) {
         $groupe->addDroits($row['champ'], $row['droits']);
      }
   }

   return $groupe;
}

/**
 Renvoie le nom et l'identifiant des groupes ayant les données passées en argument sous forme d'un tableau
 @param nom_groupe
 ...
*/
function Groupes_chercher($nom_groupe = '')
{
   $tab_result = array();

   $sql = " SELECT *
          FROM ".$GLOBALS['prefix']."sys_groupes
          WHERE modifiable = '1'";

   if ($nom_groupe == "") return $tab_result;

   $condition = "";
   if ( $nom_groupe != "" && $nom_groupe != "*") $condition .= " AND nom_groupe = '$nom_groupe' ";
   $condition .= " ORDER by id_groupe ASC";
   
   $sql .= $condition;
   $result = Sql_query($sql);

   if ($result && Sql_errorCode($result) === "00000") {
      while($row = Sql_fetch($result)) {
         $tab_result[$row['id_groupe']]['id_groupe'] = $row['id_groupe'];      
         $tab_result[$row['id_groupe']]['nom_groupe'] = $row['nom_groupe'];
         $tab_result[$row['id_groupe']]['nb_connect_defaut'] = $row['nb_connect_defaut'];
         $tab_result[$row['id_groupe']]['effacable'] = $row['effacable'];
         $tab_result[$row['id_groupe']]['modifiable'] = $row['modifiable'];         
			$tab_result[$row['id_groupe']]['modules'] = array();
			$tab_result[$row['id_groupe']]['droits'] = array();

         // On récupère ensuite les données de la table modules
         $sql2 = "SELECT *
                 FROM ".$GLOBALS['prefix']."sys_groupes_modules
                 WHERE nom_groupe = '{$row->nom_groupe}'";

   		$result2 = Sql_query($sql2);
    
         if ($result2) {
            while($row2 = Sql_fetch($result2)) {
               $tab_result[$row['id_groupe']]['modules'][] = $row2['module'];
            }
         }
         
         // On récupère ensuite les données de la table des droits
         $sql3 = "SELECT *
                 FROM ".$GLOBALS['prefix']."sys_groupes_droits
                 WHERE nom_groupe = '{$row->nom_groupe}'";

   		$result3 = Sql_query($sql3);

         if ($result3) {
            while($row3 = Sql_fetch($result3)) {
               $tab_result[$row['id_groupe']]['droits'][$row3->champ] = $row3['droits'];
            }
         }                  
      }
   }

   if (count($tab_result) == 1 && ($nom_groupe != '' && $nom_groupe != '*')) 
      $tab_result = array_pop($tab_result);   
   return $tab_result;
}

} // Fin if (!defined('__GROUPE_INC__')){
?>