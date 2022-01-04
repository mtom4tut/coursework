document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // формат даты в календаре
  flatpickr("#date", {
    dateFormat: "Y-m-d",
    locale: "ru",
    maxDate: new Date()
  });

  $('.goods__item-btn').on('click', (e) => {
    const target = e.target;

    let id = target.dataset.id;
    let title = target.dataset.title;
    let price = target.dataset.price;
    let description = target.dataset.description;

    $.post('templates/basket/basket_add.php', {id, title, price, description}, function(data) {
      window.location.reload();
      // console.log(data);
    });
  })

  $('.basket__item-input-qty').on('click', (e) => {
    const target = e.target;

    let id = target.dataset.id;
    let value = target.value;

    $.post('templates/basket/basket_change_num.php', {id, value}, function(data) {
      window.location.reload();
      // console.log(data);
    });
  })

  $('.basket__item-btn-remove').on('click', (e) => {
    const target = e.target;

    let id = target.parentElement.dataset.id;
    $.post('templates/basket/basket_remove.php', {id}, function(data) {
      window.location.reload();
      // console.log(data);
    });
  })
});
