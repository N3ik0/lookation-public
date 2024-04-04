{extends file="views/layout.tpl"}

{block name="contenu"}
    <main>
        <div class="container">
            <div class="row pt-5 d-flex justify-content-center">
                <div class="col-md-8">
                    <h1>Support</h1><br>
                </div>
                <div class="col-md-8">
                    <p>Si vous avez le moindre souci, veuillez nous contacter si dessous :</p>
                    <form method="post" enctype="multipart/form-data">

                    <div class="form-group pt-3">
                        <label for="name">Votre nom :</label>
                        <input type="text" id="name" name="name" required class="form-control"
                        placeholder="Votre nom">
                    </div>

                    <div class="form-group pt-3">
                        <label for="mail">Votre adresse mail :</label>
                        <input type="mail" id="mail" name="mail" required class="form-control" rows="5"
                            placeholder="Votre mail"></textarea>
                    </div>

                    <div class="form-group pt-3">
                        <label for="subject">le sujet de votre demande :</label>
                        <input type="text" id="subject" name="subject" required class="form-control"
                        placeholder="Votre sujet">
                    </div>

                    <div class="form-group pt-3">
                        <label for="context">Décrivez nous de manière détaillé votre problème :</label>
                        <textarea id="context" name="context" required class="form-control" rows="5"
                            placeholder="Décrivez votre souci"></textarea>
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