<?php
require_once 'api.php';
// Роутер
function route($method, $urlData, $formData) {
  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);
    // Получение информации о товаре
    // GET /menuwork/{goodId}
    if ($method === 'GET' && count($urlData) === 1) {
        // Получаем id товара
        $menuId = $urlData[0];
      $list = $exm->getMenuById($menuId);
        // Выводим ответ клиенту
        echo $list;
        return;
    }

    if ($method === 'GET' && count($urlData) === 2 && $urlData[1] === 'all' && $urlData[0] === 'type') {
        $list = $exm->getListMenu();
        // Выводим ответ клиенту
        echo $list;
        return;
    }


if ($method === 'GET' && count($urlData) === 2 && $urlData[1] ===  'restid') {
    $restId = $urlData[0];
    $list = $exm->getMenuByIdRestaurant($restId);
    // Выводим ответ клиенту
    echo $list;
    return;
}

    // Добавление нового товара
    // POST /menuwork
    if ($method === 'POST' && empty($urlData)) {
        $menuImage = $formData['image'];
        $menuName = $formData['name'];
        $menuCategory = $formData['category'];
        $menuDescription = $formData['description'];
        $menuPrice = $formData['price'];
        $menuCalories = $formData['calories'];
        $menuNew = $formData['new'];
        $menuOldprice = $formData['oldprice'];
        $menuNewprice = $formData['newprice'];
        $menuWeight = $formData['weight'];
        $menuRestId = $formData['restaurant_id'];
        // Добавляем товар в базу...
        $res = $exm->addPositionMenu($menuImage, $menuName, $menuCategory, $menuDescription,
                                     $menuPrice, $menuCalories, $menuNew, $menuOldprice,
                                      $menuNewprice, $menuWeight, $menuRestId);
        $lastid = $exm->conn->insert_id;
        // Выводим ответ клиенту
        echo json_encode(array(array(
            'method' => 'POST',
            'id' => $lastid,
            'status' => $res
        )));
        return;
    }


    // Обновление всех данных товара
    // PUT /menuwork/{goodId}
    if ($method === 'PUT' && count($urlData) === 1) {
        // Получаем id товара
        $menuId = $urlData[0];
        $menuImage = $formData['image'];
        $menuName = $formData['name'];
        $menuCategory = $formData['category'];
        $menuDescription = $formData['description'];
        $menuPrice = $formData['price'];
        $menuCalories = $formData['calories'];
        $menuNew = $formData['new'];
        $menuOldprice = $formData['oldprice'];
        $menuNewprice = $formData['newprice'];
        $menuWeight = $formData['weight'];
        $menuRestId = $formData['restaurant_id'];
        $res = $exm->changeMenuById($menuId ,$menuImage, $menuName, $menuCategory, $menuDescription,
                                     $menuPrice, $menuCalories, $menuNew, $menuOldprice,
                                      $menuNewprice, $menuWeight, $menuRestId);
        // Обновляем все поля товара в базе...
        // Выводим ответ клиенту
        echo json_encode(array(array(
            'method' => 'PUT',
            'id' => $menuId,
            'status' => $res
        )));
    }


    // Частичное обновление данных товара
    // PATCH /menuwork/{goodId}
    if ($method === 'PATCH' && count($urlData) === 1) {
        // Получаем id товара
        $menuId = $urlData[0];
        $data = $exm->getMenuById($menuId);
        $data = json_decode($data, true);
        $keys = array_keys($data[0]);
        $menuId = $urlData[0];
        $menuImage = @$formData['image'];
        $menuName = @$formData['name'];
        $menuCategory = @$formData['category'];
        $menuDescription = @$formData['description'];
        $menuPrice = @$formData['price'];
        $menuCalories = @$formData['calories'];
        $menuNew = @$formData['new'];
        $menuOldprice = @$formData['oldprice'];
        $menuNewprice = @$formData['newprice'];
        $menuWeight = @$formData['weight'];
        $menuRestId = @$formData['restaurant_id'];

          for($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
          if ($key == 'image') {
            if (!$menuImage) $menuImage = $data[0][$key];
          }
          if ($key == 'name') {
            if (!$menuName) $menuName = $data[0][$key];
          }
          if ($key == 'category') {
            if (!$menuCategory) $menuCategory = $data[0][$key];
          }
          if ($key == 'description') {
            if (!$menuDescription) $menuDescription = $data[0][$key];
          }
          if ($key == 'price') {
            if (!$menuPrice) $menuPrice = $data[0][$key];
          }
          if ($key == 'calories') {
            if (!$menuCalories) $menuCalories = $data[0][$key];
          }
          if ($key == 'new') {
            if (!$menuNew) $menuNew = $data[0][$key];
          }
          if ($key == 'oldprice') {
            if (!$menuOldprice) $menuOldprice = $data[0][$key];
          }
          if ($key == 'newprice') {
            if (!$menuNewprice) $menuNewprice = $data[0][$key];
          }
          if ($key == 'weight') {
            if (!$menuWeight) $menuWeight = $data[0][$key];
          }
          if ($key == 'restaurant_id') {
            if (!$menuRestId) $menuRestId = $data[0][$key];
          }
        }

        // Обновляем только указанные поля товара в базе...
        $res = $exm->changeMenuById($menuId, $menuImage, $menuName, $menuCategory, $menuDescription,
                                     $menuPrice, $menuCalories, $menuNew, $menuOldprice,
                                      $menuNewprice, $menuWeight, $menuRestId);
        // Выводим ответ клиенту
        echo json_encode(array(array(
            'method' => 'PATCH',
            'id' => $menuId,
            'status' => $res
        )));
        return;
    }

    // Удаление товара
    // DELETE /menuwork/{goodId}
    if ($method === 'DELETE' && count($urlData) === 1) {
        // Получаем id товара
        $menuId = $urlData[0];
        // Удаляем товар из базы...
        $m = $exm->deletePositionMenu($menuId);
        // Выводим ответ клиенту
        echo json_encode(array(array(
            'method' => 'DELETE',
            'id' => $menuId,
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
