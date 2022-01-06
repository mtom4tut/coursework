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
</head>

<body>
  <?php if (isset($_SESSION['admin'])) : ?>
    <header class="header">
      header
    </header>
  <?php endif; ?>

  <?php if (isset($_SESSION['admin'])) : ?>
    <aside class="header">
      aside
    </aside>
  <?php endif; ?>

  <?= $main ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="../../js/swmin.js"></script>
  <script src="../../js/swinit.js"></script>
  <script src='../../js/flatpickr.js'></script>
  <script src="../../js/script.js?ver=1"></script>
</body>

</html>