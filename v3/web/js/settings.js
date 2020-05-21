$("#w0").form({
	onSuccess: (e,f) => save(e,f, '#w0')
});

$("#w1").form({ 
	onSuccess: (e,f) => save(e,f, '#w1') 
});

$("#w2").form({
	onSuccess: (e,f) => save(e,f, '#w2')
});

function save(event, fields, formID) {
	event.preventDefault();
	event.stopPropagation();

	//Ajax call
	let progressBar = $(formID + ' .hidden.progress');

	progressBar.progress({
		total    : 100,
		text     : {
			active: 'Guardando cambios {value}%',
			success: 'Datos guardados!'
		},
		onSuccess: () => {}
	});
	
	progressBar.removeClass("hidden");
	window.fakeProgress = setInterval(x => progressBar.progress('increment'), 20);
}
