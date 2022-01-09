<?php
// Подключение бд
include_once("../../../config/init.php");

// Подключение функций
include_once("../../../functions/helpers.php");

if (isset($_POST['name']) && $_POST['name'] == "discount") {
  $sql = "UPDATE premium_bonus SET discount = ?";
  $empty = db_fetch_data($link, $sql, [$_POST["value"]]);
}

if (isset($_POST['name']) && $_POST['name'] == "bonus") {
  $sql = "UPDATE premium_bonus SET bonus = ?";
  $empty = db_fetch_data($link, $sql, [$_POST["value"]]);
}
?>