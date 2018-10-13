<?php
/**
** @Project: NUKEVIET SUPPORT ONLINE
** @Author: Viet Group (vietgroup.biz@gmail.com)
** @Copyright: VIET GROUP
** @Craetdate: 19.08.2011
** @Website: http://vietgroup.biz
*/

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['support16'];

$contents = "<div id=\"module_show_list_group\">";
$contents .= nv_show_list_group();
$contents .= "</div>\n";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>