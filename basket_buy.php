<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

if (!isset($_SESSION['user'])) {
  header("Location: index.php"); // переадресация
  exit();
}

// Получение всех товаров корзины
$goods = "";

if (isset($_SESSION['user'])) {
  $sql = "SELECT g.id, g.title, g.price, sc.number from goods g join shopping_cart sc on g.id = sc.id_good WHERE sc.id_user = ?";
  $goods = db_fetch_data($link, $sql, [$_SESSION['user']['id']]);
} elseif (isset($_SESSION['basket'])) {
  $goods = $_SESSION['basket'];
}

// сумма товаров
$total_price = 0;
if ($goods !== "") {
  foreach ($goods as $item) {
    $total_price += $item['price'] * $item['number'];
  }
}

// добавление заказа
$sql = "INSERT INTO orders SET id_user = ?, amount = ?";
$data = [$_SESSION['user']['id'], $total_price];
$id_order = db_insert_data($link, $sql, $data);

// добавление элементов заказа
$sql = "INSERT INTO order_items SET id_order = ?, id_good = ?, quantity = ?";
foreach ($goods as $item) {
  $data = [$id_order, $item['id'], $item['number']];
  $res = db_insert_data($link, $sql, $data);
}

// очистка корзины
$sql = "DELETE FROM shopping_cart WHERE id_user = ?";
$data = [$_SESSION['user']['id']];
$res = db_insert_data($link, $sql, $data);

// шаблонизация main.php
$main = include_template("basket/basket_buy.php", ["link" => $link]); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead - Оформление заказа", // Заголовок страницы
  "main" => $main // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout