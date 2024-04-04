<?php
    include_once("models/advert_model.php");
    include_once("entities/advert_entity.php");
    include_once("models/user_model.php");
    include_once("entities/user_entity.php");

    class CityCtrl extends Ctrl {

        public function home() {

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

            $this->_arrData["strPage"] = "index";
            
            $this->_arrData["arrCityToDisplay"] = $arrCityToDisplay;

            $this->afficheTpl("home");

            
        }


    }