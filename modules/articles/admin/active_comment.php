<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) { die( 'Stop!!!' ); }

$status = $nv_Request->get_int( 'active', 'post' );
$listcid = $nv_Request->get_string( 'list', 'post' );
if ( ! empty( $listcid ) )
{
    $status = ( $status == 1 ) ? 1 : 0;
    $cid_array = explode( ',', $listcid );
    $cid_array = array_map( "intval", $cid_array );
    
    foreach ( $cid_array as $cid )
    {
    	$query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_comment` SET status='" . $status . "' WHERE cid=" . $cid . "";
        $db->sql_query( $query );
    	$sql = "SELECT id FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE cid='" . $cid . "'";
        $result = $db->sql_query( $sql );
        list($id) = $db->sql_fetchrow($result);
    	list( $numf ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` where `id`= '" . $id . "' AND `status`=1" ) );
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET `comment`=" . $numf . " WHERE `id`=" . $id;
        $db->sql_query( $query ); 
    }
    echo $lang_module['comment_update_success'];
}
?>