<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/
quagio();
if (!defined('NV_IS_MOD_VAC')) {
  die( 'Stop!!!' );
}
$page_title = $lang_module["main_title"];
$page = $nv_Request->get_string('page', 'get', '');

$disease = get_disease_list();
if ($page) {
  $data_content["list"] = parse_list(get_main_recent_list($disease));
  // get recently list
}
else {
  $data_content["list"] = parse_list(get_main_list($disease), 1);
  // get list
}
$data_content["disease"] = $disease;

$contents = call_user_func("main_vaccine_list", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
