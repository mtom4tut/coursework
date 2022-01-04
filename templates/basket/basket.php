<?php
// Подключение бд
include_once("./config/init.php");

// Подключение функций
include_once("./functions/helpers.php");

$total_price = 0;
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
        <div class="basket__item">
          <div class="basket__item-left">
            <img src="img/goods/<?= $item['id'] ?>.png" alt="img">
          </div>

          <div class="basket__item-right">
            <div class="basket__item-title">
              <span><?= $item['title'] ?></span>
              <button class="btn-remove" type="button" data-id="<?= $item['id'] ?>"><i class="fas fa-times"></i></button>
            </div>
            <div class="basket__item-price">Цена: <span><?= $item['price'] ?>&#8381;</span></div>
            <div class="basket__item-qty">
              Количество:
              <input type="number" name="qty" class="basket__item-input-qty" min="1" max="20" data-id="<?= $item['id'] ?>" value="<?=$item['number']?>">
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="basket__total">
        <h3>Итоговая сумма: <?= $total_price ?>&#8381;</h3>
        <button type="button" class="btn-primary">Оформить заказ</button>
      </div>
    <?php endif; ?>
  </div>
</div>