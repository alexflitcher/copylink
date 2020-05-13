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

if (@$_GET['id']) {



$id = $_GET['id'];
$menuData = $exm->getSouseById($id);
$menuData = json_decode($menuData, true);

if (@$_REQUEST['name'] && @$_REQUEST['price'] && @$_REQUEST['rest_id']) {
  $name = $_REQUEST['name'];
  $price = $_REQUEST['price'];
  $rest_id = $_REQUEST['rest_id'];

    $s = $exm->changeSouseById($id, $name, $price, $rest_id);
    echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
      if ($s) echo "Сохранено";
      else echo "Неудача";

    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Редактирование соуса</title>
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
        <td>Имя соуса</td><td><input type="text" name="name" value='<?=$menuData[0]['name']?>'></td>
      </tr>
      <tr>
        <td>Цена соуса:</td><td><input type="number" name="price" value='<?=$menuData[0]['price']?>'></td>
      </tr>
      <tr>
        <td>ID ресторана</td><td><select name="rest_id">
          <?php
            $list = $exm->getListRestaurants();
            $list = json_decode($list, true);

            for ($i = 0; $i < count($list); $i++) {
              $checked = "";
              if ($list[$i]['id'] == $menuData[0]['restaurant_id']) $checked = "selected";

              echo "<option value='{$list[$i]['id']}' $checked>{$list[$i]['id']} (имя: {$list[$i]['name']})</option>";
            }
          ?>
        </select></td>
      </tr>
      <tr><td><input type="submit" value="Сохранить"></td></tr>
    </form>
  </table>
  </body>
</html>

<?php
} else {


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Изменение соуса</title>
  </head>
  <body>
    <form  action=" " method="get">
      <table>
        <tr><th></th><th></th></tr>
        <tr><td>Выберите id категории:</td>
      <td><select name="id">
        <?php
          $listM = $exm->getListSouses();
          $listM = json_decode($listM, true);
          print_r($listM);
          for ($i=0; $i < count($listM); $i++) {
            $listq = $exm->getRestaurantById($listM[$i]['restaurant_id']);
            $listq = json_decode($listq, true);
            print_r($listq);
            echo "<option value='{$listM[$i]['id']}'>{$listM[$i]['id']} (ресторан соуса: {$listq[0]['name']})</option>";
          }

        ?>
      </select></td></tr>
      <tr><td><input type="submit" value="Преступить к редактированию"></td></tr>
    </form>
  </body>
</html>
<?php
}
 ?>
<?php } ?>
