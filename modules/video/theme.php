<?php

/**
 * @Project OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

function view_listcate ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "main_catall.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $data_content_i )
        {
            if ( ! empty( $data_content_i['data'] ) )
            {
                $xtpl->assign( 'CATE', $data_content_i['catinfo'] );
                if ( $data_content_i['catinfo']['numsubcat'] > 0 )
                {
                    $arraysub = explode( ",", $data_content_i['catinfo']['subcatid'] );
                    foreach ( $arraysub as $sub )
                    {
                        $xtpl->assign( 'SUB', $global_videos_cat[$sub] );
                        $xtpl->parse( 'main.cat.subcat' );
                    }
                }
                foreach ( $data_content_i['data'] as $row )
                {
                    $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view/" . $row['alias'] . "-" . $row['id'];
                    $row['addtime'] = date( "d/m/Y", $row['addtime'] );
                    //if ( ! empty( $row['img'] ) ) $row['img'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row['img'];
                	if ( ! empty( $row['img'] ) )
		            {
		                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
		                $row['img'] = $imageinfo['src'];
		            }
                    $row['title1'] = nv_clean60( $row['title'], 20 );
                    $xtpl->assign( 'ROW', $row );
                    if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.cat.loop.img' );
                    $xtpl->parse( 'main.cat.loop' );
                }
                $xtpl->parse( 'main.cat' );
            }
        }
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_listall ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $xtpl = new XTemplate( "main_listall.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view/" . $row['alias'] . "-" . $row['id'];
            $row['addtime'] = date( "d/m/Y", $row['addtime'] );
            //if ( ! empty( $row['img'] ) ) $row['img'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row['img'];
        	if ( ! empty( $row['img'] ) )
            {
                $imageinfo = nv_ImageInfo( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['img'], 120, true, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name );
                $row['img'] = $imageinfo['src'];
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

function view_one ( $data_content = null, $html_pages = "" )
{
	global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $data_content['addtime'] = date( "d/m/Y", $data_content['addtime'] );
    if ( ! empty( $data_content['img'] ) ) $data_content['img'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $data_content['img'];
    $data_content['file_src'] = ( ! empty( $data_content['filepath'] ) ) ? NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row['filepath'] : $data_content['otherpath'];
    return view_videos( $data_content );
}

function view_videos ( $data_content,$data_other=array() )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $xtpl = new XTemplate( "view.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'DATA', $data_content );
    if ( !empty($data_content['otherpath']) ) $xtpl->parse( 'main.linko' );
    if ( !empty($data_content['file_src']) ) $xtpl->parse( 'main.file' );
    if ( !empty($data_content['embed']) ) $xtpl->parse( 'main.embed' );
    if (!empty($data_other))
    {
    	foreach ( $data_other as $row )
        {
            $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=view/" . $row['alias'] . "-" . $row['id'];
            $row['addtime'] = date( "d/m/Y", $row['addtime'] );
            if ( ! empty( $row['img'] ) ) $row['img'] = NV_BASE_SITEURL . "" . NV_UPLOADS_DIR . "/" . $module_name . "/" . $row['img'];
            $row['title1'] = nv_clean60( $row['title'], 20 );
            $xtpl->assign( 'ROW', $row );
            if ( ! empty( $row['img'] ) ) $xtpl->parse( 'main.loop.img' );
            $xtpl->parse( 'main.loop' );
        }
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function viewcat_list ( $data_content = null, $top_contents = "", $html_pages = "" )
{
    return view_listall( $data_content, $html_pages );
}

function viewcat_gird ( $data_content = null, $top_contents = "", $html_pages = "" )
{
    return view_listall( $data_content, $html_pages );
}

function view_search ( $data_content = null, $html_pages = "", $data_form )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_videos_cat;
    $xtpl = new XTemplate( "view_search.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'RESULT', view_listall( $data_content, $html_pages ) );
    $xtpl->assign( 'DATA', $data_form );
    foreach ( $global_archives_cat as $catid => $catinfo )
    {
        $xtitle = "";
        if ( $catinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $catinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $catinfo['xtitle'] = $xtitle . $catinfo['title'];
        $catinfo['select'] = ( $catinfo['catid'] == $data_form['catid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $catinfo );
        $xtpl->parse( 'main.cat_loop' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

?>