<div class="card">
  <img src="assets/img/advert/{$objAdvert->getImg()}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">
      {$objAdvert->getTitle()}
    </h5>
    <a href="{$base_url}advert/selected&id={$objAdvert->getId()}" class="stretched-link" style="opacity: 0;">
    </a>
    <p class="card-text">
      {$objAdvert->getDetailsSummary(40)}.
    </p>
  </div>
  <div class="card-footer">
    <small class="text-body-secondary">Le {$objAdvert->getDateCrea()}</small>
    <small class="text-body-secondary"> à
      {$objAdvert->getCity_name()}
    </small>
  </div>
</div>