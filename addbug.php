<?php
$results = array();
try{
    $dbHandler = new PDO("mysql:host = mysql; dbname=bugreporter; charset=utf8", "root", "");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if($dbHandler && isset($_POST['product']) && isset($_POST['version']) && isset($_POST['hardware']) && isset($_POST['os']) && isset($_POST['frequency']) && isset($_POST['solution'])&& !empty($_POST['product']) && !empty($_POST['version']) && !empty($_POST['hardware']) && !empty($_POST['os']) && !empty($_POST['frequency']) && !empty($_POST['solution'])){
            if(isset($_GET['id'])){
                $stmt = $dbHandler->prepare("UPDATE bugs SET 
                Product=:product, 
                Version=:version, 
                Hardware=:hardware, 
                OS=:os, 
                Frequency=:freq, 
                Solution=:solutions 
                WHERE id=:id");
                $stmt->bindParam(":product",$_POST['product'], PDO::PARAM_STR);
                $stmt->bindParam(":version",$_POST['version'], PDO::PARAM_STR);
                $stmt->bindParam(":hardware",$_POST['hardware'], PDO::PARAM_STR);
                $stmt->bindParam(":os",$_POST['os'], PDO::PARAM_STR);
                $stmt->bindParam(":freq",$_POST['frequency'], PDO::PARAM_STR);
                $stmt->bindParam(":solutions",$_POST['solution'], PDO::PARAM_STR);
                $stmt->bindParam(":id",$_GET['id'], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $stmt = $dbHandler->prepare("INSERT INTO bugs (Product, Version, Hardware, OS, Frequency, Solution) VALUES (:product,:version,:hardware,:os,:freq,:solutions)");
                $stmt->bindParam(":product",$_POST['product'], PDO::PARAM_STR);
                $stmt->bindParam(":version",$_POST['version'], PDO::PARAM_STR);
                $stmt->bindParam(":hardware",$_POST['hardware'], PDO::PARAM_STR);
                $stmt->bindParam(":os",$_POST['os'], PDO::PARAM_STR);
                $stmt->bindParam(":freq",$_POST['frequency'], PDO::PARAM_STR);
                $stmt->bindParam(":solutions",$_POST['solution'], PDO::PARAM_STR);
                $stmt->execute();
            }
            header("location: index.php");

        } else {
            echo "Er is een fout opgetreden...";
        }
    } 
    if(isset($_GET['id'])){
        $stmt = $dbHandler->prepare("SELECT * FROM bugs WHERE id=:id LIMIT 1");
        $stmt->bindParam(":id",$_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $results = $results[0];
        }
    }
    
}
catch (Exception $e){
    die($e);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Reporter</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<h1>Bug toevoegen</h1>
<form action="<?php echo (isset($_GET['id']))?"?id={$_GET['id']}":"#";?>" method="post">
    <div>
        <label for="Product">Product:</label>
    </div>
    <div>
        <input name="product" type="text" id="Product" value="<?php echo (isset($_GET['id']))? $results['Product'] : "";?>">
    </div>
    <div>
        <label for="Version">Version:</label>
    </div>
    <div>
        <input name="version" type="text" id="Version"  value="<?php echo (isset($_GET['id']))? $results['Version'] : "";?>">
    </div>
    <div>
        <label for="Hardware">Hardware:</label>
    </div>
    <div>
        <input name="hardware" type="text" id="Hardware"  value="<?php echo (isset($_GET['id']))? $results['Hardware'] : "";?>">
    </div>
    <div>
        <label for="OS">Operation system:</label>
    </div>
    <div>
        <input name="os" type="text" id="OS"  value="<?php echo (isset($_GET['id']))? $results['OS'] : "";?>">
    </div>
    <div>
        <label for="FQ">Frequency:</label>
    </div>
    <div>
        <input name="frequency" type="text" id="FQ"  value="<?php echo (isset($_GET['id']))? $results['Frequency'] : "";?>">
    </div>
    <div>
        <label for="Solution">Solution:</label>
    </div>
    <div>
        <input name="solution" type="text" id="Solution"  value="<?php echo (isset($_GET['id']))? $results['Solution'] : "";?>">
    </div>
    <div>
        <input type="submit" value="<?php echo (isset($_GET['id']))?"Bewerking opslaan":"Bug toevoegen";?>">
    </div>
</form>
</body>
</html>