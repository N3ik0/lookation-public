<div class="card mb-3 mt-5" id="cards-details">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="assets/img/advert/{$objAdvert->getImg()}" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8 adv-details d-flex flex-column">
            <div class="card-body">
                <h5 class="card-title">
                    {$objAdvert->getTitle()}
                </h5>
                <p class="card-text">
                    {$objAdvert->getDetailsSummary()}
                </p>
                <p class="card-text">
                    <small class="text-body-secondary">
                        {$objAdvert->getDateCrea()}
                    </small>
                </p>
            </div>
            <div class="d-flex justify-content-end">
                <a href="index.php?action=selected&ctrl=advert&id={$objAdvert->getId()}" class="btn">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>