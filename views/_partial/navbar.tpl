    <nav class="navbar navbar-expand-lg navbar-top">
        <div class="container">
            <a class="navbar-brand" href="{$base_url}"><img
                    src="{$base_url}assets/img/site/Lookation-logo-navbar.png"></a>
            <button type="button" class="btn">
                <a href="{$base_url}advert/addAdvert">Poster une annonce</a>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 justify-content-end">
                    <form method="POST" class="d-flex align-items-center" role="search"
                        action="{$base_url}advert/advert" id="formNavBar">
                        <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search"
                            name="keywords">
                        <button class="" type="submit" style=""><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>

                    <li class="nav-item active">
                        <a class="nav-link" href="{$base_url}cat/category">
                            <i class="fa-solid fa-icons"></i>
                            <span>Catégories</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-envelope"></i>
                            <span>Message</span>
                        </a>
                    </li>

                    <li class="nav-item active" id="cookie">
                        {if isset($smarty.session.user.usr_id) && ($smarty.session.user.usr_id) != ''}
                            <a class="nav-link" href="{$base_url}advert/modAdvert">
                                <i class="fa-solid fa-scroll"></i>
                                <span>Mes annonces</span>
                            </a>
                        {/if}
                    </li>

                    <li class="nav-item dropdown d-flex justify-content-center" id="userdd">
                        <a href="#" class="btn dropdown-toggle" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" name="Profile">
                            {if isset($smarty.session.user.usr_id) && $smarty.session.user.usr_id != ''}
                                <li><a class="dropdown-item" href="{$base_url}user/edit_profile">Edit Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="{$base_url}user/logout">Logout</a></li>
                            {else}
                                <li><a class="dropdown-item" href="{$base_url}user/login">Login</a></li>
                            {/if}
                        </ul>
                    </li>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-bot">
        <div class="container">
            <div class="collapse navbar-collapse justify-content-around" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    {foreach from=$arrCatToDisplay item=objCat name=catLoop}
                        {if $smarty.foreach.catLoop.iteration <= 5}
                            <a class="nav-item nav-link"
                                href="{$base_url}cat/advertsOfCategory&id={$objCat->getId()}">{$objCat->getName()}<span
                                    class="sr-only">(current)</span></a>
                        {/if}
                    {/foreach}
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Tous les catégories
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$arrCatToDisplay item=objCat}
                                <li><a class="dropdown-item"
                                        href="{$base_url}cat/advertsOfCategory&id={$objCat->getId()}">{$objCat->getName()}</a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</nav>