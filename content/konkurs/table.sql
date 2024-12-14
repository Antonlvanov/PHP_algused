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
                       usersUsername varchar(128) NOT NULL,
                       usersEmail varchar(128) NOT NULL,
                       usersPassword varchar(128) NOT NULL,
                       usersRealname varchar(128) NOT NULL
);