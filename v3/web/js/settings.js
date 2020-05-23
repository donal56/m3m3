$("#w0").form({
	onSuccess: (e,f) =>  {
		event.preventDefault();
		event.stopPropagation();
	
		let progressBar = $("#SELECTOR" + ' .hidden.progress');
		
		//Ajax call
		window.fakeProgress = setInterval(x => progressBar.progress('increment'), 20);
		
	
		progressBar.progress({
			total    : 100,
			text     : {
				active: 'Guardando cambios {value}%',
				success: 'Datos guardados!'
			},
			onSuccess: () => {}
		});
		
		progressBar.removeClass("hidden");
	}
});

