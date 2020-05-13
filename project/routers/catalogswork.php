<?php
require_once 'api.php';

function route($method, $urlData, $formData) {
  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);

  if ($method === 'GET' && count($urlData) === 1) {
    $id = $urlData[0];
    $list = $exm->getCatalogById($id);
    echo $list;
    return;
  }

  if ($method === 'GET' && count($urlData) === 2 && $urlData[0] === 'type' && $urlData[1] === 'all') {
    $list = $exm->getListCatalogs();
    // Выводим ответ клиенту
    echo $list;
    return;
  }

  if ($method === 'POST' && empty($urlData)) {
    $restName = $formData['name'];
    $image = $formData['img'];
    $m = $exm->addCatalogs($restName, $image);
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
      $image = $formData['image'];
      $m = $exm->changeCategoryById($restId, $restName, $image);
      echo json_encode(array(array(
          'method' => 'PUT',
          'id' => $restId,
          'status' => $m
      )));
      return;
  }

  if ($method === 'PATCH' && count($urlData) === 1) {
      $restId = $urlData[0];
      $data = $exm->getCatalogById($restId);
      $data = json_decode($data, true);
      $keys = array_keys($data[0]);
      $restName = @$formData['name'];
      $image = @$formData['image'];
      for($i = 0; $i < count($keys); $i++) {
        $key = $keys[$i];
      if ($key == 'image') {
        if (!$menuImage) $menuImage = $data[0][$key];
      }
      if ($key == 'name') {
        if (!$menuName) $menuName = $data[0][$key];
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
    $m = $exm->deleteCatalogs($restId);
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
