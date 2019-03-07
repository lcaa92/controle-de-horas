import flatpickr from "flatpickr";

$(document).ready(function(){
    flatpickr(".datetime", {
        enableTime: true,
        altFormat: "d/m/Y H:i",
        dateFormat: "Y-m-d H:i:00",
        time_24hr: true
    });
})