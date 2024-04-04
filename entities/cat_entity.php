<?php
include_once("entities/parent_entity.php");
	
	class Category extends Entity {
		//property
		protected string $_strPrefixe = "cat_";
		
		private int $_id;
		private string $_name;
		private string $_img;
		
		//cat_id
		public function getId() :int{
			return $this->_id;
		}
		public function setId(int $intId) {
			$this->_id = $intId;
		}
		//cat_name
		public function getName() :string{
			return $this->_name;
		}
		public function setName(string $strName) {
			$this->_name = filter_var($strName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		//cat_img
		public function getImg() :string{
			return $this->_img;
		}
		public function setImg(string $strImg) {
			$this->_img = filter_var($strImg, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
	}