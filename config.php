<?php
/**
 * Temporary config file for developing purposes. To be changed.
 */

/* Global settings */
$url = "http://localhost/quoter";
/* Database connection */
$host = "localhost";
$username = "";
$password = "";
$port = 3306;
$database = "quoter";
try {
    // Everything here is temporary!
    $pdo = new PDO("mysql:host={$host};dbname={$database};port={$port};",
        $username, $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: noDbConnection.php");
    die();
}
