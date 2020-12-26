$(document).ready(function() { //setting up mixit
    $('.no_favour').hide();

    mixitup('.channels', {
		selectors: {
				control: '[data-mixitup-control]'
        },
        // callbacks onMixEnd
        callbacks: {
            onMixEnd: function(state){
              // hasFailed true? show alert
              if(state.hasFailed){
                $('.no_favour').show();
              }
              // hasFailed false? hide alert
              else{
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
$('[data-toggle="tooltip"]').tooltip(); //enable tooltip

var btn = $('#button'); //"Up" button settings
  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
       btn.addClass('show');
     } else {
       btn.removeClass('show');
     }
   });
   btn.on('click', function(e) {
     e.preventDefault();
     $('html, body').animate({scrollTop:0}, '300');
   });

});

function description(i){ //showing description of TV-program
	var d_id = $(i).attr('id'); //takin' TV-program ID
	var route = '/descr/'+d_id; //preparing route
	$.ajaxSetup({ //setting AJAX
    headers: {
    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

		    $.ajax({
	        type : 'GET',
	        url : route,
					dataType: "json",
					data: {id: d_id},
	        success: function(result) {
             $('#basicModal .modal-title').html(moment(result.time).format('HH:mm') + " - "+ moment(result.time_to).format('HH:mm') + " " + result.name); //displaying time and time to
						 $('#basicModal div.modal-body').html(result.descr) //description
	        }
	    });
}
function onlyCurrent() { //showing only current TV-programs on clicking by checkbox
	if ($('#onlyCurrent').is(':checked')){
		$('.before').hide();
		$('.after').hide();
		$('current').after('channel_title');
		$('.current').css('color', 'black');
		$('.current a').css('color', 'black');
		$('.current a').css('font-weight', 'normal');
		toastr.warning('Режим просмотра текущих телепередач');
	} else {
		$('.before').show();
		$('.after').show();
		$('.current').css('color', '#0066ff');
		$('.current a').css('color', '#0066ff');
		$('.current a').css('font-weight', 'bold');
		toastr.warning('Режим просмотра всех телепередач');
	}
}

function favour(i){ //adding to favour

var getvalue = $(i).attr('id'); //getting channel ID
var name = $(i).attr('name'); //channel name for popup
var div = $("#"+getvalue).parents('.mix')[0]; //getting name of 'channel'-div

	if ($(i).hasClass('add_favour')) {//if channel isn't in favour list
						$.ajax({
						type: "GET", //data type
						url: "/cookie/set/"+getvalue, //route for cookie controller
					}).done(function(html) { //if success
							$("#"+getvalue).removeClass("add_favour"); //remove class
							$("#"+getvalue).addClass("delete_favour"); //adding class
							$(".img_id"+getvalue).attr("src","/storage/images/favour_active.png"); //changing picture
							$(div).removeClass("genreNum"+getvalue); //removing old sort class
							$(div).addClass("favour"); //adding new sort class
							toastr.success('Телеканал "'+name+'" успешно добавлен в избранное!'); //popup success
						}).fail(function(html) {
							 toastr.error('Произошла ошибка, попробуйте позже.') //popup error
						});
					}
		else if ($(i).hasClass('delete_favour')) { //if channel is in favour list
					$.ajax({
					type: "GET", //data type
					url: "/cookie/delete/"+getvalue, //route for deleting channel from cookie
				}).done(function(html) {
					$("#"+getvalue).removeClass("delete_favour"); //deleting old class
					$("#"+getvalue).addClass("add_favour"); //adding new class
					$(".img_id"+getvalue).attr("src","/storage/images/favour_ready.png"); //changing image
					$(div).removeClass("favour"); //deleting favour class
					if ($("#fav").hasClass("mixitup-control-active")) { //updating favour section view
							$('#fav')[0].click();
				}
					toastr.error('Телеканал "'+name+'" удален из избранного!') //popup success
			}).fail(function(html) {
				toastr.error('Произошла ошибка, попробуйте позже.') //popup error
			});
				}

}
