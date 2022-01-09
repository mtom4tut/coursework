<div class="main__flex">
  <form class="main__search" action="/admin/vipuser.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="id_user">id пользователя</option>
      <option value="username" <?= isset($_GET['select']) && $_GET['select'] === 'username' ? 'selected
' : '' ?>>Имя пользователя</option>
      <option value="mail" <?= isset($_GET['select']) && $_GET['select'] === 'mail' ? 'selected
' : '' ?>>E-Mail пользователя</option>
      <option value="data_start" <?= isset($_GET['select']) && $_GET['select'] === 'data_start' ? 'selected
' : '' ?>>Дата начала премиума</option>
      <option value="data_end" <?= isset($_GET['select']) && $_GET['select'] === 'data_end' ? 'selected
' : '' ?>>Дата окончания премиума</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/vipuser.php?add" type="button" class="btn-primary">Добавить vip пользователя</a>
</div>

<div class="main__vip-settings">
  <div class="main__vip-settings-item">
    Дополнительная скидка:
    <input type="number" name="discount" class="basket__item-input-qty" min="0" max="100" value="<?= $vip_discount ?>">
  </div>
  <div class="main__vip-settings-item">
    Дополнительные бонусы:
    <input type="number" name="bonus" class="basket__item-input-qty" min="0" max="9999" value="<?= $vip_bonus ?>">
  </div>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id пользователя</th>
          <th>Имя пользователя</th>
          <th>E-Mail пользователя</th>
          <th>Дата начала премиум подписки</th>
          <th>Дата окончания премиум подписки</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id_user'] ?></td>
            <td><?= $item['username'] ?></td>
            <td><?= $item['mail'] ?></td>
            <td><?= $item['data_start'] ?></td>
            <td><?= $item['data_end'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/vipuser.php?update=<?= $item['id_user'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/vipuser.php?remove=<?= $item['id_user'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>