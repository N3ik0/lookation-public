<?php
	include_once("entities/parent_entity.php");
	
	class Ticket extends Entity {
		//property
		protected string $_strPrefixe = "tic_";
		
		private int $_id;
		private datetime $_date_open;
        private datetime $_date_close;
		private string $_details;
        private string $_status;
        private string $_usr_id;
		private string $_adv_id;
		
		//tic_id
		public function getId() :int{
			return $this->_id;
		}
		public function setId(int $intId) {
			$this->_id = $intId;
		}
        //tic_date_open
		public function getDateOpen() :datetime{
			return $this->_date_open;
		}
		public function setDate_open(datetime $dateDateOpen){
			$this->_date_open = $dateDateOpen;
		}
		//tic_date_close
		public function getDateClose() :datetime{
			return $this->_date_close;
		}
		public function setDate_close(datetime $dateDateClose){
			$this->_date_close = $dateDateClose;
		}
		//tic_details
		public function getDetails() :string{
			return $this->_details;
		}
		public function setDetails(string $strDetails) {
			$this->_details = $strDetails;
		}
        //tic_status
		public function getStatus() :string{
			return $this->_status;
		}
		public function setStatus(string $strStatus) {
			$this->_status = $strStatus;
		}
        //tic_usr_id
		public function getUsrId() :string{
			return $this->_usr_id;
		}
		public function setUsr_id(string $strUsrId) {
			$this->_usr_id = $strUsrId;
		}
		//tic_adv_id
		public function getAdvId() :string{
			return $this->_adv_id;
		}
		public function setAdv_id(string $strAdvId) {
			$this->_adv_id = $strAdvId;
		}
	}