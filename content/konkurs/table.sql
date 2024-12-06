CREATE TABLE `konkurss` (
                            `id` int(11) NOT NULL,
                            `konkursiNimi` varchar(100) DEFAULT NULL,
                            `lisamisAeg` datetime DEFAULT NULL,
                            `kommentaarid` text DEFAULT ' ',
                            `punktid` int(11) DEFAULT 0,
                            `avalik` int(11) DEFAULT 1
)