INSTALLATION :

DATABASE : 

1) create database "draw_smthg"

2) insert tables :

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) 

CREATE TABLE `draw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `root` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) 

CREATE TABLE `word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `word` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
)

3) Install the python file and its libraries to get random words

    - python3.8
    - mariadb