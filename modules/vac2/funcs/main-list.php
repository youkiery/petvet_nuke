<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_MOD_VAC')) {
  die( 'Stop!!!' );
}

quagio();

$page_title = $lang_module["main_title"];
$page = $nv_Request->get_string('page', 'get', '');
$keyword = $nv_Request->get_string('keyword', 'get', '');

$disease = get_disease_list();
if ($page) {
  $data_content["list"] = parse_list(get_main_recent_list($keyword, $disease), 0);
  // get recently list
}
else {
  $data_content["list"] = parse_list(get_main_list($keyword, $disease), 1);
  // get list
}
$data_content["disease"] = $disease;
$data_content["page"] = $page;
$data_content["keyword"] = $keyword;

$contents = call_user_func("main_vaccine_list", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
