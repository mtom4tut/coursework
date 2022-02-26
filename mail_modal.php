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
  ->setUsername('junepc20@mail.ru')
  ->setPassword('tE0kg3GS04yY9qRXAcGQ');

// Создание почтовой программы, используя созданный транспорт
$mailer = new Swift_Mailer($transport);

// Создание шаблона
$mailArr = ['userName' => $_SESSION['user']['name'], 'mail' => $_SESSION['user']['mail'], 'mailContent' => $_POST["mailContent"]];
$msg_content = include_template('send_email_modal.php', $mailArr);

$message = (new Swift_Message('Письмо специалисту «LetterHead»'))
  ->setFrom(['junepc20@mail.ru' => 'LetterHead']) // отправитель
  ->setTo('junepc20@mail.ru') // получатель
  ->setBody($msg_content, 'text/html');

$result = $mailer->send($message); // отправляем письмо

if ($result) {
  $message = (new Swift_Message('Уведомление от сервиса «LetterHead»'))
    ->setFrom(['junepc20@mail.ru' => 'LetterHead']) // отправитель
    ->setTo($_SESSION['user']['mail']) // получатель
    ->setBody("Ваше сообщение успешно доставлено. В скором времени наш специалист свяжется с вами.", 'text/html');

  $result = $mailer->send($message); // отправляем письмо
}

header("Location: index.php"); // переадресация
exit();
