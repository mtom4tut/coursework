<?php
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

// Подключение библиотеки
include_once("../library/phpqrcode/qrlib.php");

if (!isset($_SESSION['admin'])) {
  header("Location: index.php"); // переадресация
  exit();
}

// получение данных
$sql = "SELECT bc.id, bc.id_user, u.username, u.mail, bc.сard_number, bc.date, bc.balance FROM bonus_cards bc join users u on u.id = bc.id_user";
$data = db_fetch_data($link, $sql);

if (isset($_GET['select']) && isset($_GET['search']) && $_GET['search'] === "") {
  header("Location: /admin/bonus_card.php"); // переадресация
  exit();
}

if (isset($_GET['select']) && isset($_GET['search'])) {
  $select = ["bc.id", "id_user", "username", "mail", "сard_number", "date", "balance"];
  $selectTrue = true;
  foreach ($select as $item) {
    if ($item === $_GET['select']) {
      $selectTrue = false;
      break;
    }
  }

  if ($selectTrue) {
    header("Location: /admin/bonus_card.php"); // переадресация
    exit();
  }

  $sql = "SELECT bc.id, bc.id_user, u.username, u.mail, bc.сard_number, bc.date, bc.balance FROM bonus_cards bc join users u on u.id = bc.id_user where ";
  $sql .= $_GET['select'] . " LIKE ?";
  $search = "%" . $_GET['search'] . "%";
  $data = db_fetch_data($link, $sql, [$search]);
}

// шаблонизация main.php
$main = include_template("bonus_card/bonus_card.php", ["data" => $data]); // шаблон основной страницы

$add = include_template("bonus_card/bonus_card_add.php"); // шаблон добавления
$update = "";
if (isset($_GET['update'])) {
  $_SESSION["updateID"] = $_GET['update'];
  $sql = "SELECT id_user, data_start, data_end FROM premium_users WHERE id_user = ?";
  $_SESSION["updateData"] = db_fetch_data($link, $sql, [$_GET['update']])[0];
  $update = include_template("bonus_card/bonus_card_update.php", ["updateData" => $_SESSION["updateData"]]); // шаблон изменения
}

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"]))) {
  // если форма отправлена
  $required = isset($_POST["updateRecording"]) ? [] : ['id_user']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "id_user" => function () use ($link) {
      if (isset($_POST["updateRecording"])) {
        return;
      }

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
        return "Пользователь с таким id уже оформил бонусную карту";
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
      $add = include_template("bonus_card/bonus_card_add.php", ["errors" => $errors]);
    }
    if (isset($_POST["updateRecording"])) {
      $update = include_template("bonus_card/bonus_card_update.php", ["errors" => $errors]);
    }
  } else {
    if (isset($_POST["addRecording"])) {
      // создание qr кода
      $text = "user=" . $_POST['id_user'] . ";";
      $path = "../img/qr/" . $_POST['id_user'] . ".png";

      QRcode::png($text, $path, "H");

      // создание номера карты
      $card = str_pad($_POST['id_user'], 16, "0", STR_PAD_LEFT);

      // добавление карты
      $sql = "INSERT INTO bonus_cards SET id_user = ?, сard_number = ?";
      $data = [$_POST['id_user'], $card];
      $res = db_insert_data($link, $sql, $data);
    }
    if (isset($_POST["updateRecording"])) {
      $sql = "UPDATE bonus_cards SET balance = ? WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["balance"], $_SESSION["updateID"]]);
      unset($_SESSION["updateID"]);
      unset($_SESSION["updateData"]);
    }

    header("Location: /admin/bonus_card.php"); // переадресация
    exit();
  }
}

// удаление записи
if (isset($_GET['remove'])) {
  $sql = "DELETE FROM bonus_cards WHERE id = ?";
  $remove = db_fetch_data($link, $sql, [$_GET['remove']]);
  header("Location: /admin/bonus_card.php"); // переадресация
  exit();
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/bonus_card.php",
  "add" => $add,
  "update" => $update
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout