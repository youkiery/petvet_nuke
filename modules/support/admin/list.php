<?php
/**
** @Project: NUKEVIET SUPPORT ONLINE
** @Author: Viet Group (vietgroup.biz@gmail.com)
** @Copyright: VIET GROUP
** @Craetdate: 19.08.2011
** @Website: http://vietgroup.biz
*/

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$contents = nv_show_list();

include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");

?>