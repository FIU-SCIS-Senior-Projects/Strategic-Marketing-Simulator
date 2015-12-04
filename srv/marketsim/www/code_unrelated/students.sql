CREATE TABLE hotel
(
  id int(11) NOT NULL AUTO_INCREMENT,
  name tinytext NOT NULL,
  location int not null,
  type enum('economy','midrange','luxury'),
  game int(11) NOT NULL,
  balance decimal(12,2) null,
  revenue decimal(12,2) null,
  roomsFilled float null,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE game
(
  id int(11) NOT NULL AUTO_INCREMENT,
  semester tinytext NOT NULL,
  course tinytext NOT NULL,
  section tinytext NOT NULL,
  schedule tinytext null,

  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE advertising
(
  id int(11) NOT NULL AUTO_INCREMENT,
  type tinytext NOT NULL,


  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE location
(
  id int(11) NOT NULL AUTO_INCREMENT,
  type tinytext NOT NULL,


  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE game_period
(
  id int(11) NOT NULL AUTO_INCREMENT,
  game int(11) NOT NULL,
pstart datetime not null,
pend datetime null,



  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE hotel_advertising
(
  id int(11) NOT NULL AUTO_INCREMENT,
  hotel int not null,
  advertising int not null,
  

  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


alter table student add foreign key (game) references game(id) on delete
 cascade on update cascade;

alter table student add foreign key (hotel) references hotel(id) on delete
 cascade on update cascade;

alter table hotel add foreign key (game) references game(id) on delete
 cascade on update cascade;

alter table hotel add foreign key (location) references location(id) on delete
 cascade on update cascade;

alter table hotel_advertising add foreign key (hotel) references hotel(id) on delete
 cascade on update cascade;

alter table hotel_advertising add foreign key (advertising) references advertising(id) on delete
 cascade on update cascade;

alter table game_period add foreign key (game) references game(id) on delete
 cascade on update cascade;




CREATE TABLE admin(
  id int(11) NOT NULL AUTO_INCREMENT,
  fname tinytext NOT NULL,
  lname tinytext,
  username varchar(8) NOT NULL,

  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
