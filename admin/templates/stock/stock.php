<div class="main__flex">
  <form class="main__search" action="/admin/stock.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="s.id">id</option>
      <option value="s.id_good" <?= isset($_GET['select']) && $_GET['select'] === 's.id_good' ? 'selected
' : '' ?>>id товара</option>
      <option value="g.title" <?= isset($_GET['select']) && $_GET['select'] === 'g.title' ? 'selected
' : '' ?>>Заголовок товара</option>
      <option value="s.discount" <?= isset($_GET['select']) && $_GET['select'] === 's.discount' ? 'selected
' : '' ?>>Скидка</option>
      <option value="s.bonuses" <?= isset($_GET['select']) && $_GET['select'] === 's.bonuses' ? 'selected
' : '' ?>>Количество бонусов</option>
      <option value="s.data_start" <?= isset($_GET['select']) && $_GET['select'] === 's.data_start' ? 'selected
' : '' ?>>Дата начала акции</option>
      <option value="s.data_end" <?= isset($_GET['select']) && $_GET['select'] === 's.data_end' ? 'selected
' : '' ?>>Дата окончания акции</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/stock.php?add" type="button" class="btn-primary">Добавить запись</a>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id</th>
          <th>id товара</th>
          <th>Заголовок товара</th>
          <th>Скидка (в&#160;%)</th>
          <th style="max-width: 175px;">Количество бонусов (1&#160;бонус&#160;=&#160;1&#160;рубль)</th>
          <th>Дата начала акции</th>
          <th>Дата окончания акции</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['id_good'] ?></td>
            <td><?= $item['title'] ?></td>
            <td><?= $item['discount'] ?></td>
            <td><?= $item['bonuses'] ?></td>
            <td><?= $item['data_start'] ?></td>
            <td><?= $item['data_end'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/stock.php?update=<?= $item['id'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/stock.php?remove=<?= $item['id'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>