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
    email : {
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
    password : {
        identifier  :   'registrationform-password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    repeatPassword : {
        identifier  :   'registrationform-repeat_password',
        rules       :   [ {  type   : 'coincidirContraseña[registrationform-password]' } ],
    },


    username : {
        identifier  :   'usuario-username',
        rules       :   [ {  type   : 'usuario' } ],
    },
    email : {
        identifier  :   'usuario-email',
        rules       :   [ {  type   : 'correo' } ],
    },

    
    current_password : {
        identifier  :   'changeownpasswordform-current_password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    password : {
        identifier  :   'changeownpasswordform-password',
        rules       :   [ {  type   : 'contraseña' } ],
    },
    repeatPassword : {
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
    
};
