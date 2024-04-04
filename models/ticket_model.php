<?php
	include_once("connect.php");
	
	class TicketModel extends Model {
		//property
		//function
		public function __construct () {
			parent::__construct();
		}
		
		public function findTicUsr ($getTicId){
			$strQuery = "";
			
			$strQuery .= 'SELECT tic_id, tic_date_open, tic_date_close, tic_details, tic_status
			FROM ticket
			INNER JOIN user ON ticket.tic_usr_id = user.usr_id
			WHERE user.usr_id = ';
			$strQuery .= $getUsrId;
			$strQuery .= ';';
			return $this->_db->query($strQuery)->fetch();
		}

        public function findTicAdv ($getTicId){
			$strQuery = "";
			
			$strQuery .= 'SELECT tic_id, tic_date_open, tic_date_close, tic_details, tic_status
			FROM ticket
			INNER JOIN advert ON ticket.tic_adv_id = advert.adv_id
			WHERE advert.adv_id = ';
			$strQuery .= $getAdvId;
			$strQuery .= ';';
			return $this->_db->query($strQuery)->fetch();
		}

    }