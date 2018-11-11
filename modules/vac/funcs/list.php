<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/
$today = strtotime(date("Y-m-d"));
$from = $today + 7 * 60 * 60;
$end = $today + 17 * 60 * 60 + 30 * 60;

if (NV_CURRENTTIME < $from || NV_CURRENTTIME > $end) {
    $xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign("lang", $lang_module);

    $xtpl->parse("overtime");
    $contents = $xtpl->text("overtime");

    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme($contents);
    include ( NV_ROOTDIR . "/includes/footer.php" );
} else {
    if ( ! defined( 'NV_IS_MOD_VAC' ) ) die( 'Stop!!!' );
    $page_title = $lang_module["main_title"];
    $xtpl = new XTemplate("list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign("lang", $lang_module);

    $page = $nv_Request->get_string('page', 'get', '');

    $diseases = getDiseaseList();
    $vaclist = array();
    // echo $global_config["filter_time"]; die();
    if ($page == "list") {
      foreach ($diseases as $id => $disease) {
        $vaclist_disease = getrecentlist(NV_CURRENTTIME, $global_config["filter_time"], $global_config["sort_type"], $disease["id"]);
        // echo date("Y-m-d", NV_CURRENTTIME) . ", " . $global_config["filter_time"] . ", " . $global_config["sort_type"] . ", " . $disease["id"] . " | ";
        // var_dump($vaclist_disease);
        $vaclist = array_merge($vaclist, $vaclist_disease);
      }
    } else {
      foreach ($diseases as $id => $disease) {
        $vaclist_disease = filterVac(NV_CURRENTTIME, $global_config["filter_time"], $global_config["sort_type"], $disease["id"]);
        // echo date("Y-m-d", NV_CURRENTTIME) . ", " . $global_config["filter_time"] . ", " . $global_config["sort_type"] . ", " . $disease["id"] . " | ";
        // var_dump($vaclist_disease);
        $vaclist = array_merge($vaclist, $vaclist_disease);
      }
    }
    // die();
    // var_dump($vaclist); die();
  
    if ($page == "list") {
      $xtpl->assign("content", filter($vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $global_config["filter_time"], $global_config["sort_type"], 0));
    } else {
      // echo $vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $global_config["filter_time"], $global_config["sort_type"]), 1;
      // die();
      $xtpl->assign("content", filter($vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $global_config["filter_time"], $global_config["sort_type"], 1));
    }

    $xtpl->parse("main");

    $contents = $xtpl->text("main");
    
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
}
?>
