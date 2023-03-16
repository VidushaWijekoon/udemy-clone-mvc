<?php

// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';

define('APP_NAME', 'Udemy Clone');
define('APP_DESC', 'Clone By Vidusha Wijekoon OOP MVC PDO 2023/03/10');

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // database config for local server
    define('DBHOST', 'localhost');
    define('DBNAME', 'udemy_clone');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', 'mysql');
    // Root Path localhost
    define('ROOT', 'http://localhost/udemy-clone/public');
} else {
    // database congif for live serve
    define('DBHOST', 'localhost');
    define('DBNAME', 'udemy_clone');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', 'mysql');
    // Root Path liveserver
    define('ROOT', 'http://localhost/udemy-clone/public');
}
