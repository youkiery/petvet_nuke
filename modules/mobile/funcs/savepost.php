<?php

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!');
}

$name = $nv_Request->get_string('name', 'post/get', '');
$uid = $nv_Request->get_string('uid', 'post/get', '');
$age = $nv_Request->get_string('age', 'post/get', '');
$price = $nv_Request->get_string('price', 'post/get', '');
$species = $nv_Request->get_string('species', 'post/get', '');
$kind = $nv_Request->get_string('kind', 'post/get', '');
$vaccine = $nv_Request->get_string('vaccine', 'post/get', '');
$typeid = $nv_Request->get_string('typeid', 'post/get', '');
$pid = $nv_Request->get_string('id', 'post/get', '');
$description = $nv_Request->get_string('description', 'post/get', '');
$files = $nv_Request->get_string('file', 'post/get', '');
$images = $nv_Request->get_array('image', 'post/get', '');
if (!(empty($name)) && $uid >= 0 && $age >= 0 && $price >= 0 && $species >= 0 && $kind >= 0 && $vaccine >= 0 && $typeid >= 0) {
  $id = $pid;
  $result["data"]["status"] = 0;
  if ($species == "undefined") {
    $species = 0;
  }
  if ($kind == "undefined") {
    $kind = 0;
  }
  if (!empty($pid) && $pid !== "undefined") {
    $sql = "UPDATE post set name = '$name', age = $age, description = '$description', price = '$price', vaccine = $vaccine, species = $species, kind = $kind, type = $typeid where id = $pid";
    if (!$db->sql_query($sql)) {
      $pid = 0;
    }
  } else {
    $time = time();
    $sql = "INSERT into post(user, name, age, description, species, kind, price, vaccine, type, sold, time) values($uid, '$name', $age, '$description', $species, $kind, $price, $vaccine, $typeid, 0, $time)";
    $pid = $db->sql_query_insert_id($sql);
  }
  if ($pid) {
    $target_path = "uploads/mobile/";
    $index = 1;
    $length = 0;
    if ($images) {
      $length = count($images);
    }
    if ($length && !empty($images[0])) {
      $image = array();
      for ($i = 0; $i < $length; $i ++) {
        if ($images[$i]) {
          if (strlen($images[$i]) > 100) {
            $save_path = $target_path . $pid . "_" . $i . ".jpg";
            $ifp = fopen( $save_path, 'wb' ); 
            $data = explode( ',', $images[$i] );
            fwrite( $ifp, base64_decode( $data[ 1 ] ) );
            fclose( $ifp ); 
            // $data = base64_decode($images[$i]);
            // if (move_uploaded_file($data, $save_path)) {
            if ($save_path) {
              $image[] = $save_path;
            }
          }
          else {
            if ($images[$i] !== "../assets/imgs/noimage.png") {
              $images[$i] = substr($images[$i], strripos($images[$i] , "/upload"));
              $image[] = $images[$i];
            }
          }
        }
      }
      if (count($image)) {
        $sql = "UPDATE post set image = '" . implode("|", $image) . "' where id = $pid";
        $query = $db->sql_query($sql);
        if ($query) {
          $result["data"]["status"] = 1;
        } else {
          $result["data"]["status"] = 3;
        }
      }
    }
    else {
      $sql = "UPDATE post set image = '' where id = $pid";
      $db->sql_query($sql);
      $result["data"]["status"] = 1;
    }
    // else if ($_FILES && $_FILES['file']['name']) {
    //     $file = $_FILES['file']['name'][0];
    //       $target_path = $target_path . $pid . "_" . $index . ".jpg";

    //   if (move_uploaded_file($_FILES['file']['tmp_name'][0], $target_path)) {
    //     $sql = "UPDATE post set image = '$target_path' where id = $pid";
    //     $query = $db->sql_query($sql);
    //     if ($query) {
    //       $result["data"]["status"] = 1;
    //     }
    //   } else {
    //     $result["data"]["status"] = 3;
    //   }
    // }
  }
  if ($result["data"]["status"]) {
    $result["status"] = 1;
  }
  if ($result["data"]["status"] === 3) {
    $sql = "delete from post where id = $pid";
    $db->sql_query($sql);
  }
  if ($result["data"]["status"] === 1) {
    $result["data"]["id"] = $pid;
    if ($id && $id !== "undefined") {
      $result["data"]["status"] = 2;
    }
    filterorder();
  }
}
