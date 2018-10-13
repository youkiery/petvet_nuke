<?php

if ( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "`;";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_group`;";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config`;";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `idgroup` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `links` varchar(255) NOT NULL,
  `bodytext` mediumtext NOT NULL,
  `keywords` mediumtext NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `admin_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `edit_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_group` (

  `id` int(11) NOT NULL auto_increment,

  `title` varchar(255) NOT NULL default '',

  `description` varchar(255) NOT NULL default '',

  `weight` smallint(4) NOT NULL DEFAULT '0',

  PRIMARY KEY  (`id`)

) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config` (

  `id` int(11) NOT NULL auto_increment,

  `title` varchar(255) NOT NULL default '',

  `description` varchar(255) NOT NULL default '',

  `weight` smallint(4) NOT NULL DEFAULT '0',

  PRIMARY KEY  (`id`)

) ENGINE=MyISAM";


$sql_create_module[] = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_config` 
(`id`, `title`, `description`, `weight`) VALUES 
(NULL, 'slider', '', '1')"; 


?>