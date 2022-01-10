document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // формат даты в календаре
  flatpickr("#date", {
    dateFormat: "Y-m-d",
    locale: "ru",
    maxDate: new Date(),
  });

  // формат даты в календаре
  flatpickr("#dateEnd", {
    dateFormat: "Y-m-d",
    locale: "ru",
    minDate: new Date(),
  });

  // формат даты в календаре
  flatpickr("#dateStart", {
    dateFormat: "Y-m-d",
    locale: "ru",
  });

  $(".main__vip-settings input").on("mouseup", (e) => {
    const target = e.target;
    let name = $(target).attr("name");
    let value = target.value;

    $.post(
      "templates/vipuser/vipuser_bonus_update.php",
      { name, value },
      function (data) {
        // console.log(data);
      }
    );
  });

  $(".main__vip-settings input").on("blur", (e) => {
    const target = e.target;
    let name = $(target).attr("name");
    let value = target.value;

    $.post(
      "templates/vipuser/vipuser_bonus_update.php",
      { name, value },
      function (data) {
        // console.log(data);
      }
    );
  });

  let startPicker = flatpickr("#date-from", {
    dateFormat: "d.m.Y",
    locale: "ru",
    // для интервала дат
    onChange: function (selectedDates) {
      endPicker.set("minDate", selectedDates[0]);
    },
  });

  let endPicker = flatpickr("#date-to", {
    dateFormat: "d.m.Y",
    locale: "ru",
    // для интервала дат
    onChange: function (selectedDates) {
      startPicker.set("maxDate", selectedDates[0]);
    },
  });
});
