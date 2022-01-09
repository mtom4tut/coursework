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
    <label class="well__text form__label" for="file">Файл</label>

    <div class="form__input-file <?php if (isset($errors["file"])) {
                                    print("form__input--error");
                                  } ?>">
      <input class="visually-hidden" type="file" name="file" id="file" value="<?= get_post_val("file") ?>">

      <?php if (isset($errors["file"])) : ?>
        <p class="form__message"> <?= $errors["file"] ?> </p>
      <?php endif; ?>
    </div>
  </div>


  <input type="hidden" name="addRecording" value="addRecording" />

  <div class="form__submit">
    <input type="submit" class="btn-primary" name="" value="Добавить товар">
  </div>
</form>