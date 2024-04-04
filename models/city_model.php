<?php
    include_once("connect.php");

	/**
	* Récupérer les informations des villes dans la base de données
	* @author Pierre
	*/
	
    class CityModel extends Model {

		/**
		* Constructeur de la classe
		*/
        public function __construct (){
            parent::__construct();
        }

		/**
		* Récupération des informations de toutes les villes de la base
		* @return $arrCity (array) tableau des villes contenant les informations de toutes les villes dans la base de données
		*/
        public function findAll(){
            $strQuery = "SELECT city_id, city_name, city_zip
                        FROM city
                        ORDER BY city_name ASC;";
			$arrCity = $this->_db->query($strQuery)->fetchAll();
            return $arrCity;
        }
		
		/**
		* Récupération des informations d'une ville à partir d'un identifiant utilisateur qui y est lié
		* @param $intUserId (integer) numéro d'identifiant de l'utilisateur lié à la ville
		* @return $arrCity (array) tableau contenant les informations de la ville où habite l'utilisateur
		*/
		public function findCity(int $intUsrId){
            $strQuery = "SELECT city_id, city_name, city_zip
                        FROM city
							INNER JOIN user ON user.usr_city_id = city.city_id
                        WHERE usr_id = :usrId;";
			$prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":usrId", $intUsrId, PDO::PARAM_INT);
            $prep->execute();
            $arrCity = $prep->fetch();
            return $arrCity;
        }

		/**
		* Vérification de l'existence ou non d'un couple ville / code postal dans la base de données
		* @param $obbCity (object) objet ville contenant les informations nécessaires à l'insertion dans la base
		* @return $arrCityId (array) tableau contenant l'ID correspond au couple ville / code postal. S'il est à -1, cela veut dire que la ville n'existe pas dans la base de données
		*/
		public function checkCity(object $objCity){
			$strQuery = "SELECT city_id
						FROM city
						WHERE city_name = :cityName
						AND city_zip = :cityZip;";
			$prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":cityName", $objCity->getName(), PDO::PARAM_STR);
			$prep->bindValue(":cityZip", $objCity->getZip(), PDO::PARAM_STR);
            $prep->execute();
			$arrCityId = $prep->fetch();
			return $arrCityId;
		}
		
		/**
		* Ajout d'un couple ville / code postal dans la base de données
		* Cette fonction appelle la fonction checkCity() afin d'éviter les doublons dans la base
		* @param $obbCity (object) objet ville contenant les informations nécessaires à l'insertion dans la base
		* @return $intLastId (integer) identifiant du couple ville / code postal fraîchement inséré
		*/
		public function addCity(object $objCity){
			$intCountCity = $this->checkCity($objCity);
			// Si le retour est 0, le couple ville / code postal n'existe pas encore dans la base
			// On peut donc ajouter ledit couple dans la base de données
			if ($intCountCity == 0) {			
				$strQuery = "INSERT INTO city (city_name, city_zip)
							VALUES (:cityName, :cityZip);";
				$prep = $this->_db->prepare($strQuery);
				$prep->bindValue(":cityName", $objCity->getName(), PDO::PARAM_STR);
				$prep->bindValue(":cityZip", $objCity->getZip(), PDO::PARAM_STR);
				$prep->execute();
				$intLastId = $this->_db->lastInsertId(); // lastInsertId() retourne null, et je ne sais pas pourquoi
				return $intLastId;
			}
		}
		
		/**
		* Fonction remplaçant lastInsertId() pour récupérer l'identifiant de la dernière ville insérée
		* À supprimer (+ adapter le code dans le user_controller) une fois que le lastInsertId() de la fonction addCity() fonctionnera correctement
		* @return $intLastId (integer) identifiant du dernier couple ville / code postal inséré
		*/
		public function lastCityId(){
			$strQuery = "SELECT city_id FROM city ORDER BY city_id DESC LIMIT 1;";
			$arrLastId = $this->_db->query($strQuery)->fetch();
			$intLastId = intval($arrLastId["city_id"]);
			return $intLastId;
		}
    }