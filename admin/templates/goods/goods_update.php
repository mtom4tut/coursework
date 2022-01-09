<h2 class="modal__title">Изменение записи</h2>

<form autocomplete="off" class="form auth" action="/admin/stock.php" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <label class="well__text form__label" for="id">ID товара<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["id"])) {
                                print("form__input--error");
                              } ?>" type="text" name="id" id="id" value="<?= get_post_val("id") === "" ? $updateData['id_good'] : get_post_val("id") ?>" placeholder="Введите id товара">

    <?php if (isset($errors["id"])) : ?>
      <p class="form__message"> <?= $errors["id"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="discount">Скидка (в %)</label>

    <input class="form__input <?php if (isset($errors["discount"])) {
                                print("form__input--error");
                              } ?>" type="text" name="discount" id="discount" value="<?= get_post_val("discount") === "" ? $updateData['discount'] : get_post_val("discount") ?>" placeholder="Введите скидку товара">

    <?php if (isset($errors["discount"])) : ?>
      <p class="form__message"> <?= $errors["discount"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="bonus">Бонусы</label>

    <input class="form__input <?php if (isset($errors["bonus"])) {
                                print("form__input--error");
                              } ?>" type="text" name="bonus" id="bonus" value="<?= get_post_val("bonus") === "" ? $updateData['bonuses'] : get_post_val("bonus") ?>" placeholder="Введите число бонусов товара">

    <?php if (isset($errors["bonus"])) : ?>
      <p class="form__message"> <?= $errors["bonus"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="dateStart">Дата начала акции</label>

    <input class="form__input form__input--date
            <?php
            if (isset($errors["dateStart"])) {
              print("form__input--error");
            }
            ?>" type="text" name="dateStart" id="dateStart" value="<?= get_post_val("dateStart") === "" ? $updateData['data_start'] : get_post_val("dateStart") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

    <?php if (isset($errors["dateStart"])) : ?>
      <p class="form__message"> <?= $errors["dateStart"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="date">Дата окончания акции<sup>*</sup></label>

    <input class="form__input form__input--date
            <?php
            if (isset($errors["date"])) {
              print("form__input--error");
            }
            ?>" type="text" name="date" id="dateEnd" value="<?= get_post_val("date") === "" ? $updateData['data_end'] : get_post_val("date") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

    <?php if (isset($errors["date"])) : ?>
      <p class="form__message"> <?= $errors["date"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="updateRecording" value="updateRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Изменить запись">
  </div>
</form>