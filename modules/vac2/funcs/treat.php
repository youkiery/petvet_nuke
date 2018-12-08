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

$doctor = get_doctor();
$data_content["doctor"] = $doctor;
$data_content["status"] = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");

$contents = call_user_func("treat_vaccine_page", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
