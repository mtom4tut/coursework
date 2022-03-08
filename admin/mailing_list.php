<?php
// Подключение бд
include_once("../config/init.php");

// Подключение библиотек
include_once('../vendor/autoload.php');

// Подключение функций
include_once("../functions/helpers.php");

if (!isset($_SESSION['admin'])) {
  header("Location: authorization.php"); // переадресация
}

$sql = "SELECT id, username FROM users WHERE mailing_list = 1";
$users_mail = db_fetch_data($link, $sql);

if (isset($_POST['mailContent']) && isset($_POST['users'])) {
  $recipients = [];

  if ($_POST['users'][0] === 'all') {
    $sql = "SELECT mail FROM users WHERE mailing_list = 1";
    $recipients = db_fetch_data($link, $sql);
  } else {
    foreach ($_POST['users'] as $val) {
      $sql = "SELECT mail FROM users WHERE id = ?";
      $recipients[] = db_fetch_data($link, $sql, [$val])[0];
    }
  }

  if (count($recipients)) {
    // Создание транспорта
    $transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
      ->setUsername('testemail-00@mail.ru') // junepc20@mail.ru
      ->setPassword('X13FkF8dGzgmJ6Ezn5Fc'); // tE0kg3GS04yY9qRXAcGQ

    // Создание почтовой программы, используя созданный транспорт
    $mailer = new Swift_Mailer($transport);

    // Создание шаблона
    $msg_content = include_template('send_email.php', ['mailContent' => $_POST["mailContent"]]);

    foreach ($recipients as $key => $val) {
      // Создание сообщения
      $message = (new Swift_Message('Рассылка от сервиса «LetterHead»'))
        ->setFrom(['testemail-00@mail.ru' => 'LetterHead']) // отправитель
        ->setTo($key, $val['mail']) // получатель
        ->setBody($msg_content, 'text/html');

      $result = $mailer->send($message); // отправляем письмо
    }
  }
}


// шаблонизация main.php
$main = include_template("mailing_list.php", ["users_mail" => $users_mail]); // шаблон основной страницы

// Данные для layout.php
$layoutArr = [
  "title" => "LetterHead - Кабинет администратора", // Заголовок страницы
  "main" => $main, // main страницы
];

print(include_template("layout.php", $layoutArr)); // шаблонизация и вывод layout