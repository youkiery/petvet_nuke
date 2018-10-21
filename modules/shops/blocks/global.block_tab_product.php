<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */
if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );
if ( ! function_exists( 'CurrencyConversion' ) )
{
	function CurrencyConversion ( $price, $currency_curent, $currency_convert, $block_config )
	{
		global $money_config, $module_config;
		$module = $block_config['module'];
		$pro_config = $module_config[$module];
		$str = number_format( $price, 0, '.', ' ' );
		if ( ! empty( $money_config ) )
		{
			if ( $currency_curent == $pro_config['money_unit'] )
			{
				$value = doubleval( $money_config[$currency_convert]['exchange'] );
				$price = doubleval( $price * $value );
				$str = number_format( $price, 0, '.', ' ' );
				$ss = "~";
			}
			elseif ( $currency_convert == $pro_config['money_unit'] )
			{
				$value = doubleval( $money_config[$currency_curent]['exchange'] );
				$price = doubleval( $price / $value );
				$str = number_format( $price, 0, '.', ' ' );
			}
		}
		$ss = ( $currency_curent == $currency_convert ) ? "" : "~";
		return $ss . $str;
	}
}
if ( !function_exists( 'show_tab_block') )
{
	function show_tab_block ( $module, $block_config, $xtpl, $block_id,$mod_file,$array_cat_shops, $tab )
	{
		global $db_config,$db,$module_info,$pro_config;	
		$sql = "SELECT  t1.id, t1.listcatid, t1." . NV_LANG_DATA . "_title, t1." . NV_LANG_DATA . "_alias, t1." . NV_LANG_DATA . "_hometext, t1.addtime,t1.homeimgthumb,t1.product_price,t1.product_discounts,t1.money_unit,t1.showprice FROM `" . $db_config['prefix'] . "_" . $module . "_rows` as t1 INNER JOIN `" . $db_config['prefix'] . "_" . $module . "_block` AS t2 ON t1.id = t2.id WHERE t2.bid= ".$block_id." AND t1.status= 1 AND  t1.publtime < " . NV_CURRENTTIME . " AND (t1.exptime=0 OR t1.exptime >" . NV_CURRENTTIME . ") ORDER BY t1.addtime DESC, t2.weight ASC LIMIT 0 , 5";
		$query = $db->sql_query( $sql );
		$i = 1;
		$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=";
		///////////////////////////////////////////////////////////
		while ( list( $id_i, $listcatid_i, $title_i, $alias_i, $hometext_i, $addtime_i, $homeimgthumb_i, $product_price_i, $product_discounts_i, $money_unit_i, $showprice_i ) = $db->sql_fetchrow( $query ) )
		{
			$thumb = explode( "|", $homeimgthumb_i );
			if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
			{
				$thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module . "/" . $thumb[0];
			}
			else
			{
                $thumb[0] = $homeimgthumb_i;
				// $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $mod_file . "/no-image.jpg";
			}
			$xtpl->assign( 'i', $i );
			$xtpl->assign( 'link', $link . $array_cat_shops[$listcatid_i]['alias'] . "/" . $alias_i . "-" . $id_i );
			$title_i = nv_clean60( $title_i, 20 );
			$xtpl->assign( 'title', $title_i );
			$xtpl->assign( 'hometext', $hometext_i );
			$xtpl->assign( 'src_img', $thumb[0] );
			$xtpl->assign( 'time', nv_date( 'd-m-Y h:i:s A', $addtime_i ) );
			if ( $pro_config['active_price'] == '1' && $showprice_i == '1' )
			{
				$product_price = CurrencyConversion( $product_price_i, $money_unit_i, $pro_config['money_unit'], $block_config );
				$xtpl->assign( 'product_price', $product_price );
				$xtpl->assign( 'discounts', $product_discounts_i );
				$xtpl->assign( 'money_unit', $pro_config['money_unit'] );
				if ( $product_discounts_i != 0 )
				{
					$price_product_discounts = $product_price_i - ( $product_price_i * ( $product_discounts_i / 100 ) );
					$xtpl->assign( 'product_discounts', CurrencyConversion( $price_product_discounts, $money_unit_i, $pro_config['money_unit'], $block_config ) );
					$xtpl->assign( 'class_money', 'discounts_money' );
					$xtpl->parse( 'main.'.$tab.'.discounts' );
				}
				else
				{
					$xtpl->assign( 'class_money', 'money' );
				}
				$xtpl->parse( 'main.'.$tab.'.price' );
			}
			$xtpl->parse( 'main.'.$tab );
			$i ++;
		}	
	}
}
if ( ! function_exists( 'nv_tab_product' ) )
{
    function nv_block_config_tab_product_blocks ( $module, $data_block, $lang_block )
    {
        global $db, $language_array, $db_config;
        $html = "";        
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['numrow'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";        
        $html .= "</tr>";
        $html .= "<tr>";        
        $html .= "  <td>" . $lang_block['perrow'] . "</td>";
        $html .= "  <td><input type=\"text\" name=\"config_perrow\" size=\"5\" value=\"" . $data_block['perrow'] . "\"/></td>";
        $html .= "</tr>";
        return $html;
    }
    function nv_block_config_tab_product_blocks_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();        
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        $return['config']['perrow'] = $nv_Request->get_int( 'config_perrow', 'post', 0 );
        return $return;
    }
    function nv_tab_product ( $block_config )
    {
        global $site_mods, $db_config, $db, $global_array_group, $global_array_cat, $module_name, $module_info, $nv_Request, $catid, $module_config;
        
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $array_group = $global_array_group;
        $pro_config = $module_config[$module];
        $array_cat_shops = $global_array_cat;
        
        $perrow= $block_config['perrow'];       
        
        include ( NV_ROOTDIR . "/modules/" . $mod_file . "/language/" . NV_LANG_DATA . ".php" );
        
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module . "/block_tabs_products.tpl" ) )
        {
            $block_theme = $module_info['template'];
        }
        else
        {
            $block_theme = "default";
        }
        
        if ( $module != $module_name )
        {
            $sql_cat = "SELECT catid, parentid, lev," . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, viewcat, numsubcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, inhome, " . NV_LANG_DATA . "_keywords, who_view, groups_view FROM `" . $db_config['prefix'] . "_" . $module . "_catalogs` ORDER BY `order` ASC";
            $result_cat = $db->sql_query( $sql_cat );
            while ( list( $catid_i, $parentid_i, $lev_i, $title_i, $alias_i, $viewcat_i, $numsubcat_i, $subcatid_i, $numlinks_i, $del_cache_time_i, $description_i, $inhome_i, $keywords_i, $who_view_i, $groups_view_i ) = $db->sql_fetchrow( $result_cat ) )
            {
                $link_i = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $alias_i . "";
                $array_cat_shops[$catid_i] = array( 
                    "catid" => $catid_i, "parentid" => $parentid_i, "title" => $title_i, "alias" => $alias_i, "link" => $link_i, "viewcat" => $viewcat_i, "numsubcat" => $numsubcat_i, "subcatid" => $subcatid_i, "numlinks" => $numlinks_i, "description" => $description_i, "inhome" => $inhome_i, "keywords" => $keywords_i, "who_view" => $who_view_i, "groups_view" => $groups_view_i, 'lev' => $lev_i 
                );
            }
        }
        
				$xtpl = new XTemplate( "block_tabs_products.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module );
        $xtpl->assign( 'LANG', $lang_module );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'TEMPLATE', $module_info['template'] );       
        
		show_tab_block ( $module, $block_config, $xtpl, '2' ,$mod_file,$array_cat_shops, "tab1" ) ;
		show_tab_block ( $module, $block_config, $xtpl, '3' ,$mod_file,$array_cat_shops, "tab2" ) ;
        show_tab_block ( $module, $block_config, $xtpl, '4' ,$mod_file,$array_cat_shops, "tab3" ) ;
		show_tab_block ( $module, $block_config, $xtpl, '5' ,$mod_file,$array_cat_shops, "tab4" ) ;
		show_tab_block ( $module, $block_config, $xtpl, '6' ,$mod_file,$array_cat_shops, "tab5" ) ;
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $global_array_group, $module_name;
    $content = nv_tab_product( $block_config );
}
?>