<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['albums'];
$groups_list = nv_groups_list();
$contents = "";
$error = "";
$albumid = $nv_Request->get_int( 'id', 'get,post', 0 );
$data = array( 
    "id" => 0, "title" => "", "alias" => "", "description" => "", "img" => "", "inhome" => 1, "keywords" => "", "admins" => $admin_info['userid'], "view" => 0, "comment" => 0, "add_time" => NV_CURRENTTIME, "edit_time" => NV_CURRENTTIME, "who_view" => 0, "groups_view" => 0, "numitems" => 0 
);
$table = "`" . NV_PREFIXLANG . "_" . $module_data . "_rows`";
$month_dir_module = nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_name, date( "Y_m" ), true );
$id = $nv_Request->get_int( 'id', 'get', 0 );
//post data
if ( $nv_Request->get_int( 'save', 'post', 0 ) == '1' )
{
    $data['title'] = filter_text_input( 'title', 'post', '', 1 );
    $data['keywords'] = filter_text_input( 'keywords', 'post', '', 1 );
    $alias = filter_text_input( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $description = $nv_Request->get_string( 'description', 'post', '' );
    $data['description'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br />' );
    $data['who_view'] = $nv_Request->get_int( 'who_view', 'post', 0 );
    $groups = $nv_Request->get_typed_array( 'groups_view', 'post', 'int', array() );
    $groups = array_intersect( $groups, array_keys( $groups_list ) );
    $data['groups_view'] = implode( ",", $groups );
    $data['img'] = $nv_Request->get_string( 'img', 'post', '' );
    $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" );
    $data['img'] = substr( $data['img'], $lu );
    if ( empty( $data['title'] ) ) $error = $lang_module['albums_title_erorr'];
    else
    {
        if ( $id == 0 )
        {
            //insert data
            $query = "INSERT INTO " . $table . " (`id`, `title`, `alias`, `description`, `img`, `inhome`, `keywords`, `admins`, `view`, `comment`, `add_time`, `edit_time`, `who_view`, `groups_view`, `numitems`)
	         		  VALUES (NULL, " . $db->dbescape( $data['title'] ) . ", " . $db->dbescape( $data['alias'] ) . ", " . $db->dbescape( $data['description'] ) . ", " . $db->dbescape( $data['img'] ) . ", 
	         		  				" . $db->dbescape( $data['inhome'] ) . ", " . $db->dbescape( $data['keywords'] ) . ", " . $db->dbescape( $data['admins'] ) . ", " . $db->dbescape( $data['view'] ) . ", 
	         		  				" . $db->dbescape( $data['comment'] ) . ", " . $db->dbescape( $data['add_time'] ) . ", " . $db->dbescape( $data['edit_time'] ) . ", " . $db->dbescape( $data['who_view'] ) . ", 
	         		  				" . $db->dbescape( $data['groups_view'] ) . ", " . $db->dbescape( $data['numitems'] ) . ")";
            $newid = intval( $db->sql_query_insert_id( $query ) );
            if ( $newid > 0 )
            {
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_albums'], $data['title'], $admin_info['userid'] );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
                die();
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
            $db->sql_freeresult();
        }
        elseif ( $id > 0 )
        {
            //update data
            $query = "UPDATE " . $table . " SET 
    				`title`=" . $db->dbescape( $data['title'] ) . ", 
    				`alias` =  " . $db->dbescape( $data['alias'] ) . ", 
    				`description`=" . $db->dbescape( $data['description'] ) . ", 
    				`keywords`= " . $db->dbescape( $data['keywords'] ) . ", 
    				`who_view`=" . $db->dbescape( $data['who_view'] ) . ", 
    				`img` =  " . $db->dbescape( $data['img'] ) . ", 
    				`groups_view`=" . $db->dbescape( $data['groups_view'] ) . ", 
    				`edit_time`=UNIX_TIMESTAMP( ) WHERE `id` =" . $id . "";
            $db->sql_query( $query );
            if ( $db->sql_affectedrows() > 0 )
            {
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['edit_albums'], $data['title'], $admin_info['userid'] );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
                die();
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
            $db->sql_freeresult();
        }
    }
}
//select data
if ( $id > 0 )
{
    $sql = "SELECT * FROM " . $table . " WHERE `id` = '" . $id . "'";
    $result = $db->sql_query( $sql );
    $data = $db->sql_fetchrow( $result, 2 );
}
if ( ! empty( $data['img'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data['img'] ) )
{
    $data['img'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data['img'];
}
/**
 * begin: listview data 
 */
$per_page = 30;
$page = $nv_Request->get_int( 'page', 'get', 0 );
$xtpl = new XTemplate( "album.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );
$xtpl->assign( 'DATA', $data );
$xtpl->assign( 'CURRENT', NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ) );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
if ( $error != "" )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.error' );
}
//$array_who_view
$xtpl->assign( 'who_views', drawselect_status( "who_view", $array_who_view, $data['who_view'], 'show_group()' ) );
//$groups_list
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}
if ( ! empty( $groups_list ) )
{
    $groups_view = explode( ",", $data['groups_view'] );
    foreach ( $groups_list as $groups_id => $groups_title )
    {
        $check = "";
        if ( in_array( $groups_id, $groups_view ) )
        {
            $check = 'checked="checked"';
        }
        $data_temp = array( 
            "value" => $groups_id, "title" => $groups_title, "check" => $check 
        );
        $xtpl->assign( 'groups_views', $data_temp );
        $xtpl->parse( 'main.groups_views' );
    }
}
$xtpl->assign( 'hidediv', $data['who_view'] == 3 ? "visibility:visible" : "visibility:hidden" );
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>