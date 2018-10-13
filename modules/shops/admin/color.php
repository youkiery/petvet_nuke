
<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['color'];

$error = "";
$savecat = 0;
$data = array(
	'cid' => 0,
	'title' => '',
	'description' => '',
);

$table_name = $db_config['prefix'] . "_" . $module_data . "_color";
$savecat = $nv_Request->get_int( 'savecat', 'post', 0 );
$data['cid'] = $nv_Request->get_int( 'cid', 'post,get', 0 );
$ac=$nv_Request->get_string('ac','get,post','');
//die( $db_config['prefix']."_".$module_data . "_color");
if($ac=='del')
{
	$sql="DELETE FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` WHERE `cid` =".$data['cid'];
	//die($sql);
	$db->sql_query( $sql );
	if( $db->sql_affectedrows() > 0 )
	{
		$error = $lang_module['saveok'];
		$db->sql_freeresult();
		nv_del_moduleCache( $module_name );
		Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
		die();
	}
	else
	{
		$error = $lang_module['errordel'];
		
	}
}

if( ! empty( $savecat ) )
{
	$data['cid'] = $nv_Request->get_int( 'cid', 'post,get', 0 );
	$data['title'] = filter_text_input( 'title', 'post', '', 1, 255 );
	$data['description'] = $nv_Request->get_string( 'description', 'post', '' );
	
	// Cat mo ta cho chinh xac
	if( strlen( $data['description'] ) > 255 )
	{
		$data['description'] = nv_clean60( $data['description'], 250 );
	}
	
	// Kiem tra loi
	if( empty( $data['title'] ) )
	{
		$error = $lang_module['color_error_name'];
	}
	else
	{
		if( $data['cid'] == 0 )
		{
			
				list( $weight ) = $db->sql_fetchrow( $db->sql_query( "SELECT max(`weight`) FROM `" . $db_config['prefix'] . "_" . $module_data . "_color`" ) );
				$weight = intval( $weight ) + 1;
								
				$sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_color` (`cid`,`title`, `description`, `weight`, `add_time`, `edit_time`)
				 VALUES (NULL," . $db->dbescape( $data['title'] ) . "," . $db->dbescape( $data['description'])."," . $db->dbescape( $weight ) . ",UNIX_TIMESTAMP( ),UNIX_TIMESTAMP( ))";
				if( $db->sql_query_insert_id( $sql ) )
				{
					$db->sql_freeresult();
				//	nv_del_moduleCache( $module_name );
					Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
					die();
				}
				else
				{
					$error = $lang_module['errorsave'];
				}
			
		}
		else
		{
			
			if( $db->sql_numrows( $db->sql_query( "SELECT `cid` FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` WHERE `title`=" . $db->dbescape( $data['title'] ) . " AND `cid`!=" . $data['cid'] ) ) )
			{
				$error = $lang_module['color_error_names'];
			}
			else
			{
				$sql = "UPDATE `" . $db_config['prefix'] . "_" . $module_data . "_color` SET `title`=" . $db->dbescape( $data['title'] ) . ",  `description`=" . $db->dbescape( $data['description'] ) . ", `edit_time`=UNIX_TIMESTAMP( ) WHERE `cid` =" . $data['cid'];
				$db->sql_query( $sql );
				
				if( $db->sql_affectedrows() > 0 )
				{
					$error = $lang_module['saveok'];
					$db->sql_freeresult();
					nv_del_moduleCache( $module_name );
					Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
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
}


$xtpl = new XTemplate( "color.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

//
$sql = "SELECT * FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` ORDER BY `weight` ASC";
	$result = $db->sql_query( $sql );
	
	$num = $db->sql_numrows( $result );
		$a = 0;		
		while( $row = $db->sql_fetchrow( $result ) )
		{

			$xtpl->assign( 'ROW', array(
				"class" => ( $a % 2 ) ? " class=\"second\"" : "",
				"cid" => $row['cid'],
				"title" => $row['title'],
			) );

			for( $i = 1; $i <= $num; $i++ )
			{
				$xtpl->assign( 'WEIGHT', array( "key" => $i, "title" => $i, "selected" => $i == $row['weight'] ? " selected=\"selected\"" : "" ) );
				$xtpl->parse( 'main.loop.weight' );
			}
			$xtpl->parse( 'main.loop' );
			$a ++;
		}

$data['cid'] = $nv_Request->get_int( 'cid', 'get', 0 );

if( $data['cid'] > 0 )
{
	list( $data['cid'], $data['title'], $data['description'] ) = $db->sql_fetchrow( $db->sql_query( "SELECT `cid`, `title`,  `description`  FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` where `cid`=" . $data['cid'] . "" ) );
	$xtpl->assign('TITLE',$lang_module['edit_color_cat']);
}
else	
	$xtpl->assign('TITLE',$lang_module['color']);
$xtpl->assign( 'DATA', $data );

if( $error != "" )
{
	$xtpl->assign( 'ERROR', $error );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>