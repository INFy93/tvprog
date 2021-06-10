$(document).ready(function () { //setting up mixit
    $.ajaxSetup({ //setting AJAX
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $('.no_favour').hide();
    if ($('body.main_page').length) { //mixit only on main page

        mixitup('.channels', {
            selectors: {
                control: '[data-mixitup-control]'
            },
            // callbacks onMixEnd
            callbacks: {
                onMixEnd: function (state) {
                    // hasFailed true? show alert
                    if (state.hasFailed) {
                        $('.no_favour').show();
                    }
                    // hasFailed false? hide alert
                    else {
                        $('.no_favour').hide();
                    }
                },

            }, //end of callback
        });
    }
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

    let btn = $('#button'); //"Up" button settings
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

    $('[data-toggle="tooltip"]').tooltip({ //tooltips
        trigger: 'hover'
    });
    $('[rel="tooltip"]').on('click', function () {
        $(this).tooltip('hide')
    })
});
$('.navbar-collapse').on('click', 'a', function (e) {
    $(e.delegateTarget).collapse('toggle');
});
$('.description_before, .description_after').on('click', description);
function description() { //showing description of TV-program
    let d_id = $(this).attr('id'); //takin' TV-program ID
    let route = '/descr/' + d_id; //preparing route
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
$('.current_link, .rank_link, .read_more').on('click', descriptionCurrent);
function descriptionCurrent() { //showing description of TV-program
    let d_id = $(this).attr('id'); //takin' TV-program ID
    let route = '/descr/current/' + d_id; //preparing route
    let timestamp = new Date().getTime();
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

$(document.body).on('click', '.favour_switch', favourSwitch); //favour star function
function favourSwitch() {
    if ($(this).attr('data-prefix') == 'far') {
        $(this).attr('data-prefix', 'fas');
        $(this).parent().attr('data-filter', '.all');
        $(this).parent().attr('data-original-title', 'Все телеканалы').tooltip('show');
    } else if ($(this).attr('data-prefix') == 'fas') {
        $(this).attr('data-prefix', 'far');
        $(this).parent().attr('data-filter', '.favour');
        $(this).parent().attr('data-original-title', 'Избранное').tooltip('show');
        $('#all')[0].click();
    }
}
$(document.body).on('click', '.nav-link', noFavour); //clicking on category link will clear favour icon (if it is pressed)
function noFavour()
{
    if($('.favour_switch').attr('data-prefix') == 'fas')
    {
        $('.favour_switch').attr('data-prefix', 'far');
        $('.favour_switch').parent().attr('data-filter', '.favour');
        $('.favour_switch').parent().attr('data-original-title', 'Избранное');
    }

}
$(document.body).on('click', '.switch', onlyCurrent);
function onlyCurrent() { //showing only current TV-programs on clicking by checkbox
    if ($(this).attr('data-prefix') == 'fas') {
        $(this).attr('data-prefix', 'fad');
        $(this).parent().attr('data-original-title', 'Все передачи').tooltip('show');
        $('.before').hide();
        $('.after').hide();
        $('current').after('channel_title');
        if ($('#theme-button').attr('data-icon') == 'moon') //light theme
            {
                $('.current').css('color', 'black');
                $('.current a').css('color', 'black');
                $('.current a').css('font-weight', 'normal');
            }
        else if ($('#theme-button').attr('data-icon') == 'sun') //dark theme
            {
                $('.current').css('color', '#fefefe');
                $('.current a').css('color', '#fefefe');
                $('.current a').css('font-weight', 'normal');
            }

    } else if ($(this).attr('data-prefix') == 'fad') {
        $(this).attr('data-prefix', 'fas');
        $(this).parent().attr('data-original-title', 'Текущие передачи').tooltip('show');
        $('.before').show();
        $('.after').show();
        if ($('#theme-button').attr('data-icon') == 'moon') //light theme
        {
            $('.current').css('color', '#0066ff');
            $('.current a').css('color', '#0066ff');
            $('.current a').css('font-weight', 'bold');
        } else if ($('#theme-button').attr('data-icon') == 'sun') //dark theme
        {
            $('.current').css('color', '#fefefe');
            $('.current a').css('color', '#fefefe');
            $('.current a').css('font-weight', 'bold');
        }
    }
}
$(document.body).on('click', '.favour_star', favour);
function favour() { //adding to favour
    const that = this; //const to changing icon
    let getvalue = $(this).parent().attr('id'); //getting channel ID
    let name = $(this).parent().attr('name'); //channel name for popup
    let div = $("#" + getvalue).parents('.mix')[0]; //getting name of 'channel'-div

    if ($(this).attr('data-prefix') == 'far') {//if channel isn't in favour list
        $.ajax({
            type: "GET", //data type
            url: "/cookie/set/" + getvalue, //route for cookie controller
        }).done(function (html) { //if success
            $(that).attr('data-prefix', 'fas'); //change icon
            $(that).parent().attr('data-original-title', 'Убрать из Избранного').tooltip('show'); //update popup
            $(div).addClass("favour"); //adding new sort class
            toastr.success('Телеканал "' + name + '" успешно добавлен в избранное!'); //popup success
        }).fail(function (html) {
            toastr.error('Произошла ошибка, попробуйте позже.') //popup error
        });
    }
    else if ($(this).attr('data-prefix') == 'fas') { //if channel is in favour list
        $.ajax({
            type: "GET", //data type
            url: "/cookie/delete/" + getvalue, //route for deleting channel from cookie
        }).done(function (html) {
            $(that).attr('data-prefix', 'far'); //change icon
            $(that).parent().attr('data-original-title', 'Добавить в Избранное').tooltip('show'); //update popup
            $(div).removeClass("favour"); //deleting favour class
            if ($("#fav").hasClass("mixitup-control-active")) { //updating favour section view
                $('#fav')[0].click();
            }
            toastr.error('Телеканал "' + name + '" удален из избранного!') //popup success
        }).fail(function (html) {
            toastr.error('Произошла ошибка, попробуйте позже.') //popup error
        });
    }

}
