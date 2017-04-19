{include file='include/header.tpl'}
<div class="container">
    <h1>Upload</h1>
    <div class="panel-group">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <div class="f-upload-btn btn btn-lg btn-default">
                    <label for="torrent"><span class="fa fa-fw fa-upload"></span> Select torrent files</label>
                    <input id="torrent" name="torrent[]" multiple type="file" class="upload">
                </div>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="55">-- Unsorted --</option>
                    {foreach $categories as $key=>$value}
                        <option value="{$key}">{$value}</option>
                    {/foreach}
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-default">
                <span class="fa fa-fw fa-upload"></span>
                Upload
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
                    <p>Possible reasons for this are:</p>
                    <ul>
                        <li>Torrent may already exist</li>
                        <li>Torrent may be corrupted in some way</li>
                        <li>Another, unknown error occurred</li>
                    </ul>
                </div>
            {/if}
        {/foreach}
    </div>
</div>
{include file='include/footer.tpl'}