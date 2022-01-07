<?php
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

if (!isset($_SESSION['admin'])) {
  header("Location: index.php"); // переадресация
  exit();
}

// получение данных
$sql = "SELECT s.id, s.id_good, g.title, s.discount, s.bonuses, s.data_start, s.data_end FROM stock s JOIN goods g on s.id_good = g.id";
$data = db_fetch_data($link, $sql);

// шаблонизация main.php
$main = include_template("stock/stock.php", ["data" => $data]); // шаблон основной страницы

$add = include_template("stock/stock_add.php"); // шаблон основной страницы

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["addRecording"])) { // если форма отправлена
  $required = ['id', 'date']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "id" => function () use ($link) {
      $sql = "SELECT COUNT(*) FROM goods WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["id"]])[0]["COUNT(*)"];

      $sql2 = "SELECT COUNT(*) FROM stock WHERE id_good = ?";
      $count = db_fetch_data($link, $sql2, [$_POST["id"]])[0]["COUNT(*)"];

      if (empty($_POST["id"])) {
        return "Это поле должно быть заполнено";
      } elseif ($empty === 0) {
        return "Такого товара не существует";
      } elseif ($count !== 0) {
        return "Акция для указанного товара уже существует";
      }
    },
    "discount" => function () {
      if (!empty($_POST["discount"]) && (0 > $_POST["discount"] || $_POST["discount"] > 100)) {
        return "Размер скидки должен быть больше 0 и меньше 100";
      }
    },
    "bonus" => function () use ($link) {
      $sql = "SELECT price FROM goods WHERE id = ?";
      $price = 500;

      if (!empty($_POST["id"])) {
        $price = db_fetch_data($link, $sql, [$_POST["id"]])[0]['price'];
      }

      if (!empty($_POST["bonus"]) && empty($_POST["id"])) {
        return "Поле 'ID товара' должно быть заполнено";
      } elseif (0 > $_POST["bonus"] || $_POST["bonus"] > $price) {
        return "Размер бонусов должен быть больше 0 и меньше $price";
      }
    },
  ];

  // заполняем массив ошибками, если есть
  foreach ($_POST as $key => $value) {
    if (isset($rules[$key])) {
      $rule = $rules[$key];
      $errors[$key] = $rule();
    }
  }

  $errors = array_filter($errors); // очищаем "пустые" ошибки

  // проверяем наличие обязательных полей
  foreach ($required as $key) {
    if (empty($_POST[$key])) {
      $errors[$key] = "Это поле должно быть заполнено";
    }
  }

  // есть ли в массиве ошибок, ошибки
  if (count($errors)) {
    $add = include_template("stock/stock_add.php", ["errors" => $errors]);
  } else {
    $discount = empty($_POST["discount"]) ? 0 : $_POST["discount"];
    $bonus = empty($_POST["bonus"]) ? 0 : $_POST["bonus"];
    $sql = "INSERT INTO stock SET id_good = ?, discount = ?, bonuses = ?, data_end = ?, data_start = CURRENT_DATE";
    $empty = db_fetch_data($link, $sql, [$_POST["id"], $discount, $bonus, $_POST["date"]]);

    header("Location: /admin/stock.php"); // переадресация
    exit();
  }
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/stock.php",
  "add" => $add
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout