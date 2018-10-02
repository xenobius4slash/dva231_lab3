CREATE DATABASE IF NOT EXISTS dva231;
create user IF NOT EXISTS 'dva231_RW'@'localhost' identified by 'test123';
grant usage on *.* to 'dva231_RW'@'localhost' identified by 'test123'; 
grant all privileges on dva231.* to 'dva231_RW'@'localhost';
flush privileges; 

use dva231;

CREATE TABLE IF NOT EXISTS user (
	id INTEGER NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL PRIMARY KEY,	-- username of a user
	password VARCHAR(60) NOT NULL,				-- hash of a password
	UNIQUE(id)
);

CREATE TABLE IF NOT EXISTS session (
	session_id VARCHAR(32) NOT NULL PRIMARY KEY,				-- PHP-Session-ID
	user_id INTEGER NOT NULL,									-- user id
	expiration DATETIME NOT NULL,								-- when the session is out of time
	FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE	-- reference to "user.id", tuple  will be deleted if "user.id" is deleted
);

CREATE TABLE IF NOT EXISTS article (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	published DATETIME NOT NULL,								-- datetime of adding the article
	title VARCHAR(100) NOT NULL,								-- title of the article
	subtitle VARCHAR(255) NOT NULL,								-- subtitle of the article
	text_path VARCHAR(255) NOT NULL,							-- filepath to the text
	media_type ENUM('img', 'video') NOT NULL,					-- possible media types
	media_path VARCHAR(255) NOT NULL,							-- filepath to the media
	media_size ENUM('col1', 'col2', 'col3', 'col4') NOT NULL,	-- possible media sizes
	top_article BOOLEAN NOT NULL DEFAULT FALSE,					-- should show in the rotation
	user_id INTEGER NOT NULL, 									-- user ID
	FOREIGN KEY (user_id) REFERENCES user(id)					-- reference to "user.id"
);
