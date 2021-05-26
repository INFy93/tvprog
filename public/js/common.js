$(document).ready(function () { //setting up mixit
    $.ajaxSetup({ //setting AJAX
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $('.no_favour').hide();

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
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
      });
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

$(document.body).on('click', '.favour_switch', favourSwitch);
function favourSwitch()
{
  //$(this).parent().attr('data-filter')
  if($(this).attr('data-prefix') == 'far')
  {
      $(this).attr('data-prefix', 'fas');
      $(this).parent().attr('data-filter', '.all');
      $(this).parent().attr('data-original-title', 'Все телеканалы').tooltip('show');
  } else if ($(this).attr('data-prefix') == 'fas')
  {
    $(this).attr('data-prefix', 'far');
    $(this).parent().attr('data-filter', '.favour');
    $(this).parent().attr('data-original-title', 'Избранное').tooltip('show');
    $('#all')[0].click();
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
        $('.current').css('color', 'black');
        $('.current a').css('color', 'black');
        $('.current a').css('font-weight', 'normal');
    } else if ($(this).attr('data-prefix') == 'fad') {
        $(this).attr('data-prefix', 'fas');
        $(this).parent().attr('data-original-title', 'Текущие передачи').tooltip('show');
        $('.before').show();
        $('.after').show();
        $('.current').css('color', '#0066ff');
        $('.current a').css('color', '#0066ff');
        $('.current a').css('font-weight', 'bold');
    }
}
$(document.body).on('click', '.switch_dark', onlyCurrentDark);
function onlyCurrentDark() { //showing only current TV-programs on clicking by checkbox
    if ($(this).attr('data-prefix') == 'fas') {
        $(this).attr('data-prefix', 'fad');
        $(this).parent().attr('data-original-title', 'Все передачи').tooltip('show');
        $('.before').hide();
        $('.after').hide();
        $('current').after('channel_title');
        $('.current').css('color', '#fefefe');
        $('.current a').css('color', '#fefefe');
        $('.current a').css('font-weight', 'normal');
    } else if ($(this).attr('data-prefix') == 'fad') {
        $(this).attr('data-prefix', 'fas');
        $(this).parent().attr('data-original-title', 'Текущие передачи').tooltip('show');
        $('.before').show();
        $('.after').show();
        $('.current').css('color', '#fefefe');
        $('.current a').css('color', '#fefefe');
        $('.current a').css('font-weight', 'bold');
    }
}
$('.favour_link').on('click', favour)
function favour() { //adding to favour

    let getvalue = $(this).attr('id'); //getting channel ID
    let name = $(this).attr('name'); //channel name for popup
    let div = $("#" + getvalue).parents('.mix')[0]; //getting name of 'channel'-div

    if ($(this).hasClass('add_favour')) {//if channel isn't in favour list
        $.ajax({
            type: "GET", //data type
            url: "/cookie/set/" + getvalue, //route for cookie controller
        }).done(function (html) { //if success
            $("#" + getvalue).removeClass("add_favour"); //remove class
            $("#" + getvalue).addClass("delete_favour"); //adding class
            $(".img_id" + getvalue).attr("src", "/storage/images/favour_active.png"); //changing picture
            $(div).removeClass("genreNum" + getvalue); //removing old sort class
            $(div).addClass("favour"); //adding new sort class
            toastr.success('Телеканал "' + name + '" успешно добавлен в избранное!'); //popup success
        }).fail(function (html) {
            toastr.error('Произошла ошибка, попробуйте позже.') //popup error
        });
    }
    else if ($(this).hasClass('delete_favour')) { //if channel is in favour list
        $.ajax({
            type: "GET", //data type
            url: "/cookie/delete/" + getvalue, //route for deleting channel from cookie
        }).done(function (html) {
            $("#" + getvalue).removeClass("delete_favour"); //deleting old class
            $("#" + getvalue).addClass("add_favour"); //adding new class
            $(".img_id" + getvalue).attr("src", "/storage/images/favour_ready.png"); //changing image
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
