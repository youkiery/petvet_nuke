<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 0:51
 */

if (!defined('NV_IS_MOD_VAC')) {
  die( 'Stop!!!' );
}
$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

function main_vaccine_page($data_content, $html_page = "") {
  global $module_info, $lang_module, $module_file;
  $xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("now", date("Y-m-d", NV_CURRENTTIME));
  // note: nexttime take from config
  $xtpl->assign("calltime", date("Y-m-d", NV_CURRENTTIME + 21 * 24 * 60 * 60));

  foreach ($data_content["disease"] as $disease_key => $disease_row) {
    $xtpl->assign("disease_id", $disease_row["id"]);
    $xtpl->assign("disease_name", $disease_row["disease"]);
    $xtpl->parse("main.option");
  }

  $xtpl->parse("main");
  return $xtpl->text();
}

function main_vaccine_list($data_content, $html_page = "") {
  global $hex, $lang_module;
  $xtpl = new XTemplate("main-list.tpl", VAC_PATH);
  $xtpl->assign("lang", $lang_module);
  $i = 1;
  foreach ($data_content["list"] as $data_row) {
    // var_dump($data_row);
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $data_row["petname"]);
    $xtpl->assign("customer", $data_row["customer"]);
    $xtpl->assign("phone", $data_row["phone"]);
    $xtpl->assign("disease", $data_row["disease"]);
    $xtpl->assign("calltime", $data_row["calltime"]);
    $xtpl->assign("cometime", $data_row["cometime"]);
    $xtpl->assign("color", $data_row["color"]);
    $xtpl->assign("bgcolor", $data_row["bgcolor"]);
    $xtpl->assign("confirm", $data_row["confirm"]);
    if (!$data_row["recall"]) {
      $xtpl->parse("main.vac_body.recall_link");
    }
    $xtpl->parse("main.vac_body");
    $i ++;
  }
  $xtpl->parse("main");
  return $xtpl->text("main");
}

