<?php

const HOST = 'host=localhost';
const DBNAME = 'dbname=burgers';
const USER = 'root';
const PASS = '';

//connect()->query('CREATE TABLE IF NOT EXISTS `users` (
//  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
//  `name` VARCHAR (255) NOT NULL,
//  `phone` VARCHAR (255) NOT NULL,
//  `email` VARCHAR(255) UNIQUE NOT NULL)');
//connect()->query('CREATE TABLE IF NOT EXISTS `orders`(
// id INT UNIQUE NOT NULL AUTO_INCREMENT,
// user_id INT NOT NULL REFERENCES `users`(id),
// street VARCHAR(255) NOT NULL,
// home VARCHAR(255) NOT NULL,
// part VARCHAR(255) NOT NULL,
// appt VARCHAR(255) NULL,
// floor VARCHAR(255) NULL,
// comment TEXT NULL,
// payment VARCHAR(255) NOT NULL,
// callback VARCHAR(255) NOT NULL,
// FOREIGN KEY (user_id) REFERENCES `users`(id))');
