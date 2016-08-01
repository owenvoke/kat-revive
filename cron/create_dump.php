<?php

// GENERATE MYSQL DUMP
// Generates a daily MySQL dump for importing.

$tableName  	= 't_collection';
$db_name		= 'kat_db';
$db_user 		= "root";
$db_pass 		= '';
$backup_file 	= "exports/daily_dump_".date("Y-m-d").".sql";
$cmd			= "mysqldump --insert-ignore -u $db_user -p$db_pass $db_name $tableName > $backup_file";
exec($cmd);

function scan_dir($dir = "exports") {
	$ignored = array('.', '..', '.htaccess', 'index.php');

	$files = array();    
	foreach (scandir($dir) as $file) {
		if (in_array($file, $ignored)) continue;
		$files[$file] = filemtime($dir . '/' . $file);
	}

	arsort($files);
	$files = array_keys($files);

	return ($files) ? $files : false;
}
			
$dir_files = scan_dir("exports");

if (count($dir_files) > 5) {
	unlink ("exports/" . $dir_files[6]);
}
?>