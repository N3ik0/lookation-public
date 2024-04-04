{extends file="views/layout.tpl"}
{block name="contenu"}
  <div class="container">
    <div class="row">
      {foreach from=$arrCatToDisplay item=objCat}
        <div class="card col-md-4 mt-5" style="width: 15rem;">
          <img src="assets/img/site/{$objCat->getImg()}" class="card-img-top" alt="Photo de categories">
          <div class="card-body">
            {* <h5 class="card-text text-center"><a href="index.php?ctrl=cat&action=advertsOfCategory&id={$objCat->getId()}">{$objCat->getName()}</a></h5> *}
            <div class="text-center">
              <a class="btn mt-1" href="{$base_url}cat/advertsOfCategory&id={$objCat->getId()}"
                role="button">{$objCat->getName()}</a>
            </div>
          </div>
        </div>
      {/foreach}
    </div>
  </div>
{/block}