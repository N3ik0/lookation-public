<?php 
    include_once("models/user_model.php");
    include_once("entities/user_entity.php");
	include_once("models/status_model.php");
    include_once("entities/status_entity.php");
	include_once("models/city_model.php");
    include_once("entities/city_entity.php");

	/**
	* Classe contrôleur de l'objet User (utilisateur)
	* @author Pierre
	*/
    class UserCtrl extends Ctrl{

		/**
		* Connexion au compte utilisateur
		*/
		public function login(){
			$arrErrors = array();
			$strLogin = $_POST["login"]??"";
			$strPassword = $_POST["password"]??"";
			if (count($_POST) > 0){
		
				$objUserModel = new UserModel();
				$arrUser = $objUserModel->checkLogin($strLogin, $strPassword);
		
				if (!$arrUser){ // si les identifiatns de connexion ne sont pas bons
					$arrErrors["log"] = "Erreur de connexion. Merci de vérifier votre login et/ou votre mot de passe.";
				}
				else {
					$_SESSION['user'] = $arrUser; // info récupérées : usr_id (ID), usr_login (login), stat_name (rôle : user/admin/mod/banni)
					// Mettre un message de type "alert alert-success" si la connexion s'est établie correctement ?
					
					header("Location:".parent::BASE_URL);
					// ajouter header / navbar adaptée
				}
			}

			$this->_arrData["strPage"] = "login";
			$this->_arrData["strTitle"] = "Connexion";
			$this->_arrData["strDesc"] = "Connectez-vous à votre compte Lookation à l'aide de votre nom d'utilisateur et de votre mot de passe.";
			$this->_arrData["arrErrors"] = $arrErrors;
			
			$this->afficheTpl("login");
		}
		
		
		/**
		* Déconnexion du compte utilisateur
		*/
		public function logout(){
			session_destroy();
			header("Location:".parent::BASE_URL);
		}
		
		
		/**
		* Fonction permettant la création d'un compte pour un nouvel utilisateur
		*/
		public function create_account(){
	
			$objUser = new User();
			$objCity = new City();
			$arrErrors = array();

			if (count($_POST) > 0){
				// Vérification de la case "newsletter" cochée ou non
				// vu que la valeur de la checkbox est soit "on" soit NULL, cela va poser problème avec l'hydratation qui attendra un int pour la newsletter
				$boolNewsletter = false;
				if (isset($_POST["newsletter"])){
					unset($_POST["newsletter"]); // suppression de la valeur pour éviter les conflits avec l'hydratation ci-dessous
					$boolNewsletter = true; // on retient que l'utilisateur a coché la case newsletter
				}
				$objUser->hydrate($_POST);
				// Gestion de l'erreur en insertion en BDD si l'utilisateur ne rentre pas de numéro de téléphone
				if (!isset($_POST["phone"]) || ($_POST["phone"] == "")) {
					$objUser->setPhone("-");
				}
				$objUserModel = new UserModel();
				$objCity = new City;
				$objCity->hydrate($_POST);
					
				// Vérification des champs (hors MDP)
				$arrErrorsCheckFields = array();
				$arrErrorsCheckFields = $this->_checkFields($objUser, $objCity);
				// Vérification des champs MDP
				$arrErrorsCheckFieldsPassword = array();
				$arrErrorsCheckFieldsPassword = $this->_checkFieldsPassword($objUser);
				// Fusion des deux tableaux d'erreurs précédents
				$arrErrors = array_merge($arrErrorsCheckFields, $arrErrorsCheckFieldsPassword);

				$arrNewUser = array();
				// Récupération de l'ID correspondant au couple ville / code postal. S'il n'existe pas encore, il est créé
				$arrNewUser["city_id"] = $this->_checkCity($objCity);
				
				// Gestion de l'inscription à la newsletter
				if ($boolNewsletter){ // si l'utilisateur a coché la case newsletter
					$arrNewUser["newsletter"] = 1; // re-création du champ, géré ainsi en vue de l'hydratation de $objUser ci-dessous qui attend un int
				}
				else{
					$arrNewUser["newsletter"] = 0; // re-création du champ, géré ainsi en vue de l'hydratation de $objUser ci-dessous qui attend un int
				}
				$objUser->setNewsletter($arrNewUser["newsletter"]);

				// Si aucune erreur n'a été générée, on commence la création du compte de l'utilisateur
				if (count($arrErrors) == 0) {
					// Hydratation avec les informations newsletter et city_id
					$objUser->hydrate($arrNewUser);
					$objUser->setPassword(password_hash($objUser->getPassword(), PASSWORD_DEFAULT)); // hachage du mot de passe
						
					try {
						$objUserModel->addUser($objUser);
						header("Location:".parent::BASE_URL."user/login");
					}
					catch (Exception $err) {
						echo("Une erreur s'est produite au moment de la création de l'utilisateur. Merci de réessayer.");
					}	
				}
			}
			else {
				// Lors de la première visite sur la page, on initialise tous les champs à vide
				$objUser->setLogin("");
				$objUser->setPassword("");
				$objUser->setName("");
				$objUser->setFirstname("");
				$objUser->setBirthdate("");
				$objUser->setAddress("");
				$objUser->setMail("");
				$objUser->setPhone("");
				$objUser->setAddress_comp("");
				$objUser->setNewsletter(0);
				$objCity->setName("");
				$objCity->setZip("");
			}

			$this->_arrData["strPage"] = "create_account";
			$this->_arrData["strTitle"] = "Création de compte Lookation";
			$this->_arrData["strDesc"] = "Remplissez les champs ci-dessous afin de vous créer un compte sur Lookation pour profiter de l'expérience totale offerte par le site.";
			$this->_arrData["arrErrors"] = $arrErrors;
			$this->_arrData["objUser"] = $objUser;
			$this->_arrData["objCity"] = $objCity;
			
			$this->afficheTpl("create_account");
		}
		
		
		/**
		* Fonction permettant d'afficher et d'éditer le profil d'un utilisateur
		* Si un administrateur accède à cette page, il aura la possibilité de modifier des données supplémentaires (cf template edit_profile.tpl)
		*/
		public function edit_profile(){
			// Vérification si l'utilisateur est bien connecté
			if (!isset($_SESSION['user']['usr_id']) || $_SESSION['user']['usr_id'] == ''){
				header(parent::SHOW403);
			}
			
			$arrErrors = array();
			
			// Affichage des informations utilisateur
			if (isset($_GET["usrId"]) && ($_GET["usrId"] != "")) {
				// si on vient sur cette page depuis l'affichage du listing utilisateur, on récupère l'ID depuis l'URL
				$intUserId = $_GET["usrId"];
			}
			else {
				// si on vient sur cette apge depuis le bouton de profil, on récupère l'ID depuis la session
				$intUserId = $_SESSION["user"]["usr_id"];
			}
			$objUserModel = new UserModel;
			$arrUser = $objUserModel->findUser($intUserId);
			$objUser = new User;
			$objUser->hydrate($arrUser);
			$objUser->setID($intUserId);
			
			// Création d'un objet UserOld qui contient les anciennes informations à contrôler au moment de la mise à jour du profil
			$arrUserOld = array();
			$arrUserOld["password"] = $objUser->getPassword();
			$arrUserOld["login"] = $objUser->getLogin();
			$arrUserOld["mail"] = $objUser->getMail();
			$objUserOld = new User;
			$objUserOld->hydrate($arrUserOld);

			// Affichage des informations de la ville
			$objCityModel = new CityModel;
			$arrCity = $objCityModel->findCity($intUserId);
			$objCity = new City;
			$objCity->hydrate($arrCity);
			
			// Affichage des informations du statut
			$objStatusModel = new StatusModel;
			$arrStatusToDisplay = array();
			$arrStatus = $objStatusModel->findAll();
			foreach ($arrStatus as $arrStatusDetails){
				$objStatus = new Status;
				$objStatus->hydrate($arrStatusDetails);
				$arrStatusToDisplay[] = $objStatus;
			}
			
			// Gestion de la checkbox newsletter
			// Note : cette partie aurait pu être simplifiée en mettant un attribut "value" sur la checkbox, mais comme cela fonctionne pour le moment et que le temps nous manque, je n'y touche pas pour l'instant
			$boolNewsletter = false;
			if (isset($_POST["newsletter"])){
				unset($_POST["newsletter"]); // suppression de la valeur pour éviter les conflits avec l'hydratation ci-dessous
				$boolNewsletter = true; // on retient que l'utilisateur a coché la case newsletter
			}
			// Gestion de l'inscription à la newsletter
			if ($boolNewsletter){ // si l'utilisateur a coché la case newsletter
				$arrNewUser["newsletter"] = 1; // re-création du champ, géré ainsi en vue de l'hydratation de $objUser ci-dessous qui attend un int
			}
			else{
				$arrNewUser["newsletter"] = 0; // re-création du champ, géré ainsi en vue de l'hydratation de $objUser ci-dessous qui attend un int
			}
			$objUser->setNewsletter($arrNewUser["newsletter"]);
			
			// Préparation de l'objet User depuis les informations de formulaire
			if (count($_POST) > 0){
				$objUser->hydrate($_POST); // mise à jour
				$objCity->hydrate($_POST); // mise à jour
				// Gestion de l'erreur en insertion en BDD si l'utilisateur ne rentre pas de numéro de téléphone
				if (!isset($_POST["phone"]) || ($_POST["phone"] == "")) {
					$objUser->setPhone("-");
				}
				
				// Vérification des champs (hors MDP)
				$arrErrorsCheckFields = array();
				$arrErrorsCheckFields = $this->_checkFields($objUser, $objCity, $objUserOld);
				// Vérification des champs MDP
				$arrErrorsCheckFieldsPassword = array();
				if ($objUser->getPassword() != ''){
					if (!password_verify($_POST['passwordOld'], $objUserOld->getPassword())){
						$arrErrorsCheckFieldsPassword['passwordErr'] = "Votre ancien mot de passe n'est pas correct.";
					}
					else{
						$arrErrorsCheckFieldsPassword = $this->_checkFieldsPassword($objUser);
					}
				}
				// Fusion des deux tableaux d'erreurs précédents
				$arrErrors = array_merge($arrErrorsCheckFields, $arrErrorsCheckFieldsPassword);
								
				// S'il n'y a pas d'erreurs, on passe à l'enregistrement des modifications
				if (count($arrErrors) == 0){
					$varResult = $objUserModel->editUser($objUser);
					// Vérification des champs accessibles seulement par l'administrateur (status & suppression)
					if (isset($_SESSION['user']['stat_name']) && $_SESSION['user']['stat_name'] === "Admin"){
						if (isset($_POST['stat_id'])){
							$usrStatNew = $_POST['stat_id'];
							$objUserModel->setStatusUser($objUser->getStat_id(), $usrStatNew);
						}
						if (isset($_POST['delete_user']) && ($_POST['delete_user'] == "On")){
							$objUserModel->deleteUser($objUser->getId());
						}
					}
					// Si l'insertion n'a pas renvoyé d'erreur
					if ($varResult === true){
						// Mise à jour des informations de session
						$_SESSION["user"]["usr_id"] = $objUser->getId();
						$_SESSION["user"]["login"] = $objUser->getLogin();
					}
					// Si l'insertion a renvoyé une erreur
					else {
						$arrErrors["editProfile"] = "Erreur au moment de modifier l'utilisateur : ".$varResult; // supprimer l'affichage de $varResult au moment de la mise en prod
					}
				}
				
			}
			
			$this->_arrData["strPage"] = "edit_profile";
			$this->_arrData["strTitle"] = "Modification de compte Lookation";
			$this->_arrData["arrErrors"] = $arrErrors;
			$this->_arrData["objUser"] = $objUser;
			$this->_arrData["arrStatus"] = $arrStatusToDisplay;
			$this->_arrData["objCity"] = $objCity;
			
			$this->afficheTpl("edit_profile");
		}
		
		
		/**
		* Fonction administrateur permettant d'afficher la liste des utilisateurs afin de pouvoir les modérer
		*/
		public function listAll(){
			// Vérification si l'utilisateur est bien connecté et s'il est bien un administrateur
			if (!isset($_SESSION['user']['usr_id']) || $_SESSION['user']['usr_id'] == '' || $_SESSION['user']['stat_name'] != "Admin"){
				header(parent::SHOW403);
			}
			
			// Récupération de la table utilisateurs
			$objUserModel = new UserModel();
			$arrUsers = $objUserModel->findAll();
			$arrUsersToDisplay = array();
			foreach($arrUsers as $userDetail){
				$objUser = new User();
				$objUser->hydrate($userDetail);
				$arrUsersToDisplay[] = $objUser;
			}
			
			$this->_arrData["strPage"] = "userList";
			$this->_arrData["strTitle"] = "Liste des utilisateurs";
			$this->_arrData["arrUsers"] = $arrUsersToDisplay;
			
			$this->afficheTpl("user_list");
		}
		
		
		
		// #################################################
        // ############### PRIVATE FUNCTIONS ###############
		// #################################################
		
		/**
		* Fonction privée permettant de vérifier la validité des champs (hors mot de passe) au moment de l'inscription ou de la modification du profil 
		* @param $objUser (object) Objet utilisateur contenant les informations à vérifier
		* @param $objCity (object) Objet ville contenant les informations à vérifier
		* @param $objUserOld (object) Objet optionnel utilisateur contenant les informations du compte avant modification de profil (pour bypasser l'erreur si le login/mail n'est pas changé). S'il n'est pas nul, c'est que l'on est en modification de profil. S'il est nul, c'est que l'on est en création de profil
		* @return $arrErrors (array) Tableau contenant les éventuelles erreurs sur les champs vérifiés
		*/
		private function _checkFields(object $objUser, object $objCity, object $objUserOld = NULL){
			$arrErrors = array();
			$objUserModel = new UserModel;
			// Vérification du remplissage des champs obligatoires
			if ($objUser->getLogin() == ""){
				$arrErrors["login"] = 'Le champ "Login" est obligatoire.';
			}
			else{
				// Vérification de l'unicité du login
				if (!is_null($objUserOld)){ // mode modification de profil
					if($objUser->getLogin() !== $objUserOld->getLogin()){ // si le login a été changé
						$intUniqueLogin = $objUserModel->uniqueLogin($objUser->getLogin());
						if ($intUniqueLogin == 1){
							$arrErrors["login"] = "Ce login est déjà pris par un autre utilisateur. Merci d'en choisir un différent.";
						}
					}
				}
				else{ // mode création de compte
					$intUniqueLogin = $objUserModel->uniqueLogin($objUser->getLogin());
					if ($intUniqueLogin == 1){
						$arrErrors["login"] = "Ce login est déjà pris par un autre utilisateur. Merci d'en choisir un différent.";
					}
				}
			}

			if ($objUser->getFirstname() == ""){
				$arrErrors["firstname"] = 'Le champ "Prénom" est obligatoire.';
			}
			if ($objUser->getName() == ""){
				$arrErrors["name"] = 'Le champ "Nom" est obligatoire.';
			}
			if ($objUser->getBirthdate() == ""){
				$arrErrors["birthdate"] = 'Le champ "Date de naissance" est obligatoire.';
			}
			// Vérification du format de date, pour éviter que l'utilisateur ne change pas le champ en type text pour faire n'importe quoi
			$strRegexDate = "/[1-9][0-9][0-9]{2}-([0][1-9]|[1][0-2])-([1-2][0-9]|[0][1-9]|[3][0-1])/";
			if (!preg_match($strRegexDate, $objUser->getBirthdate())){
				$arrErrors["birthdate"] = 'Le format de date est incorrect.';
			}

			// Vérification de l'âge de l'utilisateur
			else {
				$intUserAge = strtotime($objUser->getBirthdate());
				if(time() - $intUserAge < 18 * (3600 * 24 * 365.25)){ // conversion de 18 années en secondes
					$arrErrors["birthdate"] = 'Vous devez avoir plus de 18 ans pour pouvoir vous inscrire sur Lookation.';
				}
			}
			if ($objUser->getMail() == ""){
				$arrErrors["mail"] = 'Le champ "E-mail" est obligatoire.';
			}
			// Vérification de la validité syntaxique du mail
			elseif (!(filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL))){
				$arrErrors["mail"] = "L'e-mail n'est pas valide.";
			}
			else{
				// Vérification de l'unicité du mail
				if (!is_null($objUserOld)){ // mode modification de profil
					if($objUser->getMail() !== $objUserOld->getMail()){ // si le login a été changé
						$intUniqueMail = $objUserModel->uniqueMail($objUser->getMail());
						if ($intUniqueMail == 1){
							$arrErrors["mail"] = "Cet e-mail est déjà pris par un autre utilisateur. Merci d'en choisir un différent.";
						}
					}
				}
				else{ // mode création de compte
					$intUniqueMail = $objUserModel->uniqueMail($objUser->getMail());
					if ($intUniqueMail == 1){
						$arrErrors["mail"] = "Cet e-mail est déjà pris par un autre utilisateur. Merci d'en choisir un différent.";
					}
				}
			}
			
			if ($objUser->getAddress() == ""){
				$arrErrors["address"] = 'Le champ "Adresse" est obligatoire.';
			}
			
			// Gestion des informations de ville
			if ($objCity->getName() == ""){
				$arrErrors["cityName"] = 'Le champ "Ville" est obligatoire.';
			}
			if ($objCity->getZip() == ""){
				$arrErrors["cityZip"] = 'Le champ "Code postal" est obligatoire.';
			}
			elseif (strlen($objCity->getZip()) > 5) {
				$arrErrors["cityZip"] = "Le code postal que vous avez entré n'est pas valable (plus de 5 caractères).";
			}
			return $arrErrors;
		}
		
		
		/**
		* Fonction privée permettant de vérifier la validité des champs de mot de passe au moment de l'inscription ou de la modification du profil 
		* @param $objUser (object) Objet utilisateur contenant les informations à vérifier
		* @return $arrErrors (array) Tableau contenant les éventuelles erreurs sur les champs de mot de passe
		*/
		private function _checkFieldsPassword($objUser){
			$arrErrors = array();
			
			// Vérification du mot de passe
			if ($objUser->getPassword() == ""){
				$arrErrors["password"] = 'Le champ "Mot de passe" est obligatoire.'; 
			}
			$strPassword = $_POST["password"]??"";
			$strPasswordCheck = $_POST["passwordCheck"]??"";
			if ($strPasswordCheck == ""){
				$arrErrors["passwordCheck"] = 'Le champ "Mot de passe (vérification)" est obligatoire.'; 
			}
			
			// Vérification : le champ "mot de passe" et "mot de passe (confirmation)" sont-ils bien identiques ?
			if ($strPassword != "" && $strPasswordCheck != "" && $strPassword != $strPasswordCheck){
				$arrErrors["password"] = 'Les deux mots de passe ne sont pas identiques.';
			}
			elseif ($objUser->getPassword() != $_POST['passwordCheck']){
				$arrErrors["password"] = "Le mot de passe et sa confirmation doivent être identiques";
			}
			else {
				// Vérification de la complexité du mot de passe
				$strPwdRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"; 
				if (!preg_match($strPwdRegex, $objUser->getPassword())){
					$arrErrors["password"] = "Le mot de passe doit faire minimum 8 caractères et contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.";
				}
			}
			return $arrErrors;
		}
		
		
		/**
		* Fonction privée permettant de vérifier si un couple ville / code postal existe déjà, et si ce n'est pas le cas, la créée
		* @param $objCity (object) Objet ville contenant les informations à vérifier
		* @return $intCityId (integer) Identifiant du couple ville / code postal (soit déjà existant, soit créé par la fonction)
		*/
		private function _checkCity(object $objCity){
			// Vérification si le couple ville / code postal existe déjà en base de données
			$objCityModel = new CityModel();
			$arrCityId = $objCityModel->checkCity($objCity); // si le couple ville / code postal existe déjà, on a récupéré son ID
			
			// Si le couple ville / code postal n'existe pas encore dans la base de données, on l'ajoute et on récupère son ID
			if ($arrCityId == false){
				$objCityModel->addCity($objCity);
				$intCityId = $objCityModel->lastCityId();
			}
			else {
				$intCityId = $arrCityId["city_id"];
			}
			return $intCityId;
		}
    }