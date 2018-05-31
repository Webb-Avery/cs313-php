CREATE TABLE plants
(
id SERIAL PRIMARY KEY,
"name" VARCHAR(100) NOT NULL UNIQUE,
sunExposure VARCHAR(50),
waterInches VARCHAR(50),
timeToPlant VARCHAR(100),
height VARCHAR(100),
spread VARCHAR(100),
lifeCycle VARCHAR(100),
plantType VARCHAR(100)
);

CREATE TABLE hardinessZones
(
id SERIAL PRIMARY KEY,
hardinessZone INTEGER
);

CREATE TABLE gardens
(
id SERIAL PRIMARY KEY,
"name" VARCHAR(100) NOT NULL,
userId INT NOT NULL REFERENCES users(id)
);

CREATE TABLE zones
(
id SERIAL PRIMARY KEY,
"name" VARCHAR(100) NOT NULL,
sunExposure VARCHAR(50),
waterInches VARCHAR(100),
gardenId INT NOT NULL REFERENCES gardens(id),
hardiness integer
);

CREATE TABLE zonesPlants
(
id SERIAL PRIMARY KEY,
zonesId INT REFERENCES zones(id) NOT NULL,
plantsId INT REFERENCES plants(id) NOT NULL
);

CREATE TABLE hardinessPlants
(
id SERIAL PRIMARY KEY,
hardinessZonesId INT REFERENCES hardinessZones(id) NOT NULL,
plantsId INT REFERENCES plants(id) NOT NULL
);



INSERT INTO plants(name, sunexposure, waterinches, timetoplant, height, spread, lifecycle, planttype)  VALUES ('Sweet Basil', 'Full Sun', '1 inch', 'spring,summer', '12-18 inches', '10-14 inches', 'Annual', 'Herb');