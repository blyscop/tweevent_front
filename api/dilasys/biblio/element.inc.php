<?
if (!defined('__ELEMENT_INC__')){
define('__ELEMENT_INC__', 1);

class Element
{
   var $error;
   var $type_pere;
   var $id_pere;
   var $type_moi;
   
   function Element($type_pere = '', $id_pere = 0)
   {
      $this->type_pere = '';    
      $this->id_pere = 0;    
      $this->error = OK;
   }

   function getTypePere()
   {
      return $this->type_pere;
   }

   function getIdPere()
   {
      return $this->id_pere;
   }

   function getTypeMoi()
   {
     return $this->type_moi;
   }

   function getError()
   {
      return $this->error;
   }
   
   function isError()
   {
      return $this->error;
   }

	function setError($error)
	{
		$this->error = $error;
	}

	function setTypePere($type_pere)
	{
		$this->type_pere = $type_pere;
	}

	function setIdPere($id_pere)
	{
		$this->id_pere = $id_pere;
	}

   function toStr()
   {
      $str = "";

      if ($this->getIdPere() != "") $str .= (($str == "") ? $this->getIdPere() : ",".$this->getIdPere());
      if ($this->getTypePere() != "") $str .= (($str == "") ? $this->getTypePere() : ",".$this->getTypePere());

      $nb_elem = count($this->elements);
      for($i=0; $i<$nb_elem; $i++) {
         $elem = $this->elements[$i]->toStr();
         $str .= ($str == "") ? $elem : ",".$elem;
      }

      if ($str != "")  $str = "(".$str.")";
      return $str;
   }
}

} // Fin if (!defined('__ELEMENT__')){
?>