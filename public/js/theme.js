var btn = document.getElementById("theme-button");
var link = document.getElementById("theme-link");
var panel = document.getElementById("left-panel");
var current = document.getElementById("onlyCurrent");

$(document.body).on('click', '#theme-button', ChangeTheme);

function ChangeTheme() {
    let lightTheme = "/css/app.css";
    let darkTheme = "/css/dark.css";

    var currTheme = link.getAttribute("href");
    var theme = "";

    if (currTheme == lightTheme) {
        currTheme = darkTheme;
        theme = "dark";

        panel.classList.remove("bg-light");
        panel.classList.add("bg-dark");

        $(this).attr("data-icon", 'sun');

        $(this).parent().attr('data-original-title', 'Светлая тема').tooltip('show');

        if ($(current).attr('data-prefix') == 'fad') {
            $('.current').css('color', '#fefefe');
            $('.current a').css('color', '#fefefe');
        }
    }
    else {
        currTheme = lightTheme;
        theme = "app";
        panel.classList.remove("bg-dark");
        panel.classList.add("bg-light");

        $(this).parent().attr('data-original-title', 'Темная тема').tooltip('show');

        $(this).attr("data-icon", 'moon');

        if ($(current).attr('data-prefix') == 'fad') {
            $('.current').css('color', 'black');
            $('.current a').css('color', 'black');
        }
    }

    link.setAttribute("href", currTheme);

    Save(theme);
}

function Save(theme) {
    var Request = new XMLHttpRequest();
    Request.open("GET", "/theme/" + theme, true);
    Request.send();
}
