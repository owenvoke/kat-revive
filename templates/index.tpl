{include file='include/header.tpl'}
<div class="container" style="margin-top: 5%;">
    {if $torrents}
        {include file='include/pagination.tpl'}
        {include file='torrents/torrents_table.tpl'}
        {include file='include/pagination.tpl'}
    {else}
        <div class="alert alert-danger">
            <h2>No data has been added to the tables.</h2>
            <p>Please run the installer <a href="/install" class="alert-link">here</a></p>
        </div>
    {/if}
</div>
{include file='include/footer.tpl'}