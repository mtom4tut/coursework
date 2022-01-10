<div class="main__flex">
  <form class="main__search" action="/admin/calendar.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="id">id</option>
      <option value="date" <?= isset($_GET['select']) && $_GET['select'] === 'date' ? 'selected
' : '' ?>>Дата праздника</option>
      <option value="holiday" <?= isset($_GET['select']) && $_GET['select'] === 'holiday' ? 'selected
' : '' ?>>Название праздника</option>
      <option value="discount" <?= isset($_GET['select']) && $_GET['select'] === 'discount' ? 'selected
' : '' ?>>Скидка в праздник</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/calendar.php?add" type="button" class="btn-primary">Добавить скидку</a>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id</th>
          <th>Дата праздника</th>
          <th>Название праздника</th>
          <th>Скидка в праздник (в %)</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['date'] ?></td>
            <td><?= $item['holiday'] ?></td>
            <td><?= $item['discount'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/calendar.php?update=<?= $item['id'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/calendar.php?remove=<?= $item['id'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>