<?php 
    include_once("models/advert_model.php");

    include_once("models/cat_model.php");
    include_once("entities/cat_entity.php");

    include_once("entities/images_entity.php");
    include('models/images_model.php');

    class CatCtrl extends Ctrl{

        public function category(){
            
            // Utilisation de la classe model
            $objCatModel = new CatModel();
            $arrCat = $objCatModel->findAllCat();
            
            //Utilisation de la classe Img
            $objImgModel = new ImagesModel();

            // Parcourir les articles pour créer des objets
            $arrCatToDisplay = array();


            foreach ($arrCat as $arrDetailCat) {
                $objCat = new Category();    // instancie un objet Category
                $objCat->hydrate($arrDetailCat);


                $arrImages = $objImgModel->findImgCat($objCat->getId());

                if($arrImages===false) {
                    $objCat->setImg("cat_template_image.png");
                } else {
                        $objImages = new Images();    // instancie un objet Images
                        $objImages->hydrate($arrImages);
                        $objCat->setImg($objImages->getPic());
                }       
                $arrCatToDisplay[] = $objCat;
                
            }

            $this->_arrData["strPage"]  = "category";
            $this->_arrData["strTitle"]  = "Liste des catégories";
            $this->_arrData["strDesc"]  = "Liste des catégories";
            $this->_arrData["arrCatToDisplay"] = $arrCatToDisplay;
            
            $this->afficheTpl("category");

        }   

        // Une liste des adverts dans une categorie
        // Chercher ID de categorie.
        public function advertsOfCategory($id) {
            $categoryId = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (!$categoryId) {
                // S'il y a une erreur redirection vers:
                header(parent::SHOW404);
                exit;
            }
        
            // Creation une modele et cherche des details par son ID
            $objCatModel = new CatModel();
            $categoryDetails = $objCatModel->findCatById($categoryId);
            // Chercher les adverts de cette categories
            $adverts = $objCatModel->findAdvertsByCategoryId($categoryId);
            // Creation une array de details des categories et des adverts 
            $this->_arrData["categoryDetails"] = $categoryDetails;
            $this->_arrData["adverts"] = $adverts; 
            // Afficher dans view
            $this->afficheTpl("by_category");
        }
        
    }