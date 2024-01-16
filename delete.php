<?php

try {
    $dbHandler = new PDO("mysql:host = mysql; dbname=bugreporter; charset=utf8", "root", "");
    if(isset($_GET['id'])){
        $stmt = $dbHandler->prepare("DELETE FROM bugs WHERE id=:id;");
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        header("location: index.php");
    } else {
        header("location: index.php");
    }
} catch (Exception $e) {
    print($e);
}


?>