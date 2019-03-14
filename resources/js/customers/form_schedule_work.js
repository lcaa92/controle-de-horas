import flatpickr from "flatpickr";

$(document).ready(function(){
    flatpickr(".datetime", {
        enableTime: true,
        altInput: true,
        altFormat: "d/m/Y H:i",
        dateFormat: "Y-m-d H:i:00",
        time_24hr: true
    });

    flatpickr(".date", {
        enableTime: false,
        altInput: true,
        altFormat: "d/m/Y",
        dateFormat: "Y-m-d",
        time_24hr: true
    });

    flatpickr(".time", {
        enableTime: true,
        dateFormat: "H:i",
        time_24hr: true,
        noCalendar: true,
    });
})