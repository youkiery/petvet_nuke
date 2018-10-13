<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_keywords' ) )
{

    function nv_block_config_keywords_blocks ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $db_config;
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['numrow'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
        $html .= "</tr>";
        return $html;
    }

    function nv_block_config_keywords_blocks_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        return $return;
    }

    function nv_keywords ( $block_config )
    {
        global $site_mods, $db_config, $db, $global_array_group, $module_name, $module_info, $catid,$array_op,$global_array_cat, $my_head;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
		include (NV_ROOTDIR . "/modules/" . $mod_file . "/language/" . NV_LANG_DATA . ".php");
		$array_cat_shops = $global_array_cat;

        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $mod_file . "/block.keywords.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
        if ( $module != $module_name )
        {
            $sql_cat = "SELECT catid, parentid, lev," . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, viewcat, numsubcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, inhome, " . NV_LANG_DATA . "_keywords, who_view, groups_view FROM `" . $db_config['prefix'] . "_" . $mod_data . "_catalogs` ORDER BY `order` ASC";
            $result = $db->sql_query( $sql_cat );
            while ( list( $catid_i, $parentid_i, $lev_i, $title_i, $alias_i, $viewcat_i, $numsubcat_i, $subcatid_i, $numlinks_i, $del_cache_time_i, $description_i, $inhome_i, $keywords_i, $who_view_i, $groups_view_i ) = $db->sql_fetchrow( $result ) )
            {
                $link_i = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $alias_i . "";
                $array_cat_shops[$catid_i] = array( 
                    "catid" => $catid_i, "parentid" => $parentid_i, "title" => $title_i, "alias" => $alias_i, "link" => $link_i, "viewcat" => $viewcat_i, "numsubcat" => $numsubcat_i, "subcatid" => $subcatid_i, "numlinks" => $numlinks_i, "description" => $description_i, "inhome" => $inhome_i, "keywords" => $keywords_i, "who_view" => $who_view_i, "groups_view" => $groups_view_i, 'lev' => $lev_i 
                );
            }
            if ( file_exists( NV_ROOTDIR . "/themes/" . $block_theme . "/css/" . $mod_file . ".css" ) )
            {
                $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/' . $mod_file . '.css' . '" type="text/css" />';
            }
        }
		$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=";
        $xtpl = new XTemplate( "block.keywords.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
		$xtpl->assign( 'LANG', $lang_module );
		$sql = "SELECT id, listcatid, " . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, " . NV_LANG_DATA . "_hometext, addtime,homeimgthumb,product_price,product_discounts,money_unit,showprice, " . NV_LANG_DATA . "_keywords FROM `" . $db_config['prefix'] . "_" . $mod_data . "_rows` ORDER BY RAND() LIMIT 0 , " . $block_config['numrow'];
		$rs = $db -> sql_query($sql);
		while ( list( $id_i, $listcatid_i, $title_i, $alias_i, $hometext_i, $addtime_i, $homeimgthumb_i, $product_price_i, $product_discounts_i, $money_unit_i, $showprice_i, $keywords_i ) = $db->sql_fetchrow( $rs ) ) {
			$xtpl->assign( 'link', $link . $array_cat_shops[$listcatid_i]['alias'] . "/" . $alias_i . "-" . $id_i );
			$xtpl->assign( 'keywords', $keywords_i );
			$xtpl -> parse('main.loop');
		}
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $global_array_group, $module_name;
    $content = nv_keywords( $block_config );
}

?>