<script src="assets/js/jquery.js"></script>
<script>
	$(function() {
		// El token del bot no aparecerá por obvias cuestiones de privacidad
		$.post("https://api.telegram.org/bot---/sendMessage", {
			chat_id: "@forallio",
			text: "[[ message ]]"
		}, function(data, status, xhr) {
			console.log(JSON.stringify(data));
			console.log(status);
		});
	});
</script>
