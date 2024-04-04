<?php
include_once("connect.php");
include_once("entities/parent_entity.php");

/** 
 * Model Advert de récupération des données adv dans la BDD
 * @author Valentin
 */

class AdvertModel extends Model
{
	/**
	 * Constructeur de la classe
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Fonction de récupération de toutes les annonces
	 * @param int $queryMax Nombre maximum d'annonces à récupérer
	 * @param array $arrSearch Tableau de recherche
	 * @return array Tableau contenant les annonces
	 */
	public function findAll($queryMax = 0, $arrSearch = array(), $cityName = null)
	{
		$strQuery = "";

		$strQuery .= 'SELECT adv_id, CONCAT(user.usr_firstname, " ", user.usr_name) AS "adv_creator_name", advert.adv_title, 
			advert.adv_details, advert.adv_date_crea, city.city_name as "adv_city_name", cat_id, cat_name, adv_status, adv_stats_note
			FROM advert
			INNER JOIN user ON advert.adv_usr_id = user.usr_id
			INNER JOIN category ON adv_cat_id = cat_id
			INNER JOIN city ON adv_city_id = city.city_id';

		$strWhere = " WHERE ";

		// Filtrer par ville
		if (!is_null($cityName)) {
			$strQuery .= ' WHERE city.city_name = :cityName';
		}

		// Recherche par mots clés
		$strKeywords = $arrSearch['keywords'] ?? "";
		if ($strKeywords != '') {
			$strQuery 	.= $strWhere . " (adv_title LIKE :keywords
									OR adv_details LIKE :keywords) ";
			$strWhere	= " AND ";
		}

		// Recherche par catégorie
		$intCategory = $arrSearch['category'] ?? 0;
		if ($intCategory != 0) {
			$strQuery 	.= $strWhere . " (cat_id = :category) ";
			$strWhere	= " AND ";
		}

		// Tri par date
		$intOrderByDate = $arrSearch['OrderByDate'] ?? 0;
		if ($intOrderByDate != 0) {
			$strQuery 	.= ' ORDER BY adv_date_crea ASC ';
			$strWhere	= " AND ";
		} else {
			$strQuery 	.= ' ORDER BY adv_date_crea DESC ';
		}

		if ($queryMax != 0) {
			$strQuery .= 'LIMIT ' . $queryMax;
		}


		$strQuery .= ';';


		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);

		// par ville
		if (!is_null($cityName)) {
			$rqPrep->bindValue(':cityName', $cityName, PDO::PARAM_STR);
		}

		if ($strKeywords != '') {
			$rqPrep->bindValue(':keywords', '%' . $strKeywords . '%', PDO::PARAM_STR);
		}
		if ($intCategory != 0) {
			$rqPrep->bindValue(':category', $intCategory, PDO::PARAM_INT);
		}
		if ($intOrderByDate != 0) {
			$rqPrep->bindValue(':OrderByDate', $intOrderByDate, PDO::PARAM_INT);
		}

		// Exécution de la requête
		$rqPrep->execute();
		return $rqPrep->fetchAll();
	}


	/**
	 * Fonction de récupération de toutes les annonces
	 * @param int $usrId Identifiant de l'utilisateur afin de récupérer ses propres annonces.
	 */
	public function findOwn($usrId){
		$strQuery = "";

		$strQuery .= 'SELECT adv_id, CONCAT(user.usr_firstname, " ", user.usr_name) AS "adv_creator_name", advert.adv_title, 
			advert.adv_details, advert.adv_date_crea, city.city_name as "adv_city_name", cat_id, cat_name, adv_status, adv_stats_note
			FROM advert
			INNER JOIN user ON advert.adv_usr_id = user.usr_id
			INNER JOIN category ON adv_cat_id = cat_id
			INNER JOIN city ON adv_city_id = city.city_id
			WHERE adv_usr_id = :usrId';

		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':usrId', $usrId, PDO::PARAM_INT);

		$rqPrep->execute();
		return $rqPrep->fetchAll();
	}

	/**
	 * Fonction de récupération d'une annonce spécifique
	 * @param int $advId Identifiant de l'annonce à récupérer
	 * @return array Tableau contenant les informations de l'annonce
	 */
	public function selectAdvert($advId)
	{
		$strQuery = "";

		$strQuery .= "SELECT 
		advert.adv_id, 
		CONCAT(user.usr_firstname, ' ', user.usr_name) AS 'adv_creator_name', 
		advert.adv_title, 
		advert.adv_details, 
		advert.adv_date_crea,
		advert.adv_price,
		advert.adv_status,
		advert.adv_stats_note, 
		advert.adv_city_id,
		advert.adv_usr_id,
		category.cat_id,
		category.cat_name
		FROM advert
		INNER JOIN 	user ON advert.adv_usr_id = user.usr_id
		INNER JOIN category ON advert.adv_cat_id = category.cat_id
		WHERE 	advert.adv_id = $advId 
		ORDER BY advert.adv_date_crea DESC;
		";
		return $this->_db->query($strQuery)->fetch();
	}

	/**
	 * Fonction d'ajout d'une nouvelle annonce
	 * @param object $objAdvert Objet contenant les informations de l'annonce à ajouter
	 * @return int Identifiant de l'annonce ajoutée
	 */
	public function addAdvert($objAdvert)
	{
		$strQuery = "INSERT INTO 	advert (adv_title, adv_details, adv_date_crea, adv_price, 
											adv_status, adv_stats_note, adv_usr_id, adv_cat_id, adv_city_id)
									VALUES (:adv_title, :adv_details, NOW(), :adv_price, :adv_status, :adv_stats_note, :adv_usr_id,
											:adv_cat_id, :adv_city_id);";

		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':adv_title', $objAdvert->getTitle(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_details', $objAdvert->getDetails(), PDO::PARAM_STR);
		//DATE CREA 
		$rqPrep->bindValue(':adv_price', $objAdvert->getPrice(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_status', $objAdvert->getStatus(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_stats_note', $objAdvert->getStats_note(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_usr_id', $objAdvert->getUsr_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_cat_id', $objAdvert->getCat_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_city_id', $objAdvert->getCity_id(), PDO::PARAM_INT);

		// Exécution de la requête
		$success = $rqPrep->execute();
		$lastInsertId = $this->_db->lastInsertId();
		return $lastInsertId;
	}

	public function delete(int $advId)
	{
		$strQuery = "DELETE FROM advert WHERE adv_id = :adv_id;";

		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':adv_id', $advId, PDO::PARAM_INT);

		// Exécution de la requête
		$success = $rqPrep->execute();
		return $success;
	}


	public function updateAdvert(int $advId, $objAdvert)
	{
		$strQuery = "UPDATE advert 
			SET adv_title = :adv_title, 
				adv_details = :adv_details, 
				adv_date_crea = NOW(),
				adv_price = :adv_price, 
				adv_status = :adv_status,
				adv_stats_note = :adv_stats_note,
				adv_usr_id = :adv_usr_id,
				adv_cat_id = :adv_cat_id, 
				adv_city_id = :adv_city_id

			WHERE adv_id = :adv_id;";

		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':adv_id', $advId, PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_title', $objAdvert->getTitle(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_details', $objAdvert->getDetails(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_price', $objAdvert->getPrice(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_status', $objAdvert->getStatus(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_stats_note', $objAdvert->getStats_note(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_usr_id', $objAdvert->getUsr_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_cat_id', $objAdvert->getCat_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_city_id', $objAdvert->getCity_id(), PDO::PARAM_INT);
		// Exécution de la requête
		$success = $rqPrep->execute();
		return $success;
	}

	public function modAdvert(int $advId, $objAdvert)
	{
		$strQuery = "UPDATE advert 
			SET adv_title = :adv_title, 
				adv_details = :adv_details, 
				adv_date_crea = NOW(),
				adv_price = :adv_price, 
				adv_status = :adv_status,
				adv_stats_note = :adv_stats_note,
				adv_usr_id = :adv_usr_id,
				adv_cat_id = :adv_cat_id, 
				adv_city_id = :adv_city_id

			WHERE adv_id = :adv_id;";

		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':adv_id', $advId, PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_title', $objAdvert->getTitle(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_details', $objAdvert->getDetails(), PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_price', $objAdvert->getPrice(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_status', "A", PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_stats_note', "Modification par l'utilisateur", PDO::PARAM_STR);
		$rqPrep->bindValue(':adv_usr_id', $objAdvert->getUsr_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_cat_id', $objAdvert->getCat_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_city_id', $objAdvert->getCity_id(), PDO::PARAM_INT);
		// Exécution de la requête
		$success = $rqPrep->execute();
		return $success;
	}
}
