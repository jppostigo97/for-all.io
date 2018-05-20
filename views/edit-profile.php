<div id="edit-profile">

	<h2>Editar perfil - [[ user ]] ([[ role ]])</h2>

	<?php if (isset($error)): ?>
		<div id="error">
			<?= $error ?>
		</div>
	<?php endif; ?>

	<form action="user/validate_edition" method="POST">
		
		<div class="form-field">
			<label for="newemail">Email</label>
			<input type="email" name="newemail" value="[[ email ]]" />
		</div>

		<div class="form-field">
			<label for="newpassword">Nueva contraseña</label>
			<input type="password" name="newpassword" />
		</div>

		<div class="form-field">
			<label for="newpasswordre">Repite la nueva contraseña</label>
			<input type="password" name="newpasswordre" />
		</div>

		<div class="form-field">
			<label for="password">Contraseña actual</label>
			<input type="password" name="password" required />
		</div>

		<div>
			<button type="submit">Guardar</button>
		</div>

	</form>
</div>
