<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/Exception.php';
require 'libs/PHPMailer/PHPMailer.php';
require 'libs/PHPMailer/SMTP.php';


include_once("models/advert_model.php");
include_once("entities/advert_entity.php");
include('models/images_model.php');
include_once("entities/images_entity.php");
include_once("models/city_model.php");
include_once("entities/city_entity.php");
include_once("models/cat_model.php");
include_once("entities/cat_entity.php");


/**
 * Controller Advert de récupération des données adv dans la BDD
 * @author Valentin
 */

class AdvertCtrl extends Ctrl
{

    /**
     * Fonction de la page d'accueil
     */

    public function home()
    {
        // Utilisation de la classe model
        $objCityModel = new CityModel();
        $arrCity = $objCityModel->findAll();

        // Parcourir les villes pour créer des objets
        $arrCityToDisplay = array();

        foreach ($arrCity as $arrDetailCity) {
            $objCity = new City();
            $objCity->hydrate($arrDetailCity);
            $arrCityToDisplay[] = $objCity;
        }

        // Utilisation de la classe model
        $objAdvModel = new AdvertModel();
        $arrAdvert = $objAdvModel->findAll(4);

        //Utilisation de la classe Img
        $objImgModel = new ImagesModel();

        //Utilisation de la classe City
        $objCityModel = new CityModel();
        $arrCity = $objCityModel->findAll();

        $cityName = $_COOKIE['user_city'] ?? null;
        $arrAdvert = $objAdvModel->findAll(4, [], $cityName);

        // Parcourir les articles pour créer des objets
        $arrAdvertToDisplay = array();

        foreach ($arrAdvert as $arrDetailAdvert) {
            $objAdvert = new Advert();    // instancie un objet Advert
            $objAdvert->hydrate($arrDetailAdvert);

            $arrImages = $objImgModel->findImgAdv($objAdvert->getId());

            if ($arrImages === false) {
                $objAdvert->setImg("template_image.png");
            } else {
                $objImages = new Images();    // instancie un objet Images
                $objImages->hydrate($arrImages);
                $objAdvert->setImg($objImages->getPic());
            }
            $arrAdvertToDisplay[] = $objAdvert;
        }
        parent::searchAdvert();

        $this->_arrData["strPage"]  = "index";
        $this->_arrData["strTitle"]  = "Accueil de Lookation";
        $this->_arrData["strDesc"]  = "Page d'accueil de Lookation";
        $this->_arrData["arrAdvertToDisplay"] = $arrAdvertToDisplay;
        $this->afficheTpl("home");
    }


    /**
     * Fonction d'affichage des annonces
     */
    public function advert()
    {

        $strKeywords     = $_POST['keywords'] ?? "";
        $strCity         = $_POST['city'] ?? "";
        $intCategory     = intval($_POST['category'] ?? 0);
        $intOrderByDate        = intval($_POST['OrderByDate'] ?? 0);
        $intOrderByPrice        = intval($_POST['OrderByPrice'] ?? 0);

        $arrSearch         = array(
            'keywords'     => $strKeywords,
            'city'        => $strCity,
            'category'    => $intCategory,
            'OrderByDate' => $intOrderByDate,
            'OrderByPrice' => $intOrderByPrice
        );

        // Utilisation de la classe model
        $objAdvModel = new AdvertModel();
        $arrAdvert = $objAdvModel->findAll(0, $arrSearch);
        //Utilisation de la classe Img
        $objImgModel = new ImagesModel();

        $cityName = $_COOKIE['user_city'] ?? null;

        // Parcourir les articles pour créer des objets
        $arrAdvertToDisplay = array();

        foreach ($arrAdvert as $arrDetailAdvert) {
            $objAdvert = new Advert();    // instancie un objet Advert
            $objAdvert->hydrate($arrDetailAdvert);

            $arrImages = $objImgModel->findImgAdv($objAdvert->getId());

            if ($arrImages === false) {
                $objAdvert->setImg("template_image.png");
            } else {
                $objImages = new Images();    // instancie un objet Images
                $objImages->hydrate($arrImages);
                $objAdvert->setImg($objImages->getPic());
                //$arrImagesToDisplay[$objAdvert->getId()] = $objImages;
            }
            $arrAdvertToDisplay[] = $objAdvert;
        }
        parent::searchAdvert();

        $this->_arrData["city"] = $strCity;
        $this->_arrData["category"] = $intCategory;
        $this->_arrData["keywords"] = $strKeywords;
        $this->_arrData["strPage"]  = "advert";
        $this->_arrData["strTitle"]  = "Les annonces de Lookation";
        $this->_arrData["strDesc"]  = "Les annonces de Lookation";
        $this->_arrData["arrAdvertToDisplay"] = $arrAdvertToDisplay;

        $this->afficheTpl("advert");
    }


    /**
     * Fonction d'affichage de l'annonce sélectionnée
     */
    public function Selected()
    {        
        $advId            = $_GET['id'] ?? null;
        $strDestMail      = $_POST['destMail'] ?? "";

        // Utilisation de la classe model
        $objAdvModel = new AdvertModel();
        // Chargement de l'objet dans un tableau
        $selectedAdvert = $objAdvModel->selectAdvert($advId);

        if($selectedAdvert != false){
        // Instanciation de l'objet advert
        $objAdvert = new Advert();
        // Hydratation de l'objet 
        $objAdvert->hydrate($selectedAdvert);

        //utilisation de classe image
        $objImgModel = new ImagesModel();
        // chargement de l'objet dans un tableau
        $arrImages = $objImgModel->findImgAdvAll($advId);

        // Initialisation d'un tableau pour stocker les images
        $arrImagesToDisplay = array();

        // Boucle pour récupérer les images, création d'un nouvel objet
        // Hydratation et utilisation de la fonction d'img
        // Stockage dans le tableau arrImagesToDisplay
        foreach ($arrImages as $arrDetailImages) {
            $objImages = new Images();
            $objImages->hydrate($arrDetailImages);
            $objAdvert->setImg($objImages->getPic());
            $arrImagesToDisplay[] = $objImages;
        }

        if ($strDestMail != ""){
            $strSubject = $objAdvert->getTitle() . " sur Lookation";
            $strBody =  $this->afficheTpl("mails/shareAdvert", false);
            $intAdvId = $advId;
            $this->_shareAdvert($strDestMail, $strSubject, $strBody);
        }
        //Stockage des informations dans le tableau _arrData
        parent::searchAdvert();
        $this->_arrData["strPage"]  = "selected";
        $this->_arrData["strTitle"]  = "Les annonces de Lookation";
        $this->_arrData["strDesc"]  = "Les annonces de Lookation";
        $this->_arrData["objImages"] = $arrImagesToDisplay;
        $this->_arrData["objAdvert"] = $objAdvert;
        $this->afficheTpl("selected");
        } else {
            header("Location:" . parent::BASE_URL . "error/show404");
        }
    }


    /**
     * Fonction d'ajout d'une annonce
     */
    public function addAdvert()
        {  
            $arrSuccess = array();     // Initialisation d'un tableau pour les succès
            $arrErrors = array();       // Initialisation d'un tableau pour les erreurs
            $objAdvertModel = new AdvertModel(); // Instancie un objet AdvertModel
            $objAdvert = new Advert(); // Instancie un objet Advert
            $objCityModel = new CityModel(); // Instancie un objet CityModel
            $objImgModel = new ImagesModel(); // Instancie un objet ImgModel

            // Initialisation des variables de l'objet Advert pour la condition sur formulaire
            $objAdvert->setTitle("");
            $objAdvert->setDetails("");
            $objAdvert->setPrice(0);

            if (!empty($_SESSION) && $_SESSION['user']['usr_id'] != 0) {
            /* Intialisation des variable récupéré dans le $_POST */
            $strTitle = $_POST['adv_title'] ?? "";
            $strDetails = $_POST['details'] ?? "";
            $intPrice = intval($_POST['price'] ?? 0);
            $strStatus = "A";
            $strStatsNote = "A vérifier";
            $intUsrId = intval($_SESSION['user']['usr_id']);
            $intCatId = intval($_POST['category'] ?? "");
            $cat_name = "";
            $cityId = 1;
            $cityName = "";
            $intAdvId = null;

            // Stockage des données adv dans un tableau
            $arrAdvert  = array(
                'adv_title' => $strTitle,
                'adv_details' => $strDetails,
                'adv_price' => $intPrice,
                'adv_status' => $strStatus,
                'adv_Stats_note' => $strStatsNote,
                'adv_Usr_id' => $intUsrId,
                'adv_Cat_id' => $intCatId,
                'adv_city_id' => $cityId,
                'adv_City_name' => $cityName
            );

            if (count($_POST) > 0 && count($_FILES['image']) > 0) {

                $objAdvert->hydrate($arrAdvert); // Hydratation de l'objet avec les données du formulaire

                // Vérification des données et stockage des erreurs
                if ($objAdvert->getTitle() == "") {
                    $arrErrors['title'] = "Le titre de l'annonce est obligatoire";
                }
                if ($objAdvert->getDetails() == "") {
                    $arrErrors['details'] = "Un contenu est obligatoire pour décrire votre annonce";
                }
                if ($objAdvert->getCat_id() == 0) {
                    $arrErrors['category'] = "La catégorie de l'annonce est obligatoire";
                }
                if ($_FILES['image']['name'][0] == ''){
                    $arrErrors['img'] = "Vous devez ajouter au moins une image";
                }
                if (count($_FILES['image']['name']) >= 4){
                    $arrErrors['lessimg'] = "Le nombres d'images uploadées n'est pas correct";
                }

                if (empty($arrErrors) && count($_FILES['image']['name']) <= 4) {
                    // Appel de la méthode addAdvert de la classe AdvertModel
                    $newAdvertId = intval($objAdvertModel->addAdvert($objAdvert));

                    if ($newAdvertId != false) {

                        $arrImageTotal = array(); // Initialisation d'un tableau pour stocker les images
                        // Ajouter toutes les images uploadées à $arrImageTotal
                        foreach ($_FILES['image'] as $key => $value) {
                            foreach ($value as $index => $val) {
                                $arrImageTotal[$index][$key] = $val;
                            }
                        }

                        foreach ($arrImageTotal as $arrImage) {
                            $objImg = new Images(); // Instancie un objet Img
                            
                            // Stockage des données img dans un tableau
                            $arrImageData = array(
                                'img_adv_id' => $newAdvertId,
                                'img_pic' => $arrImage['name'],
                                'img_usr_id' => $intUsrId,
                                'img_cat_id' => $intCatId,
                                'img_type' => $arrImage['type'],
                            );

                            // Hydrate l'objet avec les données de l'image
                            $objImg->hydrate($arrImageData);
                            
                            if (in_array($arrImage['type'], $this->_arrMimesType)) {
                                // Nom de l'image de sortie 
                                $strImgName = bin2hex(random_bytes(5)) . ".webp";
                                $strDest = "assets/img/advert/" . $strImgName;
                                $strSource = $arrImage['tmp_name'];
                                // Redimensionnement de l'image
                                list($width, $height) = getimagesize($strSource);
                                $newwidth = 500; // Nouvelle largeur souhaitée
                                $newheight = intval(($height / $width) * $newwidth); // Calcul de la nouvelle hauteur en conservant le ratio

                                // Création de l'image de destination
                                $dest = imagecreatetruecolor($newwidth, $newheight);

                                // Chargement de l'image source en fonction de son type MIME
                                switch ($arrImage['type']) {
                                    case 'image/jpeg':
                                        $source = imagecreatefromjpeg($strSource);
                                        break;
                                    case 'image/png':
                                        $source = imagecreatefrompng($strSource);
                                        break;
                                    case 'image/webp':
                                        $source = imagecreatefromwebp($strSource);
                                        break;
                                    default:
                                        // Type MIME non pris en charge
                                        $arrErrors['img'] = "Type d'image non pris en charge";
                                        break;
                                }

                                if ($source && $dest) {
                                    // Redimensionnement de l'image
                                    imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                                    // Enregistrement de l'image redimensionnée au format webp
                                    imagewebp($dest, $strDest, 100);

                                    // Libération de la mémoire
                                    imagedestroy($source);
                                    imagedestroy($dest);

                                    // Assignation du nom de l'image à l'objet
                                    $objImg->setPic($strImgName);
                                    // Enregistrement du fichier dans la base de données
                                    $objImgModel->addImg($objImg, $newAdvertId);
                                    $arrSuccess['add'] = "Votre annonce a bien été ajoutée";
                                } else {
                                    // Erreur lors du chargement de l'image
                                    $arrErrors['img'] = "Erreur lors du chargement de l'image";
                                }
                            } else {
                                // Type MIME non pris en charge
                                $arrErrors['img'] = "Type d'image non pris en charge";
                            } // fin if(inarray)
                        } // fin foreach arrImageTotal

                        
                    } 
                } else {
                    $arrErrors['lessimg'] = "Le nombres d'images uploadées n'est pas correct";
                }
            } // fin de la vérification de la soumission du formulaire
            $this->_arrData["arrSuccess"] = $arrSuccess;
            $this->_arrData["arrErrors"] = $arrErrors;
            $this->_arrData["objAdvert"] = $objAdvert;
            $this->_arrData["objImgModel"] = $objImgModel;
            $this->_arrData["add_advert"]  = "selected";
            $this->_arrData["strTitle"]  = "Les annonces de Lookation";
            $this->_arrData["strDesc"]  = "Les annonces de Lookation";
            $this->afficheTpl("add_advert");
        } else {
            
            header("Location:" . parent::BASE_URL . "user/login");
        }
    } // fin de la fonction addAdvert


    /**
     * Fonction de modération d'une annonce
     */

    public function modAdvert()
    {
        if (!empty($_SESSION) && $_SESSION['user']['usr_id'] != 0){
        $strKeywords     = $_POST['keywords'] ?? "";
        $strCity         = $_POST['city'] ?? "";
        $intCategory     = intval($_POST['category'] ?? 0);
        $usrId       = intval($_SESSION['user']['usr_id'] ?? 0);

        $arrSearch         = array(
            'keywords'     => $strKeywords,
            'city'        => $strCity,
            'category'    => $intCategory
        );
        
        // Utilisation de la classe model
        $objAdvModel = new AdvertModel();
        if($_SESSION['user']['stat_name'] == 'Admin' || $_SESSION['user']['stat_name'] == 'Mod'){
            $arrAdvert = $objAdvModel->findAll(0, $arrSearch);
        } elseif ($_SESSION['user']['stat_name'] == 'User') {
            $arrAdvert = $objAdvModel->findOwn($usrId);
        } else {
            header("Location:" . parent::BASE_URL . "error/nothingtoshow");
        }
        
        //Utilisation de la classe Img
        $objImgModel = new ImagesModel();

        // Parcourir les articles pour créer des objets
        $arrAdvertToDisplay = array();

        foreach ($arrAdvert as $arrDetailAdvert) {
            $objAdvert = new Advert();    // instancie un objet Advert
            $objAdvert->hydrate($arrDetailAdvert);
            
            $arrImages = $objImgModel->findImgAdv($objAdvert->getId());

            if ($arrImages === false) {
                $objAdvert->setImg("template_image.png");
            } else {
                $objImages = new Images();    // instancie un objet Images
                $objImages->hydrate($arrImages);
                $objAdvert->setImg($objImages->getPic());
            }
            $arrAdvertToDisplay[] = $objAdvert;
        }
        parent::searchAdvert();

        $this->_arrData["city"] = $strCity;
        $this->_arrData["category"] = $intCategory;
        $this->_arrData["keywords"] = $strKeywords;
        $this->_arrData["strPage"]  = "advert";
        $this->_arrData["strTitle"]  = "Les annonces de Lookation";
        $this->_arrData["strDesc"]  = "Les annonces de Lookation";
        $this->_arrData["arrAdvertToDisplay"] = $arrAdvertToDisplay;

        $this->afficheTpl("mod_advert");
        } else {
            header("Location:" . parent::BASE_URL . "user/login");
        }        
    }


    public function delete()
    {
        // Numéro de l'article à supprimer
        $advId        = $_GET['id'] ?? 0;

        $objAdvertModel    = new AdvertModel();
        $objAdvertModel->delete($advId);
        header("Location:" . parent::BASE_URL . "advert/modAdvert");
    }


    public function editAdvert()
    {
        $advId      = intval($_GET['id']) ?? null;
        $arrErrors  = array();
        $arrSuccess = array();

        // Utilisation de la classe model
        $objAdvModel = new AdvertModel();
        // Chargement de l'objet dans un tableau
        $selectedAdvert = $objAdvModel->selectAdvert($advId);
        // Instanciation de l'objet advert
        $objAdvert = new Advert();
        // Hydratation de l'objet 
        $objAdvert->hydrate($selectedAdvert);
        //utilisation de classe image
        $objImgModel = new ImagesModel();
        // chargement de l'objet dans un tableau
        $arrImages = $objImgModel->findImgAdvAll($advId);
        // Initialisation d'un tableau pour stocker les images
        $arrImagesToDisplay = array();

        /* Intialisation des variable récupéré dans le $_POST */
        $strTitle = $_POST['adv_title'] ?? "";
        $strDetails = $_POST['details'] ?? "";
        $intPrice = intval($_POST['price'] ?? 0);
        $strStatus = $_POST['modAdvert'] ?? 'A';
        $strStatsNote = $_POST['statsNote'] ?? "";
        $intUsrId = intval($_SESSION['user']['usr_id']);
        $intCatId = intval($_POST['category'] ?? 1);
        $cat_name = "";
        $cityId = 1;
        $cityName = "";
        $intAdvId = null;

        // Stockage des données adv dans un tableau
        $arrAdvert  = array(
            'adv_title' => $strTitle,
            'adv_details' => $strDetails,
            'adv_price' => $intPrice,
            'adv_status' => $strStatus,
            'adv_stats_note' => $strStatsNote,
            'adv_Usr_id' => $intUsrId,
            'adv_Cat_id' => $objAdvert->getCat_id(),
            'adv_city_id' => $cityId,
            'adv_City_name' => $cityName
        );

        // Boucle pour récupérer les images, création d'un nouvel objet
        // Hydratation et utilisation de la fonction d'img
        // Stockage dans le tableau arrImagesToDisplay
        foreach ($arrImages as $arrDetailImages) {
            $objImages = new Images();
            $objImages->hydrate($arrDetailImages);
            $objAdvert->setImg($objImages->getPic());
            $arrImagesToDisplay[] = $objImages;
        }

        // Vérification des données et stockage des erreurs
        if ($objAdvert->getTitle() == "") {
            $arrErrors['title'] = "Le titre de l'annonce est obligatoire";
        }
        if ($objAdvert->getDetails() == "") {
            $arrErrors['details'] = "Un contenu est obligatoire pour décrire votre annonce";
        }

        if (empty($arrErrors) && count($_POST) > 0) {
            $objAdvert->hydrate($arrAdvert);
            
            // Appel de la méthode addAdvert de la classe AdvertModel
            $objAdvModel->updateAdvert($advId, $objAdvert);
            $objImg = new Images(); // Instancie un objet Img

            $arrImageData = array(
                'img_adv_id' => $advId,
                'img_pic' => $objAdvert->getImg(),
                'img_usr_id' => $objAdvert->getUsr_id(),
                'img_cat_id' => $objAdvert->getCat_id(),
            );
            $strImgName = $objAdvert->getImg();
            $arrImageTotal = array(); // Initialisation d'un tableau pour stocker les images
            $arrSuccess['update'] = "Votre annonce a bien été modifiée";
        }
        //Stockage des informations dans le tableau _arrData
        parent::searchAdvert();
        $this->_arrData["arrSuccess"] = $arrSuccess;
        $this->_arrData["strPage"]  = "selected";
        $this->_arrData["strTitle"]  = "Les annonces de Lookation";
        $this->_arrData["strDesc"]  = "Les annonces de Lookation";
        $this->_arrData["arrErrors"] = $arrErrors;
        $this->_arrData["objImages"] = $arrImagesToDisplay;
        $this->_arrData["objAdvert"] = $objAdvert;
        $this->afficheTpl("edit_advert");
    }

    private function _shareAdvert($strDestMail, $strSubject, $strBody){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  	= 0;  
        $mail->SMTPAuth   	= TRUE;
        $mail->SMTPSecure 	= "tls";
        $mail->Port       	= 587;
        $mail->Host       	= "smtp.gmail.com";
        $mail->Username 	= 'contact.lookation@gmail.com';
        $mail->Password 	= 'mjoa ulcj rhno ajby';
        $mail->CharSet		= PHPMailer::CHARSET_UTF8;
        $mail->IsHTML(true);
        $mail->setFrom('contact.lookation@gmail.com', 'Lookation, le site de location entre particuliers');
        $mail->addAddress($strDestMail);
        $mail->Subject 	= $strSubject;
        $mail->Body 	= $strBody;
        //$mail->addAttachment('test.txt');

        return $mail->send();

    }
}
