<?php
/*
   // Classe de gestion d'un objet
   // Cette classe doit être héritée
   // La classe apporte tous les setters et les getters des attributs
   // C'est une instance de cette classe qui sera passée au manager
   // Voici un exemple de classe enfant:

   class Clients extends \ProcessID\Model\Model {
      protected $IDclients;
      protected $nom;
      protected $tel;
      protected $siret;
   }
   
   
*/   
   namespace ProcessID\Model;

   abstract class Model  {
      
      // >=PHP 5.4:
      //use ProcessID\Traits\Hydrate;
      
      private $ta_setters;
      private $ta_getters;
      
      function __construct($data) {
         $this->createSettersGetters();
         $this->hydrate($data);
      }
      
      // <PHP 5.4
      protected function hydrate(array $data) {
         foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (is_callable(array($this, $method))) {
               $this->$method($value);
            }
         }
      }
      
      protected function createSettersGetters() {
         $this->ta_setters = array();
         $this->ta_getters = array();
         
         foreach ($this as $attribut=>$valeur) {
            $this->ta_setters['set' . ucfirst($attribut)] = $attribut;
            $this->ta_getters[$attribut] = $attribut;
         }
      }
      
      function __call($name,$arg) {
         if (array_key_exists($name,$this->ta_setters)) {
            // Setter
            $this->{$this->ta_setters[$name]} = $arg[0];
         }
         
         if (array_key_exists($name,$this->ta_getters)) {
            // Getter
            return $this->{$name};
         }
         
      }
   }
?>
