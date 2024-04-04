<?php

/**
* Classe contrôleur parent
* Définit les constantes, gère le tableau de données ($_arrData), les types de données pour les images, la barres recherche sur toutes les pages, le chargement dynamique des catégories et l'affichage des templates
* @author Valentin
* @author Pierre
*/
class Ctrl
{
	// mettre la BASE_URL à jour quand on passera en prod
    //const BASE_URL = "http://lookation/";
    const BASE_URL = "http://localhost/lookation/";

    const MAX_CONTENT = 80;

    const SHOW403 = "Location:".self::BASE_URL."error/show403";
    const SHOW404 = "Location:".self::BASE_URL."error/show404";
    const nothingtoshow = "Location:".self::BASE_URL."error/nothingtoshow";

    protected array $_arrData = array();
    protected array $_arrMimesType = array("image/webp", "image/png", "image/jpeg", "image/jpg");


	/**
	* Constructeur de la classe Ctrl
	* Au moment de l'appel du constructeur, les catégories du site (affichées dans la navbar) sont chargées
	*/
    public function __construct()
    {
        $this->loadCategories();
    }


	/**
	* Fonction pour charger dynamiquement les catégories à afficher sur le site
	*/
    protected function loadCategories()
    {
        include_once("models/cat_model.php");
        include_once("entities/cat_entity.php");
        include_once("models/images_model.php");


        $objCatModel = new CatModel();
        $arrCatToDisplay = $objCatModel->findAllCat();
        $objImgModel = new ImagesModel();

        $arrObjCat = array();
        foreach ($arrCatToDisplay as $arrCatDetails) {
            $objCat = new Category();
            $objCat->hydrate($arrCatDetails);


            $arrImages = $objImgModel->findImgCat($objCat->getId());
            if ($arrImages === false) {
                $objCat->setImg("cat_template_image.png");
            } else {
                $objCat->setImg($arrImages['img_pic']);
            }

            $arrObjCat[] = $objCat;
        }


        $this->_arrData["arrCatToDisplay"] = $arrObjCat;
    }


	/**
	* Fonction permettant l'utilisation de la barre de recherche présente dans le header du site
	*/
    public function searchAdvert()
    {
        // Récupère l'information dans $_POST => car form est en methode post
        $strKeywords     = $_POST['keywords'] ?? "";

        $arrSearch         = array('keywords'     => $strKeywords);

        $objAdvertModel = new AdvertModel();
        $arrAdvert = $objAdvertModel->findAll(0, $arrSearch);

        $arrAdvertToDisplay = array();
        foreach ($arrAdvert as $arrAdvertDetails) {
            $objAdvert = new Advert();
            $objAdvert->hydrate($arrAdvertDetails);
            $arrAdvertToDisplay[] = $objAdvert;
        }

        $this->_arrData["Keywords"] = $strKeywords;
        $this->_arrData["arrAdvertToDisplay"] = $arrAdvertToDisplay;
    }


	/**
	* Fonction permettant l'affichage des templates des pages appellées
	* Permet également de faire transiter les données présentes dans le tableau $_arrData
	*/
    public function afficheTpl($strTpl, $display = true)
    {
        include_once("libs/smarty/Smarty.class.php");
        $smarty = new Smarty();

        foreach ($this->_arrData as $key => $value) {
            $smarty->assign($key, $value);
        }

        // L'utilisateur en session
        $smarty->assign("user", $_SESSION['user'] ?? array());
        $smarty->assign("base_url", self::BASE_URL);


        if ($display){
            $smarty->display("views/" . $strTpl . ".tpl");
        } else {
            return $smarty->fetch("views/" . $strTpl . ".tpl");
        }
        
    }
}
