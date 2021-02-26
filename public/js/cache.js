toastr.options = { //setting up popup
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "2500",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function clearCache(i) {
    let action = $(i).attr('id');
    let route = '/dashboard/artisan/' + action;

    $.ajax({
        type: 'GET',
        url: route,
        success: function (result) {
            answer = result;
            toastr.success('Успех: ' + answer);
        }
    });
}
