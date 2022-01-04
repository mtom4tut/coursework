<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

// Получение всех товаров из бд
$sql = "SELECT id, title, price, description FROM goods";
$goods = db_fetch_data($link, $sql); // получить результат выполнения подготовленного выражения
// шаблонизация main.php
$main = include_template("main.php", ["goods" => $goods]); // шаблон основной страницы


// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout