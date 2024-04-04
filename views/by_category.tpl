{extends file="views/layout.tpl"}
{block name="contenu"}
    <div class="container">
        <h2 class="mt-5">Annonces dans la catégorie: {$categoryDetails.cat_name}</h2>
        <div class="row">
            {foreach from=$adverts item=advert}
                <div class="col-md-4 mt-5">
                    <div class="card" style="width: 18rem;">
                        {if $advert.img_pic}
                            <img src="assets/img/advert/{$advert.img_pic}" class="card-img-top" alt="Image de l'annonce">
                        {else}
                            <img src="assets/img/site/template_image.png" class="card-img-top" alt="Image par défaut">
                        {/if}
                        <div class="card-body">
                            <h5 class="card-title">{$advert.adv_title}</h5>
                            <p class="card-text">{$advert.adv_details|truncate:80:"...":true}</p>
                            <a href="index.php?ctrl=advert&action=selected&id={$advert.adv_id}" class="btn btn-primary">Voir
                                plus</a>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/block}