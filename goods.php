<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

if (empty($_GET['id'])) {
    header("Location: /"); // переадресация
}

$sql = "SELECT g.id, g.title, g.price, g.description, s.discount, s.bonuses, s.data_start, s.data_end FROM goods g LEFT JOIN stock s on s.id_good = g.id where g.id = ?";
$goods = db_fetch_data($link, $sql, [$_GET['id']])[0];

$count = 0;
if (isset($_SESSION['user'])) {
    $sql = "SELECT COUNT(*) FROM bonus_cards WHERE id_user = ?";
    $count = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]["COUNT(*)"];
}

if (isset($_GET['id']) && isset($_POST['commentContent'])) {
    $sql = "SELECT COUNT(*) FROM comments WHERE text_comment = ?";
    $count = db_fetch_data($link, $sql, [$_POST['commentContent']])[0]["COUNT(*)"];
    if (!$count) {
        $sql = "INSERT INTO comments SET id_user = ?, id_good = ?, text_comment = ?";
        $data = [$_SESSION['user']['id'], $_GET['id'], $_POST['commentContent']];
        $new_comment = db_insert_data($link, $sql, $data);
    }
}

$sql = "SELECT u.username, com.text_comment, com.like_comment, com.dislike_comment from comments com join users u on u.id = com.id_user WHERE com.id_good = ?";
$comments = db_fetch_data($link, $sql, [$_GET['id']]);

// шаблонизация main.php
$main = include_template("goods.php", ["item" => $goods, 'count' => $count, 'comments' => $comments]);

// Данные для layout.php
$layoutArr = [
    "user" => $_SESSION['user'] ?? "", // Пользователь
    "title" => "LetterHead", // Заголовок страницы
    "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout
