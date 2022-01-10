<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel='shortcut icon' href='../../img/favicon.png' type='image/x-icon'>

  <link rel="stylesheet" href="../../styles/normalize.css">
  <link rel="stylesheet" href=" styles/style.css?ver=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="../../styles/swiper.min.css" />
  <link rel="stylesheet" href="../../styles/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">

  <?php if ( isset($_GET["add"]) || isset($_POST["update"]) || ($_SERVER['REQUEST_METHOD'] === "POST" && (isset($_POST["addRecording"]) || isset($_POST["updateRecording"])))) : ?>
    <style>
      body, html {
        overflow: hidden;
      }
    </style>
  <?php endif; ?>
</head>

<body>
  <?php if (isset($_SESSION['admin'])) : ?>
    <header class="header">
      <a href="/admin/">
        <img src="../../img/logo.png" title="LetterHead" alt="LetterHead">
      </a>
      <a href="/admin/logout.php" class="header__link">Выйти из панели администратора</a>
    </header>
  <?php endif; ?>

  <?php if (isset($_SESSION['admin'])) : ?>
    <div class="content">
      <aside class="aside">
        <nav class="aside__nav">
          <ul>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/stock.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/stock.php"><i class="fas fa-percent"></i> Скидки</a>
            </li>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/user.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/user.php"><i class="fas fa-users"></i> Пользователи</a>
            </li>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/vipuser.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/vipuser.php"><i class="fas fa-crown"></i>vip Пользователи</a>
            </li>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/bonus_card.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/bonus_card.php"><i class="fas fa-credit-card"></i>Бонусные карты</a>
            </li>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/goods.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/goods.php"><i class="fas fa-digital-tachograph"></i>Товары</a>
            </li>
            <li class="aside__li <?= $_SERVER['REQUEST_URI'] === "/admin/statistics_user.php" ? 'active' : '' ?>">
              <a class="aside__link" href="/admin/statistics_user.php"><i class="far fa-clipboard"></i></i>Статистика пользователей</a>
            </li>
          </ul>
        </nav>
      </aside>
      <main class="main">
        <?= $main ?>
      </main>
    </div>

    <?php if ($_SERVER['REQUEST_URI'] !== "/admin/statistics_user.php" && (isset($_GET['add']) || isset($_GET['update']) || $_SERVER['REQUEST_METHOD'] === "POST")) : ?>
      <div class="modal">
        <div class="modal__item">
          <a href="<?= $url ?>" class="modal__close"><i class="fas fa-times"></i></a>
            <?php
              if (isset($_GET['add']) || ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["addRecording"]))) {
                print($add);
              }
              elseif (isset($_GET['update']) || ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["updateRecording"]))) {
                print($update);
              } else {
                print("Произошла ошибка...");
              }
            ?>
        </div>
      </div>
    <?php endif; ?>
  <?php else : ?>
    <?= $main ?>
  <?php endif; ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src='../../js/flatpickr.js'></script>
  <script src="/admin/js/script.js"></script>
</body>

</html>