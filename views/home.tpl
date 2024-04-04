{extends file="views/layout.tpl"}


{block name="contenu"}

  <main>
    <section class="container mt-3 mb-5">
      <div class="row justify-content-start">
        <div class="col-md-5 mt-5">
          <h1 class="text-center">Bienvenue chez Lookation</h1>
          <p class="mt-5">
            Lorem Elsass ipsum quam. messti de Bischheim und tellus sit gal
            sagittis schpeck Christkindelsmärik condimentum météor Mauris so
            bissame Oberschaeffolsheim placerat kartoffelsalad amet, mänele
            ornare auctor, Strasbourg yeuh. ante geïz bredele leo gravida
            turpis, sed Pellentesque amet morbi adipiscing hopla Salu bissame
            semper Gal. ac lotto-owe pellentesque salu et blottkopf, Racing.
          </p>
          <div class="text-center">
            <a class="btn mt-3" href="{$base_url}page/about" role="button">En savoir plus</a>
          </div>
        </div>
        <div class="col-md-7 d-flex">
          <div class="pt-5">
            <img src="assets/img/site/mainhero.png" class="imghero img-fluid" />
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- PREMIERES ANNONCES (PREMIUM) -->

  <div class="container mt-5 mb-5" id="cards">
    <div class="card-group text-center">

      {foreach from=$arrAdvertToDisplay item=objAdvert}
        {include file="views/advert_view.tpl"}
      {/foreach}

    </div>
    <div class="text-center mt-3 mb-3">
      <a class="btn mt-4" href="{$base_url}advert/advert" role="button">Découvrez nos annonces</a>
    </div>
  </div>

  <!-- NOS SERVICES -->

  <section id="services">
    <div class="container mt-5 mb-5">
      <div class=" nosservices row justify-content-center">
        <h2 class="col-md-3">Laissez-nous vous rendre service</h2>
        <p class="col-md-5">
          Lorem Elsass ipsum quam. messti de Bischheim und tellus sit gal
          sagittis schpeck Christkindelsmärik condimentum météor Mauris so
          bissame Oberschaeffolsheim placerat kartoffelsalad amet, mänele
          ornare auctor, Strasbourg yeuh. ante geïz bredele leo gravida turpis
        </p>
      </div>
      <div class="row mt-2 mb-5">
        <div class="col-12 text-center">
          <img src="assets/img/site/letushelp.jpg" class="img-fluid" />
        </div>
        <div class="col-md-3 mt-3 mb-3">
        </div>
      </div>
    </div>
  </section>

  <!-- ANNONCES PAR SECTEUR -->

  <div class="container mt-5 mb-5" id="cards">
    <div class="card-group text-center">
      {foreach from=$arrAdvertToDisplay item=objAdvert}
        {include file='views/advert_view.tpl'}
      {/foreach}
    </div>
    <div class="text-center mt-3 mb-3">
      <a class="btn mt-4" href="{$base_url}advert/advert" role="button">Dans votre secteur...</a>
    </div>
  </div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
    integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- CAROUSEL AVEC CATEGORIES -->

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />


  {include file='views/cat_carousel_view.tpl'}

{/block}