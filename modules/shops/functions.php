<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 0:51
 */
if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );
define( 'NV_IS_MOD_SHOPS', true );
require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php" );
global $global_array_cat, $global_array_group,$global_array_color,$global_array_source,$global_array_block_cat;
$global_array_cat = array();
$array_a = array();
$catid = 0;
$parentid = 0;
$check = 0;
$relates = 0;
$set_viewcat = "";
$alias_cat_url = isset( $array_op[0] ) ? $array_op[0] : "";
$arr_cat_title = array();
//die($alias_cat_url."---");
$sql = "SELECT catid, image, icon, parentid, lev," . NV_LANG_DATA . "_title as title," . NV_LANG_DATA . "_alias as alias, viewcat, numsubcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description as description, inhome, " . NV_LANG_DATA . "_keywords as keywords, who_view, groups_view FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` ORDER BY `order` ASC";

$list = nv_db_cache( $sql, 'catid', $module_name );
foreach ( $list as $l )
{
	$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'] . "";
    $global_array_cat[$l['catid']] = $l;
    if ( $alias_cat_url == $l['alias'] )
    {
        $catid = $l['catid'];
        $parentid = $l['parentid'];
    }
}
//source
$sql = "SELECT sourceid, link, logo," . NV_LANG_DATA . "_title as title," . NV_LANG_DATA . "_alias as alias FROM `" . $db_config['prefix'] . "_" . $module_data . "_sources` ORDER BY `weight` ASC";

$list = nv_db_cache( $sql, 'sourceid', $module_name );
foreach ( $list as $l )
{
	$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'] . "";
    $global_array_source[$l['sourceid']] = $l;
    if ( $alias_cat_url == $l['alias'] )
    {
        $catid = $l['sourceid'];
		$check = 1;
    }
}
//block
$sql = "SELECT bid, " . NV_LANG_DATA . "_title as title," . NV_LANG_DATA . "_alias as alias FROM `" . $db_config['prefix'] . "_" . $module_data . "_block_cat` ORDER BY `weight` ASC";

$list = nv_db_cache( $sql, 'bid', $module_name );
foreach ( $list as $l )
{
	$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'] . "";
    $global_array_block_cat[$l['bid']] = $l;
    if ( $alias_cat_url == $l['alias'] )
    {
        $catid = $l['bid'];
		$relates = 1;
    }
}
//color
$sql = "SELECT cid, title FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` ORDER BY `cid` ASC";

$list = nv_db_cache( $sql, 'cid', $module_name );
foreach ( $list as $l )
{
    $global_array_color[$l['cid']] = $l;

}

/*group*/
$global_array_group = array();
$sql = "SELECT groupid, parentid, image, cateid, lev," . NV_LANG_DATA . "_title as title, " . NV_LANG_DATA . "_alias as alias, viewgroup, numsubgroup, subgroupid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, inhome, " . NV_LANG_DATA . "_keywords, who_view, groups_view,numpro FROM `" . $db_config['prefix'] . "_" . $module_data . "_group` ORDER BY `order` ASC";

$list = nv_db_cache( $sql, 'groupid', $module_name );
foreach ( $list as $l )
{
	$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=group/" . $l['alias'] . "-" . $l['groupid'];
    $global_array_group[$groupid_i] = $l;
}

/*end group*/
$page = 0;
$per_page = $pro_config['per_page'];
$count_op = count( $array_op );
if ( ! empty( $array_op ) and $op == "main" )
{
    if ( $catid == 0 )
    {
        $contents = $lang_module['nocatpage'] . $array_op[0];
        if ( ! empty( $array_op[1] ) )
        {
            if ( substr( $array_op[1], 0, 5 ) == "page-" )
            {
                $page = intval( substr( $array_op[1], 5 ) );
            }
        }
    }
    else
    {
        $op = "main";
        if ( $count_op == 1 or substr( $array_op[1], 0, 5 ) == "page-" )
        {
            $op = "viewcat";
            if ( $count_op > 1 )
            {
                //$set_viewcat = "viewcat_page_new";
                $page = intval( substr( $array_op[1], 5 ) );
            }
        }
        elseif ( $count_op == 2 )
        {
            $array_page = explode( "-", $array_op[1] );
            $id = intval( end( $array_page ) );
            $number = strlen( $id ) + 1;
            $alias_url = substr( $array_op[1], 0, - $number );
            if ( $id > 0 and $alias_url != "" )
            {
                $op = "detail";
            }
        }
        $parentid = $catid;
        while ( $parentid > 0 )
        {
            $array_cat_i = $global_array_cat[$parentid];
            $array_mod_title[] = array( 
                'catid' => $parentid, 'title' => $array_cat_i['title'], 'link' => $array_cat_i['link'] 
            );
            $parentid = $array_cat_i['parentid'];
        }
        sort( $array_mod_title, SORT_NUMERIC );
    }
}
$sort_id = $nv_Request->get_int( 'sort', 'get,post', 0 );
if ( $sort_id > 0 && $page == 0 )
$page = $nv_Request->get_int( 'page', 'get', 0 );
function GetCatidInParent ( $catid )
{
    global $global_array_cat;
    $array_cat[] = $catid;
    $subcatid = explode( ",", $global_array_cat[$catid]['subcatid'] );
    if ( ! empty( $subcatid ) )
    {
        foreach ( $subcatid as $id )
        {
            if ( $id > 0 )
            {
                if ( $global_array_cat[$id]['numsubcat'] == 0 )
                {
                    $array_cat[] = $id;
                }
                else
                {
                    $array_cat_temp = GetCatidInParent( $id );
                    foreach ( $array_cat_temp as $catid_i )
                    {
                        $array_cat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique( $array_cat );
}
function GetDataIn ( $result, $catid )
{
    global $global_array_cat, $module_name, $db, $link, $module_info;
	$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

    $data_content = array();
    $data = array();
    while ( list( $id, $listcatid, $publtime, $title, $alias, $hometext, $address, $homeimgalt, $homeimgthumb, $product_price, $hitstotal, $product_discounts, $money_unit, $showprice, $homeimgfile ) = $db->sql_fetchrow( $result ) )
    {
        $thumb = explode( "|", $homeimgthumb );
		$homeimgfile = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/".$homeimgfile;
        if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
        {
            $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
        }
        else
        {
                $thumb[0] = $homeimgthumb;
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_name . "/no-image.jpg";
        }
        $data[] = array( 
            "id" => $id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "hometext" => $hometext, "address" => $address, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "hitstotal" => $hitstotal, "product_discounts" => $product_discounts, "money_unit" => $money_unit, "showprice" => $showprice, "link_pro" => $link . $global_array_cat[$listcatid]['alias'] . "/" . $alias . "-" . $id, "link_order" => $link . "setcart&amp;id=" . $id , "homeimgfile"=>$homeimgfile
        );
    }
    $data_content['id'] = $catid;
    $data_content['title'] = $global_array_cat[$catid]['title'];
    $data_content['data'] = $data;
    $data_content['alias'] = $global_array_cat[$catid]['alias'];
    return $data_content;
}
function GetDataInGroup ( $result, $groupid )
{
    global $global_array_group, $module_name, $db, $link, $module_info, $global_array_cat;
    $data_content = array();
    $data = array();
    while ( list( $id, $listcatid, $publtime, $title, $alias, $hometext, $address, $homeimgalt, $homeimgthumb, $product_price, $hitstotal, $product_discounts, $money_unit, $showprice ) = $db->sql_fetchrow( $result ) )
    {
        $thumb = explode( "|", $homeimgthumb );
        if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
        {
            $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
        }
        else
        {
                $thumb[0] = $homeimgthumb;
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_name . "/no-image.jpg";
        }
        $data[] = array( 
            "id" => $id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "hometext" => $hometext, "address" => $address, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "hitstotal" => $hitstotal, "product_discounts" => $product_discounts, "money_unit" => $money_unit, "showprice" => $showprice, "link_pro" => $link . $global_array_cat[$listcatid]['alias'] . "/" . $alias . "-" . $id, "link_order" => $link . "setcart&amp;id=" . $id 
        );
    }
    $data_content['id'] = $groupid;
    $data_content['title'] = $global_array_group[$groupid]['title'];
    $data_content['data'] = $data;
    $data_content['alias'] = $global_array_group[$groupid]['alias'];
    return $data_content;
}
function FormatNumber ( $number, $decimals = 0, $thousand_separator = '&nbsp;', $decimal_point = '.' )
{
    $str = number_format( $number, 0, ',', '.' );
    return $str;
}
//eg : echo CurrencyConversion ( 100000, 'USD', 'VND' );
/*return string money eg: 100 000 000*/
function CurrencyConversion ( $price, $currency_curent, $currency_convert )
{
    global $money_config, $pro_config; //die($price." ");
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
//eg : echo CurrencyConversion ( 100000, 'USD', 'VND' );
/*return double money eg: 100000000 */
function CurrencyConversionToNumber ( $price, $currency_curent, $currency_convert )
{
    global $money_config, $pro_config;
    if ( ! empty( $money_config ) )
    {
        if ( $currency_curent == $pro_config['money_unit'] )
        {
            $value = doubleval( $money_config[$currency_convert]['exchange'] );
            $price = doubleval( $price * $value );
        }
        elseif ( $currency_convert == $pro_config['money_unit'] )
        {
            $value = doubleval( $money_config[$currency_curent]['exchange'] );
            $price = doubleval( $price / $value );
        }
    }
    return $price;
}
/*set view old product*/
function SetSessionProView ( $id, $title, $alias, $addtime, $link, $homeimgthumb )
{
    global $module_data;
    if ( ! isset( $_SESSION[$module_data . '_proview'] ) ) $_SESSION[$module_data . '_proview'] = array();
    if ( ! isset( $_SESSION[$module_data . '_proview'][$id] ) )
    {
        $_SESSION[$module_data . '_proview'][$id] = array( 
            'title' => $title, 'alias' => $alias, 'addtime' => $addtime, 'link' => $link, 'homeimgthumb' => $homeimgthumb 
        );
    }
}
function redict_link ( $lang_view, $lang_back, $nv_redirect )
{
    global $lang_module;
    $contents = "<div class=\"frame\">";
    $contents .= $lang_view . "<br /><br />\n";
    $contents .= "<img border=\"0\" src=\"" . NV_BASE_SITEURL . "images/load_bar.gif\"><br /><br />\n";
    $contents .= "<a href=\"" . $nv_redirect . "\">" . $lang_back . "</a>";
    $contents .= "</div>";
    $contents .= "<meta http-equiv=\"refresh\" content=\"2;url=" . $nv_redirect . "\" />";
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}
function nv_generate_page_shop ( $base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page' )
{
    global $lang_global;
    
    $total_pages = ceil( $num_items / $per_page );
    if ( $total_pages == 1 ) return '';
    @$on_page = floor( $start_item / $per_page ) + 1;
    $amp = preg_match( "/\?/", $base_url ) ? "&amp;" : "?";
    $page_string = "";
    if ( $total_pages > 10 )
    {
        $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
        for ( $i = 1; $i <= $init_page_max; $i ++ )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $init_page_max ) $page_string .= " ";
        }
        if ( $total_pages > 3 )
        {
            if ( $on_page > 1 && $on_page < $total_pages )
            {
                $page_string .= ( $on_page > 5 ) ? " ... " : ", ";
                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
                for ( $i = $init_page_min - 1; $i < $init_page_max + 2; $i ++ )
                {
                    $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
                    $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                    if ( $i < $init_page_max + 1 )
                    {
                        $page_string .= " ";
                    }
                }
                $page_string .= ( $on_page < $total_pages - 4 ) ? " ... " : ", ";
            }
            else
            {
                $page_string .= " ... ";
            }
            
            for ( $i = $total_pages - 2; $i < $total_pages + 1; $i ++ )
            {
                $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
                $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                if ( $i < $total_pages )
                {
                    $page_string .= " ";
                }
            }
        }
    }
    else
    {
        for ( $i = 1; $i < $total_pages + 1; $i ++ )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $i - 1 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $total_pages )
            {
                $page_string .= " ";
            }
        }
    }
    if ( $add_prevnext_text )
    {
        if ( $on_page > 1 )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( ( $on_page - 2 ) * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( ( $on_page - 2 ) * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string = "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pageprev'] . "</a></span>&nbsp;&nbsp;" . $page_string;
        }
        if ( $on_page < $total_pages )
        {
            $href = ! $onclick ? "href=\"" . $base_url . $amp . "page=" . ( $on_page * $per_page ) . "\"" : "href=\"javascript:void(0)\" onclick=\"" . $js_func_name . "('" . rawurlencode( nv_unhtmlspecialchars( $base_url . $amp . "page=" . ( $on_page * $per_page ) ) ) . "','" . $containerid . "')\"";
            $page_string .= "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pagenext'] . "</a></span>";
        }
    }
    return $page_string;
}
?>