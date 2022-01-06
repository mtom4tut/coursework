<div class="container">
  <ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Авторизация</span></li>
  </ul>

  <main class="main auth">
    <div class="well">
      <h2>Новый клиент</h2>
      <p class="well__text"><strong>Регистрация</strong></p>
      <p class="well__text">Создание учетной записи поможет покупать быстрее. Вы сможете контролировать состояние заказа, а также просматривать заказы сделанные ранее. Вы сможете накапливать призовые баллы и получать скидочные купоны. <br>А постоянным покупателям мы предлагаем гибкую систему скидок и персональное обслуживание.<br></p>
      <a href="/register.php" class="btn-primary">Продолжить</a>
    </div>

    <div class="well">
      <h2>Зарегистрированный клиент</h2>
      <p class="well__text"><strong>Войти в Личный Кабинет</strong></p>

      <form class="form auth" action="/authorization.php" method="post" enctype="multipart/form-data">
        <div class="form__group">
          <label class="well__text form__label" for="email">E-Mail</label>

          <input class="form__input <?php if (isset($errors["email"])) {
                                      print("form__input--error");
                                    } ?>" type="text" name="email" id="email" value="<?= get_post_val("email") ?>" placeholder="Введите E-Mail">

          <?php if (isset($errors["email"])) : ?>
            <p class="form__message"> <?= $errors["email"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__group">
          <label class="well__text form__label" for="password">Пароль</label>

          <input class="form__input <?php if (isset($errors["password"])) {
                                      print("form__input--error");
                                    } ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль" autocomplete="on">

          <?php if (isset($errors["password"])) : ?>
            <p class="form__message"> <?= $errors["password"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__submit">
          <input type="submit" class="btn-primary" name="" value="Войти">
        </div>
      </form>
    </div>
  </main>
</div>