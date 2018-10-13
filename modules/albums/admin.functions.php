<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if(!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
{
	die('Stop!!!');
}
$submenu['album'] = $lang_module['add_albums'];
$submenu['imglist'] = $lang_module['imglist'];
$submenu['config'] = $lang_module['config'];
$allow_func = array('main','alias','album','image','imglist','config');

$array_who_view = array( 
    0 => $lang_global['who_view0'], 1 => $lang_global['who_view1'], 2 => $lang_global['who_view2'], 3 => $lang_global['who_view3'] 
);
define( 'NV_IS_FILE_ADMIN', true );

function drawselect_number ( $select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    for ( $i = $number_start; $i <= $number_end; $i ++ )
    {
        $select = ( $i == $number_curent ) ? 'selected="selected"' : '';
        $html .= '<option value="' . $i . '" ' . $select . '>' . $i . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function drawselect_status ( $select_name = "", $array_control_value, $value_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    foreach ( $array_control_value as $val => $title )
    {
        $select = ( $val == $value_curent ) ? "selected=\"selected\"" : "";
        $html .= '<option value="' . $val . '" ' . $select . '>' . $title . '</option>';
    }
    $html .= '</select>';
    return $html;
}
function nv_fix_img_albums ( $aid = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT count(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_imgs` WHERE `aid`=" . $aid . " AND status=1";
    $result = $db->sql_query( $query );
    list($num) = $db->sql_fetchrow( $result );
    $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `numitems` =  " . $db->dbescape( $num ) . " WHERE `id` =" . $aid . "";
    $result = $db->sql_query( $query );
}

?>