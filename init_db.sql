DROP TABLE IF EXISTS poll;

CREATE TABLE `poll` (
 `id` int NOT NULL AUTO_INCREMENT,
 `question` varchar(1000) NOT NULL,
 `uri` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS answer;

CREATE TABLE `answer` (
 `id` int NOT NULL AUTO_INCREMENT,
 `poll_id` int NOT NULL,
 `answer` varchar(1000) NOT NULL,
 PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS result;

CREATE TABLE `result` (
 `poll_id` int NOT NULL,
 `answer_id` int NOT NULL,
 `username` varchar(1000) NOT NULL
);


