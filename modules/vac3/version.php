<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' )) die( 'Stop!!!' );

$module_version = array( 
	"name" => "petvet", // Tieu de module
	"modfuncs" => "test, main, vaccine",
	"is_sysmod" => 0,
	"virtual" => 1,
	"version" => "0.0.01",
	"date" => "Thu, 1 Sep 2018 07:01:01 GMT",
	"author" => "Youkiery (email: youkiery@gmail.com)",
	"note"=>"",
	"uploads_dir" => array(
		$module_name
	)
);
?>