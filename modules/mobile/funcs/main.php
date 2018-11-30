<?php

if (!defined('NV_IS_MOD_VAC')) {
      die('Stop!!!');
}
$action = $nv_Request->get_string('action', 'post/get', '');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$result = array("status" => 0, "data" => "");
$type = array("Cần bán", "Cần mua", "Muốn tặng", "Tìm thú lạc");

if (!empty($action)) {
  $db_config["dbname"] = "petcoffe";
  $db_config["dbuname"] = "root";
  $db_config["dbpass"] = "";

  $db = new sql_db($db_config);
  $query = $db->sql_query("SET CHARACTER SET 'utf8'");

  $sql = "SELECT * FROM `config`";
  $query = $db->sql_query($sql);
  $data = fetchall($db, $query);

  $config = array();
  foreach ($data as $key => $value) {
    $config[$value["name"]][] = $value["value"];
  }
  $newprovince = array("Toàn quốc");
  foreach ($config["province"] as $key => $row) {
    $newprovince[] = $row;
  }
  $config["province"] = $newprovince;
  $sorttype = array("time desc", "time asc", "price asc", "price desc");

  switch ($action) {
    case "getlogin":
      $id = $nv_Request->get_string('id', 'post/get', '');
      if (!empty($id)) {
        $sql = "SELECT * from user where id = $id";
        $query = $db->sql_query($sql);

        if ($db->sql_numrows($query)) {
          $row = $db->sql_fetch_assoc($query);
          $result["status"] = 1;
          $result["data"] = array("uid" => $row["id"], "name" => $row["name"], "phone" => $row["phone"], "address" => $row["address"], "province" => $row["province"]);
        }
      }
      break;
    case "login":
      $username = $nv_Request->get_string('username', 'post/get', '');
      $password = $nv_Request->get_string('password', 'post/get', '');
      if (! (empty($username) || empty($password))) {

        $sql = "SELECT * from user where username = '$username'";
        $query = $db->sql_query($sql);
        // echo $sql;
        // var_dump($db->sql_fetch_assoc($query));

        if ($db->sql_numrows($query)) {
          $sql = "SELECT * from user where username = '$username' and password = '$password'";
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

        $sql = "SELECT * from user where username = '$username'";
        $query = $db->sql_query($sql);

        if (!$db->sql_numrows($query)) {
          $sql = "INSERT into user (username, password, name, phone, address, province) values ('$username', '$password', '$name', '$phone', '$address', $province)";
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
          $sql = "UPDATE post set name = '$name', age = $age, description = '$description', price = '$price', vaccine = $vaccine, species = $species, kind = $kind, type = $typeid where id = $id";
          // $result["data"] = $sql;
          // echo json_encode($result);
          // die();
          if (!$db->sql_query($sql)) {
            $id = 0;
          }
        } else {
          $time = time();
          $sql = "INSERT into post(user, name, age, description, species, kind, price, vaccine, type, sold, time) values($uid, '$name', $age, '$description', $species, $kind, $price, $vaccine, $typeid, 0, $time)";
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
              $sql = "UPDATE post set image = '" . implode("|", $image) . "' where id = $id";
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
              $sql = "UPDATE post set image = '$target_path' where id = $id";
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
        // $result["data"]["sql"] = $sql;
        if ($result["status"] === 3) {
          if (isset($_POST["id"]) && $_POST["id"] !== "undefined") {
            $result["status"] = 5;
          }
          filterorder();
        }
      }
      break;
    case 'removepost':
      if (checkParam(array("id", "uid"))) {
        $pid = $_GET["id"];
        $uid = $_GET["uid"];

        $sql = "SELECT * from post where id = $pid";
        $query = $db->sql_query($sql);
        $row = $db->sql_fetch_assoc($query);
        $sql = "SELECT * from petorder where pid = $pid";
        $query = $db->sql_query($sql);
        if (!empty($allrow = fetchall($db, $query))) {
          $sql = "delete from post where id = $pid";
          if ($db->sql_query($sql)) {
            foreach ($allrow as $key => $row) {
              $sql = "insert into notify (type, user, uid, pid, time) values(5, $row[uid], $row[user], $pid, " . strtotime(date("Y-m-d")) . ")";
              $query = $db->sql_query($sql);
            }
            $result["status"] = 1;
            $result["data"] = array();
            filterorder();
          }
        }
      }
      break;
    case 'getinit':
      $sql = 'SELECT * from kind';
      $query = $db->sql_query($sql);
      $result["data"]["kind"] = fetchall($db, $query);
      $result["data"]["species"] = array();

      foreach ($result["data"]["kind"] as $key => $value) {
        $sql = "SELECT * from species where kind = $value[id]";
        $query = $db->sql_query($sql);

        $data = fetchall($db, $query);
        $result["data"]["species"][$value["id"]][0] = array("id" => 0, "name" => "Chưa chọn");
        foreach ($data as $key => $row) {
          $result["data"]["species"][$value["id"]][] = $row;
        }
      }

      $result["data"]["type"] = $type;
      $result["data"]["config"] = $config;
      filterbase();
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

        $sql = "INSERT into petorder(pid, user, name, address, phone, status) values ($pid, $id, '$name', '$address', '$phone', 0)";
          $query = $db->sql_query($sql);
          $result["data"] = $sql;

        if ($query) {
          $time = strtotime(date("Y-m-d"));
          $sql = "SELECT user from post where id = $pid";
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $sql = "insert into notify (type, user, uid, pid, time) values(1, $row[user], $uid, $pid, $time)";
            $result["data"] = $sql;  
            $query = $db->sql_query($sql);
            $result["status"] = 1;
          }
        }
      }
      break;
    case 'getinfo':
      if (checkParam(array("uid", "puid", "pid", "page"))) {
        $puid = $_GET["puid"];
        $page = $_GET["page"];
        $uid = $_GET["uid"];
        $pid = $_GET["pid"];
        $uid = 0;
        $userdata = array();
        $order = 0;
        $rate = 0;

        if (checkParam(array("uid"))) {
          $uid = $_GET["uid"];
          
          $sql = "SELECT name, phone, address from user where id = $puid";
          // $result["data"]["sql"] = $sql;
          // die(var_dump($_GET));
          $query = $db->sql_query($sql);
          $userdata = $db->sql_fetch_assoc($query);

          $sql = "SELECT id, value from rate where uid = $uid and pid = $pid";
          // die(var_dump($_GET));
          // die($sql);
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            // $result["data"] = var_dump($row);
            $rate = $row["value"];
            // test();
          }

          $sql = "SELECT * from petorder where user = $uid and pid = $pid";
          $query = $db->sql_query($sql);
          // $order = "1: " . $sql;
          $order = $db->sql_numrows($query);
          if (!$order) {
            $sql = "SELECT * from post where user = $uid and id = $pid";
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

        $commentlimit = 10;
        if ($config["comment"] > 0) {
          $commentlimit = $config["comment"];
        }
        $from = 0; 
        $to = $page * $commentlimit; 
        $limit = "limit $from, $to";

        $sql = "SELECT a.user, a.name, a.phone, a.address, a.time, a.comment from comment a where a.pid = $pid order by a.time asc $limit";
        $query = $db->sql_query($sql);
        $comment = fetchall($db, $query);

        foreach ($comment as $key => $row) {
          if ($row["user"]) {
            $sql = "SELECT a.name, a.phone, a.address from user a where id = $row[user]";
            $result["data"]["sql"] = $sql;
            $query = $db->sql_query($sql);
            $crow = $db->sql_fetch_assoc($query);
            $comment[$key]["name"] = $crow["name"];
            $comment[$key]["phone"] = $crow["phone"];
            $comment[$key]["address"] = $crow["address"];
          }
          $comment[$key]["time"] = date("H:i d/m/Y", $row["time"]);
        }

        $sql = "select count(id) as count from comment where pid = $pid";
        $query = $db->sql_query($sql);
        $countid = $db->sql_fetch_assoc($query);
        $result["data"]["next"] = false;
        if ($countid["count"] > $to) {
          $result["data"]["next"] = true;
        }

        // $comment = array_merge($comment, $comment2);
        // $time = array();
        // foreach ($comment as $key => $row) {
        //   $time[$key] = $row['time'];
        // }
        // array_multisort($time, SORT_ASC, $comment);
      
        $sql = "insert into notify (type, user, uid, pid, time) values(4, $ouid, $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
        $query = $db->sql_query($sql);


        $result["status"] = 1;
        $result["data"]["owner"] = $userdata;
        $result["data"]["comment"] = $comment;
        $result["data"]["order"] = $order;
        $result["data"]["rate"] = $rate;
      }
      break;
    case 'filter':
      filterbase();
      break;
    case 'salefilter':
      filterorder();
      break;
    case 'disorder':
      if (checkParam(array("uid", "id", "sort", "type"))) {
        $uid = $_GET["uid"];
        $oid = $_GET["id"];
        $keyword = $_GET["keyword"];
        $sort = $_GET["sort"];
        $type = $_GET["type"];

        $sql = "SELECT * from petorder where id = $oid";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $sql = "delete from petorder where id = $oid";
          if ($db->sql_query($sql)) {
            $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%')";
            $order = " order by " . $sorttype[$sort];
            $main = "SELECT e.id as oid, b.province, a.kind as kindid, a.species as speciesid, a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, c.name as species from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
  
            if ($type) {
              $sql = "$main $where and e.user = $uid $order";
            } else {
              $sql = "$main $where and a.user = $uid $order";
            }
            $query = $db->sql_query($sql);
  
            if ($query) {
              $sql = "insert into notify (type, user, uid, pid, time) values(2, $row[user], $uid, $row[id], " . strtotime(date("Y-m-d")) . ")";
              $query = $db->sql_query($sql);
                $query = $db->sql_query($sql);
              $result["status"] = 1;
              $result["data"] = parseData(fetchall($db, $query));
            }
          }            
        }
      }
      break;
    case 'postchat':
      $uid = $nv_Request->get_string('uid', 'post/get', '');
      $pid = $nv_Request->get_string('id', 'post/get', '');
      $page = $nv_Request->get_string('page', 'post/get', '');
      $comment = $nv_Request->get_string('chattext', 'post/get', '');
      $time = time();

      if (empty($uid)) {
        $name = $nv_Request->get_string('name', 'post/get', '');
        $phone = $nv_Request->get_string('phone', 'post/get', '');
        $address = $nv_Request->get_string('address', 'post/get', '');
        $uid = 0;

        $sql = "INSERT into comment(pid, user, name, phone, address, time, comment, cid, public) values($pid, $uid, '$name', '$phone', '$address', $time, '$comment', 0, 0)";
      }
      else {
        $puid = $nv_Request->get_string('puid', 'post/get', '');

        $sql = "INSERT into comment(pid, user, name, phone, address, time, comment, cid, public) values($pid, $uid, '', '', '', $time, '$comment', 0, 0)";
      }

      if ($db->sql_query($sql)) {
        $commentlimit = 10;
        if ($config["comment"] > 0) {
          $commentlimit = $config["comment"];
        }
        $result["data"]["page"] = $page;
        $result["data"]["commentlimit"] = $commentlimit;

        $from = 0; 
        $to = $page * $commentlimit; 
        $limit = "limit $from, $to";

        $sql = "SELECT a.user, a.name, a.phone, a.address, a.time, a.comment from comment a where a.pid = $pid  order by a.time asc $limit";
        // $result["data"]["sql"] = $sql;
        $query = $db->sql_query($sql);
        $comment = fetchall($db, $query);

        foreach ($comment as $key => $row) {
          if ($row["user"]) {
            $sql = "SELECT a.name, a.phone, a.address from user a where id = $row[user]";
            $query = $db->sql_query($sql);
            $crow = $db->sql_fetch_assoc($query);
            $comment[$key]["name"] = $crow["name"];
            $comment[$key]["phone"] = $crow["phone"];
            $comment[$key]["address"] = $crow["address"];
          }
          $comment[$key]["time"] = date("H:i d/m/Y", $row["time"]);
        }

        $sql = "SELECT * from post where id = $pid";
        $query = $db->sql_query($sql);
        $row = $db->sql_fetch_assoc($query);

        $sql = "insert into notify (type, user, uid, pid, time) values(4, $row[user], $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
        $result["data"]["sql"] = $sql;
        $query = $db->sql_query($sql);

        $result["status"] = 1;
        $result["data"]["comment"] = $comment;
      }
      break;
    case 'rate':
      if (checkParam(array("value", "uid", "pid"))) {
        $value = $_GET["value"];
        $uid = $_GET["uid"];
        $pid = $_GET["pid"];

        $time = strtotime(date("Y-m-d"));

        $sql = "SELECT * from post where id = $pid";
        $query = $db->sql_query($sql);
        if ($row = $db->sql_fetch_assoc($query)) {
          $sql = "INSERT into rate (uid, pid, value, review, time) values($uid, $pid, $value, '', $time)";
          if ($db->sql_query($sql)) {
            $sql = "insert into notify (type, user, uid, pid, time) values(3, $row[user], $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
            $query = $db->sql_query($sql);
            $result["status"] = 1;
          }  
        }
      }
      break;
    case 'submitorder':
      if (checkParam(array("oid", "uid", "pid"))) {
        $uid = $_GET["uid"];
        $oid = $_GET["oid"];
        $pid = $_GET["pid"];

        $sql = "UPDATE petorder set status = 1 where id = $oid";
        if ($db->sql_query($sql)) {
          $sql = "UPDATE petorder set status = 2 where status = 0 and id <> $oid";
          if ($db->sql_query($sql)) {
            $sql = "UPDATE post set sold = 1 where id = $pid";
            if ($db->sql_query($sql)) {
              $sql = "SELECT * from post where id = $pid";
              $query = $db->sql_query($sql);
              $row = $db->sql_fetch_assoc($query);
              $sql = "insert into notify (type, user, uid, pid, time) values(6, $uid, $row[user], $pid, " . strtotime(date("Y-m-d")) . ")";
              $query = $db->sql_query($sql);
              $sql = "insert into notify (type, user, uid, pid, time) values(7, $row[user], $uid, $pid, " . strtotime(date("Y-m-d")) . ")";
              $query = $db->sql_query($sql);
              $result["status"] = 1;
              filterorder();
            }
          }
        }
      }
      break;
    case 'getproviderpet':
      $name = $nv_Request->get_string('name', 'post/get', '');
      $phone = $nv_Request->get_string('phone', 'post/get', '');
      if (!(empty($name) || (empty($phone)))) {
        $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id where sold = 0 order by a.time desc";
        if ($query = $db->sql_query($sql)) {
          $data = fetchall($db, $query);
          // $sql = "SELECT * from rate a inner join post b on a.pid = b.id inner join user c on c.id in ("1", "2", "3") and b.user = c.id";
          $sql = "SELECT * from rate a inner join post b on a.pid = b.id inner join user c on c.id = b.user";
          $query = $db->sql_query($sql);
          $total = $db->sql_numrows($query);
          // $result["data"]["sql"] = $sql;

          if ($total) {
            $rate = fetchall($db, $query);
            $totalpoint = 0;
            foreach ($rate as $key => $value) {
              $totalpoint += $value["value"];
            }
            $average = $totalpoint / $total;
          }
          else {
            $average = 0;
          }

          $sql = "SELECT * from post a inner join user b on b.name = '$name' and b.phone = '$phone' and a.sold = 1 and a.user = b.id";
          $query = $db->sql_query($sql);
          $totalsale = $db->sql_numrows($query);
          // $result["data"]["sql"] = $sql;

          $crate = array();
          foreach ($rate as $key => $row) {
            $crate[] = array("name" => $row["name"], "msg" => $row["review"], "time" => date("d/m/Y", $row["time"]));
          }

          $result["status"] = 1;
          $result["data"]["propet"] = parseData($data);
          $result["data"]["total"] = $total;
          $result["data"]["average"] = $average;
          $result["data"]["totalsale"] = $totalsale;
          $result["data"]["rate"] = $crate;
        }
      }
      break;
      case 'getnotify':
        $uid = $nv_Request->get_string('uid', 'post/get', '');
        if (!empty($uid)) {
          $sql = "SELECT a.type, a.time, a.pid, b.name as title, c.name from notify a inner join post b on a.pid = b.id inner join user c on a.user = $uid and a.uid = c.id order by a.time desc";
          $result["data"]["sql"] = $sql;

          if ($query = $db->sql_query($sql)) {
            $data = fetchall($db, $query);
            foreach ($data as $key => $row) {
              $data[$key]["time"] = date("d/m/Y", $row["time"]);
            }
            $result["status"] = 1;
            $result["data"] = $data;
          }
        }
      break;
      case 'getvender':
        $oid = $nv_Request->get_string('oid', 'post/get', '');
        if (!empty($oid)) {
          $sql = "SELECT c.name, c.phone, c.address from petorder a inner join post b on a.id = $oid and a.pid = b.id inner join user c on b.user = c.id";

          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $result["status"] = 1;
            $result["data"]["vender"] = $row;
          }
        }
      break;
      case 'getorderlist':
        $pid = $nv_Request->get_string('pid', 'post/get', '');
        if (!empty($pid)) {
          $sql = "SELECT a.id as oid, c.name, c.phone, c.address from petorder a inner join post b on a.pid = $pid and a.pid = b.id inner join user c on a.user = c.id";
          $query = $db->sql_query($sql);
          if ($allrow = fetchall($db, $query)) {
            $result["status"] = 1;
            $result["data"]["vender"] = $allrow;
          }
        }
      break;
      case 'changepass':
        $uid = $nv_Request->get_string('uid', 'post/get', '');
        $pass = $nv_Request->get_string('pass', 'post/get', '');
        $npass = $nv_Request->get_string('npass', 'post/get', '');
        if (!(empty($uid) || empty($pass) || empty($npass))) {
          $sql = "SELECT * from user where password = $pass and id = $uid";
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $sql = "UPDATE user set password = '$npass' where id = $uid";
            if ($db->sql_query($sql)) {
              $result["status"] = 1;
            }
          }
        }
      break;
      case 'changeinfo':
        $uid = $nv_Request->get_string('uid', 'post/get', '');
        $name = $nv_Request->get_string('name', 'post/get', '');
        $address = $nv_Request->get_string('address', 'post/get', '');
        $phone = $nv_Request->get_string('phone', 'post/get', '');
        if (!(empty($uid) || empty($name) || empty($address) || empty($phone))) {
          $sql = "SELECT * from user where id = $uid and name = $name";
          $query = $db->sql_query($sql);
          if ($row = $db->sql_fetch_assoc($query)) {
            $sql = "UPDATE user set name = '$name', address = '$address', phone = '$phone' where id = $uid";
            if ($db->sql_query($sql)) {
              $result["status"] = 1;
            }
          }
        }
      break;
      case 'changeprovince':
        $uid = $nv_Request->get_string('uid', 'post/get', '');
        $province = $nv_Request->get_string('province', 'post/get', '');
        if (!(empty($uid) || empty($province))) {
            $sql = "UPDATE user set province = '$province' where id = $uid";
            if ($db->sql_query($sql)) {
              $result["status"] = 1;
            }
        }
      break;
      case 'getdatainfo':
        $pid = $nv_Request->get_string('pid', 'post/get', '');
        if (!empty($pid)) {
          $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.id = $pid and a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
          if ($query = $db->sql_query($sql)) {
            $result["data"]["owner"] = parseData(array($db->sql_fetch_assoc($query)))[0];
            $result["status"] = 1;
          }
        }
      break;
      case 'nextcomment':
        $pid = $nv_Request->get_string('pid', 'post/get', '');
        $page = $nv_Request->get_string('page', 'post/get', '');
        if (!(empty($pid) || empty($page))) {
          $page ++;
          $commentlimit = 10;
          if ($config["comment"] > 0) {
            $commentlimit = $config["comment"];
          }
          $from = 0; 
          $to = $page * $commentlimit; 
          $limit = "limit $from, $to";
  
          $sql = "SELECT a.user, a.name, a.phone, a.address, a.time, a.comment from comment a where a.pid = $pid  order by a.time asc $limit";
          $result["data"]["sql"] = $sql;
          $query = $db->sql_query($sql);
          $comment = fetchall($db, $query);
  
          foreach ($comment as $key => $row) {
            if ($row["user"]) {
              $sql = "SELECT a.name, a.phone, a.address from user a where id = $row[user]";
              $query = $db->sql_query($sql);
              $crow = $db->sql_fetch_assoc($query);
              $comment[$key]["name"] = $crow["name"];
              $comment[$key]["phone"] = $crow["phone"];
              $comment[$key]["address"] = $crow["address"];
            }
            $comment[$key]["time"] = date("H:i d/m/Y", $row["time"]);
          }
  
          $sql = "select count(id) as count from comment where pid = $pid";
          $query = $db->sql_query($sql);
          $countid = $db->sql_fetch_assoc($query);
          $result["data"]["next"] = false;
          if ($countid["count"] > $to) {
            $result["data"]["next"] = true;
          }

          $result["status"] = 1;
          $result["data"]["comment"] = $comment;
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
    $sql = "SELECT * from post where sold = 1 and user = $uid";
    if ($query = $db->sql_query($sql)) {
      $result["status"] = 1;
      $result["data"] = $db->sql_numrows($query);
    }
  }
}

function filterbase() {
  global $db, $result, $sorttype, $nv_Request;
  $sort = $nv_Request->get_string('sort', 'post/get', '');
  $price = $nv_Request->get_string('price', 'post/get', '');
  $type = $nv_Request->get_string('type', 'post/get', '');
  $province = $nv_Request->get_string('province', 'post/get', '');
  $page = $nv_Request->get_string('page', 'post/get', '');
  if ($sort >= 0 && !empty($price) && $type >= 0 && $page > 0) {
    $keyword = $_GET["keyword"];
    $price = explode("-", $price);
    $whereprovince = "";
    if ($province > 0) {
      $whereprovince = "and b.province = $province";
    }

    $where = " where (a.name like '%$keyword%' or a.description like '%$keyword%' or b.name like '%$keyword%' or b.phone like '%$keyword%') $whereprovince and a.sold = 0 and a.type = $type";
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

    $from = 0;
    $to = 12 * $page;

    $sql = "SELECT count(a.id) as count from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id $where";
    $query = $db->sql_query($sql);
    $countid = $db->sql_fetch_assoc($query);
    $result["data"]["next"] = false;
    if ($countid["count"] > $to) {
      $result["data"]["next"] = true;
    }


    $sql = "SELECT a.type as typeid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, a.description, b.name as owner, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id $where $order limit $from, $to";
    $result["data"]["sql"] = $sql;
    // yk
    // die($sql);
    $query = $db->sql_query($sql);

    if ($query) {
      $result["status"] = 1;
      $result["data"]["newpet"] = parseData(fetchall($db, $query));
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
    $main = "SELECT a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from post a inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";
    $main2 = "SELECT e.id as oid, a.type as typeid, a.kind as kindid, a.species as speciesid, a.id, a.user, a.name, a.price, a.age as ageid, a.image, a.time, a.vaccine, b.name as owner, a.description, c.name as species, d.name as kind, b.province from petorder e inner join post a on e.pid = a.id inner join user b on a.user = b.id inner join species c on a.species = c.id inner join kind d on c.kind = d.id";

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
        $sql = "$main2 $where and a.user = $uid and a.sold = 1 and e.status = 1 $order";
        break;
        case '4':
        // bought
        $sql = "$main2 $where and e.user = $uid and a.sold = 1 and e.status = 1 $order";
        break;
      default:
        //sell
        $sql = "$main $where and a.user = $uid and a.sold = 0 $order";
    }

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

    if ($timedistance > (3 * $year)) {
      $petlist[$key]["timer"] = floor($timedistance / $year) . " năm";
    } else if ($timedistance > (3 * $month)) {
      $petlist[$key]["timer"] = floor($timedistance / $month) . " tháng";
    } else if ($timedistance > (3 * $week)) {
      $petlist[$key]["timer"] = floor($timedistance / $week) . " tuần";
    } else if ($timedistance > (3 * $day)) {
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

function test() {
  echo json_encode($result);
  die();
}

?>
