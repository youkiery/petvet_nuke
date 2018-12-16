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
$page_title = $lang_module["tester"];

// parse_order(array());
$filter = array("time_type" => "1", "from" => 1500, "end" => 3200);
$today = strtotime(date("Y-m-d")) + DAY;
$nextweek = $today + MONTH;


// $tester = insert_pet("Trường", 1);
// $tester = confirm_vaccine(1, 1, 1);
// $tester = confirm_usg(1, 1, 1);
// $tester = insert_disease(1, "DISEASE 1");
// $tester = insert_doctor("DOCTOR 1");
// $tester = insert_vaccine(2, 1, 1, $today, $nextweek, "");
// $filter = array("keyword" => "a", "customer" => 1, "pet" => 1);
// echo parse_filter($filter);
// $tester = get_vaccine_list();
// $filter = array("page" => 1, "limit" => 10, "sort" => 1);
// echo parse_filter($filter);  
vaccine_list(1, 10);
// echo $tester;
die();
?>
