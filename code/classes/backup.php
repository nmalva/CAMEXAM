<?php
define("BACKUP_PATH", "/home/nmalva/public_html/aaexams/mysql_backup");

$server_name   = "localhost";
$username      = "nmalva_nmalva";
$password      = "Wara1441";
$database_name = "nmalva_camexam_testing";
$date_string   = date("Ymd");

$cmd = "mysqldump --hex-blob --routines --skip-lock-tables --log-error=mysqldump_error.log -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";

$arr_out = array();
unset($return);

exec($cmd, $arr_out, $return);

if($return !== 0) {
    echo "mysqldump for {$server_name} : {$database_name} failed with a return code of {$return}\n\n";
    echo "Error message was:\n";
    $file = escapeshellarg("mysqldump_error.log");
    $message = `tail -n 1 $file`;
    echo "- $message\n\n";
}
?>