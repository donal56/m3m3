let progressBar = $('#w0 .hidden.progress');

progressBar.progress({
	total    : 100,
	text     : {
		active: 'Subiendo publicación {value}%'
	},
	onSuccess: () => window.location = "index.html"
});

$("#w0").form({
	fields: {
      titulo : ['maxLength[300]', 'empty'],
      file   : 'empty',
      tags 	 : 'empty',
    },
	onSuccess: function(event, fields) {
		event.preventDefault();
		event.stopPropagation();
		
		console.log(fields);

		//Ajax call
		progressBar.removeClass("hidden");
		window.fakeProgress = setInterval(x => progressBar.progress('increment'), 50);
	}
});
