<?php
	/** 
	* @author Maxime 
	*/

	class PageCtrl extends Ctrl{
		
		public function about(){
			$this->_arrData["strPage"] 	= "about";
			$this->_arrData["strTitle"] = "A propos";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("about");
			
		}

		public function join_us(){
			$this->_arrData["strPage"] 	= "join_us";
			$this->_arrData["strTitle"] = "A propos";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("join_us");
			
		}

		public function news(){
			$this->_arrData["strPage"] 	= "news";
			$this->_arrData["strTitle"] = "A propos";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("news");
			
		}
		
		public function contact(){
			$this->_arrData["strPage"] 	= "contact";
			$this->_arrData["strTitle"] = "Contact";
			$this->_arrData["strDesc"] 	= "Page de contact";
			$this->afficheTpl("contact");

		}

		public function faq_page(){
			$this->_arrData["strPage"] 	= "faq_page";
			$this->_arrData["strTitle"] = "Foire aux questions";
			$this->_arrData["strDesc"] 	= "Page contenant les questions les plus fréquentes";
			$this->afficheTpl("faq_page");

		}

		public function support(){
			$this->_arrData["strPage"] 	= "support";
			$this->_arrData["strTitle"] = "Support en ligne";
			$this->_arrData["strDesc"] 	= "Page permettant de contacter le support";
			$this->afficheTpl("support");

		}

		public function delivery_info(){
			$this->_arrData["strPage"] 	= "delivery_info";
			$this->_arrData["strTitle"] = "Informations de livraison";
			$this->_arrData["strDesc"] 	= "Page d'informations de livraison";
			$this->afficheTpl("delivery_info");

		}

		public function site_plan(){
			$this->_arrData["strPage"] 	= "site_plan";
			$this->_arrData["strTitle"] = "Plan du site";
			$this->_arrData["strDesc"] 	= "Page affichant le plan du site selon le role de l'utilisateur";
			$this->afficheTpl("site_plan");

		}

		public function mentions(){
			$this->_arrData["strPage"] 	= "mentions";
			$this->_arrData["strTitle"] = "Mentions légales";
			$this->_arrData["strDesc"] 	= "Page contenant les mentions légales du site";
			$this->afficheTpl("mentions");

		}

		public function confidentiality(){
			$this->_arrData["strPage"] 	= "confidentiality";
			$this->_arrData["strTitle"] = "Politique de confidentiolité";
			$this->_arrData["strDesc"] 	= "Page contenant les informations générales sur la confidentialité du site";
			$this->afficheTpl("confidentiality");

		}

		public function author_rights(){
			$this->_arrData["strPage"] 	= "author_rights";
			$this->_arrData["strTitle"] = "Droits d'auteur";
			$this->_arrData["strDesc"] 	= "Page contenant les informations de droit d'auteur du site";
			$this->afficheTpl("author_rights");

		}

		public function licences(){
			$this->_arrData["strPage"] 	= "licences";
			$this->_arrData["strTitle"] = "Licences";
			$this->_arrData["strDesc"] 	= "Page comprennant la liste des licences des technologies utilisés";
			$this->afficheTpl("licences");

		}
	}