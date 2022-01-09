<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

unset($_SESSION['basket']); // удаление сессии

if (isset($_SESSION['user'])) {
  header("Location: index.php"); // переадресация
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") { // если форма отправлена
  $required = ['email', 'password']; // массив обязательных полей
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
      } elseif (empty(db_fetch_data($link, $sql, [$_POST['email']])[0])) {
        return "Пользователя с этим E-mail не существут";
      }
    },
    "password" => function () use ($link) {
      if (empty($_POST["password"])) {
        return "Это поле должно быть заполнено";
      } elseif (empty($errors['email'])) {
        $sql = "SELECT password FROM users WHERE mail = ?";
        $pass = db_fetch_data($link, $sql, [$_POST['email']]);
        if (!password_verify($_POST['password'], $pass[0]['password'])) {
          return "Неверный пароль";
        }
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
    $main = include_template("auth.php", ["errors" => $errors]);
  } else {
    // получаем id пользователя
    $sql = "SELECT id, username FROM users WHERE mail = ?";
    $user = db_fetch_data($link, $sql, [$_POST['email']]);

    $_SESSION['user'] = [
      "id" => $user[0]["id"],
      "mail" => $_POST['email'],
      "name" => $user[0]["username"]
    ];
    header("Location: index.php"); // переадресация
    exit();
  }
} else {
  $main = include_template("auth.php");
}

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Авторизация", // Заголовок страницы
  "main" => $main // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout