<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

// Получение всех товаров корзины
$goods = "";

if (isset($_SESSION['user'])) {
  $sql = "SELECT g.id, g.title, g.price, g.description, sc.number from goods g join shopping_cart sc on g.id = sc.id_good WHERE sc.id_user = ?";
  $goods = db_fetch_data($link, $sql, [$_SESSION['user']['id']]);
}
elseif (isset($_SESSION['basket'])) {
  $goods = $_SESSION['basket'];
}

// шаблонизация main.php
$main = include_template("basket/basket.php", ["goods" => $goods]); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead - Корзина", // Заголовок страницы
  "main" => $main // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout