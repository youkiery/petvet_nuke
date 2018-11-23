<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'post', '');

// $origin = 'http://localhost:8100';
// $allowed_domains = [
//   'http://localhost:8100',
//   'http://localhost:8080',
//   'http://petcoffee:8080'
// ];

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// $arr = array("Chưa tiêm", "1 Mũi", "2 Mũi", "3 Mũi", "4 Mũi", "5 Mũi", "6 Mũi", "7 Mũi", "8 Mũi", "9 Mũi", "10 Mũi", "Nhiều hơn");
// if (in_array($origin, $allowed_domains)) {
// header('Access-Control-Allow-Origin: ' . $origin);
// header('Content-Type: application/json');

$result = array("status" => 0, "data" => "");
$type = array("Cần bán", "Cần mua", "Muốn tặng", "Tìm thú lạc");

if (isset($_GET["action"])) {
  $action = $_GET["action"];
  // $db = new mysqli("localhost", "id1588624_adweb", "Whpl.2412", "id1588624_root");
  // $db_config["dbname"] = "petcoffe_mobile";
  // $db_config["dbuname"] = "petcoffe_mobile";
  // $db_config["dbpass"] = "Ykpl.2412";
  $db_config["dbname"] = "petcoffe";
  $db_config["dbuname"] = "root";
  $db_config["dbpass"] = "";
  $db = new sql_db($db_config);

  $query = $db->sql_query("SET CHARACTER SET 'utf8'");

  // foreach ($arr as $key => $value) {
  //   $sql = "insert into config (name, value) values('vaccine[$key]', '$value')";
  //   $db->sql_query($sql);
  // }
  $sql = "SELECT * FROM `config`";
  $query = $db->sql_query($sql);
  $data = fetchall($db, $query);

  $config = array();

  foreach ($data as $key => $value) {
    $config[$value["name"]][] = $value["value"];
  }
  $sorttype = array("time desc", "time asc", "price asc", "price desc");
  switch ($action) {
    case "getlogin":
      
    if (checkParam(array("id"))) {
        $id = $_GET["id"];
        $sql = "select * from user where id = $id";
        $query = $db->sql_query($sql);

        if ($db->sql_numrows($query)) {
          $row = $db->sql_fetch_assoc($query);
          $result["status"] = 1;
          $result["data"] = array("uid" => $row["id"], "name" => $row["name"], "phone" => $row["phone"], "address" => $row["address"]);
        }
      }
      break;
    case "login":
      if (checkParam(array("username", "password"))) {
        $username = $_GET["username"];
        $password = $_GET["password"];

        $sql = "select * from user where username = '$username'";
        $query = $db->sql_query($sql);
        // echo $sql;
        // var_dump($db->sql_fetch_assoc($query));

        if ($db->sql_numrows($query)) {
          $sql = "select * from user where username = '$username' and password = '$password'";
          $query = $db->sql_query($sql);

          if ($db->sql_numrows($query)) {
            $row = $db->sql_fetch_assoc($query);
            $result["status"] = 3;
            $result["data"] = array("uid" => $row["id"], "name" => $row["name"], "phone" => $row["phone"], "address" => $row["address"]);
          } else {
            $result["status"] = 2;
          }
        } else
          $result["status"] = 1;
      }
      break;
    case "signup":
      if (checkParam(array("username", "password", "name", "phone", "address", "province"))) {
        $username = $_GET["username"];
        $password = $_GET["password"];
        $name = $_GET["name"];
        $phone = $_GET["phone"];
        $address = $_GET["address"];
        $province = $_GET["province"];

        $sql = "select * from user where username = '$username'";
        $query = $db->sql_query($sql);

        if (!$db->sql_numrows($query)) {
          $sql = "insert into user (username, password, name, phone, address, province) values ('$username', '$password', '$name', '$phone', '$address', $province)";
          $id = $db->sql_query_insert_id($sql);

          if ($id) {
            $result["status"] = 2;
            $result["data"] = array("uid" => $id, "name" => $name);
          }
        } else {
          $result["status"] = 1;
        }
      }
      break;
    case "savepost":
      if (checkParam(array("uid", "name", "age", "description", "price", "vaccine", "species", "sort", "type", "typeid"), true)) {
        // var_dump($_POST); die();
        $uid = $_POST["uid"];
        $name = $_POST["name"];
        $age = $_POST["age"];
        $price = $_POST["price"];
        $species = $_POST["species"];
        $kind = $_POST["kind"];
        $vaccine = $_POST["vaccine"];
        $typeid = $_POST["typeid"];
        $description = $_POST["description"];

        if (isset($_POST["id"]) && $_POST["id"] !== "undefined") {
          $result["data"] = 1;
          $id = $_POST["id"];
          $sql = "update post set name = '$name', age = $age, description = '$description', price = '$price', vaccine = $vaccine, species = $species, kind = $kind, type = $typeid where id = $id";
          // $result["data"] = $sql;
          // echo json_encode($result);
          // die();
          if (!$db->sql_query($sql)) {
            $id = 0;
          }
        } else {
          $time = time();
          $sql = "insert into post(user, name, age, description, species, kind, price, vaccine, type, sold, time) values($uid, '$name', $age, '$description', $species, $kind, $price, $vaccine, $typeid, 0, $time)";
        //   echo $sql;
          $id = $db->sql_query_insert_id($sql);
        }
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
              } else {
                $result["status"] = 4;
                $result["data"] .= "There was an error uploading the file, please try again!";
              }
            }
            if (count($image)) {
              $sql = "update post set image = '" . implode("|", $image) . "' where id = $id";
              $query = $db->sql_query($sql);
              if ($query) {
                $result["status"] = 3;
                $result["data"] .= "Upload and move success";
              } else {
                $result["status"] = 2;
                $sql = "delete from post where id = $id";
                $db->sql_query($sql);
              }
            }
          } else if ($_FILES && $_FILES['file']['name']) {
            $extension = end(explode(".", $file)) ? $extension : "";
            $target_path = $target_path . $id . "_" . $index . "." . $extension;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
              $sql = "update post set image = '$target_path' where id = $id";
              $query = $db->sql_query($sql);
              if ($query) {
                $result["status"] = 3;
                $result["data"] .= "Upload and move success";
              } else {
                $result["status"] = 2;
                $sql = "delete from post where id = $id";
                $db->sql_query($sql);
              }
            } else {
              $result["status"] = 4;
              $result["data"] .= "There was an error uploading the file, please try again!";
            }
          } else {
            $result["status"] = 3;
          }
        } else {
          $result["status"] = 1;
        }
        if ($result["status"] === 3) {
          if (isset($_POST["id"]) && $_POST["id"] !== "undefined") {
            $result["status"] = 5;
          }
          $result["data"] = array();
          filterorder();
        }
      }
      break;
    case 'removepost':
      if (checkParam(array("id", "uid"))) {
        $id = $_GET["id"];
        $uid = $_GET["uid"];

        $sql = "delete from post where id = $id";
        if ($db->sql_query($sql)) {
          $result["status"] = 1;
          $result["data"] = array();
          filterorder();
        }
      }
      break;
    case 'getinit':
      $sql = 'select * from kind';
      $query = $db->sql_query($sql);
      $result["data"]["kind"] = fetchall($db, $query);
      $result["data"]["species"] = array();

      foreach ($result["data"]["kind"] as $key => $value) {
        $sql = "select * from species where kind = $value[id]";
        $query = $db->sql_query($sql);

        $data = fetchall($db, $query);
        $result["data"]["species"][$value["id"]] = $data;
        $result["data"]["species"][$value["id"]][] = array("id" => 0, "name" => "Chưa chọn");
      }
      $result["data"]["kind"][] = array("id" => 0, "name" => "Chưa chọn");

      $result["data"]["type"] = $type;
      $result["data"]["config"] = $config;
      break;
    case 'order':
      if (checkParam(array("name", "address", "phone", "pid"))) {
        $name = $_GET["name"];
        $address = $_GET["address"];
        $phone = $_GET["phone"];
        $pid = $_GET["pid"];

        if (checkParam(array("id")) && $_GET["id"] !== "null") {
          $id = $_GET["id"];
        } else {
          $id = 0;
        }

        $sql = "insert into petorder(pid, user, name, address, phone, status) values ($pid, $id, '$name', '$address', '$phone', 0)";
        $query = $db->sql_query($sql);
        if ($query) {
          $sql = "insert into notify(type, user, pid) values (1, $id, $pid)";
          $query = $db->sql_query($sql);
          $result["status"] = 2;
        } else {
          $result["status"] = 1;
        }
      }
      break;
    case 'getinfo':
      if (checkParam(array("id", "puid"))) {
        $id = $_GET["id"];
        $puid = $_GET["puid"];
        $uid = 0;
        $userdata = array();
        $order = 0;
        $rate = 0;

        $sql = "select name, phone, address from user where id = $puid";
        // die(var_dump($_GET));
        $query = $db->sql_query($sql);
        $userdata = $db->sql_fetch_assoc($query);

        if (checkParam(array("uid"))) {
          $uid = $_GET["uid"];

          $sql = "select id from rate where uid = $uid";
          // die(var_dump($_GET));
          // die($sql);
          $query = $db->sql_query($sql);
          $rate = $db->sql_numrows($query);

          $sql = "select * from petorder where user = $uid and pid = $id";
          $query = $db->sql_query($sql);
          // $order = "1: " . $sql;
          $order = $db->sql_numrows($query);
          if (!$order) {
            $sql = "select * from post where user = $uid and id = $id";
            $query = $db->sql_query($sql);
            $order = $db->sql_numrows($query);
            // $order .= "|2: " . $db->sql_numrows($query);
          }
        }

        if ($uid) {
          $where = "(a.user = $uid or b.user = $puid)";
        } else {
          $where = "(b.user = $puid)";
        }

        $sql = "select a.user, a.time, a.comment, c.name, c.province from comment a inner join post b on a.pid = $id and a.pid = b.id and $where inner join user c on a.user = c.id order by a.time asc";
        $query = $db->sql_query($sql);
        $comment = fetchall($db, $query);
        // die($sql);
        foreach ($comment as $key => $value) {
          $comment[$key]["time"] = date("d/m/Y", $value["time"]);
        }

        $result["status"] = 1;
        $result["data"]["owner"] = $userdata;
        $result["data"]["comment"] = $comment;
        $result["data"]["order"] = $order;
        $result["data"]["rate"] = $rate;
      }
      break;
    case 'filter':
      if (checkParam(array("sort", "price", "type"))) {
        $keyword = $_GET["keyword"];
        $sort = $_GET["sort"];
        $type = $_GET["type"];
        $price = explode("-", $_GET["price"]);

        $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%') and a.sold = 0 and a.type = $type";
        $order = " order by " . $sorttype[$sort];

        if ($price[1] >= 100000) {
          $where .= " and price >= $price[0]";
        } else {
          $where .= " and price between $price[0] and $price[1]";
        }

        if (checkParam(array("species")) && $_GET["species"] > 0) {
          $species = $_GET["species"];
          $where .= " and a.species = $species";
        } else if (checkParam(array("kind")) && $_GET["kind"] > 0) {
          $kind = $_GET["kind"];
          $where .= " and d.kind = $kind";
        }

        $sql = "select a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id $where $order";
        // die($sql);
        $query = $db->sql_query($sql);

        if ($query) {
          $result["status"] = 1;
          $result["data"] = parseData(fetchall($db, $query));
        }
      }
      break;
    case 'salefilter':
      filterorder();
      break;
    case 'disorder':
      if (checkParam(array("uid", "id", "sort", "type"))) {
        $uid = $_GET["uid"];
        $id = $_GET["id"];
        $keyword = $_GET["keyword"];
        $sort = $_GET["sort"];
        $type = $_GET["type"];

        $sql = "delete from petorder where id = $id";
        if ($db->sql_query($sql)) {
          $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
          $order = " order by " . $sorttype[$sort];
          $main = "select e.id as oid, b.province, a.kind as kindid, a.species as speciesid, a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, c.name as species from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";

          if ($type) {
            $sql = "$main $where and e.user = $uid $order";
          } else {
            $sql = "$main $where and a.user = $uid $order";
          }
          $query = $db->sql_query($sql);

          if ($query) {
            $result["status"] = 1;
            $result["data"] = parseData(fetchall($db, $query));
          }
        }
      }
      break;
    case 'postchat':
      if (checkParam(array("id", "uid", "puid", "chattext"))) {
        $pid = $_GET["id"];
        $uid = $_GET["uid"];
        $puid = $_GET["puid"];
        $comment = $_GET["chattext"];
        $name = "";
        $time = time();

        if (checkParam(array("name"))) {
          $name = $_GET["name"];
        }

        $sql = "insert into comment(pid, user, name, time, comment, cid, public) values($pid, $uid, '$name', $time, '$comment', 0, 0)";
        if ($db->sql_query($sql)) {
          $sql = "select a.user, a.time, a.comment, c.name from comment a inner join post b on a.pid = $pid and a.pid = b.id inner join user c on a.user = c.id order by a.time asc";
          $query = $db->sql_query($sql);
          $comment = fetchall($db, $query);
          foreach ($comment as $key => $value) {
            $comment[$key]["time"] = date("d/m/Y", $value["time"]);
          }

          $result["status"] = 1;
          $result["data"] = $comment;
        }


        // $sql = "insert into comment (pid, user, name, time, comment) value ($id, $uid, '$name', $time, '$chattext')";
        // if ($db->sql_query($sql)) {
        //   $sql = "select a.user, a.time, a.comment, c.name from comment a inner join post b on a.pid = $id and a.pid = b.id and (a.user = $uid or b.user = $puid) inner join user c on a.user = c.id order by a.time asc";
        //   $query = $db->sql_query($sql);
        //   $comment = fetchall($db, $query);
        //   foreach ($comment as $key => $value) {
        //   $comment[$key]["time"] = date("d/m/Y", $value["time"]);
        //   }
        //   $result["status"] = 1;
        //   $result["data"] = $comment;
        // }
      }
      break;
    case 'rate':
      if (checkParam(array("value", "uid", "puid"))) {
        $value = $_GET["value"];
        $uid = $_GET["uid"];
        $puid = $_GET["puid"];

        $sql = "insert into rate (uid, puid, value, review) values($uid, $puid, $value, '')";
        if ($db->sql_query($sql)) {
          $result["status"] = 1;
        }
      }
      break;
    case 'submitorder':
      if (checkParam(array("oid", "pid"))) {
        $oid = $_GET["oid"];
        $pid = $_GET["pid"];

        $sql = "update petorder set status = 1 where id = $oid";
        if ($db->sql_query($sql)) {
          $sql = "update petorder set status = 2 where status = 0 and id <> $oid";
          if ($db->sql_query($sql)) {
            $sql = "update post set sold = 1 where id = $pid";
            if ($db->sql_query($sql))
              $result["status"] = 1;
          }
        }
      }
      break;
  }

}

// var_dump($result);
echo json_encode($result);

// }

function rate() {
  global $result, $db;

  if (checkParam(array("uid"))) {
    $uid = $_GET["uid"];
    $sql = "select * from post where sold = 1 and user = $uid";
    if ($query = $db->sql_query($sql)) {
      $result["status"] = 1;
      $result["data"] = $db->sql_numrows($query);
    }
  }
}

function filterorder() {
  global $result, $db, $sorttype;
  if (checkParam(array("uid", "sort", "type"))) {
    $uid = $_GET["uid"];
    $keyword = $_GET["keyword"];
    $sort = $_GET["sort"];
    $type = $_GET["type"];

    $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
    $order = " order by " . $sorttype[$sort];
    $main = "select a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $main2 = "select e.id as oid, a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";

    switch ($type) {
      case '1':
        // buy
        $sql = "$main2 $where and e.user = $uid and a.sold = 0 $order";
        break;
      case '2':
        // order
        $sql = "$main2 $where and a.user = $uid and a.sold = 0 $order";
        break;
      case '3':
        // sold
        $sql = "$main2 $where and e.user = $uid and a.sold = 1 $order";
        break;
      case '4':
        // bought
        $sql = "$main2 $where and a.user = $uid and a.sold = 1 $order";
        break;
      default:
        //sell
        $sql = "$main $where and a.user = $uid and a.sold = 0 $order";
    }
    // die($sql);
    // echo $type;
    $query = $db->sql_query($sql);

    if ($query) {
      if (!$result["status"]) {
        $result["status"] = 1;
      }
      $result["data"] = parseData(fetchall($db, $query));
    }
  }
}

function parseData($petlist) {
  global $config;
  $time = time();
  $hour = 60 * 60;
  $day = 24 * $hour;
  $week = 7 * $day;
  $month = 30 * $day;
  $year = 365 * $day;
  $type = array("Cần bán", "Cần mua", "Muốn tặng", "Tìm thú lạc");
  // var_dump($petlist);
  foreach ($petlist as $key => $value) {
    $images = explode("|", $petlist[$key]["image"]);
    foreach ($images as $key2 => $value2) {
      $images[$key2] = "http://" . $_SERVER["SERVER_NAME"] . "/" . $value2;
    }
    $petlist[$key]["image"] = $images;
    // var_dump($config["age"][$value["age"]]);
    // die();
    $petlist[$key]["age"] = $config["age"][$value["ageid"]];
    $petlist[$key]["province"] = $config["province"][$value["province"]];
    $petlist[$key]["pricevalue"] = $value["price"];
    $petlist[$key]["price"] = number_format(preg_replace("/[^0-9.]/", "", $value["price"] * 1000)) . " ₫";
    $timedistance = $time - $value["time"];
    $petlist[$key]["type"] = $type[$value["typeid"]];
    $petlist[$key]["typename"] = $value["kind"] . " " . $value["species"];

    if ($timedistance > $year) {
      $petlist[$key]["timer"] = floor($timedistance / $year) . " năm";
    } else if ($timedistance > $month) {
      $petlist[$key]["timer"] = floor($timedistance / $month) . " tháng";
    } else if ($timedistance > $week) {
      $petlist[$key]["timer"] = floor($timedistance / $week) . " tuần";
    } else if ($timedistance > $day) {
      $petlist[$key]["timer"] = floor($timedistance / $day) . " ngày";
    } else {
      $h = floor($timedistance / $hour);
      if ($h) {
        $petlist[$key]["timer"] = $h . " giờ";
      } else {
        $petlist[$key]["timer"] = "vừa mới";
      }
    }
  }
  return $petlist;
}

function checkParam($param, $post = false) {
  $check = true;
  if ($post) {
    foreach ($param as $value) {
      if (!$check && (!isset($_POST[$value]) && $_POST[$value] !== "")) {
        $check = false;
      }
    }
  } else {
    foreach ($param as $value) {
      if (!$check || (!isset($_GET[$value]) || $_GET[$value] == "")) {
        $check = false;
      }
    }
  }
  // var_dump($check);
  return $check;
}

function fetchall($db, $query) {
    $result = array();
    while ($row = $db->sql_fetch_assoc($query)) {
        $result[] = $row;
    }
    return $result;
}

?>
