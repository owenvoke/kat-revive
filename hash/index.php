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
		<?php include('../nav.php'); ?>
		<div class="container" style="margin-top: 5%;">
			<?php
			
				$categories = [
					"21" => "TV",
					"19" => "Movies > videos",
					"20" => "Movies > Movie clips",
					"22" => "Movies > Handheld",
					"69" => "Movies > iPad",
					"23" => "Movies > Highres Movies",
					"80" => "Movies > UltraHD",
					"24" => "Movies > Bollywood",
					"62" => "Movies > Concerts",
					"63" => "Movies > Dubbed Movies",
					"64" => "Movies > Asian",
					"46" => "Movies > Documentary",
					"47" => "Movies > Trailer",
					"25" => "Movies > Other Movies",
					"31" => "Games > PC",
					"32" => "Games > Mac",
					"94" => "Games > Linux",
					"74" => "Games > Xbox ONE",
					"35" => "Games > Wii",
					"36" => "Games > Handheld",
					"40" => "Games > NDS",
					"44" => "Games > PSP",
					"76" => "Games > PS Vita",
					"58" => "Games > iOS",
					"59" => "Games > Android",
					"37" => "Games > Other Games",
					"26" => "Applications > Windows",
					"27" => "Applications > Mac",
					"28" => "Applications > UNIX",
					"78" => "Applications > Linux",
					"60" => "Applications > iOS",
					"61" => "Applications > Android",
					"29" => "Applications > Handheld",
					"30" => "Applications > Other Applications",
					"75" => "Music > AAC",
					"15" => "Music > Lossless",
					"72" => "Music > Transcode",
					"73" => "Music > Soundtrack",
					"82" => "Music > Radio Shows",
					"87" => "Music > Karaoke",
					"16" => "Music > Other Music",
					"38" => "Books > Ebooks",
					"39" => "Books > Comics",
					"50" => "Books > Magazines",
					"51" => "Books > Textbooks",
					"53" => "Books > Fiction",
					"13" => "Books > Audio books",
					"56" => "Books > Academic",
					"79" => "Books > Poetry",
					"80" => "Books > Newspapers",
					"52" => "Books > Other Books",
					"48" => "Anime > Other Anime",
					"85" => "Anime > Anime Music Video",
					"65" => "XXX > Video",
					"70" => "XXX > HD Video",
					"89" => "XXX > UltraHD",
					"66" => "XXX > Pictures",
					"67" => "XXX > Magazines",
					"68" => "XXX > Books",
					"43" => "XXX > Hentai",
					"83" => "XXX > Games",
					"17" => "XXX > Other XXX",
					"8" => "Other > Pictures",
					"14" => "Other > Sound clips",
					"41" => "Other > Covers",
					"42" => "Other > Wallpapers",
					"71" => "Other > Tutorials",
					"81" => "Other > Subtitles",
					"88" => "Other > Fonts",
					"55" => "Other > Unsorted"
				];

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
