<?php

/**
 * @Project VINAGON - HOTDEAL 1.1.0
 * @Author VINAGON.COM (info@vinagon.com)
 * @Copyright (C) 2012 VINAGON.COM. All rights reserved
 * @Createdate Sat, 08 Aug 2013 02:59:43 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

/*action del row*/
$ac = $nv_Request->get_string( 'ac', 'get', 0 );
if ($ac=='del')
{
	$id = $nv_Request->get_string( 'id', 'get', '' );
	$sql = "DELETE FROM `" . $db_config['prefix'] . "_" . $module_data . "_email` WHERE `id` = '" . intval( $id ) . "'";
    $result = $db->sql_query( $sql );
  //  nv_insert_logs( NV_LANG_DATA, $module_name, 'del_key', $id, $admin_info['userid'] );
	$db->sql_freeresult();
    die($lang_module['del_complete']);
}
elseif ($ac=='delall')
{
	$listall = $nv_Request->get_string( 'listall', 'post,get' );
    if (!empty($listall))
    {
    	$sql = "DELETE FROM `" . $db_config['prefix'] . "_" . $module_data . "_email` WHERE `id` IN (" . $listall . ")";
	    $result = $db->sql_query( $sql );
	    nv_insert_logs( NV_LANG_DATA, $module_name, 'del_email', $listall, $admin_info['userid'] );
		$db->sql_freeresult();
    	die($lang_module['del_complate']);
    }
    die('no!!');
}

/*********/
$page_title = $lang_module['emaillist'];

$per_page = $nv_Request->get_int( 'per_page', 'get',30);
$page = $nv_Request->get_int( 'page', 'get', 0 );
$q = filter_text_input( 'q', 'get', '', 1 );

$back_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&q=" . $q . "&page=" . $page;
$table = "`".$db_config['prefix'] . "_" . $module_data . "_email`";

$id = $nv_Request->get_string( 'id', 'get', '' );

$data = array ("id"=>"", "email"=>"","addtime" => NV_CURRENTTIME );

if ( $id != '' )
{
	$sql = "SELECT * FROM " . $table . " WHERE id=".$db->dbescape_string($id)."";
	$result = $db->sql_query( $sql );
	$data = $db->sql_fetchrow($result,2);
	$db->sql_freeresult();
}
if ( $nv_Request->get_int( 'save', 'post', 0 ) == 1 )
{
	$data['email'] = $nv_Request->get_string( 'email', 'post', '' );
	if ( $id == '' )
	{
	 	$query = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_email`
					( `id`,`email`, `addtime` ) VALUES ( NULL,".$db->dbescape_string( $data['email'] ) . ",".$db->dbescape_string( $data['addtime'] ) .");";
        $db->sql_query( $query );
	}
	elseif ( $id != '' )
	{
	 	$query = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_email` SET 
    					 `email`=" . $db->dbescape_string( $data['email'] ) . "
                  WHERE `id` =" . $db->dbescape_string($id) . "";
		
        $db->sql_query( $query );
	}
	$db->sql_freeresult();
	nv_del_moduleCache( $module_name );
	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
	die();
}

/**
 * begin: formview data 
 */
$xtpl = new XTemplate( "email.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'DATA', $data );
$xtpl->assign( 'q', $q );
$xtpl->assign( 'URLBACK', $back_url );
$xtpl->assign( 'DELALL', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op."&ac=delall" );

//begin: listdata
$where = array();
$where_sql="";
if ( !empty($q) ) $where[] = " ( `email` LIKE '%" . $db->dblikeescape( $q ) . "%' ) "; 
if ( !empty($where) ) 
{
	$where_sql = " WHERE " . implode(" AND ", $where);
}
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " ".$where_sql." ORDER BY `addtime` DESC LIMIT " . $page . "," . $per_page;
$result = $db->sql_query( $sql );
$result_all = $db->sql_query( "SELECT FOUND_ROWS()" );
list( $numf ) = $db->sql_fetchrow( $result_all );
$all_page = ( $numf ) ? $numf : 1;
$i=1;
while ( $row = $db->sql_fetchrow($result,2) )
{
	$row['addtime'] = date('H:i, d/m/Y',$row['addtime']); 
	$row['bg'] = ($i%2==0)? "class=\"second\"":""; 
	$row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&ac=del&id=".$row['id'];
	$row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&id=".$row['id'];
	$xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.loop' );
    $i++;
}
$db->sql_freeresult();
//end: listdata
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op ."&q=" . $q;
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if ( $generate_page != "" ) 
{
	$xtpl->assign( 'generate_page', $generate_page );
	$xtpl->parse( 'main.page' );
}
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>