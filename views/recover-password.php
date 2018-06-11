<div id="recover-password">

	<h2>Recuperar contraseña</h2>

	<?php if ($error != ""): ?>
		<div id="error"><?= $error ?></div>
	<?php endif; ?>

	<form action="user/recover" method="POST">
		<div class="form-field">
			<label for="target_email">Email</label>
			<input type="email" name="target_email" placeholder="email@ejemplo.com" />
		</div>
		<div>
			<button type="submit">Recuperar contraseña</button>
		</div>
	</form>

</div>