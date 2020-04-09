-- Create tables

CREATE TABLE IF NOT EXISTS accounts (
  id INT NOT NULL AUTO_INCREMENT,
  account_name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (account_name)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS positions (
  id INT NOT NULL AUTO_INCREMENT,
  position_name VARCHAR(50) NOT NULL,
  user_access INT NOT NULL,
  PRIMARY KEY (id)
  UNIQUE (position_name)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS teams (
  id INT NOT NULL AUTO_INCREMENT,
  team_id VARCHAR(50) NOT NULL,
  team_name VARCHAR(50) NOT NULL,
  account_name VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (team_id)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS globalmetrics (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  team_id VARCHAR(50) NOT NULL,
  metric_name VARCHAR(50) NOT NULL,
  site_goal DECIMAL NOT NULL,
  team_goal DECIMAL NOT NULL 
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS usermetrics (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(50) NOT NULL,
  team_id VARCHAR(50) NOT NULL,
  metric_name VARCHAR(50) NOT NULL,
  user_score DECIMAL NOT NULL,
  signed BOOLEAN NOT NULL,
  sign_date DATETIME NOT NULL,
  week_num INT NOT NULL,
  date_num INT NOT NULL,
  year_num INT NOT NULL  
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  create_date DATETIME NOT NULL,  
  user_name VARCHAR(50) NOT NULL,
  user_firstname VARCHAR(100) NOT NULL,
  user_lastname VARCHAR(100) NOT NULL,
  employee_id CHAR(4) NOT NULL,
  team_id VARCHAR(50) NOT NULL,
  position_name VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  salt VARCHAR(100) NOT NULL,
  user_pic VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  account_name VARCHAR(50) NOT NULL,
  user_access CHAR(1) NOT NULL,
  PRIMARY KEY (id)
  UNIQUE (user_name)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS resetpassword (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
  user_name INT NOT NULL,
  pass_key VARCHAR(255) NOT NULL,
  create_date DATETIME NOT NULL,
  status INT NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS userlog (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
  user_name INT NOT NULL,
  locked INT NOT NULL,
  log_date DATETIME NOT NULL,
  logout_date DATETIME NOT NULL,
  user_ip VARCHAR(100) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;
