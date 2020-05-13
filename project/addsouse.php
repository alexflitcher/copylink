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

if (@$_REQUEST['name'] && @$_REQUEST['price']  && @$_REQUEST['rest_id']) {
  $name = $_REQUEST['name'];
  $price = $_REQUEST['price'];
  $rest_id = $_REQUEST['rest_id'];

  $s = $exm->addSouse($name, $price, $rest_id);

  if ($s) echo "Соус добавлен";
  else echo "Неудача";
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Добавить соус</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action=" " method="post">
      <table>
        <tr>
          <th></th><th></th>
        </tr>
        <tr>
          <td>Имя соуса:</td><td><input type="text" name="name"></td>
        </tr>
        <tr>
          <td>Цена:</td><td><input type="num" name="price"></td>
        </tr>
        <tr>
          <td>ID ресторана:</td><td><select name="rest_id">
                <?php
                  $list = $exm->getListRestaurants();
                  $list = json_decode($list, true);

                  for ($i=0; $i < count($list); $i++) {
                    echo "<option value='{$list[$i]['id']}'>{$list[$i]['id']}  (имя: {$list[$i]['name']})</option>'";
                  }
                ?>
          </select>
          </td>
        </tr>
        <tr>
          <td><input type="submit" value="Добавить"> </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php } ?>
