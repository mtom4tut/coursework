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
$sql = "SELECT pu.id_user, u.username, u.mail, pu.data_start, pu.data_end FROM premium_users pu join users u on u.id = pu.id_user";
$data = db_fetch_data($link, $sql);

if (isset($_GET['select']) && isset($_GET['search']) && $_GET['search'] === "") {
  header("Location: /admin/vipuser.php"); // переадресация
  exit();
}

if (isset($_GET['select']) && isset($_GET['search'])) {
  $select = ["id_user", "username", "mail", "data_start", "data_end"];
  $selectTrue = true;
  foreach ($select as $item) {
    if ($item === $_GET['select']) {
      $selectTrue = false;
      break;
    }
  }

  if ($selectTrue) {
    header("Location: /admin/vipuser.php"); // переадресация
    exit();
  }

  $sql = "SELECT pu.id_user, u.username, u.mail, pu.data_start, pu.data_end FROM premium_users pu join users u on u.id = pu.id_user where ";
  $sql .= $_GET['select'] . " LIKE ?";
  $search = "%".$_GET['search']."%";
  $data = db_fetch_data($link, $sql, [$search]);
}

$sqlvip = "SELECT discount, bonus FROM premium_bonus";
$datavip = db_fetch_data($link, $sqlvip)[0];
// шаблонизация main.php
$main = include_template("vipuser/vipuser.php", ["data" => $data, "vip_discount" => $datavip['discount'], "vip_bonus" => $datavip['bonus']]); // шаблон основной страницы

$add = include_template("vipuser/vipuser_add.php"); // шаблон добавления
$update = "";
if (isset($_GET['update'])) {
  $_SESSION["updateID"] = $_GET['update'];
  $sql = "SELECT id_user, data_start, data_end FROM premium_users WHERE id_user = ?";
  $_SESSION["updateData"] = db_fetch_data($link, $sql, [$_GET['update']])[0];
  $update = include_template("vipuser/vipuser_update.php", ["updateData" => $_SESSION["updateData"]]); // шаблон изменения
}

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"]))) {
  // если форма отправлена
  $required = ['id_user', 'data_end']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "id_user" => function () use ($link) {
      $sql = "SELECT COUNT(*) FROM users WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["id_user"]])[0]["COUNT(*)"];

      $sql2 = "SELECT COUNT(*) FROM premium_users WHERE id_user = ?";
      $count = db_fetch_data($link, $sql2, [$_POST["id_user"]])[0]["COUNT(*)"];

      if (empty($_POST["id_user"])) {
        return "Это поле должно быть заполнено";
      } elseif ($empty === 0) {
        return "Пользователя с таким id не существует";
      } elseif ($count !== 0) {
        if (isset($_POST["updateRecording"]) && $_SESSION["updateData"]['id_user'] == $_POST["id_user"]) {
          return;
        }
        return "Пользователь с таким id уже оформил премиум подписку";
      }
    },
    "data_end" => function () {
      if (empty($_POST["data_end"])) {
        return "Это поле должно быть заполнено";
      } elseif (!empty($_POST["dateStart"]) && $_POST["dateStart"] > $_POST["date"]) {
        return "Дата завершения акции должна быть больше даты начала акции";
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
      $add = include_template("vipuser/vipuser_add.php", ["errors" => $errors]);
    }
    if (isset($_POST["updateRecording"])) {
      $update = include_template("vipuser/vipuser_update.php", ["errors" => $errors]);
    }
  } else {
    $dateStart = empty($_POST["dateStart"]) ? date("Y-m-d") : $_POST["dateStart"];

    if (isset($_POST["addRecording"])) {
      $sql = "INSERT INTO premium_users SET id_user = ?, data_start = ?, data_end = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["id_user"], $dateStart, $_POST["data_end"]]);
    }
    if (isset($_POST["updateRecording"])) {
      $sql = "UPDATE premium_users SET id_user = ?, data_start = ?, data_end = ? WHERE id_user = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["id_user"], $dateStart, $_POST["data_end"], $_SESSION["updateID"]]);
      unset($_SESSION["updateID"]);
      unset($_SESSION["updateData"]);
    }

    header("Location: /admin/vipuser.php"); // переадресация
    exit();
  }
}

// удаление записи
if (isset($_GET['remove'])) {
  $sql = "DELETE FROM premium_users WHERE id_user = ?";
  $remove = db_fetch_data($link, $sql, [$_GET['remove']]);
  header("Location: /admin/vipuser.php"); // переадресация
  exit();
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/vipuser.php",
  "add" => $add,
  "update" => $update
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout