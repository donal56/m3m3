/* Variables */

let mediaQuery 	= 	window.matchMedia("(max-width: 767px)");
let tipos 		= 	document.querySelectorAll("navbar ul li, #sidebar a.item.type");
let tags		=	document.querySelectorAll("#sidebar a.item:not(.title):not(.type)")

const SIDEBAR_CONF = {
	closable	 	 : false,
	dimPage          : false,
	transition       : 'overlay',
	mobileTransition : 'overlay'
};

/* Eventos */

$("#sidebar a.item:not(.title):not(.type)").on("click", function() {
	let tag 	= this.getAttribute("data-tag");
	
	tags.forEach( i => i.classList.remove("selected") );
	this.classList.add("selected");

	recargarPosts(tag);
});

$("navbar ul li, #sidebar a.item.type").on("click", function() {
	let tag 	= document.querySelectorAll("#sidebar a.item.selected")[0].getAttribute("data-tag");
	let type 	= this.getAttribute("data-type");
	
	recargarPosts(tag, type);
});

$("#toogle-sidebar").on("click", function() {
	configureSidebar("show", false);
});

function recargarPosts(tag, type = "popular") {
	tipos.forEach( i => i.classList.remove("selected") );
	document.querySelectorAll(`navbar ul li[data-type=${type}]`)[0].classList.add("selected");
	document.querySelectorAll(`#sidebar a.item.type[data-type=${type}]`)[0].classList.add("selected");
	
	if(tag == "*") {
		$("main article").css("display", "none");
		$("main article").filter( (n, i) => i.getAttribute("data-types").includes(type)).css("display", "block");
	} else {
		$("main article").css("display", "none");
		$("main article").filter( (n, i) => i.getAttribute("data-tags").includes(tag) && i.getAttribute("data-types").includes(type)).css("display", "block");
	}
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
  
mediaQuery.addListener(configureSidebar);

/*onLoad() */
configureSidebar();
recargarPosts("*");