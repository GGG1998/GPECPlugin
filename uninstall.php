<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;
$table_remove=array("gpec_cost","gpec_rule","gpec_client");
for($i=0; $i<count($table_remove); $i++)
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXIST %s;",$table_remove[$i]));
?>