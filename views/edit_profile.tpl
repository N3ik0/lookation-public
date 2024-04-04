{extends file="views/layout.tpl"}

{block name="contenu"}

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

		<div class="row">
			<div class="col-6 form-signin">
				<form action="index.php?ctrl=user&action=edit_profile" method="post">

					<fieldset class="my-3 p-2 border">
						<legend class="text-center">Page d'édition du profil</legend>
					<div class="form-group pb-3">
						<label for="login">Login</label><span class="form-mandatory">*</span>
						<input type="text" class="form-control" id="login" name="login" value="{$objUser->getLogin()}">
					</div>
					<div class="form-group pb-3">
						<label for="mail">E-mail</label><span class="form-mandatory">*</span>
						<input type="email" class="form-control" id="mail" name="mail" value="{$objUser->getMail()}">
					</div>
				</fieldset>

				<fieldset class="my-3 p-2 border">
					<legend class="text-center">Mot de passe</legend>
					<div class="form-group pb-3">
						<label for="passwordOld">Ancien mot de passe</label><span class="form-mandatory">*</span>
						<input type="password" class="form-control" id="passwordOld" name="passwordOld">
					</div>
					<div class="form-group pb-3">
						<label for="password">Nouveau mot de passe</label><span class="form-mandatory">*</span>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<div class="form-group pb-3">
						<label for="passwordCheck">Nouveau mot de passe (vérification)</label><span
							class="form-mandatory">*</span>
						<input type="password" class="form-control" id="passwordCheck" name="passwordCheck">
					</div>
				</fieldset>

				<fieldset class="my-3 p-2 border">
					<legend class="text-center">Utilisateur</legend>
					<div class="form-group pb-3">
						<label for="firstname">Prénom</label><span class="form-mandatory">*</span>
						<input type="text" class="form-control" id="firstname" name="firstname"
							value="{$objUser->getFirstname()}">
					</div>
					<div class="form-group pb-3">
						<label for="name">Nom</label><span class="form-mandatory">*</span>
						<input type="text" class="form-control" id="name" name="name" value="{$objUser->getName()}">
					</div>
					<div class="form-group pb-3">
						<label for="birthdate">Date de naissance</label><span class="form-mandatory">*</span>
						<input type="date" class="form-control" id="birthdate" name="birthdate"
							value="{$objUser->getBirthdate()}"
							{if ($smarty.session.user.stat_name != "Mod" || $smarty.session.user.stat_name != "Admin")}disabled{/if}>{* ne pas autoriser la modification de la date de naissance, sauf pour les admin / mod, pour éviter qu'un mineur ne s'inscrire puis ne modifie sa date de naissance par la suite *}
					</div>
					<div class="form-group pb-3">
						<label for="phone">Téléphone</label>
						<input type="tel" class="form-control" id="phone" name="phone"
							value="{if (!empty($objUser->getPhone))}{$objUser->getPhone()}{/if}">
					</div>
				</fieldset>

				<fieldset class="my-3 p-2 border">
					<legend class="text-center">Adresse</legend>
					<div class="form-group pb-3">
						<label for="address">Adresse</label><span class="form-mandatory">*</span>
						<input type="text" class="form-control" id="address" name="address"
							value="{$objUser->getAddress()}">
					</div>
					<div class="form-group pb-3">
						<label for="address_comp">Adresse (complément)</label>
						<input type="text" class="form-control" id="address_comp" name="address_comp"
							value="{$objUser->getAddress_comp()}">
					</div>

					<div class="form-group pb-3">
						<label for="city_name">Ville</label><span class="form-mandatory">*</span>
						<input type="text" class="form-control" id="city_name" name="city_name"
							value="{$objCity->getName()}">
					</div>
					<div>
						<div class="form-group pb-3">
							<label for="city_zip " class="text-center">Code postal</label><span
								class="form-mandatory">*</span>
							<input type="text" class="form-control" id="city_zip" name="city_zip"
								value="{$objCity->getZip()}">
						</div>
				</fieldset>

				<fieldset class="my-3 p-2 border">
					<legend class="text-center">Newsletter</legend>
					<div class="form-check pb-3 ">
						<input type="checkbox" class="form-check-input" id="newsletter" name="newsletter"
							{if ($objUser->getNewsletter() == 1)}checked{/if}>
						<label class="form-check-label" for="newsletter" value="1">Inscription à la newsletter</label>
					</div>
				</fieldset>

				{if (isset($smarty.session.user.stat_name) && ($smarty.session.user.stat_name == "Admin"))}
				<div class="alert alert-info">
					<legend class="text-center">Paramètres de modérateur</legend>
					<div class="form-check pb-3">
						<label for="stat_id">Statut de l'utilisateur</label>
						<select name="stat_id" id="stat_id">
							{foreach from=$arrStatus item=status}
								<option value="{$status->getId()}" {if ($objUser->getStat_id() == $status->getId())}selected
									{/if}>{$status->getName()}
								</option>
							{/foreach}
						</select>
					</div>
					<div class="form-check pb-3">
						<label for="signup_date">Date d'inscription</label>
						<input type="date" name="signup_date" id="signup_date" value="{*$objUser->getSignup_date()*}"
							disabled>
					</div>
					<div class="form-check pb-3">
						<label for="user_id">Identifiant utilisateur</label>
						<input type="text" name="user_id" id="user_id" value="{$objUser->getID()}" disabled>
					</div>
					{if ($smarty.session.user.stat_name == "Admin")}
					<div class="form-check pb-3">
						<label for="delete_user">Supprimer l'utilisateur</label>
								<!-- demander confirmation (via MDP sur une autre page ? seulement pour admin ?) -->
								<input type="checkbox" class="form-check-input" id="delete_user" name="delete_user">
							</div>
						{/if}
					</div>
				{/if}
				<div class="text-end">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
{/block}