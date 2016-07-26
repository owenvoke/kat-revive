<!DOCTYPE html>
<html lang="en">
	<?php include('../head.php'); ?>
	<body>
		<?php include('../nav.php'); ?>
		<div class="container" style="margin-top: 5%;">
			<?php
			
				
				include ('..categories.php');
				include ('../funcs.php');

				if (isset($_GET['h']) && !empty($_GET['h']) && strlen($_GET['h']) == 40) {
					$startPoint = $_GET['h'];

					$db_conn = \funcs\Functions::conn();
					$sql     = "SELECT *, count(*) as cnt FROM t_collection WHERE torrent_info_hash='".mysqli_real_escape_string($db_conn, $_GET['h'])."'";
					$res     = \funcs\Functions::query($db_conn, $sql);

					if ($res) {
						while ($row = mysqli_fetch_assoc($res)) {
							if ($row['cnt'] < 1) {
								echo '
								<div class="alert alert-danger">
									<h1>404</h1>
									<p>
										Torrent was not found.
									</p>
								</div>
								';
								exit();
							}
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
						echo '<tr><td><p><strong>Category: </strong></td><td>'.$data['torrent_category'].' (';
						if ($categories[$data['category_id']] != '') {
							echo $categories[$data['category_id']];
						}
						else {
							echo $data['category_id'];
						}
						echo ')</td></tr>';
						echo '<tr><td><p><strong>KAT URL: </strong></td><td><a href="'.$data['torrent_info_url'].'" target="_blank">'.$data['torrent_info_url'].'</a></td></tr>';
						echo '<tr><td><p><strong>TorCache URL: </strong></td><td><a href="'.$data['torrent_download_url'].'" target="_blank">'.$data['torrent_download_url'].'</a></td></tr>';
						echo '<tr><td><p><strong>Torrage URL: </strong></td><td><a href="http://torrage.info/torrent.php?h='.$data['torrent_info_hash'].'" target="_blank">http://torrage.info/torrent.php?h='.$data['torrent_info_hash'].'</a></td></tr>';
						echo '<tr><td><p><strong>iTorrents URL: </strong></td><td><a href="http://itorrents.org/torrent/'.$data['torrent_info_hash'].'.torrent" target="_blank">http://itorrents.org/torrent/'.$data['torrent_info_hash'].'.torrent</a></td></tr>';
						echo '<tr><td><p><strong>Magnet Link: </strong></td><td><a href="magnet:?xt=urn:btih:'.$data['torrent_info_hash'].'&dn='.$data['torrent_name'].'"<span>magnet:?xt=urn:btih:'.$data['torrent_info_hash'].'&dn='.$data['torrent_name'].'</span></a></td></tr>';
						echo '<tr><td><p><strong>File Count: </strong></td><td>'.$data['files_count'].'</td></tr>';
						echo '<tr><td><p><strong>Size: </strong></td><td>'.(round($data['size'] / pow(1024, 2), 2)).'MB</td></tr>';
						echo '</table>';
					}
					else {
						echo '
						<div class="alert alert-danger">
							<h1>404</h1>
							<p>
								Torrent was not found.
							</p>
						</div>
						';
						exit();
					}
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
