{extends file="views/layout.tpl"}

{block name="contenu"}
    <div class="container" id="selected">
        <div class="row mt-4 text-start">
            <div class="col-md-8 mb-3">
                <h5 class="">
                    {$objAdvert->getTitle()}
                </h5>
                <p class="card-text">
                    {$objAdvert->getDetailsSummary()}
                </p>
                <div>
                    <p class="card-text">
                        Annonce publiée le :
                    </p>
                    <p class="card-text">

                        {$objAdvert->getDateCreaFR()}
                    </p>
                </div>
                <p class="card-text">
                    Prix :
                    {$objAdvert->getPrice()}
                </p>
            </div>
            <div class="col-md-2 mt-4 offset-0">
                <h6>Cette annonce vous intéresse ?</h6>
                <button type="button" class="btn btn-primary" id="shareAdvert">Partager</button>
                <button type="button" class="btn btn-primary">Contacter</button>
                <div class="text-center mt-2" id="shareDiv" style="display: none;">
                    <form action="{$base_url}advert/selected?id={$objAdvert->getId()}" method="post">
                        <input type="text-area" id="mail" placeholder="Entrez l'adresse mail" name="destMail"></br>
                        <button type="submit" class=" btn btn-primary mt-3">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {foreach from=$objImages item=objImg}
                <div id="selectedPic">
                    <img src="assets/img/advert/{$objImg->getPic()}" class="img-thumbnail" alt="{$objImg->getPic()}">
                </div>
            {/foreach}
        </div>
    </div>
{/block}

{block name="js_footer"}
    {literal}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('shareAdvert').addEventListener('click', function() {
                    // Trouver la div à afficher
                    var shareDiv = document.getElementById('shareDiv');
                    // Modifier le style pour afficher la div
                    shareDiv.style.display = 'block';
                });
            });
        </script>
    {/literal}
{/block}