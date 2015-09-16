-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Applicant (email, password) VALUES ('miska.noponen@helsinki.fi', 'keijo123');
INSERT INTO DEGREE (name, description, deadline, accepted, acceptancerate, city, extent) VALUES ('B.Sc. Physics', 'Good degree', '2015-09-09', 100, 0.3, 'Lappeenranta', 300);
INSERT INTO DEGREE (name, description, deadline, accepted, acceptancerate, city, extent) VALUES ('Ph.D. Molecular Neuroscience', 'Very difficult and intricate degree.', '2015-10-10', 5, 0.1, 'Helsinki', 120);
INSERT INTO SUGGESTION (creationtime, description, justification, processed) VALUES (NOW(), 'delete system', 'it sux', FALSE);
INSERT INTO INSTITUTION(name) VALUES ('Lappeenranta University of Tech');