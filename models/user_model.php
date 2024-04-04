<?php
	include_once("connect.php");
	
	/**
	* Classe pour récupérer les informations utilisateurs dans la BDD 
	* @author Pierre
	*/
	
	class UserModel extends Model {
		
		/**
		* Constructeur de la classe
		*/
		public function __construct () {
			parent::__construct();
		}
		
		/**
		* Connexion à un compte utilisateur existant
		* @param $strLogin (string) Identifiant de l'utilisateur
		* @param $strPassword (string) Mot de passe de l'utilisateur
		* @return $arrUser (array) Tableau contenant les informations de l'utilisateur (si connexion OK)
		* @return false (boolean) Booléan à faux si les identifiants de connexion ne sont pas bons
		*/
		public function checkLogin(string $strLogin, string $strPassword){
			$strQuery = "SELECT usr_id, usr_login, usr_password, stat_name, city_id, city_name
						FROM user
						INNER JOIN city ON user.usr_city_id = city.city_id
						INNER JOIN status ON user.usr_stat_id = status.stat_id
						WHERE usr_login = :login;";
			$prep = $this->_db->prepare($strQuery);
			$prep->bindValue(":login", $strLogin, PDO::PARAM_STR);
			$prep->execute();
			$arrUser = $prep->fetch();
			if(is_array($arrUser) && password_verify($strPassword, $arrUser['usr_password'])){
				unset($arrUser['usr_password']); // effacer le MDP du tableau pour ne pas qu'il passe en session
				return $arrUser;
			}
			else {
				return false;
			}
		}
		
		/**
		* Récupération des informations de tous les utilisateurs de la base
		* @return (array) tableau d'utilisateurs contenant les informations de tous les utilisateurs dans la base de données
		*/
		public function findAll(){
			$strQuery =    "SELECT usr_id, usr_login, usr_name, usr_firstname, usr_birthdate, usr_signup_date, usr_address, usr_address_comp, usr_phone, usr_mail, usr_newsletter, usr_city_id, usr_stat_id, city_id, city_name
                            FROM user 
							INNER JOIN city ON advert.adv_city_id = city.city_id
                            ORDER BY usr_id ASC;";
			return $this->_db->query($strQuery)->fetchAll();
		}

		/**
		* Récupération des informations d'un utilisateur d'après son ID
		* @param $intFindUserId (integer) numéro d'identifiant de l'utilisateur 
		* @return $arrUser (array) tableau d'utilisateur contenant les informations
		*/
		public function findUser(int $intFindUserId){
			$strQuery =    "SELECT usr_login, usr_name, usr_firstname, usr_birthdate, usr_address, usr_address_comp, usr_phone, usr_mail, usr_newsletter, city_id, city_name, city_zip, usr_stat_id, usr_password, usr_signup_date, usr_city_id
                            FROM user 
                            INNER JOIN city ON user.usr_city_id = city.city_id
                            WHERE usr_id = :findUsr;";
			$prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":findUsr", $intFindUserId, PDO::PARAM_INT);
            $prep->execute();
            $arrUser = $prep->fetch();
			return $arrUser;
		}
		
		/**
		* Vérification si un login est bien unique dans la base de données
		* @param $strLogin (string) potentiel login de l'utilisateur qui souhaite s'inscrire
		* @return (integer) nombre de résultats trouvés sur la recherche par login. Si 0 : le login n'existe pas encore dans la base ; si 1 : le login existe déjà dans la base
		*/
		public function uniqueLogin(string $strLogin){
			$strQuery =		"SELECT usr_firstname
							FROM user
							WHERE usr_login = :login;";
			$prep = $this->_db->prepare($strQuery);
			$prep->bindValue(":login", $strLogin, PDO::PARAM_STR);
			$prep->execute();
			return $prep->rowCount();
		}
		
		/**
		* Vérification si un e-mail est bien unique dans la base de données
		* @param $strMail (string) potentiel e-mail de l'utilisateur qui souhaite s'inscrire
		* @return (integer) nombre de résultats trouvés sur la recherche par mail. Si 0 : le mail n'existe pas encore dans la base ; si 1 : le mail existe déjà dans la base
		*/
		public function uniqueMail(string $strMail){
			$strQuery =		"SELECT usr_firstname
							FROM user
							WHERE usr_mail = :mail;";
			$prep = $this->_db->prepare($strQuery);
			$prep->bindValue(":mail", $strMail, PDO::PARAM_STR);
			$prep->execute();
			return $prep->rowCount();
		}
		
		/**
		* Création d'un nouvel utilisateur
		* @param $objUser (object) objet contenant toutes les informations nécessaires à la création du compte
		* @return $arrUser tableau d'utilisateur contenant les informations ci-dessus
		* La date d'inscription au site est récupérée automatiquement au moment de la souscription au formulaire
		* De base, un utilisateur fraîchement créé est forcément assigné au rang d'utilisateur ''classique'', des droits plus élevés devront lui être octroyé par la suite si besoin
        */ 
        public function addUser(object $objUser){
            $strQuery =    "INSERT INTO user (usr_login, usr_password, usr_name, usr_firstname, usr_birthdate, usr_address, usr_address_comp, usr_phone, usr_mail, usr_newsletter, usr_city_id, usr_signup_date, usr_stat_id)
                            VALUES (:uLogin, :uPassword, :uName, :uFirstname, :uBirthdate, :uAddress, :uAddressComp, :uPhone, :uMail, :uNewsletter, :uCityId, NOW(), 3);";
            $prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":uLogin", $objUser->getLogin(), PDO::PARAM_STR);
			$prep->bindValue(":uPassword", $objUser->getPassword(), PDO::PARAM_STR);
            $prep->bindValue(":uName", $objUser->getName(), PDO::PARAM_STR);
            $prep->bindValue(":uFirstname", $objUser->getFirstname(), PDO::PARAM_STR);
            $prep->bindValue(":uBirthdate", $objUser->getBirthdate(), PDO::PARAM_STR);
            $prep->bindValue(":uAddress", $objUser->getAddress(), PDO::PARAM_STR);
            $prep->bindValue(":uAddressComp", $objUser->getAddress_comp(), PDO::PARAM_STR);
            $prep->bindValue(":uPhone", $objUser->getPhone(), PDO::PARAM_STR);
            $prep->bindValue(":uMail", $objUser->getMail(), PDO::PARAM_STR);
            $prep->bindValue(":uNewsletter", $objUser->getNewsletter(), PDO::PARAM_INT);
            $prep->bindValue(":uCityId", $objUser->getCity_id(), PDO::PARAM_INT);
            $prep->execute();
        }
		
		/**
		* Mise à jour des informations de profil d'un utilisateur
		* @param $objUser (object) objet contenant toutes les informations de l'utilisateur à mettre à jour en base de données
		* @return (boolean/string) booléen à true si la requête s'est bien passée, ou message d'erreur s'il y a eu une erreur
		*/
			
		public function editUser(object $objUser){
			
			$strQuery = "UPDATE user SET usr_login = :uLogin,";
			if ($objUser->getPassword() != ""){
				$strQuery .= " usr_password = :uPassword,";
			}
			$strQuery .= " usr_name = :uName, usr_firstname = :uFirstname, usr_birthdate = :uBirthdate,	usr_address = :uAddress, usr_address_comp = :uAddressComp, usr_phone = :uPhone,	usr_mail = :uMail, usr_newsletter = :uNewsletter WHERE usr_id = :uId;";
			$prep = $this->_db->prepare($strQuery);
			$prep->bindValue(":uLogin", $objUser->getLogin(), PDO::PARAM_STR);
			if ($objUser->getPassword() != ""){
				$prep->bindValue(":uPassword", $objUser->getPassword(), PDO::PARAM_STR);
			}
			$prep->bindValue(":uName", $objUser->getName(), PDO::PARAM_STR);
			$prep->bindValue(":uFirstname", $objUser->getFirstname(), PDO::PARAM_STR);
			$prep->bindValue(":uBirthdate", $objUser->getBirthdate(), PDO::PARAM_STR);
			$prep->bindValue(":uAddress", $objUser->getAddress(), PDO::PARAM_STR);
			$prep->bindValue(":uAddressComp", $objUser->getAddress_comp(), PDO::PARAM_STR);
			$prep->bindValue(":uPhone", $objUser->getPhone(), PDO::PARAM_STR);
			$prep->bindValue(":uMail", $objUser->getMail(), PDO::PARAM_STR);
			$prep->bindValue(":uNewsletter", $objUser->getNewsletter(), PDO::PARAM_INT);
			$prep->bindValue(":uId", $objUser->getId(), PDO::PARAM_INT);
			
			return $prep->execute();
		}
		/**
		* Suppression d'un utilisateur d'après son ID
		* @param $intUser (integer) numéro d'identifiant de l'utilisateur 
		*/
        public function deleteUser(int $intUser){
            $strQuery = "DELETE FROM user
                        WHERE usr_id = :usrId;";
            $prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":usrId", $intUser, PDO::PARAM_INT);
            $prep->execute();
        }
     
		/**
		* Changement du statut d'un utilisateur
		* @param $intUser (integer) numéro d'identifiant de l'utilisateur 
		* @param $intNewStatus (integer) numéro d'identifiant du nouveau statut à octroyer à l'utilisateur
		*/
        public function setStatusUser(int $intUser, int $intNewStatus){
			$strQuery = "UPDATE user
                        SET usr_stat_id = :newStatus
                        WHERE usr_id = :usrId;";
			$prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":newStatus", $intNewStatus, PDO::PARAM_INT);
            $prep->bindValue(":usrId", $intUser, PDO::PARAM_INT);
            $prep->execute();
        }
	}