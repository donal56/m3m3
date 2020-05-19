$("#w0").form({
	onSuccess: function(event, fields) {
		event.preventDefault();
		event.stopPropagation();
		console.log(fields);
		//Ajax call
		window.location= "index.html"
		localStorage.setItem("logged","1");
	}
});
