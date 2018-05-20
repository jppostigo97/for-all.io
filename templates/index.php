<!DOCTYPE html>
<html lang="es">
<head>
	<base href="<?= Router::$base ?>" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title><?= Application::$tabTitle ?></title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" href="assets/css/fontawesome-all.min.css" />
	<link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
	<div id="wrapper">
		<header id="header">

			<hgroup id="logo">
				<h1>
					<?php
						echo Application::$title . "." . Application::$subtitle;

						if (empty(Application::$param)) echo "()";
						else echo "( " . Application::$param . " )";
					?>;
				</h1>
			</hgroup>

			<nav id="navbar">
				<ul>

					<li>
						<a href=".">
							<span>
								<i class="fas fa-lg fa-fw fa-home"></i>
							</span>
							<span>
								<i class="fas fa-fw fa-home"></i>
							</span>
							<span>
								Inicio
							</span>
						</a>
					</li>

					<?php if (isset($_SESSION["user"])): ?>
						<li>
							<a href="user/profile">
								<span>
									<i class="fas fa-lg fa-fw fa-user-circle"></i>
								</span>
								<span>
									<i class="fas fa-fw fa-user-circle"></i>
								</span>
								<span>
									Perfil
								</span>
							</a>
						</li>

						<?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "admin"): ?>
							<li>
								<a href="admin">
									<span>
										<i class="fas fa-lg fa-fw fa-cogs"></i>
									</span>
									<span>
										<i class="fas fa-fw fa-cogs"></i>
									</span>
									<span>
										Administración
									</span>
								</a>
							</li>
						<?php endif; ?>

						<li>
							<a href="user/logout">
								<span>
									<i class="fas fa-lg fa-fw fa-sign-out-alt"></i>
								</span>
								<span>
									<i class="fas fa-fw fa-sign-out-alt"></i>
								</span>
								<span>
									Salir
								</span>
							</a>
						</li>
					<?php else: ?>
						<li>
							<a href="user/account">
								<span>
									<i class="fas fa-lg fa-fw fa-sign-in-alt"></i>
								</span>
								<span>
									<i class="fas fa-fw fa-sign-in-alt"></i>
								</span>
								<span>
									Entra / Regístrate
								</span>
							</a>
						</li>
					<?php endif; ?>

				</ul>
			</nav>
		</header>

		<div id="content">
			[[ forallio-content ]]
		</div>

	</div>
</body>
</html>
