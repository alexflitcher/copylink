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
$menuData = $exm->getCatalogById($id);
$menuData = json_decode($menuData, true);

if (@$_REQUEST['name']) {
  if(isset($_FILES) && $_FILES['image']['error'] == 0){ // Проверяем, загрузил ли пользователь файл
    $destiation_dir = 'img/'.'category' .mt_rand(300, 30000000) . $_FILES['image']['name']; // Директория для размещения файла
    move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
    $image = $destiation_dir;
  } else {
    $image = $menuData[0]['image'];
  }

      $name = $_REQUEST['name'];


      $s = $exm->changeCategoryById($id, $name, $image);
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

    <form action=" " method="post" enctype="multipart/form-data">
      <tr><td>Имя категории:</td> <td><input type="text" name="name" value="<?=$menuData[0]['name']?>"></td></tr>
      <tr><td>Путь к картинке(не обязательно):</td><td><input type="file" name="image" value="<?=$menuData[0]['image']?>"></td></tr>
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
    <title>Редактирование категории</title>
  </head>
  <body>
    <form  action=" " method="get">
      <table>
        <tr><th></th><th></th></tr>
        <tr><td>Выберите id категории:</td>
      <td><select name="id">
        <?php
          $listM = $exm->getListCatalogs();
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
