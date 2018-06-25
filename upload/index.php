<!DOCTYPE html>
<html lang="en">
    <?php include '../head.php'; ?>
    <body>
        <?php
        include '../nav.php';
        require('../funcs.php');
        $db_conn = \funcs\Functions::conn();
        ?>
        <div class="container" style="margin-top: 5%;">
            <?php
                if (isset($_FILES['torrent']['name']) && $_FILES['torrent']['size'] > 0) {
                    include './Torrent.php';

                    $len = count($_FILES['torrent']['name']);

                    for ($i = 0; $i < $len; ++$i) {
                        $torrent_content = file_get_contents($_FILES['torrent']['tmp_name'][$i]);
                        addTorrentToDB($torrent_content, $db_conn);
                    }
                }
                    ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control btn btn-default" style="cursor: pointer;" type="file" name="torrent[]" multiple>
                </div>
                <button type="submit" name="submit" class="btn btn-default"><span class="glyphicon glyphicon-cloud-upload"></span> Upload .torrent file</button>
            </form>
        </div>
    </body>
</html>

<?php

function addTorrentToDB($torrent_content = '', $db_conn = false)
{
    if (isset($torrent_content) && $torrent_content !== null) {
        $torrent_data = parse_torrent($torrent_content);
        $file_count = 1;
        $total_size = 1;
        if (isset($torrent_data['info']['files']) && $torrent_data['info']['files'] !== null) { // Check if files param exists
            for ($i = 0; $i < count($torrent_data['info']['files']) - 1; ++$i) {
                $total_size = $total_size + (int) $torrent_data['info']['files'][$i]['length'];
            }
            $file_count = count($torrent_data['info']['files']);
        }

        if (isset($total_size) && isset($torrent_data['info_hash']) && isset($torrent_data['info']['name'])) {
            if (!isset($torrent_data['creation date'])) {
                $torrent_data['creation date'] = date('now');
            }

            $torrent = array(
                    'torrent_name' => $torrent_data['info']['name'],
                    'torrent_info_hash' => strtoupper($torrent_data['info_hash']),
                    'torrent_download_url' => 'http://torcache.net/torrent/'.strtoupper($torrent_data['info_hash']).'.torrent',
                    'size' => $total_size,
                    'upload_date' => $torrent_data['creation date'],
                    'files_count' => $file_count,
            );
            $sql = "INSERT INTO t_collection (torrent_info_hash, torrent_name, torrent_download_url, size, files_count, upload_date) VALUES ('".
            mysqli_real_escape_string($db_conn, $torrent['torrent_info_hash'])."','".
            mysqli_real_escape_string($db_conn, $torrent['torrent_name'])."','".
            mysqli_real_escape_string($db_conn, $torrent['torrent_download_url'])."',".
            mysqli_real_escape_string($db_conn, $torrent['size']).','.
            mysqli_real_escape_string($db_conn, $torrent['files_count']).",'".
            mysqli_real_escape_string($db_conn, $torrent['upload_date'])."');";

            //echo $sql; /* Debugging */
            $res = \funcs\Functions::query($db_conn, $sql);

            if ($res) {
                ?>
<div class="alert alert-success">
<p><?php echo $torrent['torrent_name'];
                ?> was imported successfully.</p>
<p><a href="/hash/?h=<?php echo $torrent['torrent_info_hash'];
                ?>">Click to view torrent.</a></p>
<?php if ($file_count == 0 || $total_size == 0 || $torrent_data['info']['name']) {
    ?>
<p><a href="/edit/?h=<?php echo $torrent['torrent_info_hash'];
    ?>">Torrent was missing some details, please edit them here.</a></p>
<?php

}
                ?>
<p><a href="/">Go to Index</a></p>
</div>
<?php

            } else {
                ?>
<div class="alert alert-danger">
<p>Failed to import torrent with hash <?php echo $torrent['torrent_info_hash'];
                ?>.</p>
<p><?php echo mysqli_error($db_conn);
                ?></p>
</div>
<?php

            }
        } else {
            ?>
<div class="alert alert-danger">
<p>Incorrect BSON Format</p>
<p>Apologies but we are unable to import this format yet. Please contact PXgamer via one of the following methods:<br/><ul><li>PM PXgamer on <a class="alert-link" href="https://katcr.co/community/index.php?action=pm;sa=send;u=31">KickassTorrents</a>.</li><li>Add a comment to the <a class="alert-link" href="https://github.com/PXgamer/KatRevive/issues/15">open issue on Github</a>.</li></ul><br/><br/>When contacting, please provide the following details.<br/><ul><li>Torrent client that created the .torrent</li><li>Link to the .torrent file that you were trying to upload</li></ul></p>
<p><pre><?php var_dump($torrent_data);
            ?></pre></p>
</div>
<?php

        }
    }
}
