<?php if (isset($error)): ?>
	<div class="error">
		<?= $error ?>
	</div>
	<?php exit; ?>
<?php endif; ?>

<div id="write-message">
	<form action="thread/validate" method="POST">

		<?php if (isset($thread_id) && $thread_id != 0): ?>

			<div class="form-field">
				<label>Hilo</label>
				<input type="text" readonly="readonly" value="[[ thread_title ]]" />
				<input type="hidden" name="thread_id" value="[[ thread_id ]]" />
			</div>

		<?php else: ?>

			<div class="form-field">
				<label>Subforo</label>
				<input type="text" readonly="readonly" value="[[ subforum_title ]]" />
				<input type="hidden" name="subforum" value="[[ subforum_id ]]" />
			</div>
			<div class="form-field">
				<label for="thread_title">Título</label>
				<input type="text" name="thread_title" maxlength="255" minlength="5" required />
			</div>

		<?php endif; ?>

		<div class="form-field vertical-field">
			<label for="message_content">Mensaje</label>
			<textarea name="message_content" rows="8" required></textarea>
		</div>
		<div>
			<button type="submit">Publicar</button>
		</div>
	</form>
</div>
