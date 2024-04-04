{extends file="views/layout.tpl"}

{block name="contenu"}

    <!-- affichage du profil utilisateur // version utilisateur -->
    <div class="container my-5">

        <!-- tableau d'erreurs -->
        {if (count($arrErrors) > 0)}
            <div class="row">
                <div class="col-6 alert alert-danger">
                    <ul>
                        {foreach from=$arrErrors item=strError}
                            <li>{$strError}</li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        {/if}

        <!-- formulaire de connexion -->
        <div class="wrapper">
            <form class="form-signin" id="login-form" method="POST">
                <h2 class="form-signin-heading text-center mt-3">Page de connexion</h2>
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="checkbox text-center">
                    <a href="index.php?ctrl=user&action=create_account">Pas encore inscrit ? Par ici !</a>
                </div>
                <div class="checkbox text-center">
                    <a href="index.php?ctrl=user&action=create_account">Mot de passe oublié ?</a>
                </div>
                <div class="text-center">
                    <button class="btn mt-3" id="formButton" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
{/block}