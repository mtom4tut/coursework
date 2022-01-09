<?php
// Подключение бд
include_once("./config/init.php");

// Подключение библиотек
include_once('./vendor/autoload.php');

// Подключение функций
include_once("./functions/helpers.php");

if (!isset($_SESSION['user'])) {
  header("Location: index.php"); // переадресация
  exit();
}

// Создание транспорта
$transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
  ->setUsername('testemail-00@mail.ru')
  ->setPassword('VxBQKJT5QxqWyFTHjtLz');

// Создание почтовой программы, используя созданный транспорт
$mailer = new Swift_Mailer($transport);

// Получение всех товаров корзины
$goods = "";

if (isset($_SESSION['user'])) {
  $sql = "SELECT g.id, g.title, g.price, sc.number from goods g join shopping_cart sc on g.id = sc.id_good WHERE sc.id_user = ?";
  $goods = db_fetch_data($link, $sql, [$_SESSION['user']['id']]);
} elseif (isset($_SESSION['basket'])) {
  $goods = $_SESSION['basket'];
}

if (count($goods) === 0 || !isset($_SESSION['buy'])) {
  header("Location: /basket.php"); // переадресация
  exit();
}

// сумма товаров
$total_price = $_SESSION['buy']['price'];

if (isset($_GET['buy']) || isset($_GET['bonus'])) {
  // добавление заказа
  $sql = "INSERT INTO orders SET id_user = ?, amount = ?";
  $data = [$_SESSION['user']['id'], $total_price];
  $id_order = db_insert_data($link, $sql, $data);

  // добавление элементов заказа
  $sql = "INSERT INTO order_items SET id_order = ?, id_good = ?, quantity = ?";
  foreach ($goods as $item) {
    $data = [$id_order, $item['id'], $item['number']];
    $res = db_insert_data($link, $sql, $data);
  }

  // очистка корзины
  $sql = "DELETE FROM shopping_cart WHERE id_user = ?";
  $data = [$_SESSION['user']['id']];
  $res = db_insert_data($link, $sql, $data);
}

if (isset($_SESSION['buy']) && isset($_GET['buy'])) {
  $sql = "UPDATE bonus_cards SET balance = balance + ? WHERE id_user = ?";
  $data = db_insert_data($link, $sql, [$_SESSION['buy']['bonus'], $_SESSION['user']['id']]);

  // Создание шаблона
  $msg_content = include_template('send_email.php', ['goods' => $goods, 'price' => $total_price, 'bonus' => $_SESSION['buy']['bonus']]);

  // Создание сообщения
  $message = (new Swift_Message('Уведомление от сервиса «LetterHead»'))
    ->setFrom(['testemail-00@mail.ru' => 'LetterHead']) // отправитель
    ->setTo($_SESSION['user']['mail']) // получатель
    ->setBody($msg_content, 'text/html');

  $result = $mailer->send($message); // отправляем письмо
  unset($_SESSION['buy']);
}

$sql = "SELECT balance FROM bonus_cards WHERE id_user = ?";
$balance = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]['balance'];

$price = isset($_SESSION['buy']['price']) ? $_SESSION['buy']['price'] : '';
$bonus_remove = isset($_SESSION['buy']['price']) ? $_SESSION['buy']['price'] : '';

if (isset($_SESSION['buy']) && $_SESSION['buy']['price'] < $balance) {
  $balance -= $price;
  $price = 0;
} elseif (isset($_SESSION['buy']['price'])) {
  $price -= $balance;
  $bonus_remove = $balance;
  $balance = 0;
}

if (isset($_SESSION['buy']) && isset($_GET['bonus'])) {
  if ($_SESSION['buy']['price'] < $balance) {
    $sql = "UPDATE bonus_cards SET balance = ? WHERE id_user = ?";
    $data = db_insert_data($link, $sql, [$balance, $_SESSION['user']['id']]);
  } else {
    $sql = "UPDATE bonus_cards SET balance = 0 WHERE id_user = ?";
    $data = db_insert_data($link, $sql, [$_SESSION['user']['id']]);
  }

  // Создание шаблона
  $msg_content = include_template('send_email.php', ['goods' => $goods, 'price' => $price, 'bonus' => 0]);

  // Создание сообщения
  $message = (new Swift_Message('Уведомление от сервиса «LetterHead»'))
    ->setFrom(['testemail-00@mail.ru' => 'LetterHead']) // отправитель
    ->setTo($_SESSION['user']['mail']) // получатель
    ->setBody($msg_content, 'text/html');

  $result = $mailer->send($message); // отправляем письмо
  unset($_SESSION['buy']);
}

// шаблонизация main.php
$main = include_template("basket/basket_buy.php", ["price" => $price, "bonus_remove" => $bonus_remove, "balance" => $balance]); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "user" => $_SESSION['user'] ?? "", // Пользователь
  "title" => "LetterHead - Оформление заказа", // Заголовок страницы
  "main" => $main // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout