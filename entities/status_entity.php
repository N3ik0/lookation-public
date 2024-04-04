<?php
	include_once("entities/parent_entity.php");
	/**
	* Classe entité de l'objet Statut (status)
	* @author Pierre
	*/	
	class Status extends Entity {
		// Propriétés
		protected string $_strPrefixe = "stat_";
		private int $_id;
		private string $_name;

		// #################################################
        // ############### Setters & Getters ###############
		// #################################################
		
        /**
		* Récupération de l'identifiant du status
		* @return $_id (integer) numéro d'identifiant du status
		*/
		public function getId() :int{
			return $this->_id;
		}
		
		/**
		* Modification de l'identifiant du status
		* @param $intId (integer) numéro d'identifiant du status
		*/
		public function setId(int $intId) {
			$this->_id = $intId;
		}
		
        /**
		* Récupération du nom du status
		* @return $_name (string) nom du status
		*/
		public function getName() :string{
			return $this->_name;
		}
		
		/**
		* Modification du nom du status
		* @param $strName (string) nom du status
		*/
		public function setName(string $strName) {
			$this->_name = $strName;
		}
	}