<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

// Получение всех товаров из бд
$sql = "SELECT g.id, g.title, g.price, g.description, s.discount, s.bonuses, s.data_start, s.data_end FROM goods g LEFT JOIN stock s on s.id_good = g.id";

if (isset($_GET['discounts'])) {
  $sql = "SELECT g.id, g.title, g.price, g.description, s.discount, s.bonuses, s.data_start, s.data_end FROM goods g JOIN stock s on s.id_good = g.id WHERE s.data_start <= CURRENT_DATE AND CURRENT_DATE <= s.data_end";
}

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

$count = 0;
if (isset($_SESSION['user'])) {
  $sql = "SELECT COUNT(*) FROM bonus_cards WHERE id_user = ?";
  $count = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]["COUNT(*)"];
}

// шаблонизация main.php
$main = include_template("main.php", ["goods" => $goods, "count" => $count]); // шаблон основной страницы


// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout