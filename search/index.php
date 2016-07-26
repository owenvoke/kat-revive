<!DOCTYPE html>
<html lang="en">
	<?php include('../head.php'); ?>
	<body>
		<?php
		include('../funcs.php');
		include('../categories.php');
		$db_conn = \funcs\Functions::conn();
		$sql = "SELECT count(*) as count FROM t_collection";
		try {
			$total_torrents = \funcs\Functions::query($db_conn, $sql);
			$tTotal = mysqli_fetch_assoc($total_torrents)['count'];
		}
		catch (Exception $e) {
			$total_torrents = false;
			$tTotal = 0;
		}
		include('../nav.php');
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
		$wheres = '';
		if (isset($_GET['c']) && $_GET['c'] != '') {
			$wheres .= ' AND category_id="'.(int)$_GET['c'].'"';
		}
		if (isset($_GET['q']) && $_GET['q'] !== '') {
			$query = $_GET['q'];
			$res = \funcs\Functions::query(
			$db_conn,
			sprintf(
				"SELECT * FROM t_collection WHERE torrent_name LIKE '%s'".$wheres." LIMIT " . mysqli_real_escape_string($db_conn, $startPoint) . ", 20",
				'%'. mysqli_real_escape_string($db_conn, $_GET['q']) .'%'
			)
			);
			$ttc = \funcs\Functions::query(
				$db_conn,
				sprintf(
					"SELECT * FROM t_collection WHERE torrent_name LIKE '%s'".$wheres,
					'%'. mysqli_real_escape_string($db_conn, $query) .'%'
				)
			);
		}
		else if (isset($_GET['c'])) {
			$res = \funcs\Functions::query($db_conn, "SELECT * FROM t_collection WHERE category_id='".(int)$_GET['c']."' LIMIT " . mysqli_real_escape_string($db_conn, $startPoint) . ", 20");
			$ttc = \funcs\Functions::query($db_conn, "SELECT * FROM t_collection WHERE category_id='".(int)$_GET['c']."'");
		}
		else {
			$res = \funcs\Functions::query($db_conn, "SELECT * FROM t_collection".$wheres." LIMIT " . mysqli_real_escape_string($db_conn, $startPoint) . ", 20");
			$ttc = \funcs\Functions::query($db_conn, "SELECT count(*) as count FROM t_collection");
			$tt = mysqli_fetch_assoc($ttc)['count'];
		}
		if (!isset($tt)) {
			$tt = mysqli_num_rows($ttc);
		}
		?>
		<div class="container">
			<div class="text-center">
				<form role="search" action="/search" method="get">
					<div class="form-group">
						<input name="q" type="text" class="form-control" placeholder="Search" value="<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>">
					</div>
					<div class="form-group">
						<select name="c" class="form-control">
						<?php
						echo '<option value="">-Any Category-</option>'; 
						foreach ($categories as $categoryId => $category) {
							echo '<option value="'.$categoryId.'"';
							if (isset($_GET['c']) && (int)$_GET['c'] == $categoryId) { echo ' selected="selected"';	}
							echo '>'.$category.'</option>';
						}
						?>
						</select>
					</div>
					<button type="submit" class="btn btn-default">Search Torrents</button>
				</form>
				<br/>
				<br/>
				<br/>
				<nav>
					<ul class="pagination">
						<li>
							<a href="?s=<?php if ($startPoint > 20) { echo $startPoint - 20; } else { echo '0'; } if (isset($_GET['q'])) {echo '&q='.urlencode($_GET['q']) ; } if (isset($_GET['c'])) { echo '&c='.urlencode($_GET['c']);}?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><span>Currently On Point: <?php echo $startPoint; ?> of <?php echo $tt; ?></span></li>
						<li>
							<a href="?s=<?php echo $startPoint + 20; if (isset($_GET['q'])) {echo '&q='.urlencode($_GET['q']) ; } if (isset($_GET['c'])) { echo '&c='.urlencode($_GET['c']);}?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
					<?php
					if ($tt > 0) { ?>
			<div class="table-responsive">
				<table class="table table-condensed">
					<th></th><th>Hash</th><th>Name</th><th>Category</th><th colspan="4">URLs</th>
					<?php
						while ($row = mysqli_fetch_assoc($res)) {
							$data[$row['torrent_info_hash']]['torrent_info_hash'] = $row['torrent_info_hash'];
							$data[$row['torrent_info_hash']]['torrent_name'] = $row['torrent_name'];
							$data[$row['torrent_info_hash']]['torrent_category'] = $row['torrent_category'];
							$data[$row['torrent_info_hash']]['verified'] = $row['verified'];
							$data[$row['torrent_info_hash']]['torrent_info_url'] = $row['torrent_info_url'];
							$data[$row['torrent_info_hash']]['torrent_download_url'] = $row['torrent_download_url'];
						}
						foreach ($data as $arrM) {
							//var_dump($arrM);
							if ($arrM['torrent_info_hash'] !== '') {
								echo '<tr><td>';
								if ($arrM['verified']) { echo '<span class="glyphicon glyphicon-star-empty"></span>'; } else { echo ''; }
								echo '</td><td>' . $arrM['torrent_info_hash'] . '</td><td><a href="/hash/?h=' . $arrM['torrent_info_hash'] . '" target="_blank">' . $arrM['torrent_name'] . '</a></td><td>' . $arrM['torrent_category'] . '</td><td><a href="magnet:?xt=urn:btih:' . $arrM['torrent_info_hash'] . '&dn=' . urlencode($arrM['torrent_name']) . '&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Fglotorrents.pw%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce" target="_blank" title="Download magnet"><span class="glyphicon glyphicon-cloud-download"></span></a></td><td><a href="' . $arrM['torrent_download_url'] . '" target="_blank" title="Download .torrent from TorCache"><span class="glyphicon glyphicon-floppy-save"></span></a></td><td><a href="http://torrage.info/torrent.php?h=' . $arrM['torrent_info_hash'] . '" target="_blank" title="Download .torrent from Torrage"><img src="https://pximg.xyz/images/eb36d60350eb5c2ba9a8f8f3572237f6.png"></img></a></td><td><a href="http://itorrents.org/torrent/' . $arrM['torrent_info_hash'] . '.torrent" target="_blank" title="Download .torrent from iTorrents"><img src="https://pximg.xyz/images/ecc3e659112104c1bae3e39f2c98bc01.png"></img></a></td></tr>';
							}
						}
						?>

				</table>
			</div>
						<?php
					}
					else { ?>
						<div class="container" style="margin-top: 5%;">
							<div class="alert alert-danger">
								<h2>No results found.</h2>
							</div>
						</div>
					<?php
					}
					?>
			<div class="text-center">
				<nav>
					<ul class="pagination">
						<li>
							<a href="?s=<?php if ($startPoint > 20) { echo $startPoint - 20; } else { echo '0'; } if (isset($_GET['q'])) {echo '&q='.urlencode($_GET['q']) ; } if (isset($_GET['c'])) { echo '&c='.urlencode($_GET['c']);}?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><span>Currently On Point: <?php echo $startPoint; ?> of <?php echo $tt; ?></span></li>
						<li>
							<a href="?s=<?php echo $startPoint + 20; if (isset($_GET['q'])) {echo '&q='.urlencode($_GET['q']) ; } if (isset($_GET['c'])) { echo '&c='.urlencode($_GET['c']);}?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</body>
</html>
