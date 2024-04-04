<?php
	include_once("entities/parent_entity.php");
	/**
	* Classe entité de l'objet User (utilisateur)
	* @author Pierre
	*/	
	class User extends Entity {
		// Propriétés
		protected string $_strPrefixe = "usr_";
        private int $_id;
        private string $_login;
        private string $_password;
        private string $_name;
        private string $_firstname;
        private string  $_birthdate;
        private string $_address;
        private string $_address_comp;
        private string $_phone;
        private string $_mail;
        private string  $_signup_date;
        private int $_newsletter;
        private int $_city_id;
        private int $_stat_id;

		// #################################################
        // ############### Setters & Getters ###############
		// #################################################
		
        /**
		* Récupération de l'identifiant de l'utilisateur
		* @return $_id (integer) numéro d'identifiant de l'utilisateur
		*/
        public function getId() :int{
            return $this->_id;
        }

        /**
		* Modification de l'identifiant de l'utilisateur
		* @param $intId (integer) numéro d'identifiant de l'utilisateur
		*/
        public function setId(int $intId){
   			$this->_id = trim($intId);
			$this->_id = filter_var($intId, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération du login de l'utilisateur
		* @return $_login (string) pseudonyme
		*/
        public function getLogin() :string{
            return $this->_login;
        }

        /**
		* Modification du login de l'utilisateur
		* @param $strLogin (string) pseudonyme
		*/
        public function setLogin(string $strLogin){
			$this->_login = trim($strLogin);
			$this->_login = filter_var($strLogin, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération du mot de passe de l'utilisateur
		* @return $_password (string) mot de passe
		*/
        public function getPassword() :string{
            return $this->_password;
        }
		
		/**
		* Récupération du mot de passe (version haché) de l'utilisateur
		* @return $_password (string) mot de passe haché
		*/
        public function getPasswordHash() :string{
            return password_hash($this->_password, PASSWORD_DEFAULT);
        }

		/**
		* Modification du mot de passe de l'utilisateur
		* @param $strPassword (string) mot de passe
		*/
        public function setPassword(string $strPassword){
			$this->_password = $strPassword;
        }

        /**
		* Récupération du nom de l'utilisateur
		* @return $_name (string) nom de famille
		*/
        public function getName() :string{
            return $this->_name;
        }

		/**
		* Modification du nom de l'utilisateur
		* @param $strName (string) nom
		*/
        public function setName($strName){
			$this->_name = trim($strName);
			$this->_name = filter_var($strName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération du prénom de l'utilisateur
		* @return $_firstname (string) prénom
		*/
        public function getFirstname() :string{
            return $this->_firstname;
        }
    
	    /**
		* Modification du prénom de l'utilisateur
		* @param $strFirstname (string) prénom
		*/
        public function setFirstname(string $strFirstname){
			$this->_firstname = trim($strFirstname);
			$this->_firstname = filter_var($strFirstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération de la date de naissance de l'utilisateur
		* @return $_birthdate (string) date de naissance
		*/
        public function getBirthdate() :string{
            return $this->_birthdate;
        }

        /**
		* Modification de la date de naissance de l'utilisateur
		* @param $strBirthdate (string) date de naissance
		*/
        public function setBirthdate(string $strBirthdate){
			$this->_birthdate = trim($strBirthdate);
			$this->_birthdate = filter_var($strBirthdate, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération de l'adresse de l'utilisateur
		* @return $_address (string) adresse
		*/
        public function getAddress() :string{
            return $this->_address;
        }

        /**
		* Modification de l'adresse de l'utilisateur
		* @param $strAddress (string) adresse
		*/
        public function setAddress(string $strAddress){
			$this->_address = trim($strAddress);
			$this->_address = filter_var($strAddress, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération du complément d'adresse de l'utilisateur
		* @return $_address_comp (string) complément d'adresse
		*/
        public function getAddress_comp() :string{
            return $this->_address_comp;
        }

        /**
		* Modification du complément d'adresse de l'utilisateur
		* @param $strAddressComp (string) complément d'adresse
		*/
        public function setAddress_comp($strAddressComp){
			$this->_address_comp = trim($strAddressComp);
			$this->_address_comp = filter_var($strAddressComp, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération du numéro de téléphone de l'utilisateur
		* @return $_phone (string) numéro de téléphone
		*/
        public function getPhone() :string{
            return $this->_phone;
        }
		
        /**
		* Modification du numéro de téléphone de l'utilisateur
		* @param $strPhone (string) numéro de téléphone
		*/
        public function setPhone(string $strPhone){
			$this->_phone = trim($strPhone);
			$this->_phone = filter_var($strPhone, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération de l'adresse mail de l'utilisateur
		* @return $_mail (string) adresse e-mail
		*/
        public function getMail() :string{
            return $this->_mail;
        }

        /**
		* Modification de l'adresse mail de l'utilisateur
		* @param $strMail (string) adresse e-mail
		*/
        public function setMail(string $strMail){
			$this->_mail = trim($strMail);
			$this->_mail = filter_var($strMail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        /**
		* Récupération de la date d'inscription de l'utilisateur
		* @return $_signup_date (string) date d'inscription
		*/
        public function getSignup_date() :string{
            return $this->_signup_date;
        }

        /**
		* Modification de la date d'inscription de l'utilisateur
		* @param $strSignupDate (string) date d'inscription
		*/
        public function setSignup_date(string $strSignupDate) {
			$this->_signup_date = $strSignupDate;
        }

        /**
		* Récupération d'information d'inscription à la newsletter
		* @return $_newsletter (integer) paramètre d'inscription à la newsletter (0 = non ; 1 = oui)
		*/
        public function getNewsletter() :int{
            return $this->_newsletter;
        }

        /**
		* Modification d'information d'inscription à la newsletter
		* @param $intNewsletter (integer) paramètre d'inscription à la newsletter (0 = non ; 1 = oui)
		*/
        public function setNewsletter(int $intNewsletter){
			$this->_newsletter = $intNewsletter;
        }

        /**
		* Récupération de l'identifiant de ville de l'utilisateur
		* @return $_city_id (integer) numéro d'identifiant de la ville de l'utilisateur
		*/
        public function getCity_id() :int{
            return $this->_city_id;
        }

        /**
		* Modification de l'identifiant de ville de l'utilisateur
		* @param $intCityId (integer) numéro d'identifiant de la ville de l'utilisateur
		*/
        public function setCity_id(int $intCityId) {
  			$this->_city_id = $intCityId;
        }

        /**
		* Récupération de l'identifiant de statut de l'utilisateur
		* @return $_status_id (integer) numéro d'identifiant du status de l'utilisateur
		*/
        public function getStat_id() :int{
            return $this->_stat_id;
        }

        /**
		* Modification de l'identifiant de statut de l'utilisateur
		* @param $intStatId (integer) numéro d'identifiant du status de l'utilisateur
		*/
        public function setStat_id(int $intStatId) {
			$this->_stat_id = $intStatId;
        }
	}