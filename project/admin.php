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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админка</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="header">

    </div>
    <div class="content">
      <h3>Редактирование, добавление, удаление</h3><br>
      <div class="links">
      <a href="changerestname.php">Изменить название ресторана по id</a><br>
      <a href="changeidposmenu.php">Изменить позицию меню по id меню</a><br>
      <a href="changeinfo.php">Изменить информацию о заказе через id заказа</a><br>
      <a href="changerecomendbyid.php">Изменить рекомендации по id</a><br>
      <a href="changesouses.php">Изменить информацию о соусе</a><br>
      <a href="changecatalogs.php">Изменить название категории</a><br><br>
      <a href="addmenu.php">Добавить позицию меню</a><br>
      <a href="addRest.php">Добавить ресторан</a><br>
      <a href="addinfo.php">Добавить заказ</a><br>
      <a href="addrecommend.php">Добавить рекомендацию</a><br>
      <a href="addsouse.php">Добавить соус</a><br>
      <a href="addcatalogs.php">Добавить категорию</a><br><br>
      <a href="delposmenu.php">Удалить позицию меню</a><br>
      <a href="delrest.php">Удалить ресторан</a><br>
      <a href="delinfo.php">Удалить заказ</a><br>
      <a href="delrecomend.php">Удалить рекомендацию</a><br>
      <a href="delsouse.php">Удалить соус</a><br>
      <a href="delcatalogs.php">Удалить категорию</a>
    </div>
      <br><br> <p class="list_rest">Список ресторанов:</p>

      <table>
        <tr><th>Id</th><th>Name</th></tr>

      <?php
        $listR = $exm->getListRestaurants();
        $listR = json_decode($listR, true);
        for ($i=0; $i < count($listR); $i++) {

            echo "<tr><td>{$listR[$i]['id']}</td><td>{$listR[$i]['name']}</td></tr>";

        }

      ?>
      </table>

      <br><br><br> <p class="list_menu">Список позиций меню:</p>
      <table>
        <tr><th>Id</th><th>Image</th><th>Name</th><th>Category</th><th>Description</th><th>Price</th><th>Calories</th><th>New</th><th>Old_price</th><th>New_Price</th><th>Weight</th><th>Restaurant_id</th></tr>


      <?php
          $listM = $exm->getListMenu();
          $listM = json_decode($listM, true);
          for ($i=0; $i < count($listM); $i++) {

              echo "<tr><td>{$listM[$i]['id']}</td><td>{$listM[$i]['image']}</td><td>{$listM[$i]['name']}</td><td>{$listM[$i]['category']}</td><td>{$listM[$i]['description']}</td><td>{$listM[$i]['price']}</td><td>{$listM[$i]['price']}</td><td>{$listM[$i]['calories']}</td><td>{$listM[$i]['new']}</td><td>{$listM[$i]['oldprice']}</td><td>{$listM[$i]['newprice']}</td><td>{$listM[$i]['weight']}</td> <td>{$listM[$i]['restaurant_id']}</td></tr>";

          }

      ?>
        </table>

          <br><br>  <p class="list_info">Текущие заказы:</p>

          <table>
            <tr><th>Id</th><th>Count_products</th><th>Count_appliance</th><th>Delivery</th><th>Address</th><th>Name</th><th>Phone</th><th>Comment</th><th>Pay</th><th>Time_delivery</th><th>Ids_products</th><th>Souses</th><th>Total_price</th></tr>


          <?php
              $listI = $exm->getListInfo();

              $listI = json_decode($listI, true);

              for ($i=0; $i < count($listI); $i++) {

                echo "<tr><td>{$listI[$i]['id']}</td><td>{$listI[$i]['countprod']}</td><td>{$listI[$i]['countappli']}</td><td>{$listI[$i]['deliver']}</td><td>{$listI[$i]['address']}</td><td>{$listI[$i]['name']}</td><td>{$listI[$i]['phone']}</td><td>{$listI[$i]['comment']}</td><td>{$listI[$i]['pay']}</td><td>{$listI[$i]['timedel']}</td><td>";
                for ($j=0; $j < count($listI[$i]['idsprod']); $j++) {
                  echo "{$listI[$i]['idsprod'][$j]},";
                }
                echo "</td><td>";
                for ($s=0; $s < count($listI[$i]['souses']); $s++) {
                  echo "{$listI[$i]['souses'][$s]},";
                }
                echo "</td>";
                echo "<td>{$listI[$i]['totalprice']}</td>";
                  echo "</td></tr>";
              }


          ?>

              </table>

          <br><br> <p class="list_rest">Список рекомендаций:</p>

          <table>
            <tr><th>Id</th><th>Menu_id</th><th>Restaurant_id</th></tr>

          <?php
            $listR = $exm->getListRecommend();
            $listR = json_decode($listR, true);
            for ($i=0; $i < count($listR); $i++) {
              echo "<tr><td>{$listR[$i]['id']}
              </td><td>{$listR[$i]['menu_id']}
              </td><td>{$listR[$i]['restaurant_id']}</td></tr>";
            }
          ?>
        </table>


        <br><br> <p class="list_rest">Список категорий:</p>

        <table>
          <tr><th>Id</th><th>Name</th><th>Image</th></tr>

        <?php
          $listR = $exm->getListCatalogs();
          $listR = json_decode($listR, true);
          for ($i=0; $i < count($listR); $i++) {
            echo "<tr><td>{$listR[$i]['id']}
            </td><td>{$listR[$i]['name']}
            </td><td>{$listR[$i]['image']}</td></tr>";
          }
        ?>
      </table>
      <br><br> <p class="list_rest">Список соусов:</p>

      <table>
        <tr><th>Id</th><th>Name</th><th>Price</th><th>Restaurant_id</th></tr>

      <?php
        $listR = $exm->getListSouses();
        $listR = json_decode($listR, true);
        for ($i=0; $i < count($listR); $i++) {
          echo "<tr><td>
          {$listR[$i]['id']}
          </td><td>
          {$listR[$i]['name']}
          </td>  <td>
          {$listR[$i]['price']}
          </td> <td>
          {$listR[$i]['restaurant_id']}
          </td> </tr>";
        }
      ?>
    </table>
    </div>
    <div class="footer">

    </div>
  </body>
</html>

<?php } ?>
