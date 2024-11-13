<?php
session_start();
include_once('./connect.php');

// Verifica si la conexión fue exitosa
if (!$pdo) {
    die('No se pudo conectar a la base de datos.');
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Comprobamos que se haya enviado el comentario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comentario'])) {
    // Sanitizamos y validamos las entradas
    $comentario = trim($_POST['comentario']);
    $id_publicacion = $_POST['id_publicacion'];
    $id_usuario = $_SESSION['usuario_id'];  // Asumimos que tienes el id del usuario en la sesión

    // Validaciones
    if (empty($comentario)) {
        echo "El comentario no puede estar vacío.";
        exit();
    }

    if (!filter_var($id_publicacion, FILTER_VALIDATE_INT)) {
        echo "ID de publicación inválido.";
        exit();
    }

    // Preparamos la consulta SQL para insertar el comentario
    try {
        $stmt = $pdo->prepare("INSERT INTO comentarios (comentario, id_publicacion, id_usuario, fecha_comentario) 
                               VALUES (:comentario, :id_publicacion, :id_usuario, NOW())");

        // Ejecutamos la consulta
        $stmt->execute([
            ':comentario' => $comentario,
            ':id_publicacion' => $id_publicacion,
            ':id_usuario' => $id_usuario
        ]);

        // Redirigir a la página de la publicación después de agregar el comentario
        header("Location: index.php?id=$id_publicacion");
        exit();
    } catch (PDOException $e) {
        echo "Error al agregar comentario: " . $e->getMessage();
    }
} else {
    echo "No se enviaron datos válidos.";
}
?>
