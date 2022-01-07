<div class="main__flex">
  <form class="main__search" action="index.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="id">id</option>
      <option value="id_good">id товара</option>
      <option value="title">Заголовок товара</option>
      <option value="discount">Скидка</option>
      <option value="bonuses">Количество бонусов</option>
      <option value="data_start">Дата начала акции</option>
      <option value="data_end">Дата окончания акции</option>
    </select>
    <input type="text" name="search" value="" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/stock.php?add" type="button" class="btn-primary">Добавить запись</a>
</div>

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
            <button type="button" class="btn-table" title="Изменить запись">
              <i class="fas fa-pencil-alt"></i>
            </button>
            <a href="/admin/stock.php?remove=<?=$item['id']?>" type="button" class="btn-table" title="Удалить запись">
              <i class="fas fa-times"></i>
            </ф>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>