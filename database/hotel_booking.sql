CREATE DATABASE hotel_booking; -- Creates a database called "hotel_booking"

USE hotel_booking; -- Switches to the "hotel-booking" database

CREATE TABLE slots (
                       id INT NOT NULL AUTO_INCREMENT, -- The unique identifier for the slot
                       name VARCHAR(255) NOT NULL,
                       description TEXT NOT NULL,
                       image VARCHAR(255) NOT NULL,
                       expired BOOLEAN NOT NULL DEFAULT 0, -- Whether the slot has expired
                       booked BOOLEAN NOT NULL DEFAULT 0, -- Whether the slot is booked
                       booked_user VARCHAR(255) NULL,
                       checkin DATE NULL,
                       checkout DATE NULL,
                       created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- The date and time the slot was created
                       updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       PRIMARY KEY (id) -- The primary key for the table
);

CREATE TABLE users (
                       id INT NOT NULL AUTO_INCREMENT,
                       name VARCHAR(255) NOT NULL,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       is_admin BOOLEAN NOT NULL DEFAULT 1, -- Whether the user is an admin. If default is set to 0 login will automatically set as "not admin"
                       created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- The date and time the user was created
                       updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- The date and time the user was last updated
                       PRIMARY KEY (id) -- The primary key for the table
);
