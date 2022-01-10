<div class="main__flex">
  <form class="main__search" action="/admin/bonus_card.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="bc.id">id карты</option>
      <option value="id_user" <?= isset($_GET['select']) && $_GET['select'] === 'id_user' ? 'selected
' : '' ?>>id пользователя</option>
      <option value="username" <?= isset($_GET['select']) && $_GET['select'] === 'username' ? 'selected
' : '' ?>>Имя пользователя</option>
      <option value="mail" <?= isset($_GET['select']) && $_GET['select'] === 'mail' ? 'selected
' : '' ?>>E-Mail пользователя</option>
      <option value="сard_number" <?= isset($_GET['select']) && $_GET['select'] === 'сard_number' ? 'selected
' : '' ?>>Номер карты</option>
      <option value="date" <?= isset($_GET['select']) && $_GET['select'] === 'date' ? 'selected
' : '' ?>>Дата получения карты</option>
      <option value="balance" <?= isset($_GET['select']) && $_GET['select'] === 'balance' ? 'selected
' : '' ?>>Бонусы</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/bonus_card.php?add" type="button" class="btn-primary">Добавить новую карту</a>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id карты</th>
          <th>id пользователя</th>
          <th>Имя пользователя</th>
          <th>E-Mail пользователя</th>
          <th>Номер карты</th>
          <th>Дата получения карты</th>
          <th>Бонусы</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['id_user'] ?></td>
            <td><?= $item['username'] ?></td>
            <td><?= $item['mail'] ?></td>
            <td><?= $item['сard_number'] ?></td>
            <td><?= $item['date'] ?></td>
            <td><?= $item['balance'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/bonus_card.php?update=<?= $item['id'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/bonus_card.php?remove=<?= $item['id'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>