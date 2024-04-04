{extends file="views/layout.tpl"}

{block name="contenu"}

	<!-- indiquer quels champs sont obligatoires / facultatifs -->
	<div class="container my-5">

		<!-- tableau d'erreurs -->
		{if (count($arrErrors) > 0)}
			<div class="row">
				<div class="col-6 offset-3 alert alert-danger">
					<ul>
						{foreach from=$arrErrors item=strError}
							<li>{$strError}</li>
						{/foreach}
					</ul>
				</div>
			</div>
		{/if}

		<div class="row">
			<div class="col-2"></div>
			<div class="col-8">
				<form action="{$base_url}user/create_account" method="post" class="form-signin">

					<fieldset class="my-3 p-2 border">
						<legend>Connexion</legend>
						<div class="form-group pb-3">
							<label for="login">Login</label><span class="form-mandatory">*</span>
							<input type="text" class="form-control" id="login" name="login"
								value="{if isset(!empty($objUser->getLogin()))}{$objUser->getLogin()}{/if}">
						</div>
						<div class="form-group pb-3">
							<label for="password">Mot de passe</label><span class="form-mandatory">*</span>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<div class="form-group pb-3">
							<label for="passwordCheck">Mot de passe (vérification)</label><span
								class="form-mandatory">*</span>
							<input type="password" class="form-control" id="passwordCheck" name="passwordCheck">
						</div>
						<div class="form-group pb-3">
							<label for="mail">E-mail</label><span class="form-mandatory">*</span>
							<input type="email" class="form-control" id="mail" name="mail"
								value="{if (!empty($objUser->getMail()))}{$objUser->getMail()}{/if}">
						</div>
					</fieldset>

					<fieldset class="my-3 p-2 border">
						<legend>Utilisateur</legend>
						<div class="form-group pb-3">
							<label for="firstname">Prénom</label><span class="form-mandatory">*</span>
							<input type="text" class="form-control" id="firstname" name="firstname"
								value="{if (!empty($objUser->getFirstname()))}{$objUser->getFirstname()}{/if}">
						</div>
						<div class="form-group pb-3">
							<label for="name">Nom</label><span class="form-mandatory">*</span>
							<input type="text" class="form-control" id="name" name="name"
								value="{if (!empty($objUser->getName()))}{$objUser->getName()}{/if}">
						</div>
						<div class="form-group pb-3">
							<label for="birthdate">Date de naissance</label><span class="form-mandatory">*</span>
							<input type="date" class="form-control" id="birthdate" name="birthdate"
								value="{if (!empty($objUser->getBirthdate()))}{$objUser->getBirthdate()}{/if}">
						</div>
						<div class="form-group pb-3">
							<label for="phone">Téléphone</label>
							<input type="tel" class="form-control" id="phone" name="phone"
								value="{if (!empty($objUser->getPhone()))}{$objUser->getPhone()}{/if}">
						</div>
					</fieldset>

					<fieldset class="my-3 p-2 border">
						<legend>Adresse</legend>
						<div class="form-group pb-3">
							<label for="address">Adresse</label><span class="form-mandatory">*</span>
							<input type="text" class="form-control" id="address" name="address"
								value="{if (!empty($objUser->getAddress()))}{$objUser->getAddress()}{/if}">
						</div>
						<div class="form-group pb-3">
							<label for="address_comp">Adresse (complément)</label>
							<input type="text" class="form-control" id="address_comp" name="address_comp"
								value="{if (!empty($objUser->getAddress_comp()))}{$objUser->getAddress_comp()}{/if}">
						</div>

						<div class="form-group pb-3">
							<label for="city_name">Ville</label><span class="form-mandatory">*</span>
							<input type="text" class="form-control" id="city_name" name="city_name"
								value="{if (!empty($objCity->getName()))}{$objCity->getName()}{/if}">
						</div>
						<div>
							<div class="form-group pb-3">
								<label for="city_zip">Code postal</label><span class="form-mandatory">*</span>
								<input type="text" class="form-control" id="city_zip" name="city_zip"
									value="{if (!empty($objCity->getZip()))}{$objCity->getZip()}{/if}">
							</div>
					</fieldset>

					<fieldset class="my-3 p-2 border">
						<legend>Newsletter</legend>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="newsletter" name="newsletter"
								{if ($objUser->getNewsletter() == 1)}checked{/if}>
							<label class="form-check-label" for="newsletter" value="1">Inscription à la newsletter</label>
						</div>
					</fieldset>

					<button type="submit" class="btn btn-primary">Submit</button>
				</form>

			</div>
			<div class="col-2"></div>
		</div>
	</div>

{/block}