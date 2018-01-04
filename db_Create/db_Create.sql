DROP DATABASE IF EXISTS accounts;

CREATE DATABASE IF NOT EXISTS accounts;

USE accounts;

CREATE TABLE users (
    `uid` int(11) AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR (255) NOT NULL,
    `password` VARCHAR(1000) NOT NULL,
    `verifid` INT(11) NOT NULL,
    `active` BOOLEAN NOT NULL DEFAULT 0,
    `email_notif` BOOLEAN NOT NULL DEFAULT 1,
    PRIMARY KEY (`uid`)
);

CREATE TABLE uploads (
    `pid` INT(11) AUTO_INCREMENT NOT NULL,
    `userid` INT(11) NOT NULL,
    `file_name` VARCHAR(100) NOT NULL,
    `date` TIMESTAMP NOT NULL,
    PRIMARY KEY(`pid`)
);

CREATE TABLE comments (
    `pid` INT(11) NOT NULL,
    `userid` INT(11) NOT NULL,
    `comment_data` VARCHAR(1000) NOT NULL,
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(`id`)
);

CREATE TABLE likes (
    `pid` INT(11) NOT NULL,
    `userid` INT(11) NOT NULL,
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(`id`)
);