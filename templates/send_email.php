<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    span {
      color: #97cf1f;
      font-weight: 700;
    }

    a {
      color: #353fb1;
    }

    h2 {
      margin-top: 24px;
      margin-bottom: 0;
    }
    ul {
      margin-top: 0;
      margin-bottom: 0;
    }
  </style>
</head>

<body>
  <h1>Уважаемый пользователь, ваш заказ успешно сформирован!</h1>
  <div>
    <span>Номер по которому можно отследить заказ:</span> <?= substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10) ?>
    <a href="https://www.pochta.ru/">ПочтаРоссии</a>
  </div>

  <h2>Вы заказали:</h2>
  <ul>
    <?php foreach ($goods as $item) : ?>
      <li><?= $item['title'] ?></li>
    <?php endforeach; ?>
  </ul>

  <h2>Итоги:</h2>
  <div><span>Стоимоть покупки: </span><?= $price ?>&#8381;</div>
  <?php if ($bonus !== 0) : ?>
    <div><span>Начисленные бонусы: </span><?= $bonus ?></div>
  <?php endif; ?>
  <br>
  <br>
  © 2022, «LetterHead»
</body>

</html>