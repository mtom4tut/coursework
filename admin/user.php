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
$sql = "SELECT id, date_now, birthday, username, mail, password FROM users";
$data = db_fetch_data($link, $sql);

if (isset($_GET['select']) && isset($_GET['search']) && $_GET['search'] === "") {
  header("Location: /admin/user.php"); // переадресация
  exit();
}

if (isset($_GET['select']) && isset($_GET['search'])) {
  $select = ["id", "date_now", "birthday", "username", "mail"];
  $selectTrue = true;
  foreach ($select as $item) {
    if ($item === $_GET['select']) {
      $selectTrue = false;
      break;
    }
  }

  if ($selectTrue) {
    header("Location: /admin/user.php"); // переадресация
    exit();
  }

  $sql = "SELECT id, date_now, birthday, username, mail, password FROM users where ";
  $sql .= $_GET['select'] . " LIKE ?";
  $search = "%".$_GET['search']."%";
  $data = db_fetch_data($link, $sql, [$search]);
}

// шаблонизация main.php
$main = include_template("user/user.php", ["data" => $data]); // шаблон основной страницы

$add = include_template("user/user_add.php"); // шаблон добавления
$update = "";
if (isset($_GET['update'])) {
  $_SESSION["updateID"] = $_GET['update'];
  $sql = "SELECT date_now, birthday, username, mail, password FROM users WHERE id = ?";
  $_SESSION["updateData"] = db_fetch_data($link, $sql, [$_GET['update']])[0];
  $update = include_template("user/user_update.php", ["updateData" => $_SESSION["updateData"]]); // шаблон изменения
}

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"]))) {
  // если форма отправлена
  $required = ['birthday', 'username', 'mail', 'password']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "birthday" => function () {
      if (empty($_POST["birthday"])) {
        return "Это поле должно быть заполнено";
      }
    },
    "username" => function () {
      if (empty($_POST["username"])) {
        return "Это поле должно быть заполнено";
      }
    },
    "mail" => function () use ($link) {
      $sql = "SELECT id FROM users WHERE mail = ?";

      if (empty($_POST["mail"])) {
        return "Это поле должно быть заполнено";
      } elseif (!is_correct_length("mail", 0, 60)) {
        return "Длинна E-mail слишком велика";
      } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        return "Не верный E-mail адрес";
      } elseif (isset(db_fetch_data($link, $sql, [$_POST['mail']])[0])) {
        if (isset($_POST["updateRecording"]) && $_SESSION["updateData"]['mail'] == $_POST["mail"]) {
          return;
        }
        return "Пользователь с этим E-mail уже зарегистрирован";
      }
    },
    "password" => function () {
      if (empty($_POST["password"])) {
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
      $add = include_template("user/user_add.php", ["errors" => $errors]);
    }
    if (isset($_POST["updateRecording"])) {
      $update = include_template("user/user_update.php", ["errors" => $errors]);
    }
  } else {
    if (isset($_POST["addRecording"])) {
      $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
      $sql = "INSERT INTO users SET birthday = ?, username = ?, mail = ?, password = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["birthday"], $_POST["username"], $_POST["mail"], $password]);
    }
    if (isset($_POST["updateRecording"])) {
      if (strlen($_POST["password"]) < 60) {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
      } else {
        $password = $_POST["password"];
      }

      $sql = "UPDATE users SET birthday = ?, username = ?, mail = ?, password = ? WHERE id = ?";
      $empty = db_fetch_data($link, $sql, [$_POST["birthday"], $_POST["username"], $_POST["mail"], $password, $_SESSION["updateID"]]);
      unset($_SESSION["updateID"]);
      unset($_SESSION["updateData"]);
    }

    header("Location: /admin/user.php"); // переадресация
    exit();
  }
}

// удаление записи
if (isset($_GET['remove'])) {
  $sql = "DELETE FROM users WHERE id = ?";
  $remove = db_fetch_data($link, $sql, [$_GET['remove']]);
  header("Location: /admin/user.php"); // переадресация
  exit();
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
  "url" => "/admin/user.php",
  "add" => $add,
  "update" => $update
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout