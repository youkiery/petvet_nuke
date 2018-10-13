<?php



/**

 * @Project NUKEVIET 3.0

 * @Author VINADES.,JSC (contact@vinades.vn)

 * @Copyright (C) 2010 VINADES., JSC. All rights reserved

 * @Createdate 3-6-2010 0:14

 */

if ( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );

$temp = $nv_Request->get_string('list_pro','get',"");
$contents ="";
$list_pro = array();
$list_pro = explode(',',$temp);
$sql = "SELECT *  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE `id` IN (" . implode( ",", $list_pro ) . ")";
//die($sql);
$result = $db->sql_query( $sql );

$xtpl = new XTemplate("compare_pro.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);

while ( $data_row = $db->sql_fetchrow($result) ) 
{
	$data_row['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/".$data_row['homeimgfile'];
	$xtpl -> assign('ROW', $data_row);
	
	$xtpl -> parse('main.grid_rows');

}

$xtpl -> parse('main');
$contents = $xtpl -> text('main');


include ( NV_ROOTDIR . "/includes/header.php" );

echo nv_site_theme( $contents );

include ( NV_ROOTDIR . "/includes/footer.php" );



?>