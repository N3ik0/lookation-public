<?php
	/**
	 * @author Ramzan
	 */
	include_once("connect.php");
	
	class CatModel extends Model {
		//property
		//function
		public function __construct () {
			parent::__construct();
		}
		
		public function findAllCat() {
			
			$strQuery = 'SELECT cat_id, cat_name
            FROM category
            ORDER BY cat_name;';
			return $this->_db->query($strQuery)->fetchAll();
		}

		//Chercher ID et NOM des categories pour se presenter par click sur nom dela categorie
		public function findCatById($categoryId) {
			$strQuery = 'SELECT cat_id, cat_name
						 FROM category
						 WHERE cat_id = :categoryId;';
		
			$stmt = $this->_db->prepare($strQuery);
			$stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
			$stmt->execute();
		
			return $stmt->fetch(); 
		}

        //Afficher les adverts par categories
	// В CatModel.php
	public function findAdvertsByCategoryId($categoryId) {
		$strQuery = 'SELECT advert.*, images.img_pic FROM advert
					LEFT JOIN images ON advert.adv_id = images.img_adv_id
					WHERE advert.adv_cat_id = :categoryId
					ORDER BY advert.adv_date_crea DESC;';

		$stmt = $this->_db->prepare($strQuery);
		$stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

		
}