-- Create tables

CREATE TABLE IF NOT EXISTS Accounts (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  account_name VARCHAR(255) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS Positions (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  position_name VARCHAR(255) NOT NULL,
  user_access CHAR(1) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS Teams (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  team_name VARCHAR(255) NOT NULL,
  account_name VARCHAR(255) NOT NULL  
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS Users (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(255) NOT NULL,
  user_access CHAR(1) NOT NULL,
  employee_id CHAR(4) NOT NULL,
  position_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  salt VARCHAR(255) NOT NULL,
  user_pic VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  account_name VARCHAR(255) NOT NULL  
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;
