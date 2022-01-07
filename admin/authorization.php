<?php
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") { // если форма отправлена
  $required = ['login', 'password']; // массив обязательных полей
  $errors = []; // массив ошибок

  $rules = [
    "email" => function () use ($link) {
      if (empty($_POST["login"])) {
        return "Это поле должно быть заполнено";
      }
    },
    "password" => function () use ($link) {
      if (empty($_POST["password"])) {
        return "Это поле должно быть заполнено";
      } elseif ($_POST["password"] !== "admin" || $_POST["login"] !== "admin") {
        return "Не верный логин или пароль!";
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
    $_SESSION['admin'] = [
      "login" => "admin",
      "password" => "admin"
    ];

    header("Location: /admin/"); // переадресация
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