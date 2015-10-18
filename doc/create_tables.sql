-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Applicant(
	id SERIAL PRIMARY KEY,
	email varchar(100) NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE Admin(
        id SERIAL PRIMARY KEY,
        email varchar(100) NOT NULL,
        password varchar(50) NOT NULL
);

CREATE TABLE Degree(
	id SERIAL PRIMARY KEY,
	name varchar(100) NOT NULL,
	deadline DATE,
	description varchar(2000),
	accepted INTEGER,
	acceptancerate DECIMAL(4,2),
	city varchar(50),
	extent INTEGER
);

CREATE TABLE Favorite(
	applicant_id INTEGER REFERENCES Applicant(id),
	degree_id INTEGER REFERENCES Degree(id),
	PRIMARY KEY(applicant_id, degree_id)
);

CREATE TABLE Institution(
	id SERIAL PRIMARY KEY,
	name VARCHAR(100),
	picture VARCHAR(300)
);

CREATE TABLE Degree_Institution(
	degree_id INTEGER REFERENCES Degree(id),
	institution_id INTEGER REFERENCES Institution(id),
	PRIMARY KEY(degree_id, institution_id)
);

CREATE TABLE Suggestion(
	id SERIAL PRIMARY KEY,
	creationtime TIMESTAMP,
	description varchar(500),
	justification varchar(500),
	processed boolean DEFAULT FALSE
);