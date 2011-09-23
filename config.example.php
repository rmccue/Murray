<?php

// Config

Murray::$url = 'http://localhost/php/Murray';
Murray::$db = new PDO('mysql:host=fserve;dbname=testdb', 'root', 'password');


// Load sources

Murray_Sources::load('Murray_Source_GitHub', 'rmccue');
Murray_Sources::load('Murray_Source_Reddit', 'rmccue');
Murray_Sources::load('Murray_Source_LastFM', 'rmccue');
Murray_Sources::load('Murray_Source_Twitter', 'rmccue');
//Murray_Sources::load('Murray_Source_Steam', array('user' => 'rmccue', 'key' => '4891AAE2F2D77FAC28D11EAC5766D0F2'));