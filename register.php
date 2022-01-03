<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

if (isset($_SESSION['user'])) {
  header("Location: index.php"); // переадресация
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") { // если форма отправлена
  $required = ['email', 'password', 'password-confirmation', 'name', 'date']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "email" => function () use ($link) {
      $sql = "SELECT id FROM users WHERE mail = ?";

      if (empty($_POST["email"])) {
        return "Это поле должно быть заполнено";
      } elseif (!is_correct_length("email", 0, 60)) {
        return "Длинна E-mail слишком велика";
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        return "Не верный E-mail адрес";
      } elseif (isset(db_fetch_data($link, $sql, [$_POST['email']])[0])) {
        return "Пользователь с этим E-mail уже зарегистрирован";
      }
    },
    "password" => function () {
      if (empty($_POST["password"])) {
        return "Это поле должно быть заполнено";
      } elseif (!is_correct_length("password", 6, 40)) {
        return "Длинна пароля должна быть больше 6 символов";
      }
    },
    "password-confirmation" => function () {
      if (empty($_POST["password-confirmation"])) {
        return "Это поле должно быть заполнено";
      } elseif ($_POST["password-confirmation"] !== $_POST["password"]) {
        return "Пароли не совпадают";
      }
    },
    "name" => function () {
      if (empty($_POST["name"])) {
        return "Это поле должно быть заполнено";
      } elseif (!is_correct_length("name", 0, 25)) {
        return "Имя пользователя не должно быть больше 25 символов";
      }
    },
    "date" => function () {
      if (empty($_POST["date"])) {
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
    $main = include_template("reg.php", ["errors" => $errors]);
  } else {
    $sql = "INSERT INTO users SET username = ?, mail = ?, password = ?, birthday = ?";
    $data = [trim(strip_tags($_POST['name'])), $_POST["email"], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['date']];
    $res = db_insert_data($link, $sql, $data);

    if ($res) {
      // получаем id пользователя
      $sql = "SELECT id FROM users WHERE mail = ?";
      $userID = db_fetch_data($link, $sql, [$_POST['email']])[0]["id"];

      $_SESSION['user'] = [
        "id" => $userID,
        "mail" => $_POST['email'],
        "name" => trim(strip_tags($_POST['name']))
      ];

      header("Location: index.php"); // переадресация
      exit();
    }
  }
} else {
  $main = include_template("reg.php");
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - регистрация", // Заголовок страницы
  "main" => $main // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout