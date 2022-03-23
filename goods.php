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

        if (isset($_POST['idcom'])) {
            $sql = "INSERT INTO com_child SET id_com = ?, id_com_child = ?";
            $data = [$_POST['idcom'], $new_comment];
            $new_child_comment = db_insert_data($link, $sql, $data);
        }
    }
}

$count_com = 0;
if (isset($_GET['like']) || isset($_GET['dislike'])) {
    $sql = "SELECT COUNT(*) FROM com_rewiew WHERE id_user = ? AND id_com = ?";

    if (isset($_GET['like'])) {
        $count_com = db_fetch_data($link, $sql, [$_SESSION['user']['id'], $_GET['like']])[0]["COUNT(*)"];
    } else {
        $count_com = db_fetch_data($link, $sql, [$_SESSION['user']['id'], $_GET['dislike']])[0]["COUNT(*)"];
    }
    if ($count_com) {
        header("Location: /goods.php?id=" . $_GET['id']); // переадресация
    }
}

if (isset($_GET['like'])) {
    $sql = "UPDATE comments SET like_comment = like_comment + 1 WHERE id = ?";
}
if (isset($_GET['dislike'])) {
    $sql = "UPDATE comments SET dislike_comment = dislike_comment + 1 WHERE id = ?";
}

if ((isset($_GET['like']) || isset($_GET['dislike'])) && !$count_com) {
    $val = null;
    if (isset($_GET['like'])) {
        $val = $_GET['like'];
    } else {
        $val = $_GET['dislike'];
    }

    $data = db_insert_data($link, $sql, [$val]);
    $sql = "INSERT INTO com_rewiew SET id_com = ?, id_user = ?";
    $data = [$val, $_SESSION['user']['id']];
    $data = db_insert_data($link, $sql, $data);
    header("Location: /goods.php?id=" . $_GET['id']); // переадресация
}

$sql = "SELECT com.id, u.username, com.text_comment, com.like_comment, com.dislike_comment from comments com join users u on u.id = com.id_user WHERE com.id_good = ?";
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
