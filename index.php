<!DOCTYPE html>
<html lang="en">
	<?php include('head.php'); ?>
	<body>
		<?php
		include('funcs.php');
		include('categories.php');
		$db_conn = \funcs\Functions::conn();
		$sql = "SELECT count(*) as count FROM t_collection";
		try {
			$total_torrents = \funcs\Functions::query($db_conn, $sql);
		}
		catch (Exception $e) {
			$total_torrents = false;
		}

		include('nav.php');
		if (!$total_torrents && mysqli_fetch_assoc($total_torrents)['count'] < 1) {
			?>
			<div class="container" style="margin-top: 5%;">
				<div class="alert alert-danger">
					<h2>No data has been added to the tables.</h2>
					<p>Please run the installer <a href="/install.php" class="alert-link">here</a></p>
				</div>
			</div>
			<?php
			exit();
		}
		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$startPoint = $_GET['s'];
		}
		else {
			$startPoint = "0";
		}
		$tt = mysqli_fetch_assoc($total_torrents)['count'];
		?>
		<div class="container">
			<div class="text-center">
				<nav>
					<ul class="pagination">
						<li>
							<a href="?s=<?php if ($startPoint > 20) { echo $startPoint - 20; } else { echo '0'; } ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><a href="#">Currently On Point: <?php echo $startPoint; ?> of <?php echo $tt; ?></a></li>
						<li>
							<a href="?s=<?php echo $startPoint + 20; ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="table-responsive">
				<table class="table table-condensed">
					<th></th><th>Hash</th><th>Name</th><th>Category</th><th colspan="4">URLs</th>
					<?php

					require_once('funcs.php');

					$db_conn = \funcs\Functions::conn();
					$sql     = "SELECT * FROM t_collection LIMIT " . mysqli_real_escape_string($db_conn, $startPoint) . ", 20";
					$res     = \funcs\Functions::query($db_conn, $sql);

					while ($row = mysqli_fetch_assoc($res)) {
						$data[$row['torrent_info_hash']]['torrent_info_hash'] = $row['torrent_info_hash'];
						$data[$row['torrent_info_hash']]['torrent_name'] = $row['torrent_name'];
						$data[$row['torrent_info_hash']]['category_id'] = $row['category_id'];
						$data[$row['torrent_info_hash']]['verified'] = $row['verified'];
						$data[$row['torrent_info_hash']]['torrent_info_url'] = $row['torrent_info_url'];
						$data[$row['torrent_info_hash']]['torrent_download_url'] = $row['torrent_download_url'];
					}
					foreach ($data as $arrM) {
						//var_dump($arrM);
						if ($arrM['torrent_info_hash'] !== '') {
							echo '<tr><td>';
						    if ($arrM['verified']) { echo '<span class="glyphicon glyphicon-star-empty"></span>'; } else { echo ''; }
							echo '</td><td>' . $arrM['torrent_info_hash'] . '</td><td><a href="/hash/?h=' . $arrM['torrent_info_hash'] . '" target="_blank">' . $arrM['torrent_name'] . '</a></td><td>' . $categories[$arrM['category_id']] . '</td><td><a href="magnet:?xt=urn:btih:' . $arrM['torrent_info_hash'] . '&dn=' . urlencode($arrM['torrent_name']) . '&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Fglotorrents.pw%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce" target="_blank" title="Download magnet"><span class="glyphicon glyphicon-cloud-download"></span></a></td><td><a href="' . $arrM['torrent_download_url'] . '" target="_blank" title="Download .torrent from TorCache"><span class="glyphicon glyphicon-floppy-save"></span></a></td><td><a href="http://torrage.info/torrent.php?h=' . $arrM['torrent_info_hash'] . '" target="_blank" title="Download .torrent from Torrage"><img src="https://pximg.xyz/images/eb36d60350eb5c2ba9a8f8f3572237f6.png"></img></a></td><td><a href="http://itorrents.org/torrent/' . $arrM['torrent_info_hash'] . '.torrent" target="_blank" title="Download .torrent from iTorrents"><img src="https://pximg.xyz/images/ecc3e659112104c1bae3e39f2c98bc01.png"></img></a></td></tr>';
						}
					}
					?>
				</table>
			</div>
			<div class="text-center">
				<nav>
					<ul class="pagination">
						<li>
							<a href="?s=<?php if ($startPoint > 20) { echo $startPoint - 20; } else { echo '0'; } ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><a href="#">Currently On Point: <?php echo $startPoint; ?> of <?php echo $tt; ?></a></li>
						<li>
							<a href="?s=<?php echo $startPoint + 20; ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</body>
</html>
