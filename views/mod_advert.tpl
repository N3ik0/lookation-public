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
    {assign var="role" value=(switch)}
    {if (!empty($smarty.session.user))}
        <div class="container mt-5 mb-5">
            <table id="list_article">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>img</th>
                        <th>titre</th>
                        <th>contenu</th>
                        <th>validé</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$arrAdvertToDisplay item=objAdvert}
                        <tr>
                            <td class="text-center">{$objAdvert->getId()}</td>
                            <td class="text-center col-md-2"><img class="img-thumbnail"
                                    src="assets/img/advert/{$objAdvert->getImg()}" alt="{$objAdvert->getTitle()}"></td>
                            <td>{$objAdvert->getTitle()}</td>
                            <td>{$objAdvert->getDetailsSummary()}</td>
                            <td class="text-center">
                                {if $objAdvert->getStatus() == 'V'}
                                    <i class="text-success fa fa-check"></i>
                                {elseif $objAdvert->getStatus() == 'A'}
                                    <i class="fa-solid fa-hourglass-start"></i>
                                {else}
                                    <i class="text-danger fa fa-xmark"></i>
                                {/if}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="{$base_url}advert/editAdvert?id={$objAdvert->getId()}"
                                    alt="Modifier l'article"><i class="fa fa-edit"></i></a>
                                {if ($smarty.session.user.stat_name) == "Admin" || ($smarty.session.user.stat_name) == "Mod"}
                                    <a class="btn btn-secondary" href="{$base_url}advert/editAdvert?id={$objAdvert->getId()}"
                                        alt="Modérer l'article"><i class="fa fa-check-double"></i></a>
                                {/if}
                                <a class="btn btn-danger" href="{$base_url}advert/delete?id={$objAdvert->getId()}"
                                    alt="Supprimer l'article"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {/if}
{/block}

{block name="js_footer"}
    {literal}
        <script>
            var table = new DataTable('#list_article', {
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/fr-FR.json',
                },
                columns: [{width: '5%'}, {width: '15%'}, {width: '12%'}, {width: '25%'}, {width: '5%'}, {width: '15%'}],
            });
        </script>
    {/literal}
{/block}