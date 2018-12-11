<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/
quagio();
    if ( ! defined( 'NV_IS_MOD_QUANLY' ) ) die( 'Stop!!!' );
    $page_title = $lang_module["main_title"];
    $xtpl = new XTemplate("list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
    $xtpl->assign("lang", $lang_module);

    $sql = "select * from " . VAC_PREFIX . "_doctor";
    $query = $db->sql_query($sql);
    while($row = $db->sql_fetch_assoc($query)) {
      $xtpl->assign("doctorid", $row["id"]);
      $xtpl->assign("doctorname", $row["name"]);
      $xtpl->parse("main.doctor");
    }

    $page = $nv_Request->get_string('page', 'get', '');

    $diseases = getDiseaseList();
    $vaclist = array();

    if ($page == "list") {
        $vaclist = getrecentlist(NV_CURRENTTIME, $module_config[$module_file]["filter_time"], $module_config[$module_file]["sort_type"]);
    } else {
        $vaclist = filterVac(NV_CURRENTTIME, $module_config[$module_file]["filter_time"], $module_config[$module_file]["sort_type"]);
    }
  
    if ($page == "list") {
      $xtpl->assign("content", filter($vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $module_config[$module_file]["filter_time"], $module_config[$module_file]["sort_type"], 0));
    } else {
      $xtpl->assign("content", filter($vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $module_config[$module_file]["filter_time"], $module_config[$module_file]["sort_type"], 1));
    }

    $xtpl->parse("main");

    $contents = $xtpl->text("main");
    
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
?>
