<?php
// Подключение бд
include_once("../../config/init.php");

// Подключение функций
include_once("../../functions/helpers.php");

if (isset($_SESSION['user'])) {
  $sql = "SELECT COUNT(*) from shopping_cart where id_user = ? and id_good = ?";
  $data = [$_SESSION['user']['id'], $_POST['id']];
  $count = db_fetch_data($link, $sql, $data)[0]["COUNT(*)"];
  
  if ($count === 0) {
    $sql = "INSERT INTO shopping_cart SET id_user = ?, id_good = ?";
    $data = [$_SESSION['user']['id'], $_POST['id']];
    $res = db_insert_data($link, $sql, $data);
  }
} else {
  if (isset_in_array($_POST['id'], $_SESSION['basket']) === -1) {
    $_SESSION['basket'][] = [
      'id' => $_POST['id'],
      'title' => $_POST['title'],
      'price' => $_POST['price'],
      'description' => $_POST['description'],
      'number' => 1
    ];
  }
}
