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

$tester = find_vaccine(2352, 1);
echo json_encode($tester);
die();
?>
