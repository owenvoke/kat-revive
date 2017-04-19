{include file='include/header.tpl'}
<div class="container">
    {if !$data->error && $data->torrent}
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td><p><strong>Name: </strong></td>
                    <td>{$data->torrent['torrent_name']}</td>
                </tr>
                <tr>
                    <td><p><strong>Is Verified: </strong></td>
                    <td>{if $data->torrent['verified']}<span class="fa fa-fw fa-star"></span>{/if}</td>
                </tr>
                <tr>
                    <td><p><strong>Hash: </strong></td>
                    <td>{$data->torrent['torrent_info_hash']}</td>
                </tr>
                <tr>
                    <td><p><strong>Category: </strong></td>
                    <td>{pxgamer\KatRevive\Meta\Categories::byId($data->torrent['category_id'])}</td>
                </tr>
                {if $data->torrent['torrent_info_url'] !== ''}
                    <tr>
                        <td><p><strong>KAT URL: </strong></td>
                        <td><a href="{$data->torrent['torrent_info_url']}"
                               target="_blank">{$data->torrent['torrent_info_url']}</a>
                        </td>
                    </tr>
                {/if}
                <tr>
                    <td><p><strong>Torrage URL: </strong></td>
                    <td><a href="https://torrage.info/torrent.php?h={$data->torrent['torrent_info_hash']}"
                           target="_blank">https://torrage.info/torrent.php?h={$data->torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>iTorrents URL: </strong></td>
                    <td><a href="https://itorrents.org/torrent/{$data->torrent['torrent_info_hash']}.torrent"
                           target="_blank">https://itorrents.org/torrent/{$data->torrent['torrent_info_hash']}
                            .torrent</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Torrentz URL: </strong></td>
                    <td>
                        <a href="https://torrentz.eu/{$data->torrent['torrent_info_hash']}" target="_blank">https://torrentz.eu/{$data->torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>BTCache URL: </strong></td>
                    <td>
                        <a href="https://www.btcache.me/torrent/{$data->torrent['torrent_info_hash']}/"
                           target="_blank">https://www.btcache.me/torrent/{$data->torrent['torrent_info_hash']}/</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>TheTorrent URL: </strong></td>
                    <td><a href="https://thetorrent.org/{$data->torrent['torrent_info_hash']}.torrent"
                           target="_blank">https://thetorrent.org/{$data->torrent['torrent_info_hash']}.torrent</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>TorrentProject URL: </strong></td>
                    <td><a href="https://torrentproject.se/{$data->torrent['torrent_info_hash']}" target="_blank">https://torrentproject.se/{$data->torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Magnet Link: </strong></td>
                    <td>
                        <a href="{pxgamer\KatRevive\Meta\Torrents::magnet($data->torrent['torrent_info_hash'], $data->torrent['torrent_name'])}">
                            <span>
                                magnet:?xt=urn:btih:{$data->torrent['torrent_info_hash']}&dn={$data->torrent['torrent_name']}
                            </span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>File Count: </strong></td>
                    <td>{$data->torrent['files_count']}</td>
                </tr>
                <tr>
                    <td><p><strong>Size: </strong></td>
                    <td>{$data->torrent['size']}</td>
                </tr>
            </table>
        </div>
        {if $data->torrent['description']}
            <div class="panel panel-default panel-collapse">
                <div class="panel-heading collapsed" data-toggle="collapse" data-target="#description">
                    <strong>Description</strong>
                </div>
                <div id="description" class="panel-body collapse">
                    <div>{$data->torrent['description']}</div>
                </div>
            </div>
        {/if}
    {elseif $data->error === 1}
        <div class="alert alert-danger">
            <h1>Invalid Hash Provided</h1>
            <p>
                Providing a hash can be done using the following URL format: <em>/torrent/{'{hash}'}</em>`.<br>
                A hash should:
            </p>
            <ul>
                <li>Be 40 characters long</li>
                <li>Only contain alphanumeric characters</li>
                <li>Be linked to a .torrent file</li>
            </ul>
            <p>
                e.g. <strong>/torrent/74C80815374F44702FFE1F25B10D1788B79282A4</strong>
            </p>
        </div>
        <form action="/torrent" method="post">
            <div class="form-group">
                <input name="hash" type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default form-control">Search Hash</button>
        </form>
    {else}
        <div class="container" style="margin-top: 5%;">
            <div class="alert alert-danger">
                <h2>Error 404 - Torrent does not exist.</h2>
                <p>Unfortunately we couldn't find the torrent you requested.</p>
            </div>
        </div>
    {/if}
</div>
{include file='include/footer.tpl'}