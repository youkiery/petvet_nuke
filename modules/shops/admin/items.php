<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 9-8-2010 14:43
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['content_list'];

$stype = $nv_Request->get_string( 'stype', 'get', '-' );
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$per_page_old = $nv_Request->get_int( 'per_page', 'cookie', 50 );
$per_page = $nv_Request->get_int( 'per_page', 'get', $per_page_old );
if ( $per_page < 1 and $per_page > 500 )
{
    $per_page = 50;
}
if ( $per_page_old != $per_page )
{
    $nv_Request->set_Cookie( 'per_page', $per_page, NV_LIVE_COOKIE_TIME );
}

$q = filter_text_input( 'q', 'get', '', 1 );
$ordername = $nv_Request->get_string( 'ordername', 'get', 'publtime' );
$order = $nv_Request->get_string( 'order', 'get' ) == "asc" ? 'asc' : 'desc';

$array_search = array( 
    "-" => $lang_module["search_type"], "title" => $lang_module['search_title'], "bodytext" => $lang_module['search_bodytext'], "author" => $lang_module['search_author'], "admin_id" => $lang_module['search_admin'] 
);
$array_in_rows = array( 
    "" . NV_LANG_DATA . "_title", "" . NV_LANG_DATA . "_bodytext" 
);
$array_in_ordername = array( 
    "" . NV_LANG_DATA . "_title", "publtime", "exptime" 
);
if ( ! in_array( $stype, array_keys( $array_search ) ) )
{
    $stype = "-";
}
if ( ! in_array( $ordername, array_keys( $array_in_ordername ) ) )
{
    $ordername = "id";
}

$from = "`" . $db_config['prefix'] . "_" . $module_data . "_rows`";

$array_catid = array();
if ($catid!=0) $array_catid = GetCatidInParent ( $catid );

$page = $nv_Request->get_int( 'page', 'get', 0 );
$checkss = $nv_Request->get_string( 'checkss', 'get', md5( session_id() ) );
if ( $checkss == md5( session_id() ) )
{
    if ( in_array( $stype, $array_in_rows ) and ! empty( $q ) )
    {
        $from .= " WHERE `" . $stype . "` LIKE '%" . $db->dblikeescape( $q ) . "%' ";
    	if ($catid!=0)
        {
        	$from .= " AND listcatid IN (".implode(',', $array_catid).")";
        }
    }
    elseif ( $stype == "admin_id" and ! empty( $q ) )
    {
        $sql = "SELECT userid FROM " . NV_USERS_GLOBALTABLE . " where userid in (SELECT admin_id FROM " . NV_AUTHORS_GLOBALTABLE . ") AND `username` LIKE '%" . $db->dblikeescape( $q ) . "%' OR `full_name` LIKE '%" . $db->dblikeescape( $q ) . "%'";
        $result = $db->sql_query( $sql );
        $array_admin_id = array();
        while ( list( $admin_id ) = $db->sql_fetchrow( $result ) )
        {
            $array_admin_id[] = $admin_id;
        }
        $from .= " WHERE `admin_id` IN (0," . implode( ",", $array_admin_id ) . ",0)";
    	if ($catid!=0)
        {
        	$from .= " AND listcatid IN (".implode(',', $array_catid).")";
        }
    }
    elseif ( ! empty( $q ) )
    {
        $sql = "SELECT userid FROM " . NV_USERS_GLOBALTABLE . " where userid in (SELECT admin_id FROM " . NV_AUTHORS_GLOBALTABLE . ") AND `username` LIKE '%" . $db->dblikeescape( $q ) . "%' OR `full_name` LIKE '%" . $db->dblikeescape( $q ) . "%'";
        $result = $db->sql_query( $sql );
        $array_admin_id = array();
        while ( list( $admin_id ) = $db->sql_fetchrow( $result ) )
        {
            $array_admin_id[] = $admin_id;
        }
        $arr_from = array();
        foreach ( $array_in_rows as $key => $val )
        {
            $arr_from[] = "(`" . $val . "` LIKE '%" . $db->dblikeescape( $q ) . "%')";
        }
        $from .= " WHERE " . implode( " OR ", $arr_from ) . "";
        if ( ! empty( $array_admin_id ) )
        {
            $from .= " OR (`admin_id` IN (0," . implode( ",", $array_admin_id ) . ",0))";
        }
        if ($catid!=0)
        {
        	$from .= " AND listcatid IN (".implode(',', $array_catid).")";
        }
    }
    else
    {
    	if ($catid!=0)
        {
        	$from .= " WHERE listcatid IN (".implode(',', $array_catid).")";
        }
    }
}

list( $all_page ) = $db->sql_fetchrow( $db->sql_query( "SELECT COUNT(*) FROM " . $from ) );
$sql = "SELECT userid, username  FROM " . NV_USERS_GLOBALTABLE . " ";
$result = $db->sql_query( $sql );
$array_admin = array();
while ( list( $admin_id, $admin_login ) = $db->sql_fetchrow( $result ) )
{
    $array_admin[$admin_id] = $admin_login;
}
$a = 0;
$order2 = ( $order == "asc" ) ? "desc" : "asc";
$base_url_id = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=id&order=" . $order2 . "&page=" . $page;
$base_url_name = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=".NV_LANG_DATA."_title&order=" . $order2 . "&page=" . $page;
$base_url_publtime = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=publtime&order=" . $order2 . "&page=" . $page;
$base_url_exptime = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=exptime&order=" . $order2 . "&page=" . $page;
$base_url_price = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=product_price&order=" . $order2 . "&page=" . $page;
$base_url_number = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=product_number&order=" . $order2 . "&page=" . $page;

////////////////////////////////////////
$xtpl = new XTemplate( "items.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'module_name', $module_name );
$xtpl->assign( 'op', $op );
$xtpl->assign( 'q', $q );
// set category select box
$global_array_cat = array();
$link_i = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=Other";
$global_array_cat[0] = array( 
    "catid" => 0, "parentid" => 0, "title" => "Other", "alias" => "Other", "link" => $link_i, "viewcat" => "viewcat_page_new", "subcatid" => 0, "numlinks" => 3, "description" => "", "keywords" => "" 
);

$sql = "SELECT catid, parentid, " . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, viewcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, " . NV_LANG_DATA . "_keywords, lev FROM `" . $db_config['prefix'] . "_" . $module_data . "_catalogs` ORDER BY `order` ASC";
$result = $db->sql_query( $sql ); 
while ( list( $catid_i, $parentid_i, $title_i, $alias_i, $viewcat_i, $subcatid_i, $numlinks_i, $del_cache_time_i, $description_i, $keywords_i, $lev_i ) = $db->sql_fetchrow( $result ) )
{
    $link_i = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $alias_i;
    $global_array_cat[$catid_i] = array( 
        "catid" => $catid_i, "parentid" => $parentid_i, "title" => $title_i, "alias" => $alias_i, "link" => $link_i, "viewcat" => $viewcat_i, "subcatid" => $subcatid_i, "numlinks" => $numlinks_i, "description" => $description_i, "keywords" => $keywords_i 
    );
    $xtitle_i = "";
    if ( $lev_i > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $lev_i; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $xtitle_i .= $title_i;
    $sl = "";
    if ( $catid_i == $catid )
    {
        $sl = " selected=\"selected\"";
    }
    $cate = array( "sl"=>$sl,"xtitle"=>$xtitle_i,"catid"=>$catid_i);
    $xtpl->assign( 'CATE', $cate );
    $xtpl->parse( 'main.cloop' );
}
//end set
//set stype
foreach ( $array_search as $key => $val )
{
	$sl = ( $key == $stype ) ? " selected=\"selected\"" : "";
	$row = array( "sl"=>$sl,"key"=>$key,"val"=>$val);
    $xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.sloop' );
}
//end set
//set per_page
$xtpl->assign( 'per_page', $per_page );
$xtpl->assign( 'session_id', md5( session_id() ) );

//get list data
$base_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=" . $ordername . "&order=" . $order;
$ord_sql = "ORDER BY `" . $ordername . "` " . $order . "";
$sql = "SELECT id, listcatid, user_id, " . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, status , publtime, exptime,product_number,product_price,money_unit,homeimgthumb,product_discounts FROM " . $from . " " . $ord_sql . " LIMIT " . $page . "," . $per_page;
//die($sql);
$result = $db->sql_query( $sql );
$a=0;
while ( list( $id, $listcatid, $admin_id, $title, $alias, $status, $publtime, $exptime,$product_number,$product_price,$money_unit,$homeimgthumb,$product_discounts ) = $db->sql_fetchrow( $result ) )
{
    if ( $status == 0 )
    {
        $status = $lang_module['status_0'];
    }
    elseif ( $publtime < NV_CURRENTTIME and ( $exptime == 0 or $exptime > NV_CURRENTTIME ) )
    {
        $status = $lang_module['status_1'];
    }
    elseif ( $publtime > NV_CURRENTTIME )
    {
        $status = $lang_module['status_2'];
    }
    else
    {
        $status = $lang_module['status_3'];
    }
    $publtime = nv_date( "H:i d/m/y", $publtime );
    $class = ( $a % 2 == 0 ) ? "" : " class=\"second\"";
    $catid_i = 0;
    if ( $catid > 0 )
    {
        $catid_i = $catid;
    }
    else
    {
        $listcatid_arr = explode( ",", $listcatid );
        $catid_i = $listcatid_arr[0];
    }
	$thumb = explode( "|", $homeimgthumb );
    if ( ! empty( $thumb[0] ) && ! nv_is_url( $thumb[0] ) )
    {
        $thumb[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $thumb[0];
    }
    else
    {
        $thumb[0] = "";
    }
    $admin_name = isset( $array_admin[$admin_id] ) ? $array_admin[$admin_id] : "system" ;
    $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $global_array_cat[$catid_i]['alias'] . "/" . $alias . "-" . $id;
    $link_cat = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid_i . "&stype=" . $stype . "&q=" . $q . "&checkss=" . $checkss . "&ordername=id&order=" . $order2 . "&page=" . $page;;
    $row = array( "id"=>$id,"title" =>$title, "bg"=>$class,"product_price"=>$product_price,"status"=>$status,"money_unit"=>$money_unit,"admin_name"=>$admin_name,"product_number"=>$product_number,"link"=>$link,"edit"=>nv_link_edit_page( $id ),"del"=>nv_link_delete_page( $id ),"thumb"=>$thumb[0],"publtime"=>$publtime,"product_discounts"=>$product_discounts,"pro_cat"=>$global_array_cat[$catid_i]['title'],"link_cat"=>$link_cat);
    $xtpl->assign( 'ROW', $row );
    if ($thumb[0]!="") $xtpl->parse( 'main.loop.img' );
	$xtpl->parse( 'main.loop' );
    $a ++;
}

$array_list_action = array( 
    'delete' => $lang_global['delete'], 'publtime' => $lang_module['publtime'], 'exptime' => $lang_module['exptime'], 'addtoblock' => $lang_module['addtoblock'], 'addtotopics' => $lang_module['addtotopics'] 
);
while ( list( $catid_i, $title_i ) = each( $array_list_action ) )
{
	$row = array("catid"=>$catid_i,"title"=>$title_i);
    $xtpl->assign( 'ROW', $row );
	$xtpl->parse( 'main.aloop' );
}
$xtpl->assign( 'md5ck', md5( $global_config['sitekey'] . session_id() ) );
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if ( $generate_page != "" ) 
{
	$xtpl->assign( 'generate_page', $generate_page );
	$xtpl->parse( 'main.page' );
}
$xtpl->assign( 'base_url_name', $base_url_name );
$xtpl->assign( 'base_url_price', $base_url_price );
$xtpl->assign( 'base_url_id', $base_url_id );
$xtpl->assign( 'base_url_number', $base_url_number );
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>