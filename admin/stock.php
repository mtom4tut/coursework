<?php
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

// шаблонизация main.php
$main = include_template("stock/stock.php"); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout