<?php
if(isset($_SESSION['buy'])) {
  $sql = "UPDATE bonus_cards SET balance = balance + ? WHERE id_user = ?";
  $data = db_insert_data($link, $sql, [$_SESSION['buy']['bonus'], $_SESSION['user']['id']]);
  unset($_SESSION['buy']);
}
?>

<div class="container">
<ul class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i></a> <i class="fas fa-chevron-right"></i></li>
    <li><a href="/">Главная</a> <i class="fas fa-chevron-right"></i> </li>
    <li><span>Оформление заказа</span></li>
  </ul>
  <main class="main buy">
    <h1>
      <span>Заказ успешно сформирован!</span>
      В скорем времени вам на почту придет номер по которому можно будет остледить заказ...
      <span>Спасибо за покупку!</span>
  </h1>
  </main>
</div>