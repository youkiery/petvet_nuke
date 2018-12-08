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

define(VAC_PATH, NV_ROOTDIR . "/themes/" . $module_info['theme'] . "/modules/" . $module_file);
$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");

function main_vaccine_page($data_content, $html_page = "") {
  global $module_info, $lang_module, $module_file;
  $xtpl = new XTemplate("main.tpl", VAC_PATH);
  $xtpl->assign("lang", $lang_module);
  // note: nexttime take from config
  $xtpl->assign("now", date("Y-m-d", NV_CURRENTTIME));
  $xtpl->assign("calltime", date("Y-m-d", NV_CURRENTTIME + 21 * 24 * 60 * 60));

  // var_dump($data_content["disease"]);
  // die();

  foreach ($data_content["disease"] as $id => $disease) {
    $xtpl->assign("disease_id", $id);
    $xtpl->assign("disease_name", $disease);
    $xtpl->parse("main.option");
  }

  $xtpl->parse("main");
  return $xtpl->text();
}

function main_vaccine_list($data_content, $html_page = "") {
  global $hex, $lang_module, $module_name;
  $xtpl = new XTemplate("main-list.tpl", VAC_PATH);
  $i = 1;
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("keyword", $data_content["keyword"]);
  $xtpl->assign("page", $data_content["page"]);
  $xtpl->assign("list", "/index.php?nv=$module_name&op=main-list");
  $xtpl->assign("rlist", "/index.php?nv=$module_name&op=main-list&page=rlist");

  foreach ($data_content["list"] as $data_row) {
    $xtpl->assign("index", $i);
    $xtpl->assign("vacid", $data_row["id"]);
    $xtpl->assign("diseaseid", $data_row["diseaseid"]);
    $xtpl->assign("petid", $data_row["petid"]);
    $xtpl->assign("petname", $data_row["petname"]);
    $xtpl->assign("customer", $data_row["customer"]);
    $xtpl->assign("phone", $data_row["phone"]);
    $xtpl->assign("disease", $data_content["disease"][$data_row["diseaseid"]]);
    $xtpl->assign("calltime", $data_row["calltime"]);
    $xtpl->assign("cometime", $data_row["cometime"]);
    $xtpl->assign("color", $data_row["color"]);
    $xtpl->assign("bgcolor", $data_row["bgcolor"]);
    $xtpl->assign("confirm", $data_row["confirm"]);
    $xtpl->assign("note", $data_row["note"]);
    if (!$data_row["recall"] && $data_row["status"] == 2) {
      $xtpl->parse("main.disease.body.recall");
    }
    $xtpl->parse("main.disease.body");
    $i ++;
  }

  $xtpl->parse("main.disease");
  $xtpl->parse("main");
  return $xtpl->text("main");
}

function usg_vaccine_page($data_content, $html_page = "") {
  global $lang_module, $global_config;
  $xtpl = new XTemplate("usg.tpl", VAC_PATH);
  $xtpl->assign("lang", $lang_module);

  $today = date("Y-m-d", NV_CURRENTTIME);
  $usgfilter = $global_config["usgfilter"];
  if (empty($usgfilter)) {
    $usgfilter = 30 * 24 * 60 * 60;
  }

  $xtpl->assign("now", $today);
  $xtpl->assign("calltime", date("Y-m-d", strtotime($today) + $usgfilter));

  foreach ($data_content["doctor"] as $id => $doctor) {
    $xtpl->assign("doctor_value", $id);
    $xtpl->assign("doctor_name", $doctor);
    $xtpl->parse("main.doctor");
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

function usg_vaccine_list($data_content, $html_page = "") {
  global $hex, $lang_module, $module_name;
  $xtpl = new XTemplate("usg-list.tpl", VAC_PATH);
  $i = 1;
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("keyword", $data_content["keyword"]);
  $xtpl->assign("page", $data_content["page"]);
  $xtpl->assign("list", "/index.php?nv=$module_name&op=usg-list");
  $xtpl->assign("rlist", "/index.php?nv=$module_name&op=usg-list&page=rlist");

  foreach ($data_content["list"] as $data_row) {
    $xtpl->assign("index", $i);
    $xtpl->assign("vacid", $data_row["id"]);
    $xtpl->assign("diseaseid", $data_row["diseaseid"]);
    $xtpl->assign("petid", $data_row["petid"]);
    $xtpl->assign("petname", $data_row["petname"]);
    $xtpl->assign("customer", $data_row["customer"]);
    $xtpl->assign("phone", $data_row["phone"]);
    $xtpl->assign("disease", $data_content["disease"][$data_row["diseaseid"]]);
    $xtpl->assign("cometime", $data_row["cometime"]);
    $xtpl->assign("calltime", $data_row["calltime"]);
    $xtpl->assign("color", $data_row["color"]);
    $xtpl->assign("bgcolor", $data_row["bgcolor"]);
    $xtpl->assign("confirm", $data_row["confirm"]);
    $xtpl->assign("note", $data_row["note"]);
    if (!$data_row["recall"] && $data_row["status"] == 2) {
      $xtpl->parse("main.disease.body.recall");
    }
    $xtpl->parse("main.disease.body");
    $i ++;
  }

  $xtpl->parse("main.disease");
  $xtpl->parse("main");
  return $xtpl->text("main");
}

function treat_vaccine_page($data_content, $html_page = "") {
  global $lang_module, $global_config;
  $xtpl = new XTemplate("treat.tpl", VAC_PATH);
  $xtpl->assign("lang", $lang_module);

  $today = date("Y-m-d", NV_CURRENTTIME);
  $xtpl->assign("now", $today);

  foreach ($data_content["doctor"] as $id => $doctor) {
    $xtpl->assign("doctor_value", $id);
    $xtpl->assign("doctor_name", $doctor);
    $xtpl->parse("main.doctor");
  }
  foreach ($data_content["status"] as $id => $doctor) {
    $xtpl->assign("status_name", $doctor);
    $xtpl->assign("status_value", $id);
    $xtpl->parse("main.status");
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

function treat_vaccine_list($data_content, $html_page = "") {
  global $hex, $lang_module, $module_name;
  $xtpl = new XTemplate("usg-list.tpl", VAC_PATH);
  $xtpl->assign("lang", $lang_module);
  $xtpl->assign("keyword", $data_content["keyword"]);
  $xtpl->assign("page", $data_content["page"]);
  $xtpl->assign("list", "/index.php?nv=$module_name&op=treat-list");
  $xtpl->assign("rlist", "/index.php?nv=$module_name&op=treat-list&page=rlist");
  
  $i = 1;
  foreach ($data_content["list"] as $data_row) {
    $xtpl->assign("index", $i);
    $xtpl->assign("vacid", $data_row["id"]);
    $xtpl->assign("diseaseid", $data_row["diseaseid"]);
    $xtpl->assign("petid", $data_row["petid"]);
    $xtpl->assign("petname", $data_row["petname"]);
    $xtpl->assign("customer", $data_row["customer"]);
    $xtpl->assign("phone", $data_row["phone"]);
    $xtpl->assign("cometime", $data_row["cometime"]);
    $xtpl->assign("bgcolor", $data_row["bgcolor"]);
    $xtpl->assign("confirm", $data_row["confirm"]);
    $xtpl->assign("note", $data_row["note"]);
    $xtpl->parse("main.disease.body");
    $i ++;
  }

  $xtpl->parse("main.disease");
  $xtpl->parse("main");
  return $xtpl->text("main");
}
