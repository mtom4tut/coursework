<?php
session_start(); // запуск сессии

// Подключение бд
$link = mysqli_connect("localhost", "root", "root", "coursework"); // подключение к бд в OpenServer

if (!$link) { // проверка соединения
  die("Ошибка соединения: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8"); // установка кодировки
