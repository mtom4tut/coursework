<div class="main__flex">
  <form class="main__search" action="/admin/user.php" method="get" autocomplete="off">
    <select name="select" id="select">
      <option value="id">id</option>
      <option value="date_now" <?= isset($_GET['select']) && $_GET['select'] === 'date_now' ? 'selected
' : '' ?>>Дата регистрации</option>
      <option value="birthday" <?= isset($_GET['select']) && $_GET['select'] === 'birthday' ? 'selected
' : '' ?>>День рождения</option>
      <option value="username" <?= isset($_GET['select']) && $_GET['select'] === 'username' ? 'selected
' : '' ?>>Имя пользователя</option>
      <option value="mail" <?= isset($_GET['select']) && $_GET['select'] === 'mail' ? 'selected
' : '' ?>>Электронная почта</option>
    </select>
    <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Поиск по акциям">
    <button type="submit" class="main__search-btn"><i class="fas fa-search"></i></button>
  </form>

  <a href="/admin/user.php?add" type="button" class="btn-primary">Добавить пользователя</a>
</div>

<?php if (count($data) === 0) : ?>
  <div class="table__none">По вашему запросу ничего не найдено...</div>
<?php else : ?>
  <div class="table">
    <table class="table__content">
      <thead>
        <tr>
          <th>id</th>
          <th>Дата регистрации</th>
          <th>День рождения</th>
          <th>Имя пользователя</th>
          <th>Электронная почта</th>
          <th style="max-width: 175px;">Пароль</th>
          <th>Управление</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['date_now'] ?></td>
            <td><?= $item['birthday'] ?></td>
            <td><?= $item['username'] ?></td>
            <td><?= $item['mail'] ?></td>
            <td style="max-width: 175px; overflow: hidden"><?= $item['password'] ?></td>
            <td data-id="<?= $item['id'] ?>">
              <a href="/admin/user.php?update=<?= $item['id'] ?>" type="button" class="btn-table" title="Изменить запись">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <a href="/admin/user.php?remove=<?= $item['id'] ?>" type="button" class="btn-table" title="Удалить запись">
                <i class="fas fa-times"></i>
                </ф>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>