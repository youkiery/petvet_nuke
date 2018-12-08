<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
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
