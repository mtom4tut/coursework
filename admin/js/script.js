document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  // формат даты в календаре
  flatpickr("#date", {
    dateFormat: "Y-m-d",
    locale: "ru",
    maxDate: new Date(),
  });

  // формат даты в календаре
  flatpickr("#dateSk", {
    dateFormat: "m-d",
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
    dateFormat: "Y-m-d",
    locale: "ru",
    // для интервала дат
    onChange: function (selectedDates) {
      endPicker.set("minDate", selectedDates[0]);
    },
  });

  let endPicker = flatpickr("#date-to", {
    dateFormat: "Y-m-d",
    locale: "ru",
    // для интервала дат
    onChange: function (selectedDates) {
      startPicker.set("maxDate", selectedDates[0]);
    },
  });
});

(function ($) {
  function setChecked(target) {
    var checked = $(target).find("input[type='checkbox']:checked").length;
    if (checked) {
      $(target)
        .find("select option:first")
        .html("Выбрано: " + checked);
    } else {
      $(target).find("select option:first").html("Выберите из списка");
    }
  }

  $.fn.checkselect = function () {
    this.wrapInner('<div class="checkselect-popup"></div>');
    this.prepend(
      '<div class="checkselect-control">' +
        '<select class="form-control"><option></option></select>' +
        '<div class="checkselect-over"></div>' +
        "</div>"
    );

    this.each(function () {
      setChecked(this);
    });
    this.find('input[type="checkbox"]').click(function () {
      setChecked($(this).parents(".checkselect"));
    });

    this.parent()
      .find(".checkselect-control")
      .on("click", function () {
        $popup = $(this).next();
        $(".checkselect-popup").not($popup).css("display", "none");
        if ($popup.is(":hidden")) {
          $popup.css("display", "block");
          $(this).find("select").focus();
        } else {
          $popup.css("display", "none");
        }
      });

    $("html, body").on("click", function (e) {
      if ($(e.target).closest(".checkselect").length == 0) {
        $(".checkselect-popup").css("display", "none");
      }
    });
  };
})(jQuery);

$(".checkselect").checkselect();
