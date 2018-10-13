<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3-6-2010 0:14
 */
if ( ! defined( 'NV_IS_MOD_SHOPS' ) ) die( 'Stop!!!' );


$data_content = array();
$view = $nv_Request->get_string( 'view', 'post,get', "" );
$opst = $nv_Request->get_string( 'opst', 'post,get', "" );
$sort_id = $nv_Request->get_int( 'sort', 'get,post', 0 );

if(!empty($view))
{
	$global_array_cat[$catid]['viewcat'] = $view;
}

$count = 0;

$base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $global_array_cat[$catid]['alias'] . "";

$page_title = $global_array_cat[$catid]['title'];
$key_words = $global_array_cat[$catid]['keywords'];
$description = $global_array_cat[$catid]['description'];
	
if($relates == 1)
{
	
	$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

	 $data_content = array();

        $array_info_i = $global_array_block_cat[$catid];


        $s = "SELECT SQL_CALC_FOUND_ROWS a.id, a.publtime, a." . NV_LANG_DATA . "_title,a." . NV_LANG_DATA . "_alias, a." . NV_LANG_DATA . "_hometext, a." . NV_LANG_DATA . "_address, a.homeimgalt, a.homeimgthumb, a.product_price, a.hitstotal,a.product_discounts, a.money_unit,a.showprice,a.homeimgfile, a." . NV_LANG_DATA . "_codesp  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` AS a INNER JOIN `" . $db_config['prefix'] . "_" . $module_data . "_block` AS b ON a.id = b.id WHERE b.bid = ".$catid." AND a.inhome=1 AND a.status=1 AND a.publtime <= " . NV_CURRENTTIME . " AND (a.exptime=0 OR a.exptime>" . NV_CURRENTTIME . ") ORDER BY a.id DESC LIMIT 0,20";

		
        $re = $db->sql_query( $s );


        $result = $db->sql_query( "SELECT FOUND_ROWS()" );

        list( $num_pro ) = $db->sql_fetchrow( $result );

        

        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

        $data_pro = array();

        while ( list( $id, $publtime, $title, $alias, $hometext, $address, $homeimgalt, $homeimgthumb, $product_price, $hitstotal, $product_discounts, $money_unit,$showprice,$homeimgfile, $codesp ) = $db->sql_fetchrow( $re ) )

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
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no-image.jpg";

            }

            $data_pro[] = array( 

                "id" => $id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "hometext" => $hometext, "address" => $address, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "hitstotal" => $hitstotal, "product_discounts" => $product_discounts, "money_unit" => $money_unit,"showprice" =>$showprice, "link_pro" => $link . $global_array_block_cat[$catid]['alias'] . "/" . $alias . "-" . $id, "link_order" => $link . "setcart&amp;id=" . $id ,"homeimgfile"=>$homeimgfile, "codesp"=>$codesp

            );

        }
		//die($link . $global_array_block_cat[$catid]['alias'] . "/" . $alias . "-" . $id);
        $data_content[] = array( 

            "catid" => $catid, "title" => $array_info_i['title'], "link" => $array_info_i['link'], 'data' => $data_pro, 'num_pro' => $num_pro, "num_link" => $array_info_i['numlinks'] 

        );

  

    $contents = call_user_func( 'view_home_cat', $data_content );
}

elseif($check == 1)
{
	//$page_title = $global_array_source[$catid]['vi_title'];
	
	$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

	 $data_content = array();

        $array_info_i = $global_array_source[$catid];


        $s = "SELECT SQL_CALC_FOUND_ROWS id, publtime, " . NV_LANG_DATA . "_title," . NV_LANG_DATA . "_alias, " . NV_LANG_DATA . "_hometext, " . NV_LANG_DATA . "_address, homeimgalt, homeimgthumb, product_price, hitstotal,product_discounts, money_unit,showprice,homeimgfile, " . NV_LANG_DATA . "_codesp   FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE source_id =".$catid." AND inhome=1 AND status=1 AND publtime <= " . NV_CURRENTTIME . " AND (exptime=0 OR exptime>" . NV_CURRENTTIME . ") ORDER BY ID DESC LIMIT 0,20";

        $re = $db->sql_query( $s );


        $result = $db->sql_query( "SELECT FOUND_ROWS()" );

        list( $num_pro ) = $db->sql_fetchrow( $result );

        

        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

        $data_pro = array();

        while ( list( $id, $publtime, $title, $alias, $hometext, $address, $homeimgalt, $homeimgthumb, $product_price, $hitstotal, $product_discounts, $money_unit,$showprice,$homeimgfile, $codesp ) = $db->sql_fetchrow( $re ) )

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
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no-image.jpg";

            }

            $data_pro[] = array( 

                "id" => $id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "hometext" => $hometext, "address" => $address, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "hitstotal" => $hitstotal, "product_discounts" => $product_discounts, "money_unit" => $money_unit,"showprice" =>$showprice, "link_pro" => $link  . $alias . "-" . $id, "link_order" => $link . "setcart&amp;id=" . $id ,"homeimgfile"=>$homeimgfile,"codesp"=>$codesp

            );

        }

        $data_content[] = array( 

            "catid" => $catid, "title" => $array_info_i['title'], "link" => $array_info_i['link'], 'data' => $data_pro, 'num_pro' => $num_pro, "num_link" => $array_info_i['numlinks'] 

        );

  

    $contents = call_user_func( 'view_home_cat', $data_content );
}

elseif ( $global_array_cat[$catid]['viewcat'] == "view_home_cat" and $global_array_cat[$catid]['numsubcat'] > 0 )
{	
	$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

    $data_content = array();

    $array_subcatid = explode( ",", $global_array_cat[$catid]['subcatid'] );

    foreach ( $array_subcatid as $catid_i )

    {

        $array_info_i = $global_array_cat[$catid_i];

        

        $array_cat = array();

        $array_cat = GetCatidInParent( $catid_i );

        $s = "SELECT SQL_CALC_FOUND_ROWS id, publtime, " . NV_LANG_DATA . "_title," . NV_LANG_DATA . "_alias, " . NV_LANG_DATA . "_hometext, " . NV_LANG_DATA . "_address, homeimgalt, homeimgthumb, product_price, hitstotal,product_discounts, money_unit,showprice,homeimgfile, " . NV_LANG_DATA . "_codesp  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE listcatid IN (" . implode( ",", $array_cat ) . ") AND inhome=1 AND status=1 AND publtime <= " . NV_CURRENTTIME . " AND (exptime=0 OR exptime>" . NV_CURRENTTIME . ") ORDER BY ID DESC LIMIT 0," . $array_info_i['numlinks'] . "";

        $re = $db->sql_query( $s );

        

        $result = $db->sql_query( "SELECT FOUND_ROWS()" );

        list( $num_pro ) = $db->sql_fetchrow( $result );

        

        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";

        $data_pro = array();

        while ( list( $id, $publtime, $title, $alias, $hometext, $address, $homeimgalt, $homeimgthumb, $product_price, $hitstotal, $product_discounts, $money_unit,$showprice,$homeimgfile, $codesp ) = $db->sql_fetchrow( $re ) )

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
                // $thumb[0] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no-image.jpg";

            }

            $data_pro[] = array( 

                "id" => $id, "publtime" => $publtime, "title" => $title, "alias" => $alias, "hometext" => $hometext, "address" => $address, "homeimgalt" => $homeimgalt, "homeimgthumb" => $thumb[0], "product_price" => $product_price, "hitstotal" => $hitstotal, "product_discounts" => $product_discounts, "money_unit" => $money_unit,"showprice" =>$showprice, "link_pro" => $link . $alias . "-" . $id, "link_order" => $link . "setcart&amp;id=" . $id ,"homeimgfile"=>$homeimgfile,"codesp"=>$codesp

            );

        }

        $data_content[] = array( 

            "catid" => $catid_i, "title" => $array_info_i['title'], "link" => $array_info_i['link'], 'data' => $data_pro, 'num_pro' => $num_pro, "num_link" => $array_info_i['numlinks'] 

        );

    }

    $contents = call_user_func( 'view_home_cat', $data_content );

}

else

{
    $sql = "SELECT SQL_CALC_FOUND_ROWS id,listcatid, publtime, " . NV_LANG_DATA . "_title, " . NV_LANG_DATA . "_alias, " . NV_LANG_DATA . "_hometext, " . NV_LANG_DATA . "_address, homeimgalt, homeimgthumb,product_price,hitstotal,product_discounts,money_unit,showprice,homeimgfile, " . NV_LANG_DATA . "_codesp  FROM `" . $db_config['prefix'] . "_" . $module_data . "_rows` WHERE ";

    if ( $global_array_cat[$catid]['numsubcat'] == 0 )

    {

        $sql .= " listcatid =" . $catid . "";

    }

    else

    {

        $array_cat = array();

        $array_cat = GetCatidInParent( $catid );

        $sql .= " listcatid IN (" . implode( ",", $array_cat ) . ")";

    }

    $order_by = " ORDER BY ID DESC ";

	if ($sort_id>0)

    {

    	if ( $sort_id == 1)

    	{

    		$order_by = "ORDER BY " . NV_LANG_DATA . "_title ASC ";

    	}

    	elseif ( $sort_id == 2 )

    	{

    		$order_by = "ORDER BY " . NV_LANG_DATA . "_title DESC ";

    	}

    	elseif ( $sort_id == 3 )

    	{

    		$order_by = "ORDER BY product_discounts ASC ";

    	}

    	elseif ( $sort_id == 4 )

    	{

    		$order_by = "ORDER BY product_discounts DESC ";

    	}

    }

    $sql .= " AND status=1 AND publtime <= " . NV_CURRENTTIME . " AND (exptime=0 OR exptime>" . NV_CURRENTTIME . ") ".$order_by." LIMIT " . $page . "," . $per_page . "";

	
   
    $result = $db->sql_query( $sql );

    $result_page = $db->sql_query( "SELECT FOUND_ROWS()" );

	list( $numf ) = $db->sql_fetchrow( $result_page );

	$all_page = ( $numf ) ? $numf : 1;

	    

    $data_content = GetDataIn( $result, $catid );

    $data_content['count'] = $all_page;

    /*if ( $sort_id>0 ) 

    {

    	$base_url = $base_url."&sort=".$sort_id;

    	$pages = nv_products_page2( $base_url, $all_page, $per_page, $page );

    }

    else*/

    {

    	$pages = nv_products_page( $base_url, $all_page, $per_page, $page );

    }
	//print_r($data_content);die();
    $contents = call_user_func( $global_array_cat[$catid]['viewcat'], $data_content, $pages );

}

include ( NV_ROOTDIR . "/includes/header.php" );

echo nv_site_theme( $contents );

include ( NV_ROOTDIR . "/includes/footer.php" );



?>