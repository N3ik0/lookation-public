<?php
	include_once("connect.php");
	
	/**
	* Classe pour récupérer les informations des statuts utilisateurs
	* @author Pierre
	*/
	class StatusModel extends Model{

		/**
		* Constructeur de la classe
		*/
		public function __construct (){
			parent::__construct();
		}
		
		/**
		* Récupération des informations de tous les status de la base
		* @return $arrStatus (array) tableau des status contenant les informations de tous les status
		*/
		public function findAll(){
			$strQuery = "SELECT stat_id, stat_name
						FROM status
						ORDER BY stat_name DESC;";
			$arrStatus = $this->_db->query($strQuery)->fetchAll();
			return $arrStatus;
		}
		
		/**
		* Récupération des informations d'un nom de status lié à un identifiant utilisateur
		* @param $intUserId (integer) numéro d'identifiant de l'utilisateur dont on souhaite connaître le status
		* @return $arrStatus (array) tableau contenant le nom du status de l'utilisateur passé en paramètre
		*/
		public function findStatus(int $intUserId){
			$strQuery =    "SELECT stat_id, stat_name
							FROM status
								INNER JOIN user ON user.usr_stat_id = status.stat_id
							WHERE usr_id = :usrId;";

			$prep = $this->_db->prepare($strQuery);
            $prep->bindValue(":usrId", $intUserId, PDO::PARAM_INT);
            $prep->execute();
			return $arrStatus = $prep->fetch();
		}
	}