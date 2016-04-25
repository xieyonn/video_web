CREATE TABLE admins (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  nick_name varchar(50) DEFAULT NULL,
  password varchar(100) NOT NULL,
  create_time datetime NOT NULL,
  last_login_time datetime DEFAULT NULL,
  type int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE articles (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  content varchar(10000) DEFAULT NULL,
  create_time datetime NOT NULL,
  update_time datetime NOT NULL,
  clicks int(11) DEFAULT '0',
  indexing int(11) DEFAULT '0',
  status int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE configs (
  id int(11) NOT NULL AUTO_INCREMENT,
  key varchar(255) NOT NULL,
  value varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE records (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  video_id int(11) NOT NULL,
  update_time datetime NOT NULL,
  played_percent int(11) NOT NULL DEFAULT '0',
  series_id int(11) NOT NULL,
  indexing int(11) NOT NULL,
  video_name varchar(255) NOT NULL,
  title varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE series (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  brief varchar(2000) DEFAULT NULL,
  create_time datetime NOT NULL,
  update_time datetime NOT NULL,
  admin varchar(50) NOT NULL,
  amount int(11) DEFAULT NULL,
  cover_name varchar(255) NOT NULL,
  series_name varchar(255) NOT NULL,
  status int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  create_time datetime NOT NULL,
  last_login_time datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE videos (
  id int(11) NOT NULL AUTO_INCREMENT,
  series_id int(11) NOT NULL,
  file_name varchar(255) NOT NULL,
  create_time datetime NOT NULL,
  admin varchar(50) NOT NULL,
  indexing int(11) NOT NULL,
  status int(11) NOT NULL,
  update_time datetime DEFAULT NULL,
  title varchar(255) NOT NULL,
  cover varchar(255) NOT NULL,
  has_cover int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO configs (key, value) VALUES ('logo', 'NEoKMqD2E7fzRuSZ7TGH0Urizf5nhq.jpg');
INSERT INTO configs (key, value) VALUES ('site_title', '武汉大学计算机学院');
INSERT INTO configs (key, value) VALUES ('site_name', '武汉大学计算机学院');
INSERT INTO admins (id, user_name, nick_name, password, create_time, last_login_time, type) VALUES ('1', 'admin', 'admin', 'bdc2d12f90867717d1bbc5bc01bb614f', '2016-04-14 19:32:05', '2016-04-24 23:22:31', '0');