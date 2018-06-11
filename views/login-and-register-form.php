<div id="password-help">
	<small>
		Las contraseñas deben ser de al menos 6 caracteres de longitud, además de contener una letra y un número o caracter especial.
	</small>
</div>

<?php if (isset($error) && !empty($error)): ?>
	<div id="login-register-error" class="error">
		[[ error ]]
	</div>
<?php endif; ?>

<div id="landing-forms">

	<form action="user/account" method="POST" id="login-form">
		<h2>Iniciar sesión</h2>
		<div class="form-field">
			<label for="login_email">Email</label>
			<input type="email" name="login_email" id="login_email" value="[[ login_email ]]" required />
		</div>
		<div class="form-field">
			<label for="login_password">Contraseña</label>
			<input type="password" name="login_password" id="login_password" required />
		</div>
		<div>
			<button type="submit">Entra</button>
		</div>
		<div id="forgot-password">
			<a href="user/recover">¿Has olvidado tu contraseña?</a>
		</div>
	</form>

	<form action="user/account" method="POST" id="register-form">
		<h2>Registrarse</h2>
		<div class="form-field">
			<label for="reg_email">Email</label>
			<input type="email" name="reg_email" id="reg_email" value="[[ reg_email ]]" required placeholder="email@ejemplo.com" />
		</div>
		<div class="form-field">
			<label for="reg_username">Usuario</label>
			<input type="text" name="reg_username" id="reg_username" value="[[ reg_username ]]" pattern="([A-z]+)\w{5,}" required />
		</div>
		<div class="form-field">
			<label for="reg_password">Contraseña</label>
			<input type="password" name="reg_password" id="reg_password" required />
			<!-- <input type="password" name="reg_password" id="reg_password" pattern="((?=(.*[a-z|A-Z].*))+(?=(.*(\W|[0-9]).*))+)(.){6,}" required /> -->
		</div>
		<div class="form-field">
			<label for="reg_repassword">Repite la contraseña</label>
			<input type="password" name="reg_repassword" id="reg_repassword" required />
			<!-- <input type="password" name="reg_repassword" id="reg_repassword" pattern="((?=(.*[a-z|A-Z].*))+(?=(.*(\W|[0-9]).*))+)(.){6,}" required /> -->
		</div>
		<div>
			<button type="submit">Regístrate</button>
		</div>
	</form>
</div>