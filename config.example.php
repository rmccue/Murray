<?php

// Config

Murray::$url = 'http://localhost/';
Murray::$db = new PDO('mysql:host=localhost;dbname=db', 'root', 'password');


// Load sources

Murray_Sources::load('Murray_Source_GitHub', 'user');
Murray_Sources::load('Murray_Source_Reddit', 'user');
Murray_Sources::load('Murray_Source_LastFM', 'user');
Murray_Sources::load('Murray_Source_Twitter', 'user');