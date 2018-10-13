<?php
/**
 * @Project PCD-NUKEVIET 3.x
 * @Author PCD-GROUP (dinhpc.it@gmail.com)
 * @Copyright (C) 2012 PCD-GROUP. All rights reserved
 * @Createdate 3-6-2010 0:14
 */
if ( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );

$global_array_cat;
$num_colum = $nv_Request->get_int( 'col', 'get',4 );
$num_row = $nv_Request->get_int( 'row', 'get',2 );
$num_height = $nv_Request->get_int( 'height', 'get',2 );
$block_id = $nv_Request->get_int( 'bid', 'get',1 );
$type = $nv_Request->get_int( 'type', 'get',1 );
$num = $num_colum * $num_row;

if ( $num > 10 ) $num = 10;

define('VAR_ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] );
$cachefilename = urlencode($_SERVER['REQUEST_URI'])."-".md5($num_colum.$num_row.$num_height.$block_id.$type); 
global $cacheFile;
$cacheFile = VAR_ROOT_DIR. '/cache/'.$cachefilename.'.cache';
$cachetime = 60*3; 
if (file_exists($cacheFile) && time() - $cachetime < filemtime($cacheFile) )
{
    $content = file_get_contents($cacheFile);
    echo $content;
	exit();
} 

ob_start();


$contentid = $nv_Request->get_string( 'cid', 'get',"ads_content" );

$sql = "SELECT bid, " . NV_LANG_DATA . "_title FROM `" . $db_config['prefix'] . "_" . $module_data . "_block_cat` WHERE bid= " . $block_id . "";
$result = $db->sql_query( $sql );
list( $bid, $titlebid ) = $db->sql_fetchrow( $result );

$array_content = array();
if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $module_file . "/product_share.tpl" ) )
{
    $block_theme = $global_config['site_theme'];
}
else
{
    $block_theme = "default";
}

$xtpl = new XTemplate( "product_share.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file );

$xtpl->assign( 'NV_BASE_SITEURL', $global_config['site_url'].NV_BASE_SITEURL );
$xtpl->assign( 'THEME', $block_theme );
$sql = "SELECT t1.id, t1.listcatid, t1." . NV_LANG_DATA . "_title as title, t1." . NV_LANG_DATA . "_alias as alias, t1.homeimgthumb , t1.homeimgalt, t1." . NV_LANG_DATA . "_hometext as hometext, t1.product_price, t1.product_discounts FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` as t1 LEFT JOIN `" . $db_config['prefix'] . "_" . $module_data . "_block` AS t2 ON t1.id = t2.id WHERE t2.bid= " . $bid . " AND t1.status= 1 AND t1.inhome='1' and  t1.publtime < " . NV_CURRENTTIME . " AND (t1.exptime=0 OR t1.exptime >" . NV_CURRENTTIME . ") ORDER BY RAND() LIMIT 0 , " . $num;
$result = $db->sql_query( $sql );
while ( $row = $db->sql_fetchrow( $result,2 ) )
{
    $row['link'] = $global_config['site_url'].NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $global_array_cat[$row['listcatid']]['alias'] . "/" . $row['alias'] . "-" . $row['id'];
    $thumb = explode( "|", $row['homeimgthumb'] );
    if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
    {
        $row['src'] = $global_config['site_url'].NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
    }
    else
    {
                $row['src'] = $row['homeimgthumb'];
                // $row['src'] = $global_config['site_url'].NV_BASE_SITEURL . "themes/" . $block_theme . "/images/" . $module_file . "/no-image.jpg";
    }
	$row['hometext1'] = nv_clean60($row['hometext'],100);
    $row['hometext'] = nv_clean60($row['hometext'],40);
    $row['surl'] = str_replace( "http://","",$global_config['site_url'] );
    $row['url'] = $global_config['site_url'];
    $row['width'] = (100 / $num_colum) - 1;
    $row['height'] = $num_height;
	$price_product_discounts = $row['product_price'] - ( $row['product_price'] * ( $row['product_discounts'] / 100 ) );
    $row['product_price'] = FormatNumber($price_product_discounts,0,'.', ' ');
    $xtpl->assign( 'ROW', $row );
	if ( $type == 1 ) 
	{
		$xtpl->parse( 'main.type1.loop' );
	}
	if ( $type == 2 ) 
	{
		$xtpl->parse( 'main.type2.loop' );
	}
	if ( $type == 3 ) 
	{
		$xtpl->parse( 'main.type3.loop' );
	}
}
if ( $type == 1 ) 
{
	$xtpl->parse( 'main.type1' );
}
if ( $type == 2 ) 
{
	$xtpl->parse( 'main.type2' );
}
if ( $type == 3 ) 
{
	$xtpl->parse( 'main.type3' );
}
$xtpl->parse( 'main' );
$content = $xtpl->text( 'main' );

echo $content;

$page = ob_get_contents();
ob_end_clean();

echo $page;

global $cacheFile,$is_mobile;
file_put_contents($cacheFile,$page); 


?>