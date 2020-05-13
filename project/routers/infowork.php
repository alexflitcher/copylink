<?php
require_once 'api.php';

  function route($method, $urlData, $formData) {
    require_once 'connect.php';
    $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);
      // Получение информации о товаре
      // GET /menuwork/{goodId}
      if ($method === 'GET' && count($urlData) === 1) {
          // Получаем id товара
          $menuId = $urlData[0];
        $list = $exm->getInfoById($menuId);
          // Выводим ответ клиенту
          echo $list;
          return;
      }

      if ($method === 'GET' && count($urlData) === 2 && $urlData[0] == 'type' && $urlData[1] == 'all') {
        $list = $exm->getListInfo();
        // Выводим ответ клиенту
        echo $list;
        return;
  }

  if ($method === 'POST' && empty($urlData)) {
      $countprod = $formData['countprod'];
      $countappli = $formData['countappli'];
      $deliver = $formData['deliver'];
      $name = $formData['name'];
      $phone = $formData['phone'];
      $comment = $formData['comment'];
      $pay = $formData['pay'];
      $timedel = $formData['timedel'];
      $idsprod = $formData['idsprod'];
      $address = $formData['address'];
      $souses = $formData['souses'];
      // Добавляем товар в базу...
      $res = $exm->addInfo($countprod, $countappli, $deliver, $address, $name, $phone,
                           $comment, $pay, $timedel, $idsprod, $souses);
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
        $id = $urlData[0];
        $countprod = $formData['countprod'];
        $countappli = $formData['countappli'];
        $deliver = $formData['deliver'];
        $name = $formData['name'];
        $phone = $formData['phone'];
        $comment = $formData['comment'];
        $pay = $formData['pay'];
        $timedel = $formData['timedel'];
        $idsprod = $formData['idsprod'];
        $address = $formData['address'];
        $souses = $formData['souses'];
        $res = $exm->changeInfoById($id, $countprod, $countappli, $deliver, $address, $name, $phone,
                             $comment, $pay, $timedel, $idsprod, $souses);

                             echo json_encode(array(array(
                                 'method' => 'PUT',
                                 'id' => $id,
                                 'status' => $res
                             )));
      }

    if ($method === 'PATCH' && count($urlData) === 1) {
      $id = $urlData[0];
      $data = $exm->getInfoById($id);
      $data = json_decode($data, true);
      $keys = array_keys($data[0]);
      $countprod = @$formData['countprod'];
      $countappli = @$formData['countappli'];
      $deliver = @$formData['deliver'];
      $name = @$formData['name'];
      $phone = @$formData['phone'];
      $comment = @$formData['comment'];
      $pay = @$formData['pay'];
      $timedel = @$formData['timedel'];
      $idsprod = @$formData['idsprod'];
      $address = @$formData['address'];
      $souses = $formData['souses'];

      for($i = 0; $i < count($keys); $i++) {
        $key = $keys[$i];
        if ($key == 'countprod') {
          if (!$countprod) $countprod = $data[0][$key];
        }
        if ($key == 'countappli') {
          if (!$countappli) $countappli = $data[0][$key];
        }
        if ($key == 'deliver') {
          if (!$deliver) $deliver = $data[0][$key];
        }
        if ($key == 'name') {
          if (!$name) $name = $data[0][$key];
        }
        if ($key == 'phone') {
          if (!$phone) $phone = $data[0][$key];
        }
        if ($key == 'comment') {
          if (!$comment) $comment = $data[0][$key];
        }
        if ($key == 'pay') {
          if (!$pay) $pay = $data[0][$key];
        }
        if ($key == 'timedel') {
          if (!$timedel) $timedel = $data[0][$key];
        }
        if (is_array($key)) {
          if (!$idsprod) $idsprod = $data[0][$key];
        }
        if ($key == 'address') {
          if (!$address) $address = $data[0][$key];
        }
        if ($key == 'souses') {
          if (!$souses) $souses = $data[0][$key];
        }
      }
      $res = $exm->changeInfoById($id, $countprod, $countappli, $deliver, $address, $name, $phone,
                           $comment, $pay, $timedel, $idsprod, $souses);

                           echo json_encode(array(array(
                               'method' => 'PATCH',
                               'id' => $id,
                               'status' => $res
                           )));

    }

    if ($method === 'DELETE' && count($urlData) === 1) {
        // Получаем id товара
        $id = $urlData[0];
        // Удаляем товар из базы...
        $m = $exm->deleteInfo($id);
        // Выводим ответ клиенту
        echo json_encode(array(array(
            'method' => 'DELETE',
            'id' => $id,
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
