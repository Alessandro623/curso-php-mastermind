<?php
    $host = "localhost";
    $dataBase = 'contacts_app';
    $user = 'root';
    $pass = '';

    try{
        $conn = new PDO("mysql:host=$host;dbname=$dataBase", $user, $pass);
    } catch (PDOException $e) {
        die("PDO Connection Error: " . $e -> getMessage());
    }
?>