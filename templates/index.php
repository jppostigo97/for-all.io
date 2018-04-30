<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title><?= Application::$title ?></title>
</head>
<body>
	<div id="wrapper">
		<header>
			<h1><?= Application::$title ?></h1>
			<h2><?= Application::$description ?></h2>
		</header>
		<div id="content">
			[[ forallio-content ]]
		</div>
	</div>
</body>
</html>