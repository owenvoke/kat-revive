{include file='include/header.tpl'}
<div class="container">
    {if !$error && $torrent}
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td><p><strong>Name: </strong></td>
                    <td>{$torrent['torrent_name']}</td>
                </tr>
                <tr>
                    <td><p><strong>Is Verified: </strong></td>
                    <td>{if $torrent['verified']}<span class="glyphicon glyphicon-star-empty"></span>{/if}</td>
                </tr>
                <tr>
                    <td><p><strong>Hash: </strong></td>
                    <td>{$torrent['torrent_info_hash']}</td>
                </tr>
                <tr>
                    <td><p><strong>Category: </strong></td>
                    <td>{pxgamer\KatRevive\Meta\Categories::byId($torrent['category_id'])}</td>
                </tr>
                <tr>
                    <td><p><strong>KAT URL: </strong></td>
                    <td><a href="{$torrent['torrent_info_url']}" target="_blank">{$torrent['torrent_info_url']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>TorCache URL: </strong></td>
                    <td><a href="https://torcache.net/torrent/{$torrent['torrent_info_hash']}.torrent"
                           target="_blank">https://torcache.net/torrent/{$torrent['torrent_info_hash']}.torrent</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Torrage URL: </strong></td>
                    <td><a href="https://torrage.info/torrent.php?h={$torrent['torrent_info_hash']}"
                           target="_blank">https://torrage.info/torrent.php?h={$torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>iTorrents URL: </strong></td>
                    <td><a href="https://itorrents.org/torrent/{$torrent['torrent_info_hash']}.torrent"
                           target="_blank">https://itorrents.org/torrent/{$torrent['torrent_info_hash']}.torrent</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Torrentz URL: </strong></td>
                    <td><a href="https://torrentz.eu/{$torrent['torrent_info_hash']}" target="_blank">https://torrentz.eu/{$torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>BTCache URL: </strong></td>
                    <td><a href="https://www.btcache.me/torrent/{$torrent['torrent_info_hash']}/"
                           target="_blank">https://www.btcache.me/torrent/{$torrent['torrent_info_hash']}/</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>TheTorrent URL: </strong></td>
                    <td><a href="https://thetorrent.org/{$torrent['torrent_info_hash']}.torrent"
                           target="_blank">https://thetorrent.org/{$torrent['torrent_info_hash']}.torrent</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>TorrentProject URL: </strong></td>
                    <td><a href="https://torrentproject.se/{$torrent['torrent_info_hash']}" target="_blank">https://torrentproject.se/{$torrent['torrent_info_hash']}</a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Magnet Link: </strong></td>
                    <td>
                        <a href="{pxgamer\KatRevive\Meta\Torrents::magnet($torrent['torrent_info_hash'], $torrent['torrent_name'])}"<span>magnet:?xt=urn:btih:{$torrent['torrent_info_hash']}&dn={$torrent['torrent_name']}</span></a>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>File Count: </strong></td>
                    <td>1</td>
                </tr>
                <tr>
                    <td><p><strong>Size: </strong></td>
                    <td>2048MB</td>
                </tr>
            </table>
        </div>
    {elseif $error === 1}
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
                <h2>No data has been added to the tables.</h2>
                <p>Please run the installer <a href="/install" class="alert-link">here</a></p>
            </div>
        </div>
    {/if}
</div>
{include file='include/footer.tpl'}