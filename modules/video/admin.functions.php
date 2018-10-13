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
$submenu['content'] = $lang_module['add_content'];
$submenu['cat'] = $lang_module['cat'];
$submenu['config'] = $lang_module['config'];
$allow_func = array('main','alias','cat','cat_action','content','config');

$array_who_view = array( 
    0 => $lang_global['who_view0'], 1 => $lang_global['who_view1'], 2 => $lang_global['who_view2'], 3 => $lang_global['who_view3'] 
);
define( 'NV_IS_FILE_ADMIN', true );

global $global_array_cat;
$global_array_cat = array();
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat` ORDER BY `order` ASC";
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result, 2 ) )
{
    $global_array_cat[$row['catid']] = $row;
}
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
function nv_fix_cat_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT `catid`, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $array_cat_order = array();
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $array_cat_order[] = $row['catid'];
    }
    $db->sql_freeresult();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_cat_order as $catid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_cat` SET `weight`=" . $weight . ", `order`=" . $order . ", `lev`='" . $lev . "' WHERE `catid`=" . intval( $catid_i );
        $db->sql_query( $sql );
        $order = nv_fix_cat_order( $catid_i, $order, $lev );
    }
    $numsubcat = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_cat` SET `numsubcat`=" . $numsubcat;
        if ( $numsubcat == 0 )
        {
            $sql .= ",`subcatid`=''";
        }
        else
        {
            $sql .= ",`subcatid`='" . implode( ",", $array_cat_order ) . "'";
        }
        $sql .= " WHERE `catid`=" . intval( $parentid );
        $db->sql_query( $sql );
    }
    return $order;
}

?>