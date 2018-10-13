<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if(!defined('NV_IS_FILE_MODULES'))
	die('Stop!!!');

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat`";

$sql_create_module = $sql_drop_module;

// Category
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `alias` varchar(255) NOT NULL,
  `hometext` text,
  `bodytext` mediumtext NOT NULL,
  `keywords` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `createddate` int(11) NOT NULL DEFAULT '0',
  `filepath` varchar(255) NOT NULL,
  `otherpath` varchar(255) NOT NULL,
  `view` int(8) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `embed` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM";

// Picture
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat` (
  `catid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `thumbnail` varchar(255) NOT NULL DEFAULT '',
  `weight` smallint(4) unsigned NOT NULL DEFAULT '0',
  `order` mediumint(8) NOT NULL DEFAULT '0',
  `lev` smallint(4) NOT NULL DEFAULT '0',
  `viewcat` varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
  `numsubcat` int(11) NOT NULL DEFAULT '0',
  `subcatid` varchar(255) NOT NULL DEFAULT '',
  `inhome` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `numlinks` tinyint(2) unsigned NOT NULL DEFAULT '3',
  `keywords` mediumtext NOT NULL,
  `admins` mediumtext NOT NULL,
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0',
  `del_cache_time` int(11) NOT NULL DEFAULT '0',
  `who_view` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `groups_view` varchar(255) NOT NULL DEFAULT '',
  `numrow` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  UNIQUE KEY `alias` (`alias`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM ";

$data = array();
$data['view_type'] = 'view_listall';
$data['view_num'] = '30';

foreach ( $data as $config_name => $config_value )
{
    $sql_create_module[] = "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES('" . $lang . "', " . $db->dbescape( $module_name ) . ", " . $db->dbescape( $config_name ) . ", " . $db->dbescape( $config_value ) . ")";
}
?>