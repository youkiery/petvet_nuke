<?php

/**
 * @Project NUKEVIET 3.1
 * @Author PCD GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2011 PCD GROUP. All rights reserved
 * @Createdate Mon, 23 May 2011 05:30:42 GMT
 */
if ( ! defined( 'NV_IS_MOD_ARTICLES' ) ) die( 'Stop!!!' );

function view_home_none ( $array_data, $pages_html )
{
    return "";
}

function view_home_list ( $array_data, $pages_html )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $articles_config;
    $xtpl = new XTemplate( "view_home_list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( ! empty( $array_data ) )
    {
        foreach ( $array_data as $data )
        {
            $data['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $data['alias'] . "-" . $data['id'] . "";
            $data['add_time'] = nv_date( "l - d/m/Y  H:i", $data['add_time'] );
            $data['homewidth'] = $articles_config['homewidth'];
            $data['homeheight'] = $articles_config['homeheight'];
            if ( ! empty( $data['homefileimg'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $data['homefileimg'], $articles_config['homewidth'], true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $data['src'] = $imageinfo['src'];
            }
            $xtpl->assign( 'ROW', $data );
        	$admin_link = "";
		    if ( defined( 'NV_IS_MODADMIN' ) )
		    { 
		    	$admin_link = nv_link_edit_articles($data['id'])." " . nv_link_delete_articles($data['id']);
		    }
		    if (!empty($admin_link))
		    {
		    	$xtpl->assign( 'admin_link', $admin_link );
		    	$xtpl->parse( 'main.loop.admin_link' );
		    }
        	if (! empty( $data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $data['homefileimg'] ))
		    {
		    	$xtpl->parse( 'main.loop.img' );
		    }
            $xtpl->parse( 'main.loop' );
        }
    }
    if ( ! empty( $pages_html ) )
    {
        $xtpl->assign( 'pages_html', $pages_html );
        $xtpl->parse( 'main.page' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_home_gird ( $array_data, $pages_html )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $articles_config;
    $xtpl = new XTemplate( "view_home_gird.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( $articles_config['per_row'] == 0 ) $articles_config['per_row'] = 1;
    $width = 100 / $articles_config['per_row'];
    if ( ! empty( $array_data ) )
    {
        foreach ( $array_data as $data )
        {
            $data['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $data['alias'] . "-" . $data['id'] . "";
            if ( $data['link_active'] == 1 && ! empty( $data['link_redirect'] ) ) $data['link'] = $data['link_redirect'];
            $data['add_time'] = nv_date( "l - d/m/Y  H:i", $data['add_time'] );
            $data['hometext'] = nv_clean60( $data['hometext'], 200 );
            $data['homewidth'] = $articles_config['homewidth'];
            $data['homeheight'] = $articles_config['homeheight'];
            $data['widthview'] = $width;
            if ( ! empty( $data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $data['homefileimg'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $data['homefileimg'], $articles_config['homewidth'], true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $data['src'] = $imageinfo['src'];
            }
            $xtpl->assign( 'ROW', $data );
	        $admin_link = "";
		    if ( defined( 'NV_IS_MODADMIN' ) )
		    { 
		    	$admin_link = nv_link_edit_articles($data['id'])." " . nv_link_delete_articles($data['id']);
		    }
		    if (!empty($admin_link))
		    {
		    	$xtpl->assign( 'admin_link', $admin_link );
		    	$xtpl->parse( 'main.loop.admin_link' );
		    }
        	if (! empty( $data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $data['homefileimg'] ))
		    {
		    	$xtpl->parse( 'main.loop.img' );
		    }
            $xtpl->parse( 'main.loop' );
        }
    }
    if ( ! empty( $pages_html ) )
    {
        $xtpl->assign( 'pages_html', $pages_html );
        $xtpl->parse( 'main.page' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_home_all ( $array_data, $pages_html )
{
    global $articles_config;
    switch ( $articles_config['home_view_type'] )
    {
        case 'view_home_list':
            return view_home_list( $array_data, $pages_html );
        case 'view_home_gird':
            return view_home_gird( $array_data, $pages_html );
        default:
            return view_home_list( $array_data, $pages_html );
    }
}

function view_home_one ( $array_data, $pages_html )
{
    global $articles_config;
    $array_data_other = $data_one = array();
    if ( ! empty( $array_data[0] ) )
    {
        $data_one = array_pop( $array_data );
    }
    if ( ! empty( $array_data ) )
    {
        $array_data_other = $array_data;
    }
    $content = nv_theme_articles_detail( $data_one, $array_data_other );
	if ( ! empty( $pages_html ) )
    {
        $content = $content.'<div class="articles_pages">'.$pages_html.'</div>';
    }
    return $content;
}

function nv_theme_articles_detail ( $array_data, $array_data_other )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $articles_config, $client_info;
    $xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( ! empty( $array_data ) )
    {
        $array_data['add_time'] = nv_date( "l - d/m/Y  H:i", $array_data['add_time'] );
        $array_data['edit_time'] = nv_date( "l - d/m/Y  H:i", $array_data['edit_time'] );
        if ( ! empty( $array_data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $array_data['homefileimg'] ) )
        {
            $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $array_data['homefileimg'], $articles_config['homewidth'], true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
            $array_data['src'] = $imageinfo['src'];
        }
        $xtpl->assign( 'DATA', $array_data );
        if ( ! empty( $array_data['homefileimg'] ) && file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $array_data['homefileimg'] ) )
        {
            $xtpl->parse( 'main.hometext.img' );
        }
        if ( $articles_config['active_hometext'] == '1' )
        {
            $xtpl->parse( 'main.hometext' );
        }
        if ( ! empty( $array_data_other ) )
        {
            foreach ( $array_data_other as $other )
            {
                $other['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $other['alias'] . "-" . $other['id'] . "";
                if ( $other['link_active'] == 1 && ! empty( $other['link_redirect'] ) ) $other['link'] = $other['link_redirect'];
                $xtpl->assign( 'OTHER', $other );
                $xtpl->parse( 'main.other.loop' );
            }
            $xtpl->parse( 'main.other' );
        }
        //show keywords
        if ( ! empty( $array_data['keywords'] ) )
        {
            $array_key = explode( ',', $array_data['keywords'] );
            foreach ( $array_key as $key_title )
            {
                $ck = md5( $client_info['session_id'] . $global_config['sitekey'] );
                $key = array( 
                    'title' => trim( $key_title ), 'ck' => $ck 
                );
                $xtpl->assign( 'KEY', $key );
                $xtpl->parse( 'main.keywords.loop' );
            }
            $xtpl->parse( 'main.keywords' );
        }
    }
    $admin_link = "";
    if ( defined( 'NV_IS_MODADMIN' ) )
    { 
    	$admin_link = nv_link_edit_articles($array_data['id'])." " . nv_link_delete_articles($array_data['id']);
    }
    if (!empty($admin_link))
    {
    	$xtpl->assign( 'admin_link', $admin_link );
    	$xtpl->parse( 'main.admin_link' );
    }
    if (!empty($array_data['author'])) $xtpl->parse( 'main.author' );
	if (!empty($array_data['source'])) $xtpl->parse( 'main.source' );
	
    if ($articles_config['active_comment'] == 1 && $array_data['allow_comment'] == 1)
    {
    	$xtpl->assign( 'SRC_CAPTCHA', NV_BASE_SITEURL . "index.php?scaptcha=captcha" );
    	$xtpl->parse( 'main.comment' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>