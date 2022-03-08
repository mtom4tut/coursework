<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

if (empty($_SESSION['user'])) {
  header("Location: index.php"); // переадресация
  exit();
}

$_SESSION['user']["mailing_list"] = !$_SESSION['user']["mailing_list"];

$sql = "UPDATE users SET mailing_list = ? WHERE id = ?";
$data = db_insert_data($link, $sql, [+$_SESSION['user']["mailing_list"], $_SESSION['user']["id"]]);
header("Location: index.php"); // переадресация
exit();
