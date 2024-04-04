<?php
	/**
	* @author Valentin
    * @author Pierre
	*/

    // Création de la classe Error
    class ErrorCtrl extends Ctrl{
        // Création de la fonction publique pour afficher la page 404
        public function Show404(){
            // $this faisant référence au tableau de la class Ctrl qui boucle, nous assignons les clés/valeurs
            $this->_arrData["strPage"]  = "404";
            $this->_arrData["strTitle"]  = "Page non trouvée";
            $this->_arrData["strDesc"]  = "Page affichant le fait que la page demandée est introuvable";
            $this->afficheTpl("Show404");
        }        
		
		public function Show403(){
            // $this faisant référence au tableau de la class Ctrl qui boucle, nous assignons les clés/valeurs
            $this->_arrData["strPage"]  = "403";
            $this->_arrData["strTitle"]  = "Accès non autorisé";
            $this->_arrData["strDesc"]  = "Vous n'avez pas les droits suffisants pour accéder à cette page";
            $this->afficheTpl("Show403");
        }

        public function nothingtoshow(){
            // $this faisant référence au tableau de la class Ctrl qui boucle, nous assignons les clés/valeurs
            $this->_arrData["strPage"]  = "NothingToShow";
            $this->_arrData["strTitle"]  = "Accès non autorisé";
            $this->_arrData["strDesc"]  = "Vous n'avez pas les droits suffisants pour accéder à cette page";
            $this->afficheTpl("nothingtoshow");
        }
    }