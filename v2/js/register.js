$("#w0").form({
	onSuccess: function(event, fields) {
		event.preventDefault();
		event.stopPropagation();

		//Ajax call
		let progressBar = $('#w0 .hidden.progress');

		progressBar.progress({
			total    : 100,
			text     : {
				active: 'Creando cuenta {value}%',
				success: 'Cuenta creada!'
			},
			onSuccess: () => {
				window.location= "index.html";
				localStorage.setItem("logged","1");
			}
		});
		
		progressBar.removeClass("hidden");
		window.fakeProgress = setInterval(x => progressBar.progress('increment'), 20);
	}
});
