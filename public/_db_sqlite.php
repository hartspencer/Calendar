<?php

$db_exists = file_exists("daypilot.sqlite");

$db = new PDO("mysql:host=localhost;dbname=appetiser_test", 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// CREATE TABLE IF NOT EXISTS events (
//                         id INTEGER PRIMARY KEY, 
//                         name TEXT, 
//                         start DATETIME, 
//                         end DATETIME,
//                         color VARCHAR(30))