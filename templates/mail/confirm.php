<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>Confirmación registro ForAll.io</title>
</head>
<body>
	<h1>Bienvenido a ForAll.io</h1>
	<p>
		Puedes pulsar el siguiente botón para confirmar tu cuenta de usuario: <br />
		<a class="btn" href="<?= $verify_url ?>">Confirmar tu cuenta</a>
	</p>
	<?php if (isset($token)): ?>
		<p>
			Además, tu API token es: <br /><?= $token ?>
			<br />
			Si quieres aprender a consumir la API de ForAll,
			toda la información que necesitas está en el manual de usuario.
		</p>
	<?php endif; ?>
	<footer>
		Copyright &copy; Juan Pedro Postigo 2018 - ForAll.io
	</footer>
</body>
</html>
