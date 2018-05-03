<div id="write-message">
	<form action="thread/validate" method="POST">
		<div class="form-field">
			<label>Subforo</label>
			<input type="text" readonly="readonly" value="[[ subforum_title ]]" />
			<input type="hidden" name="subforum" value="[[ subforum_id ]]" />
		</div>
		<div class="form-field">
			<label for="thread_title">Título</label>
			<input type="text" name="thread_title" required />
		</div>
		<div class="form-field vertical-field">
			<label for="message_content">Mensaje</label>
			<textarea name="message_content" rows="8" required></textarea>
		</div>
		<div>
			<button type="submit">Publicar</button>
		</div>
	</form>
</div>