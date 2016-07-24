<?php
ini_set('MAX_EXECUTION_TIME', -1);
set_time_limit(0)
?>
<!DOCTYPE html>
<html lang="en">
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0,width=device-width">
		<meta name="HandheldFriendly" content="true"/>
		<title>KatRevive</title>
		<link rel="shortcut icon" href="favicon.png">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script async src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
		<script async src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
		<?php include('nav.php'); ?>
		<div style="width: 70%; margin: auto; padding: auto; margin-top: 5%;">
			<?php
			require_once('funcs.php');

			$db_type = $_POST['dbtype'];
			if ($db_type == '') {
				$db_type = 'NOTYPE';
			}

			$startTime = microtime(true);

			$db_conn = \funcs\Functions::conn();

			$f = fopen("import_lists/".$db_type."dump.txt", "r") or exit("Unable to open file!<br/> DT-ERROR: E001" .$db_type);

			$i = 0;
			//echo '<table class="table"><th>torrent_info_hash</th><th>torrent_name</th><th>torrent_category</th><th>torrent_info_url</th><th>torrent_download_url</th><th>size</th><th>category_id</th><th>files_count</th><th>upload_date</th><th>verified</th>';
			while (!feof($f)) {

				// Make an array using | as delimiter
				$arrM = explode('|', mysqli_real_escape_string($db_conn, fgets($f)));
				// Write links (get the data in the array)
				//echo '<tr><td>' . $arrM[0] . '</td><td>' . $arrM[1] . '</td><td>' . $arrM[2] . '</td><td><span>' . $arrM[3] . '</span></td><td>' . $arrM[4] . '</td><td>' . $arrM[5] . '</td><td>' . $arrM[6] . '</td><td>' . $arrM[7] . '</td><td>' . $arrM[10] . '</td><td>' . $arrM[11] . '</td></tr>';
				$sql = "INSERT INTO t_collection (torrent_info_hash, torrent_name, torrent_category, torrent_info_url, torrent_download_url, size, category_id, files_count, upload_date, verified) VALUES ('$arrM[0]','$arrM[1]','$arrM[2]','$arrM[3]','$arrM[4]','$arrM[5]','$arrM[6]','$arrM[7]','$arrM[10]','$arrM[11]')";

				$res = \funcs\Functions::query($db_conn, $sql) ;
				$i++;
				if (!$res) {
					echo '
						<div class="alert alert-danger">
							<p>Import failed on line '.$i.'</p>
							<p>'.mysqli_error($db_conn).'</p>
						</div>
					';
					exit();
				}
			}
			//echo '</table>';
			fclose($f);
			?>
			<div class="alert alert-success">
				<p><?php echo $i; ?> Torrents Imported in <?php echo number_format(microtime(true) - $startTime, 4); ?> seconds.</p>
				<p><a href="index.php">Go to Index</a></p>
			</div>
		</div>
	</body>
</html>
