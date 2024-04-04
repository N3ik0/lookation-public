{extends file="views/layout.tpl"}

{block name="contenu"}
    <main>
        <div class="container">
            <div class="row pt-5 d-flex justify-content-center">
                <div class="col-md-8">
                    <h1>Rejoignez notre équipe</h1><br>
                </div>
                <div class="col-md-8">
                    <p>Vous êtes développeur et vous souhaitez nous rejoindre? N'hésitez pas! Renseignez nous vite vos coordonées afin que nous puissions établir un contact avec vous :</p>
                    <form method="post" enctype="multipart/form-data">

                    <div class="form-group pt-3">
                        <label for="name">Votre nom :</label>
                        <input type="text" id="name" name="name" required class="form-control"
                        placeholder="Votre nom">
                    </div>

                    <div class="form-group pt-3">
                        <label for="firstname">Votre prénom :</label>
                        <input type="text" id="firstname" name="firstname" required class="form-control"
                        placeholder="Votre prénom">
                    </div>

                    <div class="form-group pt-3">
                        <label for="mail">Votre adresse mail :</label>
                        <input type="mail" id="mail" name="mail" required class="form-control"
                            placeholder="Votre mail"></textarea>
                    </div>

                    <div class="form-group pt-3">
                        <label for="cursus">Votre parcours professionnel :</label>
                        <textarea id="cursus" name="cursus" required class="form-control" rows="5"
                        placeholder="Votre parcours"></textarea>
                    </div>

                    <div class="form-group pt-3">
                        <label for="reason">La raison de votre demande :</label>
                        <textarea id="reason" name="reason" required class="form-control" rows="5"
                            placeholder="Votre raison"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
{/block}