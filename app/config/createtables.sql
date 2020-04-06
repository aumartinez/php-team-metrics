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
  team_id VARCHAR(255) NOT NULL,
  team_name VARCHAR(255) NOT NULL,
  account_name VARCHAR(255) NOT NULL  
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS GlobalMetrics (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  team_id VARCHAR(255) NOT NULL,
  metric_name VARCHAR(255) NOT NULL,
  site_goal DECIMAL NOT NULL,
  team_goal DECIMAL NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS UserMetrics (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(255) NOT NULL,
  team_id VARCHAR(255) NOT NULL,
  metric_name VARCHAR(255) NOT NULL,
  user_score DECIMAL NOT NULL,
  signed BOOLEAN NOT NULL,
  sign_date DATETIME NOT NULL,
  week_num INT NOT NULL,
  date_num INT NOT NULL,
  year_num INT NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS Users (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  create_date DATETIME NOT NULL,  
  user_name VARCHAR(255) NOT NULL,
  user_firstname VARCHAR(255) NOT NULL,
  user_lastname VARCHAR(255) NOT NULL,
  employee_id CHAR(4) NOT NULL,
  team_id VARCHAR(255) NOT NULL,
  position_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  salt VARCHAR(255) NOT NULL,
  user_pic VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  account_name VARCHAR(255) NOT NULL,
  user_access CHAR(1) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS ResetPassword (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
  user_id INT NOT NULL,
  pass_key VARCHAR(255) NOT NULL,
  create_date DATETIME NOT NULL,
  status INT NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS UserLog (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
  user_id INT NOT NULL,
  locked INT NOT NULL,
  log_date DATETIME NOT NULL,
  logout_date DATETIME NOT NULL,
  user_ip VARCHAR(255) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1;
