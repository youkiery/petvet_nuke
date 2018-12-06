<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

quagio();

$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());

if (!empty($action)) {
  die();
}

$data_content["doctor"] = get_doctor();

$contents = call_user_func("usg_vaccine_page", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
