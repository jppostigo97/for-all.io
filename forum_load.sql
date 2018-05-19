INSERT INTO forum (title, description) VALUES
	("Desarrollo móvil", "Android e iOS"),
	("Desarrollo de escritorio", "PC, Mac y Linux"),
	("Desarrollo web", "Navegador web"),
	("Offtopic", "Todo lo que no tenga lugar");

INSERT INTO subforum (forum, title, description) VALUES
	/* Desarrollo web */
	(1, "Android - Java", "Programación para Android con Java"),
	(1, "Android - Kotlin", "El nuevo lenguaje oficial de Android"),
	(1, "Android - Extra", "Programación para Android con lenguajes poco convencionales"),
	(1, "iOS - XCode / Swift", "El que Apple quiere que usemos"),
	(1, "iOS - Extra", "Programación para iOS con lenguajes poco convencionales"),
	/* Desarrollo de escritorio */
	(2, "Shell Script / Batch", "Lenguajes de script de cada sistema"),
	(2, "Java", "El lenguajes más usado en el entorno empresarial"),
	(2, "C / C++", "Los lenguajes con mejor rendimiento entre los actuales"),
	(2, "C# / Unity", "Para desarrollar videojuegos, lo mejor es..."),
	(2, "Python", "El lenguaje de la serpiente"),
	(2, "Ruby", "Un lenguaje diferente"),
	(2, "Otros", "Ensamblador"),
	/* Desarrollo web */
	(3, "Diseño", "HTML5, CSS3 y frameworks como Bootstrap o Materialize"),
	(3, "Cliente", "Javascript y Typescript"),
	(3, "Servidor", "PHP, Java, Rails y Python"),
	(3, "NodeJS", "NodeJS nos ofrece muchas posibilidades, y está en tu mano explorarlas todas"),
	/* Offtopic */
	(4, "Videojuegos", "El nuevo arte"),
	(4, "Series y películas", "Para quien disfrute de las palomitas"),
	(4, "Papelera", "Lo que ya no sirve")
;
