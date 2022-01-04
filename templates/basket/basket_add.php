<?php
// Подключение бд
include_once("../../config/init.php");

// Подключение функций
include_once("../../functions/helpers.php");

if (isset($_SESSION['user'])) {
  $sql = "INSERT INTO shopping_cart SET id_user = ?, id_good = ?";
  $data = [$_SESSION['user']['id'], $_POST['id']];
  $res = db_insert_data($link, $sql, $data);
} else {
  $_SESSION['basket'][] = [
    'id' => $_POST['id'],
    'title' => $_POST['title'],
    'price' => $_POST['price'],
    'description' => $_POST['description'],
    'number' => 1
  ];
}
