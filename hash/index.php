<!DOCTYPE html>
<html lang="en">
	<head itemscope itemtype="http://schema.org/WebSite">
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0,width=device-width">
		<meta name="HandheldFriendly" content="true"/>
		<title>KatRevive</title>
		<link rel="shortcut icon" href="favicon.png">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script async src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/rocketscript"></script>
		<script async src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 5%;">
			<?php

				include ('../funcs.php');
				
				if (isset($_GET['h']) && !empty($_GET['h']) && strlen($_GET['h']) == 40) {
					$startPoint = $_GET['h'];
				
					$db_conn = \funcs\Functions::conn();
					$sql     = "SELECT * FROM t_collection WHERE torrent_info_hash='".mysqli_real_escape_string($db_conn, $_GET['h'])."'";
					$res     = \funcs\Functions::query($db_conn, $sql);
				 
					while ($row = mysqli_fetch_assoc($res)) {
						$data['torrent_info_hash'] = $row['torrent_info_hash'];
						$data['torrent_name'] = $row['torrent_name'];
						$data['torrent_category'] = $row['torrent_category'];
						$data['verified'] = $row['verified'];
						$data['torrent_info_url'] = $row['torrent_info_url'];
						$data['torrent_download_url'] = $row['torrent_download_url'];
						$data['files_count'] = $row['files_count'];
						$data['category_id'] = $row['category_id'];
						$data['size'] = $row['size'];
					}
					echo '<table class="table">';
					echo '<tr><td><p><strong>Name: </strong></td><td>'.$data['torrent_name'].'</td></tr>';
					echo '<tr><td><p><strong>Is Verified: </strong></td><td>';
					if ($data['verified']) { echo '<span class="glyphicon glyphicon-star-empty"></span>'; }
					echo '</td></tr>';
					echo '<tr><td><p><strong>Hash: </strong></td><td>'.$data['torrent_info_hash'].'</td></tr>';
					echo '<tr><td><p><strong>Category: </strong></td><td>'.$data['torrent_category'].' ('.$data['category_id'].')</td></tr>';
					echo '<tr><td><p><strong>KAT URL: </strong></td><td><a href="'.$data['torrent_info_url'].'" target="_blank">'.$data['torrent_info_url'].'</a></td></tr>';
					echo '<tr><td><p><strong>TorCache URL: </strong></td><td><a href="'.$data['torrent_download_url'].'" target="_blank">'.$data['torrent_download_url'].'</a></td></tr>';
					echo '<tr><td><p><strong>Torrage URL: </strong></td><td><a href="http://torrage.info/torrent.php?h='.$data['torrent_info_hash'].'" target="_blank">http://torrage.info/torrent.php?h='.$data['torrent_info_hash'].'</a></td></tr>';
					echo '<tr><td><p><strong>iTorrents URL: </strong></td><td><a href="http://itorrents.org/torrent/'.$data['torrent_info_hash'].'" target="_blank">http://itorrents.org/torrent/'.$data['torrent_info_hash'].'</a></td></tr>';
					echo '<tr><td><p><strong>Magnet Link: </strong></td><td><a href="magnet:?xt=urn:btih:'.$data['torrent_info_hash'].'&dn='.$data['torrent_name'].'"<span>magnet:?xt=urn:btih:'.$data['torrent_info_hash'].'&dn='.$data['torrent_name'].'</span></a></td></tr>';
					echo '<tr><td><p><strong>File Count: </strong></td><td>'.$data['files_count'].'</td></tr>';
					echo '<tr><td><p><strong>Size: </strong></td><td>'.(round($data['size'] / (1024 ** 2), 2)).'MB</td></tr>';
					echo '</table>';
				}
				else {
					echo '
						<div class="alert alert-danger">
							<h1>No Hash Provided</h1>
							<p>
								Providing a hash can be done using the HTTP GET parameter of `h`.<br/>
								e.g. <strong>hash/?h=74C80815374F44702FFE1F25B10D1788B79282A4</strong>
							</p>
						</div>
						';
					exit();
				}
				
				?>
		</div>
	</body>
</html>