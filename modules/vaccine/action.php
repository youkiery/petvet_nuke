<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @copyright 2011
* @createdate 26/01/2011 10:10 AM
*/

if (!defined('NV_IS_FILE_MODULES')) die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_customer`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_disease`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_doctor`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_pet`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_treat`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_treating`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_usg`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_vaccine`";
$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_disease` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_pet` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `customerid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_treat` (
  `id` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `doctorid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `catime` int(11) DEFAULT NULL,
  `insult` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_treating` (
  `id` int(11) NOT NULL,
  `treatid` int(11) NOT NULL,
  `temperate` varchar(200) NOT NULL,
  `eye` varchar(200) NOT NULL,
  `orther` varchar(500) NOT NULL,
  `examine` tinyint(4) NOT NULL,
  `image` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  `treating` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `doctorx` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_usg` (
  `id` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `doctorid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `calltime` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_vaccine` (
  `id` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `diseaseid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `calltime` int(11) NOT NULL,
  `note` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `recall` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

