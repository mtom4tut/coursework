<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <h1>Писмо получено от пользователя: <?= $userName ?></h1>
  <h2>Почта отправителя: <?= $mail ?></h2>
  <h3>Сообщение:</h3>
  <p>
    <?= $mailContent ?>
  </p>
  <br>
  <br>
  © 2022, «LetterHead»
</body>

</html>