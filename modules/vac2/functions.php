<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @copyright 2011
* @createdate 26/01/2011 10:10 AM
*/

if (!defined('NV_SYSTEM')) die('Stop!!!'); 
define('NV_IS_MOD_VAC', true); 
define(VAC_PREFIX, $db_config['prefix'] . "_" . $module_data);
define(VAC_PATH, NV_ROOTDIR . "/themes/" . $module_info['theme'] . "/modules/" . $module_file);

require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php" );
?>
