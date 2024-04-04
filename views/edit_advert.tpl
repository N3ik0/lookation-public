{extends file="views/layout.tpl"}

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
                <h1>Modification de votre annonce</h1>
                <form action="{$base_url}advert/editAdvert?id={$objAdvert->getId()}" method="post"
                    enctype="multipart/form-data">
                    <div>
                        <div class="form-group pt-3">
                            <label for="titre">Titre de l'annonce</label>
                        <input type="text" id="titre" name="adv_title" required class="form-control" placeholder=""
                            value="{$objAdvert->getTitle()}">
                    </div>

                    <div class="form-group pt-3">
                        <label for="contenu">Contenu de l'annonce</label>
                            <textarea id="contenu" name="details" class="form-control" rows="5"
                                placeholder="Décrivez votre annonce">{$objAdvert->getDetailsSummary()}</textarea>
                        </div>

                        <div class="form-group pt-3">
                            <label for="prix">Prix de l'annonce (€)</label>
                        <input type="number" id="price" name="price" placeholder="Prix de l'annonce"
                            value="{if (!empty($objAdvert->getPrice()))}{$objAdvert->getPrice()}{/if}">
                    </div>

                    <div class="form-group pt-3">
                        <label for="categorie">Catégorie</label>
                        <select id="category" name="category" class="form-control">
                            <option value="">Sélectionnez une catégorie</option>
                            {foreach from=$arrCatToDisplay item=objCat}
                            <option value={$objCat->getId()}>{$objCat->getName()}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group pt-3">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {foreach from=$objImages item=objImg}
                                <div id="selectedPic" class="text-center">
                                    <img src="assets/img/advert/{$objImg->getPic()}" class="img-thumbnail" alt="...">
                                </div>
                                {/foreach}
                            </div>
                        </div>

                        {if ($smarty.session.user.stat_name) == "Admin" || ($smarty.session.user.stat_name) == "Mod"}
                        <h4 class="text-center mt-5">Partie pour la modération</h4>
                        <select id="modAdvert" name="modAdvert" class="form-control text-center col-md-8 mt-3 mb-3">
                            <option value="A">Sélectionnez une option</option>
                            <option value="V">Valider l'annonce</option>
                            <option value="R">Refuser l'annonce</option>
                        </select>
                        <textarea id="statsNote" name="statsNote" class="form-control" rows="5" placeholder="Entrez une note">{$objAdvert->getStats_note()}</textarea>
                        {/if}
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Publier la modification</button>
                    </div>
                </form>
            </div>
        </div>
{/block}