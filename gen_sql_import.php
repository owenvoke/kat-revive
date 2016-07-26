<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<?php
			include('nav.php');
			?>
			<div style="width: 70%; margin: auto; padding: auto; margin-top: 5%;">
			<?php
			require_once('funcs.php');
			if (isset($_GET['db_type']) && !empty($_GET['db_type'])) {
				
				$db_type = $_GET['db_type'];
				
				$startTime = microtime(true);

				$db_conn = \funcs\Functions::conn();
			
				$sql_output = "INSERT INTO `t_collection` (`torrent_info_hash`, `torrent_name`, `torrent_category`, `torrent_info_url`, `torrent_download_url`, `size`, `category_id`, `files_count`, `upload_date`, `verified`) VALUES \n";
				
				$f = fopen("import_lists/".$db_type."dump.txt", "r") or exit("Unable to open file!<br/> DT-ERROR: E001" .$db_type);
				$i = 0;
				while (!feof($f)) {
					// Make an array using | as delimiter
					$arrM = explode('|', mysqli_real_escape_string($db_conn, fgets($f)));
					if ($arrM[0] !== '') {
						// Write links (get the data in the array)
						$sql_output .= "\n('$arrM[0]','$arrM[1]','$arrM[2]','$arrM[3]','$arrM[4]','$arrM[5]','$arrM[6]','$arrM[7]','$arrM[10]','$arrM[11]'),";
						
						$i++;
					}
				}
				
				fclose($f);
				$sql_output = substr($sql_output, 0, -1);
				$fname = "sql_imports/sql_import_".date("Y-m-d_H.i.s").".sql";
				$f = fopen($fname, "w");
				fwrite($f, $sql_output);
				?>
				<div class="alert alert-success">
					<p>Added <?php echo $i; ?> to <a href="<?php echo $fname; ?>"><?php echo $fname; ?></a> in <?php echo number_format(microtime(true) - $startTime, 4); ?> seconds.</p>
					<p><a href="index.php">Go to Index</a></p>
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-danger">
					<h2>No database type present.</h2>
				</div>
			<?php
			}
		?>
		</div>
	</body>
</html>