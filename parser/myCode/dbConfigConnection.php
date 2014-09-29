<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/24/14
 * Time: 4:55 PM
 */

$dbConfig = array(
    "connectionString" => "localhost",
    "username" => "root",
    "password" => "root",
    "db" => "parser"
);

/**
 * Create connection to DB
 *
 */
$dbLink = mysqli_connect(
    $dbConfig["connectionString"],
    $dbConfig["username"],
    $dbConfig["password"],
    $dbConfig["db"]

);

if (!$dbLink) {
    echo "Error MySql connection: " . mysqli_error($dbLink)."\n";
    exit;
}