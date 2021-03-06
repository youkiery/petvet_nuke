<?php

/**
 * @Project NUKEVIET CMS 3.0
 * @Author VINADES (contact@vinades.vn)
 * @Copyright 2010 VINADES. All rights reserved
 * @Createdate Apr 22, 2010 3:00:20 PM
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$id = $nv_Request->get_int( 'id', 'post', 0 );

if ( empty( $id ) ) die( 'NO' );

$query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id`=" . $id;
$result = $db->sql_query( $query );
$numrows = $db->sql_numrows( $result );
if ( $numrows != 1 ) die( 'NO' );

$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_send` WHERE `cid` = " . $id;
$db->sql_query( $query );
$query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = " . $id;

nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_row', "rowid ".$id, $admin_info['userid'] );

$db->sql_query( $query );
if ( $db->sql_affectedrows() > 0 )
{
    $db->sql_query( "OPTIMIZE TABLE `" . NV_PREFIXLANG . "_" . $module_data . "_send`" );
    $db->sql_query( "OPTIMIZE TABLE `" . NV_PREFIXLANG . "_" . $module_data . "_rows`" );
}
else
{
    die( 'NO' );
}

nv_del_moduleCache( $module_name );

include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK';
include ( NV_ROOTDIR . "/includes/footer.php" );

?>