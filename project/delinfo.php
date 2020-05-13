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
    $s = $exm->deleteInfo($id);

    if ($s) echo "Заказ удалён";
    else echo "Неудача";
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Удаление заказа</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h2>ВНИМАНИЕ! После удаления заказа восстановить его будет невозможно</h2>
    <form  action=" " method="post">
      Выберите id ресторана:
      <select name="id">
        <?php
          $listR = $exm->getListInfo();
          $listR = json_decode($listR, true);

          for ($i=0; $i < count($listR); $i++) {
            echo "<option values='{$listR[$i]['id']}'>{$listR[$i]['id']} (имя: {$listR[$i]['name']})</option>";
          }
        ?>
      </select><br>
      <input type="submit" value="Удалить"><br>
    </form>
  </body>
</html>

<?php } ?>
