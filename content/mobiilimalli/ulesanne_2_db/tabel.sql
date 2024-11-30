Create table anekdoodid(
                           id int Primary key AUTO_INCREMENT,
                           nimetus varchar(40) not null,
                           sisu text not null,
                           kuupaev DATETIME
);

INSERT INTO anekdoodid (nimetus, sisu, kuupaev) VALUES
                                                    ('Baskini anekdoot', '"Kas ma olen teid kusagil näinud?" - küsib kohtunik süüaluselt.\n"Seda küll, härra kohtunik. Ma andsin teie tütrele muusikatunde!"\n"Eluaegne vanglakaristus!"', '2024-05-06 10:00:00'),

                                                    ('Meie naljaraamat', '"Kaebealune, teid mõistetakse õigeks, kuna puudub tõendus teie osalemise kohta pangaröövis."\n"Oi, kui tore, härra kohtunik! Kas see tähendab, et võin raha endale jätta!?"', '2024-05-06 11:30:00'),

                                                    ('Delfi naljad', '"Halloo, kes seal kuuleb?"\n"Bill Gates."\n"Oi, ma ei tundnud teid ära, saate rikkaks."', '2024-05-06 12:45:00'),

                                                    ('Maalehe anekdoot', '"Kuule, kägu," pärib Vahur Kraft,\n"Mitu aastat ma veel president saan olla?"\n"Kuk-ku!"\n"Miks nii vähe?"\n"Te-tegelt sul isegi vedas - ma olen kok-kokutaja."', '2024-05-06 14:15:00'),

                                                    ('Delfi naljad', '"Windows" - see tähendab indiaanlaste keeles - valge inimene vaatab läbi klaasist akna liivakella.', '2024-05-06 15:30:00');
