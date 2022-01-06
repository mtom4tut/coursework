<div class="container" style="height: 98%">
  <main class="main auth">
    <div class="well">
      <h2>Вход в кабинет администратора</h2>

      <form class="form auth" action="/admin/authorization.php" method="post" enctype="multipart/form-data">
        <div class="form__group">
          <label class="well__text form__label" for="login">E-Mail</label>

          <input class="form__input <?php if (isset($errors["login"])) {
                                      print("form__input--error");
                                    } ?>" type="text" name="login" id="login" value="<?= get_post_val("login") ?>" placeholder="Введите E-Mail">

          <?php if (isset($errors["login"])) : ?>
            <p class="form__message"> <?= $errors["login"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__group">
          <label class="well__text form__label" for="password">Пароль</label>

          <input class="form__input <?php if (isset($errors["password"])) {
                                      print("form__input--error");
                                    } ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">

          <?php if (isset($errors["password"])) : ?>
            <p class="form__message"> <?= $errors["password"] ?> </p>
          <?php endif; ?>
        </div>

        <div class="form__submit">
          <input type="submit" class="btn-primary" name="" value="Войти">
        </div>
      </form>
  </main>
</div>