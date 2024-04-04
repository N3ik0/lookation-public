<?php
	/**
	* Classe entité de l'objet City (ville)
	* @author Valentin
	* @author Pierre (commentaires)
	*/	
    include_once("parent_entity.php");

	class City extends Entity{

		// Propriétés
		protected string $_strPrefixe = "city_";
		private int $_id;
		private string $_name;
		private string $_zip;


		// #################################################
        // ############### Setters & Getters ###############
		// #################################################

        /**
		* Récupération de l'identifiant de la ville
		* @return $_id (integer) numéro d'identifiant de la ville
		*/
		public function getId() :int{
			return $this->_id;
		}
		
	    /**
		* Modification de l'identifiant de la ville
		* @param $intId (integer) numéro d'identifiant de la ville
		*/
		public function setId(int $intId) {
			$this->_id = trim($intId);
			$this->_id = filter_var($intId, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

        /**
		* Récupération du nom de la ville
		* @return $_name (string) nom de la ville
		*/
		public function getName() :string{
			return $this->_name;
		}

        /**
		* Modification du nom de la ville
		* @param $strName (string) nom de la ville
		*/
		public function setName(string $strName) {
			$this->_name = trim($strName);
			$this->_name = filter_var($strName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

        /**
		* Récupération du code postal de la ville
		* @return $_zip (string) code postal de la ville
		*/
		public function getZip() :string{
			return $this->_zip;
		}

        /**
		* Modification du code postal de la ville
		* @param $strZip (string) code postal de la ville
		*/
		public function setZip(string $strZip) {
			$this->_zip = trim($strZip);
			$this->_zip = filter_var($strZip, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

	}