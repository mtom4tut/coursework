<h2 class="modal__title">Изменение данных карты</h2>

<form autocomplete="off" class="form auth" action="/admin/bonus_card.php" method="post" enctype="multipart/form-data">
<div class="form__group">
    <label class="well__text form__label" for="balance">Бонусы пользователя</label>

    <input class="form__input <?php if (isset($errors["balance"])) {
                                print("form__input--error");
                              } ?>" type="text" name="balance" id="balance" value="<?= get_post_val("balance") === "" ? $updateData['balance'] : get_post_val("balance") ?>" placeholder="Введите бонусы пользователя">

    <?php if (isset($errors["balance"])) : ?>
      <p class="form__message"> <?= $errors["balance"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="updateRecording" value="updateRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Измененить данные карты">
  </div>
</form>