<div class="main__flex">
  <form class="main__search" action="/admin/goods.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="id">id товара</option>
      <option value="title" <?= isset($_GET['select']) && $_GET['select'] === 'title' ? 'selected
' : '' ?>>Заголовок товара</option>
      <option value="price" <?= isset($_GET['select']) && $_GET['select'] === 'price' ? 'selected
' : '' ?>>Цена товара</option>
      <option value="description" <?= isset($_GET['select']) && $_GET['select'] === 'description' ? 'selected' : '' ?>>Описание товара</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/goods.php?add" type="button" class="btn-primary">Добавить товар</a>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id товара</th>
          <th>Картинка товара</th>
          <th>Заголовок товара</th>
          <th>Цена товара</th>
          <th>Описание товара</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td>
              <img height="100" src="../../../img/goods/<?= $item['id'] ?>.png" alt="img">
            </td>
            <td><?= $item['title'] ?></td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['description'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/goods.php?update=<?= $item['id'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/goods.php?remove=<?= $item['id'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>