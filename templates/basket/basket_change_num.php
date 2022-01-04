<?php
// Подключение бд
include_once("../../config/init.php");

// Подключение функций
include_once("../../functions/helpers.php");

if (isset($_SESSION['user'])) {
  $sql = "UPDATE shopping_cart SET number = ? WHERE id_user = ? and id_good = ?";
  $data = [$_POST['value'], $_SESSION['user']['id'], $_POST['id']];
  $res = db_insert_data($link, $sql, $data);
} else {
  $index = isset_in_array($_POST['id'], $_SESSION['basket']);
  $_SESSION['basket'][$index]['number'] = $_POST['value'];
}
