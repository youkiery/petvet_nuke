<?php

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'post', 0 );

if ( empty( $id ) ) die( 'NO_' . $id );

$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config` WHERE `id`=" . $id;
$result = $db->sql_query( $query );
$numrows = $db->sql_numrows( $result );
if ( $numrows != 1 ) die( 'NO_' . $id );
nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['log_del_config'], "configid  " . $id, $admin_info['userid'] );
$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config` WHERE `id` = " . $id;
$db->sql_query( $query );

include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $id;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>