<h2 class="modal__title">Добавление пользователя</h2>

<form autocomplete="off" class="form auth" action="/admin/user.php" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <label class="well__text form__label" for="username">Имя<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["username"])) {
                                print("form__input--error");
                              } ?>" type="text" name="username" id="username" value="<?= get_post_val("username") ?>" placeholder="Введите имя">

    <?php if (isset($errors["username"])) : ?>
      <p class="form__message"> <?= $errors["username"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="mail">E-Mail<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["mail"])) {
                                print("form__input--error");
                              } ?>" type="text" name="mail" id="mail" value="<?= get_post_val("mail") ?>" placeholder="Введите E-Mail">

    <?php if (isset($errors["mail"])) : ?>
      <p class="form__message"> <?= $errors["mail"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="birthday">Дата дня рождения<sup>*</sup></label>
    <input class="form__input form__input--date
            <?php
            if (isset($errors["birthday"])) {
              print("form__input--error");
            }
            ?>" type="text" name="birthday" id="date" value="<?= get_post_val("birthday") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

    <?php if (isset($errors["birthday"])) : ?>
      <p class="form__message"> <?= $errors["birthday"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="password">Пароль<sup>*</sup></label>
    <input class="form__input <?php if (isset($errors["password"])) {
                                print("form__input--error");
                              } ?>" type="password" name="password" id="password" value="<?= get_post_val("password") ?>" placeholder="Введите пароль">

    <?php if (isset($errors["password"])) : ?>
      <p class="form__message"> <?= $errors["password"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="addRecording" value="addRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Добавить пользователя">
  </div>
</form>