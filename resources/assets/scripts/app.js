require('./bootstrap');

$(document).ready(function() {

    // Добавление необходимых заголовков для выполнения запросов AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Инициализация модуля "Inputmask"
    $(":input.input-mask").inputmask();
    $(":input.input-mask-phone").inputmask('+7 (999) 999-99-99');

    // Инициализация модуля "Popover"
    $('[data-toggle="popover"]').popover();

});
