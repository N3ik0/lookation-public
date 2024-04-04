{extends file="views/layout.tpl"}

{block name="js_head"}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"> </script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
{/block}

{block name="contenu"}
    <div class="container">
        <div class="col-md-6 row justify-content-center mt-5 mb-3" id="orderBy">
            <form action=" index.php?action=advert&ctrl=advert" role="search" method="POST">
                <div class="form-group">
                    <label for="search">Recherche par texte :</label>
                    <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search"
                        name="keywords">
                </div>
                <div class="form row">
                    <div class="form-group col-md-6">
                        <label for="city">Recherche par ville :</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Recherche par ville">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="category">Catégorie :</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">Toutes les catégories</option>
                            {foreach from=$arrCatToDisplay item=objCat}
                                <option value="{$objCat->getId()}">{$objCat->getName()}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form row">
                    <div class="form-group col-md-6">
                        <label for="price">Tri par prix :</label>
                        <select class="form-control" id="price" name="price">
                            <option value="0">Choisissez l'ordre de prix :</option>
                            <option value="0">Tri par prix décroissant</option>
                            <option value="1">Tri par prix croissant</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date">Tri par ancienneté :</label>
                        <select class="form-control" id="OrderByDate" name="OrderByDate">
                            <option value="0">Choisissez une option :</option>
                            <option value="0">Tri du plus récent</option>
                            <option value="1">Tri du plus ancien</option>
                        </select>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn mt-3" id="formButton" type="submit">Rechercher</button>
                </div>
            </form>
        </div>

        <!--Premiere DIV avec 2X4 contenu-->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                {foreach from=$arrAdvertToDisplay item=objAdvert}
                    {include file="views/advert_details_view.tpl"}
                {/foreach}
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
{/block}