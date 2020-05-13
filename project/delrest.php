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

  if (@$_POST['id']) {
    $id = $_POST['id'];
    $s = $exm->deleteRestaurant($id);

    if ($s) echo "Ресторан удалён";
    else echo "Неудача";
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Удаление ресторана</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h2>ВНИМАНИЕ! После удаления ресторана восстановить его будет невозможно</h2>
    <form  action=" " method="post">
      Выберите id ресторана:
      <select name="id">
        <?php

                  $listR = $exm->getListRestaurants();
                  $listR = json_decode($listR, true);

                  $keys = array_keys($listR);

                  for ($i=0; $i < count($listR); $i++) {
                    echo "<option value='{$listR[$i]['id']}'>{$listR[$i]['name']} (id: {$listR[$i]['id']})</option>";

                  }
        ?>
      </select><br>
      <input type="submit" value="Удалить"><br>
    </form>
  </body>
</html>

<?php } ?>
