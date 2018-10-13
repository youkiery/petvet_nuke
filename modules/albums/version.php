<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if(!defined('NV_ADMIN') or !defined('NV_MAINFILE'))
{
	die('Stop!!!');
}

$module_version = array("name"=>"Albums", //
"modfuncs"=>"main,album", //
"is_sysmod"=>0, //
"virtual"=>1, //
"version"=>"3.1", //
"date"=>"Tue, 20 Otc 2011 06:03:36 GMT", //
"author"=>"PCD-Group (dinhpc.com)", //
"note"=>"", "uploads_dir"=>array($module_name),
"files_dir" => array( 
	    $module_name  
	)
);

?>