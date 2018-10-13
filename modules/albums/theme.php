<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_ALBUMS' ) ) die( 'Stop!!!' );

function view_listimg ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "listimg.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'MODULE_NAME', $module_file );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album/" . $row['album_alias'] . "-" . $row['aid'];
            $row['addtime'] = date( "d/m/Y", $row['addtime'] );
            if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $row['img_small'] = $imageinfo['src'];
                $row['img'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/' . $module_name . '/' . $row['img'];
            }
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        
        }
    }
	if ( ! empty( $html_pages ) )
    {
        $xtpl->assign( 'htmlpage', $html_pages );
        $xtpl->parse( 'main.pages' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_album ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "listalbum.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'MODULE_NAME', $module_file );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album/" . $row['alias'] . "-" . $row['id'];
            $row['add_time'] = date( "d/m/Y", $row['add_time'] );
            if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $row['img_small'] = $imageinfo['src'];
            }
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        
        }
    }
	if ( ! empty( $html_pages ) )
    {
        $xtpl->assign( 'htmlpage', $html_pages );
        $xtpl->parse( 'main.pages' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_alistimg ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "alistimg.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'MODULE_NAME', $module_file );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['addtime'] = date( "d/m/Y", $row['addtime'] );
            if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $row['img_small'] = $imageinfo['src'];
                $row['img'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/' . $module_name . '/' . $row['img'];
            }
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        
        }
    }
	if ( ! empty( $html_pages ) )
    {
        $xtpl->assign( 'htmlpage', $html_pages );
        $xtpl->parse( 'main.pages' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_slideimg ( $data_content )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "slidealbum.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'MODULE_NAME', $module_file );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=album/" . $row['alias'] . "-" . $row['id'];
            $row['addtime'] = date( "d/m/Y", $row['addtime'] );
            if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $row['img_small'] = $imageinfo['src'];
                $row['img'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/' . $module_name . '/' . $row['img'];
            }
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        
        }
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>