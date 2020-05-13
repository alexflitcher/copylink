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
$menuData = $exm->getReccomendByIdRest($id);
$menuData = json_decode($menuData, true);

if ( @$_REQUEST['postmenu']) {
      $id_menu = $_REQUEST['postmenu'];


      $s = $exm->changeRecommendById($menuData[0]['recommend_id'], $id_menu, $id);
echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
      if ($s) echo "Сохранено";
      else echo "Неудача";

    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Редактирование категории</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <table>
      <tr>
        <th></th>
        <th></th>
      </tr>
      <?php
      $listOff=  $exm->getReccomendByIdRest($id);
      $listOff = json_decode($listOff);
      if (empty($listOff)) die("У данного ресторана ещё нет рекомендации");
      ?>
    <form action=" " method="post">
        <tr>
          <td>ID меню: </td><td><select name="postmenu">
              <?php
                $list = $exm->getMenuByIdRestaurant($id);
                $list = json_decode($list, true);
                for ($i=0; $i < count($list); $i++) {
                  $osb = "";
            if ($list[$i]['id'] == $menuData[0]['menu_id']) $osb = "selected";
                  echo "<option value='{$list[$i]['id']}' $osb>{$list[$i]['id']} (имя: {$list[$i]['name']})</option>";
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
    <title>Редактирование рекомендации</title>
  </head>
  <body>
    <form  action=" " method="get">
      <table>
        <tr><th></th><th></th></tr>
        <tr><td>Выберите id ресторана:</td>
      <td><select name="id">
        <?php
          $listM = $exm->getListRestaurants();
          $listM = json_decode($listM, true);
          for ($i=0; $i < count($listM); $i++) {
            echo "<option value='{$listM[$i]['id']}'>{$listM[$i]['id']} (имя ресторана: {$listM[$i]['name']})</option>";
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
