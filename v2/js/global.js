if(Number(localStorage.getItem("logged")))
    document.querySelector("#settings").style.display = "block";
else
    document.querySelector("#login").style.display = "block";

$('.ui.dropdown').dropdown();
$('.menu .item').tab();