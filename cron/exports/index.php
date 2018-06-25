<!DOCTYPE html>
<html lang="en">
    <?php include('../../head.php'); ?>
    <body>
        <?php include('../../nav.php'); ?>
        <div class="container">
            <table class="table">
            <tr><th>Latest MySQL Dumps</th><th>Date Created</th></tr>
            <?php
            function scan_dir($dir = ".") {
                $ignored = array('.', '..', '.htaccess', 'index.php');

                $files = array();
                foreach (scandir($dir) as $file) {
                    if (in_array($file, $ignored)) continue;
                    $files[$file] = filemtime($dir.'/'.$file);
                }

                arsort($files);
                $files = array_keys($files);

                return ($files) ? $files : false;
            }

            $dir_files = scan_dir(".");

            for ($i = 0; $i < count($dir_files); $i++) { ?>
                <tr><td><a href="/cron/exports/<?php echo $dir_files[$i]; ?>"><?php echo $dir_files[$i]; ?></a></td><td><?php echo preg_replace("/daily_dump_([0-9]{4}-[0-9]{2}-[0-9]{2})\.sql.gz/", "$1", $dir_files[$i]); ?></td></tr>
            <?php
            }
            ?>
            </table>
        </div>
    </body>
</html>
