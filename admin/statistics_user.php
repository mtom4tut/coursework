<?php
// Подключение бд
include_once("../config/init.php");

// Подключение функций
include_once("../functions/helpers.php");

if (!isset($_SESSION['admin'])) {
    header("Location: index.php"); // переадресация
    exit();
}

// шаблонизация main.php
$main = include_template("statistics_user.php"); // шаблон основной страницы

// проверка формы добавления записи
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // если форма отправлена
    $required = ['date-to', 'date-from']; // массив обязательных полей
    $errors = []; // массив ошибок

    $rules = [
        "date-to" => function () {
            if (empty($_POST["date-to"])) {
                return "Это поле должно быть заполнено";
            }
        },
        "date-from" => function () {
            if (empty($_POST["date-from"])) {
                return "Это поле должно быть заполнено";
            }
        },
    ];
    $_SESSION['time_a'] = $_POST["date-to"];
    $_SESSION['time_b'] = $_POST["date-from"];

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
        $main = include_template("statistics_user.php", ["errors" => $errors]);
    } else {
        $sql_card = "select COUNT(*) from users u JOIN bonus_cards bc on bc.id_user = u.id WHERE ? <= u.date_now and u.date_now <= ?";
        $sql_total = "select COUNT(*) from users u WHERE ? <= u.date_now and u.date_now <= ?";
        $_SESSION['data_card'] = db_fetch_data($link, $sql_card, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];
        $_SESSION['data_total'] = db_fetch_data($link, $sql_total, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];

        $sql_order = "SELECT COUNT(*) FROM orders o JOIN bonus_cards bc on bc.id_user = o.id_user WHERE ? <= o.date and o.date <= ?";
        $sql_order_total = "SELECT COUNT(*) FROM orders o WHERE ? <= o.date and o.date <= ?";

        $_SESSION['data_order'] = db_fetch_data($link, $sql_order, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];
        $_SESSION['data_order_total'] = db_fetch_data($link, $sql_order_total, [$_POST['date-from'], $_POST['date-to']])[0]['COUNT(*)'];

        $sql_amount = "SELECT SUM(o.amount) amount FROM orders o JOIN bonus_cards bc on bc.id_user = o.id_user WHERE ? <= o.date and o.date <= ?";
        $sql_amount_total = "SELECT SUM(o.amount) amount FROM orders o WHERE ? <= o.date and o.date <= ?";

        $_SESSION['data_amount'] = db_fetch_data($link, $sql_amount, [$_POST['date-from'], $_POST['date-to']])[0]['amount'];
        $_SESSION['data_amount_total'] = db_fetch_data($link, $sql_amount_total, [$_POST['date-from'], $_POST['date-to']])[0]['amount'];

        $_SESSION['data_amount'] = number_format((float)$_SESSION['data_amount'], 2, '.', '');
        $_SESSION['data_amount_total'] = number_format((float)$_SESSION['data_amount_total'], 2, '.', '');

        $sql_sale = "select MONTH(o.date) month, sum(o.amount) sale from orders o WHERE ? < o.date and o.date < ? group by MONTH(o.date)";
        $data_sale = db_fetch_data($link, $sql_sale, [$_POST['date-from'], $_POST['date-to']]);

        $_SESSION['data_sale'] = [];
        $_SESSION['data_sale'][] = ['Месяц', 'Выручка'];
        foreach ($data_sale as $key => $value) {
            $month = "";
            switch ($value['month']) {
                case 1:
                    $month = "Январь";
                    break;
                case 2:
                    $month = "Февраль";
                    break;
                case 3:
                    $month = "Март";
                    break;
                case 4:
                    $month = "Апрель";
                    break;
                case 5:
                    $month = "Май";
                    break;
                case 6:
                    $month = "Июнь";
                    break;
                case 7:
                    $month = "Июль";
                    break;
                case 8:
                    $month = "Август";
                    break;
                case 9:
                    $month = "Сентабрь";
                    break;
                case 10:
                    $month = "Октябрь";
                    break;
                case 11:
                    $month = "Ноябрь";
                    break;
                case 12:
                    $month = "Декабрь";
                    break;
            }
            $_SESSION['data_sale'][] = [$month, number_format((float)$value['sale'], 2, '.', '')];
        }

        $_SESSION['data_sale'] = json_encode($_SESSION['data_sale']);

        $sql_goods = "SELECT title, price FROM goods";
        $data_goods = db_fetch_data($link, $sql_goods);

        $_SESSION['data_goods'] = [];
        $_SESSION['data_goods'][] = ['Товар', 'Цена'];

        foreach ($data_goods as $value) {
            $_SESSION['data_goods'][] = [$value['title'], $value['price']];
        }
        $_SESSION['data_goods'] = json_encode($_SESSION['data_goods']);

        $sql_count_goods = "SELECT MONTH(o.date) month, g.title, sum(oi.quantity) num FROM orders o join order_items oi on o.id = oi.id_order join goods g on g.id = oi.id_good GROUP by MONTH(o.date), g.id";
        $data_count_goods = db_fetch_data($link, $sql_count_goods);
        $_SESSION['data_count_goods'] = [];
        $_SESSION['data_count_goods'][] = ['ID', 'Месяц', 'Продано товара', 'Товар'];
        foreach ($data_count_goods as $value) {
            $_SESSION['data_count_goods'][] = [$value['title'], $value['month'], $value['num'], $value['title']];
        }
        $_SESSION['data_count_goods'] = json_encode($_SESSION['data_count_goods']);

        $sql_count_goods_date = "SELECT o.date dat, sum(oi.quantity) num FROM orders o join order_items oi on o.id = oi.id_order GROUP by o.date";
        $data_count_goods_date = db_fetch_data($link, $sql_count_goods_date);
        $_SESSION['data_count_goods_date'] = [];
        foreach ($data_count_goods_date as $value) {
            $_SESSION['data_count_goods_date'][] = [$value['dat'], $value['num']];
        }
        $_SESSION['data_count_goods_date'] = json_encode($_SESSION['data_count_goods_date']);

        $sql_sankey_data = "SELECT u.username, g.title, sum(oi.quantity) num FROM orders o join order_items oi on o.id = oi.id_order join goods g on g.id = oi.id_good join users u on u.id = o.id_user GROUP by o.id_user, oi.id_good";
        $sankey_data = db_fetch_data($link, $sql_sankey_data);
        $_SESSION['sankey_data'] = [];
        foreach ($sankey_data as $value) {
            $_SESSION['sankey_data'][] = [$value['username'], $value['title'], $value['num']];
        }
        $_SESSION['sankey_data'] = json_encode($_SESSION['sankey_data']);

        $sql_timeline = "SELECT g.title, MIN(o.date) min_date, MAX(o.date) max_date FROM orders o join order_items oi on o.id = oi.id_order join goods g on g.id = oi.id_good GROUP by g.id";
        $timeline = db_fetch_data($link, $sql_timeline);
        $_SESSION['timeline'] = [];
        foreach ($timeline as $value) {
            $_SESSION['timeline'][] = [$value['title'], $value['min_date'], $value['max_date']];
        }
        $_SESSION['timeline'] = json_encode($_SESSION['timeline']);

        $sql = "SELECT sum(o.amount) num FROM orders o GROUP by MONTH(o.date);";
        $_SESSION['month_amount'] = [];

        foreach (db_fetch_data($link, $sql) as $value) {
            $_SESSION['month_amount'][] = $value['num'];
        }

        $_SESSION['month_amount'] = json_encode($_SESSION['month_amount']);

        header("Location: /admin/statistics_user.php"); // переадресация
        exit();
    }
}

// Данные для layout.php
$layoutArr = [
    "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
    "main" => $main, // main страницы
    "url" => "/admin/statistics_user.php",
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout
