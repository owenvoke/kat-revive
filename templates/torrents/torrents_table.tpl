<div class="table-responsive">
    <table class="table table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>Hash</th>
            <th>Name</th>
            <th>Category</th>
            <th colspan="3">URLs</th>
        </tr>
        </thead>

        <tbody>
        {foreach $torrents as $torrent}
            <tr>
                <td>{if $torrent['verified']}<span class="glyphicon glyphicon-star-empty"></span>{/if}</td>
                <td>{$torrent['torrent_info_hash']}</td>
                <td>
                    <a href="/torrent/{$torrent['torrent_info_hash']}" target="_blank">{$torrent['torrent_name']}</a>
                </td>
                <td>{pxgamer\KatRevive\Meta\Categories::byId($torrent['category_id'])}</td>
                <td>
                    <a href="{pxgamer\KatRevive\Meta\Torrents::magnet($torrent['torrent_info_hash'], $torrent['torrent_name'])}"
                       target="_blank" title="Download magnet">
                        <span class="glyphicon glyphicon-cloud-download"></span>
                    </a>
                </td>
                <td>
                    <a href="http://torrage.info/torrent.php?h={$torrent['torrent_info_hash']}" target="_blank"
                       title="Download .torrent from Torrage">
                        <span class="fa fa-fw fa-download text-success"></span>
                    </a>
                </td>
                <td>
                    <a href="http://itorrents.org/torrent/'.$arrM['torrent_info_hash'].'.torrent" target="_blank"
                       title="Download .torrent from iTorrents">
                        <span class="fa fa-fw fa-download text-warning"></span>
                    </a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>