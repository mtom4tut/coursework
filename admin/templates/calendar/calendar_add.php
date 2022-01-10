<h2 class="modal__title">Добавление праздника</h2>

<form autocomplete="off" class="form auth" action="/admin/calendar.php" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <label class="well__text form__label" for="holiday">Название праздника<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["holiday"])) {
                                print("form__input--error");
                              } ?>" type="text" name="holiday" id="holiday" value="<?= get_post_val("holiday") ?>" placeholder="Введите название праздника">

    <?php if (isset($errors["holiday"])) : ?>
      <p class="form__message"> <?= $errors["holiday"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="date">Дата праздника<sup>*</sup></label>
    <input class="form__input form__input--date" type="text" name="date" id="dateSk" value="<?= get_post_val("date") ?>" placeholder="Введите дату в формате ММ-ДД">

    <?php if (isset($errors["date"])) : ?>
      <p class="form__message"> <?= $errors["date"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="discount">Скидка в праздник</label>
    <input class="form__input <?php if (isset($errors["discount"])) {
                                print("form__input--error");
                              } ?>" type="text" name="discount" id="discount" value="<?= get_post_val("discount") ?>" placeholder="Введите скидку в праздник">

    <?php if (isset($errors["discount"])) : ?>
      <p class="form__message"> <?= $errors["discount"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="addRecording" value="addRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Добавить пользователя">
  </div>
</form>