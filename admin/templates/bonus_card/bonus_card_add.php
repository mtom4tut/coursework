<h2 class="modal__title">Добавление бонусной карты</h2>

<form autocomplete="off" class="form auth" action="/admin/bonus_card.php" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <label class="well__text form__label" for="id_user">id пользователя<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["id_user"])) {
                                print("form__input--error");
                              } ?>" type="text" name="id_user" id="id_user" value="<?= get_post_val("id_user") ?>" placeholder="Введите id пользователя">

    <?php if (isset($errors["id_user"])) : ?>
      <p class="form__message"> <?= $errors["id_user"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="addRecording" value="addRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Добавить новую карту">
  </div>
</form>