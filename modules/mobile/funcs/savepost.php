<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$uid = $nv_Request->get_string('uid', 'post/get', '');
$name = $nv_Request->get_string('name', 'post/get', '');
$age = $nv_Request->get_string('age', 'post/get', '');
$description = $nv_Request->get_string('description', 'post/get', '');
$price = $nv_Request->get_string('price', 'post/get', '');
$species = $nv_Request->get_string('species', 'post/get', '');
$kind = $nv_Request->get_string('kind', 'post/get', '');
$vaccine = $nv_Request->get_string('vaccine', 'post/get', '');
$typeid = $nv_Request->get_string('typeid', 'post/get', '');
$id = $nv_Request->get_string('id', 'post/get', '');
if (!(empty($name) || empty($name)) && $uid >= 0 && $age >= 0 && $price >= 0 && $species >= 0 && $kind >= 0 && $vaccine >= 0 && $typeid >= 0) {
  if (!empty($id) && $id !== "undefined") {
    $sql = "UPDATE post set name = '$name', age = $age, description = '$description', price = '$price', vaccine = $vaccine, species = $species, kind = $kind, type = $typeid where id = $id";
    // echo $sql;
    if (!$db->sql_query($sql)) {
      $id = 0;
    }
  } else {
    $time = time();
    $sql = "INSERT into post(user, name, age, description, species, kind, price, vaccine, type, sold, time) values($uid, '$name', $age, '$description', $species, $kind, $price, $vaccine, $typeid, 0, $time)";
    $id = $db->sql_query_insert_id($sql);
  }
  // $result["data"]["sql"] = $sql;
  if ($id) {
    $target_path = "uploads/mobile/";
    $index = 1;
    $length = 0;
    if ($_FILES) {
      $length = count($_FILES['file']['name']);
    }
    if ($length) {
      $image = array();
      for ($i = 0; $i < $length; $i ++) {
        $extension = end(explode(".", $file)) ? $extension : "";
        $save_path = $target_path . $id . "_" . $i . "." . $extension;
        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $save_path)) {
          $image[] = $save_path;
        }
      }
      if (count($image)) {
        $sql = "UPDATE post set image = '" . implode("|", $image) . "' where id = $id";
        $query = $db->sql_query($sql);
        if ($query) {
          $result["data"]["status"] = 1;
        } else {
          $result["data"]["status"] = 3;
        }
      }
    } else if ($_FILES && $_FILES['file']['name']) {
      $extension = end(explode(".", $file)) ? $extension : "";
      $target_path = $target_path . $id . "_" . $index . "." . $extension;

      if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        $sql = "UPDATE post set image = '$target_path' where id = $id";
        $query = $db->sql_query($sql);
        if ($query) {
          $result["data"]["status"] = 1;
        }
      } else {
        $result["data"]["status"] = 3;
      }
    } else {
      $result["data"]["status"] = 1;
    }
  }
  // $result["data"]["sql"] = $sql;
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
  if ($result["data"]["status"] === 3) {
    $sql = "delete from post where id = $id";
    $db->sql_query($sql);
  }
  if ($result["data"]["status"] === 1) {
    if ($id && $id !== "undefined") {
      $result["data"]["status"] = 2;
    }
    filterorder();
  }
}
