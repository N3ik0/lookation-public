<div id='slider' class="container">
    {foreach from=$arrCatToDisplay item=objCat}
        <div class="card" id="carousel" style="height:auto; position: relative;">
            <img src="assets/img/site/{$objCat->getImg()}" class="card-img-top" alt="...">
            <div class="card-body">
                <div class="text-center">
                    <a class="btn mt-1" href="{$base_url}cat/advertsOfCategory&id={$objCat->getId()}"
                        role="button">{$objCat->getName()}</a>
                </div>
            </div>
        </div>
    {/foreach}
</div>

{literal}
    <script>
        $(document).ready(function() {
            console.log('okkk')
            $('#slider').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1
            });
        })
    </script>
{/literal}