<?php
  class DataBaseWorked {
    private $host, $db_user, $db_pass, $db, $time_to_conn;
    public $conn;

    public function __construct($host, $db_user, $db_pass, $db) {
      $this->host = $host;
      $this->db_user = $db_user;
      $this->db_pass = $db_pass;
      $this->db = $db;

      $this->conn = new mysqli($host, $db_user, $db_pass, $db);

      if ($this->conn->connect_error) die("Произошла ошибка");
      $this->time_to_conn = time();
    }

    public function getListSouses() {
      $tmp_m = [];
      $query = "SELECT * FROM souses";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[] = $row;

      }
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    }

    public function getListCatalogs() {
      $tmp_m = [];
      $query = "SELECT * FROM catalogs";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[] = $row;

      }
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    }

    public function getListRecommend() {
      $tmp_m = [];
      $query = "SELECT * FROM recommendations";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[] = $row;

      }
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    }
    /* type */
    public function getListInfo() {
      $tmp_m = [];
      $query = "SELECT * FROM info";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[] = array("id" => $row['id'],"countprod"=> $row['countprod'],"countappli" => $row['countappli'], "deliver" => $row['deliver'],"address" => $row['address'],"name" => $row['name'], "phone" => $row['phone'],"comment" => $row['comment'],"pay"=> $row['pay'],"timedel" => $row['timedel'],"idsprod" => explode(',', $row['idsprod']), "souses" => explode(',', $row['souses']), "totalprice"=>$row['totalprice']);

      }
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    }

    /* type */
    public function getListMenu() {
      $tmp_m = [];
      $query = "SELECT * FROM menu";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[] =  $row;

      }
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    }
    /* type */
    public function getListRestaurants() {
  $query = "SELECT * FROM restaurants";
  $result = $this->conn->query($query);
  if (!$result) return false;
  $data = array();
  while($n = $result->fetch_assoc()) {
   $data[] = $n;
  }
  return json_encode($data);
    }

    public function getSouseById($id) {

      $query = "SELECT * FROM souses WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = $result;
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }

    public function getCatalogById($id) {

      $query = "SELECT * FROM catalogs WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = $result;
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }


    public function getReccomendByIdRest($id) {

      $query = "SELECT * FROM recommendations WHERE restaurant_id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = array("recommend_id"=>$result['id'], "menu_id"=>$result['menu_id']);
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }

    public function getReccomendById($id) {

      $query = "SELECT * FROM recommendations WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = $result;
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }
    /* type */
    public function getInfoById($id) {

      $query = "SELECT * FROM info WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_array(MYSQLI_ASSOC);
      if (!$row) return false;
      $m[] = array("id" => $row['id'],"countprod"=> $row['countprod'],"countappli" => $row['countappli'], "deliver" => $row['deliver'],"address" => $row['address'],"name" => $row['name'], "phone" => $row['phone'],"comment" => $row['comment'],"pay"=> $row['pay'],"timedel" => $row['timedel'],"idsprod" => explode(',', $row['idsprod']), "souses" => explode(',', $row['souses']),  "totalprice"=>$row['totalprice']);
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }

    /* type */
    public function getRestaurantById($id) {

      $query = "SELECT * FROM restaurants WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = $result;
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }
    /* type */
    public function getMenuByIdRestaurant($rest_id) {

      $tmp_m = [];
      $query = "SELECT * FROM menu WHERE restaurant_id='$rest_id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[$i] = $row;

      }
      if (!empty($tmp_m)) {
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }

    public function getListSousesByRestId($id) {
      $query = "SELECT id AS souse_id, price, name FROM souses WHERE restaurant_id=$id";
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $tmp_m[$i] = $row;

      }
      if (!empty($tmp_m)) {
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
}
    /* type */
    public function getListCategoryByIdRestaurant($id) {

      $query = "SELECT category, restaurant_id, id FROM menu WHERE restaurant_id=$id";
      $tmp_m = [];
      $t = [];
      $result = $this->conn->query($query);
      if (!$result) return false;
      for ($i = 0; $i < $result->num_rows; $i++) {
        $a = true;
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $query2 = "SELECT image, name FROM catalogs WHERE id={$row['category']}";
        $result2 = $this->conn->query($query2);
        $row2 = $result2->fetch_array(MYSQLI_ASSOC);

      $t[$i] = array("category_id"=>$row["category"]);
        for ($j=0; $j < $i; $j++) {
          if ($t[$j]['category_id'] == $t[$i]['category_id']) {
            $a = false;
          }
        }

        if ($a === false) continue;
        else {
        $tmp_m[] = array("category_id"=>$row["category"], "name"=>$row2['name'], "image"=>$row2['image']);

      }
      }
      if (!empty($tmp_m)) {
      return json_encode($tmp_m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }
    /* type */
    public function getMenuById($id) {

      $query = "SELECT * FROM menu WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $result = $res->fetch_array(MYSQLI_ASSOC);
      if (!$result) return false;
      $m[] = $result;
      if (!empty($m)) {
      return json_encode($m, JSON_UNESCAPED_UNICODE);
    } else {
      return json_encode([]);
    }
    }


    public function changeSouseById($id, $name, $price, $rest_id) {
      $query = "UPDATE souses SET `name`='$name', `price`=$price, `restaurant_id`=$rest_id WHERE `id`=$id";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function changeCategoryById($id, $name, $image) {

      $query = "UPDATE `catalogs` SET `name`='$name', `image`='$image' WHERE `id`=$id ";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function changeRecommendById($id, $menu_id, $rest_id) {

      $query = "UPDATE `recommendations` SET `menu_id`=$menu_id, `restaurant_id`='$rest_id' WHERE `id`=$id";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function changeNameRestaurantById($id, $newname) {

      $query = "UPDATE restaurants SET name='$newname' WHERE id=$id";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function changeMenuById($id, $pathtoimage, $name, $category, $description, $price, $calories, $new, $oldprice, $newprice, $weight, $rest_id) {
      $query = "UPDATE menu SET image='$pathtoimage', name='$name', category='$category', description='$description', price='$price', calories='$calories', new='$new', oldprice='$oldprice', newprice='$newprice', weight='$weight', restaurant_id='$rest_id' WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function changeInfoById($id, $countprod, $countappli, $deliver, $address, $name, $phone, $comment, $pay, $timedel, $idsprod, $souses) {
      $totalprice = 0;
      $idsprod = explode(',', $idsprod);
      for ($i=0; $i < count($idsprod); $i++) {
        $list = $this->getMenuById($idsprod[$i]);
        $list = json_decode($list, true);
        $price = $list[0]['newprice'];
        $totalprice += $price;
      }
      $souses = explode(',', $souses);
      for ($i=0; $i < count($souses); $i++) {
        $list = $this->getSouseById($souses[$i]);
        $list = json_decode($list, true);
        $price = $list[0]['price'];
        $totalprice += $price;
      }

      $souses = implode(',', $souses);
      $idsprod = implode(',', $idsprod);
      $query = "UPDATE info SET countprod='$countprod', countappli='$countappli', deliver='$deliver', address='$address', name='$name', phone='$phone', comment='$comment', pay='$pay', timedel='$timedel', idsprod='$idsprod', souses='$souses', totalprice=$totalprice   WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function addSouse($name, $price, $restaurant_id) {
      $query = "INSERT INTO souses VALUES(null, '$name', $price, $restaurant_id)";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function addCatalogs($name, $image) {

      $query = "INSERT INTO catalogs VALUES(null, '$name', '$image')";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function addRecommend($menu_id, $restaurant_id) {

      $query = "INSERT INTO recommendations VALUES(null, '$menu_id', '$restaurant_id')";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function addPositionMenu($pathtoimage, $name, $category, $description, $price, $calories, $new, $oldprice, $newprice, $weight, $rest_id) {

      $query = "INSERT INTO menu VALUES (null, '$pathtoimage', '$name','$category','$description','$price','$calories','$new','$oldprice', '$newprice', '$weight', '$rest_id')";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;

    }
    /* type */
    public function addRestaurant($name) {

      $query = "INSERT INTO restaurants VALUES(null, '$name')";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function addInfo($countprod, $countappli, $deliver, $address, $name, $phone, $comment, $pay, $timedel, $idsprod, $souses) {
      $totalprice = 0;
      if ($idsprod !== "") {
      $idsprod = explode(',', $idsprod);
      for ($i=0; $i < count($idsprod); $i++) {
        $list = $this->getMenuById($idsprod[$i]);
        $list = json_decode($list, true);
        $price = $list[0]['newprice'];
        $totalprice += $price;
      }
      $idsprod = @implode(',', $idsprod);
    }
      if ($souses !== "") {
      $souses = explode(',', $souses);
      for ($i=0; $i < count($souses); $i++) {
        $list = $this->getSouseById($souses[$i]);
        $list = json_decode($list, true);
        $price = $list[0]['price'];
        $totalprice += $price;
      }
      $souses = @implode(',', $souses);
    }

      $query = "INSERT INTO info VALUES (null, '$countprod', '$countappli', '$deliver', '$address', '$name', '$phone', '$comment', '$pay', '$timedel', '$idsprod', '$souses', $totalprice)";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function deleteSouse($id) {
      $query = "DELETE FROM souses WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function deleteCatalogs($id) {

      $query = "DELETE FROM catalogs WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

    public function deleteRecommend($id) {

      $query = "DELETE FROM recommendations WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function deletePositionMenu($id) {

      $query = "DELETE FROM menu WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function deleteRestaurant($id) {

      $query = "DELETE FROM restaurants WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }
    /* type */
    public function deleteInfo($id) {

      $query = "DELETE FROM info WHERE id='$id'";
      $result = $this->conn->query($query);
      if (!$result) return false;
      else return true;
    }

}
?>
