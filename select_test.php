<?php
ini_set('display_errors', 1);
try {
    require('../../pdo_connect.php');
    $sql = 'SELECT * FROM JJ_images';
    $result = $dbc->query($sql);
    $numRows = $result->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Test</title>
</head>

<body>
    <?php
    echo "<p>A total of $numRows records were found.</p>";
    ?>
    <table>
        <tr>
            <th>Image ID</th>
            <th>Filename</th>
            <th>Caption</th>
        </tr>
        <?php
        // <?= below is a short cut for <?php echo
        foreach ($result as $row) { ?>
            <tr>
                <td><?= $row['image_id'] ?></td>
                <td><?= $row['filename'] ?></td>
                <td><?= $row['caption'] ?></td>
            </tr>
        <?php } ?> <!-- end foreach -->
    </table>
</body>

</html>