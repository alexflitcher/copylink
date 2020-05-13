<?php
$us = "admin";
$passw = "metaFaleGet12425OnN";
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

if (@$_REQUEST['id'] && @$_REQUEST['name']) {
  $id = $_REQUEST['id'];
  $name = $_REQUEST['name'];

  $s = $exm->changeNameRestaurantById($id, $name);
  echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
  if ($s) echo "Смена произошла успешно";
  else echo "Неудача";
} else {
    echo "Пожалуйста заполните все поля";
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Смена имени ресторана</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action=" " method="post">
      <table>
        <tr><th></th><th></th></tr>
      <tr><td>Выберите ресторан:</td>
        <td><select name="id">
        <?php

          $listR = $exm->getListRestaurants();
          $listR = json_decode($listR, true);

          $keys = array_keys($listR);

          for ($i=0; $i < count($listR); $i++) {
            echo "<option value='{$listR[$i]['id']}'>{$listR[$i]['name']} (id: {$listR[$i]['id']})</option>";

          }
        ?>
      </select></td><tr>
      <tr><td>Введите новое имя для ресторана:</td> <td><input type="text" name="name"></td></tr>
      <tr><td><input type="submit" value="Сменить имя"></td></tr>
    </table>
    </form>
  </body>
</html>
<?php } ?>
