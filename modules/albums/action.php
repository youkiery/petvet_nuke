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
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_imgs`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_coms`";

$sql_create_module = $sql_drop_module;

// images of albums
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_imgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `alias` varchar(255) NOT NULL,
  `description` text,
  `img` varchar(255) NOT NULL,
  `otherpath` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `edittime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM";

// albums
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '',
  `inhome` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `keywords` mediumtext NOT NULL,
  `admins` mediumtext NOT NULL,
  `view` int(8) unsigned NOT NULL DEFAULT '0',
  `comment` int(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0',
  `who_view` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `groups_view` varchar(255) NOT NULL DEFAULT '',
  `numitems` int(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM ";
// commnent
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_coms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) NOT NULL DEFAULT '0',
  `name` text,
  `email` varchar(255) NOT NULL,
  `content` text,
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM";

$data = array();
$data['view_type'] = 'view_listimg';
$data['view_album'] = 'view_listclick';
$data['view_num'] = '30';

foreach ( $data as $config_name => $config_value )
{
    $sql_create_module[] = "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES('" . $lang . "', " . $db->dbescape( $module_name ) . ", " . $db->dbescape( $config_name ) . ", " . $db->dbescape( $config_value ) . ")";
}
?>