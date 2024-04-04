{extends file="views/layout.tpl"}

{block name="contenu"}
    <main>
        <div class="container">
            <div class="row pt-5 d-flex justify-content-center">
                <div class="col-md-8">
                    <h1>Plan du Site</h1><br>
                </div>
                <div class="col-md-8">
                {if isset($smarty.session.user) && $smarty.session.user.stat_name == "Admin" }
                    <h3>Modèle administrateur</h3>
                {else if isset($smarty.session.user) && $smarty.session.user.stat_name == "Mod" }
                    <h3>Modèle Modérateur</h3>
                {else if isset($smarty.session.user) && $smarty.session.user.stat_name == "User" }
                    <h3>Modèle Utilisateur</h3>
                {else}
                    <h3>Modèle Visiteur</h3>
                {/if}
                </div>
            </div>
        </div>
    </main>
{/block}