<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$contents = "";
$id = $nv_Request->get_int( 'id', 'get', 0 );
$ac = $nv_Request->get_string( 'ac', 'get', '' );
$w = $nv_Request->get_int( 'w', 'get', 0 );
switch ( $ac )
{
    case 'status': nv_achange_status( $id );
        break;
    case 'del': nv_delete_articles ( $id );
        break;
    case 'weight': nv_achange_weight ( $id,$w ); break;
    default:
        break;
}

function nv_delete_articles ( $id )
{
	global $db, $module_data;
    $sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
    $db->sql_query( $sql );
}

function nv_achange_status ( $id )
{
    global $db, $module_data;
    $query = "SELECT `status` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
    $result = $db->sql_query( $query );
    $row = $db->sql_fetchrow( $result );
    $new_status = 0;
    if ( $row['status'] == 1 ) $new_status = 0;
    elseif ( $row['status'] == 0 ) $new_status = 1;
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `status`=" . $new_status . " WHERE `id`=" . $id;
    $db->sql_query( $sql );
}

function nv_achange_weight ( $id,$w )
{
	global $db, $module_data;
    $query = "SELECT `weight` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
    $result = $db->sql_query( $query );
    $row = $db->sql_fetchrow( $result );
    if ( ! empty( $row ) )
    {
        $w_old = $row['weight'];
        unset( $row );
        unset( $result );
        $query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `weight`=" . intval( $w );
        $result = $db->sql_query( $query );
        $row = $db->sql_fetchrow( $result );
        $id_new = 0;
        if ( ! empty( $row ) )
        {
            $id_new = $row['id'];
            unset( $row );
            unset( $result );
        }
        if ( $id_new != $id )
        {
            $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `weight`=" . $w . " WHERE `id`=" . $id;
            $db->sql_query( $sql );
            $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `weight`=" . $w_old . " WHERE `id`=" . $id_new;
            $db->sql_query( $sql );
        }
    }
}
include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );

?>