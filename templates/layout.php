<?php
// Подключение бд
$link = mysqli_connect("localhost", "root", "root", "coursework");

// Получение всех товаров корзины
$basket_count = 0;

if (isset($_SESSION['user'])) {
  $sql = "SELECT COUNT(*) from shopping_cart where id_user = ?";
  $basket_count = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]["COUNT(*)"];
} elseif (isset($_SESSION['basket'])) {
  $basket_count = count($_SESSION['basket']);
}

// Получение бонусов пользователя
if (isset($_SESSION['user'])) {
  $sql = "SELECT сard_number, balance from bonus_cards where id_user = ?";
  $bonus_cards = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0];
}

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
                              echo ', ' . $_SESSION['user']['name']
                            ?>!
          </b>

          <?php if (!isset($_SESSION['user'])) : ?>
            <a href="/register.php">Регистрация</a>
            <a href="/authorization.php">Вход</a>
          <?php else : ?>
            <span><b>Ваши бонусы: </b> <?=$bonus_cards['balance']?></span>
            <span class="header__top-right-bonus">
              <b>Бонусная карта</b>
              <div class="header__top-right-bonus-card">
                <img src="./img/qr/<?=$_SESSION['user']['id']?>.png" alt="">
                <span><?=chunk_split($bonus_cards['сard_number'], 4, ' ')?></span>
              </div>
            </span>
            <a href="/vip_user.php">Стать VIP пользователем?</a>
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

          <a href="/basket.php" class="header__bottom-basket">
            <div class="header__bottom-basket-num"><?= $basket_count ?></div>
            <i class="fas fa-shopping-cart"></i>
            <b>Корзина</b>
          </a>
        </nav>
      </div>
    </div>
  </header>

  <?= $main ?>

  <footer class="footer">
    <div class="footer__top">
      <div class="container footer__container">
        <div class="footer__top-left">
          <h3 class="footer__title">О нас</h3>
          <p class="footer__text">Наша миссия - быть магазином канцелярских товаров №1, и мы с гордостью выполняем ее из года в год. Мы гордимся тем, что предоставляем вам продукты премиум-класса и первоклассные услуги. Вы должны знать, что как клиент вы получите огромную выгоду от работы с нашей компанией. Наша политика обслуживания клиентов помогает нам оставаться на вершине нашего бизнеса более пятнадцати лет, потому что мы знаем свое дело и каждый раз выполняем свою работу надежно.</p>
        </div>

        <div class="footer__top-center">
          <h3 class="footer__title">Информация</h3>

          <ul class="footer__list">
            <li class="footer__text"><a href="/">O нас</a></li>
            <li class="footer__text"><a href="/">Информация о доставке</a></li>
            <li class="footer__text"><a href="/">Условия использования</a></li>
            <li class="footer__text"><a href="/">Политика конфиденциальности</a></li>
            <li class="footer__text"><a href="/">Контакты</a></li>
            <li class="footer__text"><a href="/">Возврат</a></li>
          </ul>
        </div>

        <div class="footer__top-right">
          <h3 class="footer__title">Информация о магазине</h3>

          <address>
            <dl>
              <dt class="footer__text"><i class="fas fa-map-marker-alt"></i>Адрес:&#160;</dt>
              <dd><a class="footer-link" href="//www.google.com/maps/?q=40.6700,+-73.9400" target="_blank"> 4578 Marmora Road, Glasgow, D04 89GR</a></dd>
            </dl>
            <dl>
              <dt class="footer__text"><i class="fas fa-phone-alt"></i>Телефон:&#160;</dt>
              <dd>
                <a class="footer-link" href="callto:8001230045">(800) 123-0045</a>; <a class="footer-link" href="callto:8001230046">(800) 123-0046</a>
              </dd>
            </dl>
            <dl>
              <dt class="footer__text"><i class="far fa-clock"></i>Мы открыты:&#160;</dt>
              <dd>Mn-Fr: 10 am-8 pm</dd>
            </dl>
          </address>
          <p><i class="far fa-envelope"></i><span class="footer__text">E-Mail: </span> <a href="mailto:demo-coursework@mail.ru">demo-coursework@mail.ru</a></p>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="container footer__container-bottom">
        <ul class="footer__social">
          <li><a class="fab fa-facebook-f" href="https://www.facebook.com/" title="Facebook"></a></li>
          <li><a class="fab fa-twitter" href="https://twitter.com/" title="Twitter"></a></li>
          <li><a class="fab fa-google-plus-g" href="https://plus.google.com/" title="Google+"></a></li>
        </ul>

        <ul class="footer__payments">
          <li><img src="img/payments/1.jpg" alt=""></li>
          <li><img src="img/payments/2.jpg" alt=""></li>
          <li><img src="img/payments/3.jpg" alt=""></li>
          <li><img src="img/payments/4.jpg" alt=""></li>
          <li><img src="img/payments/5.jpg" alt=""></li>
        </ul>

        <p class="footer__copyright">
          &#169; Курсовая работа 2021-2022
        </p>
      </div>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="/js/swmin.js"></script>
  <script src="/js/swinit.js"></script>
  <script src='/js/flatpickr.js'></script>
  <script src="/js/script.js?ver=1"></script>
</body>
</html>