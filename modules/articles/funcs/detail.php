<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_MOD_ARTICLES' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$table_name = NV_PREFIXLANG . "_" . $module_data . "";
$array_data_other = $array_data = array();
$order = "";
switch ( $articles_config['order'] )
{
	case "random" : $order = "ORDER BY RAND()" ; break;
	case "weight" : $order = "ORDER BY weight ASC" ; break;
	case "dateup" : $order = "ORDER BY ID DESC" ; break;
	case "atoz" : $order = "ORDER BY title ASC" ; break;
	case "ztoa" : $order = "ORDER BY title DESC" ; break;
}
if ( $id > 0 )
{
    $sql = "SELECT * FROM " . $table_name . " WHERE status =1 AND id=" . intval( $id ) ;
    $result = $db->sql_query( $sql );
    $array_data = $db->sql_fetchrow( $result, 2 );
    if (!empty($array_data))
    {
    	$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "" . " SET `view` = `view`+1 WHERE `id` =" . $id . "";
        $db->sql_query( $query );
    	$page_title = $array_data['title'];
		$key_words = $array_data['keywords'];
    }
    $sql = "SELECT * FROM " . $table_name . " WHERE status =1 AND id < " . intval( $id ) ." ".$order." LIMIT 0,10";
    $result = $db->sql_query( $sql );
	while ( $row = $db->sql_fetchrow( $result ) )
	{
	    $array_data_other[]= $row;
	}
}
if (empty ($array_data)) die('stop!!!');
$contents = nv_theme_articles_detail( $array_data,$array_data_other );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>