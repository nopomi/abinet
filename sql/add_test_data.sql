-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Applicant (email, password) VALUES ('miska.noponen@helsinki.fi', 'keijo123');
INSERT INTO Applicant (email, password) VALUES ('samurai@jack.com', 'katana123');
INSERT INTO Admin (email, password) VALUES ('miska.noponen@gmail.com', 'kamikaze55');
INSERT INTO DEGREE (name, description, deadline, accepted, acceptancerate, city, extent) VALUES ('B.Sc. Physics', 'The programme aims to produce graduates with the thorough knowledge of Physics, transferable skills and attitudes that will enable them to fulfil their career aspirations. Lectures, practical teaching and learning laboratories, personal tutorials and exercise classes, combine to give a stimulating and challenging course covering key aspects of physics. ', '2015-09-09', 100, 0.3, 'Lappeenranta', 300);
INSERT INTO DEGREE (name, description, deadline, accepted, acceptancerate, city, extent) VALUES ('Ph.D. Molecular Biology', 'The Graduate Program in Molecular Biology welcomes students from a variety of educational backgrounds. Students select courses in a variety of disciplines and carry out research rotations with faculty members in Molecular Biology and associated programs and departments. The program provides a wide choice of advisers encompassing a broad spectrum of interdisciplinary interests and research objectives..', '2015-10-10', 5, 0.1, 'Helsinki', 120);
INSERT INTO DEGREE (name, description, deadline, accepted, acceptancerate, city, extent) VALUES ('M.Sc. Economics', 'The MSc Economics programme is intended to equip you with the main tools of the professional economist, whether you intend to work in government, central banking, international organisations or private sector firms such as economic consultancies. The advanced and technically rigorous nature of the programme also serves as an excellent foundation for PhD programmes and other research-focused roles.', '2016-02-03', 78, 0.24, 'Helsinki', 300);
INSERT INTO SUGGESTION (creationtime, description, justification) VALUES (LOCALTIMESTAMP(2), 'Delete the whole system', 'it sux');
INSERT INTO SUGGESTION (creationtime, description, justification) VALUES (LOCALTIMESTAMP(2), 'Add all degrees from University of Tampere.', 'It is s a major university, homepage here: www.uta.fi');
INSERT INTO SUGGESTION (creationtime, description, justification) VALUES (LOCALTIMESTAMP(2), 'Fix typo in the Aalto M.Sc. Econ Degree.', 'Dificult is not correctly spelled -> Difficult');
INSERT INTO INSTITUTION(name, picture) VALUES ('Lappeenranta University of Technology', 'http://clanfa.com/dundy/mideluola/tsoha/Lappeenranta_Universty_of_Technology.jpg');
INSERT INTO INSTITUTION(name, picture) VALUES ('University of Helsinki', 'http://clanfa.com/dundy/mideluola/tsoha/Helsinki_University.jpg');
INSERT INTO INSTITUTION(name, picture) VALUES ('Aalto University', 'http://clanfa.com/dundy/mideluola/tsoha/Aalto_University.jpg');
INSERT INTO DEGREE_INSTITUTION(degree_id, institution_id) VALUES (1, 1);
INSERT INTO DEGREE_INSTITUTION(degree_id, institution_id) VALUES (2, 2);
INSERT INTO DEGREE_INSTITUTION(degree_id, institution_id) VALUES (3, 3);
INSERT INTO FAVORITE(applicant_id, degree_id) VALUES (2, 1);
INSERT INTO FAVORITE(applicant_id, degree_id) VALUES (1, 1);
INSERT INTO FAVORITE(applicant_id, degree_id) VALUES (1, 2);