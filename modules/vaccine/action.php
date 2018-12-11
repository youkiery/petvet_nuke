<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @copyright 2011
* @createdate 26/01/2011 10:10 AM
*/

if (!defined('NV_IS_FILE_MODULES')) die('Stop!!!');
define('VAC_PREFIX', $db_config['prefix'] . "_" . $module_data);

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_customer`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_disease`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_doctor`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_pet`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_treat`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_treating`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_usg`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . VAC_PREFIX . "_vaccine`";
$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_pet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `customerid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_treat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `petid` int(11) NOT NULL,
  `doctorid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `calltime` int(11) DEFAULT NULL,
  `insult` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_treating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `treatid` int(11) NOT NULL,
  `temperate` varchar(200) NOT NULL,
  `eye` varchar(200) NOT NULL,
  `other` varchar(500) NOT NULL,
  `examine` tinyint(4) NOT NULL,
  `image` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  `treating` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `doctorx` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_usg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `petid` int(11) NOT NULL,
  `doctorid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `calltime` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "CREATE TABLE `" . VAC_PREFIX . "_vaccine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `petid` int(11) NOT NULL,
  `diseaseid` int(11) NOT NULL,
  `cometime` int(11) NOT NULL,
  `calltime` int(11) NOT NULL,
  `note` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `recall` int(11) NOT NULL,
  `doctorid` int(11) NOT NULL
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sql_create_module[] = "INSERT INTO " . $db_config["prefix"] . "_config (lang, module, config_name, config_value) values ('vi', '" . $module_data . "', 'filter_time', 1209600)";
$sql_create_module[] = "INSERT INTO " . $db_config["prefix"] . "_config (lang, module, config_name, config_value) values ('vi', '" . $module_data . "', 'expert_time', 1296000)";
$sql_create_module[] = "INSERT INTO " . $db_config["prefix"] . "_config (lang, module, config_name, config_value) values ('vi', '" . $module_data . "', 'sort_type', 0)";

