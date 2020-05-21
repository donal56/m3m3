$.fn.form.settings.prompt = {
    email  : 'Ingrese un correo electrónico válido.',
}

$.prototype.form.settings.text = {
    unspecifiedField    : 'Este campo',
    unspecifiedRule    : 'Este campo es requerido'
}

$.fn.form.settings.defaults = {
	username : {
		identifier: 'LoginForm[username]',
		rules: [
			{
				type: "empty",
				prompt: "Ingrese usuario"
			}, {
                type   : 'regExp',
                prompt : 'El usuario debe contener entre 5 y 25 caráteres alfanuméricos.',
                value  :  /[a-zA-Z\d]{5,25}/
            }
		]
	},
	avatar : {
		identifier: 'avatar',
		rules: [
			{
				type: "empty",
				prompt: "Seleccione una foto de perfil."
			}
		]
	},
    email : {
        identifier: 'LoginForm[email]',
        rules: [
            {
                type   : 'empty',
                prompt : 'Ingrese un correo.'
            }, {
                type   : 'email',
                prompt : 'Ingrese un correo electrónico válido.'
            }
        ]
    },
    password : {
        identifier: 'LoginForm[password]',
        rules: [
            {
                type   : 'empty',
                prompt : 'Ingrese contraseña.'
            }, {
                type   : 'regExp',
                prompt : 'La contraseña debe contener entre 8 y 32 caráteres. Mínimo un número, una mayúscula y una minúscula.',
                value  :  /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}/
            }
        ]
    },
	repeatPassword : {
        identifier: 'repeatPassword',
        rules: [
            {
                type   : 'match[password]',
                prompt : 'Las contraseñas deben coincidir.',
            }
        ]
    }
};
