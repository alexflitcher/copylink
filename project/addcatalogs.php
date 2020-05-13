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

if (@$_REQUEST['name'] && @$_FILES['image']) {

  if(isset($_FILES) && $_FILES['image']['error'] == 0){ // Проверяем, загрузил ли пользователь файл
    $destiation_dir = 'img/'.'category' .mt_rand(300, 30000000) . $_FILES['image']['name']; // Директория для размещения файла
    move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir ); // Перемещаем файл в желаемую директорию
  }

  $image = $destiation_dir;
  $name = $_REQUEST['name'];
  $s = $exm->addCatalogs($name, $image);
  echo "<script>setTimeout(function() {window.location = window.location}, 500)</script>";
  if ($s) echo "Каталог добавлен";
  else echo "Неудача";
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Добавить категорию</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action=" " method="post" enctype="multipart/form-data">
      <table>
        <tr>
          <th></th><th></th>
        </tr>
        <tr>
          <td>Имя категории:</td>
          <td><input type="text" name="name" value=""></td>
        </tr>
        <tr>
          <td>Путь к картинке:</td>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <td><input type="submit" value="Добавить"> </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php } ?>
