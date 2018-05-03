DROP DATABASE IF EXISTS forallio;

CREATE DATABASE forallio CHARACTER SET utf8 COLLATE utf8_general_ci;

USE forallio;

/* Roles de usuario. */
CREATE TABLE user_role (
	id INT AUTO_INCREMENT PRIMARY KEY,
	slug VARCHAR(20) NOT NULL,
	name VARCHAR(40) NOT NULL
);

/* Usuario. */
CREATE TABLE user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(150) NOT NULL,
	nick VARCHAR(60) NOT NULL,
	password VARCHAR(300) NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	last_connection TIMESTAMP,
	level INT, /* user_role */
	verified BIT DEFAULT 0,
	active BIT DEFAULT 1,
	FOREIGN KEY (level) REFERENCES user_role(id)
);

/* Config. */
CREATE TABLE config (
	ckey VARCHAR(30) NOT NULL,
	cvalue VARCHAR(30) NOT NULL
);

/* Categoría / Foro */
CREATE TABLE forum (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(50) NOT NULL,
	description TEXT,
	date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	ordered INT(2) DEFAULT 1
);

/** Subcategoría / Subforo */
CREATE TABLE subforum (
	id INT AUTO_INCREMENT PRIMARY KEY,
	forum INT NOT NULL,
	title VARCHAR(50) NOT NULL,
	description TEXT,
	date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	ordered INT(2) DEFAULT 1,
	FOREIGN KEY (forum) REFERENCES forum(id) ON DELETE CASCADE
);

/* Hilo / Thread */
CREATE TABLE thread (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(100) NOT NULL,
	creator INT NOT NULL,
	subforum INT NOT NULL,
	FOREIGN KEY (creator) REFERENCES user(id),
	FOREIGN KEY (subforum) REFERENCES subforum(id) ON DELETE CASCADE
);
