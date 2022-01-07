<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

// Получение всех товаров из бд
$sql = "SELECT id, title, price, description FROM goods";
if (isset($_GET['search'])) {
  if ($_GET['search'] === "") {
    header("Location: /"); // переадресация
    exit();
  }
  $sql .= " where MATCH(title) AGAINST(? IN BOOLEAN MODE)";
  $goods = db_fetch_data($link, $sql, [$_GET['search']]);
} else {
  $goods = db_fetch_data($link, $sql);
}

// шаблонизация main.php
$main = include_template("main.php", ["goods" => $goods]); // шаблон основной страницы


// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout