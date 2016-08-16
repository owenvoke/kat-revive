<?php

// GENERATE MYSQL DUMP
// Generates a daily MySQL dump for importing.

$tableName  	= 't_collection';
$db_name		= 'kat_db';
$db_user 		= "root";
$db_pass 		= '';
$backup_file 	= "exports/daily_dump_".date("Y-m-d").".sql";
$cmd			= "mysqldump --insert-ignore --skip-add-drop-table --no-create-info -u $db_user -p$db_pass $db_name $tableName > $backup_file";
if (!file_exists($backup_file . ".gz")) {
	exec($cmd);
}

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

foreach ($dir_files as $file) {
	if (substr($file, -4) === ".sql") {
		// Name of the gz file we're creating
		$gzfile = "./exports/" . $file . ".gz";

		$error = false; 
		if ($fp_out = gzopen($gzfile, "wb9")) { 
			if ($fp_in = fopen("./exports/" . $file, 'rb')) { 
				while (!feof($fp_in)) 
					gzwrite($fp_out, fread($fp_in, 1024 * 512)); 
				fclose($fp_in); 
			} else {
				$error = true; 
			}
			gzclose($fp_out); 
		} else {
			$error = true; 
		}
		
		if ($error) {
			echo "error\n";
		}
		
		unlink("./exports/" . $file);
	}
}

if (count($dir_files) > 2) {
	unlink ("exports/" . $dir_files[3]);
}