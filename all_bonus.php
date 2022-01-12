<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

// Праздничные скидки
$sql = "SELECT holiday, discount FROM holidays";
$holiday = db_fetch_data($link, $sql);

// vip скидки
$sql = "SELECT discount, bonus FROM premium_bonus";
$vip = db_fetch_data($link, $sql)[0];

// товары
$sql = "SELECT g.title, s.discount, s.bonuses FROM stock s join goods g on s.id_good = g.id";
$goods = db_fetch_data($link, $sql);

// шаблонизация main.php
$main = include_template("all_bonus.php", ["holiday" => $holiday, "vip" => $vip, "goods" => $goods]); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead - Все скидки", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout