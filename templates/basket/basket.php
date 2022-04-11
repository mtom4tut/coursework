<?php
$total_price = 0;
$total_bonus = 0;

$count = 0;
if (isset($_SESSION['user'])) {
  $sql = "SELECT COUNT(*) FROM bonus_cards WHERE id_user = ?";
  $count = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]["COUNT(*)"];
}

if ($goods !== "") {
  foreach ($goods as $item) {
    if ($item['data_start'] <= date("Y-m-d") && date("Y-m-d") <= $item['data_end']) {
      if ($count > 0) {
        $total_price += $item['price'] * ((100 - $item['discount']) / 100) * $item['number'];
        $total_bonus += $item['bonuses'] * $item['number'];
      } else {
        $total_price += $item['price'] * $item['number'];
      }
    } else {
      $total_price += $item['price'] * $item['number'];
    }
  }

  $sql = "SELECT COUNT(*) FROM premium_users where id_user = ? and data_start <= CURRENT_DATE and CURRENT_DATE <= data_end";
  $count = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]['COUNT(*)'];
  if ($count !== 0) {
    $sql = "SELECT discount, bonus FROM premium_bonus";
    $bonus = db_fetch_data($link, $sql)[0];
    $total_bonus += $total_price * ($bonus['bonus'] / 100);
    $total_price = $total_price * ((100 - $bonus['discount']) / 100);
  }

  // праздники
  $sql = "SELECT COUNT(*) FROM holidays WHERE date = ?";
  $countHolidays = db_fetch_data($link, $sql, [date("m-d")])[0]["COUNT(*)"];

  if($countHolidays !== 0) {
    $sql = "SELECT discount FROM holidays WHERE date = ?";
    $discount = db_fetch_data($link, $sql, [date("m-d")])[0]['discount'];
  }

  if($countHolidays !== 0) {
    $total_price = $total_price * ((100 - $discount) / 100);
  }

  // День рождения
  $sql = "SELECT COUNT(*) FROM users WHERE id = ? and month(birthday) = month(CURRENT_DATE) and day(birthday) = day(CURRENT_DATE)";
  $countbirthday = db_fetch_data($link, $sql, [$_SESSION['user']['id']])[0]["COUNT(*)"];

  if($countbirthday !== 0){
    $sql = "SELECT discount FROM holidays WHERE id = 1";
    $discountBirthday = db_fetch_data($link, $sql)[0]["discount"];
    $total_price = $total_price * ((100 - $discountBirthday) / 100);
  }

  $total_price = number_format((float)$total_price, 2, '.', '');
  $total_bonus = number_format((float)$total_bonus, 2, '.', '');

  $_SESSION['buy'] = [
    "price" => $total_price,
    "bonus" => $total_bonus
  ];
}
?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Корзина</span></li>
  </ul>

  <div class="basket">
    <h2 class="basket__title">Корзина товаров</h2>
    <?php if ($goods === "" || count($goods) === 0) : ?>
      <p class="basket__none">Корзина пуста...</p>
    <?php else : ?>
      <?php if ($countHolidays !== 0) : ?>
        <div class="basket__discount"><span>Празднечная скидка: </span><?= $discount ?>% от суммы покупки</div>
      <?php endif; ?>
      <?php if ($countbirthday !== 0) : ?>
        <div class="basket__discount"><span>С Днем Рождения! Ваша скидка: </span><?= $discountBirthday ?>% от суммы покупки</div>
      <?php endif; ?>
      <?php foreach ($goods as $item) : ?>
        <?php $itemStatus = $item['data_start'] <= date("Y-m-d") && date("Y-m-d") <= $item['data_end']; ?>
        <div class="basket__item">
          <div class="basket__item-left">
            <img src="img/goods/<?= $item['id'] ?>.png" alt="img">
          </div>

          <div class="basket__item-right">
            <div class="basket__item-title">
              <span><?= $item['title'] ?></span>
              <button class="basket__item-btn-remove btn-remove" type="button" data-id="<?= $item['id'] ?>"><i class="fas fa-times"></i></button>
            </div>
            <div class="basket__item-price">
              Цена:
              <?php if ($count > 0) : ?>
                <span><?= $itemStatus ? $item['price'] * ((100 - $item['discount']) / 100) : $item['price'] ?>&#8381;</span>
              <?php endif; ?>
              <?php if (isset($item['discount']) && $item['discount'] !== 0 && $itemStatus) : ?>
                <span><?= $item['price'] ?>&#8381;</span>
              <?php endif; ?>
            </div>

            <?php if (isset($item['bonuses']) && $item['bonuses'] !== 0 && $itemStatus && $count > 0) : ?>
              <div class="basket__item-bonus">
                Бонусы за покупку:
                <span><?= $item['bonuses'] * $item['number'] ?></span>
              </div>
            <?php endif; ?>

            <div class="basket__item-qty">
              Количество:
              <input type="number" name="qty" class="basket__item-input-qty" min="1" max="20" data-id="<?= $item['id'] ?>" value="<?= $item['number'] ?>">
            </div>

          </div>
        </div>
      <?php endforeach; ?>

      <div class="basket__total">
        <h3>
          <span>Итоговая сумма:</span> <?= $total_price ?>&#8381;

          <?php if ($total_bonus > 0) : ?>
            <span>Бонусов за покупку:</span> <?= $total_bonus ?>
          <?php endif; ?>
        </h3>
        <a href="basket_buy.php" class="btn-primary">Оформить заказ</a>
        <a class="btn-primary" href="/pdf/basket_pdf.php"> Корзина в PDF </a>
      </div>
    <?php endif; ?>
  </div>
</div>