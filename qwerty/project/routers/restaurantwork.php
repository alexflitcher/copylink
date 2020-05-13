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
        $list = $exm->getRestaurantById($restId);
        // Выводим ответ клиенту
        echo $list;
        return;
    }

    if ($method === 'GET' && count($urlData) === 2 && $urlData[1] === 'all' && $urlData[0] === 'type') {
        $list = $exm->getListRestaurants();
        // Выводим ответ клиенту
        echo $list;
        return;
    }

    if ($method === 'GET' && count($urlData) === 2 && $urlData[1] === 'categ') {
        $restId = $urlData[0];
        $list = $exm->getListCategoryByIdRestaurant($restId);
        $list = json_decode($list, true);


        $list = json_encode($list, JSON_UNESCAPED_UNICODE);
        // Выводим ответ клиенту
        echo $list;
        return;
    }

        if ($method === 'GET' && count($urlData) === 2 && $urlData[1] === 'souses') {
          $id = $urlData[0];
          $list = $exm->getListSousesByRestId($id);
          echo $list;

          return;
        }

    if ($method === 'POST' && empty($urlData)) {
          $restName = $formData['name'];
          $m = $exm->addRestaurant($restName);
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
        $restName = $formData['name'];
        $m = $exm->changeNameRestaurantById($restId, $restName);
        echo json_encode(array(array(
            'method' => 'PUT',
            'id' => $restId,
            'status' => $m
        )));
        return;
    }

    if ($method === 'PATCH' && count($urlData) === 1) {
        $restId = $urlData[0];
        $restName = $formData['name'];
        $m = $exm->changeNameRestaurantById($restId, $restName);
        echo json_encode(array(array(
            'method' => 'PATCH',
            'id' => $restId,
            'status' => $m
        )));
        return;
    }

      if ($method === 'DELETE' && count($urlData) === 1) {
        $restId = $urlData[0];
        $m = $exm->deleteRestaurant($restId);
        echo json_encode(array(array(
            'method' => 'DELETE',
            'id' => $restId,
            'status' => $m
        )));
        return;
      }


    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}
