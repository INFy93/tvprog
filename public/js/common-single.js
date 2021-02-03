$(document).ready(function () { //setting up mixit
    $.ajaxSetup({ //setting AJAX
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    toastr.options = { //setting up popup of adding/deleting to/from favour channels list
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
    $('[data-toggle="tooltip"]').tooltip(); //enable tooltip

    var btn = $('#button'); //"Up" button settings
    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });
    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '300');
    });

});

function description(i) { //showing description of TV-program
    var d_id = $(i).attr('id'); //takin' TV-program ID
    var route = '/descr/' + d_id; //preparing route
    $.ajax({
        type: 'GET',
        url: route,
        dataType: "json",
        data: { id: d_id },
        success: function (result) {
            if ($("#screen").length) { //if we have the "screen"-picture after current-popup, we will delete it
                $("#screen").remove();
            }
            $('#basicModal .modal-title').html(moment(result.time).format('HH:mm') + " - " + moment(result.time_to).format('HH:mm') + " " + result.name); //displaying time and time to
            $('#basicModal div.modal-body').html(result.descr) //description
        }
    });
}

function descriptionCurrent(i) { //showing description of TV-program
    var d_id = $(i).attr('id'); //takin' TV-program ID
    var route = '/descr/current/' + d_id; //preparing route
    var timestamp = new Date().getTime();
    $.ajax({
        type: 'GET',
        url: route,
        dataType: "json",
        data: { id: d_id },
        success: function (result) {
            $('#basicModal .modal-title').html(moment(result.time).format('HH:mm') + " - " + moment(result.time_to).format('HH:mm') + " " + result.name); //displaying time and time to
            $('#basicModal div.modal-body').html('<img style="padding-right: 10px;" src="https://hosting.crimeastar.net/cgi-bin/channel_screenshot.cgi?' + result.number + '&timestamp=' + timestamp + '" align="left" id="screen">') //description
            $('#basicModal div.modal-body').append(result.descr) //description


        }
    });
}
