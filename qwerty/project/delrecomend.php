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
    $s = $exm->deleteRecommend($id);

    if ($s) echo "Рекомендация удалёна";
    else echo "Неудача";
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Удаление рекомендаций</title>
        <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h2>ВНИМАНИЕ! После удаления рекомендации восстановить её будет невозможно</h2>
    <form  action=" " method="post">
      Выберите id рекомендации:
      <select name="id">
        <?php
          $listR= $exm->getListRecommend();
          $listR = json_decode($listR, true);
          $keys = array_keys($listR);
          for ($i=0; $i < count($listR); $i++) {
              $list = $exm->getRestaurantById($listR[$i]['restaurant_id']);
              $list = json_decode($list, true);
              echo "<option value='{$listR[$i]['id']}'>id: {$listR[$i]['id']} (имя: {$list[0]['name']})</option>";
          }
        ?>
      </select><br>
      <input type="submit" value="Удалить"><br>
    </form>
  </body>
</html>

<?php } ?>
