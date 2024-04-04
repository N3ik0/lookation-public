{extends file="views/layout.tpl"}

{block name="contenu"}
    <main>
        <div class="container">
            <div class="row pt-5 d-flex justify-content-center">
                <div class="col-md-8">
                    <h1>Foire aux questions</h1><br>
                </div>
                <div class="col-md-8">
                {if isset($smarty.session.user) && $smarty.session.user.stat_name == "Admin" }
                    <h4>Q : Que puis-je faire sur lookation ?</h4>
                    <p>R : Vous pouvez consulter la liste des annonces et des utilisateurs a modérer, modifier le profil d'un utilisateur si il ne correspond pas au règles d'utilisation du site, veiller au respect des règles et a l'assiduité des modérateurs.</p>
                    <br>

                {else if isset($smarty.session.user) && $smarty.session.user.stat_name == "Mod" }
                    <h4>Q : Que puis-je faire sur lookation ?</h4>
                    <p>R : Vous pouvez consulter la liste des annonces et des utilisateurs a modérer, modifier le profil d'un utilisateur si il ne correspond pas au règles d'utilisation du site.</p>
                    <br>
                    <h4>Q : </h4>
                    <p>R : </p>
                    <br>

                {else if isset($smarty.session.user) && $smarty.session.user.stat_name == "User" }
                    <h4>Q : Que puis-je faire sur lookation ?</h4>
                    <p>R : Vous pouvez posté des annonces, consulté vos annonces publiées, enregistré des annonces en favoris, contacté le publieur d'une annonce pour des infos supplémentaires.</p>
                    <br>
                    <h4>Q : Comment dois-je m'y prendre pour créer une annonce ?</h4>
                    <p>R : Vous avez uniquement besoin de cliqué sur le bouton "Poster une annonce". Il vous suffira ensuite de renseigné les informations nécessaires afin que nous puissions la prendre en charge et la vérifier pour que d'autres utilisateurs puissent interagir avec.</p>
                    <br>
                    <h4>Q : Que ce passe t'il après avoir créer mon annonce ?</h4>
                    <p>R : Elle sera envoyée a notre équipe de modération afin de pouvoir étre vérifier et ainsi devenir visible par chacun. Il s'agit d'une étape fondamentale afin d'assurer une sécurité ainsi qu'un aspect global conviviale.</p>
                    <br>

                {else}
                    <h4>Q : Que puis-je faire sur lookation ?</h4>
                    <p>R : Vous pouvez créé un compte afin de poster des annonces, consulté vos annonces publiées, enregistré des annonces en favoris, contacté le publieur d'une annonce pour des infos supplémentaires.</p>
                    <br>
                    <h4>Q : Est-il possible de poster une annonce sans etre connecté ?</h4>
                    <p>R : Malheureusement non, une connexion est requise pour pouvoir créer des annonces et intéragir avec d'autres utilisateurs.</p>
                    <br>
                {/if}
                    
                </div>
            </div>
        </div>
    </main>
{/block}

