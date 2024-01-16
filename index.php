<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Reporter</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php
    try {
        $dbHandler = new PDO("mysql:host = mysql; dbname=bugreporter; charset=utf8", "root", "");
    } catch (Exception $e) {
        print($e);
    }
    ?>
    <h1>Alle bugs</h1>

    <table>
        <thead>
            <th>Product</th>
            <th>Version</th>
            <th>Hardware</th>
            <th>OS</th>
            <th>Frequency</th>
            <th>Solution</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            <?php
            if ($dbHandler) {
                try {
                    $stmt = $dbHandler->prepare("SELECT * FROM bugs");
                    $stmt->execute();

                    if ($stmt) {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $row) {
                            echo "<tr>
                                <td>{$row['Product']}</td>
                                <td>{$row['Version']}</td>
                                <td>{$row['Hardware']}</td>
                                <td>{$row['OS']}</td>
                                <td>{$row['Frequency']}</td>
                                <td>{$row['Solution']}</td>
                                <td><a href=\"addbug.php?id={$row['id']}\">Edit</a></td>
                                <td><a href=\"delete.php?id={$row['id']}\">Delete</a></td>
                            </tr>";
                        }
                    } else {
                        throw new Exception;
                    }
                } catch (Exception $e) {
                    print($e);
                }
            }

            ?>
        </tbody>
    </table>
    <a href="addbug.php">Bug toevoegen</a>
</body>

</html>