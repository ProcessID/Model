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

    // Lors de l'ajout d'une colonne à une table, il faut créer la variable dans le modèle avant de créer la colonne en BD pour ne pas avoir d'erreur. Attention cependant à ce que modèle et BD soient à jour avant de faire appel à cette nouvelle colonne dans le code.
    // Lors de la suppression d'une colonne d'une table, il faut la supprimer en BD avant de supprimer la variable dans le modèle. Il faut auparavant supprimer tout appel à cette colonne dans le code avant de modifier BD et modèle.
    */   
    namespace processid\model;

    abstract class Model  {
        use \processid\traits\Hydrate;

        private $ta_setters;
        private $ta_getters;

        function __construct($data = array()) {
            $this->createSettersGetters();
            $this->hydrate($data);
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
            elseif (array_key_exists($name,$this->ta_getters)) {
                // Getter
                return $this->{$name};
            }
            else {
                trigger_error($name . '() introuvable dans la classe ' . get_class($this),E_USER_ERROR);
            }
        }
    }
?>