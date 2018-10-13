<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( defined( 'NV_EDITOR' ) )
{
    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}
$table_name = NV_PREFIXLANG . "_" . $module_data . "";
$month_dir_module = nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_name, date( "Y_m" ), true );
$articles_config = $module_config[$module_name];
$data = array( 
    "id" => 0, "title" => "", "alias" => "", "homefileimg" => "", "hometext" => "", "bodytext" => "", "keywords" => "", "author" => "", "source" => "", "link_active" => 0, "link_redirect" => "", "weight" => 0, "admin_id" => 0, "add_time" => NV_CURRENTTIME, "edit_time" => NV_CURRENTTIME, "status" => 0,"comment"=>0,"view"=>0,"inhome"=>1,"allow_comment"=>$articles_config['active_comment'] 
);
$data['id'] = $nv_Request->get_int( 'id', 'get,post', 0 );
$error = '';
if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    $data['inhome'] = $nv_Request->get_int( 'inhome', 'post', 0 );
    $data['allow_comment'] = $nv_Request->get_int( 'allow_comment', 'post', 0 );
    $data['title'] = filter_text_input( 'title', 'post', '', 1 );
    $alias = filter_text_input( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $data['hometext'] = filter_text_input( 'hometext', 'post', '' );
    $data['homefileimg'] = filter_text_input( 'homeimg', 'post', '' );
    if ( ! nv_is_url( $data['homefileimg'] ) and file_exists( NV_DOCUMENT_ROOT . $data['homefileimg'] ) )
    {
        $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" );
        $data['homefileimg'] = substr( $data['homefileimg'], $lu );
    }
    elseif ( ! nv_is_url( $data['homefileimg'] ) )
    {
        $data['homefileimg'] = "";
    }
    $bodytext = $nv_Request->get_string( 'bodytext', 'post', '' );
    $data['bodytext'] = defined( 'NV_EDITOR' ) ? nv_nl2br( $bodytext, '' ) : nv_nl2br( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
    $data['keywords'] = filter_text_input( 'keywords', 'post', '', 1 );
    $data['source'] = filter_text_input( 'source', 'post', '', 1 );
    $data['author'] = filter_text_input( 'author', 'post', '', 1 );
    $data['link_active'] = $nv_Request->get_int( 'link_active', 'post', 0 );
    $data['link_redirect'] = $nv_Request->get_string( 'link_redirect', 'post', '' );
    if ( empty( $data['title'] ) )
    {
        $error = $lang_module['title_error'];
    }
    if ( $data['id'] == 0 && empty( $error ) )
    {
        list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM " . $table_name . " " ) );
        $data['weight'] = intval( $weight ) + 1;
        $query = "INSERT INTO " . $table_name . " (`id` ,`title` ,`alias` ,`homefileimg` ,`hometext` ,`bodytext` ,`keywords` ,`author` ,`source` ,`link_active` ,`link_redirect` ,`weight` ,`admin_id` ,`add_time` ,`edit_time` ,`status`, `comment`,`view`,`inhome`,`allow_comment`) VALUES 
                (   NULL, 
	                " . $db->dbescape_string( $data['title'] ) . ",
	                " . $db->dbescape_string( $data['alias'] ) . ",
	                " . $db->dbescape_string( $data['homefileimg'] ) . ",
	                " . $db->dbescape_string( $data['hometext'] ) . ",
	                " . $db->dbescape_string( $data['bodytext'] ) . ",
	                " . $db->dbescape_string( $data['keywords'] ) . ",
	                " . $db->dbescape_string( $data['source'] ) . ",
	                " . $db->dbescape_string( $data['author'] ) . ",
	                " . intval( $data['link_active'] ) . ",  
	                " . $db->dbescape_string( $data['link_redirect'] ) . ",
	                " . intval( $data['weight'] ) . ",  
	                " . intval( $data['admin_id'] ) . ",  
	                " . intval( $data['add_time'] ) . ",  
	                " . intval( $data['edit_time'] ) . ",  
	                " . intval( $data['status'] ) . ",
	                " . intval( $data['comment'] ) . ",
	                " . intval( $data['view'] ) . ",
	                " . intval( $data['inhome'] ) . ",
	                " . intval( $data['allow_comment'] ) . "
                )";
        $data['id'] = $db->sql_query_insert_id( $query );
        if ( $data['id'] > 0 )
        {
            nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['content_add'], $data['title'], $admin_info['userid'] );
            nv_del_moduleCache( $module_name );
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
            die();
        }
        else
        {
            $error = $lang_module['errorsave'];
        }
        $db->sql_freeresult();
    }
    elseif ( $data['id'] > 0 && empty( $error ) )
    {
        $query = "UPDATE " . $table_name . " SET 
    					    `title`=" . $db->dbescape_string( $data['title'] ) . ", 
                            `alias`=" . $db->dbescape_string( $data['alias'] ) . ", 
                            `homefileimg`=" . $db->dbescape_string( $data['homefileimg'] ) . ",
                            `hometext`=" . $db->dbescape_string( $data['hometext'] ) . ", 
                            `bodytext`=" . $db->dbescape_string( $data['bodytext'] ) . ", 
                            `keywords`=" . $db->dbescape_string( $data['keywords'] ) . ", 
                            `source`=" . $db->dbescape_string( $data['source'] ) . ", 
                            `author`=" . $db->dbescape_string( $data['author'] ) . ", 
                            `link_active` = " . intval( $data['link_active'] ) . ",  
			                `link_redirect` = " . $db->dbescape_string( $data['link_redirect'] ) . ",
			                `edit_time` = " . intval( $data['edit_time'] ) . ",  
			                `status` = " . intval( $data['status'] ) . ",
			                `inhome` = " . intval( $data['inhome'] ) . ",
			                `allow_comment` = " . intval( $data['allow_comment'] ) . "
                        WHERE `id` =" . $data['id'] . "";
        $db->sql_query( $query );
        if ( $db->sql_affectedrows() > 0 )
        {
            nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['content_edit'], $data['title'], $admin_info['userid'] );
            nv_del_moduleCache( $module_name );
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
            die();
        }
    }
}
if ( $data['id'] > 0 )
{
    $sql = "SELECT * FROM " . $table_name . " WHERE id=" . intval( $data['id'] );
    $result = $db->sql_query( $sql );
    $data = $db->sql_fetchrow( $result, 2 );
}
$xtpl = new XTemplate( "content.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );
$xtpl->assign( 'NV_UPLOADS_DIR', NV_UPLOADS_DIR );
if ( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
{
    $edits = nv_aleditor( 'bodytext', '100%', '300px', $data['bodytext'] );
}
else
{
    $edits = "<textarea style=\"width: 100%\" name=\"bodytext\" id=\"bodytext\" cols=\"20\" rows=\"15\">" . $data['bodytext'] . "</textarea>";
}
$xtpl->assign( 'bodytext', $edits );
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}

if ( ! empty( $data['homefileimg'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data['homefileimg'] ) )
{
    $data['homefileimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data['homefileimg'];
}
$xtpl->assign( 'DATA', $data );
$ck_link = ( $data['link_active'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'check_link', $ck_link );

$ck_inhome = ( $data['inhome'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'check_inhome', $ck_inhome );

$ck_allow_comment = ( $data['allow_comment'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'check_allow_comment', $ck_allow_comment );

if ( ! empty( $error ) )
{
    $xtpl->assign( 'error', $error );
    $xtpl->parse( 'main.error' );
}
$xtpl->assign( 'CURRENT', NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ) );
$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['content'];

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>