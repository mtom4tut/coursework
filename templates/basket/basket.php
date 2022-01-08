<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

$total_price = 0;
$total_bonus = 0;
if ($goods !== "") {
  foreach ($goods as $item) {
    if ($item['data_start'] <= date("Y-m-d") && date("Y-m-d") <= $item['data_end']) {
      $total_price += $item['price'] * ((100 - $item['discount']) / 100) * $item['number'];
      $total_bonus += $item['bonuses'] * $item['number'];
    } else {
      $total_price += $item['price'] * $item['number'];
    }
  }
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
    <?php if ($goods === "") : ?>
      <p class="basket__none">Корзина пуста...</p>
    <?php else : ?>
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
              <span><?= $itemStatus ? $item['price'] * ((100 - $item['discount']) / 100) : $item['price'] ?>&#8381;</span>
              <?php if (isset($item['discount']) && $item['discount'] !== 0 && $itemStatus) : ?>
                <span><?= $item['price'] ?>&#8381;</span>
              <?php endif; ?>
            </div>

            <?php if (isset($item['bonuses']) && $item['bonuses'] !== 0 && $itemStatus) : ?>
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
            <span>Бонусов за покупку:</span> <?= $total_bonus ?>&#8381;
          <?php endif; ?>
        </h3>
        <a href="basket_buy.php" class="btn-primary">Оформить заказ</a>
      </div>
    <?php endif; ?>
  </div>
</div>