<h2 class="modal__title">Изменение данных пользователя</h2>

<form autocomplete="off" class="form auth" action="/admin/vipuser.php" method="post" enctype="multipart/form-data">
<div class="form__group">
    <label class="well__text form__label" for="id_user">id пользователя<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["id_user"])) {
                                print("form__input--error");
                              } ?>" type="text" name="id_user" id="id_user" value="<?= get_post_val("id_user") === "" ? $updateData['id_user'] : get_post_val("id_user") ?>" placeholder="Введите id пользователя">

    <?php if (isset($errors["id_user"])) : ?>
      <p class="form__message"> <?= $errors["id_user"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="data_start">Дата начала подписки</label>

    <input class="form__input form__input--date
            <?php
            if (isset($errors["data_start"])) {
              print("form__input--error");
            }
            ?>" type="text" name="data_start" id="dateStart" value="<?= get_post_val("data_start") === "" ? $updateData['data_start'] : get_post_val("data_start") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

    <?php if (isset($errors["data_start"])) : ?>
      <p class="form__message"> <?= $errors["data_start"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="form__label" for="data_end">Дата окончания подписки<sup>*</sup></label>

    <input class="form__input form__input--data_end
            <?php
            if (isset($errors["data_end"])) {
              print("form__input--error");
            }
            ?>" type="text" name="data_end" id="dateEnd" value="<?= get_post_val("data_end") === "" ? $updateData['data_end'] : get_post_val("data_end") ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">

    <?php if (isset($errors["data_end"])) : ?>
      <p class="form__message"> <?= $errors["data_end"] ?> </p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="updateRecording" value="updateRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Измененить данные пользователя">
  </div>
</form>