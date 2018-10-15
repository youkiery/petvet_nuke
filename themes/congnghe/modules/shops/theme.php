<?php

if (!defined('NV_IS_MOD_SHOPS'))
  die('Stop!!!');

function draw_option_select_number($select = -1, $begin = 0, $end = 100, $step = 1) {
  $html = "";
  for ($i = $begin; $i < $end; $i = $i + $step) {
    if ($i == $select)
      $html .= "<option value=\"" . $i . "\" selected=\"selected\">" . $i . "</option>";
    else
      $html .= "<option value=\"" . $i . "\">" . $i . "</option>";
  }
  return $html;
}

function view_home_cat($data_content, $html_pages = "") {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config;
  $xtpl = new XTemplate("main_procate.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $num_view = $pro_config['per_row'];
  if (!empty($data_content)) {
    foreach ($data_content as $data_row) {
      if ($data_row['num_pro'] > 0) {
        $xtpl->assign('TITLE_CATALOG', $data_row['title']);
        $xtpl->assign('LINK_CATALOG', $data_row['link']);
        $xtpl->assign('NUM_PRO', $data_row['num_pro']);
        $xtpl->assign('IMG_CATALOG', $data_row['image']);
        $xtpl->assign('DES_CATALOG', $data_row['description']);
        $i = 1;
        $id = 1;
        foreach ($data_row['data'] as $data_row_i) {
          $xtpl->assign('ID', $data_row_i['id']);
          $xtpl->assign('LINK', $data_row_i['link_pro']);
          $xtpl->assign('TITLE', $data_row_i['title']);
          $xtpl->assign('TITLE0', nv_clean60($data_row_i['title'], 25));
          $xtpl->assign('IMG_SRC', $data_row_i['homeimgthumb']);
          $xtpl->assign('IMG_SRC2', $data_row_i['homeimgfile']);
          $xtpl->assign('LINK_ORDER', $data_row_i['link_order']);
          $xtpl->assign('height', $pro_config['homeheight']);
          $xtpl->assign('width', $pro_config['homewidth']);
          $xtpl->assign('hometext', nv_clean60($data_row_i['hometext'], 300));
          if ($pro_config['active_price'] == '1') {
            if ($data_row_i['showprice'] == '1') {
              $xtpl->assign('product_price', CurrencyConversion($data_row_i['product_price'], $data_row_i['money_unit'], $pro_config['money_unit']));
              $xtpl->assign('money_unit', $pro_config['money_unit']);
              if ($data_row_i['product_discounts'] != 0) {
                $price_product_discounts = $data_row_i['product_price'] - ($data_row_i['product_price'] * ($data_row_i['product_discounts'] / 100));
                $xtpl->assign('product_discounts', CurrencyConversion($price_product_discounts, $data_row_i['money_unit'], $pro_config['money_unit']));
                $product_price_end = $data_row_i['product_price'] - $price_product_discounts;
                $xtpl->assign('product_price_end', CurrencyConversion($product_price_end, $data_row_i['money_unit'], $pro_config['money_unit']));
                $xtpl->assign('class_money', 'price-old');
                $xtpl->parse('main.catalogs.items.price.discounts');
              } else {
                $xtpl->assign('class_money', 'price');
              }
              $xtpl->parse('main.catalogs.items.price');
            } else {
              $xtpl->parse('main.catalogs.items.contact');
            }
          }
          $pwidth = (int) (100 / $num_view);
          if ($i % $pro_config['per_row'] == 0) {
            $xtpl->parse('main.catalogs.items.break');
            $pwidth = 100 - ((int) (100 / $num_view)) * ($i - 1);
            $i = 0;
          } else {
            $pwidth = (int) (100 / $num_view);
          }
          $xtpl->assign('pwidth', $pwidth);
          if ($pro_config['active_order'] == '1') {
            if ($data_row_i['showprice'] == '1') {
              $xtpl->parse('main.catalogs.items.order');
            }
          }
          if ($pro_config['active_tooltip'] == 1)
            $xtpl->parse('main.catalogs.items.tooltip');
          $xtpl->assign('id', $id);
          $xtpl->parse('main.catalogs.items');
          $i++;
          $id++;
        }
        if ($data_row['num_pro'] > $data_row['num_link'])
          $xtpl->parse('main.catalogs.view_next');
        $xtpl->parse('main.catalogs');
      }
    }
  }
  if ($pro_config['active_tooltip'] == 1)
    $xtpl->parse('main.tooltip_js');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function view_home_all($data_content, $html_pages = "") {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $sort_id;
  $xtpl = new XTemplate("main_product.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $xtpl->assign('SELECT' . $sort_id, 'selected="selected"');
  $num_view = $pro_config['per_row'];
  if (!empty($data_content)) {
    $i = 1;
    foreach ($data_content as $data_row) {

      $xtpl->assign('ID', $data_row['id']);
      $xtpl->assign('LINK', $data_row['link_pro']);
      $xtpl->assign('TITLE', $data_row['title']);
      $xtpl->assign('TITLE0', nv_clean60($data_row['title'], 22));
      $xtpl->assign('IMG_SRC', $data_row['homeimgthumb']);
      $xtpl->assign('IMG_SRC2', $data_row['homeimgfile']);
      $xtpl->assign('homeimgfile', $data_row['homeimgfile']);
      $xtpl->assign('LINK_ORDER', $data_row['link_order']);
      $xtpl->assign('height', $pro_config['homeheight']);
      $xtpl->assign('width', $pro_config['homewidth']);
      $xtpl->assign('width', $pro_config['homewidth']);
      $xtpl->assign('NUM_VIEW', $data_row['hitstotal']);
      //$xtpl->assign('SALE', $data_row['product_discounts']);
      $xtpl->assign('hometext', nv_clean60($data_row['hometext'], 300));
      $a = round((100 - (($data_row['product_discounts']) / ($data_row['product_price'])) * 100));
      //$b=round(3.8);
      //print_r($b);exit();
      $pwidth = (int) (100 / $num_view);
      if ($i % $pro_config['per_row'] == 0) {
        $xtpl->parse('main.items.break');
        $pwidth = 100 - ((int) (100 / $num_view)) * ($i - 1);
        $i = 0;
      } else {
        $pwidth = (int) (100 / $num_view);
      }
      $xtpl->assign('pwidth', $pwidth);
      if ($pro_config['active_order'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->parse('main.items.order');
        }
      }
      if ($pro_config['active_price'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->assign('product_price', CurrencyConversion($data_row['product_price'], $data_row['money_unit'], $pro_config['money_unit']));
          $xtpl->assign('money_unit', $pro_config['money_unit']);
          if ($data_row['product_discounts'] != 0) {
            //$price_product_discounts = $data_row['product_price'] - ($data_row['product_price'] * ($data_row['product_discounts'] / 100));						
            //$xtpl->assign('sale', CurrencyConversion($price_product_discounts, $data_row['money_unit'], $pro_config['money_unit']));
            $xtpl->assign('sale', $a);
            $product_price_end = $data_row['product_price'] - $data_row['product_discounts'];
            $xtpl->assign('product_price_end', CurrencyConversion($product_price_end, $data_row['money_unit'], $pro_config['money_unit']));
            $price_product_discounts = $data_row['product_discounts'];
            $xtpl->assign('product_discounts', number_format($price_product_discounts, 0, '.', ' ') . " ");

            $xtpl->assign('class_money', 'ul_li_price1');
            $xtpl->parse('main.items.price.discounts');
            $xtpl->parse('main.items.price');
          } else {
            $xtpl->parse('main.items.price2');
            $xtpl->assign('class_money', 'ul_li_price');
          }
        } else {
          $xtpl->parse('main.items.contact');
        }
      }
      if ($pro_config['active_tooltip'] == 1)
        $xtpl->parse('main.items.tooltip');
      $xtpl->parse('main.items');
      $i++;
    }
    if (!empty($html_pages)) {
      $xtpl->assign('generate_page', $html_pages);
      $xtpl->parse('main.pages');
    }
  }
  if ($pro_config['active_tooltip'] == 1)
    $xtpl->parse('main.tooltip_js');

  $xtpl->parse('main');

  return $xtpl->text('main');
}

function view_home_none($data_content, $html_pages = "") {
  return "";
}

function view_search_all($data_content, $html_pages = "", $all_page) {
  global $db, $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $sort_id;
  $xtpl = new XTemplate("search_all.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $num_view = $pro_config['per_row'];
  if (!empty($data_content)) {
    $i = 1;
    foreach ($data_content as $data_row) {
      $xtpl->assign('ID', $data_row['id']);
      $xtpl->assign('LINK', $data_row['link_pro']);
      $xtpl->assign('TITLE', $data_row['title']);
      $xtpl->assign('TITLE0', nv_clean60($data_row['title'], 25));
      $xtpl->assign('IMG_SRC', $data_row['homeimgthumb']);
      $xtpl->assign('homeimgfile', $data_row['homeimgfile']);
      $xtpl->assign('LINK_ORDER', $data_row['link_order']);
      $xtpl->assign('height', $pro_config['homeheight']);
      $xtpl->assign('width', $pro_config['homewidth']);
      $xtpl->assign('hometext', nv_clean60($data_row['hometext'], 100));
      $a = round((100 - (($data_row['product_discounts']) / ($data_row['product_price'])) * 100));
      $xtpl->assign('sale', $a);
      $pwidth = (int) (100 / $num_view);
      if ($i % $pro_config['per_row'] == 0) {
        $xtpl->parse('main.items.break');
        $pwidth = 100 - ((int) (100 / $num_view)) * ($i - 1);
        $i = 0;
      } else {
        $pwidth = (int) (100 / $num_view);
      }
      $xtpl->assign('pwidth', $pwidth);
      if ($pro_config['active_order'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->parse('main.items.order');
        }
      }
      $xtpl->assign('id', $data_row["id"]);
      $xtpl->assign('product_price', number_format($data_row['product_price'], 0, '.', ' ') . " " . $data_row['money_unit']);
      if ($pro_config['active_price'] == '1') {
        if ($data_row['showprice'] == '1') {
          if ($data_row['product_discounts'] != 0) {
            //$price_product_discounts = $data_row['product_price'] - ($data_row['product_price'] * ($data_row['product_discounts'] / 100));
            $price_product_discounts = $data_row['product_discounts'];
            $xtpl->assign('product_discounts', number_format($price_product_discounts, 0, '.', ' ') . " " . $data_row['money_unit']);
            $xtpl->assign('class_money', 'gianiemyet');
            $xtpl->assign('sale', $a);
            $xtpl->parse('main.items.price');
            $xtpl->parse('main.items.price.discounts');
          } else {
            $xtpl->parse('main.items.price2');
            $xtpl->assign('class_money', 'giaban');
          }
        } else {
          $xtpl->parse('main.items.contact');
        }
      }

      //zsize
      $sql2 = "SELECT size FROM `vng_shops_size` WHERE product_id = " . $data_row["id"];
      $result = $db->sql_query($sql2);
      $size = array();
      $check_size = false;
      while ($row = $db->sql_fetch_assoc($result)) {
        $check_size = true;
        $size[] = $row["size"];
      }
      if ($check_size) {
        $size_string = "Size (" . implode(", ", $size) . ")";
        $xtpl->assign('size', $size_string);
        $xtpl->parse('main.items.size');
      } else {
        $xtpl->parse('main.items.nosize');
      }
      if ($pro_config['active_tooltip'] == 1)
        $xtpl->parse('main.items.tooltip');
      $xtpl->parse('main.items');
      $i++;
      $xtpl->assign('sa', $all_page);
    }
    if (!empty($html_pages)) {
      $xtpl->assign('generate_page', $html_pages);
      $xtpl->parse('main.pages');
    }
  }
  if ($pro_config['active_tooltip'] == 1)
    $xtpl->parse('main.tooltip_js');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function viewcat_page_gird($data_content, $pages) {
  global $db, $module_info, $lang_module, $module_file, $module_name, $pro_config, $sort_id, $array_op, $nv_Request, $global_array_cat;
  $xtpl = new XTemplate("view_gird.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  //print_r($global_array_cat[$data_content['id']]['title']);exit();
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('TITLE_CATALOG', $global_array_cat[$data_content['id']]['title']);
  $xtpl->assign('LINK_CATALOG', $global_array_cat[$data_content['id']]['link']);
  $xtpl->assign('IMG_CATALOG', $global_array_cat[$data_content['id']]['image']);
  $xtpl->assign('ICON_CATALOG', $global_array_cat[$data_content['id']]['icon']);
  $xtpl->assign('DES_CATALOG', $global_array_cat[$data_content['id']]['description']);
  $array_sub = explode(",", $global_array_cat[$data_content['id']]['subcatid']);
  $i = 0;
  $a = 1;
  foreach ($array_sub as $sub) {
    //if ( $i >= 4 ) break;
    if (!empty($global_array_cat[$sub])) {
      if ($a != 1) {
        $xtpl->assign('li', 'li');
      } else {
        $xtpl->assign('li', '');
      }
      $xtpl->assign("SUB", $global_array_cat[$sub]);
      //print_r($global_array_cat[$sub]);exit();
      $xtpl->parse('main.sub');
      $i++;
      $a++;
    }
  }



  $array_sort = array($lang_module['sort0'], $lang_module['sort1'], $lang_module['sort2'], $lang_module['sort3'], $lang_module['sort4']);
  foreach ($array_sort as $array_sort_i => $value) {
    if ($array_sort_i == $sort_id)
      $select = "selected='selected'";
    else
      $select = "";
    $xtpl->assign('select', $select);
    $xtpl->assign('value', $value);
    $xtpl->assign('sort', $array_sort_i);
    $xtpl->parse('main.sort');
  }
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('OPST', $array_op[0]);
  $xtpl->assign('view', "viewcat_page_gird");
  $xtpl->assign('module_name', $module_file);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
  $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
  $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
  $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
  $xtpl->assign('alias', $data_content['alias']);
  $xtpl->assign('catid', $data_content['id']);
  $xtpl->assign('CAT_NAME', $data_content['title']);
  $xtpl->assign('count', $data_content['count']);
  $xtpl->assign('SELECT' . $sort_id, 'selected="selected"');
  if (!empty($data_content['data'])) {
    $i = 1;
    $num_view = $pro_config['per_row'];
    foreach ($data_content['data'] as $data_row) {
      $xtpl->assign('id', $data_row['id']);
      $xtpl->assign('title_pro', $data_row['title']);
      $xtpl->assign('title_pro0', nv_clean60($data_row['title'], 20));
      $xtpl->assign('link_pro', $data_row['link_pro']);
      $a = round((100 - (($data_row['product_discounts']) / ($data_row['product_price'])) * 100));
      //print_r($a);exit();
      $xtpl->assign('sale', $a);
      $xtpl->assign('img_pro', $data_row['homeimgthumb']);
      $xtpl->assign('homeimgfile', $data_row['homeimgfile']);
      $xtpl->assign('link_order', $data_row['link_order']);
      $xtpl->assign('intro', nv_clean60($data_row['hometext'], 100));
      //$xtpl->assign('intro', $data_row['hometext']);
      $xtpl->assign('NUM_VIEW', $data_row['hitstotal']);
      $xtpl->assign('product_price', CurrencyConversion($data_row['product_price'], $data_row['money_unit'], $pro_config['money_unit']));
      if ($pro_config['active_price'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->assign('money_unit', $pro_config['money_unit']);
          if ($data_row['product_discounts'] != 0) {
            //$price_product_discounts = $data_row['product_price'] - ($data_row['product_price'] * ($data_row['product_discounts'] / 100));
            $price_product_discounts = $data_row['product_discounts'];
            $xtpl->assign('product_discounts', CurrencyConversion($price_product_discounts, $data_row['money_unit'], $pro_config['money_unit']));
            $xtpl->assign('class_money', 'ul_li_price1');
            if ($pro_config['active_price'] == '1')
              $xtpl->parse('main.grid_rows.price.discounts');
            $xtpl->parse('main.grid_rows.price1.discounts1');
						$xtpl->parse('main.grid_rows.price');
						$xtpl->parse('main.grid_rows.price1');
          } else {
						$xtpl->parse('main.grid_rows.price2');
            $xtpl->assign('class_money', 'ul_li_price');
          }
        } else {
          $xtpl->parse('main.grid_rows.contact');
        }
      }
      //zsize
      $sql2 = "SELECT size FROM `vng_shops_size` WHERE product_id = " . $data_row["id"];
      $result = $db->sql_query($sql2);
      $size = array();
      $check_size = false;
      while ($row = $db->sql_fetch_assoc($result)) {
        $check_size = true;
        $size[] = $row["size"];
      }
      if ($check_size) {
        $size_string = "Size (" . implode(", ", $size) . ")";
        $xtpl->assign('size', $size_string);
        $xtpl->parse('main.row.size');
      } else {
        $xtpl->parse('main.row.nosize');
      }

      $pwidth = (int) (100 / $num_view);
      if ($i % $pro_config['per_row'] == 0) {
        $pwidth = 100 - ((int) (100 / $num_view)) * ($i - 1);
        $i = 0;
      } else {
        $pwidth = (int) (100 / $num_view);
      }
      $xtpl->assign('pwidth', $pwidth);
      $xtpl->assign('height', $pro_config['homeheight']);
      $xtpl->assign('width', $pro_config['homewidth']);
      if ($i % $num_view == 0)
        $xtpl->parse('main.grid_rows.end_row');
      if ($pro_config['active_order'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->parse('main.grid_rows.order');
        }
      }
      if ($pro_config['active_tooltip'] == 1)
        $xtpl->parse('main.grid_rows.tooltip');
      $xtpl->parse('main.grid_rows');
      $i++;
    }
  }
  $xtpl->assign('pages', $pages);
  $xtpl->assign('LINK_LOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=loadcart");

  if ($pro_config['active_tooltip'] == 1)
    $xtpl->parse('main.tooltip_js');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function viewcat_page_list($data_content, $pages) {
  global $db, $module_info, $lang_module, $module_file, $module_name, $pro_config, $sort_id, $array_op, $global_array_cat;
  $xtpl = new XTemplate("view_list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('TITLE_CATALOG', $global_array_cat[$data_content['id']]['title']);
  $xtpl->assign('LINK_CATALOG', $global_array_cat[$data_content['id']]['link']);
  $xtpl->assign('IMG_CATALOG', $global_array_cat[$data_content['id']]['image']);
  $xtpl->assign('ICON_CATALOG', $global_array_cat[$data_content['id']]['icon']);
  $xtpl->assign('DES_CATALOG', $global_array_cat[$data_content['id']]['description']);
  $array_sub = explode(",", $global_array_cat[$data_content['id']]['subcatid']);
  $i = 0;
  $a = 1;
  foreach ($array_sub as $sub) {
    //if ( $i >= 4 ) break;
    if (!empty($global_array_cat[$sub])) {
      if ($a != 1) {
        $xtpl->assign('li', 'li');
      } else {
        $xtpl->assign('li', '');
      }
      $xtpl->assign("SUB", $global_array_cat[$sub]);
      $xtpl->parse('main.sub');
      $i++;
      $a++;
    }
  }

  $array_sort = array($lang_module['sort1'], $lang_module['sort2'], $lang_module['sort3'], $lang_module['sort4']);
  foreach ($array_sort as $array_sort_i => $value) {
    if ($array_sort_i + 1 == $sort_id)
      $select = "selected='selected'";
    else
      $select = "";
    $xtpl->assign('select', $select);
    $xtpl->assign('value', $value);
    $xtpl->assign('sort', $array_sort_i + 1);
    $xtpl->parse('main.sort');
  }
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('OPST', $array_op[0]);
  $xtpl->assign('view', "viewcat_page_list");
  $xtpl->assign('module_name', $module_file);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
  $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
  $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
  $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
  $xtpl->assign('alias', $data_content['alias']);
  $xtpl->assign('catid', $data_content['id']);

  $xtpl->assign('CAT_NAME', $data_content['title']);
  $xtpl->assign('SELECT' . $sort_id, 'selected="selected"');
  $xtpl->assign('link_order_all', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=setcart");

  $xtpl->assign('count', $data_content['count']);
  if (!empty($data_content['data'])) {
    foreach ($data_content['data'] as $data_row) {
      //print_r($data_row);exit();
      $xtpl->assign('id', $data_row['id']);

      $xtpl->assign('title_pro', nv_clean60($data_row['title'], 40));
      $xtpl->assign('link_pro', $data_row['link_pro']);
      $a = round((100 - (($data_row['product_discounts']) / ($data_row['product_price'])) * 100));
      //print_r($a);exit();
      $xtpl->assign('sale', $a);
      $xtpl->assign('img_pro', $data_row['homeimgthumb']);
      $xtpl->assign('homeimgfile', $data_row['homeimgfile']);
      $xtpl->assign('link_order', $data_row['link_order']);
      $xtpl->assign('intro', nv_clean60($data_row['hometext'], 100));
      //$xtpl->assign('intro',$data_row['hometext']);
      //print_r($data_row);exit();
      //$xtpl->assign('codesp', $data_row['codesp']);

      $xtpl->assign('product_price', CurrencyConversion($data_row['product_price'], $data_row['money_unit'], $pro_config['money_unit']));
      $xtpl->assign('id', $data_row['id']);
      if ($pro_config['active_price'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->assign('money_unit', $pro_config['money_unit']);
          if ($data_row['product_discounts'] != 0) {
            //$price_product_discounts = $data_row['product_price'] - ($data_row['product_price'] * ($data_row['product_discounts'] / 100));
            $price_product_discounts = $data_row['product_discounts'];
            $xtpl->assign('product_discounts', CurrencyConversion($price_product_discounts, $data_row['money_unit'], $pro_config['money_unit']));
            $xtpl->assign('class_money', 'ul_li_price1');
            $xtpl->parse('main.row.price.discounts');
            $xtpl->parse('main.row.price1.discounts1');
            $xtpl->parse('main.row.price');
            $xtpl->parse('main.row.price1');
          } else {
            $xtpl->parse('main.row.price2');
            $xtpl->assign('class_money', 'ul_li_price');
          }
        } else {
          $xtpl->parse('main.row.contact');
        }
      }
      $xtpl->assign('address', $data_row['address']);
      $xtpl->assign('height', $pro_config['homeheight']);
      $xtpl->assign('width', $pro_config['homewidth']);
      $xtpl->assign('publtime', $lang_module['detail_dateup'] . " " . nv_date('d-m-Y h:i:s A', $data_row['publtime']));
      if ($pro_config['active_order'] == '1') {
        if ($data_row['showprice'] == '1') {
          $xtpl->parse('main.row.order');
        }
      }
      //zsize
      $sql2 = "SELECT size FROM `vng_shops_size` WHERE product_id = " . $data_row["id"];
      $result = $db->sql_query($sql2);
      $size = array();
      $check_size = false;
      while ($row = $db->sql_fetch_assoc($result)) {
        $check_size = true;
        $size[] = $row["size"];
      }
      if ($check_size) {
        $size_string = "Size (" . implode(", ", $size) . ")";
        $xtpl->assign('size', $size_string);
        $xtpl->parse('main.row.size');
      } else {
        $xtpl->parse('main.row.nosize');
      }
      if ($pro_config['active_tooltip'] == 1)
        $xtpl->parse('main.row.tooltip');
      $xtpl->parse('main.row');
    }
  }
  $xtpl->assign('pages', $pages);
  $xtpl->assign('LINK_LOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=loadcart");
  if ($pro_config['active_tooltip'] == 1)
    $xtpl->parse('main.tooltip_js');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function detail_product($data_content, $data_unit, $data_comment, $num_comment, $data_others, $data_shop, $array_other_view) {
  global /* zsize */$db_config, $db, $module_info, $lang_module, $module_file, $global_config, $module_name, $my_head, $pro_config, $module_data, $array_op, $global_array_source;
  if (!defined('SHADOWBOX')) {
    $my_head .= "<link rel=\"Stylesheet\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
    $my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
    $my_head .= "<script type=\"text/javascript\">Shadowbox.init({ handleOversize: \"drag\" });</script>";
    define('SHADOWBOX', true);
  }
  $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=";
  $link2 = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
  $xtpl = new XTemplate("detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  if (!empty($data_content)) {
    // zsize
    $sql = "SELECT * from `" . $db_config['prefix'] . "_" . $module_data . "_size` where product_id = " . $data_content["id"] . " ORDER BY `product_price` ASC";
    $result = $db->sql_query($sql);
    $html_size = "";
    $size_check = false;
    $size_min = 0;
    $price_min = 0;
    while ($row = $db->sql_fetch_assoc($result)) {
      $size_check = true;
      if ($price_min == 0 || $row['product_price'] < $price_min) {
        $size_min = $row['size'];
        $price_min = $row['product_price'];
        $html_size .= "<div class='size_box selected' id=\"size_box_" . $row["size"] . "\" onclick=\"nv_change_size('" . $row["size"] . "', " . $row['product_price'] . ")\"><div class='size_name'>" . $row['size'] . "</div><div class='size_price'>" . $row['product_price'] . "</div></div>";
      } else {
        $html_size .= "<div class='size_box' id=\"size_box_" . $row["size"] . "\" onclick=\"nv_change_size('" . $row["size"] . "', " . $row['product_price'] . ")\"><div class='size_name'>" . $row['size'] . "</div><div class='size_price'>" . $row['product_price'] . "</div></div>";
      }
    }
    $xtpl->assign('html_size', $html_size);

    $link_view = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $array_op[0] . "/" . $data_content[NV_LANG_DATA . '_alias'] . "-" . $data_content['id'];
    //print_r($data_content);exit();
    if (!empty($data_content['vi_detailpromotional'])) {
      $xtpl->assign('khuyenmaichitiet', $data_content['vi_detailpromotional']);
    } else {
      $xtpl->assign('khuyenmaichitiet', 'Đang cập nhật...');
    }
    $xtpl->assign('proid', $data_content['id']);
    $data_content['money_unit'] = ($data_content['money_unit'] != "") ? $data_content['money_unit'] : "N/A";
    $data_content[NV_LANG_DATA . '_address'] = ($data_content[NV_LANG_DATA . '_address'] != "") ? $data_content[NV_LANG_DATA . '_address'] : "N/A";
    $xtpl->assign('SRC_PRO', $data_content['homeimgfile']);
    $xtpl->assign('maps', $data_content['vi_maps']);
    //	$xtpl->assign('hometext', $data_content['vi_maps']);
    $xtpl->assign('SRC_PRO_LAGE', $data_content['homeimgfile']);
    $xtpl->assign('TITLE', $data_content[NV_LANG_DATA . '_title']);
    $xtpl->assign('masp', $data_content[NV_LANG_DATA . '_codesp']);
    $xtpl->assign('NUM_VIEW', $data_content['hitstotal']);
    $xtpl->assign('DATE_UP', $lang_module['detail_dateup'] . " " . nv_date('d-m-Y h:i:s A', $data_content['publtime']));
    $xtpl->assign('DETAIL', $data_content[NV_LANG_DATA . '_bodytext']);
    $xtpl->assign('LINK_ORDER', $link2 . "setcart&id=" . $data_content['id']);
    //print_r( $link_view);exit();
    $xtpl->assign('link_view', $link_view);
    $xtpl->assign('NUM_PRO', $data_content['product_number']);
    $xtpl->assign('product_price', CurrencyConversion($data_content['product_price'], $data_content['money_unit'], $pro_config['money_unit']));
    $xtpl->assign('money_unit', $pro_config['money_unit']);
    if (!empty($data_content[NV_LANG_DATA . '_promotional'])) {
      $xtpl->assign('promotional', $data_content[NV_LANG_DATA . '_promotional']);
      $xtpl->parse('main.promotional');
    }
    if (!empty($data_content[NV_LANG_DATA . '_warranty'])) {
      $xtpl->assign('warranty', $data_content[NV_LANG_DATA . '_warranty']);
      $xtpl->parse('main.warranty');
    }
    if (!empty($data_content[NV_LANG_DATA . '_note'])) {
      $xtpl->assign('note', $data_content[NV_LANG_DATA . '_note']);
      $xtpl->parse('main.note');
    }
    if (!empty($data_content['source'])) {
      $xtpl->assign('source', $data_content['source']);
      //print_r($global_array_source);die();
      $xtpl->assign('link_source', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $global_array_source[$data_content['source_id']]['alias']);
      $xtpl->parse('main.source');
    }


    if (!empty($data_content[NV_LANG_DATA . '_codesp'])) {
      $xtpl->assign('codesp', $data_content[NV_LANG_DATA . '_codesp']);
      $xtpl->parse('main.codesp');
    }

    //zsize
    if ($size_check) {
      $xtpl->assign('size_min', $size_min);
      $xtpl->assign('price_min', CurrencyConversion($price_min, $data_content['money_unit'], $pro_config['money_unit']));
      $xtpl->parse('main.size_prince');
    } else {
      if ($pro_config['active_price'] == '1' && $data_content['showprice'] == '1') {
        if ($data_content['product_discounts'] != 0) {
          //$price_product_discounts = $data_content['product_price'] - ($data_content['product_price'] * ($data_content['product_discounts'] / 100));
          $perdiscounts = round(( $data_content['product_price'] - $data_content['product_discounts'] ) / $data_content['product_price'] * 100);
          $price_product_discounts = $data_content['product_discounts'];
          $imgsale = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/sale_off.png";
          $xtpl->assign('product_discounts', CurrencyConversion($price_product_discounts, $data_content['money_unit'], $pro_config['money_unit']));
          $product_price_end = $data_content['product_price'] - $price_product_discounts;
          $xtpl->assign('product_price_end', CurrencyConversion($product_price_end, $data_content['money_unit'], $pro_config['money_unit']));
          $xtpl->assign('class_money', '');
          $xtpl->assign('SALE', $perdiscounts . "%");
          $xtpl->assign('IMGSALE', $imgsale);
          $xtpl->parse('main.deal');
          $xtpl->parse('main.discounts_end');
          $xtpl->parse('main.discounts');
        } else {
          $xtpl->assign('class_money', 'product_info_price');
        }

        //		if ($data_content['showprice'] == '1')
        $xtpl->parse('main.price');
        //else
      } else {
        $xtpl->parse('main.contact');
      }
    }
    if ($data_content['product_number'] > 0) {
      $xtpl->assign('conhang', 'Còn Hàng');
      $xtpl->parse('main.number_on');
    } else {
      $xtpl->assign('hethang', 'Hết Hàng');
      $xtpl->parse('main.number_off');
    }
    $xtpl->assign('pro_unit', $data_unit['title']);
    $xtpl->assign('address', $data_content[NV_LANG_DATA . '_address']);
    $xtpl->assign('product_number', $data_content['product_number']);
    $exptime = ($data_content['exptime'] != 0) ? date("d-m-Y", $data_content['exptime']) : "N/A";
    $xtpl->assign('exptime', $exptime);
    $xtpl->assign('height', $pro_config['homeheight']);
    $xtpl->assign('width', $pro_config['homewidth']);
    $xtpl->assign('RATE', $data_content['ratingdetail']);
    $xtpl->assign('detail_note', $pro_config['detail_note']);
    $xtpl->assign('detail_note2', $pro_config['detail_note2']);
    $xtpl->assign('detail_tel', $pro_config['detail_tel']);
    $xtpl->assign('detail_email', $pro_config['detail_email']);
    if ($pro_config['active_showhomtext'] == "1") {
      $xtpl->assign('hometext', nv_clean60($data_content[NV_LANG_DATA . '_hometext'], 300));
      $xtpl->parse('main.hometext');
    }
    if (!empty($data_content['otherimage'])) {
      $otherimage = explode("|", $data_content['otherimage']);
    } else {
      $otherimage = array();
    }
    $k = 2;
    if (!empty($otherimage)) {
      foreach ($otherimage as $otherimage_i) {
        if (!empty($otherimage_i) and file_exists(NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $otherimage_i)) {
          $otherimage_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $otherimage_i;
          $xtpl->assign('IMG_SRC_OTHER', $otherimage_i);
          $xtpl->assign('k', $k);
          $xtpl->parse('main.othersimg');
          $xtpl->parse('main.othersimg1');
          $k++;
        }
      }
    }
  }
  //print_r( $link_view);exit();
  if ($pro_config['active_comfb'] == 1) {
    $xtpl->assign('link_commentfb', "http://" . $global_config['my_domains'][0] . $link_view);
    //print_r($global_config['my_domains'][0]);exit();
    $xtpl->parse('main.commentfb');
  } else {
    if ($pro_config['comment'] == "1") {
      if (!empty($data_comment)) {
        foreach ($data_comment as $cdata) {
          $xtpl->assign('username', $cdata['post_name']);
          $xtpl->assign('avata', $cdata['photo']);
          $xtpl->assign('content', $cdata['content']);
          $xtpl->assign('date_up', nv_date('d-m-Y h:i:s A', $cdata['post_time']));
          $xtpl->parse('main.comment.list');
        }
      }
      $xtpl->parse('main.comment');
    }
  }
  $xtpl->assign('link_addcomment', $link2 . "addcomment");
  $xtpl->assign('num_comment', $num_comment);
  $xtpl->assign('link_shop_re', $link . "=detail/" . $data_content['id'] . "/" . $data_content[NV_LANG_DATA . '_alias']);

  if (!empty($data_others)) {
    $hmtl = view_home_all($data_others);
    $xtpl->assign('OTHER', $hmtl);
    $xtpl->parse('main.other');
  }
  if (!empty($array_other_view)) {
    $hmtl = view_home_all($array_other_view);
    $xtpl->assign('OTHER_VIEW', $hmtl);
    $xtpl->parse('main.other_view');
  }

  $xtpl->assign('LINK_LOAD', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=loadcart");
  $xtpl->assign('THEME_URL', NV_BASE_SITEURL . "themes/" . $module_info['template']);
  $xtpl->assign('LINK_PRINT', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=print_pro&id=" . $data_content['id']);
  $xtpl->assign('LINK_RATE', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=rate&id=" . $data_content['id']);

  if (!empty($data_shop)) {
    $xtpl->assign('title_shop', $data_shop[NV_LANG_DATA . '_title']);
    $xtpl->assign('link_shop', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=estore&amp;" . NV_OP_VARIABLE . "=shop/" . $data_shop['alias'] . "-" . $data_shop['com_id']);
    $xtpl->parse('main.shop');
  }

  if ($pro_config['active_order_number'] == '0')
    $xtpl->parse('main.num');
  if ($pro_config['active_order'] == '1') {
    if ($data_content['showprice'] == '1') {
      $xtpl->parse('main.order');
    }
  }
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function print_product($data_content, $data_unit, $page_title) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $my_head, $pro_config;
  $xtpl = new XTemplate("print_pro.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  if (!empty($data_content)) {
    $xtpl->assign('proid', $data_content['id']);
    $data_content['money_unit'] = ($data_content['money_unit'] != "") ? $data_content['money_unit'] : "N/A";
    $data_content[NV_LANG_DATA . '_address'] = ($data_content[NV_LANG_DATA . '_address'] != "") ? $data_content[NV_LANG_DATA . '_address'] : "N/A";
    $xtpl->assign('SRC_PRO', $data_content['homeimgthumb']);
    $xtpl->assign('SRC_PRO_LAGE', $data_content['homeimgthumb']);
    $xtpl->assign('TITLE', $data_content[NV_LANG_DATA . '_title']);
    $xtpl->assign('NUM_VIEW', $data_content['hitstotal']);
    $xtpl->assign('DATE_UP', $lang_module['detail_dateup'] . date(' d-m-Y ', $data_content['addtime']) . $lang_module['detail_moment'] . date(" h:i'", $data_content['addtime']));
    $xtpl->assign('DETAIL', $data_content[NV_LANG_DATA . '_bodytext']);
    $xtpl->assign('product_price', CurrencyConversion($data_content['product_price'], $data_content['money_unit'], $pro_config['money_unit']));
    $xtpl->assign('money_unit', $pro_config['money_unit']);
    $xtpl->assign('pro_unit', $data_unit['title']);
    $xtpl->assign('address', $data_content[NV_LANG_DATA . '_address']);
    $xtpl->assign('product_number', $data_content['product_number']);
    $exptime = ($data_content['exptime'] != 0) ? date("d-m-Y", $data_content['exptime']) : "N/A";
    $xtpl->assign('exptime', $exptime);
    $xtpl->assign('height', $pro_config['homeheight']);
    $xtpl->assign('width', $pro_config['homewidth']);

    $link_url = $global_config['site_url'] . '/' . "?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=detail/" . $data_content['id'] . "/" . $data_content[NV_LANG_DATA . '_alias'] . "";
    $xtpl->assign('link_url', $link_url);
    $xtpl->assign('site_name', $global_config['site_name']);
    $xtpl->assign('url', $global_config['site_url']);
    $xtpl->assign('contact', $global_config['site_email']);
    $xtpl->assign('page_title', $page_title);
  }
  if ($pro_config['active_price'] == '1')
    $xtpl->parse('main.price');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function cart_product($data_content, $array_error_number) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $db, $db_config, $module_data;
  $xtpl = new XTemplate("cart.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $price_total = 0;
  $i = 1;
  //color
  $array_color_cat = array();
  $sql = "SELECT `cid`, `title` FROM `" . $db_config['prefix'] . "_" . $module_data . "_color` ORDER BY `weight` ASC";
  $result = $db->sql_query($sql);
  while (list( $cid_i, $title_i ) = $db->sql_fetchrow($result)) {
    $array_color_cat[$cid_i] = $title_i;
  }

  if (!empty($data_content)) {
    $idcolor = array();
    foreach ($data_content as $data_row) {
      $xtpl->assign('id', $data_row['id']);
      //color

      if (!empty($data_row['color_id']) && ($data_row != ",")) {
        $colorhtm = "";
        $array_color = array();
        $array_color = explode(",", $data_row['color_id']);
        if (count($array_color_cat) > 0) {
          foreach ($array_color_cat as $cid_i => $cid_title) {
            if (in_array($cid_i, $array_color)) {
              $colorhtm .= "<option value = \"" . $cid_i . "\">" . $cid_title . "</option>";
            }
          }

          $idcolor[] = $data_row['id'];
          $xtpl->assign('row_color', $colorhtm);
          $xtpl->parse('main.rows.color');
        }
      }

      $xtpl->assign('stt', $i);

      $xtpl->assign('title_pro', $data_row['title']);
      $xtpl->assign('link_pro', $data_row['link_pro']);
      $xtpl->assign('img_pro', $data_row['homeimgthumb']);
      $note = str_replace("|", ", ", $data_row['note']);
      $xtpl->assign('note', nv_clean60($note, 50));
      $price_product_discounts = $data_row['product_price'] - ( $data_row['product_price'] * ( $data_row['product_discounts'] / 100 ) );
      //die($data_row['product_price']."=" .$data_row['product_discounts'] );
      $price_product_discounts = CurrencyConversionToNumber($price_product_discounts, $data_row['money_unit'], $pro_config['money_unit']);
      $xtpl->assign('pro_num', $data_row['num']);
      $xtpl->assign('product_unit', $data_row['product_unit']);
      $xtpl->assign('link_remove', $data_row['link_remove']);
      $bg = ( $i % 2 == 0 ) ? "class=\"bg\"" : "";
      $xtpl->assign('bg', $bg);
      // zsize
      if ($data_row['zsize'] != "") {
        $xtpl->assign('product_price', FormatNumber($data_row['zprice'], 0, "", ""));
        $xtpl->assign('product_note', "Size: " . $data_row['zsize']);
      } else {
        if ($data_row['product_discounts'] != 0) {
          $xtpl->assign('product_price', FormatNumber($data_row['product_discounts'], 0, "", ""));
        } else {
          $xtpl->assign('product_price', FormatNumber($data_row['product_price'], 0, "", ""));
        }
      }
      if ($pro_config['active_price'] == '1')
        $xtpl->parse('main.rows.price2');
      if ($pro_config['active_order_number'] == '0')
        $xtpl->parse('main.rows.num2');
      $xtpl->parse('main.rows');
      $price_total = $price_total + (double) ( $price_product_discounts ) * (int) ( $data_row['num'] );
      $i ++;
    }
  }

  $xtpl->assign('a', $idcolor);
  if (!empty($array_error_number)) {
    foreach ($array_error_number as $title_error) {
      $xtpl->assign('ERROR_NUMBER_PRODUCT', $title_error);
      $xtpl->parse('main.errortitle.errorloop');
    }
    $xtpl->parse('main.errortitle');
  }
  $xtpl->assign('price_total', FormatNumber($price_total, 2, '.', ','));
  $xtpl->assign('unit_config', $pro_config['money_unit']);
  $xtpl->assign('LINK_DEL_ALL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=remove");
  $xtpl->assign('LINK_CART', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cart");
  $xtpl->assign('LINK_PRODUCTS', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "");
  $xtpl->assign('link_order_all', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=order");
  if ($pro_config['active_price'] == '1')
    $xtpl->parse('main.price1');
  if ($pro_config['active_order_number'] == '0') {
    $xtpl->parse('main.num1');
    $xtpl->parse('main.num4');
  }
  if ($pro_config['active_price'] == '1' && $pro_config['active_order_number'] == '0')
    $xtpl->parse('main.price3');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function uers_order($data_content, $data_order, $error) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $global_array_color;
  $xtpl = new XTemplate("order.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  $price_total = 0;
  $i = 1;
  if (!empty($data_content)) {
    foreach ($data_content as $data_row) {
      $xtpl->assign('id', $data_row['id']);
      $xtpl->assign('title_pro', $data_row['title']);
      $xtpl->assign('link_pro', $data_row['link_pro']);
      $note = str_replace("|", ", ", $data_row['note']);
      $xtpl->assign('note', nv_clean60($note, 50));
      //$price_product_discounts = $data_row['product_price'] - ($data_row['product_price'] * ($data_row['product_discounts'] / 100));
      if ($data_row['product_discounts'] > 0) {
        $price_product_discounts = $data_row['product_discounts'];
      } else {
        $price_product_discounts = $data_row['product_price'];
      }
      $price_product_discounts = CurrencyConversionToNumber($price_product_discounts, $data_row['money_unit'], $pro_config['money_unit']);
      $xtpl->assign('product_price', FormatNumber($price_product_discounts, 0, "", ""));
      if ($data_row['color'] != 0)
        $xtpl->assign('color', $global_array_color[$data_row['color']]['title']);
      else
        $xtpl->assign('color', '---');
      $xtpl->assign('pro_num', $data_row['num']);
      $xtpl->assign('product_unit', $data_row['product_unit']);
      $xtpl->assign('pro_no', $i);
      $bg = ($i % 2 == 0) ? "class=\"bg\"" : "";
      $xtpl->assign('bg', $bg);
      if ($pro_config['active_price'] == '1')
        $xtpl->parse('main.rows.price2');
      if ($pro_config['active_order_number'] == '0')
        $xtpl->parse('main.rows.num2');
      $xtpl->parse('main.rows');
      $price_total = $price_total + (double) ($price_product_discounts) * (int) ($data_row['num']);
      $i++;
    }
  }
  $xtpl->assign('price_total', FormatNumber($price_total, 2, '.', ','));
  $xtpl->assign('unit_config', $pro_config['money_unit']);
  $xtpl->assign('DATA', $data_order);
  $xtpl->assign('ERROR', $error);
  $xtpl->assign('LINK_CART', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cart");
  if ($pro_config['active_price'] == '1')
    $xtpl->parse('main.price1');
  if ($pro_config['active_order_number'] == '0')
    $xtpl->parse('main.num1');
  if ($pro_config['active_price'] == '1' && $pro_config['active_order_number'] == '0')
    $xtpl->parse('main.price3');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function payment($data_content, $data_pro, $url_checkout, $intro_pay) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $global_array_color;
  $xtpl = new XTemplate("payment.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('dateup', date("d-m-Y", $data_content['order_time']));
  $xtpl->assign('moment', date("h:i' ", $data_content['order_time']));
  $xtpl->assign('DATA', $data_content);
  $xtpl->assign('order_id', $data_content['order_id']);
  ////////////////////////////////////////////////////////
  $i = 0;
  foreach ($data_pro as $pdata) {
    $xtpl->assign('product_name', $pdata['title']);
    $xtpl->assign('product_number', $pdata['product_number']);
    $xtpl->assign('product_price', FormatNumber($pdata['product_price'], 2, '.', ','));
    $xtpl->assign('product_unit', $pdata['product_unit']);
    $xtpl->assign('product_note', $pdata['product_note']);
    $xtpl->assign('link_pro', $pdata['link_pro']);
    $xtpl->assign('pro_no', $i + 1);
    $xtpl->assign('product_note', "Size: " . $pdata['size']);
    if (!empty($pdata['color']))
      $xtpl->assign('color', $pdata['color']);
    else
      $xtpl->assign('color', '---');
    $bg = ($i % 2 == 0) ? "class=\"bg\"" : "";
    $xtpl->assign('bg', $bg);
    if ($pro_config['active_price'] == '1')
      $xtpl->parse('main.loop.price2');
    if ($pro_config['active_order_number'] == '0')
      $xtpl->parse('main.loop.num2');
    $xtpl->parse('main.loop');
    $i++;
  }
  if (!empty($data_content['order_note'])) {
    $xtpl->parse('main.order_note');
  }
  $xtpl->assign('order_total', FormatNumber($data_content['order_total'], 2, '.', ','));
  $xtpl->assign('unit', $data_content['unit_total']);
  if (!empty($url_checkout)) {
    $xtpl->assign('note_pay', '');
    foreach ($url_checkout as $value) {
      $xtpl->assign('DATA_PAYMENT', $value);
      $xtpl->parse('main.actpay.payment.paymentloop');
    }
    $xtpl->parse('main.actpay.payment');
  }
  $xtpl->assign('intro_pay', $intro_pay);
  if ($pro_config['active_payment'] == '1' && $pro_config['active_order'] == '1' && $pro_config['active_price'] == '1' && $pro_config['active_order_number'] == '0')
    $xtpl->parse('main.actpay');
  $xtpl->assign('url_finsh', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name);
  $xtpl->assign('url_print', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=print&order_id=" . $data_content['order_id'] . "&checkss=" . md5($data_content['order_id'] . $global_config['sitekey'] . session_id()));
  if ($pro_config['active_price'] == '1')
    $xtpl->parse('main.price1');
  if ($pro_config['active_order_number'] == '0')
    $xtpl->parse('main.num1');
  if ($pro_config['active_price'] == '1' && $pro_config['active_order_number'] == '0')
    $xtpl->parse('main.price3');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function print_pay($data_content, $data_pro) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config;
  $xtpl = new XTemplate("print.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('dateup', date("d-m-Y", $data_content['order_time']));
  $xtpl->assign('moment', date("h:i' ", $data_content['order_time']));
  $xtpl->assign('DATA', $data_content);
  $xtpl->assign('order_id', $data_content['id']);
  ////////////////////////////////////////////////////////
  $i = 0;
  foreach ($data_pro as $pdata) {
    $xtpl->assign('product_name', $pdata['title']);
    $xtpl->assign('product_number', $pdata['product_number']);
    $xtpl->assign('product_price', FormatNumber($pdata['product_price'], 2, '.', ','));
    $xtpl->assign('product_unit', $pdata['product_unit']);
    $xtpl->assign('product_note', $pdata['product_note']);
    $xtpl->assign('link_pro', $pdata['link_pro']);
    $xtpl->assign('pro_no', $i + 1);
    $bg = ($i % 2 == 0) ? "class=\"bg\"" : "";
    $xtpl->assign('bg', $bg);
    if ($pro_config['active_price'] == '1')
      $xtpl->parse('main.loop.price2');
    if ($pro_config['active_order_number'] == '0')
      $xtpl->parse('main.loop.num2');
    $xtpl->parse('main.loop');
    $i++;
  }
  if (!empty($data_content['order_note'])) {
    $xtpl->parse('main.order_note');
  }
  $xtpl->assign('order_total', FormatNumber($data_content['order_total'], 2, '.', ','));
  $xtpl->assign('unit', $data_content['unit_total']);

  $payment = "";
  if ($data_content['transaction_status'] == 4) {
    $payment = $lang_module['history_payment_yes'];
  } elseif ($data_content['transaction_status'] == 3) {
    $payment = $lang_module['history_payment_cancel'];
  } elseif ($data_content['transaction_status'] == 2) {
    $payment = $lang_module['history_payment_check'];
  } elseif ($data_content['transaction_status'] == 1) {
    $payment = $lang_module['history_payment_send'];
  } elseif ($data_content['transaction_status'] == 0) {
    $payment = $lang_module['history_payment_no'];
  } elseif ($data_content['transaction_status'] == -1) {
    $payment = $lang_module['history_payment_wait'];
  } else {
    $payment = "ERROR";
  }
  $xtpl->assign('payment', $payment);
  if ($pro_config['active_price'] == '1')
    $xtpl->parse('main.price1');
  if ($pro_config['active_order_number'] == '0')
    $xtpl->parse('main.num1');
  if ($pro_config['active_price'] == '1' && $pro_config['active_order_number'] == '0')
    $xtpl->parse('main.price3');
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function history_order($data_content, $link_check_order) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config;
  $xtpl = new XTemplate("history_order.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $i = 0;

  foreach ($data_content as $data_row) {
    $xtpl->assign('order_code', $data_row['order_code']);
    $xtpl->assign('history_date', date("d-m-Y", $data_row['order_time']));
    $xtpl->assign('history_moment', date("h:i' ", $data_row['order_time']));
    $xtpl->assign('history_total', FormatNumber($data_row['order_total'], 2, '.', ','));
    $xtpl->assign('unit_total', $data_row['unit_total']);
    $xtpl->assign('note', $data_row['order_note']);
    $xtpl->assign('URL_DEL_BACK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=history");
    if (intval($data_row['transaction_status']) == -1) {
      $xtpl->assign('text_no_remove', "");
      $xtpl->assign('link_remove', $data_row['link_remove']);
      $xtpl->parse('main.rows.remove');
    } else {
      $xtpl->assign('text_no_remove', '');
    }
    $xtpl->assign('link', $data_row['link']);

    /* transaction_status: Trang thai giao dich:
      0 - Giao dich moi tao
      1 - Chua thanh toan;
      2 - Da thanh toan, dang bi tam giu;
      3 - Giao dich bi huy;
      4 - Giao dich da hoan thanh thanh cong (truong hop thanh toan ngay hoac thanh toan tam giu nhung nguoi mua da phe chuan)
     */
    if ($data_row['transaction_status'] == 4) {
      $history_payment = $lang_module['history_payment_yes'];
    } elseif ($data_row['transaction_status'] == 3) {
      $history_payment = $lang_module['history_payment_cancel'];
    } elseif ($data_row['transaction_status'] == 2) {
      $history_payment = $lang_module['history_payment_check'];
    } elseif ($data_row['transaction_status'] == 1) {
      $history_payment = $lang_module['history_payment_send'];
    } elseif ($data_row['transaction_status'] == 0) {
      $history_payment = $lang_module['history_payment_no'];
    } elseif ($data_row['transaction_status'] == -1) {
      $history_payment = $lang_module['history_payment_wait'];
    } else {
      $history_payment = "ERROR";
    }

    $xtpl->assign('LINK_CHECK_ORDER', $link_check_order);
    $xtpl->assign('history_payment', $history_payment);
    $bg = ($i % 2 == 0) ? "class=\"bg\"" : "";
    $xtpl->assign('bg', $bg);
    $xtpl->assign('TT', $i + 1);
    if ($pro_config['active_price'] == '1')
      $xtpl->parse('main.rows.price2');
    $xtpl->parse('main.rows');
    $i++;
  }
  if ($pro_config['active_price'] == '1') {
    $xtpl->parse('main.price1');
  }
  $xtpl->parse('main');
  return $xtpl->text('main');
}

//// search.php
function search_theme($key, $check_num, $date_array, $array_cat_search) {
  global $module_name, $module_info, $module_file, $global_config, $lang_module, $module_name;
  $xtpl = new XTemplate("search.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $base_url_site = NV_BASE_SITEURL . "?";
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
  $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
  $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
  $xtpl->assign('MODULE_NAME', $module_name);
  $xtpl->assign('BASE_URL_SITE', $base_url_site);
  $xtpl->assign('TO_DATE', $date_array['to_date']);
  $xtpl->assign('FROM_DATE', $date_array['from_date']);
  $xtpl->assign('KEY', $key);
  $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
  $xtpl->assign('OP_NAME', 'search');

  foreach ($array_cat_search as $search_cat) {
    $xtpl->assign('SEARCH_CAT', $search_cat);
    $xtpl->parse('main.search_cat');
  }
  for ($i = 0; $i <= 3; $i++) {
    if ($check_num == $i)
      $xtpl->assign('CHECK' . $i, "selected=\"selected\"");
    else
      $xtpl->assign('CHECK' . $i, "");
  }
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function search_result_theme($key, $numRecord, $per_pages, $pages, $array_content, $url_link, $catid) {
  global $module_file, $module_info, $global_config, $lang_global, $lang_module, $db, $module_name, $global_array_cat;
  $xtpl = new XTemplate("search.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);

  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('KEY', $key);

  $xtpl->assign('TITLE_MOD', $lang_module['search_modul_title']);

  if (!empty($array_content)) {
    foreach ($array_content as $value) {
      $catid_i = ($catid > 0) ? $catid : end(explode(",", $value['listcatid']));
      $url = $global_array_cat[$catid_i]['link'] . '/' . $value['alias'] . "-" . $value['id'];
      $xtpl->assign('LINK', $url);
      $xtpl->assign('TITLEROW', BoldKeywordInStr($value['title'], $key));
      $xtpl->assign('CONTENT', BoldKeywordInStr($value['hometext'], $key) . "...");

      $xtpl->assign('IMG_SRC', $value['homeimgthumb']);
      $xtpl->parse('results.result.result_img');

      $xtpl->parse('results.result');
    }
  }
  if ($numRecord == 0) {
    $xtpl->assign('KEY', $key);
    $xtpl->assign('INMOD', $lang_module['search_modul_title']);
    $xtpl->parse('results.noneresult');
  }
  if ($numRecord > $per_pages) {// show pages
    $url_link = $_SERVER['REQUEST_URI'];
    $in = strpos($url_link, '&page');
    if ($in != 0)
      $url_link = substr($url_link, 0, $in);
    $generate_page = nv_generate_page($url_link, $numRecord, $per_pages, $pages);
    $xtpl->assign('VIEW_PAGES', $generate_page);
    $xtpl->parse('results.pages_result');
  }
  $xtpl->assign('MY_DOMAIN', NV_MY_DOMAIN);
  $xtpl->assign('NUMRECORD', $numRecord);
  $xtpl->parse('results');
  return $xtpl->text('results');
}

function post_product($data_content, $data_cata, $data_catshop, $data_unit, $shopid, $error, $lang_submit) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $money_config;
  $xtpl = new XTemplate("post.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
  if (defined('NV_EDITOR') and function_exists('nv_aleditor')) {
    $editor = nv_aleditor('bodytext', '98%', '150px', $data_content['bodytext']);
  } else {
    $editor = "<textarea style='width:700px' rows='8' name=\"bodytext\" id=\"bodytext\">" . $data_content['bodytext'] . "</textarea>";
  }
  $xtpl->assign('NV_EDITOR', $editor);
  $xtpl->assign('DATA', $data_content);
  if ($data_content['homeimgthumb'] != "") {
    $array_img = explode("|", $data_content['homeimgthumb']);
    if (!empty($array_img[0]) && !nv_is_url($array_img[0])) {
      $array_img[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $array_img[0];
    } else {
      $array_img[0] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/thumb/no_image.jpg";
    }
    $xtpl->assign('img_pro', $array_img[0]);
    $xtpl->parse('main.imgpro');
  }
  if (!empty($data_cata)) {
    foreach ($data_cata as $dcat) {
      $xtpl->assign('catid', $dcat['catid']);
      $xtpl->assign('title', $dcat['title']);
      $xtpl->assign('xtitle', $dcat['xtitle']);
      $xtpl->assign('select', $dcat['select']);
      $xtpl->assign('disabled', $dcat['disabled']);
      $xtpl->parse('main.loop_cata');
    }
  }
  $xtpl->assign('unit_config', $pro_config['money_unit']);
  if (!empty($data_unit)) {
    foreach ($data_unit as $dunit) {
      $xtpl->assign('unitid', $dunit['unitid']);
      $xtpl->assign('utitle', $dunit['title']);
      $xtpl->assign('select', $dunit['select']);
      $xtpl->parse('main.loop_product_unit');
    }
  }
  if (!empty($money_config)) {
    foreach ($money_config as $code => $info) {
      $info['select'] = ($data_content['money_unit'] == $code) ? "selected=\"selected\"" : "";
      $xtpl->assign('MON', $info);
      $xtpl->parse('main.money_unit');
    }
  }
  if ($error != "") {
    $xtpl->assign('info', $error);
    $xtpl->parse('main.error');
  }
  $xtpl->assign('shopid', $shopid);
  $xtpl->assign('lang_submit', $lang_submit);
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function users_profile() {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config, $user_info;

  $xtpl = new XTemplate("profile.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);

  $xtpl->assign('PROFILE_URL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=profile");
  $xtpl->assign('USER_EDIT', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=editinfo");
  $xtpl->assign('USER_CHANGE_PASS', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=changepass");
  $xtpl->assign('USER_LOGOUT', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=logout");
  $xtpl->assign('URL_MYPRO', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=myproduct");

  $data_user = user_get($user_info);
  if (!empty($data_user)) {
    $xtpl->assign('USER', $data_user);
    //print_r($data_user);
    //die();
    $xtpl->parse('main.user');
  }

  $xtpl->parse('main');
  return $xtpl->text('main');
}

function my_product($data_pro, $pages_pro, $page) {
  global $module_info, $lang_module, $module_file, $global_config, $module_name, $pro_config;
  $xtpl = new XTemplate("my_product.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
  $xtpl->assign('LANG', $lang_module);
  $xtpl->assign('TEMPLATE', $module_info['template']);
  $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);

  $xtpl->assign('PROFILE_URL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=profile");
  $xtpl->assign('USER_EDIT', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=users&amp;" . NV_OP_VARIABLE . "=editinfo");

  $xtpl->assign('URL_MYPRO', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=myproduct");

  $i = $page + 1;
  $xtpl->assign('unit_config', $pro_config['money_unit']);

  if (!empty($data_pro)) {
    foreach ($data_pro as $dpro) {
      $xtpl->assign('title_pro', $dpro['title']);
      $xtpl->assign('id', $dpro['id']);
      $xtpl->assign('img_pro', $dpro['homeimgthumb']);
      $xtpl->assign('link_pro', $dpro['link_pro']);
      $xtpl->assign('product_price', FormatNumber($dpro['product_price'], 0, "", ""));
      $xtpl->assign('pro_num', $dpro['product_price']);
      $products_status = ($dpro['status'] == '1') ? $lang_module['profile_products_status_ok'] : $lang_module['profile_products_status_no'];
      $xtpl->assign('products_status', $products_status);
      $xtpl->assign('link_del', $dpro['link_del']);
      $xtpl->assign('link_edit', $dpro['link_edit']);
      $xtpl->assign('no_pro', $i);
      $bg = ($i % 2 == 0) ? "class=\"bg\"" : "";
      $xtpl->assign('bg', $bg);
      $xtpl->parse('main.rows.allow');
      $xtpl->parse('main.rows');
      $i++;
    }
    $xtpl->assign('LINK_BACK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=profile");
  }

  $xtpl->assign('pages_pro', $pages_pro);
  $xtpl->parse('main');
  return $xtpl->text('main');
}

function user_get($user_info) {
  global $lang_module;
  $user_info['gender'] = ($user_info['gender'] == "M") ? $lang_module['male'] : ($user_info['gender'] == 'F' ? $lang_module['female'] : $lang_module['na']);
  $user_info['birthday'] = empty($user_info['birthday']) ? $lang_module['na'] : nv_date('d/m/Y', $user_info['birthday']);
  $user_info['regdate'] = nv_date('d-m-Y', $user_info['regdate']);
  $user_info['website'] = empty($user_info['website']) ? $lang_module['na'] : "<a href=\"" . $user_info['website'] . "\" target=\"_blank\">" . $user_info['website'] . "</a>";
  $user_info['location'] = empty($user_info['location']) ? $lang_module['na'] : $user_info['location'];
  $user_info['yim'] = empty($user_info['yim']) ? $lang_module['na'] : $user_info['yim'];
  $user_info['telephone'] = empty($user_info['telephone']) ? $lang_module['na'] : $user_info['telephone'];
  $user_info['fax'] = empty($user_info['fax']) ? $lang_module['na'] : $user_info['fax'];
  $user_info['mobile'] = empty($user_info['mobile']) ? $lang_module['na'] : $user_info['mobile'];
  $user_info['view_mail'] = empty($user_info['view_mail']) ? $lang_module['no'] : $lang_module['yes'];
  $user_info['last_login'] = empty($user_info['last_login']) ? '' : nv_date('l, d/m/Y H:i', $user_info['last_login']);
  $user_info['current_login'] = nv_date('l, d/m/Y H:i', $user_info['current_login']);
  $user_info['st_login'] = $user_info['st_login'] ? $lang_module['yes'] : $lang_module['no'];
  $user_info['email'] = $user_info['email'] = empty($user_info['email']) ? $lang_module['na'] : $user_info['email'];
  return $user_info;
}
?>