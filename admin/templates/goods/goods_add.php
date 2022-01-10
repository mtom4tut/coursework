<h2 class="modal__title">Добавление товара</h2>

<form autocomplete="off" class="form auth" action="/admin/goods.php" method="post" enctype="multipart/form-data">
  <div class="form__group">
    <label class="well__text form__label" for="price">Стоимость товара<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["price"])) {
                                print("form__input--error");
                              } ?>" type="text" name="price" id="price" value="<?= get_post_val("price") ?>" placeholder="Введите стоимость товара">

    <?php if (isset($errors["price"])) : ?>
      <p class="form__message"> <?= $errors["price"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="title">Заголовок товара<sup>*</sup></label>

    <input class="form__input <?php if (isset($errors["title"])) {
                                print("form__input--error");
                              } ?>" type="text" name="title" id="title" value="<?= get_post_val("title") ?>" placeholder="Введите заголовок товара">

    <?php if (isset($errors["title"])) : ?>
      <p class="form__message"> <?= $errors["title"] ?> </p>
    <?php endif; ?>
  </div>

  <div class="form__group">
    <label class="well__text form__label" for="description">Описание товара</label>
    <textarea name="description" id="description" rows="4"><?= get_post_val("description") ?></textarea>
  </div>

  <input type="hidden" name="addRecording" value="addRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Добавить товар">
  </div>
</form>