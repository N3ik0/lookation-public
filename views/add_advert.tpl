{extends file="views/layout.tpl"}

/**
* Template d'affichage d'ajout d'article
* @author Valentin
*/

{block name="contenu"}


    <div class="container w-50 mt-5">
        {if count($arrErrors) > 0}
            <div class="alert alert-danger" role="alert">
                <ul>
                    {foreach $arrErrors as $error}
                        <li>{$error}</li>
                    {/foreach}
                </ul>
            </div>
        {/if}
    </div>
    <div class="container w-50 mt-5">
        {if count($arrSuccess) > 0}
            <div class="alert alert-success" role="success">
                <ul>
                    {foreach $arrSuccess as $success}
                        <li>{$success}</li>
                    {/foreach}
                </ul>
            </div>
        {/if}
    </div>

    <div class="container">
        <div class="row pt-5 d-flex justify-content-center">
            <div class="col-md-8">
                <h1>Ajouter une annonce</h1>
                <form action="{$base_url}advert/addAdvert" method="post" enctype="multipart/form-data">
                    <div>
                        <div class="form-group pt-3">
                            <label for="titre">Titre de l'annonce</label>
                        <input type="text" id="titre" name="adv_title" required class="form-control"
                            placeholder="Entrez le titre de l'annonce"
                            value="{if (!empty($objAdvert->getTitle()))}{$objAdvert->getTitle()}{/if}">
                    </div>

                    <div class="form-group pt-3">
                        <label for="contenu">Contenu de l'annonce</label>
                        <textarea id="contenu" name="details" required class="form-control" rows="5"
                            placeholder="Décrivez votre annonce">{if (!empty($objAdvert->getDetailsSummary()))}{$objAdvert->getDetailsSummary()}{/if}</textarea>
                    </div>

                    <div class="form-group pt-3">
                        <label for="prix">Prix de l'annonce (€)</label>
                        <input type="number" id="price" name="price" placeholder="Prix de l'annonce"
                            value="{if (!empty($objAdvert->getPrice()))}{$objAdvert->getPrice()}{/if}">
                    </div>

                    <div class="form-group pt-3">
                        <label for="categorie">Catégorie</label>
                        <select id="categorie" name="category" required class="form-control">
                            <option value="">Sélectionnez une catégorie</option>
                            {foreach from=$arrCatToDisplay item=objCat}
                            <option value={$objCat->getId()}>{$objCat->getName()}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group pt-3">
                        <label for="photo">Photo de l'annonce (limite de 4 photos par annonce)</label><br>
                            <input type="file" id="photo" name="image[]" class="form-control-file" multiple>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3">Publier l'annonce</button>
                        </div>
                </form>
            </div>
{/block}