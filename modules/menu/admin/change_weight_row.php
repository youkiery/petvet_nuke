<?php

/**
 * @Project NUKEVIET 3.1
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2011 VINADES.,JSC. All rights reserved
 * @Createdate 20-03-2011 20:08
 */
 
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

$id = $nv_Request->get_int( 'id', 'post', 0 );
$mid = $nv_Request->get_int( 'mid', 'post', 0 );
$parentid = $nv_Request->get_int( 'parentid', 'post', 0 );
$new_weight = $nv_Request->get_int( 'new_weight', 'post', 0 );

if ( empty( $id ) ) die( "NO_" . $id );

$query = "SELECT `weight` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id`=" . $id . " AND `parentid`=" . $parentid;
$result = $db->sql_query( $query );

list( $weight_old ) = $db->sql_fetchrow( $result );

$query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `weight`=" . $new_weight . " AND `parentid`=" . $parentid;
$result = $db->sql_query( $query );

list( $id_swap ) = $db->sql_fetchrow( $result );

$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `weight`=" . $new_weight . " WHERE `id`=" . $id . " AND `parentid`=" . $parentid;
$db->sql_query( $sql );
$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `weight`=" . $weight_old . " WHERE `id`=" . $id_swap . " AND `parentid`=" . $parentid;
$db->sql_query( $sql );

nv_del_moduleCache( $module_name );
include ( NV_ROOTDIR . "/includes/header.php" );
echo 'OK_' . $id."_".$mid."_".$parentid;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>