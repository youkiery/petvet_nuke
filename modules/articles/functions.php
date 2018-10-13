<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_ARTICLES', true );
global $articles_config;
$articles_config = $module_config[$module_name];

global $id; $id = 0;
if ( $op == 'main' )
{
	//print_r($array_op);die();
    $count_op = count( $array_op );
	if ( $count_op == 1 )
    {
        $array_page = explode( "-", $array_op[0] );
        $id = intval( end( $array_page ) );
        $op = "detail";
    }
}

function nv_generate_page_articles ( $base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true, $onclick = false, $js_func_name = 'nv_urldecode_ajax', $containerid = 'generate_page' )
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

function nv_link_edit_articles ( $id )
{
    global $lang_global, $module_name;
    $link = "<span class=\"edit_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $id . "\">" . $lang_global['edit'] . "</a></span>";
    return $link;
}

function nv_link_delete_articles ( $id )
{
    global $lang_global, $module_name,$lang_module;
    $link = "<span class=\"delete_icon\"><a href=\"javascript:void(0);\" onclick=\"nv_del_articles(" . $id . ",'" . NV_BASE_ADMINURL . "','".$lang_module['del_config']."')\">" . $lang_global['delete'] . "</a></span>";
    return $link;
}

?>