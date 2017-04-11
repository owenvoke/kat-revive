<?php
	header('Content-Type: application/json');

	include('../funcs.php');
	if (isset($_GET['h']) && !empty($_GET['h']) && strlen($_GET['h']) == 40) {
		$db_conn = \funcs\Functions::conn();
		$sql     = "SELECT * FROM t_collection WHERE torrent_info_hash='".mysqli_real_escape_string($db_conn, $_GET['h'])."'";
		$res     = \funcs\Functions::query($db_conn, $sql);

		while ($row = mysqli_fetch_assoc($res)) {
			$data['torrent_name'] = $row['torrent_name'];
			$data['torrent_info_hash'] = $row['torrent_info_hash'];
			$data['torrent_category'] = $row['torrent_category'];
			$data['verified'] = $row['verified'];
			$data['torrent_info_url'] = $row['torrent_info_url'];
			$data['torcache_download_url'] = $row['torrent_download_url'];
			$data['torrage_download_url'] = 'http://torrage.info/torrent.php?h='.$data['torrent_info_hash'];
			$data['itorrents_download_url'] = 'http://itorrents.org/torrent/'.$data['torrent_info_hash'];
			$data['files_count'] = $row['files_count'];
			$data['category_id'] = $row['category_id'];
			$data['size'] = $row['size'];
		}
	} else {
		$db_conn = \funcs\Functions::conn();

		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$startPoint = $_GET['s'];
		} else {
			$startPoint = "0";
		}

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$query = "WHERE torrent_name LIKE '%".mysqli_real_escape_string($db_conn, $_GET['q'])."%' ";
		} else {
			$query = '';
		}

		if (isset($_GET['c']) && !empty($_GET['c'])) {
			if ($query !== '') {
				$category = "AND category_id = ".mysqli_real_escape_string($db_conn, $_GET['c'])." ";
			} else {
				$category = "WHERE category_id = ".mysqli_real_escape_string($db_conn, $_GET['c'])." ";
			}
		} else {
			$category = '';
		}

		$sql = "SELECT * FROM t_collection ".$query.$category."LIMIT ".mysqli_real_escape_string($db_conn, $startPoint).", 20";
		if (isset($_GET['debug']) && !empty($_GET['debug']) && $_GET['debug'] == 'awfj23th1hgewjgojgqpow3f0j3tq') {
			echo $sql;
			exit();
		}
		$res = \funcs\Functions::query($db_conn, $sql);

		while ($row = mysqli_fetch_assoc($res)) {
			if ($row['torrent_info_hash'] !== '') {
				$data[$row['torrent_info_hash']]['torrent_info_hash'] = $row['torrent_info_hash'];
				$data[$row['torrent_info_hash']]['torrent_name'] = $row['torrent_name'];
				$data[$row['torrent_info_hash']]['torrent_category'] = $row['torrent_category'];
				$data[$row['torrent_info_hash']]['verified'] = $row['verified'];
				$data[$row['torrent_info_hash']]['torrent_info_url'] = $row['torrent_info_url'];
				$data[$row['torrent_info_hash']]['torrent_download_url'] = $row['torrent_download_url'];
			}
		}
	}

	if ($data == null) {
		$data = array(
			'status' => 'null'
		);
	}
	if (isset($_GET["pretty"]) && $_GET["pretty"] == "true") {
		echo json_encode($data, JSON_PRETTY_PRINT);
		} else {
			echo json_encode($data);
		}
