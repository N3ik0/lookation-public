<?php

include_once("entities/parent_entity.php");

/**
 * Entity Advert de récupération des données adv dans la BDD
 * @author Valentin
 */


class Advert extends Entity
{
	//property from entity
	protected string $_strPrefixe = "adv_";

	/**
	 * Propriétés de la classe
	 */
	private int $_id;
	private string $_title;
	private string $_details;
	private string $_date_crea;
	private int | null $_price;
	private string $_status;
	private string $_stats_note;
	private int $_usr_id;
	private int $_cat_id;
	private string $_img;
	private int $_city_id;
	private string $_city_name;

	/**
	 * Setters & Getters
	 */

	/**
	 * Récupération de l'identifiant de l'annonce
	 * @return int Identifiant de l'annonce
	 */
	public function getId(): int
	{
		return $this->_id;
	}
	/**
	 * Définition de l'identifiant de l'annonce
	 * @param int $intId Identifiant de l'annonce
	 */
	public function setId(int $intId)
	{
		$this->_id = $intId;
	}
	/**
	 * Récupération du titre de l'annonce
	 * @return string Titre de l'annonce
	 */
	public function getTitle(): string
	{
		return $this->_title;
	}
	/**
	 * Définition du titre de l'annonce
	 * @param string $strTitle Titre de l'annonce
	 */
	public function setTitle(string $strTitle)
	{
		$this->_title = filter_var(trim($strTitle), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération des détails de l'annonce
	 * @return string Détails de l'annonce
	 */
	public function getDetails(): string
	{
		return $this->_details;
	}
	/**
	 * Définition des détails de l'annonce
	 * @param string $strDetails Détails de l'annonce
	 */
	public function setDetails(string $strDetails)
	{
		$this->_details = filter_var(trim($strDetails), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération de la date de création de l'annonce
	 * @return string Date de création de l'annonce
	 */
	public function getDetailsSummary()
	{
		$strDetails = $this->_details;
		if (strlen($strDetails) > 80) {
			$strDetails = substr($strDetails, 0, 80) . " ...";
		}
		return $strDetails;
	}
	/**
	 * Définition de la date de création de l'annonce
	 * @param string $dateDateCrea Date de création de l'annonce
	 */
	public function getDateCrea(): string
	{
		return $this->_date_crea;
	}
	/**
	 * Définition de la date de création de l'annonce
	 * @param string $dateDateCrea Date de création de l'annonce
	 */
	public function setDate_crea(string $dateDateCrea)
	{
		$this->_date_crea = filter_var(trim($dateDateCrea), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération de la date de création de l'annonce au format français
	 * @return string Date de création de l'annonce au format français
	 */
	public function getDateCreaFR()
	{
		$objDate = new DateTime($this->_date_crea);
		return $dateDateCrea = $objDate->format("d/m/Y");
	}
	/**
	 * Récupération du prix de l'annonce
	 * @return int Prix de l'annonce
	 */
	public function getPrice(): int | null
	{
		return $this->_price;
	}
	/**
	 * Définition du prix de l'annonce
	 * @param int $intPrice Prix de l'annonce
	 */
	public function setPrice(?int $intPrice)
	{
		$this->_price = $intPrice;
	}
	/**
	 * Récupération du statut de l'annonce
	 * @return string Statut de l'annonce
	 */
	public function getStatus(): string
	{
		return $this->_status;
	}
	/**
	 * Définition du statut de l'annonce
	 * @param string $strStatus Statut de l'annonce
	 */
	public function setStatus(string $strStatus)
	{
		$this->_status = filter_var(trim($strStatus), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération de la note de l'annonce
	 * @return string Note de l'annonce
	 */
	public function getStats_note(): string
	{
		return $this->_stats_note;
	}
	/**
	 * Définition de la note de l'annonce
	 * @param string $strStatsNote Note de l'annonce
	 */
	public function setStats_note(string $strStatsNote)
	{
		$this->_stats_note = filter_var(trim($strStatsNote), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération de l'identifiant de l'utilisateur ayant créé l'annonce
	 * @return int Identifiant de l'utilisateur ayant créé l'annonce
	 */
	public function getUsr_id(): int
	{
		return $this->_usr_id;
	}
	/**
	 * Définition de l'identifiant de l'utilisateur ayant créé l'annonce
	 * @param int $intUsrId Identifiant de l'utilisateur ayant créé l'annonce
	 */
	public function setUsr_id(int $intUsrId)
	{
		$this->_usr_id = filter_var(trim($intUsrId), FILTER_VALIDATE_INT);
	}
	/**
	 * Récupération de l'identifiant de la catégorie de l'annonce
	 * @return int Identifiant de la catégorie de l'annonce
	 */
	public function getCat_id(): int
	{
		return $this->_cat_id;
	}
	/**
	 * Définition de l'identifiant de la catégorie de l'annonce
	 * @param int $intCatId Identifiant de la catégorie de l'annonce
	 */
	public function setCat_id(int $intCatId)
	{
		$this->_cat_id = filter_var(trim($intCatId), FILTER_VALIDATE_INT);
	}
	/**
	 * Récupération de l'image de l'annonce
	 * @return string Image de l'annonce
	 */
	public function getImg(): string
	{
		return $this->_img;
	}
	/**
	 * Définition de l'image de l'annonce
	 * @param string $strImg Image de l'annonce
	 */
	public function setImg(string $strImg)
	{
		$this->_img = filter_var(trim($strImg), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	/**
	 * Récupération de l'identifiant de la ville de l'annonce
	 * @return int Identifiant de la ville de l'annonce
	 */
	public function getCity_id(): int
	{
		return $this->_city_id;
	}
	/**
	 * Définition de l'identifiant de la ville de l'annonce
	 * @param int $intCityId Identifiant de la ville de l'annonce
	 */
	public function setCity_id(int $intCityId)
	{
		$this->_city_id = filter_var(trim($intCityId), FILTER_VALIDATE_INT);
	}
	/**
	 * Récupération du nom de la ville de l'annonce
	 * @return string Nom de la ville de l'annonce
	 */
	public function getCity_name(): string
	{
		return $this->_city_name;
	}
	/**
	 * Définition du nom de la ville de l'annonce
	 * @param string $strCityName Nom de la ville de l'annonce
	 */
	public function setCity_name(string $strCityName)
	{
		$this->_city_name = filter_var(trim($strCityName), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
}
