<?php
session_start();
include_once('./connect.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se ha enviado el formulario para editar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_publicacion'], $_POST['contenido'])) {
    $id_publicacion = $_POST['id_publicacion'];
    $contenido = $_POST['contenido'];

    try {
        // Actualizar la publicación en la base de datos
        $stmt = $pdo->prepare("UPDATE publicaciones SET contenido = :contenido WHERE id_publicacion = :id_publicacion AND id_usuario = :usuario_id");
        $stmt->execute(['contenido' => $contenido, 'id_publicacion' => $id_publicacion, 'usuario_id' => $_SESSION['usuario_id']]);
        
        header('Location: index.php'); // Redirigir al inicio después de la edición
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la publicación: " . $e->getMessage();
    }
}

// Obtener la publicación actual
if (isset($_GET['id'])) {
    $id_publicacion = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE id_publicacion = :id_publicacion AND id_usuario = :usuario_id");
        $stmt->execute(['id_publicacion' => $id_publicacion, 'usuario_id' => $_SESSION['usuario_id']]);
        $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al cargar la publicación: " . $e->getMessage();
    }
}

if (!$publicacion) {
    echo "Publicación no encontrada o no tienes permiso para editarla.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Editar Publicación</h1>
    <form action="editar_publicacion.php" method="POST">
        <input type="hidden" name="id_publicacion" value="<?php echo htmlspecialchars($id_publicacion); ?>">
        <textarea name="contenido" rows="5" required><?php echo htmlspecialchars($publicacion['contenido']); ?></textarea>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="index.php">Cancelar</a>
</body>
</html>
