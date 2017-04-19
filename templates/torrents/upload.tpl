{include file='include/header.tpl'}
<div class="container">
    <h1>Upload</h1>
    <div class="panel-group">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="torrent[]" multiple>
            </div>
            <button type="submit" name="submit" class="btn btn-default"><span
                        class="glyphicon glyphicon-cloud-upload"></span> Upload .torrent file
            </button>
        </form>
    </div>
    <div class="panel-group">
        {foreach $uploaded as $status}
            {if $status->success}
                <div class="alert alert-success">
                    <p>{$status->torrent['torrent_name']} was imported successfully.</p>
                    <p><a href="/torrent/{$status->torrent['torrent_info_hash']}">Click to view torrent.</a></p>
                    <p><a href="/">Go to Index</a></p>
                </div>
            {elseif isset($status->error) && $status->error == pxgamer\KatRevive\Meta\Torrents::ERROR_INCORRECT_BSON}
                <div class="alert alert-danger">
                    <h4>Incorrect BSON Format</h4>
                    <p>Apologies but we are unable to import this format yet.<br/>
                        <a href="//github.com/PXgamer/KatRevive/issues" target="_blank">Open an issue on Github?</a></p>
                    <br/>When contacting, please provide the following details.<br/>
                    <ul>
                        <li>Torrent client that created the .torrent</li>
                        <li>Link to the .torrent file that you were trying to upload</li>
                    </ul>
                </div>
            {else}
                <div class="alert alert-danger">
                    <p>Failed to import torrent with hash {$status->torrent['torrent_info_hash']}.</p>
                    <pre>{$status|print_r:true}</pre>
                </div>
            {/if}
        {/foreach}
    </div>
</div>
{include file='include/footer.tpl'}