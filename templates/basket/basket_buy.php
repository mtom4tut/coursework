<div class="container">
  <ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Оформление заказа</span></li>
  </ul>
  <main class="main buy">
    <?php if ($balance > 0 && isset($_SESSION['buy'])) : ?>
      <h1>
        <span>Хотите ли Вы использовать свои бонусы?</span>
      </h1>
      <div class="buy__info">При использовании накопленных бонусов бонусы за покупку не начисляются!</div>
      <div class="buy_price"><span>Цена с учетом бонусов:&#160;</span> <?= $price ?>&#8381;</div>
      <div class="buy_price"><span>Число затраченных бонусов:&#160;</span> <?= $bonus_remove ?></div>
      <div class="buy__btn">
        <a href="basket_buy.php?bonus" class="btn-primary">Оформить заказ c использованием бонусов</a>
        <a href="basket_buy.php?buy" class="btn-primary">Оформить заказ</a>
      </div>
    <?php else : ?>
      <h1>
        <span>Заказ успешно сформирован!</span>
        В скорем времени вам на почту придет чек и номер по которому можно будет остледить заказ...
        <span>Спасибо за покупку!</span>
      </h1>
    <?php endif; ?>
  </main>
</div>