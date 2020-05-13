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

  $id = @$_GET['id'];
  require_once 'api.php';
  require_once 'connect.php';
  $exm = new DataBaseWorked($host, $db_user, $db_pass, $db);
  if (@$_REQUEST['menu_id']) {
    $menu_id = $_REQUEST['menu_id'];
    $s = $exm->addRecommend($menu_id, $id);
    if ($s) echo "Рекомендация добавлена успешно";
    else echo "Неудача(у ресторана уже есть Рекомендация)";
  }

if (!@$_GET['id']) {

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Добавить рекомендацию</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action=" " method="get">
      <table>
        <tr>
          <th></th><th></th>
        </tr>
        <tr>
          <td>Id ресторана:</td>
          <td><select name="id">
            <?php
            $list = $exm->getListRestaurants();
            $list = json_decode($list, true);
            for ($i=0; $i < count($list); $i++) {
              echo "<option value='{$list[$i]['id']}'>{$list[$i]['id']} (имя: {$list[$i]['name']})</option>";
            }
           ?></select></td>
        </tr>
        <tr>
          <td><input type="submit" value="Добавить"> </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php } else { ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Добавление рекомендации</title>
    </head>
    <body>
      <form action=" " method="post">
        <table>
          <tr>
            <th></th><th></th>
          </tr>
          <tr>
            <td>Id меню выбранного ресторана:</td>
            <td><select name="menu_id">
              <?php


              $id = $_GET['id'];
              $list = $exm->getMenuByIdRestaurant($id);
              $list = json_decode($list, true);
              for ($i=0; $i < count($list); $i++) {
                echo "<option value='{$list[$i]['id']}'>{$list[$i]['id']} (имя: {$list[$i]['name']})</option>";
              }
             ?></select></td>
          </tr>
          <tr>
            <td><input type="submit" value="Добавить"> </td>
          </tr>
        </table>
      </form>
    </body>
  </html>
<?php } ?>
<?php } ?>
