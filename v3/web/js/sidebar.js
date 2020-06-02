/* Variables */

let mediaQuery 	= 	window.matchMedia("(max-width: 767px)");
let tipos 		= 	document.querySelectorAll("navbar ul li, #sidebar a.item.type");
let tags		=	document.querySelectorAll("#sidebar a.item:not(.title):not(.type):not(.upload-post)");

window.page = 1;

const SIDEBAR_CONF = {
	closable	 	 : false,
	dimPage          : false,
	transition       : 'overlay',
	mobileTransition : 'overlay'
};


/* Eventos */

$("#sidebar a.item:not(.title):not(.type):not(.upload-post)").on("click", function() {
	tags.forEach( i => i.classList.remove("selected") );

	this.classList.add("selected");

	recargarPosts();
});

$("navbar ul li, #sidebar a.item.type").on("click", function() {	
	let type = this.getAttribute("data-type");
	
	tipos.forEach( i => i.classList.remove("selected") );
	
	document.querySelectorAll(`navbar ul li[data-type=${type}]`)[0].classList.add("selected");
	document.querySelectorAll(`#sidebar a.item.type[data-type=${type}]`)[0].classList.add("selected");

	recargarPosts();
});

$("#toogle-sidebar").on("click", function() {
	configureSidebar("show", false);
});


/* Métodos */

function recargarPosts(tag, type) {
	window.page = 1;

	$("main article").remove();
	
	feed();
}

function configureSidebar(defaultBehaviour1 = "show", defaultBehaviour2 = 'hide') {

	if(typeof defaultBehaviour1 == "object")
		defaultBehaviour1 = "show";
	
	if (mediaQuery.matches)
		$('#sidebar')
			.sidebar(SIDEBAR_CONF)
			.sidebar('setting', 'closable', true)
			.sidebar(defaultBehaviour2 || 'toggle');
	else
		$('#sidebar')
			.sidebar(SIDEBAR_CONF)
			.sidebar(defaultBehaviour1);
}

function feed() {

	let tipo        = 	document.querySelector("navbar ul li, #sidebar a.item.type.selected");
	let etiqueta	=	document.querySelector("#sidebar a.item.selected:not(.title):not(.type)");
	let csrfToken 	= 	document.querySelector('meta[name="csrf-token"]')['content'];

	$.ajax({
		url: "/site/feed",
		data: {
			page	: 	window.page++,
			type	: 	tipo.getAttribute("data-type") || null,
			tag		: 	etiqueta.getAttribute("data-tag") || null,
			_csrf 	: 	csrfToken,
		},
		method: "POST",
		success: data => $("main").append(data).children().fadeIn(600)
	});
}
  

/*onLoad() */
mediaQuery.addListener(configureSidebar);

configureSidebar();