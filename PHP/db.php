<?php

function get_db_connection(): mysqli
{
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $database = 'culturelingo';
    $port = 3306;

    $mysqli = mysqli_init();
    if (!$mysqli) {
        throw new RuntimeException('Failed to initialize MySQLi.');
    }

    if (!$mysqli->real_connect($host, $user, $password, $database, $port)) {
        throw new RuntimeException('Database connection failed: ' . $mysqli->connect_error);
    }

    if (!$mysqli->set_charset('utf8mb4')) {
        throw new RuntimeException('Failed to set charset: ' . $mysqli->error);
    }

    return $mysqli;
}
