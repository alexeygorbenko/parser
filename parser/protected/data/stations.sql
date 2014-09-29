DROP DATABASE IF EXISTS `parser`;
CREATE DATABASE IF NOT EXISTS `parser`
COLLATE = utf8_bin;

USE `parser`;

DROP TABLE IF EXISTS `stations`;
CREATE TABLE IF NOT EXISTS `stations`(
id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR (255) NOT NULL UNIQUE,
url VARCHAR (2803) NOT NULL,
status VARCHAR (11) NOT NULL
)
ENGINE=MyISAM COLLATE = utf8_bin;

DROP TABLE IF EXISTS `description`;
CREATE TABLE IF NOT EXISTS `description`(
id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
st_name VARCHAR (255),
song VARCHAR (255),
author VARCHAR (255)
)
ENGINE=MyISAM COLLATE = utf8_bin;