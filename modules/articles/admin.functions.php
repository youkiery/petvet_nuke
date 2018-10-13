<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['main'] = $lang_module['main'];
$submenu['content'] = $lang_module['content'];
$submenu['blockcat'] = $lang_module['block'];
$submenu['comment'] = $lang_module['comment'];
$submenu['config'] = $lang_module['config'];

$allow_func = array( 'main', 'config','action','content','alias','comment','del_comment',
			'edit_comment','active_comment','block','blockcat','del_block_cat',
			'list_block_cat','chang_block_cat','change_block','list_block'
);

define( 'NV_IS_FILE_ADMIN', true );

///////////////////////
function drawselect_number ( $select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "" )
{ 
    $html = "<select name=\"" . $select_name . "\" onchange=\"" . $func_onchange . "\">";
    for ( $i = $number_start; $i < $number_end; $i ++ )
    {
        $select = ( $i == $number_curent ) ? "selected=\"selected\"" : "";
        $html .= "<option value=\"" . $i . "\"" . $select . ">" . $i . "</option>";
    }
    $html .= "</select>";
    return $html;
}
function drawselect_yesno ( $select_name = "", $status , $func_onchange = "")
{ 
    global $lang_module;
    $slelect_yes = ( $status == 1 ) ? "selected=\"selected\"" : "";
    $slelect_no = ( $status == 0 ) ? "selected=\"selected\"" : "";
	$html = "<select name=\"" . $select_name . "\" onchange=\"" . $func_onchange . "\">";
    $html .= "<option value=\"1\"" . $slelect_yes . ">" . $lang_module['status_yes'] . "</option>";
    $html .= "<option value=\"0\"" . $slelect_no . ">" . $lang_module['status_no'] . "</option>";
    $html .= "</select>";
    return $html;
}
function nv_show_block_list ( $bid )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $contents = "";    
    $sql = "SELECT t1.id, t1.title, t1.alias, t2.weight FROM `" . NV_PREFIXLANG . "_" . $module_data . "` as t1 INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_block` AS t2 ON t1.id = t2.id WHERE t2.bid= " . $bid . " AND t1.inhome='1' ORDER BY t2.weight ASC";
    $result = $db->sql_query( $sql );
    $num = $db->sql_numrows( $result );
    if ( $num > 0 )
    {
        $contents = "<form name=\"block_list\" action=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;bid=" . $bid . "\" method=\"get\">";
        $contents .= "<table class=\"tab1\">\n";
        $contents .= "<thead>\n";
        $contents .= "<tr>\n";
        $contents .= "<td align=\"center\"><input name=\"check_all[]\" type=\"checkbox\" value=\"yes\" onclick=\"nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);\" /></td>\n";
        $contents .= "<td style=\"width:60px;\">" . $lang_module['weight'] . "</td>\n";
        $contents .= "<td>" . $lang_module['name'] . "</td>\n";
        $contents .= "<td></td>\n";
        $contents .= "</tr>\n";
        $contents .= "</thead>\n";
        $contents .= "<tfoot>\n";
        $contents .= "<tr align=\"left\">\n";
        $contents .= "<td colspan=\"5\"><input type=\"button\" onclick=\"nv_del_block_list(this.form, " . $bid . ")\" value=\"" . $lang_module['delete_from_block'] . "\">\n";
        $contents .= "</td>\n";
        $contents .= "</tr>\n";
        $contents .= "</tfoot>\n";
        $a = 0;
        while ( list( $id, $title, $alias, $weight ) = $db->sql_fetchrow( $result ) )
        {
            $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $alias . "-" . $id;
            $class = ( $a % 2 ) ? " class=\"second\"" : "";
            $contents .= "<tbody" . $class . ">\n";
            $contents .= "<tr>\n";
            $contents .= "<td align=\"center\"><input type=\"checkbox\" onclick=\"nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);\" value=\"" . $id . "\" name=\"idcheck[]\" /></td>\n";
            $contents .= "<td align=\"center\"><select id=\"id_weight_" . $id . "\" onchange=\"nv_chang_block(" . $bid . ", " . $id . ",'weight');\">\n";
            for ( $i = 1; $i <= $num; $i ++ )
            {
                $contents .= "<option value=\"" . $i . "\"" . ( $i == $weight ? " selected=\"selected\"" : "" ) . ">" . $i . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"left\"><a target=\"_blank\" href=\"" . $link . "\">" . $title . "</a></td>\n";
            $contents .= "<td align=\"center\">\n";
            $contents .= "<span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $id . "\">" . $lang_global['edit'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_chang_block(" . $bid . ", " . $id . ",'delete')\">" . $lang_module['delete_from_block'] . "</a></span>\n";
            $contents .= "</td>\n";
            $contents .= "</tr>\n";
            $contents .= "</tbody>\n";
            $a ++;
        }
        $contents .= "</table>\n";
        $contents .= "</form>\n";
        $db->sql_freeresult();
    }
    else
    {
        $contents = "&nbsp;";
    }
    return $contents;
}
function nv_news_fix_block ( $bid, $repairtable = true )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $bid = intval( $bid );
    if ( $bid > 0 )
    {
        $query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_block` where `bid`='" . $bid . "' ORDER BY `weight` ASC";
        $result = $db->sql_query( $query );
        $weight = 0;
        while ( $row = $db->sql_fetchrow( $result ) )
        {
            $weight ++;
            if ( $weight <= 100 )
            {
                $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_block` SET `weight`=" . $weight . " WHERE `bid`='" . $bid . "' AND `id`=" . intval( $row['id'] );
            }
            else
            {
                $sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_block` WHERE `bid`='" . $bid . "' AND `id`=" . intval( $row['id'] );
            }
            $db->sql_query( $sql );
        }
        $db->sql_freeresult();
        if ( $repairtable )
        {
            $db->sql_query( "REPAIR TABLE `" . NV_PREFIXLANG . "_" . $module_data . "_block`" );
            $db->sql_query( "OPTIMIZE TABLE `" . NV_PREFIXLANG . "_" . $module_data . "_block`" );
        }
    }
}
function nv_show_block_cat_list ( )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_block_cat` ORDER BY `weight` ASC";
    $result = $db->sql_query( $sql );
    $num = $db->sql_numrows( $result );
    if ( $num > 0 )
    {
        $contents = "<table class=\"tab1\">\n";
        $contents .= "<thead>\n";
        $contents .= "<tr>\n";
        $contents .= "<td style=\"width:50px;\">" . $lang_module['weight'] . "</td>\n";
        $contents .= "<td align=\"center\" style=\"width:40px;\">ID</td>\n";
        $contents .= "<td>" . $lang_module['name'] . "</td>\n";
        $contents .= "<td align=\"center\">" . $lang_module['adddefaultblock'] . "</td>\n";
        $contents .= "<td align=\"center\" style=\"width:90px;\">" . $lang_module['numlinks'] . "</td>\n";
        $contents .= "<td style=\"width:100px;\"></td>\n";
        $contents .= "</tr>\n";
        $contents .= "</thead>\n";
        $a = 0;
        $array_adddefault = array( 
            $lang_global['no'], $lang_global['yes'] 
        );
        while ( $row = $db->sql_fetchrow( $result ) )
        {
            $class = ( $a % 2 ) ? " class=\"second\"" : "";
            $contents .= "<tbody" . $class . ">\n";
            $contents .= "<tr>\n";
            $contents .= "<td align=\"center\"><select id=\"id_weight_" . $row['bid'] . "\" onchange=\"nv_chang_block_cat('" . $row['bid'] . "','weight');\">\n";
            for ( $i = 1; $i <= $num; $i ++ )
            {
                $contents .= "<option value=\"" . $i . "\"" . ( $i == $row['weight'] ? " selected=\"selected\"" : "" ) . ">" . $i . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"center\"><b>" . $row['bid'] . "</b></td>\n";
            list( $numnews ) = $db->sql_fetchrow( $db->sql_query( "SELECT count(*)  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_block` where `bid`=" . $row['bid'] . "" ) );
            if ( $numnews )
            {
                $contents .= "<td><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=block&amp;bid=" . $row['bid'] . "\">" . $row['title'] . " ($numnews " . $lang_module['topic_num_news'] . ")</a>";
            }
            else
            {
                $contents .= "<td><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=block&amp;bid=" . $row['bid'] . "\">" . $row['title'] . "</a>";
            }
            $contents .= " </td>\n";
            $contents .= "<td align=\"center\"><select id=\"id_adddefault_" . $row['bid'] . "\" onchange=\"nv_chang_block_cat('" . $row['bid'] . "','adddefault');\">\n";
            foreach ( $array_adddefault as $key => $val )
            {
                $contents .= "<option value=\"" . $key . "\"" . ( $key == $row['adddefault'] ? " selected=\"selected\"" : "" ) . ">" . $val . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"center\"><select id=\"id_numlinks_" . $row['bid'] . "\" onchange=\"nv_chang_block_cat('" . $row['bid'] . "','numlinks');\">\n";
            for ( $i = 1; $i <= 30; $i ++ )
            {
                $contents .= "<option value=\"" . $i . "\"" . ( $i == $row['number'] ? " selected=\"selected\"" : "" ) . ">" . $i . "</option>\n";
            }
            $contents .= "</select></td>\n";
            $contents .= "<td align=\"center\"><span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;bid=" . $row['bid'] . "#edit\">" . $lang_global['edit'] . "</a></span>\n";
            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_del_block_cat(" . $row['bid'] . ")\">" . $lang_global['delete'] . "</a></span></td>\n";
            $contents .= "</tr>\n";
            $contents .= "</tbody>\n";
            $a ++;
        }
        $contents .= "</table>\n";
    }
    else
    {
        $contents = "&nbsp;";
    }
    $db->sql_freeresult();
    return $contents;
}
?>