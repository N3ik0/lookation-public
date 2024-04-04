<?php
	class Model {
		//property
		protected $_db;
		
		//function
		public function __construct () {
			try{
				$this->_db = new PDO(
										"mysql:host=localhost;dbname=lookation_test",
										"root",
										"",
										array(PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC)
									);
				$this->_db->exec("SET CHARACTER SET utf8");
				$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo "Échec".$e->getMessage();
			}
		}
	}
	