<div class="container">
  <ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Регистрация</span></li>
  </ul>

  <main class="main reg">
    <h2 class="main__heading">РЕГИСТРАЦИЯ</h2>
    <p class="main__info">Если Вы уже зарегистрированы, перейдите на страницу <a href="/authorization.php">авторизации</a>.</p>


    <form autocomplete="off" class="form" action="register.php" method="post" autocomplete="off">
      <fieldset>
        <legend>Основные данные</legend>

        <div class="form__group">
          <label class="form__label" for="name">Имя <sup>*</sup></label>

          <input class="form__input <?php if (isset($errors["name"])) {
                                      print("form__input--error");
                                    } ?>" type="text" name="name" id="name" value="<?= get_post_val("name") ?>" placeholder="Введите имя">
          <?php if (isset($errors["name"])) : ?>
            <p class="form__message"> <?= $errors["name"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__group">
          <label class="form__label" for="email">E-Mail <sup>*</sup></label>

          <input class="form__input
            <?php
            if (isset($errors["email"])) {
              print("form__input--error");
            }
            ?>" type="text" name="email" id="email" value="<?= get_post_val("email") ?>" placeholder="Введите E-Mail">

          <?php if (isset($errors["email"])) : ?>
            <p class="form__message"> <?= $errors["email"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__group">
          <label class="form__label" for="date">Дата дня рождения <sup>*</sup></label>

          <input class="form__input form__input--date
            <?php
            if (isset($errors["date"])) {
              print("form__input--error");
            }
            ?>" type="text" name="date" id="date" value="<?= get_post_val("date") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

          <?php if (isset($errors["date"])) : ?>
            <p class="form__message"> <?= $errors["date"] ?> </p>
          <?php endif; ?>
        </div>
      </fieldset>

      <fieldset>
        <legend>Ваш пароль</legend>

        <div class="form__group">
          <label class="form__label" for="password">Пароль <sup>*</sup></label>

          <input class="form__input <?php if (isset($errors["password"])) {
                                      print("form__input--error");
                                    } ?>" type="password" name="password" id="password" value="<?= get_post_val("password") ?>" placeholder="Введите пароль">

          <?php if (isset($errors["password"])) : ?>
            <p class="form__message"> <?= $errors["password"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__group">
          <label class="form__label" for="password-confirmation">Подтверждение пароля <sup>*</sup></label>

          <input class="form__input <?php if (isset($errors["password-confirmation"])) {
                                      print("form__input--error");
                                    } ?>" type="password" name="password-confirmation" id="password-confirmation" value="<?= get_post_val("password-confirmation") ?>" placeholder="Введите пароль">

          <?php if (isset($errors["password-confirmation"])) : ?>
            <p class="form__message"> <?= $errors["password-confirmation"] ?> </p>
          <?php endif; ?>
        </div>
      </fieldset>

      <div class="form__submit">
        <?php if (isset($errors)) : ?>
          <p>Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>

        <input type="submit" name="" value="Зарегистрироваться">
      </div>
    </form>
  </main>
</div>