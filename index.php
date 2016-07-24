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
		<?php
		include('nav.php'); 
		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$startPoint = $_GET['s'];
		}
		else {
			$startPoint = "2";
		}
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
						<li><a href="#">Currently On Point: <?php echo $startPoint; ?></a></li>
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
					<th></th><th>Hash</th><th>Name</th><th>Category</th><th colspan="2">URLs</th>
					<?php
					
					require_once('funcs.php');
					
					$db_conn = \funcs\Functions::conn();
					$sql     = "SELECT * FROM t_collection LIMIT " . mysqli_real_escape_string($db_conn, $startPoint) . ", 20";
					$res     = \funcs\Functions::query($db_conn, $sql);
					
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
						echo '<tr><td>';
					    if ($arrM['verified']) { echo '<span class="glyphicon glyphicon-star-empty"></span>'; } else { echo ''; }
						echo '</td><td>' . $arrM['torrent_info_hash'] . '</td><td><a href="hash/?h=' . $arrM['torrent_info_hash'] . '" target="_blank">' . $arrM['torrent_name'] . '</a></td><td>' . $arrM['torrent_category'] . '</td><td><a href="magnet:?xt=urn:btih:' . $arrM['torrent_info_hash'] . '&dn=' . urlencode($arrM['torrent_name']) . '&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969%2Fannounce&tr=udp%3A%2F%2Fglotorrents.pw%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce" target="_blank" title="Download magnet"><span class="glyphicon glyphicon-cloud-download"></span></a></td><td><a href="' . $arrM['torrent_download_url'] . '" target="_blank" title="Download .torrent from TorCache"><span class="glyphicon glyphicon-floppy-save"></span></a></td></tr>';
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
						<li><a href="#">Currently On Point: <?php echo $startPoint; ?></a></li>
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