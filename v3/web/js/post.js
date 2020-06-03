function postAction(action, element, dependentOf = false, comment = null) {
	let post 		=	comment || element.parentElement.parentElement.parentElement.parentElement;	
	let csrfToken 	=	document.querySelector('meta[name="csrf-token"]')['content'];

	if(element.getAttribute("data-state") === "1")
		action = "nullify";

	$.ajax({
		url		: "/site/" + (comment ? "comment" : "post") + "?action=" + action,
		data	: {
			_csrf 	: 	csrfToken,
			id		:	(comment ? post : post.getAttribute("data-id")),
		},
		method	: "POST",
		error	:	accesoDenegado,
		success	: data => {
			if(data) {
				let dependentEl 		= 	element.parentElement.querySelector(`${dependentOf}`);
				let dependentIsActive 	= 	Number(dependentEl.getAttribute("data-state"));			
				
				let likesSection 	= 	(comment ? element.parentElement.parentElement : post).querySelector(".likes-section");
				let captureGroups 	= 	likesSection.innerText.match(/(\d)(.*)/);
				
				let likes			=	Number(captureGroups[1]);

				dependentIsActive ? (action == "like" ? likes+= 2 : likes-= 2) : (action == "like" ? likes++ : likes--);
				
				iconPressed(element, dependentOf, "BLACK", "rgba(0,0,0,.4)");

				likesSection.innerText	= 	likes + captureGroups[2]; 
			}
		}
	});
}

//Si se sabe el ID entonces estamos en una pagina exclusiva de la publicacion
function comentar(event, form, id) {	
	event.preventDefault();
	event.stopPropagation();

	if(form.reportValidity()) {	
		
		let dataEl = new FormData();
		
		let csrfToken 	= 	document.querySelector('meta[name="csrf-token"]')['content'];
		let post		=	id || form.parentElement.parentElement.parentElement.parentElement;

		let t = form.querySelector("#comentario-texto");
		let m = form.querySelector("#comentario-media");
		
		dataEl.append("id", id ? post : post.getAttribute("data-id"));
		dataEl.append(t.name, t.value);
		dataEl.append(m.name, m.value);
		dataEl.append(m.name, m.files[0]);
		dataEl.append("_csrf", csrfToken);
					
		$.ajax({
			url 		: 	form.action,
			method 		: 	form.method,
			data 		: 	dataEl,
			cache       :   false,
			processData :   false,
			contentType :   false,
			error		:	accesoDenegado,
			success 	: 	data => {
				if (data) {					
					form.reset();

					let commentsSection 	= 	(id ? document : post).querySelector(".comments-section");
					let captureGroups 		= 	commentsSection.innerText.match(/(\d)(.*)/);
					let comments			=	Number(captureGroups[1]);

					commentsSection.innerText	= 	(comments + 1) + captureGroups[2]; 

					if(!id) {
						let mensaje = '<div class="ui attached positive icon message"><i class="heart icon"></i><div class="content"><div class="header"><p>Has comentado esta publicación!</p></div></div></div>';
	
						let card = form.parentNode.parentNode.parentNode;
						let template = document.createElement("template");
						
						template.innerHTML = mensaje;
					
						let mensajeEl = card.appendChild(template.content.firstChild);
	
						setTimeout( () => $(mensajeEl).transition('fade'), 5000);
					} else {
						loadComments(id);
					}
				}	
			},
		});
	}

	return false;
}

function loadComments(url) {

	let csrfToken 	= 	document.querySelector('meta[name="csrf-token"]')['content'];

	$.ajax({
		url: "/site/comments?p=" + url,
		data: {
			_csrf 	: 	csrfToken,
		},
		method: "POST",
		success: data => {
			$(".ui.comments").children().fadeOut(600).remove();
			$(".ui.comments").append(data).children().fadeIn(600);
		}
	});
}