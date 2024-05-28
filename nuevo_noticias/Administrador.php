<!DOCTYPE html>
<html lang="es" class="administrador">
<head>
    <meta charset="UTF-8">
    <title>Panel de Noticias</title>
    <link rel="stylesheet" href="Pagina.css">
</head>
<body class="administrador-body">
    <header class="administrador-header">
        <div class="administrador-contenedor-titulo">
            <h1>Panel de Administración de Noticias</h1>
        </div>
    </header>
    <nav>
        <a href="Index.html">Inicio</a>
        <a href="Sesion.html">Login</a>
    </nav>
    <div class="administrador-main">
        <h2>Subir Nueva Noticia</h2>
    </div>
    <div>
        <main class="administrador-main">
            <section id="add-news" class="administrador-seccion">
                <form id="news-form" method="post" enctype="multipart/form-data" class="administrador-formulario">
                    <div class="input-contenedor">
                        <label for="title">Título:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <label for="content">Contenido:</label>
                    <div class="input-contenedor">
                        <textarea id="content" name="content" required></textarea>
                    </div>
                    <label for="image">Imagen:</label>
                    <div class="input-contenedor">
                        <input type="file" id="image" name="image">
                    </div>
                    <button type="submit" class="ButtonLogin" name="submit">Subir Noticia</button>
                </form>
            </section>
            
            <section id="update-news" class="administrador-seccion">
                <h2>Actualizar Noticia</h2>
                <form id="update-news-form" method="post" enctype="multipart/form-data" class="administrador-formulario">
                    <div class="input-contenedor">
                        <label for="news-id">ID de la Noticia:</label>
                        <input type="text" id="news-id" name="news-id" required>
                    </div>
                    <div class="input-contenedor">
                        <label for="new-title">Nuevo Título:</label>
                        <input type="text" id="new-title" name="new-title" required>
                    </div>
                    <label for="new-content">Nuevo Contenido:</label>
                    <div class="input-contenedor">
                        <textarea id="new-content" name="new-content" required></textarea>
                    </div>
                    <label for="new-image">Nueva Imagen:</label>
                    <div class="input-contenedor">
                        <input type="file" id="new-image" name="new-image">
                    </div>
                    <button type="submit" class="ButtonLogin" name="update">Actualizar Noticia</button>
                </form>
            </section>

            <section id="news-list" class="administrador-seccion">
                <h2>Noticias Publicadas</h2>
                <div id="news-container" class="administrador-contenedor-noticias">
                    <!-- Aquí se insertarán las noticias publicadas -->
                    <?php
                    // Conexión a la base de datos
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "news_db";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Crear nueva noticia
                    if (isset($_POST['submit'])) {
                        $title = $_POST['title'];
                        $content = $_POST['content'];
                        $image = $_FILES['image']['name'];
                        $target = "images/" . basename($image);

                        $sql = "INSERT INTO noticias (title, content, image_url) VALUES ('$title', '$content', '$target')";
                        if (mysqli_query($conn, $sql) && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                            echo "Noticia subida exitosamente.";
                        } else {
                            echo "Error al subir la noticia.";
                        }
                    }

                    // Actualizar noticia
                    if (isset($_POST['update'])) {
                        $id = $_POST['news-id'];
                        $newTitle = $_POST['new-title'];
                        $newContent = $_POST['new-content'];
                        $newImage = $_FILES['new-image']['name'];
                        $newTarget = "images/" . basename($newImage);

                        $sql = "UPDATE noticias SET title='$newTitle', content='$newContent', image_url='$newTarget' WHERE id='$id'";
                        if (mysqli_query($conn, $sql) && move_uploaded_file($_FILES['new-image']['tmp_name'], $newTarget)) {
                            echo "Noticia actualizada exitosamente.";
                        } else {
                            echo "Error al actualizar la noticia.";
                        }
                    }

                    // Mostrar noticias
                    $sql = "SELECT id, title, content, image_url FROM news";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<article class="Padre-noticias">';
                            echo '<div>';
                            echo '<div><img src="' . $row["imagen"] . '" alt="Imagen de la noticia" /></div>';
                            echo '<div><h3>' . $row["titulo"] . '</h3></div>';
                            echo '<div><p>' . $row["contenido"] . '</p></div>';
                            echo '<div><form method="post" action=""><input type="hidden" name="delete-id" value="' . $row["id"] . '"><button type="submit" name="delete">Eliminar</button></form></div>';
                            echo '</div>';
                            echo '</article>';
                        }
                    } else {
                        echo "No hay noticias publicadas.";
                    }

                    // Eliminar noticia
                    if (isset($_POST['delete'])) {
                        $id = $_POST['delete-id'];
                        $sql = "DELETE FROM news WHERE id='$id'";
                        if (mysqli_query($conn, $sql)) {
                            echo "Noticia eliminada exitosamente.";
                        } else {
                            echo "Error al eliminar la noticia.";
                        }
                    }

                    $conn->close();
                    ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
