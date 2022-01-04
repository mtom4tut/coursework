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
});
