DROP DATABASE IF EXISTS accounts;

CREATE DATABASE IF NOT EXISTS accounts;

USE accounts;

CREATE TABLE users (
    `uid` int(11) AUTO_INCREMENT NOT NULL,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR (255) NOT NULL,
    `password` VARCHAR(1000) NOT NULL,
    `verifid` INT(11) NOT NULL,
    `active` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`uid`)
);

CREATE TABLE uploads (
    `pid` INT(11) AUTO_INCREMENT NOT NULL,
    `userid` INT(11) NOT NULL,
    `file_name` VARCHAR(100) NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY(`pid`)
);