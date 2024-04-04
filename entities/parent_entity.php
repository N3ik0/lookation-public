<?php

    class Entity {
        protected string $_strPrefixe;

        /**
         * Méthode d'hydratation de l'objet à partir d'un tableau
         * @param @arrData : array
         */

        public function hydrate($arrData) {
            foreach ($arrData as $key=>$value) {
                $strSetterName = "set".ucfirst(str_replace($this->_strPrefixe, "", $key));
                if (method_exists($this, $strSetterName)) {
                    $this->$strSetterName($value);
                }
            }
        }
    }