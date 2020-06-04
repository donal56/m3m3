/** Validación **/

$.fn.form.settings.prompt = {
    correo      :   "Ingrese un correo electrónico válido.",
    contraseña  :   "La contraseña debe contener entre 8 y 32 caráteres. Mínimo un número, una mayúscula y una minúscula.",
    nombre      :   "Ingrese su nombre completo.",
    usuario     :   "El usuario debe contener entre 5 y 25 caráteres alfanuméricos.",
    avatar      :   "Seleccione una foto de perfil.",
    coincidirContraseña     :   "Las contraseñas deben coincidir.",
    postTitle   :   "Agregue un titulo para su publicación.",
    media       :   "Seleccione una imagen o video para su publicación.",
    etiquetas   :   "Seleccione de 1 a 5 etiquetas.",
    nombreEtiqueta      :   "Etiqueta requerida. Máximo 100 carácteres.",
    iconoEtiqueta       :   "Agregue un icono de la libreria Semantic UI.",
}

$.prototype.form.settings.text = {
    unspecifiedField    :   'Este campo',
    unspecifiedRule     :   'Este campo es requerido.',
}



//return $.fn.form.settings.rules.regExp(value, /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}/);
$.fn.form.settings.rules.contraseña = value => $.fn.form.settings.rules.regExp(value, /^\S*(?=\S{8,32})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/);

$.fn.form.settings.rules.correo = value => $.fn.form.settings.rules.empty(value) && $.fn.form.settings.rules.email(value);

$.fn.form.settings.rules.nombre = value => $.fn.form.settings.rules.regExp(value, /[a-zA-Z]{1,45}/);

$.fn.form.settings.rules.usuario = value => $.fn.form.settings.rules.regExp(value, /^(\w|\d){5,25}$/);

$.fn.form.settings.rules.avatar = value => $.fn.form.settings.rules.empty(value);

$.fn.form.settings.rules.coincidirContraseña = (value, identifier) => $.fn.form.settings.rules.match(value, identifier);

$.fn.form.settings.rules.postTitle = value => $.fn.form.settings.rules.empty(value) && $.fn.form.settings.rules.maxLength(value, 255);

$.fn.form.settings.rules.media = value => $.fn.form.settings.rules.empty(value);

$.fn.form.settings.rules.etiquetas = value => $.fn.form.settings.rules.minCount(value, 1) && $.fn.form.settings.rules.maxCount(value, 5);

$.fn.form.settings.rules.nombreEtiqueta = value => $.fn.form.settings.rules.empty(value) && $.fn.form.settings.rules.maxLength(value, 100);

$.fn.form.settings.rules.iconoEtiqueta = value => $.fn.form.settings.rules.empty(value);



$.fn.form.settings.defaults = {
    email : {
        identifier  :   'loginform-email',
        rules       :   [ {  type   : 'correo' } ],
    },
    password : {
        identifier  :   'loginform-password',
        rules       :   [ {  type   : 'contraseña' } ],
    },


    nombre : {
        identifier  :   'registrationform-nombre',
        rules       :   [ {  type   : 'nombre' } ],
    },
    email2 : {
        identifier  :   'registrationform-email',
        rules       :   [ {  type   : 'correo' } ],
    },
    username : {
        identifier  :   'registrationform-username',
        rules       :   [ {  type   : 'usuario' } ],
    },
    avatar : {             
        identifier  :   'registrationform-avatar',
        rules       :   [ {  type   : 'avatar' } ],
    },
    password2 : {
        identifier  :   'registrationform-password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    repeatPassword : {
        identifier  :   'registrationform-repeat_password',
        rules       :   [ {  type   : 'coincidirContraseña[registrationform-password]' } ],
    },

    
    
    current_password : {
        identifier  :   'changeownpasswordform-current_password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    password3 : {
        identifier  :   'changeownpasswordform-password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    repeatPassword2 : {
        identifier  :   'changeownpasswordform-repeat_password',
        rules       :   [ {  type   : 'coincidirContraseña[changeownpasswordform-password]' } ],
    },


    titulo : {
        identifier  :   'publicacion-titulo',
        rules       :   [ {  type   : 'postTitle' } ],
    },
    media : {
        identifier  :   'publicacion-media',
        rules       :   [ {  type   : 'media' } ],
    },
    etiquetas : {
        identifier  :   'publicacion-relpublicacionetiquetas',
        rules       :   [ {  type   : 'etiquetas' } ],
    },
    
    
    nombreEtiqueta: {
        identifier  :   'etiqueta-nombre',
        rules       :   [ {  type   : 'nombreEtiqueta' } ],
    },
    iconoEtiqueta: {
        identifier  :   'etiqueta-icon',
        rules       :   [ {  type   : 'iconoEtiqueta' } ],
    },
    
};



/* Funciones */

function iconPressed(component, dependentOf = false, activeColor = "BLACK", inactiveColor = "WHITE") {
	
	let active = Number(component.getAttribute("data-state"));

	if(active) {
		component.children[0].style.color = inactiveColor;
		component.setAttribute("data-state","0");
	} else {
		component.children[0].style.color = activeColor;
		component.setAttribute("data-state","1");
		
		if(dependentOf) {
			let dependentEl = component.parentElement.querySelector(`${dependentOf}`);
			let dependentIsActive = Number(dependentEl.getAttribute("data-state"));
			
			if(dependentIsActive) {
				dependentEl.children[0].style.color = inactiveColor;
				dependentEl.setAttribute("data-state","0");
			}	
		}
	}
}

function accesoDenegado() {
    let html = '<div class="ui warning floating toast message"><i class="close icon"></i><div class="header">Acceso denegado!</div>Registrate ahora mismo para esta función y muchas más!</div>';

    let template = document.createElement("template");
    
    template.innerHTML = html;

    let mensajeEl = document.querySelector("body").appendChild(template.content.firstChild);

    setTimeout( () => $(mensajeEl).transition('fade'), 5000);
}


/* Init UI components */

$('.ui.dropdown').dropdown();
$('.menu .item').tab();