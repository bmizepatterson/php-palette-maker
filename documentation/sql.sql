-- Create the tables we need for our project

CREATE TABLE color (
    id serial PRIMARY key,
    name varchar(50) UNIQUE NOT null,
    hex char(6) UNIQUE NOT NULL
);

CREATE TABLE palette (
    id serial PRIMARY key,
    name varchar(50) UNIQUE NOT NULL
);

CREATE TABLE color_palette (
    color_id INTEGER REFERENCES color(id) ON DELETE CASCADE,
    palette_id INTEGER REFERENCES palette(id) ON DELETE CASCADE
);


-- Seed the tables with some basic data

INSERT INTO color (name, hex) VALUES ('Bootstrap Blue', '007bff');
INSERT INTO color (name, hex) VALUES ('Bootstrap Indigo', '6610f2');
INSERT INTO color (name, hex) VALUES ('Bootstrap Purple', '6f42c1');
INSERT INTO color (name, hex) VALUES ('Bootstrap Pink', 'e83e8c');
INSERT INTO color (name, hex) VALUES ('Bootstrap Red', 'dc3545');
INSERT INTO color (name, hex) VALUES ('Bootstrap Orange', 'fd7e14');
INSERT INTO color (name, hex) VALUES ('Bootstrap Yellow', 'ffc107');
INSERT INTO color (name, hex) VALUES ('Bootstrap Green', '28a745');
INSERT INTO color (name, hex) VALUES ('Bootstrap Teal', '20c997');
INSERT INTO color (name, hex) VALUES ('Bootstrap Cyan', '17a2b8');
INSERT INTO color (name, hex) VALUES ('White', 'FFFFFF');
INSERT INTO color (name, hex) VALUES ('Black', '000000');
INSERT INTO color (name, hex) VALUES ('Grey', 'CCCCCC');
INSERT INTO color (name, hex) VALUES ('Light Grey', 'f8f9fa');
INSERT INTO color (name, hex) VALUES ('Medium Grey', 'ced4da');
INSERT INTO color (name, hex) VALUES ('Dark Grey', '495057');
INSERT INTO color (name, hex) VALUES ('Pumpkin', 'd57500');
INSERT INTO color (name, hex) VALUES ('Stem', '668d3c');
INSERT INTO color (name, hex) VALUES ('Caramel', 'b99c6b');
INSERT INTO color (name, hex) VALUES ('Dijon', 'dbca69');
INSERT INTO color (name, hex) VALUES ('Cinnamon', '8f3b1b');
INSERT INTO color (name, hex) VALUES ('Pantone Ultra Violet (2018)', '5F4B8B');
INSERT INTO color (name, hex) VALUES ('Pantone Greenery (2017)', '88B04B');
INSERT INTO color (name, hex) VALUES ('Pantone Serenity (2016)', '91A8D0');
INSERT INTO color (name, hex) VALUES ('Pantone Rose Quartz (2016)', 'F7CAC9');
INSERT INTO color (name, hex) VALUES ('Pantone Marsala (2015)', '964F4C');
INSERT INTO color (name, hex) VALUES ('Pantone Radiant Orchid (2014)', 'AD5E99');
INSERT INTO color (name, hex) VALUES ('Pantone Emerald (2013)', '009473');
INSERT INTO color (name, hex) VALUES ('Pantone Tangerine Tango (2012)', 'DD4124');
INSERT INTO color (name, hex) VALUES ('Pantone Honeysuckle (2011)', 'D94F70');
INSERT INTO color (name, hex) VALUES ('Pantone Turquoise (2010)', '45B5AA');
INSERT INTO color (name, hex) VALUES ('Pantone Mimosa (2009)', 'F0C05A');
INSERT INTO color (name, hex) VALUES ('Pantone Blue Iris (2008)', '5A5B9F');
INSERT INTO color (name, hex) VALUES ('Pantone Chili Pepper (2007)', '9B2335');

INSERT INTO palette (name) VALUES ('Bootstrap Default');
INSERT INTO palette (name) VALUES ('Pumpkin Spice');
INSERT INTO palette (name) VALUES ('Greyscale');
INSERT INTO palette (name) VALUES ('Halloween');

INSERT INTO color_palette (color_id, palette_id) VALUES (1,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (2,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (3,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (4,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (5,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (6,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (7,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (8,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (9,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (10,1);
INSERT INTO color_palette (color_id, palette_id) VALUES (17,2);
INSERT INTO color_palette (color_id, palette_id) VALUES (18,2);
INSERT INTO color_palette (color_id, palette_id) VALUES (19,2);
INSERT INTO color_palette (color_id, palette_id) VALUES (20,2);
INSERT INTO color_palette (color_id, palette_id) VALUES (21,2);
INSERT INTO color_palette (color_id, palette_id) VALUES (11,3);
INSERT INTO color_palette (color_id, palette_id) VALUES (14,3);
INSERT INTO color_palette (color_id, palette_id) VALUES (15,3);
INSERT INTO color_palette (color_id, palette_id) VALUES (16,3);
INSERT INTO color_palette (color_id, palette_id) VALUES (12,3);
