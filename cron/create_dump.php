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
?>