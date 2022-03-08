<div>
  <h1>Рассылка</h1>

  <h2>
    Получатели:
  </h2>

  <form method="post" action="./mailing_list.php">
    <div class="checkselect">
      <label><input type="checkbox" name="users[]" value="all" checked>Все</label>
      <?php foreach ($users_mail as $val) : ?>
        <label>
          <input type="checkbox" name="users[]" value="<?= $val['id'] ?>">id: <?= $val['id'] ?>. <?= $val['username'] ?>
        </label>
      <?php endforeach; ?>
    </div>

    <div>
      <textarea class="form-textarea" name="mailContent" id="mailContent" placeholder="Введите текст собщения" rows="10" required="" minlength="20"></textarea>
    </div>



    <button type="submit" class="btn btn-primary">Отправить</button>

  </form>
</div>