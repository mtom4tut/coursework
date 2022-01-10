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
$sql = "SELECT id, date, holiday, discount FROM holidays";
$data = db_fetch_data($link, $sql);

if (isset($_GET['select']) && isset($_GET['search']) && $_GET['search'] === "") {
  header("Location: /admin/calendar.php"); // переадресация
  exit();
}

if (isset($_GET['select']) && isset($_GET['search'])) {
  $select = ["id", "date", "holiday", "discount"];
  $selectTrue = true;
  foreach ($select as $item) {
    if ($item === $_GET['select']) {
      $selectTrue = false;
      break;
    }
  }

  if ($selectTrue) {
    header("Location: /admin/calendar.php"); // переадресация
    exit();
  }

  $sql = "SELECT id, date, holiday, discount FROM holidays where ";
  $sql .= $_GET['select'] . " LIKE ?";
  $search = "%".$_GET['search']."%";
  $data = db_fetch_data($link, $sql, [$search]);
}

// шаблонизация main.php
$main = include_template("calendar/calendar.php", ["data" => $data]); // шаблон основной страницы

$add = include_template("calendar/calendar_add.php"); // шаблон добавления
$update = "";
if (isset($_GET['update'])) {
  $_SESSION["updateID"] = $_GET['update'];
  $sql = "SELECT id, date, holiday, discount FROM holidays where id = ?";
  $_SESSION["updateData"] = db_fetch_data($link, $sql, [$_GET['update']])[0];
  $update = include_template("calendar/calendar_update.php", ["updateData" => $_SESSION["updateData"]]); // шаблон изменения
}

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"]))) {
  // если форма отправлена
  $required = ['date', 'holiday', 'discount']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "date" => function () {
      if (empty($_POST["date"])) {
        return "Это поле должно быть заполнено";
      }
    },
    "holiday" => function () {
      if (empty($_POST["holiday"])) {
        return "Это поле должно быть заполнено";
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
    if (isset($_POST["addRecording"])) {
      $add = include_template("calendar/calendar_add.php", ["errors" => $errors]);
    }
    if (isset($_POST["updateRecording"])) {
      $update = include_template("calendar/calendar_update.php", ["errors" => $errors]);
    }
  } else {
    if (isset($_POST["addRecording"])) {
      $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
      $sql = "INSERT INTO holidays SET date = ?, holiday = ?, discount = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["date"], $_POST["holiday"], $discount]);
    }
    if (isset($_POST["updateRecording"])) {
      $sql = "UPDATE holidays SET holiday = ?, date = ?, discount = ? WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["holiday"], $_POST["date"], $_POST["discount"], $_SESSION["updateID"]]);
      unset($_SESSION["updateID"]);
      unset($_SESSION["updateData"]);
    }

    header("Location: /admin/calendar.php"); // переадресация
    exit();
  }
}

// удаление записи
if (isset($_GET['remove'])) {
  $sql = "DELETE FROM holidays WHERE id = ?";
  $remove = db_fetch_data($link, $sql, [$_GET['remove']]);
  header("Location: /admin/calendar.php"); // переадресация
  exit();
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/calendar.php",
  "add" => $add,
  "update" => $update
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout