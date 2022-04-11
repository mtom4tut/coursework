<?php
session_start();
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

if (!isset($_SESSION['admin'])) {
  header("Location: index.php"); // переадресация
  exit();
}

// шаблонизация main.php
$main = include_template("statistics_user.php"); // шаблон основной страницы

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  // если форма отправлена
  $required = ['date-to', 'date-from']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "date-to" => function () {
      if (empty($_POST["date-to"])) {
        return "Это поле должно быть заполнено";
      }
    },
    "date-from" => function () {
      if (empty($_POST["date-from"])) {
        return "Это поле должно быть заполнено";
      }
    },
  ];
  $_SESSION['time_a'] = $_POST["date-to"];
  $_SESSION['time_b'] = $_POST["date-from"];

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
    $main = include_template("statistics_user.php", ["errors" => $errors]);
  } else {
    $sql_card = "select COUNT(*) from users u JOIN bonus_cards bc on bc.id_user = u.id WHERE ? <= u.date_now and u.date_now <= ?";
    $sql_total = "select COUNT(*) from users u WHERE ? <= u.date_now and u.date_now <= ?";

    $_SESSION['data_card'] = db_fetch_data($link, $sql_card, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];
    $_SESSION['data_total'] = db_fetch_data($link, $sql_total, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];

    $sql_order = "SELECT COUNT(*) FROM orders o JOIN bonus_cards bc on bc.id_user = o.id_user WHERE ? <= o.date and o.date <= ?";
    $sql_order_total = "SELECT COUNT(*) FROM orders o WHERE ? <= o.date and o.date <= ?";

    $_SESSION['data_order'] = db_fetch_data($link, $sql_order, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];
    $_SESSION['data_order_total'] = db_fetch_data($link, $sql_order_total, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];

    $sql_amount = "SELECT SUM(o.amount) amount FROM orders o JOIN bonus_cards bc on bc.id_user = o.id_user WHERE ? <= o.date and o.date <= ?";
    $sql_amount_total = "SELECT SUM(o.amount) amount FROM orders o WHERE ? <= o.date and o.date <= ?";

    $_SESSION['data_amount'] = db_fetch_data($link, $sql_amount, [$_POST['date-from'], $_POST['date-to']])[0]['amount'];
    $_SESSION['data_amount_total'] = db_fetch_data($link, $sql_amount_total, [$_POST['date-from'], $_POST['date-to']])[0]['amount'];

    $_SESSION['data_amount'] = number_format((float)$_SESSION['data_amount'], 2, '.', '');
    $_SESSION['data_amount_total'] = number_format((float)$_SESSION['data_amount_total'], 2, '.', '');

    header("Location: /admin/statistics_user.php"); // переадресация
    exit();
  }
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/statistics_user.php",
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout