<?php
    $host = "localhost";
    $dataBase = 'contacts_app';
    $user = 'root';
    $pass = '';

    try{
        $conn = new PDO("mysql:host=$host;dbname=$dataBase", $user, $pass);
        // foreach ($conn->query("SHOW DATABASES") as $row) {
        //     print_r($row);
        // }
        // die();
    } catch (PDOException $e) {
        die("PDO Connection Error: " . $e -> getMessage());
    }
?>