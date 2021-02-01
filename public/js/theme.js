var btn = document.getElementById("theme-button");
var link = document.getElementById("theme-link");
var panel = document.getElementById("left-panel");
var current = document.getElementById("onlyCurrent");

btn.addEventListener("click", function () { ChangeTheme(); });

function ChangeTheme()
{
    let lightTheme = "/css/app.css";
    let darkTheme = "/css/dark.css";

    var currTheme = link.getAttribute("href");
    var theme = "";

    if(currTheme == lightTheme)
    {
   	 currTheme = darkTheme;
        theme = "dark";
        panel.classList.remove("bg-light");
        panel.classList.add("bg-dark");
        btn.textContent="Светлая тема";
        btn.classList.remove("btn-dark");
        btn.classList.add("btn-secondary");
        current.setAttribute('onclick', 'onlyCurrentDark(this)');
        if (current.checked) {
            $('.current').css('color', '#fefefe');
		    $('.current a').css('color', '#fefefe');
        }
        toastr.warning('Выбрана темная тема');
    }
    else
    {
   	 currTheme = lightTheme;
        theme = "app";
        panel.classList.remove("bg-dark");
        panel.classList.add("bg-light");
        btn.textContent="Темная тема";
        btn.classList.remove("btn-secondary");
        btn.classList.add("btn-dark");
        current.setAttribute('onclick', 'onlyCurrent(this)');
        if (current.checked) {
            $('.current').css('color', 'black');
		    $('.current a').css('color', 'black');
        }
        toastr.warning('Выбрана светлая тема');
    }

    link.setAttribute("href", currTheme);

    Save(theme);
}

function Save(theme)
{
    var Request = new XMLHttpRequest();
    Request.open("GET", "/theme/" + theme, true);
    Request.send();
}
