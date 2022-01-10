<main class="main">
  <div class="slider">
    <div class="swiper-container swiper-slider swiper-container-horizontal swiper-container-fade" data-loop="false" data-autoplay="5000" data-height="590px" data-min-height="200px" data-slide-effect="fade" data-slide-speed="1600ms" data-keyboard="false" data-mousewheel="false" data-mousewheel-release="false" style="height: 590px;">
      <div class="swiper-wrapper" style="transition-duration: 1600ms;">
        <div class="swiper-slide" style="background-image: url(&quot;img/slider/1.png&quot;); background-size: cover; width: 1998px; opacity: 1; transform: translate3d(0px, 0px, 0px); transition-duration: 1600ms;">
          <div class="slide-desc">
            <div class="container">
              <div>
                <h2 data-caption-animate="fadeInUp" class="not-animated">№1 среди магазинов канцелярских товаров</h2>
                <h3 data-caption-animate="fadeInUp" data-caption-delay="200" class="not-animated">Это наша миссия!</h3>
                <h5 data-caption-animate="fadeInUp" data-caption-delay="400" class="not-animated">Мы рады предоставить вам продукты премиум-класса и первоклассные услуги.</h5>
                <a href="/" class="btn-primary" data-caption-animate="fadeInUp" data-caption-delay="600">Купить сейчас!</a>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide swiper-slide-prev" style="background-image: url(&quot;img/slider/2.png&quot;); background-size: cover; width: 1998px; opacity: 1; transform: translate3d(-1998px, 0px, 0px); transition-duration: 1600ms;">
          <div class="slide-desc">
            <div class="container">
              <div>
                <h2 data-caption-animate="fadeInUp" class="fadeInUp animated">Целый магазин</h2>
                <h3 data-caption-animate="fadeInUp" data-caption-delay="200" class="fadeInUp animated">Для всех ваших нужд</h3>
                <h5 data-caption-animate="fadeInUp" data-caption-delay="400" class="fadeInUp animated">Лучшие канцелярские товары</h5>
                <a href="/" class="btn-primary" data-caption-animate="fadeInUp" data-caption-delay="600">Купить сейчас!</a>
              </div>
            </div>
          </div>
        </div>

        <div class="swiper-slide swiper-slide-active" style="background-image: url(&quot;img/slider/3.png&quot;); background-size: cover; width: 1998px; opacity: 1; transform: translate3d(-3996px, 0px, 0px); transition-duration: 1600ms;">
          <div class="slide-desc">
            <div class="container">
              <div>
                <h2 data-caption-animate="fadeInUp" class="not-animated">Разнообразие товаров</h2>
                <h3 data-caption-animate="fadeInUp" data-caption-delay="200" class="not-animated">Всегда вам рады</h3>
                <h5 data-caption-animate="fadeInUp" data-caption-delay="400" class="not-animated">Лучшие продукты</h5>
                <a href="/" class="btn-primary" data-caption-animate="fadeInUp" data-caption-delay="600">Купить сейчас!</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-button-next swiper-button-disabled"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>

  <div class="container">
    <div class="banner">
      <div class="banner__column">
        <div class="banner__item">
          <a class="banner__link" href="/">
            <div class="banner__img"><img src="img/banner/1.png" alt="banner-1" class="img-responsive"></div>
            <div class="s-desc">
              <div class="banner__title">Блокноты</div>
              <div class="banner__desc">Начиная с 521&#8381;</div>
            </div>
          </a>
        </div>

        <div class="banner__item">
          <a class="banner__link" href="/">
            <div class="banner__img"><img src="img/banner/2.png" alt="banner-2" class="img-responsive"></div>
            <div class="s-desc">
              <div class="banner__title">Дневники</div>
              <div class="banner__desc">Начиная с 449&#8381;</div>
            </div>
          </a>
        </div>
      </div>

      <div class="banner__column">
        <div class="banner__item">
          <a class="banner__link" href="/">
            <div class="banner__img"><img src="img/banner/3.png" alt="banner-3" class="img-responsive"></div>
            <div class="s-desc">
              <div class="banner__title">Школьные <br /> аксессуары</div>
              <div class="banner__desc">Начиная с 49&#8381;</div>
            </div>
          </a>
        </div>
      </div>

      <div class="banner__column">
        <div class="banner__item">
          <a class="banner__link" href="/">
            <div class="banner__img"><img src="img/banner/4.png" alt="banner-4" class="img-responsive"></div>
            <div class="s-desc">
              <div class="banner__title">Календари</div>
              <div class="banner__desc">Начиная с 699&#8381;</div>
            </div>
          </a>
        </div>

        <div class="banner__item">
          <a class="banner__link" href="/">
            <div class="banner__img"><img src="img/banner/5.png" alt="banner-5" class="img-responsive"></div>
            <div class="s-desc">
              <div class="banner__title">Книги</div>
              <div class="banner__desc">Начиная с 599&#8381;</div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="goods__header">
      <h2 class="goods__header-title">Товары</h2>

      <form autocomplete="off" class="goods__header-search" action="index.php" method="get" autocomplete="off">
        <input type="text" name="search" value="" placeholder="Поиск по магазину">
        <button type="submit" class="goods__header-search-btn"><i class="fas fa-search"></i></button>
      </form>

      <ul class="goods__header-list">
        <li class="<?= isset($_GET['discounts']) ? '' : 'active' ?>">
          <a href="/">
            Все
          </a>
        </li>
        <li class="<?= isset($_GET['discounts']) ? 'active' : '' ?>">
          <a href="?discounts">
            Скидки
          </a>
        </li>
      </ul>
    </div>

    <div class="goods <?= count($goods) === 0 ? 'goods-no-grid' : '' ?>">
      <?php if (count($goods) === 0) : ?>
        <div class="goods__none">По вашему запросу ничего не найдено...</div>
      <?php else : ?>
        <?php foreach ($goods as $item) : ?>
          <?php
          $itemStatus = $item['data_start'] <= date("Y-m-d") && date("Y-m-d") <= $item['data_end'];
          ?>
          <div class="goods__item">
            <div class="goods__item-image-block">
              <a class="goods__item-link" href="/">
                <img alt="<?= $item['title'] ?>" title="<?= $item['title'] ?>" class="goods__item-img" src="img/goods/<?= $item['id'] ?>.png" alt="img">
              </a>
            </div>
            <div class="goods__item-content">
              <div class="goods__item-title">
                <?= $item['title'] ?>
              </div>

              <?php if (isset($item['bonuses']) && $item['bonuses'] !== 0 && $itemStatus && $count > 0) : ?>
                <div class="goods__item-bonus" style="margin-top: 10px">
                  Бонусы за покупку:
                  <span><?= $item['bonuses'] ?></span>
                </div>
              <?php endif; ?>

              <div class="goods__item-footer">
                <div class="goods__item-price">
                 <?php if ($count > 0) : ?>
                  <span><?= $itemStatus ? $item['price'] * ((100 - $item['discount']) / 100) : $item['price'] ?>&#8381;</span>
                 <?php endif; ?>
                  <?php if (isset($item['discount']) && $item['discount'] !== 0 && $itemStatus) : ?>
                    <span><?= $item['price'] ?>&#8381;</span>
                  <?php endif; ?>
                </div>

                <button type="button" class="goods__item-btn" data-id="<?= $item['id'] ?>" data-title="<?= $item['title'] ?>" data-price="<?= $item['price'] ?>" data-description="<?= $item['description'] ?>">
                  Купить
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</main>