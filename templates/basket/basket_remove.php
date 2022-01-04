<?php
// Подключение бд
include_once("../../config/init.php");

// Подключение функций
include_once("../../functions/helpers.php");

if (isset($_SESSION['user'])) {
  $sql = "DELETE FROM shopping_cart WHERE id_user = ? and id_good = ?";
  $data = [$_SESSION['user']['id'], $_POST['id']];
  $res = db_insert_data($link, $sql, $data);
} else {

  $index = isset_in_array($_POST['id'], $_SESSION['basket']);
  unset($_SESSION['basket'][$index]);
}
