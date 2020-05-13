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
$menuData = $exm->getMenuById($id);
$menuData = json_decode($menuData, true);

if (@$_REQUEST['name'] && @$_REQUEST['category'] && @$_REQUEST['descript'] &&
    @$_REQUEST['price'] && @$_REQUEST['old_price'] && @$_REQUEST['new_price'] && @$_REQUEST['weight'] &&
    @$_REQUEST['rest_id'] && @$_REQUEST['calories'] && @$_REQUEST['new']) {
      if(isset($_FILES) && $_FILES['image']['error'] == 0){ // Проверяем, загрузил ли пользователь файл
$destiation_dir = 'img/'.'menu' .mt_rand(300, 30000000) . $_FILES['image']['name']; // Директория для размещения файла
move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
$image = $destiation_dir;
} else {
  $image = $menuData[0]['image'];
}
      $name = $_REQUEST['name'];
      $category = $_REQUEST['category'];
      $descript = $_REQUEST['descript'];
      $price = $_REQUEST['price'];
      $oldprice = $_REQUEST['old_price'];
      $newprice = $_REQUEST['new_price'];
      $weight = $_REQUEST['weight'];
      $rest_id = $_REQUEST['rest_id'];
      $calories = $_REQUEST['calories'];
      $new = $_REQUEST['new'];

      $s = $exm->changeMenuById($id, $image, $name, $category, $descript, $price,
                                 $calories, $new, $oldprice, $newprice, $weight,
                                 $rest_id);
echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
      if ($s) echo "Сохранено";
      else echo "Неудача";

    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Редактирование позиции меню</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <table>
      <tr>
        <th></th>
        <th></th>
      </tr>

    <form action=" " method="post" enctype="multipart/form-data">
      <tr><td>Путь к картинке(не обезательно):</td><td><input type="file" name="image" value="<?=$menuData[0]['image']?>"></td></tr>
      <tr><td>Имя товара:</td> <td><input type="text" name="name" value="<?=$menuData[0]['name']?>"></td></tr>
      <tr><td>Категория:</td><td><select name="category">
          <?php
          $listR = $exm->getListCatalogs();
          $listR = json_decode($listR, true);
          for ($i=0; $i < count($listR); $i++) {
                $osb = "";
                if ($listR[$i]['id'] == $menuData[0]['category']) $osb = "selected";
              echo "<option value='{$listR[$i]['id']}' $osb>{$listR[$i]['name']} (id: {$listR[$i]['id']})</option>";

          }

          ?>
      </select> </td></tr>
      <tr><td>Описание:</td><td><textarea name="descript" rows="8" cols="80"><?=$menuData[0]['description']?></textarea></td></tr>
      <tr><td>Цена:</td><td><input type="number" name="price" value="<?=$menuData[0]['price']?>"></td></tr>
      <tr><td>Кол-во каллорий:</td><td><input type="number" name="calories" value="<?=$menuData[0]['calories']?>"></td></tr>
      <tr><td>Товар новинка?:</td><td><select name="new" ><?php
          if ($menuData[0]['new'] == 'true') $exit = '<option value="true" selected>Да</option><option value="false">Нет</option>';
          elseif ($menuData[0]['new'] == 'false') $exit = '<option value="true">Да</option><option value="false" selected>Нет</option>';

          echo $exit;
      ?> </select> </td></tr>
      <tr><td>Старая цена:</td><td> <input type="number" name="old_price" value="<?=$menuData[0]['oldprice']?>"></td></tr>
      <tr><td>Новая цена:</td> <td><input type="number" name="new_price" value="<?=$menuData[0]['newprice']?>"></td></tr>
      <tr><td>Вес товара:</td> <td><input type="number" name="weight" value="<?=$menuData[0]['weight']?>"></td></tr>
      <tr><td>ID Ресторана: </td><td><select name="rest_id">
        <?php
        $listR = $exm->getListRestaurants();
        $listR = json_decode($listR, true);
        for ($i=0; $i < count($listR); $i++) {
              $osb = "";
              if ($listR[$i]['id'] == $menuData[0]['restaurant_id']) $osb = "selected";
            echo "<option value='{$listR[$i]['id']}' $osb>{$listR[$i]['name']} (id: {$listR[$i]['id']})</option>";

        }
        ?>
      </select> </td></tr>
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
    <title>Редактирование позиции меню</title>
  </head>
  <body>
    <form  action=" " method="get">
      <table>
        <tr><th></th><th></th></tr>
        <tr><td>Выберите id позиции:</td>
      <td><select name="id">
        <?php
          $listM = $exm->getListMenu();
          $listM = json_decode($listM, true);
          for ($i=0; $i < count($listM); $i++) {
            echo "<option value='{$listM[$i]['id']}'>{$listM[$i]['id']} (имя: {$listM[$i]['name']})</option>";
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
