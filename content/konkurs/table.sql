CREATE TABLE `konkurss` (
                            `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `konkursiNimi` varchar(100) DEFAULT NULL,
                            `lisamisAeg` datetime DEFAULT NULL,
                            `kommentaarid` text DEFAULT ' ',
                            `punktid` int(11) DEFAULT 0,
                            `avalik` int(11) DEFAULT 1
)

CREATE TABLE users (
                       usersId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                       usersName varchar(128) NOT NULL,
                       usersEmail varchar(128) NOT NULL,
                       usersUid varchar(128) NOT NULL,
                       usersPwd varchar(128) NOT NULL,
                       rolli int NOT NULL DEFAULT 0
);