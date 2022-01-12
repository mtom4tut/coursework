<style>
  h2 {
    color: #97cf1f;
  }

  .item {
    margin-top: 30px;
  }
</style>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Все скидки</span></li>
  </ul>

  <div class="div1">
    <div class="item">
      <h2>Праздничные скидки:</h2>
      <ul>
        <?php foreach ($holiday as $val) : ?>
          <li><span><?= $val['holiday'] ?>: </span> <?= $val['discount'] ?>% </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="item">
      <h2>Премиум скидки:</h2>
      <div>Дополнительная скидка: <?= $vip['discount'] ?>%</div>
      <div>Дополнительные бонусы: <?= $vip['bonus'] ?>%</div>
    </div>
    <div class="item">
      <h2>Скидки на товары:</h2>
      <ul>
        <?php foreach ($goods as $val) : ?>
          <li>
            <div><?= $val['title'] ?>:</div>
            <ul style="margin-left: 20px;">
              <li>Скидка: <?= $val['discount'] ?></li>
              <li>Бонусы: <?= $val['bonuses'] ?></li>
            </ul>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>