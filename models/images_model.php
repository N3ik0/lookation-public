<?php

/**
 * Classe de l'entité Image
 * @author Maxime
 * @author Valentin
 */

include_once("connect.php");

class ImagesModel extends Model
{
	//property
	//function
	public function __construct()
	{
		parent::__construct();
	}

	public function findImgAdv(int $intFindImgId)
	{
		$strQuery = "";

		$strQuery .= 'SELECT images.img_pic
			FROM images
			INNER JOIN advert ON images.img_adv_id = advert.adv_id
			WHERE advert.adv_id = :findImg
			AND images.img_flag = true;';
		$prep = $this->_db->prepare($strQuery);
		$prep->bindValue(":findImg", $intFindImgId, PDO::PARAM_INT);
		$prep->execute();
		$arrImg = $prep->fetch();
		return $arrImg;
	}

	public function findImgAdvAll(int $intFindImgId)
	{
		$strQuery = "";

		$strQuery .= 'SELECT images.img_pic
			FROM images
			INNER JOIN advert ON images.img_adv_id = advert.adv_id
			WHERE advert.adv_id = :findImg;';
		$prep = $this->_db->prepare($strQuery);
		$prep->bindValue(":findImg", $intFindImgId, PDO::PARAM_INT);
		$prep->execute();
		$arrImg = $prep->fetchAll();
		return $arrImg;
	}

	public function findImgCat(int $intFindImgId)
	{
		$strQuery = "";

		$strQuery .= 'SELECT images.img_pic
			FROM images
			INNER JOIN category ON images.img_cat_id = category.cat_id
			WHERE category.cat_id = :findImg;';
		$prep = $this->_db->prepare($strQuery);
		$prep->bindValue(":findImg", $intFindImgId, PDO::PARAM_INT);
		$prep->execute();
		$arrImg = $prep->fetch();
		return $arrImg;
	}

	public function addImg($objImg, $newAdvertId)
	{
		$strQuery =    "INSERT INTO images (img_pic, img_flag, img_usr_id, img_adv_id)
                            VALUES (:iPic, :iFlag, :iUsrId, :iAdvId);";
		$prep = $this->_db->prepare($strQuery);
		$prep->bindValue(":iPic", $objImg->getPic(), PDO::PARAM_STR);
		$prep->bindValue(":iFlag", 1, PDO::PARAM_INT);
		$prep->bindValue(":iUsrId", $objImg->getUsr_id(), PDO::PARAM_INT);
		$prep->bindValue(":iAdvId", $newAdvertId, PDO::PARAM_INT);
		$prep->execute();
	}

	public function updateAdvertImg(int $advId, $objImg)
	{
		$strQuery = "UPDATE images
			SET 
				img_pic = :img_pic, 
				img_flag = :img_flag,
				img_usr_id = :img_usr_id, 
				img_adv_id = :img_adv_id,
				img_cat_id = :img_cat_id


			WHERE img_adv_id = :adv_id;";

		// Préparation de la requête
		$rqPrep = $this->_db->prepare($strQuery);
		$rqPrep->bindValue(':img_pic', $objImg->getPic(), PDO::PARAM_STR);
		$rqPrep->bindValue(':img_flag', 1, PDO::PARAM_INT);
		$rqPrep->bindValue(':img_usr_id', $objImg->getUsr_id(), PDO::PARAM_INT);
		$rqPrep->bindValue(':img_adv_id', $advId, PDO::PARAM_INT);
		$rqPrep->bindValue(':img_cat_id', NULL, PDO::PARAM_INT);
		$rqPrep->bindValue(':adv_id', $advId, PDO::PARAM_INT);
		// Exécution de la requête
		$success = $rqPrep->execute();
		return $success;
	}
}
