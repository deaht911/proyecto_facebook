<?php
session_start();
include_once('./connect.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se ha recibido el ID de la publicación
if (isset($_GET['id'])) {
    $id_publicacion = $_GET['id'];

    try {
        // Verificar que la publicación pertenece al usuario actual
        $stmt = $pdo->prepare("DELETE FROM publicaciones WHERE id_publicacion = :id_publicacion AND id_usuario = :usuario_id");
        $stmt->execute(['id_publicacion' => $id_publicacion, 'usuario_id' => $_SESSION['usuario_id']]);

        // Redirigir al inicio después de la eliminación
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar la publicación: " . $e->getMessage();
    }
} else {
    echo "Publicación no encontrada.";
    exit();
}
?>
