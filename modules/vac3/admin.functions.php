<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined( 'NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
  die('Stop!!!'); 
}
define('NV_IS_VAC_ADMIN', true);
define('VAC_PREFIX', $db_config['prefix'] . "_" . $module_name);
define("MINUTE", 60);
define("HOUR", 60 * MINUTE);
define("DAY", 24 * HOUR);
define("WEEK", 7 * DAY);
define("MONTH", 30 * DAY);
define("SEASON", 3 * MONTH);
define("YEAR", 4 * SEASON);
require_once NV_ROOTDIR . "/modules/" . $module_name . '/global.functions.php';
?>
