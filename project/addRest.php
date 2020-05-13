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

if (@$_REQUEST['name']) {
  $name = $_REQUEST['name'];

  $s = $exm->addRestaurant($name);

  if ($s) echo "Ресторан добавлен";
  else echo "Неудача";
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Добавить ресторан</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action=" " method="post">
      <table>
        <tr>
          <th></th><th></th>
        </tr>
        <tr>
          <td>Имя ресторана:</td>
          <td><input type="text" name="name" value=""></td>
        </tr>
        <tr>
          <td><input type="submit" value="Добавить"> </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php } ?>
