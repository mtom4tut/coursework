<?php
// Подключение бд
include_once("./config/init.php");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel='shortcut icon' href='img/favicon.png' type='image/x-icon'>

  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/style.css?ver=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/swiper.min.css" />
  <link rel="stylesheet" href="styles/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
</head>

<body>
  <header class="header">
    <div class="header__top">
      <div class="container">
        <div class="header__top-left">
          <span><i class="fas fa-phone-alt"></i> Телефоны: <b><a href="callto:8001230045">(800) 123-0045</a>; <a href="callto:8001230046"> (800) 123-0046</a></b></span>

          <span><i class="far fa-clock"></i> Мы открыты: <b>Пн-Пт: 10:00-20:00</b></span>
        </div>

        <div class="header__top-right">
          <b>
            Добро пожаловать<?php if (isset($_SESSION['user']))
              echo ', '.$_SESSION['user']['name']
            ?>!
          </b>

          <?php if (!isset($_SESSION['user'])) : ?>
            <a href="/register.php">Регистрация</a>
            <a href="/authorization.php">Вход</a>
          <?php else : ?>
            <a href="/logout.php">Выход</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="header__bottom">
        <div class="header__bottom-logo">
          <a href="/">
            <img src="img/logo.png" title="LetterHead" alt="LetterHead">
          </a>
        </div>

        <nav class="header__bottom-nav">
          <ul>
            <li class="header__bottom-nav-item">
              <a href="/" data-letters="Cases and School Bags">Портфели</a>
            </li>
            <li class="header__bottom-nav-item">
              <a href="/" data-letters="Frames &amp; Albums">Тетради &amp; Альбомы</a>
            </li>
            <li class="header__bottom-nav-item">
              <a href="/" data-letters="Calendars">Календари</a>
            </li>
            <li class="header__bottom-nav-item">
              <a href="/" data-letters="Equipment">Канцелярские принадлежности</a>
            </li>
          </ul>

          <div class="header__bottom-basket">
            <i class="fas fa-shopping-cart"></i>
            <b>Корзина</b>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <?= $main ?>

  <footer class="footer">

  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="/js/swmin.js"></script>
  <script src="/js/swinit.js"></script>
  <script src='/js/flatpickr.js'></script>
  <script src="/js/script.js?ver=1"></script>
</body>

</html>