<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */
 
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$listcid = $nv_Request->get_string( 'list', 'post,get' );

if ( ! empty( $listcid ) )
{
    nv_insert_logs( NV_LANG_DATA, $module_name, 'delte comment', "listcid ".$listcid, $admin_info['userid'] );
	$cid_array = explode( ',', $listcid );
    $cid_array = array_map( "intval", $cid_array );
    foreach ( $cid_array as $cid )
    {
        $sql = "SELECT id FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE cid='" . $cid . "'";
        $result = $db->sql_query( $sql );
        list($id) = $db->sql_fetchrow($result);
        //delete
    	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_comment` WHERE cid='" . $cid . "'";
        $result = $db->sql_query( $sql );
        //update
        $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "" . " SET `comment` = `comment`-1 WHERE `id` =" . $id . "";
        $db->sql_query( $query );
    }
    echo $lang_module['comment_delete_success'];
}

?>