<?
if (!defined('__COLLECTION_INC__')){
define('__COLLECTION_INC__', 1);

class Collection
{
   var $error;
   var $idx;
   var $elements;

   function Collection()
   {
      $this->Idx = 0;
      $this->elements = array();
   }

   function getTab()
   {
       $TAB_ELEMENTS = array();
       $copy = $this;
       $copy->Idx = 0;

      $l = $this->getElementCount();

      for($i=0; $i<$l; $i++) 
         $TAB_ELEMENTS[] = $this->elements[$i]->getTab();

       return $TAB_ELEMENTS;
   }

   function getElement($IdElement)
   {
      $l = $this->getElementCount();

      for($i=0; $i<$l; $i++) {
         if($this->elements[$i]->getId() == $IdElement) {
            return $this->elements[$i];
         }
      }
      return FALSE;
   }

   function getNextElement()
   {
      $nb_elem = count($this->elements);
      $idx = (int) $this->Idx;

      if ($idx >= $nb_elem) return FALSE;

      $this->Idx++;
      return $this->elements[$idx];
   }

   function getPosElement($IdElement)
   {
      $l = count($this->elements);
      for($i=0; $i<$l; $i++) {
         if($this->elements[$i]->getId() == $IdElement) {
             return $i;
         }
      }
      return FALSE;
   }

   function getElementCount()
   {
      return count($this->elements);
   }

   function isError()
   {
      return $this->error;
   }

	function setError($error)
	{
		$this->error = $error;
	}

   function setIdPere($id_pere)
   {
      $nb_elem = count($this->elements);

      for($i=0; $i<$nb_elem; $i++) 
         $this->elements[$i]->setIdPere($id_pere);
   }

   function setTypePere($type_pere)
   {
      $nb_elem = count($this->elements);

      for($i=0; $i<$nb_elem; $i++) 
         $this->elements[$i]->setTypePere($type_pere);
   }

	function isEmpty()
	{
      $nb_elem = count($this->elements);
      return ($nb_elem == 0) ? true : false;
	}

   function addElement($element)
   {
      $this->elements[] = $element;
   }

   function delElement($id_element)
   {
      $i = $this->getPosElement($id_element);
      $l = $this->getElementCount();

      // Obligé de faire un strcmp
      // car getIdxTelephone peut ramener un 0 qui
      // pose problème sur les tests...
      if (strcmp($i,'')) {
         $element = $this->elements[$i];

         if (($i+1) == $l)
            array_splice($this->elements,$i);
         else
            array_splice($this->elements,$i,(-$l+$i+1));

         return $element;
      }
      return FALSE;
   }

   function ADD()
   {
      $nb_elem = count($this->elements);

      for($i=0; $i<$nb_elem; $i++) {
         $element = $this->elements[$i];
         $element->ADD();
         
         if ($element->isError() == ERROR) {
            $this->setError(ERROR);
            break;
         }
      }
   }

   function DEL()
   {
      $nb_elem = count($this->elements);

      for($i=0; $i<$nb_elem; $i++) {
         $element = $this->elements[$i];
         $element->DEL();
      }
   }

   function toStr()
   {
      $str = "";

      $nb_elem = count($this->elements);
      for($i=0; $i<$nb_elem; $i++) {
         $elem = $this->elements[$i]->toStr();
         $str .= ($str == "") ? $elem : ",".$elem;
      }

      if ($str != "")  $str = "(".$str.")";
      return $str;
   }
}

} // Fin if (!defined('__COLLECTION__')){
?>