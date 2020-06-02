function postAction(action, element, dependentOf = false) {
	let post 		=	element.parentElement.parentElement.parentElement.parentElement;	
	let csrfToken 	=	document.querySelector('meta[name="csrf-token"]')['content'];

	if(element.getAttribute("data-state") === "1")
		action = "nullify";

	$.ajax({
		url: "/site/post?action=" + action,
		data: {
			_csrf 	: 	csrfToken,
			id		:	post.getAttribute("data-id"),
		},
		method: "POST",
		success: data => {
			if(data) {
				let dependentEl 		= 	element.parentElement.querySelector(`${dependentOf}`);
				let dependentIsActive 	= 	Number(dependentEl.getAttribute("data-state"));			
				
				let likesSection 	= 	post.querySelector(".likes-section");
				let captureGroups 	= 	likesSection.innerText.match(/(\d)(.*)/);
				
				let likes			=	Number(captureGroups[1]);

				dependentIsActive ? (action == "like" ? likes+= 2 : likes-= 2) : (action == "like" ? likes++ : likes--);
				
				iconPressed(element, dependentOf);

				likesSection.innerText	= 	likes + captureGroups[2]; 
			}
		}
	});
}

function comentar(event, form) {	
	event.preventDefault();
	event.stopPropagation();

	if(form.reportValidity()) {	
		
		let dataEl = new FormData();
		
		let csrfToken 	= 	document.querySelector('meta[name="csrf-token"]')['content'];
		let post		=	form.parentElement.parentElement.parentElement.parentElement;

		let t = form.querySelector("#comentario-texto");
		let m = form.querySelector("#comentario-media");
		
		dataEl.append("id", post.getAttribute("data-id"));
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
			success 	: 	data => {
				if (data) {					
					let mensaje = '<div class="ui attached positive icon message"><i class="heart icon"></i><div class="content"><div class="header"><p>Has comentado esta publicación!</p></div></div></div>';

					form.reset();

					let card = form.parentNode.parentNode.parentNode;
					let template = document.createElement("template");
					
					template.innerHTML = mensaje;
				
					let mensajeEl = card.appendChild(template.content.firstChild);

					setTimeout( () => $(mensajeEl).transition('fade'), 5000);
				}	
			},
		});
	}

	return false;
}