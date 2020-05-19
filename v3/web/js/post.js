function iconPressed(component, dependentOf = false) {
	const ACTIVE_COLOR 		= 	"black";
	const INACTIVE_COLOR 	= 	"white";
	
	let active = Number(component.getAttribute("data-state"));

	if(active) {
		component.children[0].style.color = INACTIVE_COLOR;
		component.setAttribute("data-state","0");
	} else {
		component.children[0].style.color = ACTIVE_COLOR;
		component.setAttribute("data-state","1");
		
		if(dependentOf) {
			let dependentEl = component.parentElement.querySelector(`${dependentOf}`);
			let dependentIsActive = Number(dependentEl.getAttribute("data-state"));
			
			if(dependentIsActive) {
				dependentEl.children[0].style.color = INACTIVE_COLOR;
				dependentEl.setAttribute("data-state","0");
			}	
		}
	}
}

function comentar(event, form) {	
	event.preventDefault();
	event.stopPropagation();
	
	let mensaje = '<div class="ui attached positive icon message"><i class="heart icon"></i><div class="content"><div class="header"><p>Has comentado esta publicación!</p></div></div></div>';
	
	setTimeout(() => {
		form.reset();

		let card = form.parentNode.parentNode.parentNode;
		let template = document.createElement("template");
		
		template.innerHTML = mensaje;
	
		let mensajeEl = card.appendChild(template.content.firstChild);

		setTimeout( () => $(mensajeEl).transition('fade'), 5000);
	}, 1000);

	return false;
}