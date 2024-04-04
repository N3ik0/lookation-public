{extends file="views/layout.tpl"}

{block name="js_head"}
	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
	<script src="https://code.jquery.com/jquery-3.7.1.js"> </script>
	<script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
{/block}

{block name="contenu"}
	<div class="container my-5">
		<div class="row">
			<table id="user_list">
				<thead>
					<tr>
						<th>ID</th>
						<th>Login</th>
						<th>Nom</th>
						<th>Inscription</th>
						<th>Mail</th>
						<th>Newsletter</th>
						<th>Status</th>
						<th>Edition</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$arrUsers item=objUser}
						<tr>
							<td>{$objUser->getID()}</td>
							<td>{$objUser->getLogin()}</td>
							<td>{$objUser->getFirstname()}&nbsp;{$objUser->getName()}</td>
							<td>{$objUser->getSignup_date()}</td>
							<td>{$objUser->getMail()}</td>
							<td>{if $objUser->getNewsletter() == 0}Non{else}Oui{/if}</td>
							<td>
								{if $objUser->getStat_id() == 1}
									Admin
								{elseif $objUser->getStat_id() == 2}
									Mod
								{elseif $objUser->getStat_id() == 2}
									User
								{else}
									Banni
								{/if}
							</td>
							<td><a href="{$base_url}user/edit_profile&usrId={$objUser->getID()}">éditer profil</a></td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
{/block}

{block name="js_footer"}
	{literal}
		<script>
			// Merci Christel pour les DataTables :-)
			var table = new DataTable('#user_list', {
				language: {
					url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/fr-FR.json',
				},
				columns: [{width: '5%'}, {width: '15%'}, {width: '12%'}, {width: '20%'}, {width: '23%'}, {width: '5%'}, {width: '10%'}, {width: '10%'}],
			});
		</script>
	{/literal}
{/block}