<?php
include_once("entities/parent_entity.php");

/**
 * Classe de l'entité Image
 * @author Maxime
 * @author Valentin
 */

/* FICHIER A TERMINE DE RENOMMER */

	class Images extends Entity {
		//property
		protected string $_strPrefixe = "img_";
		
		private int $_id;
		private string $_pic;
		private int $_usr_id;
		private int $_adv_id;
		private int $_cat_id;

		//img_id
		public function getId() :int{
			return $this->_id;
		}
		public function setId(int $intId) {
			$this->_id = $intId;
		}
		//img_pic
		public function getPic() :string{
			return $this->_pic;
		}
		public function setPic(string $strPic) {
			$this->_pic = $strPic;
		}
		//img_usr_id
		public function getUsr_id() :int{
			return $this->_usr_id;
		}
		public function setUsr_id(int $intUsrId) {
			$this->_usr_id = $intUsrId;
		}
		//img_adv_id
		public function getAdvId() :int{
			return $this->_adv_id;
		}
		public function setAdv_id(int $intAdvId) {
			$this->_adv_id = $intAdvId;
		}
		//img_cat_id
		public function getCat_id() :int{
			return $this->_cat_id;
		}
		public function setCat_id(int $intCatId) {
			$this->_cat_id = $intCatId;
		}
	}
    