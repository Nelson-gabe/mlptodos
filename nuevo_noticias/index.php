<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>News</title>
</head>
<body>
    <h1>Noticias</h1>
    <a href="crud.php">Administrar Noticias</a>
    <div class="news-container">
        <?php
        $sql = "SELECT * FROM news";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='news-item'>";
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
                echo "<img src='" . $row["image_url"] . "' alt='News Image'>";
                echo "</div>";
            }
        } else {
            echo "No hay noticias disponibles.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
