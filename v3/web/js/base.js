/** Validación **/

$.fn.form.settings.prompt = {
    correo      :   "Ingrese un correo electrónico válido.",
    contraseña  :   "La contraseña debe contener entre 8 y 32 caráteres. Mínimo un número, una mayúscula y una minúscula.",
    nombre      :   "Ingrese su nombre completo.",
    usuario     :   "El usuario debe contener entre 5 y 25 caráteres alfanuméricos.",
    avatar      :   "Seleccione una foto de perfil.",
    coincidirContraseña     :   "Las contraseñas deben coincidir.",
    fechaNacimiento     :   "Ingrese su fecha de nacimiento.",
    sexo        :   "Especifique su sexo.",
}



$.prototype.form.settings.text = {
    unspecifiedField    :   'Este campo',
    unspecifiedRule     :   'Este campo es requerido.',
}



$.fn.form.settings.rules.contraseña = function (value) {
    //return $.fn.form.settings.rules.regExp(value, /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}/);
    return $.fn.form.settings.rules.regExp(value, /^\S*(?=\S{8,32})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/);
}

$.fn.form.settings.rules.correo = function(value) {
    return $.fn.form.settings.rules.empty(value) && $.fn.form.settings.rules.email(value);
};

$.fn.form.settings.rules.nombre = function(value) {
    return $.fn.form.settings.rules.regExp(value, /[a-zA-Z]{1,45}/);
};

$.fn.form.settings.rules.usuario = function(value) {
    return $.fn.form.settings.rules.regExp(value, /^(\w|\d){5,25}$/);
};

$.fn.form.settings.rules.avatar = function(value) {
    return $.fn.form.settings.rules.empty(value);
};

$.fn.form.settings.rules.coincidirContraseña = function(value, identifier) {
    return $.fn.form.settings.rules.match(value, identifier);
};

$.fn.form.settings.rules.fechaNacimiento = function(value) {
    return $.fn.form.settings.rules.empty(value);
};

$.fn.form.settings.rules.sexo = function(value) {
    return $.fn.form.settings.rules.empty(value);
};



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

    // fechaNacimiento : {
    //     identifier  :   'RegistrationForm[fecha_nacimiento]',
    //     rules       :   [ {  type   : 'fechaNacimiento' } ],
    // },
    // sexo : {
    //     identifier  :   'RegistrationForm[sexo]',
    //     rules       :   [ {  type   : 'sexo' } ],
    // },  
};
