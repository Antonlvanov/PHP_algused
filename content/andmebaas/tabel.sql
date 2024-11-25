CREATE TABLE loomad(
                    id int PRIMARY key AUTO_INCREMENT,
                    loomanimi varchar(20),
                    omanik varchar(30),
                    varv varchar(20),
                    pilt text);

INSERT INTO loomad(loomanimi, omanik, varv)
VALUES ('kass Vassily', 'David', 'red');


SELECT * FROM loomad;

Create table osalejad(
                         id int Primary key AUTO_INCREMENT,
                         nimi varchar(20),
                         telefon varchar(30),
                         pilt text,
                         synniaeg date
);