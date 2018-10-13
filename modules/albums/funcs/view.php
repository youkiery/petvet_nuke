<?php
/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$id = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $id = intval( end( $temp ) );
    }
}
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = '" . $id . "' AND status=1 ";
$result = $db->sql_query( $sql );
$data_content = $db->sql_fetchrow( $result, 2 );
if ( empty($data_content) ) die('stop!!');

$page_title = $data_content['title'];

$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET view=view+1 WHERE `id` = '" . $id . "'";
$result = $db->sql_query( $sql );

$data_content['addtime'] = date("d/m/Y",$data_content['addtime']);
if ( ! empty( $data_content['img'] ) ) $data_content['img'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data_content['img'];
$data_content['file_src'] = ( !empty($data_content['filepath']) ) ? NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row['filepath'] : $data_content['otherpath'];

$data_other = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE status=1 AND catid=".$data_content['catid']." AND id!= ".$data_content['id']." ORDER BY RAND() LIMIT 12";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow($result,2) )
{
	$data_other[] = $row;
}

$contents = view_videos($data_content,$data_other);

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>