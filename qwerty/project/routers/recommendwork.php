<?php
require_once 'api.php';
// Роутер
function route($method, $urlData, $formData) {

  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);
    // Получение информации о товаре
    // GET /resraurantwork/{goodId}
    if ($method === 'GET' && count($urlData) === 1) {
        // Получаем id товара
        $restId = $urlData[0];
        $list = $exm->getReccomendById($restId);
        // Выводим ответ клиенту
        echo $list;
        return;
    }


    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] == 'type' && $urlData[1] == 'all') {
      $restId = $urlData[0];
      $list = $exm->getListRecommend();
      echo $list;
      return;
    }

    if ($method == 'GET' && count($urlData) === 2 && $urlData[1] === 'restid') {
      $id = $urlData[0];
      $list = $exm->getReccomendByIdRest($id);
      $list = json_decode($list, true);
      if (!empty($list)) {
      $data = $exm->conn->query("SELECT name, image, new, newprice, description FROM menu WHERE id={$list[0]['menu_id']}");
      $row = $data->fetch_array(MYSQLI_ASSOC);

      $list[0]['name'] = $row['name'];
      $list[0]['image'] = $row['image'];
      $list[0]['new'] = $row['new'];
      $list[0]['newprice'] = $row['newprice'];
      $list[0]['description'] = $row['description'];
      $list = json_encode($list, JSON_UNESCAPED_UNICODE);
      echo $list;
    } else {
      echo json_encode([]);
    }
      return;
    }


    if ($method === 'POST' && empty($urlData)) {
          $menuId = $formData['menu_id'];
          $restId = $formData['restid'];
          $m = $exm->addRecommend($restName, $menuId, $restId);
          $lastid = $exm->conn->insert_id;
          echo json_encode(array(array(
              'method' => 'POST',
              'id' => $lastid,
              'status' => $m
          )));
          return;
    }


        if ($method === 'PUT' && count($urlData) === 1) {
            $restId = $urlData[0];
            $menuId = $formData['menu_id'];
                      $restId = $formData['restid'];
            $m = $exm->changeRecommendById($restId, $restName, $restId);
            echo json_encode(array(array(
                'method' => 'PUT',
                'id' => $lastid,
                'status' => $m
            )));
            return;
        }


        if ($method === 'PATCH' && count($urlData) === 1) {
            $restId = $urlData[0];
            $data = $exm->getReccomendById($restId);
            $data = json_decode($data, true);
            $keys = array_keys($data[0]);
            $restMenu = @$formData['menu_id'];
            $restaurant_id = @$formData['restaurant_id'];
            for($i = 0; $i < count($keys); $i++) {
              $key = $keys[$i];
            if ($key == 'menu_id') {
              if (!$menuImage) $restMenu = $data[0][$key];
            }
            if ($key == 'restaurant_id') {
              if (!$menuName) $restaurant_id = $data[0][$key];
            }

          }

            $m = $exm->changeCategoryById($restId, $restName, $image);
            echo json_encode(array(array(
                'method' => 'PATCH',
                'id' => $restId,
                'status' => $m
            )));
            return;
        }

        if ($method === 'DELETE' && count($urlData) === 1) {
          $restId = $urlData[0];
          $m = $exm->deleteRecommend($restId);
          echo json_encode(array(array(
              'method' => 'DELETE',
              'id' => $restId,
              'status' => $m
          )));
          return;
        }


  header('HTTP/1.0 400 Bad Request');
  echo json_encode(array(
      'error' => 'Bad Request'
  ));
}


?>
