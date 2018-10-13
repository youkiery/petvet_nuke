<?php

/**

** @Project: NUKEVIET SUPPORT ONLINE

** @Author: Viet Group (vietgroup.biz@gmail.com)

** @Copyright: VIET GROUP

** @Craetdate: 19.08.2011

** @Website: http://vietgroup.biz

*/



if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );



$submenu ['group_main'] = $lang_module ['support16'];

$submenu ['group_content'] = $lang_module ['support17'];

$submenu ['content'] = $lang_module ['support10'];



$allow_func = array( 

    'main', 'list', 'content', 'del', 'del_group', 'group_main', 'change_weight', 'group_content', 'change_weightg', 'list_group'

);

function nv_fix_weight_group($gid = 0) {

	global $db, $db_config, $module_data;

	$sqlg = "SELECT `id` FROM `". NV_PREFIXLANG ."_". $module_data."_group` ORDER BY `weight` ASC";

	$resultg = $db->sql_query($sqlg);

	$array_weight_g = array();

	while ($rowg = $db->sql_fetchrow($resultg)){

		$array_weight_g[] = $rowg['id'];

	}

	$db->sql_freeresult();

	$weight = 0;

	foreach($array_weight_g as $groupid){

		$gid ++;

		$weight ++;

		$sql = "UPDATE `". NV_PREFIXLANG ."_". $module_data ."_group` SET `weight` = ". $weight ." WHERE `id` = ". $groupid ."";

		$db->sql_query($sql);

	}

	return $gid;

}

function nv_fix_weight_sp($spid = 0) {

	global $db, $db_config, $module_data;

	$sqlsp = "SELECT `id` FROM `". NV_PREFIXLANG ."_". $module_data."` ORDER BY `weight` ASC";

	$resultsp = $db->sql_query($sqlsp);

	$array_weight = array();

	while ($rowsp = $db->sql_fetchrow($resultsp)){

		$array_weight[] = $rowsp['id'];

	}

	$db->sql_freeresult();

	$weight = 0;

	foreach($array_weight as $vgtid){

		$spid ++;

		$weight ++;

		$sql = "UPDATE `". NV_PREFIXLANG ."_". $module_data ."` SET `weight` = ". $weight ." WHERE `id` = ". $vgtid ."";

		$db->sql_query($sql);

	}

	return $spid;

}

function nv_show_list ()

{

    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data;

    $contents = "";

    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` ORDER BY `weight` ASC";

    $result = $db->sql_query( $sql );

    $num = $db->sql_numrows( $result );

    if ( $num > 0 )

    {

        $contents .= "<table class=\"tab1\">\n";

        $contents .= "<thead>\n";

        $contents .= "<tr>\n";

        $contents .= "<td>" . $lang_module ['support02'] . "</td>\n";

		$contents .= "<td>" . $lang_module ['support03'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['support04'] . "</td>\n";

		$contents .= "<td align=\"center\">" . $lang_module['support07'] . "</td>\n";

		$contents .= "<td align=\"center\">" . $lang_module['support08'] . "</td>\n";

		$contents .= "<td align=\"center\">" . $lang_module['support09'] . "</td>\n";

		$contents .= "</tr>\n";

        $contents .= "</thead>\n";

        $a = 0;

        while ( $row = $db->sql_fetchrow( $result ) )

        {

            $class = ( $a % 2 ) ? " class=\"second\"" : "";

            $contents .= "<tbody" . $class . ">\n";

            $contents .= "<tr>\n";

            $contents .= "<td><select id=\"change_weight_" . $row ['id'] . "\" onchange=\"nv_chang_weight('" . $row ['id'] . "');\">\n";

            for ( $i = 1; $i <= $num; $i ++ )

            {

                $contents .= "<option value=\"" . $i . "\"" . ( $i == $row ['weight'] ? " selected=\"selected\"" : "" ) . ">" . $i . "</option>\n";

            }

            $contents .= "</select></td>\n";

			$contents .= "<td>" . $row ['title'] . "</td>\n";

			$idgroup=$row['idgroup'];

			$sqls = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` WHERE `id` ='$idgroup'";

    		$results = $db->sql_query( $sqls );

			$rows = $db->sql_fetchrow( $results );

            $contents .= "<td>" . $rows ['title'] . "</td>\n";

			$contents .= "<td  align=\"center\">" . $row['yahoo_item'] . "</td>\n";

			$contents .= "<td  align=\"center\"><a href=\"" . $row['yahoo_item'] . "\"><p align=\"center\"><img border=\"0\" alt=\"\" src=\"" . $row['yahoo_type'] . "\" width=\"18\" height=\"18\"/></p></a></td>\n";

            $contents .= "<td><span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content&amp;id=" . $row ['id'] . "\">" . $lang_global ['edit'] . "</a></span>\n";

            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_module_del(" . $row ['id'] . ")\">" . $lang_global ['delete'] . "</a></span></td>\n";

            $contents .= "</tr>\n";

            $contents .= "</tbody>\n";

            $a ++;

        }

		$contents .= "<thead>\n";

        $contents .= "<tr>\n";

		$contents .= "<td colspan=\"8\" align=\"center\"><span class=\"add_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content\">" . $lang_module['support10'] . "</a></span></td>\n";

		$contents .= "</tr>\n";

        $contents .= "</thead>\n";



        $contents .= "</table>\n";

    }

    else

    {

        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content" );

        die();

    }

    return $contents;

}

function nv_show_list_group ()

{

    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data;

    $contents = "";

    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` ORDER BY `weight` ASC";

    $result = $db->sql_query( $sql );

    $num = $db->sql_numrows( $result );

    if ( $num > 0 )

    {

        $contents .= "<table class=\"tab1\">\n";

        $contents .= "<thead>\n";

        $contents .= "<tr>\n";

		$contents .= "<td>" . $lang_module ['support02'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['support04'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['add'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['phone'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['fax'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['support06'] . "</td>\n";

        $contents .= "<td>" . $lang_module ['supportweb'] . "</td>\n";

		$contents .= "<td align=\"center\">" . $lang_module['support09'] . "</td>\n";

		$contents .= "</tr>\n";

        $contents .= "</thead>\n";

        $a = 0;

        while ( $row = $db->sql_fetchrow( $result ) )

        {

            $class = ( $a % 2 ) ? " class=\"second\"" : "";

            $contents .= "<tbody" . $class . ">\n";

            $contents .= "<tr>\n";

			$contents .= "<tr>\n";

            $contents .= "<td><select id=\"change_weightg_" . $row ['id'] . "\" onchange=\"nv_chang_weightg('" . $row ['id'] . "');\">\n";

            for ( $i = 1; $i <= $num; $i ++ )

            {

                $contents .= "<option value=\"" . $i . "\"" . ( $i == $row ['weight'] ? " selected=\"selected\"" : "" ) . ">" . $i . "</option>\n";

            }

            $contents .= "</select></td>\n";

            $contents .= "<td>" . $row ['title'] . "</td>\n";

            $contents .= "<td>" . $row ['add'] . "</td>\n";

            $contents .= "<td>" . $row ['phone'] . "</td>\n";

            $contents .= "<td>" . $row ['fax'] . "</td>\n";

            $contents .= "<td>" . $row ['email'] . "</td>\n";

            $contents .= "<td>" . $row ['web'] . "</td>\n";

            $contents .= "<td  align=\"center\"><span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content&amp;id=" . $row ['id'] . "\">" . $lang_global ['edit'] . "</a></span>\n";

            $contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_module_del_group(" . $row ['id'] . ")\">" . $lang_global ['delete'] . "</a></span></td>\n";

            $contents .= "</tr>\n";

            $contents .= "</tbody>\n";

            $a ++;

        }

		$contents .= "<thead>\n";

        $contents .= "<tr>\n";

        $contents .= "<td colspan=\"8\" align=\"center\"><span class=\"add_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content\">" . $lang_module['support17'] . "</a></span></td>\n";

		$contents .= "</tr>\n";

        $contents .= "</thead>\n";



        $contents .= "</table>\n";

    }

    else

    {

        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content" );

        die();

    }

    return $contents;

}



define( 'NV_IS_FILE_ADMIN', true );



?>