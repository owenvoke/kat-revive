<?php
	header('Content-Type: application/json');
	
	include ('../funcs.php');
	
	if (isset($_GET['s']) && !empty($_GET['s'])) {
		$startPoint = $_GET['s'];
	}
	else {
		$startPoint = "2";
	}
	
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

	echo json_encode($data);