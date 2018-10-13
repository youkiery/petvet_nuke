<?php 

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['add_content'];
$month_dir_module = nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_name, date( "Y_m" ), true );

if (empty($global_array_cat))
{
	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat" );
	die();
}
if ( defined( 'NV_EDITOR' ) )
{
    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}

$table = "`".NV_PREFIXLANG . "_" . $module_data . "_rows`";
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );
$id = $nv_Request->get_int( 'id', 'get,post', 0 );
$data = array( 
    "id" => 0, "catid" => $catid, "title" => "", "hometext" => "", "bodytext" => "",
	"pathfile" => "","addtime" => NV_CURRENTTIME, "view" => 0, "userid" => $admin_info['admin_id'], 
	"status" => 1,"alias"=>"","img"=>"","otherpath"=>"","keywords"=>"","embed"=>""
);
if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $data['catid'] = $nv_Request->get_int( 'catid', 'post', 0 );
    $data['title'] = filter_text_input( 'title', 'post', '', 0 );
    $alias = filter_text_input( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $hometext = $nv_Request->get_string( 'hometext', 'post', '' );
    $data['hometext'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $hometext ) ), '<br />' );
    $data['filepath'] = $nv_Request->get_string( 'filepath', 'post','' );
    $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" );
    $data['filepath'] = substr( $data['filepath'], $lu );
    $data['img'] = $nv_Request->get_string( 'img', 'post','' );
    $data['img'] = substr( $data['img'], $lu );
    $data['otherpath'] = $nv_Request->get_string( 'otherpath', 'post', '');
    $bodytext = $nv_Request->get_string( 'bodytext', 'post', '' );
    $data['bodytext'] = defined( 'NV_EDITOR' ) ? nv_nl2br( $bodytext, '' ) : nv_nl2br( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
    $data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    $data['keywords'] = $nv_Request->get_string( 'keywords', 'post','' );
    $data['embed'] = $nv_Request->get_string( 'embed', 'post','' );
	if ( empty( $data['title'] ) ) $error = $lang_module['content_title_erorr'];
    else
    {
        if ( $id == 0 )
        {
            //insert data
            $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_rows` (`id`, `catid`, `title` ,`alias`, `hometext`, `bodytext`, `keywords`,`img` ,`filepath`,`otherpath`, `view`, `userid`, `status`, `addtime`,`embed`)
	         		  VALUES (NULL, " . $db->dbescape( $data['catid'] ) . ", " . $db->dbescape( $data['title'] ) . ", " . $db->dbescape( $data['alias'] ) . ", " . $db->dbescape( $data['hometext'] ) . ",  " . $db->dbescape( $data['bodytext'] ) . ", " . $db->dbescape( $data['keywords'] ) . ", " . $db->dbescape( $data['img'] ) . ", " . $db->dbescape( $data['filepath'] ) . ", " . $db->dbescape( $data['otherpath'] ) . ", " . $db->dbescape( $data['view'] ) . "," . $db->dbescape( $data['userid'] ) . "," . $db->dbescape( $data['status'] ) . "," . $db->dbescape( $data['addtime'] ) . "," . $db->dbescape( $data['embed'] ) . ")";
            $newid = intval( $db->sql_query_insert_id( $query ) );
            if ( $newid > 0 )
            {
                nv_del_moduleCache( $module_name );
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['addcontent'], $data['title'], $admin_info['userid'] );
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
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET 
    				  `catid`=" . $db->dbescape( $data['catid'] ) . ", 
    				  `title`=" . $db->dbescape( $data['title'] ) . ", 
    				  `alias` =  " . $db->dbescape( $data['alias'] ) . ", 
    				  `hometext`=" . $db->dbescape( $data['hometext'] ) . ", 
    				  `bodytext`=" . $db->dbescape( $data['bodytext'] ) . ",
    				  `keywords`= " . $db->dbescape( $data['keywords'] ) . ", 
    				  `img`=" . $db->dbescape( $data['img'] ) . ", 
    				  `filepath`=" . $db->dbescape( $data['filepath'] ) . ", 
    				  `otherpath`=" . $db->dbescape( $data['otherpath'] ) . ", 
    				  `status` =" . $db->dbescape( $data['status'] ) . ",
    				  `embed` =" . $db->dbescape( $data['embed'] ) . "
    				  WHERE id=" . intval( $id ) . "
    				  ";
            $db->sql_query( $query );
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
            die();
        }
    }
}
if ( $id > 0 )
{
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = '" . $id . "'";
    $result = $db->sql_query( $sql );
    $data = $db->sql_fetchrow( $result, 2 );
    if ( ! empty( $data['bodytext'] ) ) $data['bodytext'] = nv_htmlspecialchars( $data['bodytext'] );
    if ( ! empty( $data['filepath'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data['filepath'] ) )
    {
        $data['filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data['filepath'];
    }
	if ( ! empty( $data['img'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data['img'] ) )
    {
        $data['img'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data['img']; 
    }
}
$xtpl = new XTemplate( "content.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );
$xtpl->assign( 'DATA', $data );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.error' );
}
//view list cat
foreach ( $global_array_cat as $catid_i => $array_value )
{
    $xtitle_i = "";
    if ( $array_value['lev'] > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $select = ( $catid_i == $data['catid'] ) ? 'selected="selected"' : '';
    $array_cat = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "catid" => $catid_i, "select" => $select 
    );
    $xtpl->assign( 'ROW', $array_cat );
    $xtpl->parse( 'main.catlist' );
}
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}
$xtpl->assign( 'CURRENT', NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ) );
if ( defined( 'NV_EDITOR' ) and function_exists( 'nv_aleditor' ) )
{
    $edits = nv_aleditor( 'bodytext', '100%', '300px', $data['bodytext'] );
}
else
{
    $edits = "<textarea style=\"width: 100%\" name=\"bodytext\" id=\"bodytext\" cols=\"20\" rows=\"15\">" . $data['bodytext'] . "</textarea>";
}
$xtpl->assign( 'edit_bodytext', $edits );
$xtpl->parse('main');
$contents = $xtpl->text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

?>