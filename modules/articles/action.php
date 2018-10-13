<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-10-2010 20:59
 */

if ( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_comment`";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `homefileimg` varchar(255) NOT NULL,
  `hometext` text NOT NULL,
  `bodytext` mediumtext NOT NULL,
  `keywords` mediumtext NOT NULL,
  `author` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `link_active` smallint(2) NOT NULL DEFAULT '0',
  `link_redirect` text NOT NULL,
  `weight` smallint(4) NOT NULL DEFAULT '0',
  `admin_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `edit_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment` int(8) NOT NULL DEFAULT '0',
  `view` int(8) NOT NULL DEFAULT '0',
  `inhome` tinyint(2) NOT NULL DEFAULT '0',
  `allow_comment` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block` (
  `bid` int(11) unsigned NOT NULL,
  `id` int(11) unsigned NOT NULL,
  `weight` int(11) unsigned NOT NULL,
  UNIQUE KEY `bid` (`bid`,`id`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat` (
    `bid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `adddefault` tinyint(4) NOT NULL DEFAULT '0',
  `number` mediumint(4) NOT NULL DEFAULT '10',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `weight` smallint(4) NOT NULL DEFAULT '0',
  `keywords` mediumtext NOT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `edit_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL DEFAULT '0',
  `post_time` int(11) NOT NULL DEFAULT '0',
  `post_name` varchar(200) NOT NULL,
  `post_email` varchar(100) NOT NULL,
  `post_ip` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM ";

$data = array();
$data['home_view'] = 'view_home_all';
$data['home_view_type'] = 'view_home_gird';
$data['order'] = 'dateup';
$data['homewidth'] = '100';
$data['homeheight'] = '100';
$data['per_page'] = 30;
$data['per_row'] = 2;
$data['active_hometext'] = 1;
$data['active_comment'] = 1;
$data['comment_auto'] = 1;
foreach ( $data as $config_name => $config_value )
{
    $sql_create_module[] = "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES('" . $lang . "', " . $db->dbescape( $module_name ) . ", " . $db->dbescape( $config_name ) . ", " . $db->dbescape( $config_value ) . ")";
}

?>