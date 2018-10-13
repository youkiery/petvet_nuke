<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_MOD_ARTICLES' ) ) die( 'Stop!!!' );
if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
$contents = "";
$table_name = NV_PREFIXLANG . "_" . $module_data . "_comment";

$difftimeout = 360;
$id = $nv_Request->get_int( 'id', 'post', 0 );
$name = filter_text_input( 'name', 'post', '', 0 );
if ( ! empty( $name ) && $name == $lang_module['fullname'] ) $name = '';
$email = $nv_Request->get_string( 'email', 'post', '' );
if ( ! empty( $email ) && $email == $lang_module['email'] ) $email = '';
$content = filter_text_input( 'content', 'post', '', 1 );
if ( ! empty( $content ) && $content == $lang_module['content'] ) $content = '';
$code = filter_text_input( 'code', 'post', '' );
$status = $articles_config['comment_auto'];
$data = array( 
    "content" => $content, "name" => $name, "email" => $email 
);
$error = '';
$timeout = $nv_Request->get_int( $module_name . '_' . $op . '_' . $id, 'cookie', 0 );
if ( NV_CURRENTTIME - $timeout <= $difftimeout )
{
    $timeout = ceil( ( $difftimeout - NV_CURRENTTIME + $timeout ) / 60 );
    $timeoutmsg = sprintf( $lang_module['comment_timeout'], $timeout );
    $error = $timeoutmsg;
}
elseif ( empty( $name ) )
{
    $error = $lang_module['error_fullname'];
}
elseif ( ! empty( $email ) && nv_check_valid_email( $email ) != '' )
{
    $error = $lang_module['error_email'];
}
elseif ( empty( $content ) )
{
    $error = $lang_module['error_content'];
}
elseif ( ! nv_capcha_txt( $code ) )
{
    $error = $lang_global['securitycodeincorrect'];
}
if ( empty( $error ) )
{
    $sql = "INSERT INTO `" . $table_name . "` (`cid` ,
				`id` ,
				`post_time` ,
				`post_name` ,
				`post_email` ,
				`post_ip` ,
				`status` ,
				`content`
				) 
				VALUES (NULL, " . intval( $id ) . "," . NV_CURRENTTIME . ", " . $db->dbescape( $data['name'] ) . "," . $db->dbescape( $data['email'] ) . "," . $db->dbescape( NV_CLIENT_IP ) . ", " . intval( $status ) . ", " . $db->dbescape( $data['content'] ) . ")";
    $cid = $db->sql_query_insert_id( $sql );
    if ( $cid > 0 )
    {
    	if ($status==1)
    	{
	    	$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "" . " SET `comment` = `comment`+1 WHERE `id` =" . $id . "";
	        $db->sql_query( $query );
    	}
        $contents = "OK_" . $lang_module['comment_success'];
        $nv_Request->set_Cookie( $module_name . '_' . $op . '_' . $id, NV_CURRENTTIME );
    }
    else $contents = "ERR_" . $lang_module['comment_unsuccess'];

}
else
{
    $contents = "ERR_" . $error;
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );
?>