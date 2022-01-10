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
$sql = "SELECT id, title, price, description FROM goods";
$data = db_fetch_data($link, $sql);

if (isset($_GET['select']) && isset($_GET['search']) && $_GET['search'] === "") {
  header("Location: /admin/goods.php"); // переадресация
  exit();
}

if (isset($_GET['select']) && isset($_GET['search'])) {
  $select = ["id", "title", "price", "description"];
  $selectTrue = true;
  foreach ($select as $item) {
    if ($item === $_GET['select']) {
      $selectTrue = false;
      break;
    }
  }

  if ($selectTrue) {
    header("Location: /admin/goods.php"); // переадресация
    exit();
  }

  $sql = "SELECT id, title, price, description FROM goods where ";
  $sql .= $_GET['select'] . " LIKE ?";
  $search = "%" . $_GET['search'] . "%";
  $data = db_fetch_data($link, $sql, [$search]);
}

// шаблонизация main.php
$main = include_template("goods/goods.php", ["data" => $data]); // шаблон основной страницы

$add = include_template("goods/goods_add.php"); // шаблон добавления
$update = "";
if (isset($_GET['update'])) {
  $_SESSION["updateID"] = $_GET['update'];
  $sql = "SELECT title, price, description FROM goods WHERE id = ?";
  $_SESSION["updateData"] = db_fetch_data($link, $sql, [$_GET['update']])[0];
  $update = include_template("goods/goods_update.php", ["updateData" => $_SESSION["updateData"]]); // шаблон изменения
}

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"]))) {
  // если форма отправлена
  $required = ['title', 'price']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "title" => function () {
      if (empty($_POST["title"])) {
        return "Размер скидки должен быть больше 0 и меньше 100";
      } elseif (!is_correct_length("title", 0, 60)) {
        return "Длинна заголовка слишком велика";
      }
    },
    "price" => function () use ($link) {
      if (empty($_POST["price"])) {
        return "Поле 'Цена товара' должно быть заполнено";
      } elseif (0 > $_POST["price"]) {
        return "Цена должна быть больше 0";
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
      $add = include_template("goods/goods_add.php", ["errors" => $errors]);
    }
    if (isset($_POST["updateRecording"])) {
      $update = include_template("goods/goods_update.php", ["errors" => $errors]);
    }
  } else {
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    if (isset($_POST["addRecording"])) {
      $sql = "INSERT INTO goods SET title = ?, price = ?, description = ?";
      $empty = db_insert_data($link, $sql, [$_POST['title'], $_POST['price'], $description]);
    }
    if (isset($_POST["updateRecording"])) {
      $sql = "UPDATE goods SET title = ?, price = ?, description = ? WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST['title'], $_POST['price'], $description, $_SESSION["updateID"]]);
      unset($_SESSION["updateID"]);
      unset($_SESSION["updateData"]);
    }

    header("Location: /admin/goods.php"); // переадресация
    exit();
  }
}

// удаление записи
if (isset($_GET['remove'])) {
  $sql = "DELETE FROM goods WHERE id = ?";
  $remove = db_fetch_data($link, $sql, [$_GET['remove']]);
  header("Location: /admin/goods.php"); // переадресация
  exit();
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/goods.php",
  "add" => $add,
  "update" => $update
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout