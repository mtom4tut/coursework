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
});
