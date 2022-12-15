<?php
    require "database.php";
    $id = $_GET["id"];

    session_start();
    session_start();
    if (!isset($_SESSION["user"])) {
      header("Location: login.php");
      return;
    }
    
    $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
    $statement->bindParam(":id", $id);
    $statement->execute();

    if($statement->rowcount() == 0){
        http_response_code(404);
        echo ("HTTP 404 NOT FOUND");
        return;
    }

    $conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

    header("Location: home.php");
?>