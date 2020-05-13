<?php
require_once 'api.php';
function route($method, $urlData, $formData) {
  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);

  if ($method === 'GET' && count($urlData) === 1) {
      // Получаем id товара
      $menuId = $urlData[0];
    $list = $exm->getSouseById($menuId);
      // Выводим ответ клиенту
      echo $list;
      return;
  }

  if ($method === 'GET' && count($urlData) === 2 && $urlData[0] == 'type' && $urlData[1] == 'all') {
    $list = $exm->getListSouses();
    // Выводим ответ клиенту
    echo $list;
    return;
}

    if ($method === 'POST' && empty($urlData)) {
      $name = $formData['name'];
      $price = $formData['price'];
      $rest_id = $formData['restaurant_id'];

      $res = $exm->addSouse($name, $price, $rest_id);
      $lastid = $exm->conn->insert_id;
      // Выводим ответ клиенту
      echo json_encode(array(array(
          'method' => 'POST',
          'id' => $lastid,
          'status' => $res
      )));
      return;
    }


    if ($method === 'PUT' && count($urlData) === 1) {
      $menuId = $urlData[0];
      $name = $formData['name'];
      $price = $formData['price'];
      $rest_id = $formData['restaurant_id'];

      $res = $exm->changeSouseById($menuId, $name, $price, $rest_id);
      // Выводим ответ клиенту
      echo json_encode(array(array(
          'method' => 'PUT',
          'id' => $menuId,
          'status' => $res
      )));
      return;
    }

    if ($method === 'PATCH' && count($urlData) === 1) {
        $restId = $urlData[0];
        $data = $exm->getSouseById($restId);
        $data = json_decode($data, true);
        $keys = array_keys($data[0]);
        $name = @$formData['name'];
        $price = @$formData['price'];
        $rest_id = @$formData['restaurant_id'];

        for($i = 0; $i < count($keys); $i++) {
          $key = $keys[$i];
        if ($key == 'name') {
          if (!$name) $name = $data[0][$key];
        }
        if ($key == 'price') {
          if (!$price) $price = $data[0][$key];
        }
        if ($key == 'restaurant_id') {
          if (!$rest_id) $rest_id = $data[0][$key];
        }
      }

        $m = $exm->changeSouseById($restId, $name, $price, $rest_id);
        echo json_encode(array(array(
            'method' => 'PATCH',
            'id' => $restId,
            'status' => $m
        )));
        return;
    }


    if ($method === 'DELETE' && count($urlData) === 1) {
      $restId = $urlData[0];
      $m = $exm->deleteSouse($restId);
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
